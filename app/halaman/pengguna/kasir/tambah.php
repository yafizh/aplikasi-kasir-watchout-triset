<?php

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $result = $mysqli->query("SELECT username FROM pengguna WHERE username='$username'");

    if (!$result->num_rows) {
        $target_dir = "../uploads/foto_kasir/";
        $foto = $target_dir . Date("YmdHis") . '.' . strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        $q = "
        INSERT INTO pengguna (
            username, 
            password, 
            status 
        ) VALUES (
            '$username',
            '$password',
            'KASIR'
        )";

        if ($mysqli->query($q)) {
            $id_pengguna = $mysqli->insert_id;

            if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
            if (!move_uploaded_file($_FILES['foto']["tmp_name"], $foto))
                echo "<script>alert('Gagal meng-upload gambar!')</script>";

            $q = "
                INSERT INTO kasir (
                    id_pengguna, 
                    nama, 
                    tempat_lahir, 
                    tanggal_lahir, 
                    foto 
                ) VALUES (
                    '$id_pengguna',
                    '$nama',
                    '$tempat_lahir',
                    '$tanggal_lahir',
                    '$foto'
                )";
            if ($mysqli->query($q)) {
                echo "<script>sessionStorage.setItem('tambah','Tambah kasir berhasil.')</script>";
                echo "<script>location.href = '?halaman=kasir';</script>";
                exit;
            } else {
                echo "<script>alert('Tambah Data Gagal!')</script>";
                die($mysqli->error);
            }
        } else {
            echo "<script>alert('Tambah Data Gagal!')</script>";
            die($mysqli->error);
        }
    } else {
        echo "<script>alert('Username telah digunakan!')</script>";
    }
}

?>
<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center mb-3">
                    <h3>Tambah Data Kasir</h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row match-height justify-content-center">
                    <div class="col-md-6 col-xxl-4 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" id="nama" class="form-control" name="nama" autofocus autocomplete="off" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input type="text" id="tempat_lahir" class="form-control" name="tempat_lahir" autocomplete="off" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                    <input type="date" id="tanggal_lahir" class="form-control" name="tanggal_lahir" autocomplete="off" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" id="username" class="form-control" name="username" autocomplete="off" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" id="password" class="form-control" name="password" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href="?halaman=kasir" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Tambah</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xxl-4 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Gambar</label>
                                                    <input type="file" name="foto" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>