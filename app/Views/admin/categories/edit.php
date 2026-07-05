<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Edit Kategori</h2>
    <a href="<?= base_url('/admin/categories') ?>" class="btn btn-secondary">Kembali</a>
</div>

<div class="form-card">
    <form action="<?= base_url('/admin/categories/' . $category['id'] . '/update') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="<?= old('name', $category['name']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea
                name="description"
                id="description"
                class="form-control"
            ><?= old('description', $category['description']) ?></textarea>
        </div>

        <button type="submit" class="btn">Update Kategori</button>
    </form>
</div>

<?= $this->endSection() ?>