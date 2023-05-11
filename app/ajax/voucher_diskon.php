<?php
session_start();

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
        kode_voucher = '".$_GET['kode_voucher']."' 
        AND 
        (
            '$today' >= tanggal_mulai 
            AND 
            '$today' <= tanggal_selesai
        )
";
$result = $mysqli->query($query);
echo json_encode($result->fetch_assoc());