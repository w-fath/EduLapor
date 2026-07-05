<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<section class="hero">
    <h1>Lacak Laporan Anda</h1>
    <p>Masukkan kode atau ID laporan untuk melihat status perkembangan laporan.</p>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="track-box">
        <form action="<?= base_url('/lacak-laporan') ?>" method="post" class="track-form">
            <?= csrf_field() ?>

            <input
                type="text"
                name="keyword"
                value="<?= esc($keyword ?? '') ?>"
                placeholder="Contoh: LAP-2026-001 atau 1"
                required
            >

            <button type="submit" class="btn">Cari Laporan</button>
        </form>

        <?php if ($keyword !== null) : ?>
            <?php if (! empty($report)) : ?>
                <div class="track-result">
                    <h3><?= esc($report['title']) ?></h3>
                    <p><?= esc($report['description']) ?></p>

                    <p>
                        <strong>Kode:</strong>
                        LAP-<?= date('Y', strtotime($report['created_at'])) ?>-<?= str_pad($report['id'], 3, '0', STR_PAD_LEFT) ?>
                    </p>

                    <p><strong>Kategori:</strong> <?= esc($report['category_name'] ?? '-') ?></p>
                    <p><strong>Lokasi:</strong> <?= esc($report['location_name'] ?? '-') ?></p>
                    <p><strong>Status:</strong> <?= esc(str_replace('_', ' ', ucfirst($report['status']))) ?></p>

                    <a href="<?= base_url('/laporan-publik/' . $report['id']) ?>" class="btn">
                        Lihat Detail
                    </a>
                </div>
            <?php else : ?>
                <div class="track-result">
                    <h3>Laporan Tidak Ditemukan</h3>
                    <p>Pastikan kode atau ID laporan yang dimasukkan sudah benar.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>