<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Debug Session</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include "includes/header.php"; ?>
<main class="container">
    <div class="table-card">
        <div class="table-header">
            <div>
                <h2>Debug Session</h2>
                <p>Informasi session saat ini.</p>
            </div>
        </div>
        <div style="padding:1.5rem;">
            <pre><?= htmlspecialchars(print_r($_SESSION, true)) ?></pre>
        </div>
    </div>
</main>
<?php include "includes/footer.php"; ?>
</body>
</html>
