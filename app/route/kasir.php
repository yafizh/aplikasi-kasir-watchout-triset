<?php
if ($_GET['halaman'] === 'kasir') {
    $title = 'Data Kasir';
    $halaman = 'pengguna/kasir/index.php';
    $active = 'pengguna';
    $sub_active = 'kasir';
} elseif ($_GET['halaman'] === 'tambah_kasir') {
    $title = 'Tambah Kasir';
    $halaman = 'pengguna/kasir/tambah.php';
    $active = 'pengguna';
    $sub_active = 'kasir';
} elseif ($_GET['halaman'] === 'edit_kasir') {
    $title = 'Edit Kasir';
    $halaman = 'pengguna/kasir/edit.php';
    $active = 'pengguna';
    $sub_active = 'kasir';
} elseif ($_GET['halaman'] === 'hapus_kasir') {
    $title = 'Hapus Kasir';
    $halaman = 'pengguna/kasir/hapus.php';
    $active = 'pengguna';
    $sub_active = 'kasir';
}
