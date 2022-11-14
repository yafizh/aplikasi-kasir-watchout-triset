<?php
$query = "
    SELECT 
        m.nama AS merk,
        jp.nama AS jenis_pakaian,
        p.nama AS nama_pakaian,
        w.nama AS warna,
        u.nama AS ukuran,
        pd.jumlah,
        pd.tanggal_masuk,
        pd.id  
    FROM 
        pakaian_disuplai AS pd 
    INNER JOIN 
        ukuran_warna_pakaian AS uwp 
    ON 
        uwp.id=pd.id_ukuran_warna_pakaian 
    INNER JOIN 
        ukuran AS u 
    ON 
        u.id=uwp.id_ukuran
    INNER JOIN 
        warna_pakaian AS wp 
    ON 
        wp.id=uwp.id_warna_pakaian  
    INNER JOIN 
        warna AS w 
    ON 
        w.id=wp.id_warna 
    INNER JOIN 
        pakaian AS p 
    ON 
        p.id=wp.id_pakaian 
    INNER JOIN
    jenis_pakaian AS jp 
    ON 
        jp.id=p.id_jenis_pakaian 
    INNER JOIN 
        merk AS m 
    ON 
        m.id=p.id_merk 
    WHERE 
        pd.id=" . $_GET['id'] . "
    ";
$result = $mysqli->query($query);
$data = $result->fetch_assoc();
if (isset($_POST['submit'])) {
    $jumlah = $_POST['jumlah'];
    $tanggal_masuk = Date("Y-m-d");

    $query = "UPDATE pakaian_disuplai SET jumlah=$jumlah WHERE id=" . $_GET['id'];

    if ($mysqli->query($query)) {
        echo "<script>alert('Edit Data Stok Berhasil!')</script>";
        echo "<script>location.href = '?halaman=riwayat_penambahan_stok';</script>";
    } else {
        echo "<script>alert('Tambah Data Stok Gagal!')</script>";
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
                    <h3>Edit Penambahan Stok Pakaian</h3>
                </div>
            </div>
        </div>

        <section id="basic-vertical-layouts">
            <form class="form form-vertical" action="" method="POST">
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
                                                    <input type="text" class="form-control" value="<?= $data['merk']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Jenis Pakaian</label>
                                                    <input type="text" class="form-control" value="<?= $data['jenis_pakaian']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" value="<?= $data['nama_pakaian']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Warna</label>
                                                    <input type="text" class="form-control" value="<?= $data['warna']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Ukuran</label>
                                                    <input type="text" class="form-control" value="<?= $data['ukuran']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="jumlah">Jumlah</label>
                                                    <input type="number" class="form-control" name="jumlah" id="jumlah" min="1" required value="<?= $data['jumlah']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3 d-flex justify-content-between">
                                                <a href="?halaman=riwayat_penambahan_stok" class="btn btn-light-secondary mb-1">Kembali</a>
                                                <button type="submit" name="submit" class="btn btn-primary mb-1">Simpan</button>
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