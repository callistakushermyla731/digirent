<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    $_SESSION['error'] = 'Silakan login terlebih dahulu untuk menambah atau mengubah digicam.';
    header('Location: ../login.php');
    exit;
}

require_once '../includes/koneksi.php';

$edit = null;
if (isset($_GET['edit'])) {
    $edit = cari_data('digicam', (int)$_GET['edit']);

    if (!$edit) {
        $_SESSION['error'] = 'Data digicam tidak ditemukan.';
        header('Location: list.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $edit ? 'Edit' : 'Tambah' ?> Digicam - DIGIRENT</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="container">
    <div class="form-card">
        <h2 style="color:#d63384; margin-bottom:1.5rem;">
            <?= $edit ? 'Edit Data Digicam' : 'Tambah Digicam' ?>
        </h2>

        <form action="proses_tambah.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($edit['id'] ?? '') ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="nama">Nama Digicam</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($edit['nama'] ?? '') ?>" placeholder="Contoh: Canon IXUS 185" required>
                </div>
                <div class="form-group">
                    <label for="merek">Merek</label>
                    <input type="text" id="merek" name="merek" value="<?= htmlspecialchars($edit['merek'] ?? '') ?>" placeholder="Contoh: Canon" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tipe">Tipe</label>
                    <input type="text" id="tipe" name="tipe" value="<?= htmlspecialchars($edit['tipe'] ?? '') ?>" placeholder="Contoh: Compact Camera" required>
                </div>
                <div class="form-group">
                    <label for="harga_sewa">Harga Sewa per Hari</label>
                    <input type="number" id="harga_sewa" name="harga_sewa" value="<?= htmlspecialchars($edit['harga_sewa'] ?? '') ?>" min="0" required>
                </div>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" value="<?= htmlspecialchars($edit['stok'] ?? '') ?>" min="0" required>
            </div>

            <div class="btn-group">
                <button type="submit" name="<?= $edit ? 'update' : 'simpan' ?>" class="btn-pink">
                    <?= $edit ? 'Update' : 'Simpan' ?>
                </button>
                <a href="list.php" class="btn-outline">Kembali</a>
            </div>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
