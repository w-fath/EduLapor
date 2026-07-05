<div class="navbar">
    <div class="navbar-title">
        <h1><?= esc($title ?? 'Dashboard') ?></h1>
        <p>Platform Pengaduan Fasilitas Pendidikan Berbasis Crowdsourcing</p>
    </div>

    <div class="navbar-user">
        <div class="user-info">
            <strong><?= esc(session()->get('name')) ?></strong>
            <span><?= esc(session()->get('role_label') ?? session()->get('role_name')) ?></span>
        </div>

        <a href="<?= base_url('/logout') ?>" class="btn-logout">Logout</a>
    </div>
</div>