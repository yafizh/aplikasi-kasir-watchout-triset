<?php

$result = $mysqli->query('SELECT * FROM ukuran WHERE id=' . $_GET['id']);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);

    $q = "
    UPDATE ukuran SET 
        nama='$nama', 
        keterangan='$keterangan' 
    WHERE 
        id=" . $data['id'] . "
    ";

    if ($mysqli->query($q)) {
        echo "<script>sessionStorage.setItem('edit','Edit ukuran berhasil.')</script>";
        echo "<script>location.href = '?halaman=ukuran&id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "';</script>";
    } else {
        echo "<script>alert('Edit Data Gagal!')</script>";
        die($mysqli->error);
    }
}

?>
<div id="main">
    <?php
    $result = $mysqli->query('SELECT * FROM jenis_pakaian WHERE id=' . $_GET['id_jenis_pakaian']);
    $jenis_pakaian = $result->fetch_assoc();
    ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center mb-3">
                    <h3>Edit Data Ukuran <?= $jenis_pakaian['nama']; ?></h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <div class="row match-height justify-content-center">
                <div class="col-md-6 col-xxl-4 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical" action="" method="POST">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama">Ukuran</label>
                                                    <input type="text" id="nama" class="form-control" name="nama" autocomplete="off" required value="<?= $data['nama']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="keterangan">Keterangan</label>
                                                    <input type="text" id="keterangan" class="form-control" name="keterangan" autocomplete="off" required value="<?= $data['keterangan']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href="?halaman=ukuran&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>" class="btn btn-light-secondary mb-1">Kembali</a>
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