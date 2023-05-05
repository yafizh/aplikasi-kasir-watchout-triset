<?php
$result = $mysqli->query("SELECT * FROM pakaian WHERE id=" . $_GET['id_pakaian']);
$pakaian = $result->fetch_assoc();
if (isset($_POST['submit'])) {
    $warna = $mysqli->real_escape_string($_POST['warna']);

    // Upload Images
    $target_dir = "../uploads/foto_pakaian/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
    $foto = [];
    for ($i = 0; $i < count($_FILES['foto']['name']); $i++) {
        $foto[] = $target_dir . Date("YmdHis") . $i . '.' . strtolower(pathinfo($_FILES['foto']['name'][$i], PATHINFO_EXTENSION));
        if (!move_uploaded_file($_FILES['foto']["tmp_name"][$i], $foto[$i]))
            echo "<script>alert('Gagal meng-upload gambar!')</script>";
    }

    try {
        $mysqli->begin_transaction();

        $q = "
        INSERT INTO warna_pakaian (
            id_pakaian, 
            warna 
        ) VALUES (
            '" . $pakaian['id'] . "',
            '" . strtoupper($warna) . "' 
        )";
        $mysqli->query($q);
        $id_warna_pakaian = $mysqli->insert_id;

        foreach ($foto as $value) {
            $q = "
            INSERT INTO foto_pakaian (
                id_warna_pakaian,
                foto
            ) VALUES (
                '" . $id_warna_pakaian . "',
                '" . $value . "' 
            )";
            $mysqli->query($q);
        }

        $ukuran = $mysqli->query("SELECT * FROM ukuran_pakaian WHERE id_pakaian=" . $pakaian['id']);
        while ($row = $ukuran->fetch_assoc()) {
            $q = "
            INSERT INTO ukuran_warna_pakaian (
                id_warna_pakaian ,
                id_ukuran_pakaian
            ) VALUES (
                '" . $id_warna_pakaian . "',
                '" . $row['id'] . "' 
            )";
            $mysqli->query($q);
        }

        $mysqli->commit();
        echo "<script>sessionStorage.setItem('tambah','Tambah warna pakaian berhasil.')</script>";
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
            <form class="form form-vertical" action="" method="POST" enctype="multipart/form-data">
                <div class="row match-height justify-content-center align-items-stretch">
                    <div class="col-md-6 col-xxl-4 col-12 mb-3">
                        <div class="card mb-0">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Nama Pakaian</label>
                                                    <input type="text" class="form-control" disabled value="<?= $pakaian['nama']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="warna">Warna</label>
                                                    <input type="text" list="warna-warna" class="form-control text-uppercase" name="warna" id="warna" required autocomplete="off">
                                                    <datalist id="warna-warna">
                                                        <option value="Merah">
                                                        <option value="Firefox">
                                                        <option value="Chrome">
                                                        <option value="Opera">
                                                        <option value="Safari">
                                                    </datalist>
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
                    <div class="col-md-6 col-xxl-4 col-12 mb-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Gambar</label>
                                                <input type="file" name="foto[]" multiple required>
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