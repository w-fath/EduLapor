<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Kelola Lokasi</h2>
    <a href="<?= base_url('/admin/locations/create') ?>" class="btn">Tambah Lokasi</a>
</div>

<div class="panel">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama Lokasi</th>
                    <th>Alamat/Keterangan</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (! empty($locations)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($locations as $location) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= esc($location['name']) ?></strong></td>
                            <td><?= esc($location['address'] ?? '-') ?></td>
                            <td><?= esc($location['latitude'] ?? '-') ?></td>
                            <td><?= esc($location['longitude'] ?? '-') ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= base_url('/admin/locations/' . $location['id'] . '/edit') ?>" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="<?= base_url('/admin/locations/' . $location['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')">
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
                        <td colspan="6">
                            <div class="empty-state">
                                Belum ada data lokasi.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>