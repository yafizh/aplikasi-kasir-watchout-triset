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
    id_pengguna BIGINT UNSIGNED,
    nama VARCHAR(255),
    tempat_lahir VARCHAR(255) NULL,
    tanggal_lahir DATE NULL,
    foto VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_pengguna) REFERENCES pengguna(id)
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
    id_jenis_pakaian BIGINT UNSIGNED,
    nama VARCHAR(255),
    keterangan VARCHAR(255),
    PRIMARY KEY(id), 
    FOREIGN KEY (id_jenis_pakaian) REFERENCES jenis_pakaian(id) ON DELETE CASCADE,
    UNIQUE KEY `ukuran` (`id_jenis_pakaian`,`nama`)
);

CREATE TABLE pakaian(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_merk BIGINT UNSIGNED,
    id_jenis_pakaian BIGINT UNSIGNED,
    nama VARCHAR(255),
    harga BIGINT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_merk) REFERENCES merk(id) ON DELETE CASCADE,
    FOREIGN KEY (id_jenis_pakaian) REFERENCES jenis_pakaian(id) ON DELETE CASCADE
);

CREATE TABLE warna_pakaian(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_pakaian BIGINT UNSIGNED,
    id_warna BIGINT UNSIGNED,
    foto VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY (id_pakaian) REFERENCES pakaian(id) ON DELETE CASCADE,
    FOREIGN KEY (id_warna) REFERENCES warna(id) ON DELETE CASCADE
);

CREATE TABLE ukuran_warna_pakaian(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_ukuran BIGINT UNSIGNED,
    id_warna_pakaian BIGINT UNSIGNED,
    PRIMARY KEY(id),
    FOREIGN KEY (id_ukuran) REFERENCES ukuran(id) ON DELETE CASCADE,
    FOREIGN KEY (id_warna_pakaian) REFERENCES warna_pakaian(id) ON DELETE CASCADE
);

CREATE TABLE pakaian_disuplai(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_ukuran_warna_pakaian BIGINT UNSIGNED,
    tanggal_masuk DATE,
    harga BIGINT UNSIGNED COMMENT 'Harga pakaian saat ia disuplai',
    PRIMARY KEY(id),
    FOREIGN KEY (id_ukuran_warna_pakaian) REFERENCES ukuran_warna_pakaian(id) ON DELETE CASCADE
);

CREATE TABLE penjualan(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    nama_pembeli VARCHAR(255),
    tanggal_waktu_pembelian TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(id) 
);

CREATE TABLE pakaian_terjual(
    id BIGINT UNSIGNED AUTO_INCREMENT,
    id_penjualan BIGINT UNSIGNED,
    id_ukuran_warna_pakaian BIGINT UNSIGNED,
    harga BIGINT UNSIGNED COMMENT 'Harga pakaian saat ia dijual',
    PRIMARY KEY(id),
    FOREIGN KEY (id_penjualan) REFERENCES penjualan(id) ON DELETE CASCADE,
    FOREIGN KEY (id_ukuran_warna_pakaian) REFERENCES ukuran_warna_pakaian(id) ON DELETE CASCADE
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
