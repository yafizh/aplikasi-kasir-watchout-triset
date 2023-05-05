<?php
$query = "
    SELECT 
        wp.*,
        p.id id_pakaian,
        p.nama 
    FROM 
        warna_pakaian wp 
    INNER JOIN 
        pakaian p 
    ON 
        p.id=wp.id_pakaian 
    WHERE 
        wp.id=" . $_GET['id'] . "
";
$result = $mysqli->query($query);
$warna_pakaian = $result->fetch_assoc();

$foto_pakaian = $mysqli->query("SELECT * FROM foto_pakaian WHERE id_warna_pakaian=" . $warna_pakaian['id']);
if (isset($_POST['submit'])) {
    $id_foto_pakaian = $_POST['id_foto_pakaian'];
    $foto_pakaian = $_POST['foto_pakaian'];
    foreach ($foto_pakaian as $index => $value) {
        $foto_pakaian[$index] = explode('/', $value)[3];
    }
    $warna = $mysqli->real_escape_string($_POST['warna']);

    try {
        $mysqli->begin_transaction();

        $q = "
        UPDATE warna_pakaian SET 
            warna='" . strtoupper($warna) . "' 
        WHERE 
            id=" . $warna_pakaian['id'];
        $mysqli->query($q);


        // Remove Images
        foreach ($foto_pakaian as $index => $value) {
            if (!in_array($value, $_FILES['foto']['name'])) {
                $mysqli->query("DELETE FROM foto_pakaian WHERE id=" . $id_foto_pakaian[$index]);
            }
        }

        // Upload Images
        $target_dir = "../uploads/foto_pakaian/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
        $foto = [];
        for ($i = 0; $i < count($_FILES['foto']['name']); $i++) {
            if (!in_array($_FILES['foto']['name'][$i], $foto_pakaian)) {
                $foto[] = $target_dir . Date("YmdHis") . '.' . strtolower(pathinfo($_FILES['foto']['name'][$i], PATHINFO_EXTENSION));
                if (!move_uploaded_file($_FILES['foto']["tmp_name"][$i], $foto[$i]))
                    echo "<script>alert('Gagal meng-upload gambar!')</script>";
            }
        }

        foreach ($foto as $value) {
            $q = "
            INSERT INTO foto_pakaian (
                id_warna_pakaian,
                foto
            ) VALUES (
                '" . $warna_pakaian['id'] . "',
                '" . $value . "' 
            )";
            $mysqli->query($q);
        }        

        $mysqli->commit();
        echo "<script>sessionStorage.setItem('edit','Edit warna pakaian berhasil.')</script>";
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
                                                    <input type="text" class="form-control" disabled value="<?= $warna_pakaian['nama']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="warna">Warna</label>
                                                    <input type="text" list="warna-warna" class="form-control text-uppercase" name="warna" id="warna" required value="<?= $warna_pakaian['warna']; ?>" autocomplete="off">
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
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Simpan</button>
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
                                                <?php while ($row = $foto_pakaian->fetch_assoc()) : ?>
                                                    <input type="text" name="id_foto_pakaian[]" value="<?= $row['id']; ?>" hidden>
                                                    <input type="text" name="foto_pakaian[]" value="<?= $row['foto']; ?>" hidden>
                                                <?php endwhile; ?>
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