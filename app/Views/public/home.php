<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<section class="hero">
    <h1>Proses cepat, transparan, dan mudah dipantau.</h1>
    <p>
        Platform crowdsourcing untuk melaporkan kerusakan fasilitas pendidikan
        di sekolah atau kampus secara mudah, terbuka, dan terstruktur.
    </p>

    <div class="hero-actions">
        <?php if (session()->get('isLoggedIn')) : ?>
            <a href="<?= base_url('/laporan/create') ?>" class="btn">Buat Laporan Sekarang</a>
        <?php else : ?>
            <a href="<?= base_url('/login') ?>" class="btn">Buat Laporan Sekarang</a>
        <?php endif; ?>

        <a href="<?= base_url('/lacak-laporan') ?>" class="btn btn-outline">Lacak Laporan</a>
    </div>

    <div class="stats-row">
        <div class="stat-mini">
            <strong><?= esc($total_reports ?? 0) ?>+</strong>
            <span>Laporan Masuk</span>
        </div>

        <div class="stat-mini">
            <strong><?= esc($completed_reports ?? 0) ?>+</strong>
            <span>Laporan Selesai</span>
        </div>

        <div class="stat-mini">
            <strong>98%</strong>
            <span>Transparansi Proses</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-header">
        <span>Cara Kerja</span>
        <h2>Cara Kerja EduLapor</h2>
        <p>Tiga langkah mudah untuk memastikan fasilitas sekolah atau kampus kembali berfungsi dengan baik.</p>
    </div>

    <div class="steps">
        <div class="step-card">
            <div class="step-number">1</div>
            <h3>Tulis Laporan</h3>
            <p>Laporkan fasilitas yang rusak, pilih kategori, lokasi, dan tambahkan deskripsi singkat.</p>
        </div>

        <div class="step-card">
            <div class="step-number">2</div>
            <h3>Verifikasi & Tindak Lanjut</h3>
            <p>Admin sekolah atau kampus memverifikasi laporan dan menugaskan petugas.</p>
        </div>

        <div class="step-card">
            <div class="step-number">3</div>
            <h3>Selesai</h3>
            <p>Fasilitas diperbaiki, status diperbarui, dan pelapor dapat memantau hasilnya.</p>
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="section-header">
        <span>Laporan</span>
        <h2>Laporan Publik Terbaru</h2>
        <p>Laporan yang sudah diverifikasi dapat dilihat oleh pengguna lain.</p>
    </div>

    <div class="report-grid">
        <?php if (! empty($public_reports)) : ?>
            <?php foreach (array_slice($public_reports, 0, 3) as $report) : ?>
                <div class="report-card">
                    <h3><?= esc($report['title']) ?></h3>
                    <p><?= esc(substr($report['description'], 0, 110)) ?>...</p>

                    <div class="report-meta">
                        <span class="badge badge-blue"><?= esc($report['category_name'] ?? '-') ?></span>
                        <span class="badge badge-yellow"><?= esc(ucfirst($report['priority'])) ?></span>
                    </div>

                    <a href="<?= base_url('/laporan-publik/' . $report['id']) ?>" class="btn">Detail</a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="report-card">
                <h3>Belum Ada Laporan Publik</h3>
                <p>Laporan akan tampil setelah diverifikasi oleh admin.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section-blue">
    <div class="section-header">
        <h2>Siap Membuat Laporan?</h2>
        <p>Sampaikan kondisi fasilitas secara cepat agar bisa segera ditindaklanjuti.</p>
    </div>

    <div class="hero-actions">
        <?php if (session()->get('isLoggedIn')) : ?>
            <a href="<?= base_url('/laporan/create') ?>" class="btn btn-light">Mulai Sekarang</a>
        <?php else : ?>
            <a href="<?= base_url('/login') ?>" class="btn btn-light">Masuk / Daftar</a>
        <?php endif; ?>

        <a href="<?= base_url('/lacak-laporan') ?>" class="btn btn-outline">Lacak Laporan</a>
    </div>
</section>

<?= $this->endSection() ?>