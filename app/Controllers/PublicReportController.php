<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\ReportPhotoModel;
use App\Models\ReportCommentModel;
use App\Models\ReportStatusHistoryModel;
use App\Models\ReportVoteModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PublicReportController extends BaseController
{
    public function index()
    {
        $reportModel = new ReportModel();

        $data = [
            'title' => 'Laporan Publik',
            'reports' => $reportModel->getPublicReports(),
        ];

        return view('public/reports/index', $data);
    }

    public function show($id)
    {
        $reportModel = new ReportModel();
        $photoModel = new ReportPhotoModel();
        $commentModel = new ReportCommentModel();
        $historyModel = new ReportStatusHistoryModel();
        $voteModel = new ReportVoteModel();

        $report = $reportModel->getReportDetail($id);

        if (! $report) {
            throw PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        if (! in_array($report['status'], ['diverifikasi', 'diproses', 'selesai'])) {
            throw PageNotFoundException::forPageNotFound('Laporan belum tersedia untuk publik.');
        }

        $hasVoted = false;

        if (session()->get('isLoggedIn')) {
            $hasVoted = $voteModel->hasVoted($id, session()->get('user_id')) ? true : false;
        }

        $data = [
            'title' => 'Detail Laporan Publik',
            'report' => $report,
            'photos' => $photoModel->getPhotosByReport($id),
            'comments' => $commentModel->getCommentsByReport($id),
            'histories' => $historyModel->getHistoriesByReport($id),
            'hasVoted' => $hasVoted,
        ];

        return view('public/reports/show', $data);
    }
    
}