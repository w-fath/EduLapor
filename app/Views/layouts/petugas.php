<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Dashboard Petugas') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
</head>
<body>

<div class="app">
    <?= $this->include('layouts/partials/sidebar_petugas') ?>

    <main class="main-content">
        <?= $this->include('layouts/partials/navbar') ?>

        <div class="content">
            <?= $this->include('layouts/partials/alert') ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

</body>
</html>