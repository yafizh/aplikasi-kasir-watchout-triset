<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../database/koneksi.php');

// Helper 
require_once('../helper/date.php');



if (isset($_SESSION['user'])) {
    if (isset($_GET['halaman'])) {
        // Laporan
        include_once('../route/laporan.php');

        // Ganti Password
        include_once('../route/ganti_password.php');

        // Riwayat Penjualan
        include_once('../route/riwayat_penjualan.php');

        // Cek Stok
        include_once('../route/cek_stok.php');

        // Pengguna
        include_once('../route/admin.php');
        include_once('../route/gudang.php');
        include_once('../route/kasir.php');

        // Stok
        include_once('../route/stok.php');

        // Pakaian
        include_once('../route/pakaian.php');

        // Kategori Pakaian
        include_once('../route/kategori_pakaian.php');

        // Warna Pakaian
        include_once('../route/warna.php');

        // Merk
        include_once('../route/merk.php');

        // Ukuran
        include_once('../route/ukuran.php');
    } else {
        if ($_SESSION['user']['status'] == 1 || $_SESSION['user']['status'] === 'GUDANG') {
            $title = 'Dashboard';
            $halaman = 'dashboard/index.php';
            $active = 'dashboard';
        } elseif ($_SESSION['user']['status'] == 2) {
            $title = 'Kasir';
            $halaman = 'kasir/index.php';
            $active = 'kasir';
        }
    }
} else {
    $title = 'Halaman Login';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <link rel="stylesheet" href="../assets/css/main/app.css">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="image/png">
    <?php if (isset($_SESSION['user'])) : ?>
        <?php if (in_array($_GET['halaman'] ?? '', ['tambah_stok_pakaian'])) : ?>
            <link rel="stylesheet" href="../assets/extensions/choices.js/public/assets/styles/choices.css">
        <?php endif; ?>

        <!-- <link rel="stylesheet" href="../assets/css/main/app-dark.css"> -->

        <link rel="stylesheet" href="../assets/css/shared/iconly.css">
        <link rel="stylesheet" href="../assets/extensions/sweetalert2/sweetalert2.min.css">

        <link rel="stylesheet" href="../assets/extensions/@fortawesome/fontawesome-free/css/all.min.css">
        <style>
            .fontawesome-icons {
                text-align: center;
            }

            article dl {
                background-color: rgba(0, 0, 0, .02);
                padding: 20px;
            }

            .fontawesome-icons .the-icon {
                font-size: 24px;
                line-height: 1.2;
            }

            /* body {
                zoom: .8;
                -moz-transform: scale(.8);
                -moz-transform-origin: 0 0;
            } */
        </style>


        <link rel="stylesheet" href="../assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="../assets/css/pages/datatables.css">

        <style>
            table {
                width: 100% !important;
            }

            .no-td {
                width: 5%;
                white-space: nowrap;
            }

            header {
                padding: 8px 32px;
                background-color: white;
            }
        </style>

        <?php if (in_array($_GET['halaman'] ?? '', ['tambah_warna_pakaian', 'edit_warna_pakaian', 'tambah_kasir', 'edit_kasir'])) : ?>
            <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
            <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
            <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet">
        <?php endif; ?>
    <?php else : ?>
        <link rel="stylesheet" href="../assets/css/pages/auth.css">
    <?php endif; ?>

    <script src="../helper/currency.js"></script>
    <style>
        html,
        body {
            min-height: 100% !important;
            height: 100%;
        }
    </style>
</head>

<body>
    <script src="../assets/js/initTheme.js"></script>
    <?php if (isset($_SESSION['user'])) : ?>
        <div id="app">
            <?php if ($_SESSION['user']['status'] == 1) : ?>
                <?php include_once('partials/sidebar.php'); ?>
            <?php elseif ($_SESSION['user']['status'] == 2) : ?>
                <?php include_once('partials/sidebar_kasir.php'); ?>
            <?php elseif ($_SESSION['user']['status'] === 'GUDANG') : ?>
                <?php include_once('partials/sidebar_gudang.php'); ?>
            <?php endif; ?>
            <header class="mb-3 d-flex justify-content-between align-items-center">
                <a id="burger" onclick="hideSidebar(this)" href="#" class="burger-btn d-block">
                    <i class="bi bi-justify fs-3 text-danger"></i>
                </a>
                <?php if ($_SESSION['user']['status'] == 2) : ?>
                    <div class="d-flex  align-items-center">
                        <img src="<?= $_SESSION['user']['foto']; ?>" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        <h5 class="mb-0"><?= $_SESSION['user']['nama']; ?></h5>
                    </div>
                <?php endif; ?>
            </header>
            <?php include_once($halaman); ?>
        </div>
    <?php else : ?>
        <div id="auth">
            <div class="row h-100 justify-content-center">
                <div class="col-md-6">
                    <?php include_once('auth/login.php'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['user'])) : ?>
        <script src="../assets/js/bootstrap.js"></script>
        <script src="../assets/js/app.js"></script>

        <script src="../assets/extensions/sweetalert2/sweetalert2.min.js"></script>

        <?php if (!isset($_GET['halaman'])) : ?>
            <script src="../assets/extensions/apexcharts/apexcharts.min.js"></script>
            <script src="../assets/js/pages/dashboard.js"></script>
        <?php endif; ?>

        <?php if (in_array($_GET['halaman'] ?? '', ['tambah_stok_pakaian'])) : ?>
            <script src="../assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
            <script src="../assets/js/pages/form-element-select.js"></script>
        <?php endif; ?>


        <script src="../assets/extensions/jquery/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
        <script src="../assets/js/pages/datatables.js"></script>

        <?php if (in_array($_GET['halaman'] ?? '', ['tambah_warna_pakaian', 'edit_warna_pakaian', 'tambah_kasir', 'edit_kasir'])) : ?>
            <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
            <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
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
                <?php if (in_array($_GET['halaman'] ?? '', ['edit_warna_pakaian', 'edit_kasir'])) : ?>
                    pond.addFile(document.querySelector('input[name=foto_pakaian]').value);
                <?php endif; ?>
            </script>
        <?php endif; ?>
        <script>
            if (document.querySelector('#tombol-hapus')) {
                document.querySelector('#tombol-hapus').addEventListener('click', function(e) {
                    Swal.fire({
                        title: 'Yakin?',
                        text: this.getAttribute('data-text'),
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: this.getAttribute('data-button-text')
                    }).then((result) => {
                        if (result.isConfirmed)
                            location.href = this.getAttribute('href');
                    });
                    e.preventDefault();
                });
            }
            if (sessionStorage.getItem('tambah')) {
                Swal.fire('Berhasil!',
                    sessionStorage.getItem('tambah'),
                    'success'
                );
                sessionStorage.removeItem('tambah');
            }
            if (sessionStorage.getItem('edit')) {
                Swal.fire('Berhasil!',
                    sessionStorage.getItem('edit'),
                    'success'
                );
                sessionStorage.removeItem('edit');
            }
            if (sessionStorage.getItem('hapus')) {
                Swal.fire('Berhasil!',
                    sessionStorage.getItem('hapus'),
                    'success'
                );
                sessionStorage.removeItem('hapus');
            }
        </script>
    <?php endif; ?>
    <script>
        function myFunction(x) {
            if (x.matches) // If media query matches
                document.querySelector('header').style.marginLeft = '0';
            else
                document.querySelector('header').style.marginLeft = '300px';
        }

        var x = window.matchMedia("(max-width: 1200px)")
        myFunction(x) // Call listener function at run time
        x.addListener(myFunction) // Attach listener function on state changes
        const hideSidebar = (element) => {
            if (element.parentElement.style.marginLeft == '0px')
                element.parentElement.style.marginLeft = '300px';
            else
                element.parentElement.style.marginLeft = '0';

        }
    </script>
</body>

</html>