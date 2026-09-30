<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: list.php");
    exit;
}

$query = "SELECT * FROM digicam WHERE id = $1";
$result = pg_query_params($conn, $query, [$id]);
$data = pg_fetch_assoc($result);

if (!$data) {
    header("Location: list.php");
    exit;
}

include '../includes/header.php';
?>

<div class="card card-custom">
    <div class="card-body p-4">
        <h3 class="fw-bold text-pink mb-4">Edit Data Digicam</h3>

        <form action="proses_edit.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">

            <div class="row g-3">
                <!-- Nama Digicam -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Digicam</label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                </div>

                <!-- Merek -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Merek</label>
                    <input type="text" name="merek" class="form-control" value="<?= htmlspecialchars($data['merek']) ?>" required>
                </div>

                <!-- Tipe -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tipe</label>
                    <input type="text" name="tipe" class="form-control" value="<?= htmlspecialchars($data['tipe']) ?>" required>
                </div>

                <!-- Harga Sewa per Hari -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Harga Sewa per Hari</label>
                    <input type="number" name="harga_sewa" class="form-control" value="<?= htmlspecialchars($data['harga_sewa']) ?>" required>
                </div>

                <!-- Stok -->
                <div class="col-12 mb-4">
                    <label class="form-label fw-semibold">Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($data['stok']) ?>" required>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-pink text-white rounded-pill px-4 fw-semibold">
                    Update
                </button>
                <a href="list.php" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
