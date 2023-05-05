<?php
if ($_GET['halaman'] === 'pakaian') {
    $title = 'Data Pakaian';
    $halaman = 'pakaian/index.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'tambah_pakaian') {
    $title = 'Tambah Pakaian';
    $halaman = 'pakaian/tambah.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'edit_pakaian') {
    $title = 'Edit Pakaian';
    $halaman = 'pakaian/edit.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'hapus_pakaian') {
    $title = 'Hapus Pakaian';
    $halaman = 'pakaian/hapus.php';
    $active = 'pakaian';
}

if ($_GET['halaman'] === 'tambah_warna_pakaian') {
    $title = 'Tambah Warna Pakaian';
    $halaman = 'pakaian/warna/tambah.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'edit_warna_pakaian') {
    $title = 'Edit Warna Pakaian';
    $halaman = 'pakaian/warna/edit.php';
    $active = 'pakaian';
} elseif ($_GET['halaman'] === 'hapus_warna_pakaian') {
    $title = 'Hapus Warna Pakaian';
    $halaman = 'pakaian/warna/hapus.php';
    $active = 'pakaian';
}
