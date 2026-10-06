<?php
require_once '../includes/csrf.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DIGIRENT</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="container">
    <div class="login-wrapper">
        <div class="login-card">
            <h1>Register</h1>
            <p class="login-subtitle">Buat akun petugas DIGIRENT</p>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form action="proses_register.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama"
                           placeholder="Masukkan nama" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username"
                           placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn-pink">Register</button>
            </form>

            <p style="margin-top: 1rem;">
                Sudah punya akun?
                <a href="login.php">Login di sini</a>
            </p>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
