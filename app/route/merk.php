<?php
if ($_GET['halaman'] === 'merk') {
    $title = 'Data Merk';
    $halaman = 'merk/index.php';
    $active = 'merk';
} elseif ($_GET['halaman'] === 'tambah_merk') {
    $title = 'Tambah Merk';
    $halaman = 'merk/tambah.php';
    $active = 'merk';
} elseif ($_GET['halaman'] === 'edit_merk') {
    $title = 'Edit Merk';
    $halaman = 'merk/edit.php';
    $active = 'merk';
} elseif ($_GET['halaman'] === 'hapus_merk') {
    $title = 'Hapus Merk';
    $halaman = 'merk/hapus.php';
    $active = 'merk';
}
