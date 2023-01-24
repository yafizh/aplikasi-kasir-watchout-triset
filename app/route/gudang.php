<?php
if ($_GET['halaman'] === 'gudang') {
    $title = 'Data Gudang';
    $halaman = 'pengguna/gudang/index.php';
    $active = 'pengguna';
    $sub_active = 'gudang';
} elseif ($_GET['halaman'] === 'tambah_gudang') {
    $title = 'Tambah Gudang';
    $halaman = 'pengguna/gudang/tambah.php';
    $active = 'pengguna';
    $sub_active = 'gudang';
} elseif ($_GET['halaman'] === 'edit_gudang') {
    $title = 'Edit Gudang';
    $halaman = 'pengguna/gudang/edit.php';
    $active = 'pengguna';
    $sub_active = 'gudang';
} elseif ($_GET['halaman'] === 'hapus_gudang') {
    $title = 'Hapus Gudang';
    $halaman = 'pengguna/gudang/hapus.php';
    $active = 'pengguna';
    $sub_active = 'gudang';
}
