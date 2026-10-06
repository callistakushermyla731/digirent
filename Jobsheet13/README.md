# DIGIRENT — Jobsheet 13

Aplikasi rental digicam berbasis PHP Native + PostgreSQL.

## Project

Project ini merupakan kelanjutan Jobsheet 1–12 dan finalisasi Jobsheet 13:

- Front-end HTML/CSS/JavaScript
- PHP native + PDO PostgreSQL
- CRUD Digicam dan Pelanggan
- Register/Login/Logout + session
- Security hardening (SQL Injection, XSS, CSRF, validasi, session fixation)
- Peminjaman, pengembalian, stok, dan riwayat
- Database PostgreSQL Supabase untuk production
- Docker deployment ke Deplexo

## Deployment

Baca:

- `README_JOBSHEET13.md`
- `DEPLOY_SUPABASE_DEPLEXO.md`
- `MANUAL_PENGGUNA.md`

SQL production:

```text
sql/supabase_schema.sql
```

## Environment

Production menggunakan Environment Variables, bukan password yang ditulis di source code.

```text
PORT=8080
DB_HOST=...pooler.supabase.com
DB_PORT=5432
DB_NAME=postgres
DB_USER=postgres.PROJECT_REF
DB_PASSWORD=...
DB_SSLMODE=require
```

Untuk local development, lihat `.env.example`.
