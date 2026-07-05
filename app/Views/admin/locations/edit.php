<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Edit Lokasi</h2>
    <a href="<?= base_url('/admin/locations') ?>" class="btn btn-secondary">Kembali</a>
</div>

<div class="form-card">
    <form action="<?= base_url('/admin/locations/' . $location['id'] . '/update') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Nama Lokasi</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="<?= old('name', $location['name']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="address">Alamat/Keterangan Lokasi</label>
            <textarea
                name="address"
                id="address"
                class="form-control"
            ><?= old('address', $location['address']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input
                type="text"
                name="latitude"
                id="latitude"
                class="form-control"
                value="<?= old('latitude', $location['latitude']) ?>"
            >
        </div>

        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input
                type="text"
                name="longitude"
                id="longitude"
                class="form-control"
                value="<?= old('longitude', $location['longitude']) ?>"
            >
        </div>

        <button type="submit" class="btn">Update Lokasi</button>
    </form>
</div>

<?= $this->endSection() ?>