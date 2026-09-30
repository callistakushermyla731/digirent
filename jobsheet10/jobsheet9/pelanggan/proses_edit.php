<?php
session_start();
if(!isset($_SESSION['login'])||$_SESSION['login']!==true){$_SESSION['error']='Silakan login terlebih dahulu.';header('Location:../login.php');exit;}
require_once '../includes/koneksi.php';if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location:list.php');exit;}
$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);$nama=trim($_POST['nama']??'');$email=trim($_POST['email']??'');$no_hp=trim($_POST['no_hp']??'');$alamat=trim($_POST['alamat']??'');
if(!$id||$nama===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||$no_hp===''||$alamat===''){$_SESSION['error']='Data edit pelanggan tidak valid.';header('Location:list.php');exit;}
try{$stmt=$pdo->prepare('update pelanggan set nama=:nama,email=:email,no_hp=:no_hp,alamat=:alamat where id=:id');$stmt->execute(['nama'=>$nama,'email'=>$email,'no_hp'=>$no_hp,'alamat'=>$alamat,'id'=>$id]);$_SESSION['pesan']=$stmt->rowCount()?'Data pelanggan berhasil diperbarui.':'Data pelanggan tidak berubah atau tidak ditemukan.';}catch(PDOException $e){$_SESSION['error']='Data pelanggan gagal diperbarui.';}header('Location:list.php');exit;
