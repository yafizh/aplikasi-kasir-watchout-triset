<?php

$q = "DELETE FROM pengguna WHERE id=" . $_GET['id_pengguna'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus pembeli berhasil.')</script>";
    echo "<script>location.href = '?halaman=pembeli';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
