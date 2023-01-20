<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Laporan Barang Masuk</h3>
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
                                            <a href="laporan/cetak/laporan_barang_masuk.php?dari_tanggal=<?= $_POST['dari_tanggal'] ?? ''; ?>&sampai_tanggal=<?= $_POST['sampai_tanggal'] ?? ''; ?>" target="_blank" class="btn btn-success flex-grow-1">Cetak</a>
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
                                        <th class="text-center">Merk</th>
                                        <th class="text-center">Jenis Pakaian</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center">Ukuran</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    ";

                                    $where = " WHERE 1=1 ";
                                    if (!empty($_POST['dari_tanggal'] ?? ''))
                                        $where .= " AND pd.tanggal_masuk >= '" . $_POST['dari_tanggal'] . "'";

                                    if (!empty($_POST['sampai_tanggal'] ?? '')) {
                                        $where .= " AND pd.tanggal_masuk <= '" . $_POST['sampai_tanggal'] . "'";
                                    }

                                    $query .= $where . " ORDER BY pd.tanggal_masuk DESC";
                                    $data = $mysqli->query($query);
                                    $no = 1;
                                    ?>
                                    <?php if ($data->num_rows) : ?>
                                        <?php while ($row = $data->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= indonesiaDate($row['tanggal_masuk']); ?></td>
                                                <td class="text-center"><?= $row['merk']; ?></td>
                                                <td class="text-center"><?= $row['jenis_pakaian']; ?></td>
                                                <td class="text-center"><?= $row['nama_pakaian']; ?></td>
                                                <td class="text-center"><?= $row['warna']; ?></td>
                                                <td class="text-center"><?= $row['ukuran']; ?></td>
                                                <td class="text-center"><?= $row['jumlah']; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td class="text-center" colspan="8">Tidak Ada Data</td>
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