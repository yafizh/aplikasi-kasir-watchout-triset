<?php
$query = "
    SELECT 
        m.nama merk,
        kp.nama kategori_pakaian, 
        p.*
    FROM 
        pakaian p 
    INNER JOIN 
        merk m 
    ON 
        m.id=p.id_merk 
    INNER JOIN 
        kategori_pakaian kp  
    ON 
        kp.id=p.id_kategori_pakaian  
    WHERE 
        p.id=" . $_GET['id_pakaian'] . "
";
$result = $mysqli->query($query);
$pakaian = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $id_warna_pakaian = $_POST['id_warna_pakaian'] ?? [];
    $id_ukuran_pakaian = $_POST['id_ukuran_pakaian'] ?? [];
    $jumlah = $_POST['jumlah'];
    $tanggal_masuk = Date("Y-m-d");

    try {
        $mysqli->begin_transaction();

        foreach ($id_warna_pakaian as $value1) {
            foreach ($id_ukuran_pakaian as $value2) {
                $ukuran_warna_pakaian = $mysqli->query("SELECT * FROM ukuran_warna_pakaian WHERE id_ukuran_pakaian=" . $value2 . " AND id_warna_pakaian=" . $value1);
                $q = "
                INSERT INTO pakaian_disuplai (
                    id_ukuran_warna_pakaian, 
                    tanggal_masuk, 
                    harga, 
                    jumlah
                ) VALUES (
                    " . $ukuran_warna_pakaian->fetch_assoc()['id'] . ",
                    '" . $tanggal_masuk . "',
                    '" . $pakaian['harga_modal'] . "',
                    '" . $jumlah . "'
                )";
                $mysqli->query($q);
            }
        }

        $mysqli->commit();
        echo "<script>sessionStorage.setItem('tambah','Suplai stok berhasil.')</script>";
        echo "<script>location.href = '" . $_SESSION['prev_url'] . "';</script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Tambah Data Gagal!')</script>";
        var_dump($e);
        $mysqli->rollback();
    };
}
$_SESSION['prev_url'] = $_SERVER['HTTP_REFERER'];

?>
<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center mb-3">
                    <h3>Suplai Pakaian</h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <form class="form form-vertical" action="" method="POST">
                <div class="row match-height justify-content-center align-items-stretch">
                    <div class="col-md-6 col-xxl-4 col-12 mb-3">
                        <div class="card mb-0">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Merk</label>
                                                    <input type="text" class="form-control" value="<?= $pakaian['merk']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Kategori Pakaian</label>
                                                    <input type="text" class="form-control" value="<?= $pakaian['kategori_pakaian']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Nama Pakaian</label>
                                                    <input type="text" class="form-control" value="<?= $pakaian['nama']; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xxl-4 col-12 mb-3">
                        <div class="card mb-0">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <?php $result = $mysqli->query("SELECT wp.id, wp.warna FROM warna_pakaian wp WHERE id_pakaian=" . $_GET['id_pakaian']); ?>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="id_warna_pakaian">Warna</label>
                                                        <select class="choices form-select multiple-remove" multiple="multiple" name="id_warna_pakaian[]" id="id_warna_pakaian" required>
                                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                                                <option value="<?= $row['id']; ?>"><?= $row['warna']; ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <?php $result = $mysqli->query("SELECT up.id, up.ukuran FROM ukuran_pakaian up WHERE id_pakaian=" . $_GET['id_pakaian']); ?>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="id_ukuran_pakaian">Ukuran</label>
                                                        <select class="choices form-select multiple-remove" multiple="multiple" name="id_ukuran_pakaian[]" id="id_ukuran_pakaian" required>
                                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                                                <option value="<?= $row['id']; ?>"><?= $row['ukuran']; ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" required>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3 d-flex justify-content-between">
                                                <a href="<?= $_SESSION['prev_url']; ?>" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Tambah</button>
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