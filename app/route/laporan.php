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
} elseif ($_GET['halaman'] === 'laporan_penjualan_online') {
    $title = 'Laporan Penjualan';
    $halaman = 'laporan/laporan_penjualan_online.php';
    $active = 'laporan';
    $sub_active = 'laporan_penjualan_online';
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
} elseif ($_GET['halaman'] === 'laporan_mutasi_pakaian') {
    $title = 'Laporan Mutasi Pakaian';
    $halaman = 'laporan/laporan_mutasi_pakaian.php';
    $active = 'laporan';
    $sub_active = 'laporan_mutasi_pakaian';
} elseif ($_GET['halaman'] === 'laporan_pakaian_terlaris') {
    $title = 'Laporan Mutasi Pakaian';
    $halaman = 'laporan/laporan_pakaian_terlaris.php';
    $active = 'laporan';
    $sub_active = 'laporan_pakaian_terlaris';
}
