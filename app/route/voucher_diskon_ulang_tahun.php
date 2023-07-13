<?php
if ($_GET['halaman'] === 'voucher_diskon_ulang_tahun') {
    $title = 'Data Voucher Diskon Ulang Tahun';
    $halaman = 'voucher_diskon_ulang_tahun/index.php';
    $active = 'voucher_diskon_ulang_tahun';
} elseif ($_GET['halaman'] === 'tambah_voucher_diskon_ulang_tahun') {
    $title = 'Tambah Voucher Diskon Ulang Tahun';
    $halaman = 'voucher_diskon_ulang_tahun/tambah.php';
    $active = 'voucher_diskon_ulang_tahun';
} elseif ($_GET['halaman'] === 'edit_voucher_diskon_ulang_tahun') {
    $title = 'Edit Voucher Diskon Ulang Tahun';
    $halaman = 'voucher_diskon_ulang_tahun/edit.php';
    $active = 'voucher_diskon_ulang_tahun';
} elseif ($_GET['halaman'] === 'hapus_voucher_diskon_ulang_tahun') {
    $title = 'Hapus Voucher Diskon Ulang Tahun';
    $halaman = 'voucher_diskon_ulang_tahun/hapus.php';
    $active = 'voucher_diskon_ulang_tahun';
}
