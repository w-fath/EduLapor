<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\CategoryModel;
use App\Models\LocationModel;
use App\Models\ReportPhotoModel;
use App\Models\ReportCommentModel;
use App\Models\ReportStatusHistoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ReportController extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();

        $data = [
            'title' => 'Laporan Saya',
            'reports' => $reportModel->getReportsByUser(session()->get('user_id')),
        ];

        return view('user/reports/index', $data);
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $categoryModel = new CategoryModel();
        $locationModel = new LocationModel();

        $data = [
            'title' => 'Buat Laporan',
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll(),
            'locations' => $locationModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('user/reports/create', $data);
    }

    public function store()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'category_id' => 'required|numeric',
            'location_id' => 'permit_empty|numeric',
            'title' => 'required|min_length[5]|max_length[150]',
            'description' => 'required|min_length[10]',
            'priority' => 'required|in_list[rendah,sedang,tinggi]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('photo');

        if ($file && $file->isValid()) {
            $fileRules = [
                'photo' => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/webp]',
            ];

            if (! $this->validate($fileRules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }
        }

        $reportModel = new ReportModel();
        $historyModel = new ReportStatusHistoryModel();
        $photoModel = new ReportPhotoModel();

        $reportId = $reportModel->insert([
            'user_id' => session()->get('user_id'),
            'category_id' => $this->request->getPost('category_id'),
            'location_id' => $this->request->getPost('location_id') ?: null,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => 'menunggu_verifikasi',
        ], true);

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/reports/';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $photoModel->insert([
                'report_id' => $reportId,
                'photo' => $newName,
            ]);
        }

        $historyModel->insert([
            'report_id' => $reportId,
            'user_id' => session()->get('user_id'),
            'old_status' => null,
            'new_status' => 'menunggu_verifikasi',
            'note' => 'Laporan dibuat oleh pelapor.',
        ]);

        return redirect()->to('/laporan')
            ->with('success', 'Laporan berhasil dikirim dan menunggu verifikasi admin.');
    }

    public function show($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $photoModel = new ReportPhotoModel();
        $commentModel = new ReportCommentModel();
        $historyModel = new ReportStatusHistoryModel();

        $report = $reportModel->getReportDetail($id);

        if (! $report) {
            throw PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Laporan',
            'report' => $report,
            'photos' => $photoModel->getPhotosByReport($id),
            'comments' => $commentModel->getCommentsByReport($id),
            'histories' => $historyModel->getHistoriesByReport($id),
        ];

        return view('user/reports/show', $data);
    }

    public function edit($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $categoryModel = new CategoryModel();
        $locationModel = new LocationModel();

        $report = $reportModel->find($id);

        if (! $report) {
            throw PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        if ($report['user_id'] != session()->get('user_id')) {
            return redirect()->to('/laporan')->with('error', 'Kamu tidak memiliki akses ke laporan ini.');
        }

        if (! in_array($report['status'], ['menunggu_verifikasi', 'ditolak'])) {
            return redirect()->to('/laporan')->with('error', 'Laporan yang sudah diproses tidak bisa diedit.');
        }

        $data = [
            'title' => 'Edit Laporan',
            'report' => $report,
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll(),
            'locations' => $locationModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('user/reports/edit', $data);
    }

    public function update($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $historyModel = new ReportStatusHistoryModel();
        $photoModel = new ReportPhotoModel();

        $report = $reportModel->find($id);

        if (! $report) {
            throw PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        if ($report['user_id'] != session()->get('user_id')) {
            return redirect()->to('/laporan')->with('error', 'Kamu tidak memiliki akses ke laporan ini.');
        }

        if (! in_array($report['status'], ['menunggu_verifikasi', 'ditolak'])) {
            return redirect()->to('/laporan')->with('error', 'Laporan yang sudah diproses tidak bisa diedit.');
        }

        $rules = [
            'category_id' => 'required|numeric',
            'location_id' => 'permit_empty|numeric',
            'title' => 'required|min_length[5]|max_length[150]',
            'description' => 'required|min_length[10]',
            'priority' => 'required|in_list[rendah,sedang,tinggi]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $oldStatus = $report['status'];

        $reportModel->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'location_id' => $this->request->getPost('location_id') ?: null,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => 'menunggu_verifikasi',
            'rejection_reason' => null,
        ]);

        $file = $this->request->getFile('photo');

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $fileRules = [
                'photo' => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/webp]',
            ];

            if (! $this->validate($fileRules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            $uploadPath = FCPATH . 'uploads/reports/';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $photoModel->insert([
                'report_id' => $id,
                'photo' => $newName,
            ]);
        }

        $historyModel->insert([
            'report_id' => $id,
            'user_id' => session()->get('user_id'),
            'old_status' => $oldStatus,
            'new_status' => 'menunggu_verifikasi',
            'note' => 'Laporan diperbarui oleh pelapor.',
        ]);

        return redirect()->to('/laporan/' . $id)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $report = $reportModel->find($id);

        if (! $report) {
            throw PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        if ($report['user_id'] != session()->get('user_id')) {
            return redirect()->to('/laporan')->with('error', 'Kamu tidak memiliki akses ke laporan ini.');
        }

        if (! in_array($report['status'], ['menunggu_verifikasi', 'ditolak'])) {
            return redirect()->to('/laporan')->with('error', 'Laporan yang sudah diproses tidak bisa dihapus.');
        }

        $reportModel->delete($id);

        return redirect()->to('/laporan')->with('success', 'Laporan berhasil dihapus.');
    }

    private function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return null;
    }
}