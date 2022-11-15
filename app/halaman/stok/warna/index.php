<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <?php
    $result = $mysqli->query("SELECT * FROM pakaian WHERE id=" . $_GET['id_pakaian']);
    $pakaian = $result->fetch_assoc();
    $result = $mysqli->query("SELECT warna.nama FROM warna_pakaian INNER JOIN warna ON warna.id=warna_pakaian.id_warna WHERE warna_pakaian.id=" . $_GET['id_warna_pakaian']);
    $warna = $result->fetch_assoc();
    ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md order-md-1 mb-3">
                    <h3>
                        <a href="?halaman=stok_per_pakaian&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $_GET['id_pakaian']; ?>" class="text-reset"><i class="bi bi-arrow-bar-left"></i></a>Data Stok <?= $pakaian['nama']; ?> Warna <?= $warna['nama']; ?>
                    </h3>
                </div>
                <div class="col-12 col-md-auto order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_stok_pakaian_per_warna&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $_GET['id_pakaian']; ?>&id_warna_pakaian=<?= $_GET['id_warna_pakaian']; ?>" class="btn btn-primary align-self-start text-white">Tambah Stok</a>
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
                                <th class="text-center">Ukuran</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT 
                                    uwp.id,
                                    u.nama,
                                    SUM(pd.jumlah) AS jumlah
                                FROM  
                                    ukuran_warna_pakaian AS uwp 
                                INNER JOIN 
                                    ukuran AS u 
                                ON 
                                    u.id=uwp.id_ukuran 
                                LEFT JOIN 
                                    pakaian_disuplai AS pd 
                                ON 
                                    pd.id_ukuran_warna_pakaian=uwp.id 
                                WHERE 
                                    uwp.id_warna_pakaian=" . $_GET['id_warna_pakaian'] . "
                                GROUP BY 
                                    uwp.id 
                                ORDER BY FIELD(u.nama, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), u.nama
                            ";
                            $data = $mysqli->query($query);
                            $no = 1;
                            ?>
                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['nama']; ?></td>
                                    <td class="text-center"><?= empty($row['jumlah']) ? 'Stok Belum Ditambahkan' : $row['jumlah']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>