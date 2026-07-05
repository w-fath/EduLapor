<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Pengaduan Fasilitas') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #2563eb, #0f172a);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 430px;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-logo h1 {
            margin: 0;
            color: #1e3a8a;
            font-size: 28px;
        }

        .auth-logo p {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #334155;
            font-size: 14px;
        }

        input,
        textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            outline: none;
        }

        input:focus,
        textarea:focus {
            border-color: #2563eb;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .btn {
            width: 100%;
            border: none;
            background: #2563eb;
            color: white;
            padding: 13px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .auth-link {
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .auth-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            <h1>EduLapor</h1>
            <p>Platform Pengaduan Fasilitas Pendidikan Berbasis Crowdsourcing</p>
        </div>

        <?= $this->include('layouts/partials/alert') ?>

        <?= $this->renderSection('content') ?>
    </div>
</div>

</body>
</html>