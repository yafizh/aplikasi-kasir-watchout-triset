<?php

$q = "DELETE FROM jenis_pakaian WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus jenis pakaian berhasil.')</script>";
    echo "<script>location.href = '?halaman=jenis_pakaian';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
