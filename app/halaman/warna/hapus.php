<?php

$q = "DELETE FROM warna WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus warna berhasil.')</script>";
    echo "<script>location.href = '?halaman=warna';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
