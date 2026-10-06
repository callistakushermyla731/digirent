# Jobsheet 13 — Deployment & Dokumentasi DIGIRENT

## 1. Deskripsi aplikasi

DIGIRENT adalah aplikasi web rental digicam berbasis PHP native dan PostgreSQL. Proyek ini merupakan gabungan dan kelanjutan Jobsheet 1–12: struktur UI, CSS responsif, JavaScript, pengolahan form PHP, PostgreSQL, CRUD, autentikasi/session, hardening keamanan, serta modul peminjaman dan pengembalian.

## 2. Fitur akhir

- Login, register, logout, dan session.
- CRUD data digicam.
- CRUD data pelanggan.
- Peminjaman digicam.
- Pengembalian digicam.
- Riwayat peminjaman.
- Pengurangan stok saat peminjaman.
- Penambahan stok saat pengembalian.
- Validasi pelanggan yang memiliki peminjaman terlambat >14 hari.
- Dashboard dengan statistik database real-time.
- Prepared statement, CSRF token, XSS escaping, validasi input, dan session regeneration.

## 3. Struktur database final

Entitas utama:

- `digicam`
- `pelanggan`
- `users`
- `peminjaman`

Relasi:

- `peminjaman.digicam_id` → `digicam.id`
- `peminjaman.pelanggan_id` → `pelanggan.id`

SQL final untuk Supabase ada di `sql/supabase_schema.sql`.

## 4. Instalasi lokal

1. Pastikan PHP 8.2+, PostgreSQL, dan ekstensi `pdo_pgsql` tersedia.
2. Buat database `digirent`.
3. Jalankan `sql/supabase_schema.sql` atau struktur dari `database.sql`.
4. Salin `.env.example` menjadi `.env` jika environment lokal kamu menggunakan loader sendiri, atau set variabel `DB_*` di environment PHP.
5. Jalankan dari root project:

```bash
php -S localhost:8000
```

6. Buka `http://localhost:8000/`.
7. Buat akun melalui menu Register, lalu Login.

## 5. Supabase

Untuk deployment di Deplexo, gunakan PostgreSQL milik Supabase. Dari Supabase Dashboard pilih **Connect → Session pooler**. Gunakan host, username, port, database, dan password yang diberikan Supabase.

Environment production:

```text
DB_HOST=...pooler.supabase.com
DB_PORT=5432
DB_NAME=postgres
DB_USER=postgres.PROJECT_REF
DB_PASSWORD=PASSWORD_SUPABASE
DB_SSLMODE=require
```

Jalankan `sql/supabase_schema.sql` terlebih dahulu di Supabase SQL Editor.

## 6. Deploy ke Deplexo

Project sudah dilengkapi:

- `Dockerfile`
- `docker-entrypoint.sh`
- `deplexo.yaml`
- `.dockerignore`
- `.env.example`

Di Deplexo:

1. Push folder `Jobsheet13` ke repository GitHub.
2. Deploy repository tersebut.
3. Jika repository berisi project ini di root, gunakan root directory project tersebut.
4. Pilih build method **Dockerfile**.
5. Pastikan Dockerfile = `Dockerfile`.
6. Set environment variable:
   - `PORT=8080`
   - `DB_HOST`
   - `DB_PORT=5432`
   - `DB_NAME=postgres`
   - `DB_USER=postgres.PROJECT_REF`
   - `DB_PASSWORD=...`
   - `DB_SSLMODE=require`
7. Deploy.
8. Cek build log dan runtime log.
9. Buka URL Deplexo dan lakukan pengujian end-to-end.

**Jangan commit password Supabase ke GitHub.** Password hanya dimasukkan melalui Environment Variables Deplexo.

## 7. Pengujian end-to-end

Urutan pengujian:

1. Register.
2. Login.
3. Tambah digicam.
4. Tambah pelanggan.
5. Lakukan peminjaman.
6. Pastikan stok berkurang satu.
7. Cek riwayat.
8. Kembalikan digicam.
9. Pastikan stok bertambah satu.
10. Cek statistik Peminjaman Aktif di Home.
11. Logout.
12. Coba membuka halaman CRUD secara langsung tanpa login dan pastikan diarahkan ke Login.

## 8. Ekspor schema untuk dokumentasi

Jika ingin membuat schema export langsung dari database Supabase dengan PostgreSQL client:

```bash
pg_dump --schema-only --no-owner --no-privileges "CONNECTION_STRING_SUPABASE" > supabase_schema_export.sql
```

Jangan menyimpan connection string yang berisi password ke repository.

## 9. File dokumentasi

- `README_JOBSHEET13.md` — dokumentasi Jobsheet 13.
- `MANUAL_PENGGUNA.md` — panduan pengguna.
- `DEPLOY_SUPABASE_DEPLEXO.md` — panduan deployment.
- `SECURITY_CHECKLIST.md` — hasil hardening Jobsheet 11.
- `sql/supabase_schema.sql` — struktur database final.
- `docs/wireframe.md` — rancangan fitur.
