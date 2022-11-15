<?php

$q = "DELETE FROM warna_pakaian WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus warna pakaian berhasil.')</script>";
    echo "<script>location.href = '?halaman=pakaian_per_warna&id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "&id_merk=" . $_GET['id_merk'] . "&id_pakaian=" . $_GET['id_pakaian'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
