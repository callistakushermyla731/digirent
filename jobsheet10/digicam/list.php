<?php
session_start();
require_once '../includes/koneksi.php';

$keyword = trim($_GET['keyword'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$per_page = 10;
$offset = ($page - 1) * $per_page;

if ($keyword !== '') {
    $count_stmt = $pdo->prepare('select count(*) from digicam where nama ilike :keyword or merek ilike :keyword or tipe ilike :keyword');
    $count_stmt->execute(['keyword' => '%' . $keyword . '%']);
    $total = (int)$count_stmt->fetchColumn();

    $stmt = $pdo->prepare('select id, nama, merek, tipe, harga_sewa, stok from digicam where nama ilike :keyword or merek ilike :keyword or tipe ilike :keyword order by id desc limit :limit offset :offset');
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
} else {
    $total = (int)$pdo->query('select count(*) from digicam')->fetchColumn();
    $stmt = $pdo->prepare('select id, nama, merek, tipe, harga_sewa, stok from digicam order by id desc limit :limit offset :offset');
}
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll();
$total_pages = max(1, (int)ceil($total / $per_page));
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Katalog Digicam - DIGIRENT</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<?php include '../includes/header.php'; ?>
<main class="container">
    <?php if (isset($_SESSION['pesan'])): ?><div class="alert alert-success"><?= htmlspecialchars($_SESSION['pesan']) ?></div><?php unset($_SESSION['pesan']); endif; ?>
    <?php if (isset($_SESSION['error'])): ?><div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div><?php unset($_SESSION['error']); endif; ?>
    <div class="table-card">
        <div class="table-header">
            <div><h2>Katalog Digicam</h2><p>CRUD lengkap dengan PostgreSQL, pencarian server-side, dan pagination.</p></div>
            <?php if (isset($_SESSION['user_id'])): ?><a href="tambah.php" class="btn-pink">+ Tambah Digicam</a><?php endif; ?>
        </div>
        <form method="get" class="search-form">
            <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari nama, merek, atau tipe digicam...">
            <button type="submit" class="btn-pink">Cari</button>
            <?php if ($keyword !== ''): ?><a href="list.php" class="btn-outline">Reset</a><?php endif; ?>
        </form>
        <div class="table-responsive"><table><thead><tr><th>No</th><th>Nama Digicam</th><th>Merek</th><th>Tipe</th><th>Harga Sewa/Hari</th><th>Stok</th><th>Aksi</th></tr></thead><tbody>
        <?php if ($data): $no = $offset + 1; foreach ($data as $row): ?>
            <tr><td><?= $no++ ?></td><td><?= htmlspecialchars($row['nama']) ?></td><td><?= htmlspecialchars($row['merek']) ?></td><td><?= htmlspecialchars($row['tipe']) ?></td><td>Rp <?= number_format((int)$row['harga_sewa'], 0, ',', '.') ?></td><td><?= (int)$row['stok'] ?></td><td class="actions">
                <?php if (isset($_SESSION['user_id'])): ?><a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn-action btn-edit">Edit</a><form action="hapus.php" method="post" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus digicam ini?');"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><button type="submit" class="btn-action btn-delete">Hapus</button></form><?php else: ?>-<?php endif; ?>
            </td></tr>
        <?php endforeach; else: ?><tr><td colspan="7" class="empty-state">Data digicam tidak ditemukan.</td></tr><?php endif; ?>
        </tbody></table></div>
        <?php if ($total_pages > 1): ?><div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?><a class="<?= $i === $page ? 'active' : '' ?>" href="?page=<?= $i ?>&keyword=<?= urlencode($keyword) ?>"><?= $i ?></a><?php endfor; ?>
        </div><?php endif; ?>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
</body></html>
