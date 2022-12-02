<?php
if ($_GET['halaman'] === 'riwayat_penjualan') {
    $title = 'Data Riwayat Penjualan';
    $halaman = 'riwayat_penjualan/index.php';
    $active = 'riwayat_penjualan';
} elseif ($_GET['halaman'] === 'edit_riwayat_penjualan') {
    $title = 'Edit Riwayat Penjualan';
    $halaman = 'riwayat_penjualan/edit.php';
    $active = 'riwayat_penjualan';
} elseif ($_GET['halaman'] === 'hapus_riwayat_penjualan') {
    $title = 'Hapus Riwayat Penjualan';
    $halaman = 'riwayat_penjualan/hapus.php';
    $active = 'riwayat_penjualan';
}
