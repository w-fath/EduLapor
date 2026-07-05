<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminUserController extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $userModel = new UserModel();

        $data = [
            'title' => 'Kelola User',
            'users' => $userModel->getUsersWithRole(),
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $roleModel = new RoleModel();

        return view('admin/users/create', [
            'title' => 'Tambah User',
            'roles' => $roleModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'role_id' => 'required|numeric',
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'phone' => 'permit_empty',
            'address' => 'permit_empty',
            'status' => 'required|in_list[active,inactive]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $userModel->insert([
            'role_id' => $this->request->getPost('role_id'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $userModel = new UserModel();
        $roleModel = new RoleModel();

        $user = $userModel->find($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound('User tidak ditemukan.');
        }

        return view('admin/users/edit', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $roleModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'role_id' => 'required|numeric',
            'name' => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'phone' => 'permit_empty',
            'address' => 'permit_empty',
            'status' => 'required|in_list[active,inactive]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $data = [
            'role_id' => $this->request->getPost('role_id'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'status' => $this->request->getPost('status'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        if ($id == session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Akun yang sedang login tidak bisa dihapus.');
        }

        $userModel = new UserModel();
        $userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus.');
    }

    private function requireAdmin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (session()->get('role_name') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        return null;
    }
}