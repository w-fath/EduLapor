<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'EduLapor') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('assets/css/public.css') ?>">
</head>
<body>

<nav class="public-navbar">
    <a href="<?= base_url('/') ?>" class="brand">
        <span class="brand-icon">L</span>
        <span>EduLapor</span>
    </a>

    <div class="nav-menu">
        <a href="<?= base_url('/') ?>">Beranda</a>
        <a href="<?= base_url('/laporan-publik') ?>">Laporan</a>
        <a href="<?= base_url('/tentang') ?>">Tentang</a>
        <a href="<?= base_url('/statistik') ?>">Statistik</a>
        <!-- <a href="<?= base_url('/lacak-laporan') ?>">Lacak Laporan</a> -->

        <?php if (session()->get('isLoggedIn')) : ?>
            <a href="<?= base_url('/dashboard') ?>" class="btn-login">Dashboard</a>
        <?php else : ?>
            <a href="<?= base_url('/login') ?>" class="btn-login">Masuk</a>
        <?php endif; ?>
    </div>
</nav>

<?= $this->renderSection('content') ?>

<footer class="footer">
    <div class="footer-grid">
        <div>
            <h3>EduLapor</h3>
            <p>
                Platform pengaduan fasilitas pendidikan berbasis crowdsourcing
                untuk mendukung lingkungan belajar yang lebih baik.
            </p>
        </div>

        <div>
            <h4>Menu</h4>
            <a href="<?= base_url('/') ?>">Beranda</a>
            <a href="<?= base_url('/tentang') ?>">Tentang</a>
            <a href="<?= base_url('/statistik') ?>">Statistik</a>
            <a href="<?= base_url('/lacak-laporan') ?>">Lacak Laporan</a>
        </div>

        <div>
            <h4>Bantuan</h4>
            <a href="<?= base_url('/login') ?>">Login</a>
            <a href="<?= base_url('/register') ?>">Daftar</a>
            <a href="<?= base_url('/lacak-laporan') ?>">Lacak Laporan</a>
        </div>
    </div>

    <div class="copyright">
        © <?= date('Y') ?> EduLapor. All Rights Reserved.
    </div>
</footer>

</body>
</html>