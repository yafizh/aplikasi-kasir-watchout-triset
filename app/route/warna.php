<?php
if ($_GET['halaman'] === 'warna') {
    $title = 'Data Warna';
    $halaman = 'warna/index.php';
    $active = 'warna';
} elseif ($_GET['halaman'] === 'tambah_warna') {
    $title = 'Tambah Warna';
    $halaman = 'warna/tambah.php';
    $active = 'warna';
} elseif ($_GET['halaman'] === 'edit_warna') {
    $title = 'Edit Warna';
    $halaman = 'warna/edit.php';
    $active = 'warna';
} elseif ($_GET['halaman'] === 'hapus_warna') {
    $title = 'Hapus Warna';
    $halaman = 'warna/hapus.php';
    $active = 'warna';
}
