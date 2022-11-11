<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../database/koneksi.php');



if (isset($_GET['halaman'])) {
    // Merk
    if ($_GET['halaman'] === 'merk') {
        $title = 'Data Merk';
        $halaman = 'merk/index.php';
        $active = 'merk';
    }
    if ($_GET['halaman'] === 'tambah_merk') {
        $title = 'Tambah Merk';
        $halaman = 'merk/tambah.php';
        $active = 'merk';
    }
    if ($_GET['halaman'] === 'edit_merk') {
        $title = 'Edit Merk';
        $halaman = 'merk/edit.php';
        $active = 'merk';
    }
    if ($_GET['halaman'] === 'hapus_merk') {
        $title = 'Hapus Merk';
        $halaman = 'merk/hapus.php';
        $active = 'merk';
    }

    // Ukuran
    if ($_GET['halaman'] === 'ukuran') {
        $title = 'Data Ukuran';
        $halaman = 'ukuran/index.php';
        $active = 'ukuran';
    }
    if ($_GET['halaman'] === 'tambah_ukuran') {
        $title = 'Tambah Ukuran';
        $halaman = 'ukuran/tambah.php';
        $active = 'ukuran';
    }
    if ($_GET['halaman'] === 'edit_ukuran') {
        $title = 'Edit Ukuran';
        $halaman = 'ukuran/edit.php';
        $active = 'ukuran';
    }
    if ($_GET['halaman'] === 'hapus_ukuran') {
        $title = 'Hapus Ukuran';
        $halaman = 'ukuran/hapus.php';
        $active = 'ukuran';
    }
} else {
    $title = 'Dashboard';
    $halaman = 'dashboard/index.php';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="../assets/css/main/app.css">
    <link rel="stylesheet" href="../assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="../assets/css/shared/iconly.css">

    <?php if (in_array($_GET['halaman'] ?? '', ['ukuran', 'merk', 'jenis_pakaian'])) : ?>
        <link rel="stylesheet" href="../assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="../assets/css/pages/datatables.css">
    <?php endif; ?>

    <style>
        .no-td {
            width: 5%;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <script src="../assets/js/initTheme.js"></script>
    <div id="app">
        <?php include_once('partials/sidebar.php'); ?>
        <?php include_once($halaman); ?>
    </div>
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/app.js"></script>

    <?php if (in_array($_GET['halaman'] ?? '', ['ukuran', 'merk', 'jenis_pakaian'])) : ?>
        <script src="../assets/extensions/jquery/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
        <script src="../assets/js/pages/datatables.js"></script>
    <?php endif; ?>
</body>

</html>