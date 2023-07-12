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
            $nomor_telepon = "62".substr($nomor_telepon,1);
        }
        if ($nomor_telepon[0] == '+') {
            $omor_telepon = substr($nomor_telepon,1);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/send-message");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            "number={$nomor_telepon}@c.us&message=Kode OTP anda adalah {$kode_otp}"
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

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