<?php

$result = $mysqli->query("SELECT * FROM merk WHERE id=" . $_GET['id_merk']);
$merk = $result->fetch_assoc();

$result = $mysqli->query("SELECT p.*, jp.nama AS jenis_pakaian, jp.id AS id_jenis_pakaian FROM pakaian AS p INNER JOIN jenis_pakaian AS jp ON jp.id=p.id_jenis_pakaian WHERE p.id=" . $_GET['id_pakaian']);
$pakaian = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $jumlah = $_POST['jumlah'];
    $id_warna_pakaian = $_POST['id_warna_pakaian'];
    $id_ukuran = $_POST['id_ukuran'] ?? [];
    $tanggal_masuk = Date("Y-m-d");

    foreach ($id_warna_pakaian as $warna_pakaian) {
        $result = $mysqli->query("SELECT * FROM ukuran_warna_pakaian WHERE id_warna_pakaian=" . $warna_pakaian);
        $ukuran = $result->fetch_all(MYSQLI_ASSOC);

        $lewat = false;
        $query = "
            INSERT INTO pakaian_disuplai (
                id_ukuran_warna_pakaian, 
                tanggal_masuk, 
                harga, 
                jumlah
            ) VALUES ";
        foreach ($id_ukuran as $id) {
            foreach ($ukuran as $value) {
                if ($id == $value['id_ukuran']) {
                    $query .= "(" . $value['id'] . ",'$tanggal_masuk'," . $pakaian['harga'] . ", $jumlah),";
                    $lewat = true;
                }
            }
        }
        $query = substr($query, 0, strlen($query) - 1);
        if ($lewat) {
            if (!$mysqli->query($query)) {
                echo "<script>alert('Tambah Data Stok Gagal!')</script>";
                die($mysqli->error);
            }
        }
    }

    echo "<script>alert('Tambah Data Stok Berhasil!')</script>";
    echo "<script>location.href = '?halaman=stok_per_pakaian&id_merk=" . $_GET['id_merk'] . "&id_pakaian=" . $_GET['id_pakaian'] . "';</script>";
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
                    <h3>Tambah Stok Pakaian</h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                <div class="row match-height justify-content-center align-items-stretch">
                    <div class="col-md-6 col-xxl-4 col-12">
                        <div class="card mb-0">
                            <div class="card-content">
                                <div class="card-body">
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
                                                    <label>Jenis Pakaian</label>
                                                    <input type="text" class="form-control" value="<?= $pakaian['jenis_pakaian']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" value="<?= $pakaian['nama']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <?php $result = $mysqli->query("SELECT warna_pakaian.id, warna.nama FROM warna_pakaian INNER JOIN warna ON warna.id=warna_pakaian.id_warna WHERE id_pakaian=" . $_GET['id_pakaian']); ?>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="id_warna_pakaian">Warna</label>
                                                        <select class="choices form-select multiple-remove" multiple="multiple" name="id_warna_pakaian[]" id="id_warna_pakaian" required>
                                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                                                <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <?php $result = $mysqli->query("SELECT * FROM ukuran WHERE id_jenis_pakaian=" . $pakaian['id_jenis_pakaian'] . " ORDER BY FIELD(nama, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), nama"); ?>
                                                <div class="form-group">
                                                    <label>Ukuran</label>
                                                    <ul class="list-unstyled mb-0">
                                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                                            <li class="d-inline-block me-2 mb-1">
                                                                <div class="form-check">
                                                                    <div class="checkbox">
                                                                        <input type="checkbox" class="form-check-input" name="id_ukuran[]" id="id_ukuran<?= $row['id']; ?>" value="<?= $row['id']; ?>">
                                                                        <label for="id_ukuran<?= $row['id']; ?>"><?= $row['nama']; ?></label>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php endwhile; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" required>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3 d-flex justify-content-between">
                                                <a href="?halaman=stok_per_pakaian&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $_GET['id_pakaian']; ?>" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1">Tambah</button>
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