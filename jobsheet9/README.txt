DIGIRENT - JOBSHEET 9

CARA MENJALANKAN TANPA MANUAL:
1. Pastikan PostgreSQL sudah terpasang dan service PostgreSQL sedang berjalan.
2. Double-click JALANKAN_DIGIRENT.bat.
3. Browser akan otomatis membuka http://localhost:8000/index.php.
4. Tidak perlu cd, tidak perlu mengetik php -S, dan tidak perlu membuat database/tabel secara manual.

DATABASE:
- PostgreSQL
- host: localhost
- port: 5432
- user: postgres
- password project: postgres
- database: digirent

Saat halaman pertama dibuka, database digirent, tabel digicam, tabel pelanggan, dan data awal akan dibuat otomatis.

LOGIN:
email: admindigirent123@gmail.com
password: 12345678

FITUR JOBSHEET 9:
- Create, Read, Update, Delete digicam
- Create, Read, Update, Delete pelanggan
- Delete memakai POST + prepared statement + konfirmasi JavaScript
- Pagination 10 data per halaman
- Pencarian digicam server-side menggunakan ILIKE
- Prepared statement untuk operasi data
