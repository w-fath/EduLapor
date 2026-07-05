<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Laporan</h3>
        <div class="number"><?= esc($total_reports ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <h3>Menunggu</h3>
        <div class="number"><?= esc($pending_reports ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <h3>Diverifikasi</h3>
        <div class="number"><?= esc($verified_reports ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <h3>Diproses</h3>
        <div class="number"><?= esc($process_reports ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <h3>Selesai</h3>
        <div class="number"><?= esc($completed_reports ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <h3>Ditolak</h3>
        <div class="number"><?= esc($rejected_reports ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <h3>Total User</h3>
        <div class="number"><?= esc($total_users ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <h3>Kategori</h3>
        <div class="number"><?= esc($total_categories ?? 0) ?></div>
    </div>
</div>

<div class="panel">
    <h2>Dashboard Admin</h2>
    <p>
        Admin bertugas memverifikasi laporan yang masuk, menolak laporan yang tidak valid,
        menugaskan petugas, serta mengelola kategori, lokasi, dan user.
    </p>

    <div class="quick-actions">
        <a href="<?= base_url('/admin/reports') ?>" class="btn">Kelola Laporan</a>
        <a href="<?= base_url('/admin/categories') ?>" class="btn btn-secondary">Kelola Kategori</a>
        <a href="<?= base_url('/admin/locations') ?>" class="btn btn-secondary">Kelola Lokasi</a>
        <a href="<?= base_url('/admin/users') ?>" class="btn btn-secondary">Kelola User</a>
    </div>
</div>

<?= $this->endSection() ?>