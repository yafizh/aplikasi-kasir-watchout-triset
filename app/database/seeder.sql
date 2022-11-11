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

INSERT INTO ukuran(
    nama,
    keterangan 
) VALUES 
('S', ''),
('M', ''),
('L', ''),
('XL', ''),
('XXL', '');

INSERT INTO jenis_pakaian(
    nama
) VALUES 
('Celana'),
('Baju'),
('Kemeja'),
('Sepatu'),
('Sendal');

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