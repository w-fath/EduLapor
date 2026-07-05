<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportVoteModel extends Model
{
    protected $table            = 'report_votes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $protectFields    = true;
    protected $allowedFields    = [
        'report_id',
        'user_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function hasVoted($reportId, $userId)
    {
        return $this->where('report_id', $reportId)
            ->where('user_id', $userId)
            ->first();
    }

    public function countVotes($reportId)
    {
        return $this->where('report_id', $reportId)->countAllResults();
    }

    public function toggleVote($reportId, $userId)
    {
        $existingVote = $this->hasVoted($reportId, $userId);

        if ($existingVote) {
            $this->delete($existingVote['id']);
            return 'removed';
        }

        $this->insert([
            'report_id' => $reportId,
            'user_id'   => $userId,
        ]);

        return 'added';
    }
}