<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: list.php'); exit; }
$nama = trim($_POST['nama'] ?? ''); $merek = trim($_POST['merek'] ?? ''); $tipe = trim($_POST['tipe'] ?? '');
$harga = filter_input(INPUT_POST, 'harga_sewa', FILTER_VALIDATE_INT); $stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
if ($nama === '' || $merek === '' || $tipe === '' || $harga === false || $harga === null || $harga < 0 || $stok === false || $stok === null || $stok < 0) { $_SESSION['error'] = 'Data digicam belum lengkap atau tidak valid.'; header('Location: tambah.php'); exit; }
try { $stmt = $pdo->prepare('insert into digicam (nama, merek, tipe, harga_sewa, stok) values (:nama, :merek, :tipe, :harga, :stok)'); $stmt->execute(['nama'=>$nama,'merek'=>$merek,'tipe'=>$tipe,'harga'=>$harga,'stok'=>$stok]); $_SESSION['pesan']='Digicam berhasil ditambahkan.'; } catch (PDOException $e) { $_SESSION['error']='Digicam gagal ditambahkan.'; }
header('Location: list.php'); exit;
