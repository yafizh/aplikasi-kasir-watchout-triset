<?php
$query = "
SELECT 
    p.*,
    m.nama merk,
    kp.nama kategori_pakaian,
    (
        SELECT 
            GROUP_CONCAT(up.ukuran SEPARATOR ' ') 
        FROM 
            ukuran_pakaian up 
        WHERE 
            up.id_pakaian=p.id 
    ) ukuran,
    (
        SELECT 
            COUNT(id) 
        FROM 
            warna_pakaian wp 
        WHERE 
            wp.id_pakaian=p.id
    ) warna_pakaian
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
    p.id=" . $_GET['id'];
$result = $mysqli->query($query);

$data = $result->fetch_assoc();

$result = $mysqli->query("SELECT * FROM ukuran_pakaian WHERE id_pakaian=" . $data['id']);
$ukuran_lama = [];
while ($row = $result->fetch_assoc()) {
    $ukuran_lama[] = $row['ukuran'];
}

if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $harga_modal = $mysqli->real_escape_string($_POST['harga_modal']);
    $harga_toko = $mysqli->real_escape_string($_POST['harga_toko']);
    $ukuran = json_decode($_POST['ukuran']);

    try {
        $mysqli->begin_transaction();

        $q = "
        UPDATE pakaian SET
            nama='" . $nama . "', 
            harga_modal='" . implode(explode('.', $harga_modal)) . "', 
            harga_toko='" . implode(explode('.', $harga_toko)) . "' 
        WHERE 
            id=" . $data['id'];
        $mysqli->query($q);

        foreach ($ukuran as $value) {
            if (!in_array(strtoupper($value->value), $ukuran_lama)) {
                $q = "
                INSERT INTO ukuran_pakaian (
                    id_pakaian,
                    ukuran
                ) VALUES (
                    '" . $data['id'] . "',
                    '" . strtoupper($value->value) . "' 
                )";
                $mysqli->query($q);
                $id_ukuran_pakaian = $mysqli->insert_id;

                $warna_pakaian = $mysqli->query("SELECT * FROM warna_pakaian WHERE id_pakaian=" . $data['id']);
                if ($warna_pakaian->num_rows) {
                    while ($row = $warna_pakaian->fetch_assoc()) {
                        $query = "
                        INSERT INTO ukuran_warna_pakaian (
                            id_ukuran_pakaian,
                            id_warna_pakaian 
                        ) VALUES (
                            " . $id_ukuran_pakaian . ",
                            " . $row['id'] . " 
                        )
                    ";
                        $mysqli->query($query);
                    }
                }
            }
        }

        $q = "
        DELETE FROM 
            ukuran_pakaian 
        WHERE 
            id_pakaian = " . $_GET['id'];
        foreach ($ukuran as $index => $value) {
            if ($index) $q .= ' AND ';
            $q .= " ukuran != '" . $value->value . "' ";
        }
        $mysqli->query($q);

        $mysqli->commit();
        echo "<script>sessionStorage.setItem('edit','Edit pakaian berhasil.')</script>";
        echo "<script>location.href = '" . $_SESSION['prev_url'] . "';</script>";
    } catch (\Throwable $e) {
        echo "<script>alert('Edit Data Gagal!')</script>";
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
                                                    <label>Pilih Merk</label>
                                                    <input type="text" class="form-control" disabled value="<?= $data['merk']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Pilih Kategori Pakaian</label>
                                                    <input type="text" class="form-control" disabled value="<?= $data['kategori_pakaian']; ?>">
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
                                                    <input type="text" class="form-control" name="nama" id="nama" required value="<?= $data['nama']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="harga_modal">Harga Modal</label>
                                                    <input type="text" class="form-control" name="harga_modal" id="harga_modal" required value="<?= number_format($data['harga_modal'], 0, ",", "."); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="harga_toko">Harga Toko</label>
                                                    <input type="text" class="form-control" name="harga_toko" id="harga_toko" required value="<?= number_format($data['harga_toko'], 0, ",", "."); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="ukuran">Ukuran</label>
                                                    <input type="text" class="form-control text-uppercase" name="ukuran" id="ukuran" required value="<?= $data['ukuran']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3 d-flex justify-content-between">
                                                <a href="<?= $_SESSION['prev_url']; ?>" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Simpan</button>
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