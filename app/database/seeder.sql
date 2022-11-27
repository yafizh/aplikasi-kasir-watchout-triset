INSERT INTO pengguna(
    username,
    password,
    status
) VALUES 
('admin', 'admin', 'ADMIN'),
('kasir', 'kasir', 'KASIR');

INSERT INTO kasir(
    id_pengguna,
    nama,
    tempat_lahir,
    tanggal_lahir,
    foto
) VALUES 
(2, 'Kasir', 'Martapura', CURRENT_DATE(), '');

INSERT INTO warna(
    nama
) VALUES 
('Putih'),
('Hitam'),
('Biru'),
('Hijau'),
('Pink');

INSERT INTO merk(
    nama
) VALUES 
('Triset'),
('Watchout');

INSERT INTO jenis_pakaian(
    nama
) VALUES 
('Celana'),
('Baju'),
('Kemeja'),
('Sepatu'),
('Sendal');

INSERT INTO ukuran(
    id,
    id_jenis_pakaian,
    nama,
    keterangan 
) VALUES 
(1, 1, '32', ''),
(2, 1, '33', ''),
(3, 1, '34', ''),
(4, 4, '32', ''),
(5, 4, '33', ''),
(6, 4, '34', ''),
(7, 5, '32', ''),
(8, 5, '33', ''),
(9, 5, '34', ''),
(10, 2, 'XXS', ''),
(11, 2, 'XS', ''),
(12, 2, 'S', ''),
(13, 2, 'M', ''),
(14, 2, 'L', ''),
(15, 2, 'XL', ''),
(16, 2, 'XXL', '');

-- Pakaian
INSERT INTO pakaian(
    id_merk,
    id_jenis_pakaian,
    nama,
    harga
) VALUES 
(1, 1, 'ELAINA PANTS', 500000),
(1, 2, 'KYNA BLOUSE', 500000),
(1, 2, 'AINE BLOUSE', 500000),
(2, 2, 'FAIRVIEW SHIRT', 500000),
(2, 1, 'FRANKLIN REGULER FIT', 700000),
(2, 2, 'NEWPORT TEE', 400000);

INSERT INTO warna_pakaian(
    id_pakaian,
    id_warna,
    foto
) VALUES 
(1, 1, '../../dummy/4.jpg'),
(2, 4, '../../dummy/5.jpg'),
(3, 5, '../../dummy/6.jpg'),
(4, 1, '../../dummy/1.jpg'),
(5, 2, '../../dummy/2.jpg'),
(6, 3, '../../dummy/3.jpg');

INSERT INTO ukuran_warna_pakaian(
    id_ukuran,
    id_warna_pakaian
) VALUES 
(11, 1),
(12, 1);

INSERT INTO pakaian_disuplai(
    id_ukuran_warna_pakaian,
    tanggal_masuk,
    harga,
    jumlah 
) VALUES 
(1, CURRENT_DATE(), 150000,2),
(1, CURRENT_DATE(), 150000,5),
(2, CURRENT_DATE(), 150000,5);