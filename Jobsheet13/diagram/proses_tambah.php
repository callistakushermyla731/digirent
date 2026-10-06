<?php
require_once '../includes/csrf.php';

require_once '../includes/auth.php';

require_once "../includes/koneksi.php";
require_once '../includes/diagram_data.php';

if (isset($_POST['hapus'])) {
    require_csrf('list.php');
    $id = filter_input(INPUT_POST, 'hapus', FILTER_VALIDATE_INT);

    if (!$id) {
        $_SESSION["error"] = "ID diagram tidak valid.";
        header("Location: list.php");
        exit;
    }

    $data = baca_data('diagram');
    $baru = [];
    $ditemukan = false;

    foreach ($data as $row) {
        if ((int)$row['id'] === $id) {
            $ditemukan = true;
            continue;
        }
        $baru[] = $row;
    }

    if ($ditemukan && simpan_data('diagram', $baru)) {
        $_SESSION["pesan"] = "Data diagram berhasil dihapus.";
    } else {
        $_SESSION["error"] = "Data diagram tidak ditemukan atau gagal dihapus.";
    }

    header("Location: list.php");
    exit;
}

if (isset($_POST['simpan'])) {
    require_csrf('tambah.php');
    $nama = trim($_POST["nama"] ?? "");
    $keterangan = trim($_POST["keterangan"] ?? "");

    if ($nama === '' || $keterangan === '' || strlen($nama) > 150 || strlen($keterangan) > 1000) {
        $_SESSION["error"] = "Semua data diagram wajib diisi.";
        header("Location: tambah.php");
        exit;
    }

    $data = baca_data('diagram');
    $data[] = [
        'id' => id_baru($data),
        'nama' => $nama,
        'keterangan' => $keterangan
    ];

    if (simpan_data('diagram', $data)) {
        $_SESSION["pesan"] = "Data diagram berhasil ditambahkan.";
    } else {
        $_SESSION["error"] = "Data diagram gagal ditambahkan.";
    }

    header("Location: list.php");
    exit;
}

if (isset($_POST['update'])) {
    require_csrf('tambah.php');
    $id = (int)($_POST["id"] ?? 0);
    $nama = trim($_POST["nama"] ?? "");
    $keterangan = trim($_POST["keterangan"] ?? "");

    if ($id <= 0 || $nama === '' || $keterangan === '') {
        $_SESSION["error"] = "Data diagram belum lengkap.";
        header("Location: list.php");
        exit;
    }

    $data = baca_data('diagram');
    $ditemukan = false;

    foreach ($data as &$row) {
        if ((int)$row['id'] === $id) {
            $row['nama'] = $nama;
            $row['keterangan'] = $keterangan;
            $ditemukan = true;
            break;
        }
    }
    unset($row);

    if ($ditemukan && simpan_data('diagram', $data)) {
        $_SESSION["pesan"] = "Data diagram berhasil diubah.";
    } else {
        $_SESSION["error"] = "Data diagram gagal diubah.";
    }

    header("Location: list.php");
    exit;
}

header("Location: list.php");
exit;
?>
