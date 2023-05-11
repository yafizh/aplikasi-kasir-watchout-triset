<?php

$q = "DELETE FROM voucher_diskon WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus voucher diskon berhasil.')</script>";
    echo "<script>location.href = '?halaman=voucher_diskon';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
