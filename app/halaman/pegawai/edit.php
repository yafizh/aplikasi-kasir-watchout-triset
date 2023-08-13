<?php

$result = $mysqli->query('SELECT * FROM pegawai WHERE id=' . $_GET['id']);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);

    $q = "
    UPDATE pegawai SET 
        nama='$nama',
        tempat_lahir='$tempat_lahir',
        tanggal_lahir='$tanggal_lahir' 
    WHERE 
        id=" . $data['id'] . "
    ";

    if ($mysqli->query($q)) {
        echo "<script>sessionStorage.setItem('edit','Edit pegawai berhasil.')</script>";
        echo "<script>location.href = '?halaman=pegawai';</script>";
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
                    <h3>Edit Data Pegawai</h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <div class="row match-height justify-content-center">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical" action="" method="POST">
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
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href="?halaman=pegawai" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>