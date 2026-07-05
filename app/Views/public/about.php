<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<section class="hero" style="background:#2554c7;color:white;">
    <h1 style="color:white;">Mewujudkan Pendidikan yang Lebih Baik</h1>
    <p style="color:#dbeafe;">
        LaporSekolah adalah platform crowdsourcing untuk pengaduan fasilitas pendidikan
        agar lingkungan belajar menjadi lebih aman, nyaman, dan layak.
    </p>

    <div class="stats-row">
        <div class="stat-mini">
            <strong style="color:white;"><?= esc($total_locations ?? 0) ?>+</strong>
            <span style="color:#dbeafe;">Lokasi/Fasilitas</span>
        </div>

        <div class="stat-mini">
            <strong style="color:white;"><?= esc($total_categories ?? 0) ?>+</strong>
            <span style="color:#dbeafe;">Kategori</span>
        </div>

        <div class="stat-mini">
            <strong style="color:white;"><?= esc($total_reports ?? 0) ?>+</strong>
            <span style="color:#dbeafe;">Laporan Masuk</span>
        </div>

        <div class="stat-mini">
            <strong style="color:white;">98%</strong>
            <span style="color:#dbeafe;">Transparansi</span>
        </div>
    </div>
</section>

<section class="section section-white">
    <div class="two-column">
        <div>
            <span style="color:#2563eb;font-weight:bold;">Publik & Partisipatif</span>
            <h2>Menghubungkan Komunitas Sekolah</h2>
            <p style="color:#64748b;line-height:1.8;">
                LaporSekolah hadir sebagai wadah digital untuk menyampaikan pengaduan
                fasilitas pendidikan. Dengan sistem ini, siswa, guru, dan pihak sekolah
                dapat bekerja sama untuk menjaga fasilitas agar tetap layak digunakan.
            </p>
            <p style="color:#64748b;line-height:1.8;">
                Konsep crowdsourcing membuat laporan berasal dari banyak pengguna,
                sehingga masalah fasilitas lebih cepat diketahui dan dapat diprioritaskan.
            </p>
        </div>

        <div class="about-box">
            <div class="mock-card">
                <h3>Fasilitas Sekolah</h3>
                <div class="mock-list">
                    <div class="mock-item">Ruang Kelas</div>
                    <div class="mock-item">Toilet</div>
                    <div class="mock-item">Laboratorium</div>
                    <div class="mock-item">Perpustakaan</div>
                    <div class="mock-item">Jaringan Internet</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-header">
        <span>Manfaat</span>
        <h2>Manfaat untuk Semua Pihak</h2>
    </div>

    <div class="benefit-grid">
        <div class="benefit-card">
            <h3>Untuk Siswa</h3>
            <p>Menyampaikan keluhan fasilitas secara mudah dan melihat perkembangan laporan.</p>
        </div>

        <div class="benefit-card">
            <h3>Untuk Guru</h3>
            <p>Membantu menciptakan lingkungan belajar yang lebih nyaman dan produktif.</p>
        </div>

        <div class="benefit-card">
            <h3>Untuk Sekolah</h3>
            <p>Mendapatkan data kerusakan fasilitas secara lebih cepat dan transparan.</p>
        </div>
    </div>
</section>

<section class="section section-white" style="text-align:center;">
    <h2>Bergabung Bersama Kami</h2>
    <p style="color:#64748b;">Jadilah bagian dari peningkatan fasilitas pendidikan.</p>
    <a href="<?= base_url('/register') ?>" class="btn">Daftar Sekarang</a>
</section>

<?= $this->endSection() ?>