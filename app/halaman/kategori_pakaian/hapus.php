<?php

$q = "DELETE FROM kategori_pakaian WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus kategori pakaian berhasil.')</script>";
    echo "<script>location.href = '?halaman=kategori_pakaian';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
