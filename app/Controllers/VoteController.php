<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\ReportVoteModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class VoteController extends BaseController
{
    public function toggle($reportId)
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $reportModel = new ReportModel();
        $voteModel = new ReportVoteModel();

        $report = $reportModel->find($reportId);

        if (! $report) {
            throw PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        if (! in_array($report['status'], ['diverifikasi', 'diproses', 'selesai'])) {
            return redirect()->back()->with('error', 'Laporan ini belum bisa didukung.');
        }

        $result = $voteModel->toggleVote($reportId, session()->get('user_id'));

        if ($result === 'added') {
            return redirect()->back()->with('success', 'Dukungan berhasil ditambahkan.');
        }

        return redirect()->back()->with('success', 'Dukungan berhasil dibatalkan.');
    }
}