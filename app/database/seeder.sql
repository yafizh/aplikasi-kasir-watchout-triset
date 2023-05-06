INSERT INTO `kasir`.`pengguna`(
    username,
    password,
    status
) VALUES 
('admin', 'admin', 1),
('nana', 'nana', 2);

INSERT INTO `kasir`.`kasir`(
    id_pengguna,
    nama,
    tempat_lahir,
    tanggal_lahir,
    foto
) VALUES 
(3, 'Nana', 'Martapura', CURRENT_DATE(), '');

INSERT INTO `kasir`.`merk`(
    id,
    nama
) VALUES 
(1, 'Triset'),
(2, 'Watchout');

INSERT INTO `kasir`.`kategori_pakaian`(
    id,
    nama,
    urutan 
) VALUES 
(1, 'Celana', 1),
(2, 'Baju', 2),
(3, 'Kemeja', 3),
(4, 'Sepatu', 4),
(5, 'Sendal', 5);

-- Pakaian
INSERT INTO `kasir`.`pakaian`(
    id,
    id_merk,
    id_kategori_pakaian,
    nama,
    harga_modal,
    harga_toko
) VALUES 
(1, 1, 2, 'AMAYA DRESS', 500000, 789900);

INSERT INTO `kasir`.`ukuran_pakaian`(
    id,
    id_pakaian,
    ukuran
) VALUES 
(1, 1, 'S'),
(2, 1, 'M'),
(3, 1, 'L'),
(4, 1, 'XL');

INSERT INTO `kasir`.`warna_pakaian`(
    id,
    id_pakaian,
    warna
) VALUES 
(1, 1, 'Grey');

INSERT INTO `kasir`.`foto_pakaian` (
    id,
    id_warna_pakaian,
    foto 
) VALUES 
(1, 1, '../../dummy/triset/baju/280f5ba9-91d2-41b7-b9f3-18318970b29f-3.webp');

INSERT INTO `kasir`.`ukuran_warna_pakaian`(
    id,
    id_ukuran_pakaian,
    id_warna_pakaian
) VALUES 
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1);

-- INSERT INTO `kasir`.`pakaian_disuplai`(
--     id_ukuran_warna_pakaian,
--     tanggal_masuk,
--     harga,
--     jumlah 
-- ) VALUES 
-- (1, CURRENT_DATE(), 150000,5),
-- (2, CURRENT_DATE(), 150000,5),
-- (3, CURRENT_DATE(), 150000,5),
-- (4, CURRENT_DATE(), 150000,5),
-- (5, CURRENT_DATE(), 150000,5),
-- (6, CURRENT_DATE(), 150000,5),
-- (7, CURRENT_DATE(), 150000,5),
-- (8, CURRENT_DATE(), 150000,5),
-- (9, CURRENT_DATE(), 150000,5),
-- (10, CURRENT_DATE(), 150000,5),
-- (11, CURRENT_DATE(), 150000,5),
-- (12, CURRENT_DATE(), 150000,5),
-- (13, CURRENT_DATE(), 150000,5),
-- (14, CURRENT_DATE(), 150000,5),
-- (15, CURRENT_DATE(), 150000,5),
-- (16, CURRENT_DATE(), 150000,5),
-- (17, CURRENT_DATE(), 150000,5),
-- (18, CURRENT_DATE(), 150000,5),
-- (19, CURRENT_DATE(), 150000,5),
-- (20, CURRENT_DATE(), 150000,5),
-- (21, CURRENT_DATE(), 150000,5),
-- (22, CURRENT_DATE(), 150000,5),
-- (23, CURRENT_DATE(), 150000,5),
-- (24, CURRENT_DATE(), 150000,5),
-- (25, CURRENT_DATE(), 150000,5),
-- (26, CURRENT_DATE(), 150000,5),
-- (27, CURRENT_DATE(), 150000,5),
-- (28, CURRENT_DATE(), 150000,5),
-- (29, CURRENT_DATE(), 150000,5),
-- (30, CURRENT_DATE(), 150000,5),
-- (31, CURRENT_DATE(), 150000,5),
-- (32, CURRENT_DATE(), 150000,5),
-- (33, CURRENT_DATE(), 150000,5),
-- (34, CURRENT_DATE(), 150000,5),
-- (35, CURRENT_DATE(), 150000,5),
-- (36, CURRENT_DATE(), 150000,5),
-- (37, CURRENT_DATE(), 150000,5),
-- (38, CURRENT_DATE(), 150000,5),
-- (39, CURRENT_DATE(), 150000,5);