<?php

$q = "DELETE FROM pakaian_disuplai WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>alert('Hapus Data Stok Berhasil!')</script>";
    echo "<script>location.href = '?halaman=riwayat_penambahan_stok';</script>";
} else {
    echo "<script>alert('Hapus Data Stok Gagal!')</script>";
    die($mysqli->error);
}
