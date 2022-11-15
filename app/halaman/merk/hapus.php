<?php

$q = "DELETE FROM merk WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus merk berhasil.')</script>";
    echo "<script>location.href = '?halaman=merk';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
