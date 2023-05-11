<?php

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $tanggal_mulai = $mysqli->real_escape_string($_POST['tanggal_mulai']);
    $tanggal_selesai = $mysqli->real_escape_string($_POST['tanggal_selesai']);
    $diskon = $mysqli->real_escape_string($_POST['diskon']);
    $jenis_diskon = $mysqli->real_escape_string($_POST['jenis_diskon']);
    $kode_voucher = $mysqli->real_escape_string($_POST['kode_voucher']);

    $q = "
    INSERT INTO voucher_diskon (
        nama,
        tanggal_mulai,
        tanggal_selesai,
        diskon,
        jenis_diskon,
        kode_voucher 
    ) VALUES (
        '$nama',
        '$tanggal_mulai',
        '$tanggal_selesai',
        '" . implode('', explode('.', $diskon)) . "',
        '$jenis_diskon',
        '$kode_voucher'
    )";

    if ($mysqli->query($q)) {
        echo "<script>sessionStorage.setItem('tambah','Tambah voucher diskon berhasil.')</script>";
        echo "<script>location.href = '?halaman=voucher_diskon';</script>";
    } else {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        die($mysqli->error);
    }
}

?>
<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center mb-3">
                    <h3><?= $title; ?></h3>
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
                                                    <input type="text" id="nama" class="form-control" name="nama" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                                    <input type="date" id="tanggal_mulai" class="form-control" name="tanggal_mulai" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                                    <input type="date" id="tanggal_selesai" class="form-control" name="tanggal_selesai" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="tanggal_selesai">Jenis Diskon</label>
                                                    <select name="jenis_diskon" id="jenis_diskon" class="form-control" required>
                                                        <option value="" selected disabled>Pilih Jenis Diskon</option>
                                                        <option value="1">Pengurangan Berdasarkan Nominal</option>
                                                        <option value="2">Pengurangan Berdasarkan Persentase</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="diskon">Diskon</label>
                                                    <input type="text" id="diskon" class="form-control" name="diskon" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="kode_voucher">Kode Voucher</label>
                                                    <input type="text" id="kode_voucher" class="form-control" name="kode_voucher" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href="?halaman=voucher_diskon" class="btn btn-light-secondary mb-1">Kembali</a>
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
    document.querySelector('input[name=diskon]').addEventListener("keypress", function(evt) {
        if (evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
            return;
        }
        this.addEventListener('input', function() {
            const diskon = Number(((this.value).split('.')).join(''));
            this.value = formatNumberWithDot.format(diskon);
        });
    });
</script>