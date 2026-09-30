<?php
/*
 * Koneksi PostgreSQL DIGIRENT
 * Bisa digunakan untuk PostgreSQL lokal maupun Supabase/Render.
 */

// Ambil konfigurasi dari Environment Variable.
// Kalau dijalankan lokal, gunakan nilai default.
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'digirent';
$user = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: 'postgres';
$sslmode = getenv('DB_SSLMODE') ?: '';

function buat_pdo(
    string $host,
    string $port,
    string $dbname,
    string $user,
    string $password,
    string $sslmode = ''
): PDO {
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

    if ($sslmode !== '') {
        $dsn .= ";sslmode={$sslmode}";
    }

    return new PDO(
        $dsn,
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
}

try {
    $pdo = buat_pdo(
        $host,
        $port,
        $dbname,
        $user,
        $password,
        $sslmode
    );

    $pdo->exec('
        create table if not exists digicam (
            id serial primary key,
            nama varchar(150) not null,
            merek varchar(100) not null,
            tipe varchar(100) not null,
            harga_sewa integer not null check (harga_sewa >= 0),
            stok integer not null check (stok >= 0)
        );

        create table if not exists pelanggan (
            id serial primary key,
            nama varchar(150) not null,
            email varchar(150) not null,
            no_hp varchar(30) not null,
            alamat text not null
        );

        create table if not exists users (
            id serial primary key,
            nama varchar(150) not null,
            username varchar(100) not null unique,
            password varchar(255) not null,
            role varchar(30) not null default \'petugas\'
        );
    ');

    if ((int)$pdo->query('select count(*) from digicam')->fetchColumn() === 0) {
        $stmt = $pdo->prepare(
            'insert into digicam
            (nama, merek, tipe, harga_sewa, stok)
            values (:nama, :merek, :tipe, :harga, :stok)'
        );

        $data = [
            ['Canon IXUS 185', 'Canon', 'Compact Camera', 75000, 3],
            ['Sony Cyber-shot DSC-W830', 'Sony', 'Compact Camera', 80000, 2],
            ['Fujifilm FinePix JX500', 'Fujifilm', 'Compact Camera', 70000, 4],
        ];

        foreach ($data as $row) {
            $stmt->execute([
                'nama' => $row[0],
                'merek' => $row[1],
                'tipe' => $row[2],
                'harga' => $row[3],
                'stok' => $row[4]
            ]);
        }
    }

    if ((int)$pdo->query('select count(*) from pelanggan')->fetchColumn() === 0) {
        $stmt = $pdo->prepare(
            'insert into pelanggan
            (nama, email, no_hp, alamat)
            values (:nama, :email, :no_hp, :alamat)'
        );

        $data = [
            ['Callista', 'callista@gmail.com', '081234567890', 'Malang'],
            ['Dimas', 'dimas@gmail.com', '082345678901', 'Blitar'],
        ];

        foreach ($data as $row) {
            $stmt->execute([
                'nama' => $row[0],
                'email' => $row[1],
                'no_hp' => $row[2],
                'alamat' => $row[3]
            ]);
        }
    }

} catch (PDOException $e) {
    http_response_code(500);

    die(
        '<!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>DIGIRENT</title>
            <style>
                body { font-family: Arial; background: #fff5f8; padding: 40px; color: #333; }
                .box { max-width: 760px; margin: auto; background: #fff; padding: 30px; border-radius: 18px; box-shadow: 0 8px 30px #0001; }
                h2 { color: #d63384; }
                code { background: #f2f2f2; padding: 3px 7px; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class="box">
                <h2>DIGIRENT belum terhubung ke PostgreSQL</h2>
                <p>Server PHP sudah berjalan, tetapi PostgreSQL belum dapat diakses.</p>
                <p>Periksa kembali Environment Variables pada server.</p>
            </div>
        </body>
        </html>'
    );
}
?>
