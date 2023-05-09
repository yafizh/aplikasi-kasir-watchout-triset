INSERT INTO `kasir`.`pengguna`(
    username,
    password,
    status
) VALUES 
('admin', 'admin', 1),
('nana', 'nana', 2),
('aulia', 'aulia', 3);

INSERT INTO `kasir`.`kasir`(
    id_pengguna,
    nama,
    tempat_lahir,
    tanggal_lahir,
    foto
) VALUES 
(3, 'Nana', 'Martapura', CURRENT_DATE(), '');

INSERT INTO `kasir`.`pembeli` (
    id_pengguna,
    nama,
    nomor_telepon,
    email,
    tempat_lahir,
    tanggal_lahir,
    pembeli 
) VALUES (
    3,
    'Nana Aulia',
    '',
    '',
    'Martapura',
    '2000-01-01',
    ''
);

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
(1, 1, 2, 'AMAYA DRESS', 500000, 789900),
(2, 1, 2, 'KYNA BLOUSE', 400000, 539900);

INSERT INTO `kasir`.`ukuran_pakaian`(
    id,
    id_pakaian,
    ukuran
) VALUES 
(1, 1, 'S'),
(2, 1, 'M'),
(3, 1, 'L'),
(4, 1, 'XL'),
(5, 2, 'S'),
(6, 2, 'M'),
(7, 2, 'L'),
(8, 2, 'XL');

INSERT INTO `kasir`.`warna_pakaian`(
    id,
    id_pakaian,
    warna
) VALUES 
(1, 1, 'GREY'),
(2, 1, 'BLUE'),
(3, 1, 'CREAM'),
(4, 1, 'LIGHT GREEN'),
(5, 2, 'GREEN'),
(6, 2, 'TURQUOISE'),
(7, 2, 'PINK'),
(8, 2, 'CARAMEL'),
(9, 2, 'MULTICOLOR');

INSERT INTO `kasir`.`foto_pakaian` (
    id,
    id_warna_pakaian,
    foto 
) VALUES 
(1, 1, '../../dummy/triset/baju/280f5ba9-91d2-41b7-b9f3-18318970b29f-3.webp'),
(2, 2, '../../dummy/triset/baju/1b0d80fb-b64b-4e14-9543-60c5092a2228-b5.webp'),
(3, 2, '../../dummy/triset/baju/de84e16a-e6c2-4809-ba8b-f1cf499ee1b9-b5.webp'),
(4, 2, '../../dummy/triset/baju/328da564-78e3-406b-a297-e81fdbdbeec9-b1.webp'),
(5, 3, '../../dummy/triset/baju/0438286f-cdaf-4d5c-bdaa-92d49c2a1ff0-c1.webp'),
(6, 3, '../../dummy/triset/baju/e4486aa6-8955-4254-9366-a3ac76ab94b8-c1.webp'),
(7, 3, '../../dummy/triset/baju/aed8d254-71c0-4b41-a525-ce6fb23a981d-c4.webp'),
(8, 4, '../../dummy/triset/baju/7c3fce48-e7f9-4e8f-80f9-2f76cd9e9e8e-ld302640011-4.webp'),
(9, 4, '../../dummy/triset/baju/5f31a7ab-2859-4bd5-adbc-7b73a13663b6-ld302640011-6.webp'),
(10, 5, '../../dummy/triset/baju/760df007-8cf8-462b-bc42-deaa96012a1f-lr304420811.webp'),
(11, 5, '../../dummy/triset/baju/48607670-b7f3-4eac-a0f5-9816f7e576d9-lr304420811-2.webp'),
(12, 5, '../../dummy/triset/baju/8b812736-81b4-4ceb-8395-8d5dd0a43450-lr304420811-3.webp'),
(13, 5, '../../dummy/triset/baju/60e1c152-c2d1-4596-8195-725a6023e6df-lr304420811-4.webp'),
(14, 5, '../../dummy/triset/baju/3040ed2b-be40-459c-a722-4ddbe5b7dcd3-lr304420811-5.webp'),
(15, 6, '../../dummy/triset/baju/ffc76abb-030a-4e42-bfff-02bd086f006a-layer-3.webp'),
(16, 6, '../../dummy/triset/baju/4e4ffa04-8892-4f31-a7f4-284cc7068c8e-layer-6.webp'),
(17, 7, '../../dummy/triset/baju/e58d37e4-4549-45e1-bb4b-e83ca7ef8bac-lr304350100.webp'),
(18, 7, '../../dummy/triset/baju/a08ac287-7746-42d9-9c52-ba3c9838530f-lr304350100-2.webp'),
(19, 7, '../../dummy/triset/baju/2d6214cb-33e8-4fda-acda-a3e790e1dd50-lr304350100-3.webp'),
(20, 7, '../../dummy/triset/baju/1acd6f43-43d7-4e0a-ab0e-894bdbee2016-lr304350100-4.webp'),
(21, 7, '../../dummy/triset/baju/29ba6f88-ddb0-43fa-87b2-0fc83103a01f-lr304350100-5.webp'),
(22, 7, '../../dummy/triset/baju/3eea8966-ea7e-497e-9983-145b6652d7ea-lr304350100-6.webp'),
(23, 8, '../../dummy/triset/baju/7df3d14c-62ce-48b1-9032-c05b55282e5c-lr304300100.webp'),
(24, 8, '../../dummy/triset/baju/07dfd45c-2e6d-49a6-8961-e554d149baab-lr304300100-2.webp'),
(25, 8, '../../dummy/triset/baju/52ecd468-6208-42f7-bb9a-a4656a4cbce2-lr304300100-3.webp'),
(26, 8, '../../dummy/triset/baju/37140518-de01-45e8-99b2-df808bdf7d68-lr304300100-4.webp'),
(27, 8, '../../dummy/triset/baju/284c9a60-a105-4aa0-9586-5d9514be40d6-lr304300100-5.webp'),
(28, 8, '../../dummy/triset/baju/bb052e50-bf24-4aa4-9994-87cecb81c599-lr304300100-6.webp'),
(29, 9, '../../dummy/triset/baju/7d6c62e4-7550-49ac-ba70-87e0d08cf8d0-lr304270800.webp'),
(30, 9, '../../dummy/triset/baju/cb573810-d5d7-4793-8c05-f81a534c8132-lr304270800-2.webp'),
(31, 9, '../../dummy/triset/baju/50c17cc9-9293-44dc-aed3-59de86487eea-lr304270800-3.webp'),
(32, 9, '../../dummy/triset/baju/c7b370c5-f245-427a-9240-0edc65f4dedc-lr304270800-4.webp'),
(33, 9, '../../dummy/triset/baju/7dbb9a44-732b-44fd-8086-dbecaf03935f-lr304270800-5.webp'),
(34, 9, '../../dummy/triset/baju/0004287d-ae6c-44ac-9889-ca450f2bcfe5-lr304270800-6.webp');

INSERT INTO `kasir`.`ukuran_warna_pakaian`(
    id,
    id_ukuran_pakaian,
    id_warna_pakaian
) VALUES 
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 1, 2),
(6, 2, 2),
(7, 3, 2),
(8, 4, 2),
(9, 1, 3),
(10, 2, 3),
(11, 3, 3),
(12, 4, 3),
(13, 1, 4),
(14, 2, 4),
(15, 3, 4),
(16, 4, 4),
(17, 5, 5),
(18, 6, 5),
(19, 7, 5),
(20, 8, 5),
(21, 5, 6),
(22, 6, 6),
(23, 7, 6),
(24, 8, 6),
(25, 5, 7),
(26, 6, 7),
(27, 7, 7),
(28, 8, 7),
(29, 5, 8),
(30, 6, 8),
(31, 7, 8),
(32, 8, 8),
(33, 5, 9),
(34, 6, 9),
(35, 7, 9),
(36, 8, 9);

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