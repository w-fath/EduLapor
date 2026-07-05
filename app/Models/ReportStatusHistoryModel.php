<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportStatusHistoryModel extends Model
{
    protected $table            = 'report_status_histories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $protectFields    = true;
    protected $allowedFields    = [
        'report_id',
        'user_id',
        'old_status',
        'new_status',
        'note',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getHistoriesByReport($reportId)
    {
        return $this->select('
                report_status_histories.*,
                users.name as user_name,
                roles.name as role_name,
                roles.label as role_label
            ')
            ->join('users', 'users.id = report_status_histories.user_id')
            ->join('roles', 'roles.id = users.role_id')
            ->where('report_status_histories.report_id', $reportId)
            ->orderBy('report_status_histories.id', 'ASC')
            ->findAll();
    }
}