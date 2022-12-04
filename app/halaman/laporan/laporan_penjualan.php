<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Laporan Penjualan</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="section">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="kasir">Kasir</label>
                                            <select name="kasir" id="kasir" class="form-control">
                                                <option value="">Semua Kasir</option>
                                                <?php $result = $mysqli->query("SELECT * FROM kasir"); ?>
                                                <?php while ($row = $result->fetch_assoc()) : ?>
                                                    <option <?= (($_POST['kasir'] ?? '') == $row['id']) ? 'selected' : ''; ?> value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <hr>
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
                                            <a href="laporan/cetak/laporan_penjualan.php?id_kasir=<?= $_POST['kasir'] ?? ''; ?>&dari_tanggal=<?= $_POST['dari_tanggal'] ?? ''; ?>&sampai_tanggal=<?= $_POST['sampai_tanggal'] ?? ''; ?>" target="_blank" class="btn btn-success flex-grow-1">Cetak</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="no-td">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Nama Kasir</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query = "
                                        SELECT 
                                            DATE(tanggal_waktu_penjualan) AS tanggal,
                                            k.nama AS nama_kasir,
                                            SUM(pt.harga * pt.jumlah) AS total 
                                        FROM 
                                            penjualan AS p 
                                        INNER JOIN 
                                            pakaian_terjual AS pt 
                                        ON 
                                            p.id=pt.id_penjualan 
                                        INNER JOIN 
                                            kasir AS k 
                                        ON 
                                            k.id=p.id_kasir 
                                    ";

                                    $where = " WHERE 1=1";

                                    if (!empty($_POST['kasir'] ?? ''))
                                        $where .= " AND k.id = '" . $_POST['kasir'] . "'";

                                    if (!empty($_POST['dari_tanggal'] ?? ''))
                                        $where .= " AND DATE(tanggal_waktu_penjualan) >= '" . $_POST['dari_tanggal'] . "'";

                                    if (!empty($_POST['sampai_tanggal'] ?? ''))
                                        $where .= " AND DATE(tanggal_waktu_penjualan) <= '" . $_POST['sampai_tanggal'] . "'";

                                    $query .= $where . " GROUP BY p.id ORDER BY tanggal_waktu_penjualan DESC";

                                    $data = $mysqli->query($query);
                                    $no = 1;
                                    ?>
                                    <?php if ($data->num_rows) : ?>
                                        <?php while ($row = $data->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= indonesiaDate($row['tanggal']); ?></td>
                                                <td class="text-center"><?= $row['nama_kasir']; ?></td>
                                                <td class="text-center">Rp <?= number_format($row['total'], 0, ",", "."); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td class="text-center" colspan="4">Tidak Ada Data</td>
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