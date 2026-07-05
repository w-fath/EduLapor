<?= $this->extend('layouts/petugas') ?>

<?= $this->section('content') ?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Tugas</h3>
        <div class="number"><?= esc($total_assigned ?? 0) ?></div>
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
</div>

<div class="panel">
    <h2>Dashboard Petugas</h2>
    <p>
        Petugas bertugas menangani laporan yang sudah diverifikasi dan ditugaskan oleh admin.
        Petugas dapat mengubah status laporan menjadi diproses atau selesai.
    </p>

    <div class="quick-actions">
        <a href="<?= base_url('/petugas/reports') ?>" class="btn">Lihat Laporan Ditugaskan</a>
    </div>
</div>

<?= $this->endSection() ?>