<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';
require_csrf('tambah.php'); if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location:list.php');exit;}
$nama=trim($_POST['nama']??'');$email=trim($_POST['email']??'');$no_hp=trim($_POST['no_hp']??'');$alamat=trim($_POST['alamat']??'');
if($nama===''||strlen($nama)>150||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($email)>150||$no_hp===''||strlen($no_hp)>30||$alamat===''||strlen($alamat)>1000){$_SESSION['error']='Data pelanggan belum lengkap atau email tidak valid.';header('Location:tambah.php');exit;}
try{$stmt=$pdo->prepare('insert into pelanggan(nama,email,no_hp,alamat) values(:nama,:email,:no_hp,:alamat)');$stmt->execute(['nama'=>$nama,'email'=>$email,'no_hp'=>$no_hp,'alamat'=>$alamat]);$_SESSION['pesan']='Data pelanggan berhasil ditambahkan.';}catch(PDOException $e){$_SESSION['error']='Data pelanggan gagal ditambahkan.';}header('Location:list.php');exit;
