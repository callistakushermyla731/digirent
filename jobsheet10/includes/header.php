<?php
// Menentukan path berdasarkan kedalaman halaman dari root project.
$scriptPath = parse_url($_SERVER['SCRIPT_NAME'] ?? '', PHP_URL_PATH);
$directory = trim(dirname($scriptPath), '/');
$depth = ($directory === '') ? 0 : substr_count($directory, '/') + 1;
$path = str_repeat('../', $depth);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIGIRENT</title>
    <link rel="stylesheet" href="<?= $path ?>assets/css/style.css">
</head>
<body>

<header>
    <div class="header-container">
        <a class="brand-title" href="<?= $path ?>index.php">DIGIRENT</a>

        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="hamburger-btn">☰</label>

        <nav>
            <ul>
                <li><a href="<?= $path ?>index.php">Home</a></li>
                <li><a href="<?= $path ?>digicam/list.php">Katalog Digicam</a></li>
                <li><a href="<?= $path ?>digicam/tambah.php">Tambah Digicam</a></li>
                <li><a href="<?= $path ?>pelanggan/list.php">Daftar Pelanggan</a></li>
                <li><a href="<?= $path ?>pelanggan/tambah.php">Tambah Pelanggan</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><span style="color:white;padding:0.5rem 0.8rem;display:inline-block;">Hallo admin digirent</span></li>
                    <li><a href="<?= $path ?>auth/logout.php" class="btn-login">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
