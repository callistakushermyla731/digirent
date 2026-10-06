<?php
/**
 * Koneksi PostgreSQL untuk DIGIRENT.
 *
 * Lokal:
 *   gunakan default localhost/postgres atau isi DB_* di .env/server.
 * Production (Supabase):
 *   gunakan Shared Pooler - Session mode (port 5432) agar PDO prepared
 *   statements dan transaksi tetap didukung.
 */

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
            // Wajib false karena aplikasi menggunakan prepared statement.
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
}

try {
    $pdo = buat_pdo($host, $port, $dbname, $user, $password, $sslmode);

    // Untuk instalasi baru, tabel aplikasi dibuat otomatis.
    // Pada Supabase, struktur final juga tersedia di sql/supabase_schema.sql
    // dan dapat dijalankan melalui SQL Editor.
    $pdo->exec(<<<SQL
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
            role varchar(30) not null default 'petugas'
                check (role in ('petugas', 'admin'))
        );

        create table if not exists peminjaman (
            id serial primary key,
            digicam_id integer not null references digicam(id),
            pelanggan_id integer not null references pelanggan(id),
            tanggal_pinjam date not null default current_date,
            tanggal_kembali date null,
            status varchar(20) not null default 'dipinjam'
                check (status in ('dipinjam', 'dikembalikan'))
        );

        create index if not exists idx_peminjaman_pelanggan
            on peminjaman (pelanggan_id);
        create index if not exists idx_peminjaman_digicam
            on peminjaman (digicam_id);
        create index if not exists idx_peminjaman_status
            on peminjaman (status);
    SQL);

    // Data awal hanya dibuat jika tabel masih kosong.
    if ((int)$pdo->query('select count(*) from digicam')->fetchColumn() === 0) {
        $stmt = $pdo->prepare(
            'insert into digicam (nama, merek, tipe, harga_sewa, stok)
             values (:nama, :merek, :tipe, :harga, :stok)'
        );

        foreach ([
            ['Canon IXUS 185', 'Canon', 'Compact Camera', 75000, 3],
            ['Sony Cyber-shot DSC-W830', 'Sony', 'Compact Camera', 80000, 2],
            ['Fujifilm FinePix JX500', 'Fujifilm', 'Compact Camera', 70000, 4],
        ] as $row) {
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
            'insert into pelanggan (nama, email, no_hp, alamat)
             values (:nama, :email, :no_hp, :alamat)'
        );

        foreach ([
            ['Callista', 'callista@gmail.com', '081234567890', 'Malang'],
            ['Dimas', 'dimas@gmail.com', '082345678901', 'Blitar'],
        ] as $row) {
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

    // Jangan tampilkan detail exception database di production.
    $is_local = in_array($host, ['localhost', '127.0.0.1'], true);
    $detail = $is_local ? '<p><small>' . htmlspecialchars($e->getMessage()) . '</small></p>' : '';

    die(
        '<!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>DIGIRENT - Koneksi Database</title>
            <style>
                body { font-family: Arial, sans-serif; background: #fff5f8; padding: 40px; color: #333; }
                .box { max-width: 760px; margin: auto; background: #fff; padding: 30px; border-radius: 18px; box-shadow: 0 8px 30px #0001; }
                h2 { color: #d63384; }
                code { background: #f2f2f2; padding: 3px 7px; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class="box">
                <h2>DIGIRENT belum terhubung ke PostgreSQL</h2>
                <p>Server PHP sudah berjalan, tetapi PostgreSQL belum dapat diakses.</p>
                <p>Periksa Environment Variables <code>DB_HOST</code>, <code>DB_PORT</code>, <code>DB_NAME</code>, <code>DB_USER</code>, <code>DB_PASSWORD</code>, dan <code>DB_SSLMODE</code>.</p>
                ' . $detail . '
            </div>
        </body>
        </html>'
    );
}
?>
