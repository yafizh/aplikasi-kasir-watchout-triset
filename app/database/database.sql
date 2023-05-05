DROP DATABASE IF EXISTS `kasir`;
CREATE DATABASE `kasir`;
USE `kasir`;

CREATE TABLE `kasir`.`pengguna`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    status TINYINT UNSIGNED COMMENT '1=Admin|2=Kasir|3=Pembeli',
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

CREATE TABLE `kasir`.`pembeli`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pengguna BIGINT UNSIGNED,
    nama VARCHAR(255),
    nomor_telepon VARCHAR(255),
    email VARCHAR(255),
    tempat_lahir VARCHAR(255) NULL,
    tanggal_lahir DATE NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`merk`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE `kasir`.`kategori_pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255) UNIQUE,
    urutan TINYINT UNSIGNED,
    PRIMARY KEY(id)
);

CREATE TABLE `kasir`.`pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_merk BIGINT UNSIGNED,
    id_kategori_pakaian BIGINT UNSIGNED,
    nama VARCHAR(255),
    harga_modal BIGINT UNSIGNED,
    harga_toko BIGINT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_merk) REFERENCES merk(id) ON DELETE CASCADE,
    FOREIGN KEY (id_kategori_pakaian) REFERENCES kategori_pakaian (id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`warna_pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pakaian BIGINT UNSIGNED,
    warna VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_pakaian) REFERENCES pakaian(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`foto_pakaian` (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_warna_pakaian BIGINT UNSIGNED,
    foto VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_warna_pakaian) REFERENCES warna_pakaian (id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`ukuran_pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pakaian BIGINT UNSIGNED,
    ukuran VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_pakaian) REFERENCES pakaian (id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`ukuran_warna_pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_warna_pakaian BIGINT UNSIGNED,
    id_ukuran_pakaian BIGINT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_warna_pakaian) REFERENCES warna_pakaian (id) ON DELETE CASCADE,
    FOREIGN KEY (id_ukuran_pakaian) REFERENCES ukuran_pakaian (id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`pakaian_disuplai`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_ukuran_warna_pakaian BIGINT UNSIGNED,
    tanggal_masuk DATE,
    harga BIGINT UNSIGNED COMMENT 'Harga pakaian saat ia disuplai',
    jumlah INT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_ukuran_warna_pakaian) REFERENCES ukuran_warna_pakaian (id) ON DELETE CASCADE
);
 
CREATE TABLE `kasir`.`penjualan`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_kasir BIGINT UNSIGNED,
    tunai BIGINT UNSIGNED,
    tanggal_waktu_penjualan TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (id_kasir) REFERENCES kasir(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`detail_penjualan`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_penjualan BIGINT UNSIGNED,
    id_ukuran_warna_pakaian BIGINT UNSIGNED,
    harga BIGINT UNSIGNED COMMENT 'Harga pakaian saat ia dijual',
    jumlah INT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_penjualan) REFERENCES penjualan(id) ON DELETE CASCADE,
    FOREIGN KEY (id_ukuran_warna_pakaian) REFERENCES ukuran_warna_pakaian(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`penjualan_online`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pelanggan BIGINT UNSIGNED,
    order_id VARCHAR(255),
    status TINYINT UNSIGNED COMMENT '1=Menunggu Pembayaran|2=Selesai',
    PRIMARY KEY (id),
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan (id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`detail_penjualan_online`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_penjualan_online BIGINT UNSIGNED,
    id_ukuran_warna_pakaian BIGINT UNSIGNED,
    harga BIGINT UNSIGNED COMMENT 'Harga pakaian saat ia dijual',
    jumlah INT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_penjualan_online) REFERENCES penjualan_online (id) ON DELETE CASCADE,
    FOREIGN KEY (id_ukuran_warna_pakaian) REFERENCES ukuran_warna_pakaian(id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`diskon`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255),
    dari_tanggal DATE,
    sampai_tanggal DATE,
    diskon BIGINT UNSIGNED,
    jenis_diskon TINYINT UNSIGNED COMMENT '1=Nominal|2=Persentase',
    PRIMARY KEY(id)
);

CREATE TABLE `kasir`.`diskon_pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_diskon BIGINT UNSIGNED,
    id_pakaian BIGINT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_diskon) REFERENCES diskon (id) ON DELETE CASCADE,
    FOREIGN KEY (id_pakaian) REFERENCES pakaian (id) ON DELETE CASCADE
);

CREATE TABLE `kasir`.`voucher_diskon`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255),
    dari_tanggal DATE,
    sampai_tanggal DATE,
    diskon BIGINT UNSIGNED,
    jenis_diskon TINYINT UNSIGNED COMMENT '1=Nominal|2=Persentase',
    kode_voucher VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE `kasir`.`voucher_diskon_pakaian`(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_voucher_diskon BIGINT UNSIGNED,
    id_pakaian BIGINT UNSIGNED,
    PRIMARY KEY (id),
    FOREIGN KEY (id_voucher_diskon) REFERENCES voucher_diskon (id) ON DELETE CASCADE,
    FOREIGN KEY (id_pakaian) REFERENCES pakaian(id) ON DELETE CASCADE
);