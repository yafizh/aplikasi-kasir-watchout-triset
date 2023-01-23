<?php

$result = $mysqli->query(
    '
    SELECT 
        p.id AS id_pengguna,
        k.id AS id_kasir,
        k.nama,
        k.tempat_lahir,
        k.tanggal_lahir,
        k.foto,
        p.username,  
        p.password  
    FROM 
        pengguna AS p 
    INNER JOIN 
        kasir AS k 
    ON 
        k.id_pengguna=p.id 
    WHERE 
        p.id=' . $_GET['id']
);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $result = $mysqli->query("SELECT username FROM pengguna WHERE username='$username' AND id != " . $data['id_pengguna']);

    if (!$result->num_rows) {
        $target_dir = "../uploads/foto_kasir/";
        if (($target_dir . $_FILES['foto']['name']) != $data['foto']) {
            $foto = $target_dir . Date("YmdHis") . '.' . strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
            if (!move_uploaded_file($_FILES['foto']["tmp_name"], $foto))
                echo "<script>alert('Gagal meng-upload gambar!')</script>";
        } else {
            $foto = $data['foto'];
        }

        $q = "
        UPDATE pengguna SET 
            status=status 
            " . ($username == $data['username'] ? '' : ", username='$username'") . " 
            " . ($password == $data['password'] ? '' : ", password='$password'") . " 
        WHERE 
            id=" . $data['id_pengguna'] . "
        ";

        $q2 = "
        UPDATE kasir SET 
            nama='$nama',
            tempat_lahir='$tempat_lahir',
            tanggal_lahir='$tanggal_lahir', 
            foto='$foto' 
        WHERE 
            id=" . $data['id_kasir'] . "
        ";

        if ($mysqli->query($q) && $mysqli->query($q2)) {
            echo "<script>sessionStorage.setItem('edit','Edit kasir berhasil.')</script>";
            echo "<script>location.href = '?halaman=kasir';</script>";
        } else {
            echo "<script>alert('Edit Data Gagal!')</script>";
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
                    <h3>Edit Data Kasir</h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row match-height justify-content-center">
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" id="nama" class="form-control" name="nama" autocomplete="off" required value="<?= $data['nama']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input type="text" id="tempat_lahir" class="form-control" name="tempat_lahir" autocomplete="off" required value="<?= $data['tempat_lahir']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                    <input type="date" id="tanggal_lahir" class="form-control" name="tanggal_lahir" autocomplete="off" required value="<?= $data['tanggal_lahir']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" id="username" class="form-control" name="username" autocomplete="off" required value="<?= $data['username']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" id="password" class="form-control" name="password" autocomplete="off" required value="<?= $data['password']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href="?halaman=kasir" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Simpan</button>
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
                                                    <input type="text" name="foto_pakaian" value="<?= $data['foto']; ?>" hidden>
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