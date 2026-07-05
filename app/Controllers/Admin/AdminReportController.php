<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReportModel;
use App\Models\UserModel;
use App\Models\ReportPhotoModel;
use App\Models\ReportCommentModel;
use App\Models\ReportStatusHistoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminReportController extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();

        $data = [
            'title' => 'Kelola Laporan',
            'reports' => $reportModel->getReports(),
        ];

        return view('admin/reports/index', $data);
    }

    public function show($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $photoModel = new ReportPhotoModel();
        $commentModel = new ReportCommentModel();
        $historyModel = new ReportStatusHistoryModel();
        $userModel = new UserModel();

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
            'petugas' => $userModel->getPetugas(),
        ];

        return view('admin/reports/show', $data);
    }

    public function verify($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $historyModel = new ReportStatusHistoryModel();

        $report = $reportModel->find($id);

        if (! $report) {
            throw PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        $oldStatus = $report['status'];

        $reportModel->update($id, [
            'status' => 'diverifikasi',
            'rejection_reason' => null,
        ]);

        $historyModel->insert([
            'report_id' => $id,
            'user_id' => session()->get('user_id'),
            'old_status' => $oldStatus,
            'new_status' => 'diverifikasi',
            'note' => 'Laporan diverifikasi oleh admin.',
        ]);

        return redirect()->to('/admin/reports/' . $id)
            ->with('success', 'Laporan berhasil diverifikasi.');
    }

    public function reject($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'rejection_reason' => 'required|min_length[5]',
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

        $oldStatus = $report['status'];

        $reportModel->update($id, [
            'status' => 'ditolak',
            'rejection_reason' => $this->request->getPost('rejection_reason'),
        ]);

        $historyModel->insert([
            'report_id' => $id,
            'user_id' => session()->get('user_id'),
            'old_status' => $oldStatus,
            'new_status' => 'ditolak',
            'note' => $this->request->getPost('rejection_reason'),
        ]);

        return redirect()->to('/admin/reports/' . $id)
            ->with('success', 'Laporan berhasil ditolak.');
    }

    public function assign($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'assigned_to' => 'required|numeric',
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

        $oldStatus = $report['status'];
        $newStatus = $oldStatus;

        if ($oldStatus === 'menunggu_verifikasi') {
            $newStatus = 'diverifikasi';
        }

        $reportModel->update($id, [
            'assigned_to' => $this->request->getPost('assigned_to'),
            'status' => $newStatus,
        ]);

        $historyModel->insert([
            'report_id' => $id,
            'user_id' => session()->get('user_id'),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'note' => 'Laporan ditugaskan kepada petugas.',
        ]);

        return redirect()->to('/admin/reports/' . $id)
            ->with('success', 'Laporan berhasil ditugaskan ke petugas.');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $reportModel->delete($id);

        return redirect()->to('/admin/reports')->with('success', 'Laporan berhasil dihapus.');
    }

    private function requireAdmin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (session()->get('role_name') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        return null;
    }
}