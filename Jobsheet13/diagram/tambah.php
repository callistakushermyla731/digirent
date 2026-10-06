<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';
require_once '../includes/diagram_data.php';

$edit = null;
if (isset($_GET["edit"])) {
    $id = filter_input(INPUT_GET, "edit", FILTER_VALIDATE_INT);

    if (!$id) {
        $_SESSION["error"] = "ID diagram tidak valid.";
        header("Location: list.php");
        exit;
    }

    $data = baca_data("diagram");
    foreach ($data as $row) {
        if ((int)$row["id"] === $id) {
            $edit = $row;
            break;
        }
    }

    if (!$edit) {
        $_SESSION["error"] = "Data tidak ditemukan.";
        header("Location: list.php");
        exit;
    }
}
?><!DOCTYPE html>
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
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
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
