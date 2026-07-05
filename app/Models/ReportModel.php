<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table            = 'reports';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'category_id',
        'location_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority',
        'rejection_reason',
        'completed_note',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getReports()
    {
        return $this->select('
                reports.*,
                users.name as reporter_name,
                categories.name as category_name,
                locations.name as location_name,
                petugas.name as petugas_name,
                COUNT(report_votes.id) as total_votes
            ')
            ->join('users', 'users.id = reports.user_id')
            ->join('categories', 'categories.id = reports.category_id')
            ->join('locations', 'locations.id = reports.location_id', 'left')
            ->join('users as petugas', 'petugas.id = reports.assigned_to', 'left')
            ->join('report_votes', 'report_votes.report_id = reports.id', 'left')
            ->groupBy('reports.id')
            ->orderBy('reports.id', 'DESC')
            ->findAll();
    }

    public function getPublicReports()
    {
        return $this->select('
                reports.*,
                users.name as reporter_name,
                categories.name as category_name,
                locations.name as location_name,
                petugas.name as petugas_name,
                COUNT(report_votes.id) as total_votes
            ')
            ->join('users', 'users.id = reports.user_id')
            ->join('categories', 'categories.id = reports.category_id')
            ->join('locations', 'locations.id = reports.location_id', 'left')
            ->join('users as petugas', 'petugas.id = reports.assigned_to', 'left')
            ->join('report_votes', 'report_votes.report_id = reports.id', 'left')
            ->whereIn('reports.status', ['diverifikasi', 'diproses', 'selesai'])
            ->groupBy('reports.id')
            ->orderBy('reports.id', 'DESC')
            ->findAll();
    }

    public function getReportDetail($id)
    {
        return $this->select('
                reports.*,
                users.name as reporter_name,
                users.email as reporter_email,
                users.phone as reporter_phone,
                categories.name as category_name,
                locations.name as location_name,
                locations.address as location_address,
                petugas.name as petugas_name,
                COUNT(report_votes.id) as total_votes
            ')
            ->join('users', 'users.id = reports.user_id')
            ->join('categories', 'categories.id = reports.category_id')
            ->join('locations', 'locations.id = reports.location_id', 'left')
            ->join('users as petugas', 'petugas.id = reports.assigned_to', 'left')
            ->join('report_votes', 'report_votes.report_id = reports.id', 'left')
            ->where('reports.id', $id)
            ->groupBy('reports.id')
            ->first();
    }

    public function getReportsByUser($userId)
    {
        return $this->select('
                reports.*,
                categories.name as category_name,
                locations.name as location_name,
                COUNT(report_votes.id) as total_votes
            ')
            ->join('categories', 'categories.id = reports.category_id')
            ->join('locations', 'locations.id = reports.location_id', 'left')
            ->join('report_votes', 'report_votes.report_id = reports.id', 'left')
            ->where('reports.user_id', $userId)
            ->groupBy('reports.id')
            ->orderBy('reports.id', 'DESC')
            ->findAll();
    }

    public function getReportsByPetugas($petugasId)
    {
        return $this->select('
                reports.*,
                users.name as reporter_name,
                categories.name as category_name,
                locations.name as location_name,
                COUNT(report_votes.id) as total_votes
            ')
            ->join('users', 'users.id = reports.user_id')
            ->join('categories', 'categories.id = reports.category_id')
            ->join('locations', 'locations.id = reports.location_id', 'left')
            ->join('report_votes', 'report_votes.report_id = reports.id', 'left')
            ->where('reports.assigned_to', $petugasId)
            ->groupBy('reports.id')
            ->orderBy('reports.id', 'DESC')
            ->findAll();
    }

    public function countByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    /**
     * Jumlah lokasi/sekolah unik yang pernah punya laporan.
     */
    public function getActiveLocationsCount(): int
    {
        return $this->select('location_id')
            ->where('location_id IS NOT NULL')
            ->distinct()
            ->countAllResults();
    }

    /**
     * Jumlah laporan per hari untuk 7 hari terakhir.
     * Return array angka berurutan dari H-6 sampai hari ini.
     */
    public function getWeeklyTrend(): array
    {
        $result = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $count = $this->where("DATE(created_at) = '{$date}'")->countAllResults();
            $result[] = $count;
        }

        return $result;
    }

    /**
     * Breakdown jumlah laporan per kategori kerusakan.
     * Return array asosiatif: [['name' => 'Kelas', 'total' => 12], ...]
     */
    public function getCategoryBreakdown(): array
    {
        return $this->select('categories.name as name, COUNT(reports.id) as total')
            ->join('categories', 'categories.id = reports.category_id')
            ->groupBy('reports.category_id')
            ->orderBy('total', 'DESC')
            ->findAll();
    }

    /**
     * Daftar lokasi/sekolah dengan laporan terbanyak, lengkap dengan
     * persentase laporan yang sudah selesai.
     */
    public function getTopLocations(int $limit = 3): array
    {
        return $this->select('
                locations.name as name,
                COUNT(reports.id) as total,
                ROUND(SUM(CASE WHEN reports.status = "selesai" THEN 1 ELSE 0 END) / COUNT(reports.id) * 100) as percent
            ')
            ->join('locations', 'locations.id = reports.location_id')
            ->groupBy('reports.location_id')
            ->orderBy('total', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}