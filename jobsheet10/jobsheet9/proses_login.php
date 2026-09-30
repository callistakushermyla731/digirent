<?php
session_start();

$username_benar = "admindigirent123@gmail.com";
$password_benar = "12345678";

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if ($email === $username_benar && $password === $password_benar) {
    session_regenerate_id(true);
    $_SESSION["login"] = true;
    $_SESSION["email"] = $email;
    $_SESSION["pesan"] = "Login berhasil. Hallo " . $email . "!";
    header("Location: index.php");
    exit;
}

$_SESSION["error"] = "Username atau password salah.";
header("Location: login.php");
exit;
