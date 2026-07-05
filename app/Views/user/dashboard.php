<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Laporan</h3>
        <div class="number"><?= esc($total_reports ?? 0) ?></div>
    </div>

    <div class="stat-card">
        <h3>Menunggu Verifikasi</h3>
        <div class="number"><?= esc($pending_reports ?? 0) ?></div>
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
    <h2>Selamat Datang, <?= esc(session()->get('name')) ?></h2>
    <p>
        Melalui sistem ini, kamu dapat membuat laporan pengaduan fasilitas pendidikan,
        melihat perkembangan status laporan, dan ikut mendukung laporan pengguna lain.
    </p>

    <div class="quick-actions">
        <a href="<?= base_url('/laporan/create') ?>" class="btn">Buat Laporan</a>
        <a href="<?= base_url('/laporan') ?>" class="btn btn-secondary">Lihat Laporan Saya</a>
        <a href="<?= base_url('/laporan-publik') ?>" class="btn btn-success">Lihat Laporan Publik</a>
    </div>
</div>

<?= $this->endSection() ?>