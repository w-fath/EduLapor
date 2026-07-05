<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Kelola Kategori</h2>
    <a href="<?= base_url('/admin/categories/create') ?>" class="btn">Tambah Kategori</a>
</div>

<div class="panel">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (! empty($categories)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= esc($category['name']) ?></strong></td>
                            <td><?= esc($category['description'] ?? '-') ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= base_url('/admin/categories/' . $category['id'] . '/edit') ?>" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="<?= base_url('/admin/categories/' . $category['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                Belum ada data kategori.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>