<?php

$result = $mysqli->query("SELECT * FROM merk WHERE id=" . $_GET['id_merk']);
$merk = $result->fetch_assoc();

$result = $mysqli->query("SELECT * FROM jenis_pakaian WHERE id=" . $_GET['id_jenis_pakaian']);
$jenis_pakaian = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $harga = implode('', explode('.', $_POST['harga']));

    $q = "
    INSERT INTO pakaian (
        id_merk, 
        id_jenis_pakaian, 
        nama, 
        harga 
    ) VALUES (
        " . $merk['id'] . ",
        " . $jenis_pakaian['id'] . ",
        '$nama',
        '$harga'
    )";

    if ($mysqli->query($q)) {
        echo "<script>sessionStorage.setItem('tambah','Tambah pakaian berhasil.')</script>";
        echo "<script>location.href = '?halaman=pakaian_per_jenis&id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "&id_merk=" . $_GET['id_merk'] . "';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}

?>
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center mb-3">
                    <h3>Tambah Data Pakaian</h3>
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
                                                    <label>Merk</label>
                                                    <input type="text" class="form-control" value="<?= $merk['nama']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama">Jenis Pakaian</label>
                                                    <input type="text" class="form-control" value="<?= $jenis_pakaian['nama']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" id="nama" class="form-control" name="nama" autofocus autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="harga">Harga</label>
                                                    <input type="text" id="harga" class="form-control" name="harga" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3 d-flex justify-content-between">
                                                <a href="?halaman=pakaian_per_jenis&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $_GET['id_merk']; ?>" class="btn btn-light-secondary mb-1">Kembali</a>
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
<script>
    document.querySelector('input[name=harga]').addEventListener("keypress", function(evt) {
        if (evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
            return;
        }

        this.addEventListener('input', function() {
            const harga = Number(((this.value).split('.')).join(''));
            this.value = formatNumberWithDot.format(harga);
        });
    });
</script>