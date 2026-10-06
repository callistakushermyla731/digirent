-- DIGIRENT - Jobsheet 13
-- Struktur database PostgreSQL untuk Supabase.
-- Jalankan seluruh file ini di Supabase Dashboard > SQL Editor.
-- Tidak berisi password/user default.

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

-- Data awal aman untuk demo. Password user dibuat melalui menu Register,
-- bukan ditulis di file SQL.
insert into digicam (nama, merek, tipe, harga_sewa, stok)
select 'Canon IXUS 185', 'Canon', 'Compact Camera', 75000, 3
where not exists (select 1 from digicam where nama = 'Canon IXUS 185');

insert into digicam (nama, merek, tipe, harga_sewa, stok)
select 'Sony Cyber-shot DSC-W830', 'Sony', 'Compact Camera', 80000, 2
where not exists (select 1 from digicam where nama = 'Sony Cyber-shot DSC-W830');

insert into digicam (nama, merek, tipe, harga_sewa, stok)
select 'Fujifilm FinePix JX500', 'Fujifilm', 'Compact Camera', 70000, 4
where not exists (select 1 from digicam where nama = 'Fujifilm FinePix JX500');

insert into pelanggan (nama, email, no_hp, alamat)
select 'Callista', 'callista@gmail.com', '081234567890', 'Malang'
where not exists (select 1 from pelanggan where email = 'callista@gmail.com');

insert into pelanggan (nama, email, no_hp, alamat)
select 'Dimas', 'dimas@gmail.com', '082345678901', 'Blitar'
where not exists (select 1 from pelanggan where email = 'dimas@gmail.com');
