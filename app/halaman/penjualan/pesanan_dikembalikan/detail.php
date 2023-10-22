<?php
if ($_GET['id']) {
    $mysqli->query("UPDATE penjualan_online SET status=5 WHERE id=" . $_GET['id']);
}
?>
<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3><?= $title; ?></h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card">
                        <?php
                        $q = "
                            SELECT 
                                po.id,
                                DATE(po.tanggal_waktu) AS tanggal,
                                p.nama,
                                po.harga_penjualan 
                            FROM penjualan_online po  
                            INNER JOIN pembeli p ON p.id=po.id_pembeli 
                            WHERE po.id=" . $_GET['id'] . "
                        ";
                        $data = $mysqli->query($q)->fetch_assoc();
                        $no = 1;
                        ?>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label>Tanggal</label>
                                <input class="form-control" disabled value="<?= indonesiaDate($data['tanggal']) ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label>Pembeli</label>
                                <input class="form-control" disabled value="<?= $data['nama']; ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label>Pembelian</label>
                                <input class="form-control" disabled value="<?= number_format($data['harga_penjualan'], 0, ",", "."); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Pakaian</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <?php
                                $q = "
                                    SELECT
                                        p.nama,
                                        dpo.jumlah,
                                        dpo.harga_penjualan
                                    FROM 
                                        detail_penjualan_online dpo 
                                    INNER JOIN 
                                        ukuran_warna_pakaian uwp 
                                    ON uwp.id=dpo.id_ukuran_warna_pakaian 
                                    INNER JOIN warna_pakaian wp 
                                    ON wp.id=uwp.id_warna_pakaian 
                                    INNER JOIN pakaian p 
                                    ON p.id=wp.id_pakaian 
                                    WHERE dpo.id_penjualan_online=" . $_GET['id'] . "
                                ";
                                $data = $mysqli->query($q);
                                $no = 1;
                                ?>
                                <tbody>
                                    <?php if ($data->num_rows) : ?>
                                        <?php while ($row = $data->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center"><?= $row['nama']; ?></td>
                                                <td class="text-center"><?= number_format($row['harga_penjualan'], 0, ",", "."); ?></td>
                                                <td class="text-center"><?= $row['jumlah']; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>