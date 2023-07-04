<?php
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $nomor_telepon = $mysqli->real_escape_string($_POST['nomor_telepon']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $konfirmasi_password = $mysqli->real_escape_string($_POST['konfirmasi_password']);

    if ($password == $konfirmasi_password) {
        $query = "
            INSERT INTO pengguna (
                username,
                password,
                status 
            ) VALUES (
                '" . $nomor_telepon . "',
                '" . $password . "',
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
                    '" . $nama . "',
                    '" . $nomor_telepon . "',
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
        echo "<script>alert('Password tidak sama!')</script>";
    }
    if ($result->num_rows) {
        $_SESSION['user'] = $result->fetch_assoc();
        if ($_SESSION['user']['status'] == 3) {
            $query = "
                SELECT 
                    * 
                FROM 
                    pembeli 
                WHERE 
                    id_pengguna=" . $_SESSION['user']['id'] . "
            ";
            $result = $mysqli->query($query);
            $_SESSION['user']['pembeli'] = $result->fetch_assoc();
            echo "<script>location.href = 'online_store/index.php';</script>";
        } else
            echo "<script>location.href = '?';</script>";
    } else {
        echo "<script>alert('username atau password salah')</script>";
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