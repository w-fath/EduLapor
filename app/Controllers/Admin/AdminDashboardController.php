<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReportModel;
use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\LocationModel;

class AdminDashboardController extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $userModel = new UserModel();
        $categoryModel = new CategoryModel();
        $locationModel = new LocationModel();

        $data = [
            'title' => 'Dashboard Admin',
            'total_reports' => $reportModel->countAllResults(),
            'pending_reports' => $reportModel->where('status', 'menunggu_verifikasi')->countAllResults(),
            'verified_reports' => $reportModel->where('status', 'diverifikasi')->countAllResults(),
            'process_reports' => $reportModel->where('status', 'diproses')->countAllResults(),
            'completed_reports' => $reportModel->where('status', 'selesai')->countAllResults(),
            'rejected_reports' => $reportModel->where('status', 'ditolak')->countAllResults(),
            'total_users' => $userModel->countAllResults(),
            'total_categories' => $categoryModel->countAllResults(),
            'total_locations' => $locationModel->countAllResults(),
        ];

        return view('admin/dashboard', $data);
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