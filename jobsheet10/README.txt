DIGIRENT - JOBSHEET 10

AUTENTIKASI & MANAJEMEN SESI

DATABASE:
- PostgreSQL
- host: localhost
- port: 5432
- user: postgres
- password project: postgres
- database: digirent

PERSIAPAN DATABASE:
Jalankan skema tambahan:
psql -d digirent -f sql/02_users.sql

Tabel users:
- id
- nama
- username
- password
- role

AUTENTIKASI:
- Register membuat akun petugas baru.
- Password disimpan menggunakan password_hash().
- Username dicek agar tidak duplikat.
- Login menggunakan password_verify().
- Session menyimpan user_id, nama, username, dan role.
- Logout menggunakan session_destroy().
- includes/auth.php menjadi guard untuk halaman yang membutuhkan login.

HALAMAN PUBLIK:
- index.php
- digicam/list.php

HALAMAN YANG MEMBUTUHKAN LOGIN:
- digicam/tambah.php
- digicam/edit.php
- digicam/proses_tambah.php
- digicam/proses_edit.php
- digicam/hapus.php
- seluruh halaman pelanggan/*

AUTENTIKASI:
- auth/register.php
- auth/proses_register.php
- auth/login.php
- auth/proses_login.php
- auth/logout.php

FITUR JOBSHEET 10:
- Autentikasi pengguna berbasis database PostgreSQL
- Password hashing dengan password_hash()
- Verifikasi password dengan password_verify()
- Validasi username duplikat
- Manajemen session pengguna
- Guard clause untuk halaman yang dikunci
- Navbar menampilkan nama petugas dan Logout saat login
- Navbar menampilkan Login saat belum login
- CRUD digicam dan pelanggan dari Jobsheet 9 tetap tersedia

DEPLOYMENT SUPABASE + DOCKER

Koneksi database menggunakan Environment Variables:
DB_HOST
DB_PORT
DB_NAME
DB_USER
DB_PASSWORD
DB_SSLMODE

Untuk Supabase, gunakan kredensial PostgreSQL dari project Supabase. Jangan memasukkan password database asli ke source code atau Git repository.

Dockerfile menggunakan PHP 8.2 Apache, ekstensi pdo_pgsql, Apache port 8080, dan menjalankan apache2-foreground.

Pada platform hosting, isi Environment Variables tersebut dan gunakan port 8080 untuk container.
