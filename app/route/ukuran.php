<?php
if ($_GET['halaman'] === 'ukuran') {
    $title = 'Data Ukuran';
    $halaman = 'ukuran/index.php';
    $active = 'ukuran';
} elseif ($_GET['halaman'] === 'tambah_ukuran') {
    $title = 'Tambah Ukuran';
    $halaman = 'ukuran/tambah.php';
    $active = 'ukuran';
} elseif ($_GET['halaman'] === 'edit_ukuran') {
    $title = 'Edit Ukuran';
    $halaman = 'ukuran/edit.php';
    $active = 'ukuran';
} elseif ($_GET['halaman'] === 'hapus_ukuran') {
    $title = 'Hapus Ukuran';
    $halaman = 'ukuran/hapus.php';
    $active = 'ukuran';
}
