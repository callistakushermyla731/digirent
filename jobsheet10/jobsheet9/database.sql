-- Database dan tabel dibuat otomatis oleh includes/koneksi.php.
-- File ini hanya sebagai dokumentasi struktur PostgreSQL Jobsheet 9.

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
