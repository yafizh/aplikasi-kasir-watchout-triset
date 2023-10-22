<?php

if (isset($_POST['status'])) {
    $query = "
        UPDATE status_pengiriman SET 
            status=" . $_POST['status'] . " 
        WHERE 
            id_penjualan_online=" . $_GET['id'];
    $mysqli->query($query);
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
                                po.harga_penjualan,
                                sp.status
                            FROM penjualan_online po  
                            INNER JOIN pembeli p ON p.id=po.id_pembeli 
                            INNER JOIN status_pengiriman sp ON sp.id_penjualan_online=po.id  
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
                            <form action="" method="POST">
                                <div class="form-group mb-3">
                                    <label>Status Pesanan</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" <?= ($data['status'] == 1) ? 'selected' : ''; ?>>Sedang Disiapkan</option>
                                        <option value="2" <?= ($data['status'] == 2) ? 'selected' : ''; ?>>Dalam Perjalanan</option>
                                        <option value="3" <?= ($data['status'] == 3) ? 'selected' : ''; ?>>Telah Sampai</option>
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary text-white w-100 mb-3">Perbaharui Status</button>
                                    <a href="?halaman=detail_penjualan_pesanan_selesai&id=<?= $_GET['id']; ?>" class="btn btn-success text-white w-100">Pesanan Selesai</a>
                                </div>
                            </form>
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