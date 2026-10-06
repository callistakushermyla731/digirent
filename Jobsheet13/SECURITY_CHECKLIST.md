# Checklist Keamanan — Jobsheet 11

## 1. SQL Injection
| Halaman/Proses | Before | After | Status |
|---|---|---|---|
| Login | Query mengambil username dari input pengguna | `prepare()` + parameter `:username` | Aman |
| Tambah Digicam | Input form masuk ke query | `prepare()` + parameter | Aman |
| Edit Digicam | Input form masuk ke query | `prepare()` + parameter | Aman |
| Hapus Digicam | ID dari POST | `prepare()` + parameter | Aman |
| Tambah/Edit/Hapus Pelanggan | Input/ID dari form | `prepare()` + parameter | Aman |

**Uji:** input login `' OR '1'='1` tidak dapat melewati `password_verify()`.

## 2. XSS
Semua data yang berasal dari database/session dan ditampilkan ke HTML dibungkus `htmlspecialchars()`.

Contoh pengujian:
```text
<script>alert(1)</script>
```
pada nama/judul data akan ditampilkan sebagai teks, bukan dieksekusi sebagai JavaScript.

## 3. CSRF
Ditambahkan `includes/csrf.php` yang membuat token menggunakan:
```php
bin2hex(random_bytes(32))
```

Token disimpan di session dan diverifikasi menggunakan `hash_equals()` pada request POST.

Token diterapkan pada:
- Login
- Register
- Tambah Digicam
- Edit Digicam
- Hapus Digicam
- Tambah Pelanggan
- Edit Pelanggan
- Hapus Pelanggan
- Tambah/Edit/Hapus Diagram

Jika token tidak ada atau salah, request ditolak dan pengguna diarahkan kembali.

## 4. Validasi & Sanitasi Input
- ID divalidasi sebagai integer menggunakan `FILTER_VALIDATE_INT`.
- Harga sewa dan stok harus integer serta tidak boleh negatif.
- Nama, merek, tipe, dan data pelanggan memiliki batas panjang.
- Email pelanggan divalidasi dengan `FILTER_VALIDATE_EMAIL`.
- Username dibatasi karakter yang diperbolehkan.
- Role saat registrasi menggunakan whitelist/fixed value `petugas`, bukan berasal dari input pengguna.
- Output HTML menggunakan `htmlspecialchars()`.

## 5. Session Fixation
Setelah login berhasil digunakan:
```php
session_regenerate_id(true);
```

Ini mempertahankan perlindungan terhadap session fixation sesuai tugas mandiri Jobsheet 11.

## 6. Prepared Statement
PDO menggunakan:
```php
PDO::ATTR_EMULATE_PREPARES => false
```
dan query yang menerima input menggunakan prepared statement.

## 7. Metode Request
Aksi penghapusan menggunakan POST, bukan GET. Form penghapusan juga dilindungi CSRF.

## 8. Catatan Pengujian
Checklist ini merupakan dokumentasi audit kode. Pengujian database dan browser tetap perlu dilakukan di environment PostgreSQL/PHP pengguna untuk memperoleh bukti screenshot before/after.
