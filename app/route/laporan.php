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
} elseif ($_GET['halaman'] === 'laporan_barang_masuk') {
    $title = 'Laporan Barang Masuk';
    $halaman = 'laporan/laporan_barang_masuk.php';
    $active = 'laporan';
    $sub_active = 'laporan_barang_masuk';
} elseif ($_GET['halaman'] === 'laporan_barang_keluar') {
    $title = 'Laporan Barang Keluar';
    $halaman = 'laporan/laporan_barang_keluar.php';
    $active = 'laporan';
    $sub_active = 'laporan_barang_keluar';
} elseif ($_GET['halaman'] === 'laporan_grafik_penjualan') {
    $title = 'Laporan Grafik Penjualan';
    $halaman = 'laporan/laporan_grafik_penjualan.php';
    $active = 'laporan';
    $sub_active = 'laporan_grafik_penjualan';
}
