<?= $this->extend('layouts/petugas') ?>

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
    <h2>Laporan Ditugaskan</h2>
</div>

<div class="panel">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Judul Laporan</th>
                    <th>Pelapor</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Vote</th>
                    <th width="120">Aksi</th>
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
                                <small>
                                    <?= esc(date('d M Y H:i', strtotime($report['created_at']))) ?>
                                </small>
                            </td>

                            <td><?= esc($report['reporter_name'] ?? '-') ?></td>

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
                                <a href="<?= base_url('/petugas/reports/' . $report['id']) ?>" class="btn btn-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                Belum ada laporan yang ditugaskan kepada kamu.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>