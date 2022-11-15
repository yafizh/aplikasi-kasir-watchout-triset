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
                    <h3>Data Stok Pakaian</h3>
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
                                <th class="text-center">Merk</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT 
                                    m.id,
                                    m.nama,
                                    SUM(pd.jumlah) AS jumlah
                                FROM 
                                    merk AS m 
                                LEFT JOIN 
                                    pakaian AS p 
                                ON 
                                    p.id_merk=m.id 
                                LEFT JOIN 
                                    warna_pakaian AS wp 
                                ON 
                                    wp.id_pakaian=p.id 
                                LEFT JOIN 
                                    ukuran_warna_pakaian AS uwp 
                                ON 
                                    uwp.id_warna_pakaian=wp.id 
                                LEFT JOIN 
                                    pakaian_disuplai AS pd 
                                ON 
                                    pd.id_ukuran_warna_pakaian=uwp.id 
                                GROUP BY 
                                    m.id
                            ";
                            $data = $mysqli->query($query);
                            $no = 1;
                            ?>
                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['nama']; ?></td>
                                    <td class="text-center"><?= empty($row['jumlah']) ? 'Pakaian Belum Ditambahkan' : $row['jumlah']; ?></td>
                                    <td class="no-td">
                                        <a href="?halaman=stok_per_merk&id_merk=<?= $row['id']; ?>" class="btn btn-info btn-sm text-white"><i class="fas fa-eye"></i></a>
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