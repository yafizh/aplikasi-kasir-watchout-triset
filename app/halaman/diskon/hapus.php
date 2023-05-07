<?php

$q = "DELETE FROM diskon WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus diskon berhasil.')</script>";
    echo "<script>location.href = '?halaman=diskon';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
