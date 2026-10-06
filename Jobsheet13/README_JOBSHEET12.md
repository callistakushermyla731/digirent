# Jobsheet 12 — Integrasi Peminjaman & Pengembalian DIGIRENT

Jobsheet 12 melanjutkan Jobsheet 11. Modul baru mengintegrasikan `digicam`, `pelanggan`, dan transaksi `peminjaman`.

## Fitur
- Peminjaman digicam melalui dropdown pelanggan dan digicam yang `stok > 0`.
- Peminjaman dan pengurangan stok diproses dalam satu transaksi PostgreSQL.
- Pengembalian memperbarui status, tanggal kembali, dan menambah stok.
- Riwayat menampilkan JOIN peminjaman + digicam + pelanggan.
- Filter riwayat berdasarkan pelanggan.
- Dashboard menampilkan jumlah peminjaman aktif dari database.
- Validasi bisnis: pelanggan yang memiliki peminjaman aktif lebih dari 14 hari tidak dapat membuat peminjaman baru.
- CSRF token dan POST tetap digunakan mengikuti hardening Jobsheet 11.

## Alur pengujian end-to-end
1. Register akun.
2. Login.
3. Pastikan ada digicam dan pelanggan.
4. Buka **Peminjaman**.
5. Pilih pelanggan + digicam, lalu simpan.
6. Pastikan stok digicam berkurang 1.
7. Buka **Riwayat** dan pastikan status `Dipinjam`.
8. Klik **Kembalikan**.
9. Pastikan status menjadi `Dikembalikan`, tanggal kembali terisi, dan stok bertambah 1.
10. Kembali ke Home dan pastikan statistik peminjaman aktif berubah sesuai database.
