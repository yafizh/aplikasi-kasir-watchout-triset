<?php
$result = $mysqli->query("SELECT * FROM diskon WHERE id=" . $_GET['id_diskon']);
$diskon = $result->fetch_assoc();
?>
<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3 d-flex gap-2">
                    <h3><a href="?halaman=diskon">Data Diskon</a></h3>
                    <h3>/</h3>
                    <h3><?= $diskon['nama']; ?></h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_diskon_pakaian&id_diskon=<?= $diskon['id']; ?>" class="btn btn-primary align-self-start text-white">Tambah</a>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table id="table1" class="table">
                        <thead>
                            <tr>
                                <th class="no-td">No</th>
                                <th class="text-center">Nama Pakaian</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $query = "
                            SELECT 
                                dp.id_diskon,
                                dp.id_pakaian,
                                p.nama nama_pakaian
                            FROM 
                                diskon_pakaian dp 
                            INNER JOIN 
                                pakaian p
                            ON 
                                p.id=dp.id_pakaian 
                            WHERE 
                                id_diskon=" . $_GET['id_diskon'] . "
                        ";
                        $data = $mysqli->query($query);
                        $no = 1;
                        ?>
                        <tbody>
                            <?php if ($data->num_rows) : ?>
                                <?php while ($row = $data->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nama_pakaian']; ?></td>
                                        <td class="no-td">
                                            <a id="tombol-hapus" href="?halaman=hapus_diskon_pakaian&id_pakaian=<?= $row['id_pakaian']; ?>&id_diskon=<?= $row['id_diskon']; ?>" class="btn btn-danger btn-sm" data-text="Menghapus pakaian '<?= $row['nama_pakaian']; ?>' akan membuat data riwayat penjualan dengan pakaian '<?= $row['nama_pakaian']; ?>' ikut terhapus!" data-button-text="Hapus Pakaian!">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>