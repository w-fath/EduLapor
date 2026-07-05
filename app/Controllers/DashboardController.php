<?php

namespace App\Controllers;

use App\Models\ReportModel;

class DashboardController extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (session()->get('role_name') === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        if (session()->get('role_name') === 'petugas') {
            return redirect()->to('/petugas/dashboard');
        }

        $reportModel = new ReportModel();
        $userId = session()->get('user_id');

        $data = [
            'title' => 'Dashboard',
            'total_reports' => $reportModel->where('user_id', $userId)->countAllResults(),
            'pending_reports' => $reportModel->where('user_id', $userId)->where('status', 'menunggu_verifikasi')->countAllResults(),
            'process_reports' => $reportModel->where('user_id', $userId)->where('status', 'diproses')->countAllResults(),
            'completed_reports' => $reportModel->where('user_id', $userId)->where('status', 'selesai')->countAllResults(),
        ];

        return view('user/dashboard', $data);
    }
}