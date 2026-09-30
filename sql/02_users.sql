-- Jobsheet 10: tabel users
create table if not exists users (
    id serial primary key,
    nama varchar(150) not null,
    username varchar(100) not null unique,
    password varchar(255) not null,
    role varchar(30) not null default 'petugas'
);
