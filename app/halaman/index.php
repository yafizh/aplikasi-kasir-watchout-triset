<?php 
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

if(isset($_GET['halaman'])){
}else {
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

</head>

<body>
    <script src="../assets/js/initTheme.js"></script>
    <div id="app">
        <?php include_once('partials/sidebar.php'); ?>
        <?php include_once($halaman); ?>
    </div>
    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/app.js"></script>

    <!-- Need: Apexcharts -->
    <script src="../assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/js/pages/dashboard.js"></script>

</body>

</html>