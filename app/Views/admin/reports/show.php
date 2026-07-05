<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php
$statusLabels = [
    'menunggu_verifikasi' => 'Menunggu Verifikasi',
    'diverifikasi' => 'Diverifikasi',
    'ditolak' => 'Ditolak',
    'diproses' => 'Diproses',
    'selesai' => 'Selesai',
];

$statusClasses = [
    'menunggu_verifikasi' => 'badge-pending',
    'diverifikasi' => 'badge-verified',
    'ditolak' => 'badge-rejected',
    'diproses' => 'badge-process',
    'selesai' => 'badge-done',
];

$priorityClasses = [
    'rendah' => 'badge-low',
    'sedang' => 'badge-medium',
    'tinggi' => 'badge-high',
];
?>

<div class="page-header">
    <h2>Detail Laporan</h2>
    <a href="<?= base_url('/admin/reports') ?>" class="btn btn-secondary">Kembali</a>
</div>

<div class="panel mb-20">
    <h2><?= esc($report['title']) ?></h2>

    <div class="detail-grid">
        <div class="detail-item">
            <small>Pelapor</small>
            <strong><?= esc($report['reporter_name'] ?? '-') ?></strong>
        </div>

        <div class="detail-item">
            <small>Email Pelapor</small>
            <strong><?= esc($report['reporter_email'] ?? '-') ?></strong>
        </div>

        <div class="detail-item">
            <small>No. HP Pelapor</small>
            <strong><?= esc($report['reporter_phone'] ?? '-') ?></strong>
        </div>

        <div class="detail-item">
            <small>Kategori</small>
            <strong><?= esc($report['category_name'] ?? '-') ?></strong>
        </div>

        <div class="detail-item">
            <small>Lokasi</small>
            <strong><?= esc($report['location_name'] ?? '-') ?></strong>
        </div>

        <div class="detail-item">
            <small>Alamat/Keterangan Lokasi</small>
            <strong><?= esc($report['location_address'] ?? '-') ?></strong>
        </div>

        <div class="detail-item">
            <small>Status</small>
            <span class="badge <?= esc($statusClasses[$report['status']] ?? 'badge-pending') ?>">
                <?= esc($statusLabels[$report['status']] ?? $report['status']) ?>
            </span>
        </div>

        <div class="detail-item">
            <small>Prioritas</small>
            <span class="badge <?= esc($priorityClasses[$report['priority']] ?? 'badge-medium') ?>">
                <?= esc(ucfirst($report['priority'])) ?>
            </span>
        </div>

        <div class="detail-item">
            <small>Petugas</small>
            <strong><?= esc($report['petugas_name'] ?? 'Belum ditugaskan') ?></strong>
        </div>

        <div class="detail-item">
            <small>Total Dukungan</small>
            <strong><?= esc($report['total_votes'] ?? 0) ?> vote</strong>
        </div>

        <div class="detail-item">
            <small>Tanggal Laporan</small>
            <strong><?= esc(date('d M Y H:i', strtotime($report['created_at']))) ?></strong>
        </div>
    </div>

    <h3>Deskripsi Laporan</h3>
    <div class="description-box">
        <?= nl2br(esc($report['description'])) ?>
    </div>

    <?php if (! empty($report['rejection_reason'])) : ?>
        <h3 class="mt-20">Alasan Penolakan</h3>
        <div class="description-box">
            <?= nl2br(esc($report['rejection_reason'])) ?>
        </div>
    <?php endif; ?>

    <?php if (! empty($report['completed_note'])) : ?>
        <h3 class="mt-20">Catatan Penyelesaian</h3>
        <div class="description-box">
            <?= nl2br(esc($report['completed_note'])) ?>
        </div>
    <?php endif; ?>

    <?php if (! empty($photos)) : ?>
        <h3 class="mt-20">Foto Bukti</h3>
        <div class="photo-grid">
            <?php foreach ($photos as $photo) : ?>
                <a href="<?= base_url('uploads/reports/' . $photo['photo']) ?>" target="_blank">
                    <img src="<?= base_url('uploads/reports/' . $photo['photo']) ?>" alt="Foto laporan">
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="panel mb-20">
    <h2>Aksi Admin</h2>

    <div class="quick-actions mb-20">
        <?php if ($report['status'] === 'menunggu_verifikasi') : ?>
            <form action="<?= base_url('/admin/reports/' . $report['id'] . '/verify') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-success" onclick="return confirm('Verifikasi laporan ini?')">
                    Verifikasi Laporan
                </button>
            </form>
        <?php endif; ?>

        <form action="<?= base_url('/admin/reports/' . $report['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">
                Hapus Laporan
            </button>
        </form>
    </div>

    <?php if (! in_array($report['status'], ['ditolak', 'selesai'])) : ?>
        <div class="form-card mb-20">
            <h3>Tugaskan ke Petugas</h3>

            <?php if (! empty($petugas)) : ?>
                <form action="<?= base_url('/admin/reports/' . $report['id'] . '/assign') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="assigned_to">Pilih Petugas</label>
                        <select name="assigned_to" id="assigned_to" class="form-control" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php foreach ($petugas as $p) : ?>
                                <option value="<?= esc($p['id']) ?>" <?= $report['assigned_to'] == $p['id'] ? 'selected' : '' ?>>
                                    <?= esc($p['name']) ?> - <?= esc($p['email']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn">
                        Simpan Penugasan
                    </button>
                </form>
            <?php else : ?>
                <div class="empty-state">
                    Belum ada user dengan role petugas. Tambahkan petugas dulu di menu Kelola User.
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (! in_array($report['status'], ['ditolak', 'diproses', 'selesai'])) : ?>
        <div class="form-card">
            <h3>Tolak Laporan</h3>

            <form action="<?= base_url('/admin/reports/' . $report['id'] . '/reject') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="rejection_reason">Alasan Penolakan</label>
                    <textarea
                        name="rejection_reason"
                        id="rejection_reason"
                        class="form-control"
                        placeholder="Contoh: Laporan kurang jelas atau data tidak sesuai."
                        required
                    ><?= old('rejection_reason') ?></textarea>
                </div>

                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menolak laporan ini?')">
                    Tolak Laporan
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<div class="panel mb-20">
    <h2>Riwayat Status</h2>

    <?php if (! empty($histories)) : ?>
        <div class="timeline">
            <?php foreach ($histories as $history) : ?>
                <div class="timeline-item">
                    <strong>
                        <?= esc($statusLabels[$history['new_status']] ?? $history['new_status']) ?>
                    </strong>

                    <small>
                        Oleh <?= esc($history['user_name'] ?? '-') ?> —
                        <?= esc($history['role_label'] ?? '-') ?> —
                        <?= esc(date('d M Y H:i', strtotime($history['created_at']))) ?>
                    </small>

                    <?php if (! empty($history['note'])) : ?>
                        <p><?= nl2br(esc($history['note'])) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="empty-state">
            Belum ada riwayat status.
        </div>
    <?php endif; ?>
</div>

<div class="panel">
    <h2>Komentar / Tanggapan</h2>

    <?php if (! empty($comments)) : ?>
        <div class="timeline">
            <?php foreach ($comments as $comment) : ?>
                <div class="timeline-item">
                    <strong><?= esc($comment['user_name'] ?? '-') ?></strong>

                    <small>
                        <?= esc($comment['role_label'] ?? '-') ?> —
                        <?= esc(date('d M Y H:i', strtotime($comment['created_at']))) ?>
                    </small>

                    <p><?= nl2br(esc($comment['comment'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="empty-state">
            Belum ada komentar atau tanggapan.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>