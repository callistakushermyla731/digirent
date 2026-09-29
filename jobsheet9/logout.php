<?php
session_start();
$_SESSION = [];
session_destroy();

session_start();
$_SESSION["pesan"] = "Berhasil logout.";
header("Location: index.php");
exit;
