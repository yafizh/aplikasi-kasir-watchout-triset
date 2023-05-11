<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../database/koneksi.php');

// Helper 
require_once('../helper/date.php');

// Midtrans
require_once '../../vendor/autoload.php';
\Midtrans\Config::$serverKey = 'SB-Mid-server-HCIF3p71DZFdD9ZMWxf3aSAg';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$data = json_decode(file_get_contents('php://input'), true);

$order_id = 'OXA-' . rand();
$total = 0;
$query = "
    INSERT INTO penjualan_online (
        id_pembeli,
        order_id,
        tanggal_waktu,
        harga,
        status
    ) VALUES (
        " . $_GET['id_pembeli'] . ",
        '$order_id',
        '" . Date("Y-m-d H:i:s") . "',
        '" . $data['penjualan_online']['harga'] . "',
        1
    )
";
$mysqli->query($query);
$id_penjualan_online = $mysqli->insert_id;

if ($data['penjualan_online']['voucher_diskon'])
    $mysqli->query("INSERT INTO penjualan_online_voucher_diskon VALUES ($id_penjualan_online, " . $data['penjualan_online']['voucher_diskon'] . ")");

foreach ($data['pakaian'] as $value) {

    $query = "
        INSERT INTO detail_penjualan_online (
            id_penjualan_online,
            id_ukuran_warna_pakaian,
            harga,
            jumlah 
        ) VALUES (
            $id_penjualan_online,
            " . $value['id_ukuran_warna_pakaian'] . ",
            " . $value['harga'] . ",
            " . $value['jumlah'] . "
        )
    ";

    $total += $value['harga'];

    $mysqli->query($query);
    if ((int)$value['diskon'] > 0) {
        $query = "
            INSERT INTO detail_penjualan_online_diskon (
                id_detail_penjualan_online,
                id_diskon 
            ) VALUES (
                " . $mysqli->insert_id . ",
                " . $value['diskon'] . " 
            )
        ";

        $mysqli->query($query);
    }
    $mysqli->query("DELETE FROM keranjang WHERE id_pembeli=" . $_GET['id_pembeli']);
}



$params = array(
    'transaction_details' => array(
        'order_id' => $order_id,
        'gross_amount' => $total,
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);
echo json_encode($snapToken);
exit;
