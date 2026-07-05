<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\CategoryModel;
use App\Models\LocationModel;

class Home extends BaseController
{
    public function index()
    {
        $reportModel = new ReportModel();

        $data = [
            'title' => 'Beranda',
            'total_reports' => $reportModel->countAllResults(),
            'completed_reports' => $reportModel->where('status', 'selesai')->countAllResults(),
            'process_reports' => $reportModel->where('status', 'diproses')->countAllResults(),
            'public_reports' => $reportModel->getPublicReports(),
        ];

        return view('public/home', $data);
    }

    public function about()
    {
        $reportModel = new ReportModel();
        $categoryModel = new CategoryModel();
        $locationModel = new LocationModel();

        $data = [
            'title' => 'Tentang',
            'total_reports' => $reportModel->countAllResults(),
            'total_categories' => $categoryModel->countAllResults(),
            'total_locations' => $locationModel->countAllResults(),
            'completed_reports' => $reportModel->where('status', 'selesai')->countAllResults(),
        ];

        return view('public/about', $data);
    }

    public function statistik()
    {
        $reportModel = new ReportModel();

        $categoryData = $reportModel->getCategoryBreakdown();

        $data = [
            'title' => 'Statistik',

            // Stat cards
            'total_reports'     => $reportModel->countAllResults(),
            'completed_reports' => $reportModel->where('status', 'selesai')->countAllResults(),
            'process_reports'   => $reportModel->where('status', 'diproses')->countAllResults(),
            'active_schools'    => $reportModel->getActiveLocationsCount(),

            // Chart: tren laporan 7 hari terakhir
            'trend_labels' => $this->getTrendLabels(),
            'trend_data'   => $reportModel->getWeeklyTrend(),

            // Chart: kategori kerusakan (donut)
            'category_labels' => array_column($categoryData, 'name'),
            'category_data'   => array_column($categoryData, 'total'),

            // Tabel: sekolah dengan laporan terbanyak
            'top_schools' => $reportModel->getTopLocations(),
        ];

        return view('public/statistik', $data);
    }

    public function lacak()
    {
        return view('public/lacak', [
            'title' => 'Lacak Laporan',
            'report' => null,
            'keyword' => null,
        ]);
    }

    public function prosesLacak()
    {
        $keyword = trim($this->request->getPost('keyword'));

        if (! $keyword) {
            return redirect()->back()->with('error', 'Masukkan kode atau ID laporan.');
        }

        $reportId = preg_replace('/[^0-9]/', '', $keyword);

        if (! $reportId) {
            return redirect()->back()->with('error', 'Format kode laporan tidak valid.');
        }

        $reportModel = new ReportModel();
        $report = $reportModel->getReportDetail((int) $reportId);

        return view('public/lacak', [
            'title' => 'Lacak Laporan',
            'report' => $report,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Helper: label hari untuk 7 hari terakhir, urut dari H-6 ke hari ini.
     */
    private function getTrendLabels(): array
    {
        $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $labels[] = $days[date('w', strtotime("-$i days"))];
        }

        return $labels;
    }
}