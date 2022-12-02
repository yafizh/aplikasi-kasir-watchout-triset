<?php

$q = "DELETE FROM penjualan WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus Riwayat Penjualan Berhasil!.')</script>";
    echo "<script>location.href = '?halaman=riwayat_penjualan';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
