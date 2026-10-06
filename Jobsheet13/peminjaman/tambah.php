<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

$anggota = $pdo->query('select id, nama, email from pelanggan order by nama asc')->fetchAll();
$digicam = $pdo->query('select id, nama, merek, tipe, harga_sewa, stok from digicam where stok > 0 order by nama asc')->fetchAll();

$old_pelanggan = (int)($_SESSION['form_peminjaman']['pelanggan_id'] ?? 0);
$old_digicam = (int)($_SESSION['form_peminjaman']['digicam_id'] ?? 0);
unset($_SESSION['form_peminjaman']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Digicam - DIGIRENT</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<main class="container">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="form-card">
        <div class="table-header">
            <div>
                <h2>Peminjaman Digicam</h2>
                <p>Pilih pelanggan dan digicam yang stoknya masih tersedia.</p>
            </div>
        </div>

        <?php if (!$anggota): ?>
            <div class="alert alert-danger">Belum ada pelanggan. Tambahkan pelanggan terlebih dahulu.</div>
        <?php elseif (!$digicam): ?>
            <div class="alert alert-danger">Tidak ada digicam dengan stok tersedia.</div>
        <?php else: ?>
            <form action="proses_tambah.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">

                <div class="form-group">
                    <label for="pelanggan_id">Pelanggan</label>
                    <select id="pelanggan_id" name="pelanggan_id" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php foreach ($anggota as $row): ?>
                            <option value="<?= (int)$row['id'] ?>" <?= $old_pelanggan === (int)$row['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nama']) ?> - <?= htmlspecialchars($row['email']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="digicam_id">Digicam</label>
                    <select id="digicam_id" name="digicam_id" required>
                        <option value="">-- Pilih Digicam --</option>
                        <?php foreach ($digicam as $row): ?>
                            <option value="<?= (int)$row['id'] ?>" <?= $old_digicam === (int)$row['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nama']) ?> - <?= htmlspecialchars($row['merek']) ?> | Stok: <?= (int)$row['stok'] ?> | Rp <?= number_format((int)$row['harga_sewa'], 0, ',', '.') ?>/hari
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="notice-box">
                    <strong>Tanggal peminjaman:</strong> otomatis menggunakan tanggal hari ini.<br>
                    Peminjaman yang belum dikembalikan lebih dari 14 hari akan memblokir pelanggan dari peminjaman baru.
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-pink">Simpan Peminjaman</button>
                    <a href="riwayat.php" class="btn-outline">Lihat Riwayat</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
</body>
</html>
