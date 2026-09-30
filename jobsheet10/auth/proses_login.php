<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

require_once '../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['error'] = 'Username dan password wajib diisi.';
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare(
    'select id, nama, username, password, role
     from users
     where username = :username
     limit 1'
);
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);

    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['pesan'] = 'Login berhasil. Selamat datang, ' . $user['nama'] . '.';

    header('Location: ../index.php');
    exit;
}

$_SESSION['error'] = 'Username atau password salah.';
header('Location: login.php');
exit;
