<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$folder = basename(dirname($_SERVER['SCRIPT_FILENAME']));
$base = in_array($folder, ['digicam', 'pelanggan', 'diagram']) ? '../' : '';
?>
<header>
    <div class="header-container">
        <a href="<?= $base ?>index.php" class="brand-title">DIGIRENT</a>

        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="hamburger-btn">☰</label>

        <nav>
            <ul>
                <li><a href="<?= $base ?>index.php">Home</a></li>
                <li><a href="<?= $base ?>digicam/list.php">Katalog Digicam</a></li>
                <li><a href="<?= $base ?>digicam/tambah.php">Tambah Digicam</a></li>
                <li><a href="<?= $base ?>pelanggan/list.php">Daftar Pelanggan</a></li>
                <li><a href="<?= $base ?>pelanggan/tambah.php">Tambah Pelanggan</a></li>

                <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                    <li class="auth-group">
                        <a href="<?= $base ?>index.php" class="btn-login user-btn">Hallo <?= htmlspecialchars($_SESSION['email']) ?></a>
                        <a href="<?= $base ?>logout.php" class="btn-login logout-btn">Logout</a>
                    </li>
                <?php else: ?>
                    <li><a href="<?= $base ?>login.php" class="btn-login">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
