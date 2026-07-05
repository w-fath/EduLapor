<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\ReportModel;

class PetugasDashboardController extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requirePetugas()) {
            return $redirect;
        }

        $reportModel = new ReportModel();
        $petugasId = session()->get('user_id');

        $data = [
            'title' => 'Dashboard Petugas',
            'total_assigned' => $reportModel->where('assigned_to', $petugasId)->countAllResults(),
            'verified_reports' => $reportModel->where('assigned_to', $petugasId)->where('status', 'diverifikasi')->countAllResults(),
            'process_reports' => $reportModel->where('assigned_to', $petugasId)->where('status', 'diproses')->countAllResults(),
            'completed_reports' => $reportModel->where('assigned_to', $petugasId)->where('status', 'selesai')->countAllResults(),
        ];

        return view('petugas/dashboard', $data);
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