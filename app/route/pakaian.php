<?php
if ($_GET['halaman'] === 'pakaian') {
    $title = 'Data Pakaian';
    $halaman = 'pakaian/index.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'tambah_pakaian') {
    $title = 'Tambah Pakaian';
    $halaman = 'pakaian/tambah_pakaian.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'tambah_warna_pakaian') {
    $title = 'Tambah Warna Pakaian';
    $halaman = 'pakaian/tambah_warna_pakaian.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'edit_pakaian') {
    $title = 'Edit Pakaian';
    $halaman = 'pakaian/edit_pakaian.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'hapus_pakaian') {
    $title = 'Hapus Pakaian';
    $halaman = 'pakaian/hapus_pakaian.php';
    $active = 'pakaian';
}