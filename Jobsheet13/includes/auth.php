<?php
require_once __DIR__ . '/csrf.php';

if (!isset($_SESSION['user_id'])) {
    $folder = basename(dirname($_SERVER['SCRIPT_FILENAME']));
    $base = in_array($folder, ['digicam', 'pelanggan', 'diagram']) ? '../' : '';
    header('Location: ' . $base . 'auth/login.php');
    exit;
}
