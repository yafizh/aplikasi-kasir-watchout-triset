<?php

$q = "DELETE FROM pegawai WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus pegawai berhasil.')</script>";
    echo "<script>location.href = '?halaman=pegawai';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
