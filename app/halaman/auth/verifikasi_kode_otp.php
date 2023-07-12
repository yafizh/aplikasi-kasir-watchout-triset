<?php
if (isset($_POST['submit'])) {
    $data = $mysqli->query("SELECT * FROM pendaftaran_pembeli WHERE id=" . $_GET['id_pendaftaran'])->fetch_assoc();
    $kode_otp = $mysqli->real_escape_string($_POST['kode_otp']);

    if ($kode_otp == $data['kode_otp']) {
        $query = "
            INSERT INTO pengguna (
                username,
                password,
                status 
            ) VALUES (
                '" . $data['nomor_telepon'] . "',
                '" . $data['password'] . "',
                '3'
            )
        ";
        if ($mysqli->query($query) === TRUE) {
            $last_id = $mysqli->insert_id;
            $query = "
                INSERT INTO pembeli (
                    id_pengguna,
                    nama,
                    nomor_telepon,
                    email,
                    tempat_lahir,
                    tanggal_lahir,
                    alamat  
                ) VALUES (
                    '" . $last_id . "',
                    '" . $data['nama'] . "',
                    '" . $data['nomor_telepon'] . "',
                    '',
                    '',
                    NULL,
                    ''
                )
            ";
            $mysqli->query($query);
            echo "<script>alert('Pendaftaran Berhasil, Silakan Login!')</script>";
            echo "<script>location.href = '?';</script>";
        }
    } else {
        echo "<script>alert('Kode OTP Invalid!')</script>";
    }
}
?>
<div id="auth-left" class="m-5 p-4 shadow rounded">
    <div class="auth-logo mb-4">
        <a href="online_store/index.php">
            <img src="../assets/images/logo.png" alt="Logo">
        </a>
    </div>
    <h1>Verifikasi Akun.</h1>
    <form action="" method="POST" class="mb-3">
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control" placeholder="KODE OTP" name="kode_otp" autocomplete="off">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block shadow text-white">Verifikasi</button>
    </form>
    <div class="text-center text-lg">
        <p><a class="font-bold" href="?">Login</a></p>
    </div>
</div>