<?php
if ($_GET['halaman'] === 'kategori_pakaian') {
    $title = 'Data Kategori Pakaian';
    $halaman = 'kategori_pakaian/index.php';
    $active = 'kategori_pakaian';
} elseif ($_GET['halaman'] === 'tambah_kategori_pakaian') {
    $title = 'Tambah Kategori Pakaian';
    $halaman = 'kategori_pakaian/tambah.php';
    $active = 'kategori_pakaian';
} elseif ($_GET['halaman'] === 'edit_kategori_pakaian') {
    $title = 'Edit Kategori Pakaian';
    $halaman = 'kategori_pakaian/edit.php';
    $active = 'kategori_pakaian';
} elseif ($_GET['halaman'] === 'hapus_kategori_pakaian') {
    $title = 'Hapus Kategori Pakaian';
    $halaman = 'kategori_pakaian/hapus.php';
    $active = 'kategori_pakaian';
}
