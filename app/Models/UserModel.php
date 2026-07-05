<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $protectFields    = true;
    protected $allowedFields    = [
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'address',
        'status',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUsersWithRole()
    {
        return $this->select('users.*, roles.name as role_name, roles.label as role_label')
            ->join('roles', 'roles.id = users.role_id')
            ->orderBy('users.id', 'DESC')
            ->findAll();
    }

    public function getUserWithRole($id)
    {
        return $this->select('users.*, roles.name as role_name, roles.label as role_label')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.id', $id)
            ->first();
    }

    public function getByEmail($email)
    {
        return $this->select('users.*, roles.name as role_name, roles.label as role_label')
            ->join('roles', 'roles.id = users.role_id')
            ->where('users.email', $email)
            ->first();
    }

    public function getPetugas()
    {
        return $this->select('users.*')
            ->join('roles', 'roles.id = users.role_id')
            ->where('roles.name', 'petugas')
            ->where('users.status', 'active')
            ->orderBy('users.name', 'ASC')
            ->findAll();
    }

    public function getPelapor()
    {
        return $this->select('users.*')
            ->join('roles', 'roles.id = users.role_id')
            ->where('roles.name', 'pelapor')
            ->orderBy('users.name', 'ASC')
            ->findAll();
    }
}