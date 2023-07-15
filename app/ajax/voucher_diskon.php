<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../database/koneksi.php');

// Helper 
require_once('../helper/date.php');

$today = Date("Y-m-d");
$query = "
    SELECT 
        * 
    FROM 
        voucher_diskon 
    WHERE 
        kode_voucher = '" . $_GET['kode_voucher'] . "' 
        AND 
        (
            '$today' >= tanggal_mulai 
            AND 
            '$today' <= tanggal_selesai
        ) 
        AND 
        ulang_tahun IS FALSE 
        AND 
        " . ($_SESSION['user']['id'] ?? 0) . " NOT IN (SELECT id_pengguna FROM pengguna_voucer_diskon WHERE id_voucher_diskon=voucher_diskon.id) 
";
$result = $mysqli->query($query);

if ($result->num_rows < 1) {
    $result = $mysqli->query("SELECT DAY(tanggal_lahir) as hari, MONTH(tanggal_lahir) as bulan FROM pembeli WHERE id_pengguna=" . $_SESSION['user']['id'])->fetch_assoc();
    $query = "
        SELECT 
            * 
        FROM 
            voucher_diskon 
        WHERE 
            kode_voucher = '" . $_GET['kode_voucher'] . "' 
            AND 
            (
                '$today' >= tanggal_mulai 
                AND 
                '$today' <= tanggal_selesai
            ) 
            AND 
            ulang_tahun IS TRUE 
            AND 
            (
                DAY(tanggal_mulai) = '".$result['hari']."' 
                AND 
                MONTH(tanggal_mulai) = '".$result['bulan']."' 
            )
            AND 
            " . ($_SESSION['user']['id'] ?? 0) . " NOT IN (SELECT id_pengguna FROM pengguna_voucer_diskon WHERE id_voucher_diskon=voucher_diskon.id) 
    ";
    $result = $mysqli->query($query);
    echo json_encode($result->fetch_assoc());
} else
    echo json_encode($result->fetch_assoc());
