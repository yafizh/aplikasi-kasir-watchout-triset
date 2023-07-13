<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../database/koneksi.php');

// Helper 
require_once('../helper/date.php');

if (isset($_GET['navbar'])) {
    $query = "
        SELECT 
            COUNT(*) jumlah
        FROM 
            keranjang 
        WHERE 
            id_pembeli=" . $_GET['id_pembeli'] . "
    ";
    $keranjang = $mysqli->query($query);
    if ($keranjang->num_rows) {
        echo $keranjang->fetch_assoc()['jumlah'];
    }
    exit;
}

if (isset($_GET['tambah'])) {
    $query = "
        SELECT 
            * 
        FROM 
            ukuran_warna_pakaian 
        WHERE 
            id_warna_pakaian=" . $_GET['id_warna'] . "
            AND 
            id_ukuran_pakaian=" . $_GET['id_ukuran'] . "    
        ";
    $result = $mysqli->query($query);

    if ($result->num_rows) {
        $ukuran_warna_pakaian = $result->fetch_assoc();
        $result = $mysqli->query("SELECT * FROM keranjang WHERE id_ukuran_warna_pakaian=" . $ukuran_warna_pakaian['id']);

        if ($result->num_rows) {
            $keranjang = $result->fetch_assoc();
            $query = "
                UPDATE keranjang SET 
                    jumlah=" . $keranjang['jumlah'] + $_GET['jumlah'] . "
                WHERE 
                    id_ukuran_warna_pakaian=" . $ukuran_warna_pakaian['id'] . " 
                    AND 
                    id_pembeli=" . $_GET['id_pembeli'] . " 
            ";
            echo $mysqli->query($query) ? 200 : 500;
        } else {
            $query = "
                INSERT INTO keranjang (
                    id_ukuran_warna_pakaian,
                    id_pembeli,
                    jumlah 
                ) VALUES (
                    " . $ukuran_warna_pakaian['id'] . ",
                    " . $_GET['id_pembeli'] . ",
                    " . $_GET['jumlah'] . "  
                )
            ";
            echo $mysqli->query($query) ? 200 : 500;
        }
    }

    exit;
}

if (isset($_GET['jumlah'])) {
    $query = "
        UPDATE 
            keranjang 
        SET 
            jumlah=" . $_GET['jumlah'] . " 
        WHERE 
            id_ukuran_warna_pakaian=" . $_GET['id_ukuran_warna_pakaian'] . " 
            AND 
            id_pembeli=" . $_GET['id_pembeli'] . " 
        ";
    $mysqli->query($query);
    return true;
}

if (isset($_GET['hapus'])) {
    $query = "
    DELETE FROM  
        keranjang 
    WHERE 
        id_ukuran_warna_pakaian=" . $_GET['id_ukuran_warna_pakaian'] . " 
        AND 
        id_pembeli=" . $_GET['id_pembeli'] . " 
    ";
    $mysqli->query($query);
    return true;
}

$query = "
    SELECT 
        uwp.id id_ukuran_warna_pakaian,
        p.*,
        wp.warna,
        up.ukuran,
        k.jumlah,
        (SELECT foto FROM foto_pakaian WHERE id_warna_pakaian=wp.id LIMIT 1) foto  
    FROM 
        keranjang k 
    INNER JOIN 
        ukuran_warna_pakaian uwp 
    ON 
        uwp.id=k.id_ukuran_warna_pakaian 
    INNER JOIN 
        warna_pakaian wp 
    ON 
        wp.id=uwp.id_warna_pakaian 
    INNER JOIN 
        ukuran_pakaian up 
    ON 
        up.id=uwp.id_ukuran_pakaian 
    INNER JOIN 
        pakaian p 
    ON 
        p.id=wp.id_pakaian 
    WHERE 
        id_pembeli=" . $_GET['id_pembeli'] . "
";
$result = $mysqli->query($query);
$pakaian = $result->fetch_all(MYSQLI_ASSOC);

$today = Date("Y-m-d");
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
            AND 
            d.id NOT IN (SELECT id_diskon FROM pengguna_diskon WHERE id_pengguna=" . ($_SESSION['user']['id'] ?? 0) . ")
    ";

    $result = $mysqli->query($query);
    $pakaian[$index]['diskon'] = $result->fetch_assoc();
}

$html = "";

if (count($pakaian)) {
    foreach ($pakaian as $row) {
        $html .= "
        <div class=\"card mb-3 item\" style=\"height: 10rem;\" data-id_ukuran_warna_pakaian=\"" . $row['id_ukuran_warna_pakaian'] . "\">
            <div class=\"card-body\">
                <div class=\"d-flex\">
                    <div class=\"flex-grow-1 d-flex\">
                        <div style=\"width: 8rem; height: 8rem;\">
                            <img src=\"" . '../' . $row['foto'] . "\" class=\"rounded\" style=\"width: 100%; height: 8rem; object-fit: cover;\">
                        </div>
                        <div class=\"px-3 py-1\">
                            <h5 class=\"mb-1\">" . $row['nama'] . "</h5>
                            <h6 class=\"mb-1 text-muted\">Warna: " . $row['warna'] . "</h6>
                            <h6 class=\"mb-2 text-muted\">Ukuran: " . $row['ukuran'] . "</h6>
                            <div class=\"d-flex\">
                                <div class=\"minus px-2 fs-5 border border-2\" style=\"cursor: pointer;\"><span style=\"display: block; margin-top: 1px;\">-</span></div>
                                <div contenteditable=\"\" class=\"jumlah px-2 border-top border-bottom border-2 fs-5 text-center\" style=\"width: 3rem; white-space: nowrap; overflow: hidden; padding-top: 2px;\">" . $row['jumlah'] . "</div>
                                <div class=\"plus px-2 fs-5 border border-2\" style=\"cursor: pointer;\"><span style=\"display: block; margin-top: 1px;\">+</span></div>
                            </div>
                        </div>
                    </div>
                    <div class=\"d-flex align-items-end flex-column justify-content-center\">";

        if ($row['diskon']) {
            $html .= "<p class=\"mb-0\"><del>Rp " . number_format($row['harga_toko'], 0, ',', '.') . "</del></p>";
            if ($row['diskon']['jenis_diskon'] == 1) {
                $html .= "<h5 
                class=\"harga\" 
                data-harga_toko=\"" . $row['harga_toko'] . "\" 
                data-harga_penjualan=\"" . $row['harga_toko'] - $row['diskon']['diskon'] . "\" 
                data-id_diskon=\"" . $row['diskon']['id'] . "\">
                    IDR " . number_format($row['harga_toko'] - $row['diskon']['diskon'], 0, ',', '.') . "
                </h5>";
            }
            if ($row['diskon']['jenis_diskon'] == 2) {
                $html .= "<h5 
                    class=\"harga\" 
                    data-harga_toko=\"" . $row['harga_toko'] . "\" 
                    data-harga_penjualan=\"" . $row['harga_toko'] * ($row['diskon']['diskon'] / 100) . "\" 
                    data-id_diskon=\"" . $row['id'] . "\">
                        IDR " . number_format($row['harga_toko'] * ($row['diskon']['diskon'] / 100), 0, ',', '.') . "
                    </h5>";
            }
        } else {
            $html .= "<h5 class=\"harga\" data-harga_toko=\"" . $row['harga_toko'] . "\" data-harga_penjualan=\"" . $row['harga_toko'] . "\" data-id_diskon=\"0\">IDR " . number_format($row['harga_toko'], 0, ',', '.') . "</h5>";
        }

        $html .= "</div>
                </div>
            </div>
        </div>
    ";
    }
} else {
    echo "<h4 class=\"text-center mt-5\">Keranjang Kosong</h4>";
}

echo $html;
