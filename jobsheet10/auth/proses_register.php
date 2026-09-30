<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

require_once '../includes/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($nama === '' || $username === '' || $password === '') {
    $_SESSION['error'] = 'Semua data wajib diisi.';
    header('Location: register.php');
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = 'Password minimal 6 karakter.';
    header('Location: register.php');
    exit;
}

try {
    $cek = $pdo->prepare('select id from users where username = :username limit 1');
    $cek->execute(['username' => $username]);

    if ($cek->fetch()) {
        $_SESSION['error'] = 'Username sudah digunakan.';
        header('Location: register.php');
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        'insert into users (nama, username, password, role)
         values (:nama, :username, :password, :role)'
    );

    $stmt->execute([
        'nama' => $nama,
        'username' => $username,
        'password' => $password_hash,
        'role' => 'petugas'
    ]);

    $_SESSION['pesan'] = 'Registrasi berhasil. Silakan login.';
    header('Location: login.php');
    exit;
} catch (PDOException $e) {
    $_SESSION['error'] = 'Registrasi gagal. Silakan coba lagi.';
    header('Location: register.php');
    exit;
}
