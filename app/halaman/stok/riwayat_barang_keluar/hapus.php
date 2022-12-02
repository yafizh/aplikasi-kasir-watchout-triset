<?php

$q = "DELETE FROM pakaian_terjual WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus riwayat barang keluar berhasil.')</script>";
    echo "<script>location.href = '?halaman=riwayat_barang_keluar';</script>";
} else {
    echo "<script>alert('Hapus Gagal!')</script>";
    die($mysqli->error);
}
