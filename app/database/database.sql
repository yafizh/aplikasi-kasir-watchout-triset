DROP DATABASE IF EXISTS `kasir`;
CREATE DATABASE `kasir`;
USE `kasir`;

CREATE TABLE `kasir`.`pengguna`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    status VARCHAR(255),
    PRIMARY KEY(id)
);

CREATE TABLE `kasir`.`kasir`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pengguna BIGINT UNSIGNED,
    nama VARCHAR(255),
    tempat_lahir VARCHAR(255) NULL,
    tanggal_lahir DATE NULL,
    foto VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`warna`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE `kasir`.`merk`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE `kasir`.`jenis_pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE `kasir`.`ukuran`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_jenis_pakaian BIGINT UNSIGNED,
    nama VARCHAR(255),
    PRIMARY KEY(id), 
    FOREIGN KEY (id_jenis_pakaian) REFERENCES jenis_pakaian(id) ON DELETE CASCADE,
    UNIQUE KEY `ukuran` (`id_jenis_pakaian`,`nama`)
);

CREATE TABLE `kasir`.`pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_merk BIGINT UNSIGNED,
    id_jenis_pakaian BIGINT UNSIGNED,
    nama VARCHAR(255),
    harga BIGINT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_merk) REFERENCES merk(id) ON DELETE CASCADE,
    FOREIGN KEY (id_jenis_pakaian) REFERENCES jenis_pakaian(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`warna_pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pakaian BIGINT UNSIGNED,
    id_warna BIGINT UNSIGNED,
    foto VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_pakaian) REFERENCES pakaian(id) ON DELETE CASCADE,
    FOREIGN KEY (id_warna) REFERENCES warna(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`ukuran_warna_pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_ukuran BIGINT UNSIGNED,
    id_warna_pakaian BIGINT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_ukuran) REFERENCES ukuran(id) ON DELETE CASCADE,
    FOREIGN KEY (id_warna_pakaian) REFERENCES warna_pakaian(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`pakaian_disuplai`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_ukuran_warna_pakaian BIGINT UNSIGNED,
    tanggal_masuk DATE,
    harga BIGINT UNSIGNED COMMENT 'Harga pakaian saat ia disuplai',
    jumlah INT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_ukuran_warna_pakaian) REFERENCES ukuran_warna_pakaian(id) ON DELETE CASCADE
);
 
CREATE TABLE `kasir`.`penjualan`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_kasir BIGINT UNSIGNED,
    tunai BIGINT UNSIGNED,
    tanggal_waktu_penjualan TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (id_kasir) REFERENCES kasir(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`pakaian_terjual`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_penjualan BIGINT UNSIGNED,
    id_ukuran_warna_pakaian BIGINT UNSIGNED,
    harga BIGINT UNSIGNED COMMENT 'Harga pakaian saat ia dijual',
    jumlah INT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_penjualan) REFERENCES penjualan(id) ON DELETE CASCADE,
    FOREIGN KEY (id_ukuran_warna_pakaian) REFERENCES ukuran_warna_pakaian(id) ON DELETE CASCADE
);