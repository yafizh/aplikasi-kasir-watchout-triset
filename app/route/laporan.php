<?php
if ($_GET['halaman'] === 'laporan_pakaian') {
    $title = 'Laporan Pakaian';
    $halaman = 'laporan/laporan_pakaian.php';
    $active = 'laporan';
    $sub_active = 'laporan_pakaian';
} elseif ($_GET['halaman'] === 'laporan_penjualan') {
    $title = 'Laporan Penjualan';
    $halaman = 'laporan/laporan_penjualan.php';
    $active = 'laporan';
    $sub_active = 'laporan_penjualan';
}
