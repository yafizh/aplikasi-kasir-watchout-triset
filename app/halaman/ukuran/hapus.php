<?php

$q = "DELETE FROM ukuran WHERE id=" . $_GET['id'];
if ($mysqli->query($q)) {
    echo "<script>alert('Hapus Data Berhasil!')</script>";
    echo "<script>location.href = '?halaman=ukuran&id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
