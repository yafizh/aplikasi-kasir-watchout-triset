<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Laporan Keuangan</h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="section">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="dari_tanggal">Dari Tanggal</label>
                                            <input type="date" class="form-control" name="dari_tanggal" id="dari_tanggal" value="<?= $_POST['dari_tanggal'] ?? ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="sampai_tanggal">Sampai Tanggal</label>
                                            <input type="date" class="form-control" name="sampai_tanggal" id="sampai_tanggal" value="<?= $_POST['sampai_tanggal'] ?? ''; ?>">
                                        </div>
                                        <div class="d-flex gap-3 flex-wrap">
                                            <a href="" class="btn btn-secondary flex-grow-1">Reset</a>
                                            <button type="submit" class="btn flex-grow-1 btn-info text-white">Filter</button>
                                            <a href="laporan/cetak/laporan_keuangan.php?dari_tanggal=<?= $_POST['dari_tanggal'] ?? ''; ?>&sampai_tanggal=<?= $_POST['sampai_tanggal'] ?? ''; ?>" target="_blank" class="btn btn-success flex-grow-1">Cetak</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="no-td">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Nama Pakaian</th>
                                        <th class="text-center">Terjual</th>
                                        <th class="text-center">Harga Modal X Terjual</th>
                                        <th class="text-center">Harga Jual X Terjual</th>
                                        <th class="text-center">Laba Bersih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "
                                        SELECT 
                                            p.nama AS nama_pakaian,
                                            p.harga_modal,
                                            dpo.harga_penjualan,
                                            dpo.jumlah,
                                            DATE(po.tanggal_waktu) AS tanggal 
                                        FROM 
                                            detail_penjualan_online AS dpo 
                                        INNER JOIN 
                                            penjualan_online AS po 
                                        ON 
                                            po.id=dpo.id_penjualan_online 
                                        INNER JOIN 
                                            ukuran_warna_pakaian uwp 
                                        ON 
                                            uwp.id=dpo.id_ukuran_warna_pakaian 
                                        INNER JOIN 
                                            ukuran_pakaian AS up 
                                        ON 
                                            up.id=uwp.id_ukuran_pakaian 
                                        INNER JOIN 
                                            pakaian p 
                                        ON 
                                            p.id=up.id_pakaian 
                                    ";

                                    $where = " WHERE 1=1";

                                    if (!empty($_POST['dari_tanggal'] ?? ''))
                                        $where .= " AND DATE(po.tanggal_waktu) >= '" . $_POST['dari_tanggal'] . "'";

                                    if (!empty($_POST['sampai_tanggal'] ?? ''))
                                        $where .= " AND DATE(po.tanggal_waktu) <= '" . $_POST['sampai_tanggal'] . "'";

                                    $query .= $where . " ORDER BY po.tanggal_waktu DESC";

                                    $data = $mysqli->query($query);
                                    $no = 1;
                                    $total_modal = 0;
                                    $total_jual = 0;
                                    $total_laba_bersih = 0;
                                    ?>
                                    <?php if ($data->num_rows) : ?>
                                        <?php while ($row = $data->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= indonesiaDate($row['tanggal']); ?></td>
                                                <td class="text-center"><?= $row['nama_pakaian']; ?></td>
                                                <td class="text-center"><?= $row['jumlah']; ?></td>
                                                <?php $modal = $row['harga_modal'] * $row['jumlah']; ?>
                                                <td class="text-center">Rp <?= number_format($modal, 0, ",", "."); ?></td>
                                                <?php $jual = $row['harga_penjualan'] * $row['jumlah']; ?>
                                                <td class="text-center">Rp <?= number_format($jual, 0, ",", "."); ?></td>
                                                <?php $laba_bersih = $jual - $modal; ?>
                                                <td class="text-center">Rp <?= number_format($laba_bersih, 0, ",", "."); ?></td>
                                                <?php
                                                    $total_modal += $modal;
                                                    $total_jual += $jual;
                                                    $total_laba_bersih += $laba_bersih;
                                                ?>
                                            </tr>
                                        <?php endwhile; ?>
                                        <tr>
                                            <td colspan="4"><strong>Total</strong></td>
                                            <td class="text-center">Rp <?= number_format($total_modal, 0, ",", "."); ?></td>
                                            <td class="text-center">Rp <?= number_format($total_jual, 0, ",", "."); ?></td>
                                            <td class="text-center">Rp <?= number_format($total_laba_bersih, 0, ",", "."); ?></td>
                                        </tr>
                                    <?php else : ?>
                                        <tr>
                                            <td class="text-center" colspan="7">Tidak Ada Data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>