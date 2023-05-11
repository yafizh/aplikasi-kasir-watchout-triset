<?php
if ($_GET['halaman'] === 'voucher_diskon') {
    $title = 'Data Voucher Diskon';
    $halaman = 'voucher_diskon/index.php';
    $active = 'voucher_diskon';
} elseif ($_GET['halaman'] === 'tambah_voucher_diskon') {
    $title = 'Tambah Voucher Diskon';
    $halaman = 'voucher_diskon/tambah.php';
    $active = 'voucher_diskon';
} elseif ($_GET['halaman'] === 'edit_voucher_diskon') {
    $title = 'Edit Voucher Diskon';
    $halaman = 'voucher_diskon/edit.php';
    $active = 'voucher_diskon';
} elseif ($_GET['halaman'] === 'hapus_voucher_diskon') {
    $title = 'Hapus Voucher Diskon';
    $halaman = 'voucher_diskon/hapus.php';
    $active = 'voucher_diskon';
}
