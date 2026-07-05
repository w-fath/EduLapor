<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Edit User</h2>
    <a href="<?= base_url('/admin/users') ?>" class="btn btn-secondary">Kembali</a>
</div>

<div class="form-card">
    <form action="<?= base_url('/admin/users/' . $user['id'] . '/update') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="role_id">Role</label>
            <select name="role_id" id="role_id" class="form-control" required>
                <option value="">-- Pilih Role --</option>

                <?php foreach ($roles as $role) : ?>
                    <option value="<?= esc($role['id']) ?>" <?= old('role_id', $user['role_id']) == $role['id'] ? 'selected' : '' ?>>
                        <?= esc($role['label'] ?? $role['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="<?= old('name', $user['name']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
                value="<?= old('email', $user['email']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="phone">No. HP</label>
            <input
                type="text"
                name="phone"
                id="phone"
                class="form-control"
                value="<?= old('phone', $user['phone']) ?>"
            >
        </div>

        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea
                name="address"
                id="address"
                class="form-control"
            ><?= old('address', $user['address']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                placeholder="Kosongkan jika tidak ingin mengganti password"
            >
            <small>Kosongkan field ini jika password tidak ingin diubah.</small>
        </div>

        <div class="form-group">
            <label for="status">Status Akun</label>
            <select name="status" id="status" class="form-control" required>
                <option value="active" <?= old('status', $user['status']) == 'active' ? 'selected' : '' ?>>
                    Aktif
                </option>
                <option value="inactive" <?= old('status', $user['status']) == 'inactive' ? 'selected' : '' ?>>
                    Tidak Aktif
                </option>
            </select>
        </div>

        <button type="submit" class="btn">Update User</button>
    </form>
</div>

<?= $this->endSection() ?>