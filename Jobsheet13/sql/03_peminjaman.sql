-- Jobsheet 12: jalankan jika database belum membuat tabel peminjaman otomatis.
create table if not exists peminjaman (
    id serial primary key,
    digicam_id integer not null references digicam(id),
    pelanggan_id integer not null references pelanggan(id),
    tanggal_pinjam date not null default current_date,
    tanggal_kembali date null,
    status varchar(20) not null default 'dipinjam'
        check (status in ('dipinjam', 'dikembalikan'))
);
