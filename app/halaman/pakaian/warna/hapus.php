<?php

$q = "DELETE FROM warna_pakaian WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>alert('Hapus Data Berhasil!')</script>";
    echo "<script>location.href = '?halaman=pakaian_per_warna&id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "&id_merk=" . $_GET['id_merk'] . "&id_pakaian=" . $_GET['id_pakaian'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
