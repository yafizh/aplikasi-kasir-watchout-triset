<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../database/koneksi.php');

// Helper 
require_once('../helper/date.php');



if(isset($_SESSION['user'])){
    if (isset($_GET['halaman'])) {
        // Stok
        include_once('../route/stok.php');
    
        // Pakaian
        include_once('../route/pakaian.php');
    
        // Jenis Pakaian
        include_once('../route/jenis_pakaian.php');
    
        // Warna Pakaian
        include_once('../route/warna.php');
    
        // Merk
        include_once('../route/merk.php');
    
        // Ukuran
        include_once('../route/ukuran.php');
    } else {
        $title = 'Dashboard';
        $halaman = 'dashboard/index.php';
        $active = 'dashboard';
    }
}else{
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

        <link rel="stylesheet" href="../assets/css/main/app-dark.css">
     
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
        </style>

        <?php if (in_array($_GET['halaman'] ?? '', ['tambah_warna_pakaian', 'edit_warna_pakaian'])) : ?>
            <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
            <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
            <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet">
        <?php endif; ?>
    <?php else : ?>
        <link rel="stylesheet" href="../assets/css/pages/auth.css">
    <?php endif; ?>
</head>

<body>
    <script src="../assets/js/initTheme.js"></script>
    <?php if (isset($_SESSION['user'])) : ?>
        <div id="app">
            <?php include_once('partials/sidebar.php'); ?>
            <?php include_once($halaman); ?>
        </div>
    <?php else : ?>
        <div id="auth">
            <div class="row h-100">
                <div class="col-lg-5 col-12">
                    <?php include_once('auth/login.php'); ?>
                </div>
                <div class="col-lg-7 d-none d-lg-block">
                    <div id="auth-right">

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['user'])) : ?>
        <script src="../assets/js/bootstrap.js"></script>
        <script src="../assets/js/app.js"></script>

        <script src="../assets/extensions/sweetalert2/sweetalert2.min.js"></script>>

        <?php if (in_array($_GET['halaman'] ?? '', ['tambah_stok_pakaian'])) : ?>
            <script src="../assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
            <script src="../assets/js/pages/form-element-select.js"></script>
        <?php endif; ?>


        <script src="../assets/extensions/jquery/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
        <script src="../assets/js/pages/datatables.js"></script>

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
</body>

</html>