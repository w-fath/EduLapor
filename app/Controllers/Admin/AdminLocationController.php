<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LocationModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminLocationController extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $locationModel = new LocationModel();

        $data = [
            'title' => 'Kelola Lokasi',
            'locations' => $locationModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('admin/locations/index', $data);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/locations/create', [
            'title' => 'Tambah Lokasi',
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
            'address' => 'permit_empty',
            'latitude' => 'permit_empty|max_length[50]',
            'longitude' => 'permit_empty|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $locationModel = new LocationModel();

        $locationModel->insert([
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
        ]);

        return redirect()->to('/admin/locations')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $locationModel = new LocationModel();
        $location = $locationModel->find($id);

        if (! $location) {
            throw PageNotFoundException::forPageNotFound('Lokasi tidak ditemukan.');
        }

        return view('admin/locations/edit', [
            'title' => 'Edit Lokasi',
            'location' => $location,
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
            'address' => 'permit_empty',
            'latitude' => 'permit_empty|max_length[50]',
            'longitude' => 'permit_empty|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $locationModel = new LocationModel();

        $locationModel->update($id, [
            'name' => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
        ]);

        return redirect()->to('/admin/locations')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $locationModel = new LocationModel();
        $locationModel->delete($id);

        return redirect()->to('/admin/locations')->with('success', 'Lokasi berhasil dihapus.');
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