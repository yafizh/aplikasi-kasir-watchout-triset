<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <?php
    $result = $mysqli->query("SELECT * FROM pakaian WHERE id=" . $_GET['id_pakaian']);
    $pakaian = $result->fetch_assoc();
    ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>
                        <a href="?halaman=stok_per_merk&id_merk=<?= $_GET['id_merk']; ?>" class="text-reset"><i class="bi bi-arrow-bar-left"></i></a>Data Stok <?= $pakaian['nama']; ?>
                    </h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_stok_pakaian&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $_GET['id_pakaian']; ?>" class="btn btn-primary align-self-start">Tambah Stok</a>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="no-td">No</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center no-td"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT 
                                    wp.id,
                                    w.nama,
                                    SUM(pd.jumlah) AS jumlah
                                FROM  
                                    warna_pakaian AS wp 
                                INNER JOIN 
                                    warna AS w 
                                ON 
                                    w.id=wp.id_warna 
                                LEFT JOIN 
                                    ukuran_warna_pakaian AS uwp 
                                ON 
                                    uwp.id_warna_pakaian=wp.id 
                                LEFT JOIN 
                                    pakaian_disuplai AS pd 
                                ON 
                                    pd.id_ukuran_warna_pakaian=uwp.id 
                                WHERE 
                                    wp.id_pakaian=" . $_GET['id_pakaian'] . "
                                GROUP BY 
                                    wp.id 
                            ";
                            $data = $mysqli->query($query);
                            $no = 1;
                            ?>
                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['nama']; ?></td>
                                    <td class="text-center"><?= empty($row['jumlah']) ? 'Stok Belum Disuplai' : $row['jumlah']; ?></td>
                                    <td class="no-td">
                                        <a href="?halaman=stok_per_warna&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $_GET['id_pakaian']; ?>&id_warna_pakaian=<?= $row['id']; ?>" class="btn btn-info btn-sm text-white">Lihat</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>