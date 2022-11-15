<?php

$q = "DELETE FROM pakaian WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus pakaian berhasil.')</script>";
    echo "<script>location.href = '?halaman=pakaian_per_jenis&id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "&id_merk=" . $_GET['id_merk'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
