<?php
if ($_GET['halaman'] === 'ganti_password') {
    $title = 'Ganti Password';
    $halaman = 'ganti_password/index.php';
    $active = 'ganti_password_sendiri';

    if (isset($_GET['id'])){
        $active = 'ganti_password';
        $sub_active = 'kasir';
    }
}
