<?php

$q = "DELETE FROM diskon_pakaian WHERE id_diskon=" . $_GET['id_diskon'] . " AND id_pakaian=" . $_GET['id_pakaian'];
if ($mysqli->query($q)) {
    echo "<script>sessionStorage.setItem('hapus','Hapus diskon pakaian berhasil.')</script>";
    echo "<script>location.href = '?halaman=diskon_pakaian&id_diskon=" . $_GET['id_diskon'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
