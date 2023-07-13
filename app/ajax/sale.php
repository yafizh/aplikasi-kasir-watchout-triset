<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../database/koneksi.php');

// Helper 
require_once('../helper/date.php');

$today = Date("Y-m-d");
$query = "
    SELECT DISTINCT
        p.*,
        (SELECT foto FROM foto_pakaian fp INNER JOIN warna_pakaian wp ON wp.id=fp.id_warna_pakaian WHERE wp.id_pakaian=p.id LIMIT 1) foto 
    FROM 
        pakaian p 
    INNER JOIN 
        warna_pakaian wp 
    ON 
        p.id=wp.id_pakaian 
    WHERE 
        p.id IN (
            SELECT 
                dp.id_pakaian 
            FROM 
                diskon d 
            INNER JOIN 
                diskon_pakaian dp 
            ON  
                dp.id_diskon=d.id 
            WHERE 
                '$today' >= d.tanggal_mulai 
                AND 
                '$today' <= d.tanggal_selesai 
                AND 
                d.id NOT IN (SELECT id_diskon FROM pengguna_diskon WHERE id_pengguna=" . ($_SESSION['user']['id'] ?? 0) . ")
        )";

if (isset($_GET['id_kategori_pakaian'])) {
    $query .= " AND ( ";
    foreach (explode(',', $_GET['id_kategori_pakaian']) as $i => $id) {
        if ($i) {
            $query .= " OR ";
        }
        $query .= " p.id_kategori_pakaian=$id";
    }
    $query .= " ) ";
}
if (isset($_GET['id_merk'])) {
    $query .= " AND ( ";
    foreach (explode(',', $_GET['id_merk']) as $i => $id) {
        if ($i) {
            $query .= " OR ";
        }
        $query .= " p.id_merk=$id";
    }
    $query .= " ) ";
}
if (isset($_GET['warna'])) {
    $query .= " AND ( ";
    foreach (explode(',', $_GET['warna']) as $i => $warna) {
        if ($i) {
            $query .= " OR ";
        }
        $query .= " wp.warna='$warna'";
    }
    $query .= " ) ";
}
$result = $mysqli->query($query);
$pakaian = $result->fetch_all(MYSQLI_ASSOC);

foreach ($pakaian as $index => $value) {
    $query = "
        SELECT 
            d.* 
        FROM 
            diskon_pakaian dp 
        INNER JOIN 
            diskon d 
        ON 
            dp.id_diskon=d.id  
        WHERE
            ( 
                '$today' >= d.tanggal_mulai 
                AND 
                '$today' <= d.tanggal_selesai  
            ) 
            AND 
            dp.id_pakaian=" . $value['id'] . "
    ";
    $result = $mysqli->query($query);
    $pakaian[$index]['diskon'] = $result->fetch_assoc();
}

$html = "";
foreach ($pakaian as $row) {
    $html .= "
    <div class=\"col-6 col-md-4 col-lg-3 item rounded\" data-id_pakaian=" . $row['id'] . ">
        <div class=\"position-relative\" style=\"overflow: hidden;\">";
    if ($row['diskon']) {
        $html .= "
            <div class=\"position-absolute pt-3\" style=\"z-index: 999;\">
                <h6 class=\"bg-danger py-2 px-3 mb-0 text-white\" style=\"border-bottom-right-radius: .3rem; border-top-right-radius: .3rem;\">Sale</h6>
            </div>
            ";
    }
    $html .= "<img src=\"" . '../' . $row['foto'] . "\" class=\"rounded\">
        </div>
        <div class=\"body px-2 pt-3 pb-1\">
            <h5>" . $row['nama'] . "</h5>";

    if ($row['diskon']) {
        $html .= "<p class=\"text-muted mb-0\"><del>IDR " . number_format($row['harga_toko'], 0, ',', '.') . "</del></p>";
        if ($row['diskon']['jenis_diskon'] == 1) {
            $html .= "<h5 class=\"text-success\">IDR " . number_format($row['harga_toko'] - $row['diskon']['diskon'], 0, ',', '.') . "</h5>";
        }
        if ($row['diskon']['jenis_diskon'] == 2) {
            $html .= "<h5 class=\"text-success\">IDR " . number_format($row['harga_toko'] * ($row['diskon']['diskon'] / 100), 0, ',', '.') . "</h5>";
        }
    } else {
        $html .= "<p class=\"text-muted mb-0\">IDR " . number_format($row['harga_toko'], 0, ',', '.') . "</p>";
    }
    $html .= "</div>
    </div>
";
}

echo $html;
