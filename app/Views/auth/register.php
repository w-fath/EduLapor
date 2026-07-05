<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<form action="<?= base_url('/register') ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input
            type="text"
            name="name"
            id="name"
            value="<?= old('name') ?>"
            placeholder="Masukkan nama lengkap"
            required
        >
    </div>

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
        <label for="phone">Nomor HP</label>
        <input
            type="text"
            name="phone"
            id="phone"
            value="<?= old('phone') ?>"
            placeholder="Contoh: 081234567890"
        >
    </div>

    <div class="form-group">
        <label for="address">Alamat</label>
        <textarea
            name="address"
            id="address"
            placeholder="Masukkan alamat"
        ><?= old('address') ?></textarea>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input
            type="password"
            name="password"
            id="password"
            placeholder="Minimal 6 karakter"
            required
        >
    </div>

    <div class="form-group">
        <label for="confirm_password">Konfirmasi Password</label>
        <input
            type="password"
            name="confirm_password"
            id="confirm_password"
            placeholder="Ulangi password"
            required
        >
    </div>

    <button type="submit" class="btn">Daftar</button>
</form>

<div class="auth-link">
    Sudah punya akun?
    <a href="<?= base_url('/login') ?>">Login sekarang</a>
</div>

<?= $this->endSection() ?>