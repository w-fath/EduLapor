<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportPhotoModel extends Model
{
    protected $table            = 'report_photos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $protectFields    = true;
    protected $allowedFields    = [
        'report_id',
        'photo',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPhotosByReport($reportId)
    {
        return $this->where('report_id', $reportId)
            ->orderBy('id', 'ASC')
            ->findAll();
    }
}