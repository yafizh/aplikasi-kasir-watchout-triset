<?php
if ($_GET['halaman'] === 'stok') {
    $title = 'Data Stok';
    $halaman = 'stok/index.php';
    $active = 'stok';
    $sub_active = 'stok_pakaian';
} elseif ($_GET['halaman'] === 'tambah_stok') {
    $title = 'Suplai Pakaian';
    $halaman = 'stok/tambah.php';
    $active = 'stok';
    $sub_active = 'stok_pakaian';
}

if ($_GET['halaman'] === 'riwayat_penambahan_stok') {
    $title = 'Riwayat Penambahan Stok';
    $halaman = 'stok/riwayat_penambahan/index.php';
    $active = 'stok';
    $sub_active = 'riwayat_penambahan_stok';
}
if ($_GET['halaman'] === 'edit_riwayat_penambahan_stok') {
    $title = 'Edit Riwayat Penambahan Stok';
    $halaman = 'stok/riwayat_penambahan/edit.php';
    $active = 'stok';
    $sub_active = 'riwayat_penambahan_stok';
}
if ($_GET['halaman'] === 'hapus_riwayat_penambahan_stok') {
    $title = 'Hapus Riwayat Penambahan Stok';
    $halaman = 'stok/riwayat_penambahan/hapus.php';
    $active = 'stok';
    $sub_active = 'riwayat_penambahan_stok';
}

if ($_GET['halaman'] === 'riwayat_barang_keluar') {
    $title = 'Riwayat Barang Keluar';
    $halaman = 'stok/riwayat_barang_keluar/index.php';
    $active = 'stok';
    $sub_active = 'riwayat_barang_keluar';
}
if ($_GET['halaman'] === 'edit_riwayat_barang_keluar') {
    $title = 'Edit Riwayat Barang Keluar';
    $halaman = 'stok/riwayat_barang_keluar/edit.php';
    $active = 'stok';
    $sub_active = 'riwayat_barang_keluar';
}
if ($_GET['halaman'] === 'hapus_riwayat_barang_keluar') {
    $title = 'Hapus Riwayat Barang Keluar';
    $halaman = 'stok/riwayat_barang_keluar/hapus.php';
    $active = 'stok';
    $sub_active = 'riwayat_barang_keluar';
}
