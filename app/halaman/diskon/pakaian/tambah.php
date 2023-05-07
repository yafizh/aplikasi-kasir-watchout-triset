<?php

$result = $mysqli->query("SELECT * FROM diskon WHERE id=" . $_GET['id_diskon']);
$diskon = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $id_pakaian = $_POST['id_pakaian'];

    foreach ($id_pakaian as $id) {
        $q = "
        INSERT INTO diskon_pakaian (
            id_diskon,
            id_pakaian 
        ) VALUES (
            '" . $_GET['id_diskon'] . "',
            '$id' 
        )";
    }

    if ($mysqli->query($q)) {
        echo "<script>sessionStorage.setItem('tambah','Tambah diskon pakaian berhasil.')</script>";
        echo "<script>location.href = '?halaman=diskon_pakaian&id_diskon=" . $_GET['id_diskon'] . "';</script>";
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
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Nama Diskon</label>
                                                    <input type="text" class="form-control" value="<?= $diskon['nama']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <?php
                                                $query = "
                                                    SELECT 
                                                        p.* 
                                                    FROM 
                                                        pakaian p
                                                    WHERE 
                                                        p.id NOT IN (
                                                            SELECT 
                                                                pd.id_pakaian 
                                                            FROM 
                                                                diskon_pakaian pd 
                                                            WHERE 
                                                                pd.id_diskon=" . $diskon['id'] . "
                                                        )
                                                ";

                                                $result = $mysqli->query($query); ?>
                                                <div class="form-group">
                                                    <label for="id_pakaian">Pilih Pakaian</label>
                                                    <select class="choices form-select multiple-remove" multiple="multiple" name="id_pakaian[]" id="id_pakaian" required>
                                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                                            <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <a href="?halaman=diskon_pakaian&id_diskon=<?= $_GET['id_diskon']; ?>" class="btn btn-light-secondary mb-1">Kembali</a>
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

    document.querySelector('input[name=harga_toko]').addEventListener("keypress", function(evt) {
        if (evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
            return;
        }
        this.addEventListener('input', function() {
            const harga_toko = Number(((this.value).split('.')).join(''));
            this.value = formatNumberWithDot.format(harga_toko);
        });
    });
</script>