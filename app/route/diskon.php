<?php
if ($_GET['halaman'] === 'diskon') {
    $title = 'Data Diskon';
    $halaman = 'diskon/index.php';
    $active = 'diskon';
} elseif ($_GET['halaman'] === 'tambah_diskon') {
    $title = 'Tambah Diskon';
    $halaman = 'diskon/tambah.php';
    $active = 'diskon';
} elseif ($_GET['halaman'] === 'edit_diskon') {
    $title = 'Edit Diskon';
    $halaman = 'diskon/edit.php';
    $active = 'diskon';
} elseif ($_GET['halaman'] === 'hapus_diskon') {
    $title = 'Hapus Diskon';
    $halaman = 'diskon/hapus.php';
    $active = 'diskon';
}
