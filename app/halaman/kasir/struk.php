<?php
include_once('../../assets/extensions/fpdf/fpdf.php');
include_once('../../database/koneksi.php');
include_once('../../helper/date.php');

$query = "
    SELECT 
        k.nama nama_kasir,
        pe.id,
        pe.tunai,
        pt.jumlah,
        pt.harga,
        u.ukuran,
        wp.warna,
        DATE(tanggal_waktu_penjualan) AS tanggal,
        TIME_FORMAT(tanggal_waktu_penjualan, '%H:%i') AS waktu,
        p.nama 
    FROM 
        penjualan AS pe 
    INNER JOIN 
        kasir AS k 
    ON 
        k.id=pe.id_kasir  
    INNER JOIN 
        detail_penjualan AS pt 
    ON 
        pe.id=pt.id_penjualan 
    INNER JOIN 
        ukuran_warna_pakaian AS uwp 
    ON 
        uwp.id=pt.id_ukuran_warna_pakaian
    INNER JOIN 
        ukuran_pakaian AS u 
    ON 
        u.id=uwp.id_ukuran_pakaian
    INNER JOIN 
        warna_pakaian AS wp 
    ON 
        wp.id=uwp.id_warna_pakaian 
    INNER JOIN 
        pakaian AS p 
    ON 
        p.id=wp.id_pakaian
    WHERE 
        pe.id=" . $_GET['id'];
$result = $mysqli->query($query);
$data = $result->fetch_all(MYSQLI_ASSOC);

$border = 0;
$height = 65;
if ($result->num_rows >= 3) $height += (3 * $result->num_rows - 3);
$pageSize = [60, $height];

$pdf = new FPDF('P', 'mm', $pageSize);
$pdf->SetMargins(4, 4);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();


$pdf->SetFont('Arial', '', 4);
$pdf->Cell(0, 2, '============================================================', $border, 2, 'C');
$pdf->Cell(0, 2, 'PT. BINACITRA KAHRISMA LESTARI', $border, 2, 'C');
$pdf->Cell(0, 2, 'NPWP 01.280.045.4-44', $border, 2, 'C');
$pdf->Cell(0, 2, 'OXA QMALL BANJARMASIN', $border, 2, 'C');
$pdf->Cell(0, 2, 'LT.GF 43-4 JL. A YANI KM 36.8 BANJAR', $border, 2, 'C');
$pdf->Cell(0, 2, '============================================================', $border, 2, 'C');


$pdf->SetFont('Arial', '', 4);
$pdf->Cell(0, 2, 'Nama Kasir: '. $data[0]['nama_kasir'], $border, 2, );
$pdf->Cell(26, 2, 'Tanggal: ' . indonesiaDate($data[0]['tanggal']), $border, 0);
$pdf->Cell(26, 2, 'Waktu: ' . $data[0]['waktu'], $border, 1, 'R');
$pdf->Cell(0, 2, '============================================================', $border, 2, 'C');

$total = 0;
$pdf->SetFont('Arial', '', 4);
foreach ($data as $row) {
    $pdf->Cell(0, 2, $row['nama'] . ' Warna ' . $row['warna'] . ' Ukuran ' . $row['ukuran'], $border, 2);
    $pdf->Cell(10, 2, $row['jumlah'] . ' x', $border, 0, 'R');
    $pdf->Cell(26, 2, 'Rp ' . number_format($row['harga'], 0, ",", "."), $border, 0);
    $pdf->Cell(6, 2, 'Rp', $border, 0);
    $pdf->Cell(10, 2, number_format($row['harga'] * $row['jumlah'], 0, ",", "."), $border, 1, 'R');
    $total += $row['harga'] * $row['jumlah'];
}

$pdf->Cell(0, 2, '============================================================', $border, 2, 'C');

$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(36, 2, 'Total', $border, 0);
$pdf->Cell(6, 2, 'Rp', $border, 0);
$pdf->Cell(10, 2, number_format($total, 0, ",", "."), $border, 1, 'R');

$pdf->SetFont('Arial', '', 4);
$pdf->Cell(0, 2, '============================================================', $border, 2, 'C');

$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(36, 2, 'Tunai', $border, 0);
$pdf->Cell(6, 2, 'Rp', $border, 0);
$pdf->Cell(10, 2, number_format($data[0]['tunai'], 0, ",", "."), $border, 1, 'R');
$pdf->Cell(36, 2, 'Kembalian', $border, 0);
$pdf->Cell(6, 2, 'Rp', $border, 0);
$pdf->Cell(10, 2, number_format($data[0]['tunai'] - $total, 0, ",", "."), $border, 1, 'R');

$pdf->SetFont('Arial', '', 4);
$pdf->Cell(0, 2, '============================================================', $border, 2, 'C');
$pdf->Cell(0, 2, 'Kunjungi kami di www.oxa.co.id', $border, 2, 'C');
$pdf->Cell(0, 2, '============================================================', $border, 2, 'C');


$pdf->Output();
