<?php

$result = $mysqli->query(
    "
    SELECT 
        jp.id AS id_jenis_pakaian,
        m.id AS id_merk,
        p.id,
        p.nama,
        jp.nama AS jenis_pakaian,
        m.nama AS merk 
    FROM 
        pakaian AS p 
    INNER JOIN 
        merk AS m 
    ON 
        m.id=p.id_merk 
    INNER JOIN 
        jenis_pakaian AS jp 
    ON 
        jp.id=p.id_jenis_pakaian 
    WHERE 
        p.id=" . $_GET['id']
);
$data = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $harga = $mysqli->real_escape_string($_POST['harga']);

    $q = "
    UPDATE pakaian SET 
        nama='$nama', 
        harga='$harga' 
    WHERE 
        id=" . $data['id'];

    if ($mysqli->query($q)) {
        echo "<script>sessionStorage.setItem('edit','Edit pakaian berhasil.')</script>";
        echo "<script>location.href = '?halaman=pakaian_per_jenis&id_jenis_pakaian=" . $data['id_jenis_pakaian'] . "&id_merk=" . $data['id_merk'] . "';</script>";
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
                    <h3>Edit Data Pakaian</h3>
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
                                                    <input type="text" class="form-control" value="<?= $data['merk']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama">Jenis Pakaian</label>
                                                    <input type="text" class="form-control" value="<?= $data['jenis_pakaian']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" id="nama" class="form-control" name="nama" autocomplete="off" required value="<?= $data['nama']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="harga">Harga</label>
                                                    <input type="text" id="harga" class="form-control" name="harga" autocomplete="off" required value="<?= $data['nama']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3 d-flex justify-content-between">
                                                <a href="?halaman=pakaian_per_jenis&id_merk=<?= $data['id_merk']; ?>&id_jenis_pakaian=<?= $data['id_jenis_pakaian']; ?>" class="btn btn-light-secondary mb-1">Kembali</a>
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