<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

include '../includes/header.php';
?>

<div class="card card-custom">
    <div class="card-body p-4">
        <h3 class="fw-bold text-pink mb-4">Tambah Pelanggan</h3>

        <form action="proses_tambah.php" method="POST">
            <div class="row g-3">
                <!-- Nama -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama pelanggan" required>
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>

                <!-- No. HP -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="Masukkan nomor HP" required>
                </div>

                <!-- Alamat -->
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Alamat</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat" required>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-pink text-white rounded-pill px-4 fw-semibold">
                    Simpan
                </button>
                <a href="list.php" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
