<?php

$result = $mysqli->query('SELECT * FROM voucher_diskon WHERE id=' . $_GET['id']);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $tanggal_selesai = $mysqli->real_escape_string($_POST['tanggal_selesai']);
    $diskon = $mysqli->real_escape_string($_POST['diskon']);
    $jenis_diskon = $mysqli->real_escape_string($_POST['jenis_diskon']);
    $kode_voucher = $mysqli->real_escape_string($_POST['kode_voucher']);

    $q = "
    UPDATE voucher_diskon SET 
        tanggal_selesai='$tanggal_selesai',
        diskon='" . implode('', explode('.', $diskon)) . "',
        jenis_diskon='$jenis_diskon',
        kode_voucher='$kode_voucher' 
    WHERE 
        id=" . $data['id'];

    if ($mysqli->query($q)) {
        echo "<script>sessionStorage.setItem('edit','Edit voucher diskon berhasil.')</script>";
        echo "<script>location.href = '?halaman=voucher_diskon_ulang_tahun';</script>";
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
                    <h3><?= $title; ?></h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <div class="row match-height justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Pelanggan Yang Berulang Tahun</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Tanggal Lahir</th>
                                    </tr>
                                </thead>
                                <?php
                                $q = "
                                    SELECT 
                                        * 
                                    FROM 
                                        pembeli 
                                    WHERE 
                                        DAY(tanggal_lahir)='" . Date("d") . "' 
                                        AND 
                                        MONTH(tanggal_lahir)='" . Date("m") . "'     
                                    ORDER BY 
                                        nama";
                                $result = $mysqli->query($q);
                                ?>
                                <tbody>
                                    <?php if ($result->num_rows) : ?>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center"><?= $row['nama']; ?></td>
                                                <td class="text-center"><?= indonesiaDate($row['tanggal_lahir']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td class="text-center" colspan="2">Tidak Ada Yang Ulang Tahun</td>
                                            </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                                                    <input type="text" id="nama" disabled class="form-control" name="nama" autocomplete="off" required value="<?= $data['nama']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                                    <input type="date" id="tanggal_mulai" disabled class="form-control" name="tanggal_mulai" autocomplete="off" required value="<?= $data['tanggal_mulai']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                                    <input type="date" id="tanggal_selesai" class="form-control" name="tanggal_selesai" autocomplete="off" required value="<?= $data['tanggal_selesai']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="tanggal_selesai">Jenis Diskon</label>
                                                    <select name="jenis_diskon" id="jenis_diskon" class="form-control" required>
                                                        <option value="1" <?= $data['diskon'] == 1 ? 'selected' : '' ?>>Pengurangan Berdasarkan Nominal</option>
                                                        <option value="2" <?= $data['diskon'] == 2 ? 'selected' : '' ?>>Pengurangan Berdasarkan Persentase</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="diskon">Diskon</label>
                                                    <input type="text" id="diskon" class="form-control" name="diskon" autocomplete="off" required value="<?= number_format($data['diskon'], 0, ",", "."); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="kode_voucher">Kode Voucher</label>
                                                    <input type="text" id="kode_voucher" class="form-control" name="kode_voucher" autocomplete="off" required value="<?= $data['kode_voucher']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href="?halaman=voucher_diskon_ulang_tahun" class="btn btn-light-secondary mb-1">Kembali</a>
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