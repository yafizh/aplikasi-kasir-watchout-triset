<?php
$query = "
    SELECT 
        m.nama merk,
        kp.nama jenis_pakaian,
        p.nama nama_pakaian,
        wp.warna,
        up.ukuran,
        pd.jumlah,
        pd.tanggal_masuk,
        pd.id  
    FROM 
        pakaian_disuplai pd 
    INNER JOIN 
        ukuran_warna_pakaian uwp 
    ON 
        uwp.id=pd.id_ukuran_warna_pakaian 
    INNER JOIN 
        ukuran_pakaian up 
    ON 
        up.id=uwp.id_ukuran_pakaian
    INNER JOIN 
        warna_pakaian wp 
    ON 
        wp.id=uwp.id_warna_pakaian  
    INNER JOIN 
        pakaian p 
    ON 
        p.id=wp.id_pakaian 
    INNER JOIN
        kategori_pakaian kp 
    ON 
        kp.id=p.id_kategori_pakaian 
    INNER JOIN 
        merk m 
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
        echo "<script>sessionStorage.setItem('edit','Edit stok berhasil.')</script>";
        echo "<script>location.href = '?halaman=riwayat_penambahan_stok';</script>";
    } else {
        echo "<script>alert('Tambah Data Stok Gagal!')</script>";
        die($mysqli->error);
    }
}

?>
<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 text-center mb-3">
                    <h3>Edit Riwayat Barang Masuk</h3>
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