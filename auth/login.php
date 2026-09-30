<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <title>Login - DIGIRENT</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="container">
    <div class="login-wrapper">
        <div class="login-card">
            <h1>Login</h1>
            <p class="login-subtitle">Silakan masuk untuk mengelola data</p>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['pesan'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['pesan']) ?>
                </div>
                <?php unset($_SESSION['pesan']); ?>
            <?php endif; ?>

            <form action="proses_login.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username"
                           placeholder="Masukkan username"
                           required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password"
                           required>
                </div>

                <button type="submit" class="btn-pink">Login</button>
            </form>

            <p style="margin-top: 1rem;">
                Belum punya akun?
                <a href="register.php">Register di sini</a>
            </p>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
