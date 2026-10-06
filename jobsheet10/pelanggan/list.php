<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

$search = trim($_GET['search'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$per_page = 10;
$offset = ($page - 1) * $per_page;

$where = '';
$params = [];

if ($search !== '') {
    $where = "where nama ilike :search or email ilike :search or no_hp ilike :search or alamat ilike :search";
    $params['search'] = '%' . $search . '%';
}

$count_stmt = $pdo->prepare("select count(*) from pelanggan $where");
foreach ($params as $key => $value) {
    $count_stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
}
$count_stmt->execute();
$total = (int)$count_stmt->fetchColumn();

$query = "select id, nama, email, no_hp, alamat
          from pelanggan
          $where
          order by id asc
          limit :limit offset :offset";

$stmt = $pdo->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll();

$total_pages = max(1, (int)ceil($total / $per_page));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan - DIGIRENT</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<main class="container">

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['pesan']) ?>
        </div>
        <?php unset($_SESSION['pesan']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="table-card">
        <div class="table-header">
            <div>
                <h2>Daftar Pelanggan</h2>
                <p>Kelola data pelanggan, pencarian server-side, dan pagination.</p>
            </div>
            <a href="tambah.php" class="btn-pink">+ Tambah Pelanggan</a>
        </div>

        <form method="get" action="list.php" class="search-form">
            <input
                type="text"
                name="search"
                value="<?= htmlspecialchars($search) ?>"
                placeholder="Cari nama, email, no hp, atau alamat..."
            >
            <button type="submit" class="btn-pink">Cari</button>
            <?php if ($search !== ''): ?>
                <a href="list.php" class="btn-outline">Reset</a>
            <?php endif; ?>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($data): ?>
                        <?php $no = $offset + 1; ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                                <td><?= htmlspecialchars($row['alamat']) ?></td>
                                <td class="actions">
                                    <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn-action btn-edit">Edit</a>

                                    <form action="hapus.php" method="post" class="inline-form"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');">
                                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                        <button type="submit" class="btn-action btn-delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="empty-state">Data pelanggan tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a
                        class="<?= $i === $page ? 'active' : '' ?>"
                        href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"
                    >
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>

</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>
