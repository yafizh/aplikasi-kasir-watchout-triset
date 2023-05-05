<?php
$result = $mysqli->query("SELECT * FROM merk WHERE id=" . $_GET['id_merk']);
$merk = $result->fetch_assoc();

$result = $mysqli->query("SELECT * FROM kategori_pakaian WHERE id=" . $_GET['id_kategori_pakaian']);
$kategori_pakaian = $result->fetch_assoc();
if (isset($_POST['submit'])) {
    $id_merk = $merk['id'];
    $id_kategori_pakaian = $kategori_pakaian['id'];
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $harga_modal = $mysqli->real_escape_string($_POST['harga_modal']);
    $harga_toko = $mysqli->real_escape_string($_POST['harga_toko']);
    $ukuran = json_decode($_POST['ukuran']);

    try {
        $mysqli->begin_transaction();

        $q = "
        INSERT INTO pakaian (
            id_merk, 
            id_kategori_pakaian, 
            nama, 
            harga_modal, 
            harga_toko
        ) VALUES (
            '" . $id_merk . "',
            '" . $id_kategori_pakaian . "',
            '" . $nama . "',
            '" . implode(explode('.', $harga_modal)) . "',
            '" . implode(explode('.', $harga_toko)) . "'
        )";
        $mysqli->query($q);
        $id_pakaian = $mysqli->insert_id;

        foreach ($ukuran as $value) {
            $q = "
            INSERT INTO ukuran_pakaian (
                id_pakaian,
                ukuran
            ) VALUES (
                '" . $id_pakaian . "',
                '" . strtoupper($value->value) . "' 
            )";
            $mysqli->query($q);
        }

        $mysqli->commit();
        echo "<script>sessionStorage.setItem('tambah','Tambah pakaian berhasil.')</script>";
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
                    <h3><?= $title; ?></h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <form class="form form-vertical" action="" method="POST">
                <div class="row match-height justify-content-center align-items-stretch">
                    <div class="col-md-6 col-12 mb-3">
                        <div class="card mb-0">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Merk</label>
                                                    <input type="text" class="form-control" disabled value="<?= $merk['nama']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Kategori Pakaian</label>
                                                    <input type="text" class="form-control" disabled value="<?= $kategori_pakaian['nama']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <div class="card mb-0">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="nama">Nama Pakaian</label>
                                                    <input type="text" class="form-control" name="nama" id="nama" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="harga_modal">Harga Modal</label>
                                                    <input type="text" class="form-control" name="harga_modal" id="harga_modal" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="harga_toko">Harga Toko</label>
                                                    <input type="text" class="form-control" name="harga_toko" id="harga_toko" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="ukuran">Ukuran</label>
                                                    <input type="text" class="form-control text-uppercase" name="ukuran" id="ukuran" required>
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
<script>
    document.querySelector('input[name=harga_modal]').addEventListener("keypress", function(evt) {
        if (evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
            return;
        }
        this.addEventListener('input', function() {
            const harga_modal = Number(((this.value).split('.')).join(''));
            this.value = formatNumberWithDot.format(harga_modal);
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