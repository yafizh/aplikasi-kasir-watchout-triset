<?php
if ($_GET['halaman'] === 'admin') {
    $title = 'Data Admin';
    $halaman = 'pengguna/admin/index.php';
    $active = 'pengguna';
    $sub_active = 'admin';
} elseif ($_GET['halaman'] === 'tambah_admin') {
    $title = 'Tambah Admin';
    $halaman = 'pengguna/admin/tambah.php';
    $active = 'pengguna';
    $sub_active = 'admin';
} elseif ($_GET['halaman'] === 'edit_admin') {
    $title = 'Edit Admin';
    $halaman = 'pengguna/admin/edit.php';
    $active = 'pengguna';
    $sub_active = 'admin';
} elseif ($_GET['halaman'] === 'hapus_admin') {
    $title = 'Hapus Admin';
    $halaman = 'pengguna/admin/hapus.php';
    $active = 'pengguna';
    $sub_active = 'admin';
}
