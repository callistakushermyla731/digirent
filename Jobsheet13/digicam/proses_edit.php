<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';
require_csrf('edit.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: list.php'); exit; }
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT); $nama = trim($_POST['nama'] ?? ''); $merek = trim($_POST['merek'] ?? ''); $tipe = trim($_POST['tipe'] ?? '');
if (strlen($nama) > 150 || strlen($merek) > 100 || strlen($tipe) > 100) { $_SESSION['error'] = 'Data teks terlalu panjang.'; header('Location: list.php'); exit; }
$harga = filter_input(INPUT_POST, 'harga_sewa', FILTER_VALIDATE_INT); $stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
if (!$id || $nama === '' || $merek === '' || $tipe === '' || $harga === false || $harga === null || $harga < 0 || $stok === false || $stok === null || $stok < 0) { $_SESSION['error']='Data edit digicam tidak valid.'; header('Location: list.php'); exit; }
try { $stmt = $pdo->prepare('update digicam set nama=:nama, merek=:merek, tipe=:tipe, harga_sewa=:harga, stok=:stok where id=:id'); $stmt->execute(['nama'=>$nama,'merek'=>$merek,'tipe'=>$tipe,'harga'=>$harga,'stok'=>$stok,'id'=>$id]); $_SESSION['pesan']=$stmt->rowCount() ? 'Data digicam berhasil diperbarui.' : 'Data digicam tidak berubah atau tidak ditemukan.'; } catch (PDOException $e) { $_SESSION['error']='Data digicam gagal diperbarui.'; }
header('Location: list.php'); exit;
