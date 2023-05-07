<?php
if ($_GET['halaman'] === 'diskon_pakaian') {
    $title = 'Data Diskon Pakaian';
    $halaman = 'diskon/pakaian/index.php';
    $active = 'diskon';
} elseif ($_GET['halaman'] === 'tambah_diskon_pakaian') {
    $title = 'Tambah Diskon Pakaian';
    $halaman = 'diskon/pakaian/tambah.php';
    $active = 'diskon';
} elseif ($_GET['halaman'] === 'hapus_diskon_pakaian') {
    $title = 'Hapus Diskon Pakaian';
    $halaman = 'diskon/pakaian/hapus.php';
    $active = 'diskon';
}
