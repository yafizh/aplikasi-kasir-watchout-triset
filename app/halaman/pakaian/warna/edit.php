<?php

$result = $mysqli->query(
    "
    SELECT 
        wp.id,
        wp.id_warna,
        wp.foto, 
        w.nama AS warna 
    FROM 
        warna_pakaian AS wp 
    INNER JOIN 
        warna AS w 
    ON w.id=wp.id_warna 
        WHERE 
    wp.id=" . $_GET['id']
);
$warna_pakaian = $result->fetch_assoc();

$result = $mysqli->query("SELECT * FROM ukuran_warna_pakaian WHERE id_warna_pakaian=" . $warna_pakaian['id']);
$ukuran = $result->fetch_all(MYSQLI_ASSOC);
$ukuran_warna_pakaian = [];
foreach ($ukuran as $value) {
    $ukuran_warna_pakaian[] = $value['id_ukuran'];
}

$result = $mysqli->query("SELECT * FROM merk WHERE id=" . $_GET['id_merk']);
$merk = $result->fetch_assoc();

$result = $mysqli->query("SELECT * FROM jenis_pakaian WHERE id=" . $_GET['id_jenis_pakaian']);
$jenis_pakaian = $result->fetch_assoc();

$result = $mysqli->query("SELECT * FROM pakaian WHERE id=" . $_GET['id_pakaian']);
$pakaian = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $id_warna = $_POST['id_warna'];
    $id_ukuran = $_POST['id_ukuran'] ?? [];

    $target_dir = "../uploads/foto_pakaian/";
    $foto = $target_dir . Date("YmdHis") . '.' . strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    if (!is_dir($target_dir)) mkdir($target_dir, 0700, true);
    if (!move_uploaded_file($_FILES['foto']["tmp_name"], $foto))
        echo "<script>alert('Gagal meng-upload gambar!')</script>";

    $q = "
    UPDATE warna_pakaian SET 
        id_warna=$id_warna, 
        foto='$foto' 
    WHERE 
        id=" . $warna_pakaian['id'];

    if ($mysqli->query($q)) {
        $result = $mysqli->query("SELECT * FROM ukuran_warna_pakaian WHERE id_warna_pakaian=" . $warna_pakaian['id']);
        $ukuran = [];
        while ($row = $result->fetch_assoc()) {
            $ukuran[] = $row['id_ukuran'];
        }

        foreach ($id_ukuran as $id) {
            if (!in_array($id, $ukuran))
                $mysqli->query("INSERT INTO ukuran_warna_pakaian (id_warna_pakaian, id_ukuran) VALUES (" . $warna_pakaian['id'] . ", $id)");
        }

        foreach ($ukuran as $id) {
            if (!in_array($id, $id_ukuran))
                $mysqli->query("DELETE FROM ukuran_warna_pakaian WHERE id_warna_pakaian=" . $warna_pakaian['id'] . " AND id_ukuran=" . $id);
        }

        echo "<script>sessionStorage.setItem('edit','Edit warna pakaian berhasil.')</script>";
        echo "<script>location.href = '?halaman=pakaian_per_warna&id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "&id_merk=" . $_GET['id_merk'] . "&id_pakaian=" . $_GET['id_pakaian'] . "';</script>";
    } else {
        echo "<script>alert('Edit Data Gagal!')</script>";
        die($mysqli->error);
    }
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
                    <h3>Edit Data Warna Pakaian</h3>
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
                                                    <input type="text" class="form-control" value="<?= $jenis_pakaian['nama']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" value="<?= $pakaian['nama']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <?php
                                                $query = "
                                                        SELECT 
                                                            * 
                                                        FROM 
                                                            warna 
                                                        WHERE 
                                                            id NOT IN (SELECT id_warna FROM warna_pakaian WHERE id_pakaian=" . $_GET['id_pakaian'] . ")";
                                                $result = $mysqli->query($query);
                                                ?>
                                                <div class="form-group">
                                                    <label for="warna" for="id_warna">Pilih Warna</label>
                                                    <select class="form-select" name="id_warna" id="id_warna" required>
                                                        <option value="<?= $warna_pakaian['id_warna']; ?>" selected><?= $warna_pakaian['warna']; ?></option>
                                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                                            <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <?php $result = $mysqli->query("SELECT * FROM ukuran WHERE id_jenis_pakaian=" . $_GET['id_jenis_pakaian']); ?>
                                                <div class="form-group">
                                                    <label>Ukuran</label>
                                                    <ul class="list-unstyled mb-0">
                                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                                            <li class="d-inline-block me-2 mb-1">
                                                                <div class="form-check">
                                                                    <div class="checkbox">
                                                                        <input <?= in_array($row['id'], $ukuran_warna_pakaian) ? 'checked' : ''; ?> type="checkbox" class="form-check-input" name="id_ukuran[]" id="id_ukuran<?= $row['id']; ?>" value="<?= $row['id']; ?>">
                                                                        <label for="id_ukuran<?= $row['id']; ?>"><?= $row['nama']; ?></label>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php endwhile; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3 d-flex justify-content-between">
                                                <a href="?halaman=pakaian_per_warna&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $_GET['id_pakaian']; ?>" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1 text-white">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xxl-4 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Gambar</label>
                                                <input type="file" name="foto" required>
                                                <input type="text" name="foto_pakaian" value="<?= $warna_pakaian['foto']; ?>" hidden>
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
    document.querySelectorAll('input[type=checkbox]').forEach((elm) => {
        elm.addEventListener('click', function(e) {
            if (this.defaultChecked && !this.checked) {
                Swal.fire({
                    title: 'Yakin?',
                    text: `Stok yang pernah ditambahkan sebelumnya pada ukuran '${elm.nextElementSibling.textContent}' akan ikut terhapus! Yakin ingin menghapus ukuran '${elm.nextElementSibling.textContent}'?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: `Hapus Ukuran '${elm.nextElementSibling.textContent}'?`
                }).then((result) => {
                    if (result.isConfirmed)
                        elm.checked = false;
                });
                e.preventDefault();
            }
        });
    });
</script>