<?php
session_start();
require_once "../includes/koneksi.php";

$data = baca_data('diagram');
usort($data, function ($a, $b) {
    return (int)$b['id'] <=> (int)$a['id'];
});
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Diagram</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>

<main class="container">
    <?php if (isset($_SESSION["pesan"])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION["pesan"]) ?></div>
        <?php unset($_SESSION["pesan"]); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION["error"])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION["error"]) ?></div>
        <?php unset($_SESSION["error"]); ?>
    <?php endif; ?>

    <div class="table-card">
        <div class="table-header">
            <div>
                <h2>Data Diagram</h2>
                <p>Daftar data diagram.</p>
            </div>
            <?php if (isset($_SESSION["login"]) && $_SESSION["login"] === true): ?>
                <a href="tambah.php" class="btn-pink">+ Tambah Data</a>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <?php if (isset($_SESSION["login"]) && $_SESSION["login"] === true): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0): ?>
                    <?php $no = 1; foreach ($data as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row["nama"]) ?></td>
                            <td><?= htmlspecialchars($row["keterangan"]) ?></td>
                            <?php if (isset($_SESSION["login"]) && $_SESSION["login"] === true): ?>
                                <td class="actions">
                                    <a href="tambah.php?edit=<?= (int)$row["id"] ?>" class="btn-action btn-edit">Edit</a>
                                    <a href="proses_tambah.php?hapus=<?= (int)$row["id"] ?>" class="btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="empty-state">Belum ada data.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
</body>
</html>
