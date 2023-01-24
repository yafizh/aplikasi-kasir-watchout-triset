<?php

$q = "DELETE FROM pengguna WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus gudang berhasil.')</script>";
    echo "<script>location.href = '?halaman=gudang';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
