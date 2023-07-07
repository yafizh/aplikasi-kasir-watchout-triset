<?php

$result = $mysqli->query("SELECT * FROM pembeli WHERE id=" . $_GET['id']);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $nomor_telepon = $mysqli->real_escape_string($_POST['nomor_telepon']);
    $email = $mysqli->real_escape_string($_POST['email']);

    $q = "
        UPDATE pembeli SET 
            nama='$nama',
            tempat_lahir='$tempat_lahir',
            tanggal_lahir='$tanggal_lahir',
            nomor_telepon='$nomor_telepon',
            email='$email' 
        WHERE 
            id=" . $data['id'] . "
    ";

    $q2 = "
        UPDATE pengguna SET 
            username='$nomor_telepon' 
        WHERE 
            id=" . $data['id_pengguna'] . "
    ";

    if ($mysqli->query($q) && $mysqli->query($q2)) {
        echo "<script>sessionStorage.setItem('edit','Edit pembeli berhasil.')</script>";
        echo "<script>location.href = '?halaman=pembeli';</script>";
    } else {
        echo "<script>alert('Edit Data Gagal!')</script>";
        die($mysqli->error);
    }
}

?>
<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center mb-3">
                    <h3>Edit Data Pembeli</h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <form action="" method="POST">
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
                                                    <label for="nomor_telepon">Nomor Telepon</label>
                                                    <input type="text" id="nomor_telepon" class="form-control" name="nomor_telepon" autocomplete="off" required value="<?= $data['nomor_telepon']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="text" id="email" class="form-control" name="email" autocomplete="off" required value="<?= $data['email']; ?>">
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
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" id="username" disabled value="<?= $data['nomor_telepon']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href="?halaman=pembeli" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Simpan</button>
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
<script>
    document.querySelector("input[name=nomor_telepon]").addEventListener('input', function() {
        document.getElementById('username').value = this.value;
    });
</script>