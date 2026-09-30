<?php
session_start();

if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jobsheet 8</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<main class="container">
    <div class="login-wrapper">
        <div class="login-card">
            <h1>Login</h1>
            <p class="login-subtitle">Silakan masuk untuk mengelola data</p>

            <?php if (isset($_SESSION["error"])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION["error"]) ?>
                </div>
                <?php unset($_SESSION["error"]); ?>
            <?php endif; ?>

            <form action="proses_login.php" method="post">
                <div class="form-group">
                    <label for="email">Username</label>
                    <input type="email" id="email" name="email"
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
        </div>
    </div>
</main>

<?php include "includes/footer.php"; ?>
</body>
</html>
