<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../database/koneksi.php');



if (isset($_GET['halaman'])) {
    // Pakaian
    if ($_GET['halaman'] === 'pakaian') {
        $title = 'Data Pakaian';
        $halaman = 'pakaian/index-admin.php';
        $active = 'pakaian';
    }
    if ($_GET['halaman'] === 'pakaian_per_merk') {
        $title = 'Data Pakaian';
        $halaman = 'pakaian/index_per_merk-admin.php';
        $active = 'pakaian';
    }
    if ($_GET['halaman'] === 'pakaian_per_warna') {
        $title = 'Data Pakaian';
        $halaman = 'pakaian/warna/index.php';
        $active = 'pakaian';
    }

    if ($_GET['halaman'] === 'tambah_pakaian') {
        $title = 'Tambah Pakaian';
        $halaman = 'pakaian/tambah.php';
        $active = 'pakaian';
    }
    if ($_GET['halaman'] === 'tambah_warna_pakaian') {
        $title = 'Tambah Warna Pakaian';
        $halaman = 'pakaian/warna/tambah.php';
        $active = 'pakaian';
    }

    if ($_GET['halaman'] === 'edit_pakaian') {
        $title = 'Edit Pakaian';
        $halaman = 'pakaian/edit.php';
        $active = 'pakaian';
    }
    if ($_GET['halaman'] === 'edit_warna_pakaian') {
        $title = 'Edit Warna Pakaian';
        $halaman = 'pakaian/warna/edit.php';
        $active = 'pakaian';
    }
    if ($_GET['halaman'] === 'hapus_pakaian') {
        $title = 'Hapus Pakaian';
        $halaman = 'pakaian/hapus.php';
        $active = 'pakaian';
    }
    if ($_GET['halaman'] === 'hapus_warna_pakaian') {
        $title = 'Hapus Pakaian';
        $halaman = 'pakaian/warna/hapus.php';
        $active = 'pakaian';
    }

    // Jenis Pakaian
    if ($_GET['halaman'] === 'jenis_pakaian') {
        $title = 'Data Jenis Pakaian';
        $halaman = 'jenis_pakaian/index.php';
        $active = 'jenis_pakaian';
    }
    if ($_GET['halaman'] === 'tambah_jenis_pakaian') {
        $title = 'Tambah Jenis Pakaian';
        $halaman = 'jenis_pakaian/tambah.php';
        $active = 'jenis_pakaian';
    }
    if ($_GET['halaman'] === 'edit_jenis_pakaian') {
        $title = 'Edit Jenis Pakaian';
        $halaman = 'jenis_pakaian/edit.php';
        $active = 'jenis_pakaian';
    }
    if ($_GET['halaman'] === 'hapus_jenis_pakaian') {
        $title = 'Hapus Jenis Pakaian';
        $halaman = 'jenis_pakaian/hapus.php';
        $active = 'jenis_pakaian';
    }

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

    <?php if (in_array($_GET['halaman'] ?? '', [''])) : ?>
        <link rel="stylesheet" href="../assets/extensions/choices.js/public/assets/styles/choices.css">
    <?php endif; ?>

    <link rel="stylesheet" href="../assets/css/main/app.css">
    <link rel="stylesheet" href="../assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="../assets/css/shared/iconly.css">

    <?php if (in_array($_GET['halaman'] ?? '', ['ukuran', 'merk', 'jenis_pakaian', 'pakaian', 'pakaian_per_warna', 'pakaian_per_merk'])) : ?>
        <link rel="stylesheet" href="../assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="../assets/css/pages/datatables.css">
    <?php endif; ?>

    <style>
        .no-td {
            width: 5%;
            white-space: nowrap;
        }
    </style>

    <?php if (in_array($_GET['halaman'] ?? '', ['tambah_warna_pakaian', 'edit_warna_pakaian'])) : ?>
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
        <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet">
    <?php endif; ?>
</head>

<body>
    <script src="../assets/js/initTheme.js"></script>
    <div id="app">
        <?php include_once('partials/sidebar.php'); ?>
        <?php include_once($halaman); ?>
    </div>
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/app.js"></script>
    <link rel="stylesheet" href="../assets/extensions/@fortawesome/fontawesome-free/css/all.min.css">

    <?php if (in_array($_GET['halaman'] ?? '', ['ukuran', 'merk', 'jenis_pakaian', 'pakaian', 'pakaian_per_warna', 'pakaian_per_merk'])) : ?>
        <script src="../assets/extensions/jquery/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
        <script src="../assets/js/pages/datatables.js"></script>
    <?php endif; ?>

    <?php if (in_array($_GET['halaman'] ?? '', ['tambah_warna_pakaian', 'edit_warna_pakaian'])) : ?>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>+
        <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

        <script>
            // Register the plugin
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateType,
                FilePondPluginImageEdit,
                FilePondPluginImageExifOrientation,
            );

            // ... FilePond initialisation code here
            const pond = FilePond.create(document.querySelector('input[type=file]'), {
                credits: false,
                name: 'foto',
                storeAsFile: true,
                required: true,
                acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'],
                fileValidateTypeDetectType: (source, type) =>
                    new Promise((resolve, reject) => {
                        // Do custom type detection here and return with promise

                        resolve(type);
                    }),
            });
            <?php if (in_array($_GET['halaman'] ?? '', ['edit_warna_pakaian'])) : ?>
                pond.addFile(document.querySelector('input[name=foto_pakaian]').value);
            <?php endif; ?>
        </script>
    <?php endif; ?>
</body>

</html>