<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) { $_SESSION['error'] = 'Silakan login terlebih dahulu.'; header('Location: ../login.php'); exit; }
require_once '../includes/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: list.php'); exit; }
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT); $nama = trim($_POST['nama'] ?? ''); $merek = trim($_POST['merek'] ?? ''); $tipe = trim($_POST['tipe'] ?? '');
$harga = filter_input(INPUT_POST, 'harga_sewa', FILTER_VALIDATE_INT); $stok = filter_input(INPUT_POST, 'stok', FILTER_VALIDATE_INT);
if (!$id || $nama === '' || $merek === '' || $tipe === '' || $harga === false || $harga === null || $harga < 0 || $stok === false || $stok === null || $stok < 0) { $_SESSION['error']='Data edit digicam tidak valid.'; header('Location: list.php'); exit; }
try { $stmt = $pdo->prepare('update digicam set nama=:nama, merek=:merek, tipe=:tipe, harga_sewa=:harga, stok=:stok where id=:id'); $stmt->execute(['nama'=>$nama,'merek'=>$merek,'tipe'=>$tipe,'harga'=>$harga,'stok'=>$stok,'id'=>$id]); $_SESSION['pesan']=$stmt->rowCount() ? 'Data digicam berhasil diperbarui.' : 'Data digicam tidak berubah atau tidak ditemukan.'; } catch (PDOException $e) { $_SESSION['error']='Data digicam gagal diperbarui.'; }
header('Location: list.php'); exit;
