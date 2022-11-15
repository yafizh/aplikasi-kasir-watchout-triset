<?php 
if ($_GET['halaman'] === 'pakaian') {
    $title = 'Data Pakaian';
    $halaman = 'pakaian/index.php';
    $active = 'pakaian';
}

if ($_GET['halaman'] === 'pakaian_per_jenis') {
    $title = 'Data Pakaian';
    $halaman = 'pakaian/jenis_pakaian/index.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'tambah_pakaian') {
    $title = 'Tambah Pakaian';
    $halaman = 'pakaian/jenis_pakaian/tambah.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'edit_pakaian') {
    $title = 'Edit Pakaian';
    $halaman = 'pakaian/jenis_pakaian/edit.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'hapus_pakaian') {
    $title = 'Hapus Pakaian';
    $halaman = 'pakaian/jenis_pakaian/hapus.php';
    $active = 'pakaian';
}

if ($_GET['halaman'] === 'pakaian_per_warna') {
    $title = 'Data Pakaian';
    $halaman = 'pakaian/warna/index.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'tambah_warna_pakaian') {
    $title = 'Tambah Warna Pakaian';
    $halaman = 'pakaian/warna/tambah.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'edit_warna_pakaian') {
    $title = 'Edit Warna Pakaian';
    $halaman = 'pakaian/warna/edit.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'hapus_warna_pakaian') {
    $title = 'Hapus Pakaian';
    $halaman = 'pakaian/warna/hapus.php';
    $active = 'pakaian';
}