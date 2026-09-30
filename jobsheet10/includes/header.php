<?php
// Deteksi direktori utama/root aplikasi secara otomatis
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIGIRENT</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-pink py-3 mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3 text-white" href="<?= $base_url ?>/index.php">DIGIRENT</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-link-group navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link text-white" href="<?= $base_url ?>/index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= $base_url ?>/digicam/list.php">Katalog Digicam</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= $base_url ?>/digicam/tambah.php">Tambah Digicam</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="<?= $base_url ?>/pelanggan/list.php">Daftar Pelanggan</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= $base_url ?>/pelanggan/tambah.php">Tambah Pelanggan</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <span class="text-white small">Hallo admin digirent</span>
                <a href="<?= $base_url ?>/auth/logout.php" class="btn btn-light text-pink rounded-pill px-3 fw-semibold">Logout</a>
            </div>
        </div>
    </div>
</nav>

<div class="container pb-5">