<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

// Ambil keyword pencarian jika ada
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Query data pelanggan dengan pencarian server-side
if (!empty($search)) {
    $query = "SELECT * FROM pelanggan 
              WHERE nama ILIKE $1 OR email ILIKE $1 OR no_hp ILIKE $1 OR alamat ILIKE $1 
              ORDER BY id ASC";
    $result = pg_query_params($conn, $query, ['%' . $search . '%']);
} else {
    $query = "SELECT * FROM pelanggan ORDER BY id ASC";
    $result = pg_query($conn, $query);
}

include '../includes/header.php';
?>

<div class="card card-custom">
    <div class="card-body">
        <!-- Header & Tombol Tambah Pelanggan -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-pink mb-1">Daftar Pelanggan</h3>
                <p class="text-muted mb-0">CRUD lengkap dengan PostgreSQL, pencarian server-side, dan pagination.</p>
            </div>
            <a href="tambah.php" class="btn btn-pink text-white rounded-pill px-4 fw-semibold">
                + Tambah Pelanggan
            </a>
        </div>

        <!-- Form Pencarian (Search Bar) -->
        <form method="GET" action="list.php" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control rounded-start-pill border-end-0 ps-3" 
                       placeholder="Cari nama, email, no hp, atau alamat..." 
                       value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-pink text-white rounded-end-pill px-4 fw-semibold">
                    Cari
                </button>
            </div>
        </form>

        <!-- Tabel Daftar Pelanggan -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-uppercase small text-muted">
                    <tr>
                        <th scope="col" width="5%">NO</th>
                        <th scope="col">NAMA</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">NO. HP</th>
                        <th scope="col">ALAMAT</th>
                        <th scope="col" class="text-center" width="15%">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (pg_num_rows($result) > 0): ?>
                        <?php $no = 1; while ($row = pg_fetch_assoc($result)): ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td class="fw-medium"><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                                <td><?= htmlspecialchars($row['alamat']) ?></td>
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <a href="edit.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                       Edit
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <a href="hapus.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-pink-light text-pink rounded-pill px-3" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
                                       Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Data pelanggan tidak ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
