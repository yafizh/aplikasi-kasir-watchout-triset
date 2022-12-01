<?php
include_once('../../assets/extensions/fpdf/fpdf.php');
include_once('../../database/koneksi.php');
include_once('../../helper/date.php');

$query = "
    SELECT 
        pe.id,
        pe.tunai,
        pt.jumlah,
        pt.harga,
        u.nama AS ukuran,
        w.nama AS warna,
        p.nama 
    FROM 
        penjualan AS pe 
    INNER JOIN 
        pakaian_terjual AS pt 
    ON 
        pe.id=pt.id_penjualan 
    INNER JOIN 
        ukuran_warna_pakaian AS uwp 
    ON 
        uwp.id=pt.id_ukuran_warna_pakaian
    INNER JOIN 
        ukuran AS u 
    ON 
        u.id=uwp.id_ukuran 
    INNER JOIN 
        warna_pakaian AS wp 
    ON 
        wp.id=uwp.id_warna_pakaian
    INNER JOIN 
        warna AS w 
    ON 
        w.id=wp.id_warna 
    INNER JOIN 
        pakaian AS p 
    ON 
        p.id=wp.id_pakaian
    WHERE 
        pe.id=" . $_GET['id'];
$result = $mysqli->query($query);
$data = $result->fetch_all(MYSQLI_ASSOC);

$border = 0;

$pdf = new FPDF('P', 'mm', [60, 75]);
$pdf->SetMargins(4, 4);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 4, 'Receipt', $border, 2, 'C');

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(0, 2, '-----------------------------------------------------------------------', $border, 2);

$pdf->SetFont('Arial', '', 4);
$pdf->Cell(26, 2, 'Tanggal: ' . indonesiaDate(Date('Y-m-d')), $border, 0);
$pdf->Cell(26, 2, 'Waktu: ' . Date("H:i"), $border, 1, 'R');

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(0, 2, '-----------------------------------------------------------------------', $border, 2);

$total = 0;
$pdf->SetFont('Arial', '', 4);
foreach ($data as $row) {
    $pdf->Cell(0, 2, $row['nama'] . ' Warna ' . $row['warna'] . ' Ukuran ' . $row['ukuran'], $border, 2);
    $pdf->Cell(10, 2, $row['jumlah'] . 'x', $border, 0);
    $pdf->Cell(20, 2, 'Rp ' . number_format($row['harga'], 0, ",", "."), $border, 0);
    $pdf->Cell(22, 2, 'Rp ' . number_format($row['harga'] * $row['jumlah'], 0, ",", "."), $border, 1, 'R');
    $total += $row['harga'] * $row['jumlah'];
}

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(0, 2, '-----------------------------------------------------------------------', $border, 2);

$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(26, 2, 'Total', $border, 0);
$pdf->Cell(26, 2, 'Rp ' . number_format($total, 0, ",", "."), $border, 1, 'R');

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(0, 2, '-----------------------------------------------------------------------', $border, 2);

$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(26, 2, 'Tunai', $border, 0);
$pdf->Cell(26, 2, 'Rp ' . number_format($data[0]['tunai'], 0, ",", "."), $border, 1, 'R');
$pdf->Cell(26, 2, 'Kembalian', $border, 0);
$pdf->Cell(26, 2, 'Rp ' . number_format($data[0]['tunai'] - $total, 0, ",", "."), $border, 1, 'R');

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(0, 2, '-----------------------------------------------------------------------', $border, 2);



$pdf->Output();
