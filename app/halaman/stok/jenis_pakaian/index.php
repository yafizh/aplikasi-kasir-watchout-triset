<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <?php
    $result = $mysqli->query("SELECT * FROM jenis_pakaian WHERE id=" . $_GET['id_jenis_pakaian']);
    $jenis_pakaian = $result->fetch_assoc();
    $result = $mysqli->query("SELECT * FROM merk WHERE id=" . $_GET['id_merk']);
    $merk = $result->fetch_assoc();
    ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>
                        <a href="?halaman=stok" class="text-reset"><i class="bi bi-arrow-bar-left"></i> Data Stok <?= $jenis_pakaian['nama'] ?> <?= $merk['nama']; ?></a>
                    </h3>
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
                                <th class="text-center">Nama</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center no-td"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT 
                                    p.id,
                                    p.nama,
                                    SUM(
                                        IFNULL((SELECT SUM(pd.jumlah) FROM pakaian_disuplai AS pd WHERE pd.id_ukuran_warna_pakaian=uwp.id), 0)
                                        - 
                                        IFNULL((SELECT SUM(pt.jumlah) FROM pakaian_terjual AS pt WHERE pt.id_ukuran_warna_pakaian=uwp.id), 0)
                                    ) AS jumlah 
                                FROM  
                                    pakaian AS p 
                                INNER JOIN 
                                    warna_pakaian AS wp 
                                ON 
                                    wp.id_pakaian=p.id 
                                LEFT JOIN 
                                    ukuran_warna_pakaian AS uwp 
                                ON 
                                    uwp.id_warna_pakaian=wp.id 
                                WHERE 
                                    p.id_merk=" . $_GET['id_merk'] . " 
                                    AND 
                                    p.id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . " 
                                GROUP BY
                                    p.id
                             ";
                            $data = $mysqli->query($query);
                            $no = 1;
                            ?>
                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['nama']; ?></td>
                                    <td class="text-center"><?= $row['jumlah']; ?></td>
                                    <td class="no-td">
                                        <a href="?halaman=stok_per_pakaian&id_merk=<?= $_GET['id_merk']; ?>&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_pakaian=<?= $row['id']; ?>" class="btn btn-info btn-sm text-white"><i class="fas fa-eye"></i></a>
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