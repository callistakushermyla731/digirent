<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

require_csrf('tambah.php');

$pelanggan_id = filter_input(INPUT_POST, 'pelanggan_id', FILTER_VALIDATE_INT);
$digicam_id = filter_input(INPUT_POST, 'digicam_id', FILTER_VALIDATE_INT);

if (!$pelanggan_id || !$digicam_id) {
    $_SESSION['error'] = 'Pelanggan dan digicam wajib dipilih.';
    header('Location: tambah.php');
    exit;
}

$_SESSION['form_peminjaman'] = [
    'pelanggan_id' => $pelanggan_id,
    'digicam_id' => $digicam_id
];

try {
    // Validasi pelanggan masih ada.
    $stmt = $pdo->prepare('select id from pelanggan where id = :id');
    $stmt->execute(['id' => $pelanggan_id]);
    if (!$stmt->fetch()) {
        throw new RuntimeException('Pelanggan tidak ditemukan.');
    }

    // Validasi bisnis: peminjaman aktif yang sudah lewat 14 hari memblokir peminjaman baru.
    $stmt = $pdo->prepare(
        "select count(*)
         from peminjaman
         where pelanggan_id = :pelanggan_id
           and status = 'dipinjam'
           and tanggal_pinjam < current_date - interval '14 days'"
    );
    $stmt->execute(['pelanggan_id' => $pelanggan_id]);
    if ((int)$stmt->fetchColumn() > 0) {
        throw new RuntimeException('Pelanggan memiliki peminjaman yang terlambat lebih dari 14 hari dan belum dikembalikan.');
    }

    $pdo->beginTransaction();

    // Kunci baris digicam agar stok tidak minus ketika dua transaksi terjadi bersamaan.
    $stmt = $pdo->prepare(
        'select id, stok from digicam where id = :id for update'
    );
    $stmt->execute(['id' => $digicam_id]);
    $kamera = $stmt->fetch();

    if (!$kamera) {
        throw new RuntimeException('Digicam tidak ditemukan.');
    }

    if ((int)$kamera['stok'] <= 0) {
        throw new RuntimeException('Stok digicam sudah habis. Silakan pilih digicam lain.');
    }

    $stmt = $pdo->prepare(
        "insert into peminjaman
         (digicam_id, pelanggan_id, tanggal_pinjam, tanggal_kembali, status)
         values (:digicam_id, :pelanggan_id, current_date, null, 'dipinjam')"
    );
    $stmt->execute([
        'digicam_id' => $digicam_id,
        'pelanggan_id' => $pelanggan_id
    ]);

    $stmt = $pdo->prepare(
        'update digicam set stok = stok - 1 where id = :id and stok > 0'
    );
    $stmt->execute(['id' => $digicam_id]);

    if ($stmt->rowCount() !== 1) {
        throw new RuntimeException('Stok digicam gagal diperbarui.');
    }

    $pdo->commit();
    unset($_SESSION['form_peminjaman']);
    $_SESSION['pesan'] = 'Peminjaman berhasil disimpan dan stok digicam berkurang 1.';
    header('Location: riwayat.php');
    exit;
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['error'] = $e instanceof RuntimeException
        ? $e->getMessage()
        : 'Peminjaman gagal disimpan. Silakan coba lagi.';
    header('Location: tambah.php');
    exit;
}
