<?php

$q = "DELETE FROM warna_pakaian WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus warna pakaian berhasil.')</script>";
    echo "<script>location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
