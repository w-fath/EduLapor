<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<section class="section section-white stat-page">
    <div class="section-header">
        <span>Statistik</span>
        <h2>Statistik Publik</h2>
        <p>Transparansi data pelaporan fasilitas sekolah.</p>
    </div>

    <!-- Stat Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <h3>Total Laporan</h3>
            <strong><?= esc($total_reports ?? 0) ?></strong>
        </div>

        <div class="stat-card">
            <h3>Laporan Selesai</h3>
            <strong class="text-success"><?= esc($completed_reports ?? 0) ?></strong>
        </div>

        <div class="stat-card">
            <h3>Laporan Proses</h3>
            <strong class="text-warning"><?= esc($process_reports ?? 0) ?></strong>
        </div>

        <div class="stat-card">
            <h3>Sekolah Aktif</h3>
            <strong><?= esc($active_schools ?? 0) ?></strong>
        </div>
    </div>

    <!-- Charts -->
    <div class="chart-grid">
        <div class="chart-card">
            <h3>Tren Laporan (7 Hari Terakhir)</h3>
            <canvas id="trendChart" height="220"></canvas>
        </div>

        <div class="chart-card chart-card-small">
            <h3>Kategori Kerusakan</h3>
            <canvas id="categoryChart" height="220"></canvas>

            <div class="donut-legend">
                <span><i class="dot dot-blue"></i> Kelas</span>
                <span><i class="dot dot-orange"></i> Toilet</span>
                <span><i class="dot dot-green"></i> Laboratorium</span>
                <span><i class="dot dot-gray"></i> Lainnya</span>
            </div>
        </div>
    </div>

    <!-- Top Schools Table -->
    <div class="table-card">
        <h3>Daftar Sekolah dengan Laporan Terbanyak</h3>

        <table class="stat-table">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Sekolah</th>
                    <th>Total Laporan</th>
                    <th>Selesai (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach (($top_schools ?? []) as $school) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($school['name']) ?></td>
                        <td><?= esc($school['total']) ?></td>
                        <td>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?= (int) $school['percent'] ?>%"></div>
                            </div>
                            <span class="progress-label"><?= (int) $school['percent'] ?>%</span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<script src="<?= base_url('assets/js/chart.min.js') ?>"></script>
<script>
    const trendLabels = <?= json_encode($trend_labels ?? ['Sen','Sel','Rab','Kam','Jum','Sab','Min']) ?>;
    const trendData   = <?= json_encode($trend_data ?? [12,18,13,20,28,10,4]) ?>;

    const categoryLabels = <?= json_encode($category_labels ?? ['Kelas','Toilet','Laboratorium','Lainnya']) ?>;
    const categoryData   = <?= json_encode($category_data ?? [35,25,20,20]) ?>;

    new Chart(document.getElementById('trendChart'), {
        type: 'bar',
        data: {
            labels: trendLabels,
            datasets: [{
                data: trendData,
                backgroundColor: '#2563eb',
                borderRadius: 4,
                maxBarThickness: 40
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: ['#2563eb', '#f59e0b', '#10b981', '#9ca3af'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });
</script>

<?= $this->endSection() ?>