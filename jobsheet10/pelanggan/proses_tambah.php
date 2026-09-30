<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php'; if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location:list.php');exit;}
$nama=trim($_POST['nama']??'');$email=trim($_POST['email']??'');$no_hp=trim($_POST['no_hp']??'');$alamat=trim($_POST['alamat']??'');
if($nama===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||$no_hp===''||$alamat===''){$_SESSION['error']='Data pelanggan belum lengkap atau email tidak valid.';header('Location:tambah.php');exit;}
try{$stmt=$pdo->prepare('insert into pelanggan(nama,email,no_hp,alamat) values(:nama,:email,:no_hp,:alamat)');$stmt->execute(['nama'=>$nama,'email'=>$email,'no_hp'=>$no_hp,'alamat'=>$alamat]);$_SESSION['pesan']='Data pelanggan berhasil ditambahkan.';}catch(PDOException $e){$_SESSION['error']='Data pelanggan gagal ditambahkan.';}header('Location:list.php');exit;
