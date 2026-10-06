# Manual Pengguna DIGIRENT

## 1. Register

1. Buka menu **Register**.
2. Isi nama, username, password, dan role sesuai kebutuhan.
3. Klik **Register**.
4. Gunakan akun tersebut untuk Login.

## 2. Login

1. Buka **Login**.
2. Masukkan username dan password.
3. Setelah berhasil, nama pengguna muncul pada navbar.

## 3. Mengelola Digicam

### Tambah
Buka **Tambah Digicam**, isi nama, merek, tipe, harga sewa, dan stok.

### Edit
Buka **Katalog Digicam**, pilih **Edit**, ubah data, lalu simpan.

### Hapus
Pilih **Hapus** pada data yang ingin dihapus dan konfirmasi tindakan.

## 4. Mengelola Pelanggan

### Tambah
Buka **Tambah Pelanggan**, isi nama, email, nomor HP, dan alamat.

### Edit/Hapus
Buka **Daftar Pelanggan**, kemudian gunakan aksi pada baris data.

## 5. Peminjaman

1. Buka menu **Peminjaman**.
2. Pilih pelanggan.
3. Pilih digicam yang stoknya masih tersedia.
4. Klik simpan.
5. Sistem mencatat transaksi dan mengurangi stok satu.

Jika pelanggan memiliki peminjaman aktif yang sudah lebih dari 14 hari, sistem menolak peminjaman baru.

## 6. Pengembalian

1. Buka **Riwayat**.
2. Cari transaksi dengan status **dipinjam**.
3. Klik **Kembalikan**.
4. Sistem mengisi tanggal kembali, mengubah status menjadi **dikembalikan**, dan menambah stok satu.

## 7. Dashboard

Home menampilkan jumlah digicam, pelanggan, dan peminjaman aktif yang diambil langsung dari PostgreSQL.

## 8. Logout

Klik **Logout** pada navbar setelah selesai menggunakan aplikasi.
