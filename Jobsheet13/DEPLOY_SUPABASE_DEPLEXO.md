# Deployment DIGIRENT — Supabase + Deplexo

Dokumen ini adalah panduan praktis deployment Jobsheet 13.

## A. Supabase

### A1. Buat project

Buat satu project PostgreSQL di Supabase.

### A2. Jalankan database

1. Buka **SQL Editor**.
2. Buka file `sql/supabase_schema.sql` dari project ini.
3. Copy seluruh isinya ke SQL Editor.
4. Jalankan.
5. Pastikan tabel `digicam`, `pelanggan`, `users`, dan `peminjaman` muncul pada Table Editor.

### A3. Ambil koneksi

Klik **Connect** pada project Supabase dan pilih **Session pooler**. Untuk backend PHP yang memakai PDO prepared statements dan transaksi, project ini menggunakan mode session pada port 5432.

Catat:

```text
DB_HOST
DB_PORT
DB_NAME
DB_USER
DB_PASSWORD
```

Gunakan `DB_SSLMODE=require`.

## B. GitHub

Struktur repository harus langsung berisi file aplikasi, misalnya:

```text
Jobsheet13/
├── Dockerfile
├── deplexo.yaml
├── docker-entrypoint.sh
├── index.php
├── auth/
├── digicam/
├── pelanggan/
├── peminjaman/
├── includes/
└── sql/
```

Jangan upload `.env` atau password Supabase.

## C. Deplexo

1. Buka Deplexo.
2. Pilih repository GitHub project.
3. Jika project ada dalam subfolder repository, isi **Root Directory** dengan folder project tersebut.
4. Pilih Dockerfile sebagai build method.
5. Gunakan `Dockerfile`.
6. Set Environment Variables:

```text
PORT=8080
DB_HOST=host_dari_supabase
DB_PORT=5432
DB_NAME=postgres
DB_USER=postgres.PROJECT_REF
DB_PASSWORD=password_supabase
DB_SSLMODE=require
```

7. Deploy.
8. Tunggu build selesai.
9. Jika aplikasi tidak dapat diakses, cek **Runtime Logs** dan pastikan Apache berjalan pada `PORT` yang diberikan Deplexo.

## D. Pengujian setelah deploy

### Database

- Login berhasil.
- Data digicam tampil.
- Data pelanggan tampil.
- Tambah/edit/hapus bekerja.

### Peminjaman

- Buat transaksi.
- Stok turun 1.
- Riwayat bertambah.

### Pengembalian

- Klik Kembalikan.
- Status berubah.
- Tanggal kembali terisi.
- Stok naik 1.

### Keamanan

- URL CRUD tanpa login diarahkan ke login.
- Form POST memiliki CSRF.
- Delete tidak menggunakan GET.
- Password tidak disimpan plaintext.
- Password/database credential tidak berada di source code production.

## E. Jika Deplexo gagal startup

Periksa tiga hal paling awal:

1. `PORT` di environment = `8080`.
2. Dockerfile memakai `docker-entrypoint.sh` sehingga Apache mengikuti `PORT`.
3. `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`, dan `DB_SSLMODE` benar.

Jangan mengganti host Supabase dengan `localhost` pada deployment. `localhost` di container Deplexo menunjuk ke container aplikasi, bukan database Supabase.
