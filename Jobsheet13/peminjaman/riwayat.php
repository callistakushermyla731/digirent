<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

$pelanggan_id = filter_input(INPUT_GET, 'pelanggan_id', FILTER_VALIDATE_INT);
$pelanggan = $pdo->query('select id, nama from pelanggan order by nama asc')->fetchAll();

$sql = "select
            p.id,
            p.tanggal_pinjam,
            p.tanggal_kembali,
            p.status,
            d.nama as digicam_nama,
            d.merek,
            d.tipe,
            pl.nama as pelanggan_nama
        from peminjaman p
        join digicam d on d.id = p.digicam_id
        join pelanggan pl on pl.id = p.pelanggan_id";

$params = [];
if ($pelanggan_id) {
    $sql .= ' where p.pelanggan_id = :pelanggan_id';
    $params['pelanggan_id'] = $pelanggan_id;
}
$sql .= ' order by p.id desc';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll();

$aktif = (int)$pdo->query("select count(*) from peminjaman where status = 'dipinjam'")->fetchColumn();
$terlambat = (int)$pdo->query(
    "select count(*) from peminjaman
     where status = 'dipinjam'
       and tanggal_pinjam < current_date - interval '14 days'"
)->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - DIGIRENT</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<main class="container">
    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['pesan']) ?></div>
        <?php unset($_SESSION['pesan']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <section class="stats-grid">
        <div class="stat-card"><div class="stat-info"><p>Peminjaman Aktif</p><h2><?= $aktif ?></h2></div><div class="stat-icon">📦</div></div>
        <div class="stat-card"><div class="stat-info"><p>Terlambat &gt; 14 Hari</p><h2><?= $terlambat ?></h2></div><div class="stat-icon">⚠️</div></div>
    </section>

    <div class="table-card">
        <div class="table-header">
            <div>
                <h2>Riwayat Peminjaman</h2>
                <p>Histori peminjaman dan pengembalian digicam berdasarkan pelanggan.</p>
            </div>
            <a href="tambah.php" class="btn-pink">+ Peminjaman Baru</a>
        </div>

        <form method="get" class="search-form">
            <select name="pelanggan_id">
                <option value="">Semua Pelanggan</option>
                <?php foreach ($pelanggan as $row): ?>
                    <option value="<?= (int)$row['id'] ?>" <?= $pelanggan_id === (int)$row['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-pink">Filter</button>
            <?php if ($pelanggan_id): ?><a href="riwayat.php" class="btn-outline">Reset</a><?php endif; ?>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Digicam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($data): $no = 1; foreach ($data as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['pelanggan_nama']) ?></td>
                        <td><?= htmlspecialchars($row['digicam_nama']) ?> - <?= htmlspecialchars($row['merek']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                        <td><?= $row['tanggal_kembali'] ? htmlspecialchars($row['tanggal_kembali']) : '-' ?></td>
                        <td>
                            <?php if ($row['status'] === 'dipinjam'): ?>
                                <span class="badge">Dipinjam</span>
                            <?php else: ?>
                                <span class="badge">Dikembalikan</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <?php if ($row['status'] === 'dipinjam'): ?>
                                <form action="kembali.php" method="post" class="inline-form" onsubmit="return confirm('Yakin digicam ini sudah dikembalikan?');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
                                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                    <button type="submit" class="btn-action btn-edit">Kembalikan</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="7" class="empty-state">Belum ada data peminjaman.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
</body>
</html>
