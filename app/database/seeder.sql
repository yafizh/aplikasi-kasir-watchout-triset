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
('Merk 1'),
('Merk 2');

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

INSERT INTO pakaian(
    id_warna,
    id_merk,
    id_ukuran,
    id_jenis_pakaian,
    nama,
    harga,
    foto
) VALUES 
(1, 1, 1, 1, 'Baju 1', 200000, '');

INSERT INTO pakaian_disuplai(
    id_pakaian,
    tanggal_masuk,
    harga 
) VALUES 
(1, CURRENT_DATE(), 200000);