<?php
session_start();
if(!isset($_SESSION['login'])||$_SESSION['login']!==true){$_SESSION['error']='Silakan login terlebih dahulu.';header('Location:../login.php');exit;}
if($_SERVER['REQUEST_METHOD']!=='POST'){$_SESSION['error']='Penghapusan harus menggunakan POST.';header('Location:list.php');exit;}
require_once '../includes/koneksi.php';$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);if(!$id){$_SESSION['error']='ID pelanggan tidak valid.';header('Location:list.php');exit;}
try{$stmt=$pdo->prepare('delete from pelanggan where id=:id');$stmt->execute(['id'=>$id]);$_SESSION['pesan']=$stmt->rowCount()?'Data pelanggan berhasil dihapus.':'Data pelanggan tidak ditemukan.';}catch(PDOException $e){$_SESSION['error']='Data pelanggan gagal dihapus.';}header('Location:list.php');exit;
