DROP DATABASE IF EXISTS kasir;
CREATE DATABASE kasir;
USE kasir;

CREATE TABLE pengguna(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    status VARCHAR(255),
    PRIMARY KEY(id)
);

CREATE TABLE kasir(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pengguna BIGINT UNSIGNED REFERENCES pengguna(id),
    nama VARCHAR(255),
    tempat_lahir VARCHAR(255) NULL,
    tanggal_lahir DATE NULL,
    foto VARCHAR(255),
    PRIMARY KEY(id)
);

CREATE TABLE warna(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE merk(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE jenis_pakaian(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama VARCHAR(255) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE ukuran(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_jenis_pakaian BIGINT UNSIGNED REFERENCES jenis_pakaian(id),
    nama VARCHAR(255),
    keterangan VARCHAR(255),
    PRIMARY KEY(id), 
    UNIQUE KEY `ukuran` (`id_jenis_pakaian`,`nama`)
);

CREATE TABLE pakaian(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_warna BIGINT UNSIGNED REFERENCES warna(id),
    id_merk BIGINT UNSIGNED REFERENCES merk(id),
    id_ukuran BIGINT UNSIGNED REFERENCES ukuran(id),
    id_jenis_pakaian BIGINT UNSIGNED REFERENCES jenis_pakaian(id),
    nama VARCHAR(255),
    harga BIGINT UNSIGNED,
    foto VARCHAR(255),
    PRIMARY KEY(id)
);

CREATE TABLE pakaian_disuplai(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pakaian BIGINT UNSIGNED REFERENCES pakaian(id),
    tanggal_masuk DATE,
    harga BIGINT UNSIGNED COMMENT 'Harga pakaian saat ia disuplai',
    PRIMARY KEY(id)   
);

CREATE TABLE penjualan(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama_pembeli VARCHAR(255),
    tanggal_waktu_pembelian TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(id) 
);

CREATE TABLE pakaian_terjual(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_penjualan BIGINT UNSIGNED REFERENCES penjualan(id),
    id_pakaian BIGINT UNSIGNED REFERENCES pakaian(id),
    harga BIGINT UNSIGNED COMMENT 'Harga pakaian saat ia dijual',
    PRIMARY KEY(id) 
);

DELIMITER //

DROP PROCEDURE IF EXISTS getPakaian//
DROP PROCEDURE IF EXISTS getPakaianByDate//

CREATE PROCEDURE 
    getPakaian() 
BEGIN
    SELECT 
        w.nama AS warna,
        m.nama AS merk,
        u.nama AS ukuran,
        jp.nama AS jenis_pakaian, 
        p.nama, 
        p.harga, 
        p.foto, 
        (
            (SELECT 
                COUNT(pd.id) 
            FROM 
                pakaian_disuplai AS pd 
            WHERE 
                pd.id_pakaian=p.id)
            - 
            (SELECT 
                COUNT(pt.id) 
            FROM 
                pakaian_terjual AS pt 
            WHERE 
                pt.id_pakaian=p.id)
        ) AS stok 
    FROM 
        pakaian AS p
    INNER JOIN 
        warna AS w 
    ON 
        w.id=p.id_warna 
    INNER JOIN 
        merk AS m 
    ON 
        m.id=p.id_merk 
    INNER JOIN 
        ukuran AS u 
    ON 
        u.id=p.id_ukuran
    INNER JOIN 
        jenis_pakaian AS jp 
    ON 
        jp.id=p.id_jenis_pakaian;
END //

CREATE PROCEDURE 
    getPakaianByDate(tanggal_mulai DATE, tanggal_akhir DATE)
BEGIN
    SELECT 
        w.nama AS warna,
        m.nama AS merk,
        u.nama AS ukuran,
        jp.nama AS jenis_pakaian, 
        p.nama, 
        p.harga, 
        p.foto, 
        (
            (
            SELECT 
                COUNT(pt.id) 
            FROM 
                pakaian_disuplai AS pd 
            WHERE 
                pd.id_pakaian=p.id 
                AND 
                pd.tanggal_masuk BETWEEN tanggal_mulai AND tanggal_akhir
            )
            - 
            (
            SELECT 
                COUNT(pt.id) 
            FROM 
                pakaian_terjual AS pt 
            INNER JOIN 
                penjualan 
            ON 
                penjualan.id=pt.id_penjualan 
            WHERE 
                pt.id_pakaian=p.id 
                AND 
                DATE(penjualan.tanggal_waktu_pembelian) BETWEEN tanggal_mulai AND tanggal_akhir 
            )
        ) AS stok 
    FROM 
        pakaian AS p
    INNER JOIN 
        warna AS w 
    ON 
        w.id=p.id_warna 
    INNER JOIN 
        merk AS m 
    ON 
        m.id=p.id_merk 
    INNER JOIN 
        ukuran AS u 
    ON 
        u.id=p.id_ukuran
    INNER JOIN 
        jenis_pakaian AS jp 
    ON 
        jp.id=p.id_jenis_pakaian;
END //

DELIMITER ;
