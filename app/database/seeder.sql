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

-- -- Pakaian
-- INSERT INTO `kasir`.`pakaian`(
--     id,
--     id_merk,
--     id_jenis_pakaian,
--     nama,
--     harga
-- ) VALUES 
-- (1, 1, 1, 'ELAINA PANTS', 500000),
-- (2, 1, 2, 'KYNA BLOUSE', 500000),
-- (3, 1, 2, 'AINE BLOUSE', 500000),
-- (4, 2, 2, 'FAIRVIEW SHIRT', 500000),
-- (5, 2, 1, 'FRANKLIN REGULER FIT', 700000),
-- (6, 2, 2, 'NEWPORT TEE', 400000);

-- INSERT INTO `kasir`.`warna_pakaian`(
--     id,
--     id_pakaian,
--     id_warna,
--     foto
-- ) VALUES 
-- (1, 3, 4, '../../dummy/AINE-BLOUSE-HIJAU.jpg'),
-- (2, 3, 6, '../../dummy/AINE-BLOUSE-MAROON.jpg'),
-- (3, 3, 7, '../../dummy/AINE-BLOUSE-MERAH.jpg'),
-- (4, 3, 5, '../../dummy/AINE-BLOUSE-PINK.jpg'),
-- (5, 3, 1, '../../dummy/AINE-BLOUSE-PUTIH.jpg'),
-- (6, 1, 8, '../../dummy/ELAINA-PANTS-ABU-ABU.jpg'),
-- (7, 1, 2, '../../dummy/ELAINA-PANTS-HITAM.jpg'),
-- (8, 4, 1, '../../dummy/FAIRVIEW-SHIRT-PUTIH.jpg'),
-- (9, 4, 3, '../../dummy/FAIRVIEW-SHIRT-BIRU.jpg'),
-- (10, 4, 6, '../../dummy/FAIRVIEW-SHIRT-MAROON.jpg'),
-- (11, 5, 3, '../../dummy/FRANKLIN-REGULER-FIT-BIRU.jpg'),
-- (12, 5, 2, '../../dummy/FRANKLIN-REGULER-FIT-HITAM.jpg'),
-- (13, 2, 4, '../../dummy/KYNA-BLOUSE-HIJAU.jpg');

-- INSERT INTO `kasir`.`ukuran_warna_pakaian`(
--     id,
--     id_ukuran,
--     id_warna_pakaian
-- ) VALUES 
-- (1, 12, 1),
-- (2, 13, 1),
-- (3, 14, 1),
-- (4, 12, 2),
-- (5, 13, 2),
-- (6, 14, 2),
-- (7, 12, 3),
-- (8, 13, 3),
-- (9, 14, 3),
-- (10, 12, 4),
-- (11, 13, 4),
-- (12, 14, 4),
-- (13, 12, 5),
-- (14, 13, 5),
-- (15, 14, 5),
-- (16, 1, 6),
-- (17, 2, 6),
-- (18, 3, 6),
-- (19, 1, 7),
-- (20, 2, 7),
-- (21, 3, 7),
-- (22, 12, 8),
-- (23, 13, 8),
-- (24, 14, 8),
-- (25, 12, 9),
-- (26, 13, 9),
-- (27, 14, 9),
-- (28, 12, 10),
-- (29, 13, 10),
-- (30, 14, 10),
-- (31, 1, 11),
-- (32, 2, 11),
-- (33, 3, 11),
-- (34, 1, 12),
-- (35, 2, 12),
-- (36, 3, 12),
-- (37, 12, 13),
-- (38, 13, 13),
-- (39, 14, 13);

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