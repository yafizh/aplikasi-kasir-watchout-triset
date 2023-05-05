<?php

$q = "DELETE FROM pakaian WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus pakaian berhasil.')</script>";
    echo "<script>location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
