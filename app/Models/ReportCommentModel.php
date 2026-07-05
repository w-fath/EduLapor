<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportCommentModel extends Model
{
    protected $table            = 'report_comments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $protectFields    = true;
    protected $allowedFields    = [
        'report_id',
        'user_id',
        'comment',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getCommentsByReport($reportId)
    {
        return $this->select('
                report_comments.*,
                users.name as user_name,
                roles.name as role_name,
                roles.label as role_label
            ')
            ->join('users', 'users.id = report_comments.user_id')
            ->join('roles', 'roles.id = users.role_id')
            ->where('report_comments.report_id', $reportId)
            ->orderBy('report_comments.id', 'ASC')
            ->findAll();
    }
}