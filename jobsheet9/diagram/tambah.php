<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    $_SESSION["error"] = "Silakan login terlebih dahulu.";
    header("Location: ../login.php");
    exit;
}

require_once "../includes/koneksi.php";

$edit = null;
if (isset($_GET["edit"])) {
    $edit = cari_data('diagram', (int)$_GET["edit"]);

    if (!$edit) {
        $_SESSION["error"] = "Data tidak ditemukan.";
        header("Location: list.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $edit ? "Edit" : "Tambah" ?> Diagram</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="container">
    <div class="form-card">
        <h2 style="color:#d63384; margin-bottom:1.5rem;">
            <?= $edit ? "Edit Data Diagram" : "Tambah Data Diagram" ?>
        </h2>

        <form action="proses_tambah.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($edit["id"] ?? "") ?>">

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($edit["nama"] ?? "") ?>" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" id="keterangan" name="keterangan" value="<?= htmlspecialchars($edit["keterangan"] ?? "") ?>" required>
            </div>

            <div class="btn-group">
                <button type="submit" name="<?= $edit ? "update" : "simpan" ?>" class="btn-pink">
                    <?= $edit ? "Update" : "Simpan" ?>
                </button>
                <a href="list.php" class="btn-outline">Kembali</a>
            </div>
        </form>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
