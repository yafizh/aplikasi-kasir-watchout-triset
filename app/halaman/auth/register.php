<?php
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $nomor_telepon = $mysqli->real_escape_string($_POST['nomor_telepon']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $konfirmasi_password = $mysqli->real_escape_string($_POST['konfirmasi_password']);

    $kode_otp = strtoupper(substr(uniqid(), 7, 6));
    if ($password == $konfirmasi_password) {
        $query = "
            INSERT INTO pendaftaran_pembeli (
                nama,
                nomor_telepon,
                password,
                kode_otp 
            ) VALUES (
                '" . $nama . "',
                '" . $nomor_telepon . "',
                '" . $password . "',
                '" . $kode_otp . "'
            )
        ";
        $mysqli->query($query);

        if ($nomor_telepon[0] == '0') {
            $nomor_telepon = '62' . substr($nomor_telepon, 1);
        }
        if ($nomor_telepon[0] == '+') {
            $nomor_telepon = substr($nomor_telepon, 1);
        }

        $data = array(
            'chatId' => $nomor_telepon . '@c.us',
            'message' => "Kode OTP anda adalah {$kode_otp}"
        );

        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data)
            )
        );

        $context = stream_context_create($options);

        $url = 'https://api.greenapi.com/waInstance7103873268/sendMessage/a517f96a093b48e79b730d97abc92f24a726f25032b14c9ead';
        $response = file_get_contents($url, false, $context);

        echo "<script>alert('Verifikasi Akun Anda!')</script>";
        echo "<script>location.href = '?halaman=verifikasi&id_pendaftaran=" . $mysqli->insert_id . "';</script>";
    } else {
        echo "<script>alert('Password tidak sama!')</script>";
    }
}
?>
<div id="auth-left" class="m-5 p-4 shadow rounded">
    <div class="auth-logo mb-4">
        <a href="online_store/index.php">
            <img src="../assets/images/logo.png" alt="Logo">
        </a>
    </div>
    <h1>Daftar Baru.</h1>
    <form action="" method="POST" class="mb-3">
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control" placeholder="Nama" name="nama" autocomplete="off">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control" placeholder="Nomor Telepon" name="nomor_telepon" autocomplete="off">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input disabled type="text" class="form-control" placeholder="Username" name="username" autocomplete="off">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control" placeholder="Konfirmasi Password" name="konfirmasi_password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block shadow text-white">Register</button>
    </form>
    <div class="text-center text-lg">
        <p><a class="font-bold" href="?">Login</a></p>
    </div>
</div>
<script>
    document.querySelector('input[name=nomor_telepon]').addEventListener('input', function() {
        document.querySelector('input[name=username]').value = this.value;
    });
</script>