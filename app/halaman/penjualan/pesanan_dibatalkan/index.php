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
            <div class="card">
                <div class="card-body">
                    <table id="table1" class="table">
                        <thead>
                            <tr>
                                <th class="no-td">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Pembeli</th>
                                <th class="text-center">Pembelian</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $q = "
                            SELECT 
                                po.id,
                                DATE(po.tanggal_waktu) AS tanggal,
                                p.nama,
                                po.harga_penjualan 
                            FROM penjualan_online po  
                            INNER JOIN pembeli p ON p.id=po.id_pembeli 
                            WHERE status=4
                        ";
                        $data = $mysqli->query($q);
                        $no = 1;
                        ?>
                        <tbody>
                            <?php if ($data->num_rows) : ?>
                                <?php while ($row = $data->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-center"><?= indonesiaDate($row['tanggal']); ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center"><?= number_format($row['harga_penjualan'], 0, ",", "."); ?></td>
                                        <td class="no-td">
                                            <a href="?halaman=detail_penjualan_pesanan_selesai&id=<?= $row['id']; ?>" class="btn btn-info btn-sm">
                                                Detail
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