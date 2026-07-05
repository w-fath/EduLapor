<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Buat Laporan Pengaduan</h2>
    <a href="<?= base_url('/laporan') ?>" class="btn btn-secondary">Kembali</a>
</div>

<div class="form-card">
    <form action="<?= base_url('/laporan/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="category_id">Kategori Laporan</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= esc($category['id']) ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                        <?= esc($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="location_id">Lokasi Fasilitas</label>
            <select name="location_id" id="location_id" class="form-control">
                <option value="">-- Pilih Lokasi --</option>
                <?php foreach ($locations as $location) : ?>
                    <option value="<?= esc($location['id']) ?>" <?= old('location_id') == $location['id'] ? 'selected' : '' ?>>
                        <?= esc($location['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="title">Judul Laporan</label>
            <input
                type="text"
                name="title"
                id="title"
                class="form-control"
                value="<?= old('title') ?>"
                placeholder="Contoh: Lampu ruang kelas mati"
                required
            >
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Laporan</label>
            <textarea
                name="description"
                id="description"
                class="form-control"
                placeholder="Jelaskan kondisi fasilitas yang bermasalah secara detail"
                required
            ><?= old('description') ?></textarea>
        </div>

        <div class="form-group">
            <label for="priority">Prioritas</label>
            <select name="priority" id="priority" class="form-control" required>
                <option value="rendah" <?= old('priority') == 'rendah' ? 'selected' : '' ?>>Rendah</option>
                <option value="sedang" <?= old('priority', 'sedang') == 'sedang' ? 'selected' : '' ?>>Sedang</option>
                <option value="tinggi" <?= old('priority') == 'tinggi' ? 'selected' : '' ?>>Tinggi</option>
            </select>
        </div>

        <div class="form-group">
            <label for="photo">Foto Bukti</label>
            <input
                type="file"
                name="photo"
                id="photo"
                class="form-control"
                accept="image/png,image/jpeg,image/jpg,image/webp"
            >
            <small>Opsional. Format: JPG, PNG, WEBP. Maksimal 2MB.</small>
        </div>

        <button type="submit" class="btn">Kirim Laporan</button>
    </form>
</div>

<?= $this->endSection() ?>