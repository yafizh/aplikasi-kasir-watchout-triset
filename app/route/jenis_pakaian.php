<?php
if ($_GET['halaman'] === 'jenis_pakaian') {
    $title = 'Data Jenis Pakaian';
    $halaman = 'jenis_pakaian/index.php';
    $active = 'jenis_pakaian';
} elseif ($_GET['halaman'] === 'tambah_jenis_pakaian') {
    $title = 'Tambah Jenis Pakaian';
    $halaman = 'jenis_pakaian/tambah.php';
    $active = 'jenis_pakaian';
} elseif ($_GET['halaman'] === 'edit_jenis_pakaian') {
    $title = 'Edit Jenis Pakaian';
    $halaman = 'jenis_pakaian/edit.php';
    $active = 'jenis_pakaian';
} elseif ($_GET['halaman'] === 'hapus_jenis_pakaian') {
    $title = 'Hapus Jenis Pakaian';
    $halaman = 'jenis_pakaian/hapus.php';
    $active = 'jenis_pakaian';
}
