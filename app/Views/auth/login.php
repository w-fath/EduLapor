<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<form action="<?= base_url('/login') ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="email">Email</label>
        <input
            type="email"
            name="email"
            id="email"
            value="<?= old('email') ?>"
            placeholder="Masukkan email"
            required
        >
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input
            type="password"
            name="password"
            id="password"
            placeholder="Masukkan password"
            required
        >
    </div>

    <button type="submit" class="btn">Login</button>
</form>

<div class="auth-link">
    Belum punya akun?
    <a href="<?= base_url('/register') ?>">Daftar sebagai pelapor</a>
</div>

<?= $this->endSection() ?>