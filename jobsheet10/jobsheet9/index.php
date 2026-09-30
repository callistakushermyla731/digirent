<?php
session_start();
require_once 'includes/koneksi.php';

$jumlah_digicam = (int)$pdo->query('select count(*) from digicam')->fetchColumn();
$jumlah_pelanggan = (int)$pdo->query('select count(*) from pelanggan')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIGIRENT - Rental Digicam</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<main class="container">
    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['pesan']) ?>
        </div>
        <?php unset($_SESSION['pesan']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <section class="hero-card">
        <div class="hero-content">
            <span class="badge">DIGICAM RENTAL</span>
            <h1>Selamat Datang di DIGIRENT</h1>
            <p>
                DIGIRENT adalah website sederhana untuk mengelola katalog digicam
                dan data pelanggan rental secara praktis.
            </p>

            <div class="btn-group">
                <a href="digicam/list.php" class="btn-pink">Lihat Katalog Digicam</a>
                <a href="pelanggan/list.php" class="btn-outline">Daftar Pelanggan</a>
            </div>
        </div>

        <div class="notice-box">
            <h3>Informasi Login</h3>
            <ul>
                <li>📧 Username: admindigirent123@gmail.com</li>
                <li>🔑 Password: 12345678</li>
                <li>📷 Kelola katalog digicam</li>
                <li>👥 Kelola data pelanggan</li>
            </ul>
        </div>
    </section>

    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <p>Total Digicam</p>
                <h2><?= $jumlah_digicam ?></h2>
            </div>
            <div class="stat-icon">📷</div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <p>Total Pelanggan</p>
                <h2><?= $jumlah_pelanggan ?></h2>
            </div>
            <div class="stat-icon">👤</div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <p>Status</p>
                <h2><?= isset($_SESSION['login']) && $_SESSION['login'] === true ? 'Login' : 'Guest' ?></h2>
            </div>
            <div class="stat-icon">✅</div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
