<?php

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);

    $q = "
    INSERT INTO ukuran (
        id_jenis_pakaian, 
        nama
    ) VALUES (
        " . $_GET['id_jenis_pakaian'] . ",
        '$nama'
    )";

    if ($mysqli->query($q)) {
        echo "<script>sessionStorage.setItem('tambah','Tambah ukuran berhasil.')</script>";
        echo "<script>location.href = '?halaman=ukuran&id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
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
                    <h3>Tambah Data Ukuran <?= $jenis_pakaian['nama']; ?></h3>
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
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama">Ukuran</label>
                                                    <input type="text" id="nama" class="form-control" name="nama" autofocus autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href="?halaman=ukuran&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Tambah</button>
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