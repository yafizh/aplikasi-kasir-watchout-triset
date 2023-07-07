<?php
if ($_GET['halaman'] === 'pembeli') {
    $title = 'Data Pembeli';
    $halaman = 'pengguna/pembeli/index.php';
    $active = 'pengguna';
    $sub_active = 'pembeli';
} elseif ($_GET['halaman'] === 'edit_pembeli') {
    $title = 'Edit Pembeli';
    $halaman = 'pengguna/pembeli/edit.php';
    $active = 'pengguna';
    $sub_active = 'pembeli';
} elseif ($_GET['halaman'] === 'hapus_pembeli') {
    $title = 'Hapus Pembeli';
    $halaman = 'pengguna/pembeli/hapus.php';
    $active = 'pengguna';
    $sub_active = 'pembeli';
}
