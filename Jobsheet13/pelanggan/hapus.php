<?php
require_once '../includes/auth.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){$_SESSION['error']='Penghapusan harus menggunakan POST.';header('Location:list.php');exit;}
require_once '../includes/koneksi.php';
require_csrf('list.php');$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);if(!$id){$_SESSION['error']='ID pelanggan tidak valid.';header('Location:list.php');exit;}
try{$stmt=$pdo->prepare('delete from pelanggan where id=:id');$stmt->execute(['id'=>$id]);$_SESSION['pesan']=$stmt->rowCount()?'Data pelanggan berhasil dihapus.':'Data pelanggan tidak ditemukan.';}catch(PDOException $e){$_SESSION['error']='Data pelanggan gagal dihapus.';}header('Location:list.php');exit;
