<?php
if ($_GET['halaman'] === 'penjualan_menunggu_pembayaran') {
    $title = 'Menunggu Pembayaran';
    $halaman = 'penjualan/menunggu_pembayaran/index.php';
    $active = 'penjualan';
    $sub_active = 'penjualan_menunggu_pembayaran';
} elseif ($_GET['halaman'] === 'detail_penjualan_menunggu_pembayaran') {
    $title = 'Detail Menunggu Pemayaran';
    $halaman = 'penjualan/menunggu_pembayaran/detail.php';
    $active = 'penjualan';
    $sub_active = 'detail_penjualan_menunggu_pembayaran';
}

if ($_GET['halaman'] === 'penjualan_pesanan_diproses') {
    $title = 'Pesanan Diproses';
    $halaman = 'penjualan/pesanan_diproses/index.php';
    $active = 'penjualan';
    $sub_active = 'penjualan_pesanan_diproses';
} elseif ($_GET['halaman'] === 'detail_penjualan_pesanan_diproses') {
    $title = 'Detail Pesanan Diproses';
    $halaman = 'penjualan/pesanan_diproses/detail.php';
    $active = 'penjualan';
    $sub_active = 'detail_penjualan_pesanan_diproses';
}

if ($_GET['halaman'] === 'penjualan_pesanan_selesai') {
    $title = 'Pesanan Selesai';
    $halaman = 'penjualan/pesanan_selesai/index.php';
    $active = 'penjualan';
    $sub_active = 'penjualan_pesanan_selesai';
} elseif ($_GET['halaman'] === 'detail_penjualan_pesanan_selesai') {
    $title = 'Detail Pesanan Selesai';
    $halaman = 'penjualan/pesanan_selesai/detail.php';
    $active = 'penjualan';
    $sub_active = 'detail_penjualan_pesanan_selesai';
}

if ($_GET['halaman'] === 'penjualan_pesanan_dibatalkan') {
    $title = 'Pesanan Dibatalkan';
    $halaman = 'penjualan/pesanan_dibatalkan/index.php';
    $active = 'penjualan';
    $sub_active = 'penjualan_pesanan_dibatalkan';
} elseif ($_GET['halaman'] === 'detail_penjualan_pesanan_dibatalkan') {
    $title = 'Detail Pesanan Dibatalkan';
    $halaman = 'penjualan/pesanan_dibatalkan/detail.php';
    $active = 'penjualan';
    $sub_active = 'detail_penjualan_pesanan_dibatalkan';
}

if ($_GET['halaman'] === 'penjualan_pesanan_dikembalikan') {
    $title = 'Pesanan Dikembalikan';
    $halaman = 'penjualan/pesanan_dikembalikan/index.php';
    $active = 'penjualan';
    $sub_active = 'penjualan_pesanan_dikembalikan';
} elseif ($_GET['halaman'] === 'detail_penjualan_pesanan_dikembalikan') {
    $title = 'Detail Pesanan Dikembalikan';
    $halaman = 'penjualan/pesanan_dikembalikan/detail.php';
    $active = 'penjualan';
    $sub_active = 'detail_penjualan_pesanan_dikembalikan';
}
