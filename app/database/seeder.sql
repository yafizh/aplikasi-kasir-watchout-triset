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
('Merah'),
('Jingga'),
('Kuning'),
('Hijau'),
('Biru'),
('Nila'),
('Ungu');

INSERT INTO merk(
    nama
) VALUES 
('Executive'),
('UNIQLO');

INSERT INTO jenis_pakaian(
    nama
) VALUES 
('Celana'),
('Baju'),
('Kemeja'),
('Sepatu'),
('Sendal');

INSERT INTO ukuran(
    id_jenis_pakaian,
    nama,
    keterangan 
) VALUES 
(1, '32', ''),
(1, '33', ''),
(1, '34', ''),
(4, '32', ''),
(4, '33', ''),
(4, '34', ''),
(5, '32', ''),
(5, '33', ''),
(5, '34', ''),
(2, 'S', ''),
(2, 'M', ''),
(2, 'L', ''),
(2, 'XL', ''),
(2, 'XXL', '');

-- Pakaian
INSERT INTO pakaian(
    id_merk,
    id_jenis_pakaian,
    nama,
    harga
) VALUES 
(1, 2, 'Round Neck Waffle T-shirt', 150000);

INSERT INTO warna_pakaian(
    id_pakaian,
    id_warna,
    foto
) VALUES 
(1, 5, '../../dummy/1-TSIKCT221B931_NAVY_1_460x.webp');

INSERT INTO ukuran_warna_pakaian(
    id_ukuran,
    id_warna_pakaian
) VALUES 
(11, 1);

INSERT INTO pakaian_disuplai(
    id_ukuran_warna_pakaian,
    tanggal_masuk,
    harga,
    jumlah 
) VALUES 
(1, CURRENT_DATE(), 150000,2),
(1, CURRENT_DATE(), 150000,5);