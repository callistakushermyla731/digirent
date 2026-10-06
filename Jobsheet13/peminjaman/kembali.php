<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Pengembalian harus menggunakan POST.';
    header('Location: riwayat.php');
    exit;
}

require_csrf('riwayat.php');
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['error'] = 'ID peminjaman tidak valid.';
    header('Location: riwayat.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        "select id, digicam_id
         from peminjaman
         where id = :id and status = 'dipinjam'
         for update"
    );
    $stmt->execute(['id' => $id]);
    $pinjam = $stmt->fetch();

    if (!$pinjam) {
        throw new RuntimeException('Data peminjaman tidak ditemukan atau sudah dikembalikan.');
    }

    $stmt = $pdo->prepare('select id from digicam where id = :id for update');
    $stmt->execute(['id' => $pinjam['digicam_id']]);
    if (!$stmt->fetch()) {
        throw new RuntimeException('Digicam terkait tidak ditemukan.');
    }

    $stmt = $pdo->prepare(
        "update peminjaman
         set status = 'dikembalikan', tanggal_kembali = current_date
         where id = :id and status = 'dipinjam'"
    );
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() !== 1) {
        throw new RuntimeException('Status peminjaman gagal diperbarui.');
    }

    $stmt = $pdo->prepare('update digicam set stok = stok + 1 where id = :id');
    $stmt->execute(['id' => $pinjam['digicam_id']]);

    $pdo->commit();
    $_SESSION['pesan'] = 'Digicam berhasil dikembalikan dan stok bertambah 1.';
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['error'] = $e instanceof RuntimeException
        ? $e->getMessage()
        : 'Pengembalian gagal diproses. Silakan coba lagi.';
}

header('Location: riwayat.php');
exit;
