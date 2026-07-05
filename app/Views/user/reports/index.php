<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$statusLabels = [
    'menunggu_verifikasi' => 'Menunggu Verifikasi',
    'diverifikasi' => 'Diverifikasi',
    'ditolak' => 'Ditolak',
    'diproses' => 'Diproses',
    'selesai' => 'Selesai',
];

$statusClasses = [
    'menunggu_verifikasi' => 'badge-pending',
    'diverifikasi' => 'badge-verified',
    'ditolak' => 'badge-rejected',
    'diproses' => 'badge-process',
    'selesai' => 'badge-done',
];

$priorityClasses = [
    'rendah' => 'badge-low',
    'sedang' => 'badge-medium',
    'tinggi' => 'badge-high',
];
?>

<div class="page-header">
    <h2>Laporan Saya</h2>
    <a href="<?= base_url('/laporan/create') ?>" class="btn">Buat Laporan</a>
</div>

<div class="panel">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Vote</th>
                    <th width="210">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (! empty($reports)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($reports as $report) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= esc($report['title']) ?></strong><br>
                                <small><?= esc(date('d M Y H:i', strtotime($report['created_at']))) ?></small>
                            </td>
                            <td><?= esc($report['category_name'] ?? '-') ?></td>
                            <td><?= esc($report['location_name'] ?? '-') ?></td>
                            <td>
                                <span class="badge <?= esc($priorityClasses[$report['priority']] ?? 'badge-medium') ?>">
                                    <?= esc(ucfirst($report['priority'])) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= esc($statusClasses[$report['status']] ?? 'badge-pending') ?>">
                                    <?= esc($statusLabels[$report['status']] ?? $report['status']) ?>
                                </span>
                            </td>
                            <td><?= esc($report['total_votes'] ?? 0) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= base_url('/laporan/' . $report['id']) ?>" class="btn btn-sm">
                                        Detail
                                    </a>

                                    <?php if (in_array($report['status'], ['menunggu_verifikasi', 'ditolak'])) : ?>
                                        <a href="<?= base_url('/laporan/' . $report['id'] . '/edit') ?>" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="<?= base_url('/laporan/' . $report['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                Belum ada laporan. Silakan buat laporan pengaduan fasilitas terlebih dahulu.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>