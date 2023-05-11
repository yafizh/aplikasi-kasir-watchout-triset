<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../../database/koneksi.php');

// Helper 
require_once('../../helper/date.php');

if (!isset($_SESSION['user']['pembeli'])) {
    header('Location: ../index.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Watchout Triset</title>
    <link href="../../assets/css/main/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/shared/iconly.css">
    <style>
        @import "../../assets/css/main/fonts.css";

        body {
            font-family: 'Nunito';
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $active = 'profil'; ?>
        <?php include_once('partials/navbar.php'); ?>

        <section class="d-flex justify-content-center mb-5" style="min-height: 50vh;">
            <div class="w-100 d-flex align-items-center flex-column">
                <div style="width: fit-content;">
                    <ul class="nav justify-content-center nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="profil.php" class="nav-link <?= isset($_GET['halaman']) ? '' : 'active'; ?>">Profile</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="profil.php?halaman=riwayat_pembelian" class="nav-link <?= ($_GET['halaman'] ?? '') == 'riwayat_pembelian' ? 'active' : ''; ?>">Riwayat Pembelian</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="profil.php?halaman=ganti_password" class="nav-link <?= ($_GET['halaman'] ?? '') == 'ganti_password' ? 'active' : ''; ?>">Ganti Password</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="../auth/logout.php" class="nav-link">Keluar</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content w-100 row justify-content-center pt-3" id="pills-tabContent">
                    <?php if (isset($_GET['halaman'])) : ?>
                        <?php if ($_GET['halaman'] == 'riwayat_pembelian') : ?>
                            <?php include_once('profil/riwayat_pembelian.php'); ?>
                        <?php elseif ($_GET['halaman'] == 'ganti_password') : ?>
                            <?php include_once('profil/ganti_password.php'); ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php include_once('profil/profil.php'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>