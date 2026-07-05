<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\ReportModel;
use App\Models\ReportPhotoModel;
use App\Models\ReportCommentModel;
use App\Models\ReportStatusHistoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PetugasReportController extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requirePetugas()) {
            return $redirect;
        }

        $reportModel = new ReportModel();

        $data = [
            'title' => 'Laporan Ditugaskan',
            'reports' => $reportModel->getReportsByPetugas(session()->get('user_id')),
        ];

        return view('petugas/reports/index', $data);
    }

    public function show($id)
    {
        if ($redirect = $this->requirePetugas()) {
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

        if ($report['assigned_to'] != session()->get('user_id')) {
            return redirect()->to('/petugas/reports')->with('error', 'Laporan ini bukan tugas kamu.');
        }

        $data = [
            'title' => 'Detail Laporan',
            'report' => $report,
            'photos' => $photoModel->getPhotosByReport($id),
            'comments' => $commentModel->getCommentsByReport($id),
            'histories' => $historyModel->getHistoriesByReport($id),
        ];

        return view('petugas/reports/show', $data);
    }

    public function process($id)
    {
        if ($redirect = $this->requirePetugas()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $historyModel = new ReportStatusHistoryModel();

        $report = $reportModel->find($id);

        if (! $report) {
            throw PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        if ($report['assigned_to'] != session()->get('user_id')) {
            return redirect()->to('/petugas/reports')->with('error', 'Laporan ini bukan tugas kamu.');
        }

        $oldStatus = $report['status'];

        $reportModel->update($id, [
            'status' => 'diproses',
        ]);

        $historyModel->insert([
            'report_id' => $id,
            'user_id' => session()->get('user_id'),
            'old_status' => $oldStatus,
            'new_status' => 'diproses',
            'note' => 'Laporan mulai diproses oleh petugas.',
        ]);

        return redirect()->to('/petugas/reports/' . $id)
            ->with('success', 'Status laporan berhasil diubah menjadi diproses.');
    }

    public function complete($id)
    {
        if ($redirect = $this->requirePetugas()) {
            return $redirect;
        }

        $rules = [
            'completed_note' => 'required|min_length[5]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $reportModel = new ReportModel();
        $historyModel = new ReportStatusHistoryModel();

        $report = $reportModel->find($id);

        if (! $report) {
            throw PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        if ($report['assigned_to'] != session()->get('user_id')) {
            return redirect()->to('/petugas/reports')->with('error', 'Laporan ini bukan tugas kamu.');
        }

        $oldStatus = $report['status'];

        $reportModel->update($id, [
            'status' => 'selesai',
            'completed_note' => $this->request->getPost('completed_note'),
        ]);

        $historyModel->insert([
            'report_id' => $id,
            'user_id' => session()->get('user_id'),
            'old_status' => $oldStatus,
            'new_status' => 'selesai',
            'note' => $this->request->getPost('completed_note'),
        ]);

        return redirect()->to('/petugas/reports/' . $id)
            ->with('success', 'Laporan berhasil diselesaikan.');
    }

    public function comment($id)
    {
        if ($redirect = $this->requirePetugas()) {
            return $redirect;
        }

        $rules = [
            'comment' => 'required|min_length[3]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $commentModel = new ReportCommentModel();

        $commentModel->insert([
            'report_id' => $id,
            'user_id' => session()->get('user_id'),
            'comment' => $this->request->getPost('comment'),
        ]);

        return redirect()->to('/petugas/reports/' . $id)
            ->with('success', 'Komentar berhasil ditambahkan.');
    }

    private function requirePetugas()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (session()->get('role_name') !== 'petugas') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        return null;
    }
}