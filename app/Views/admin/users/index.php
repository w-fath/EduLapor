<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php
$statusLabels = [
    'active' => 'Aktif',
    'inactive' => 'Tidak Aktif',
];

$statusClasses = [
    'active' => 'badge-done',
    'inactive' => 'badge-rejected',
];
?>

<div class="page-header">
    <h2>Kelola User</h2>
    <a href="<?= base_url('/admin/users/create') ?>" class="btn">Tambah User</a>
</div>

<div class="panel">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (! empty($users)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                <strong><?= esc($user['name']) ?></strong><br>
                                <small>
                                    Dibuat: 
                                    <?= ! empty($user['created_at']) ? esc(date('d M Y H:i', strtotime($user['created_at']))) : '-' ?>
                                </small>
                            </td>

                            <td><?= esc($user['email']) ?></td>

                            <td><?= esc($user['phone'] ?? '-') ?></td>

                            <td>
                                <span class="badge badge-verified">
                                    <?= esc($user['role_label'] ?? $user['role_name'] ?? '-') ?>
                                </span>
                            </td>

                            <td>
                                <span class="badge <?= esc($statusClasses[$user['status']] ?? 'badge-low') ?>">
                                    <?= esc($statusLabels[$user['status']] ?? $user['status']) ?>
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="<?= base_url('/admin/users/' . $user['id'] . '/edit') ?>" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <?php if ($user['id'] != session()->get('user_id')) : ?>
                                        <form action="<?= base_url('/admin/users/' . $user['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                Belum ada data user.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>