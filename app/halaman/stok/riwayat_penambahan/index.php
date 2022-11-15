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
                    <h3>Riwayat Penambahan Stok Pakaian</h3>
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
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Merk</th>
                                <th class="text-center">Jenis Pakaian</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Ukuran</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center no-td">Aksi</th>
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
                                LEFT JOIN 
                                    ukuran_warna_pakaian AS uwp 
                                ON 
                                    uwp.id=pd.id_ukuran_warna_pakaian 
                                LEFT JOIN 
                                    ukuran AS u 
                                ON 
                                    u.id=uwp.id_ukuran
                                LEFT JOIN 
                                    warna_pakaian AS wp 
                                ON 
                                    wp.id=uwp.id_warna_pakaian  
                                LEFT JOIN 
                                    warna AS w 
                                ON 
                                    w.id=wp.id_warna 
                                LEFT JOIN 
                                    pakaian AS p 
                                ON 
                                    p.id=wp.id_pakaian 
                                LEFT JOIN
                                jenis_pakaian AS jp 
                                ON 
                                    jp.id=p.id_jenis_pakaian 
                                LEFT JOIN 
                                    merk AS m 
                                ON 
                                    m.id=p.id_merk 
                                ORDER BY 
                                    pd.id DESC
                            ";
                            $data = $mysqli->query($query);
                            $no = 1;
                            ?>
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
                                    <td class="no-td">
                                        <a href="?halaman=edit_riwayat_penambahan_stok&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                        <a id="tombol-hapus" href="?halaman=hapus_riwayat_penambahan_stok&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm text-white" data-text="Menghapus stok pada '<?= $row['nama_pakaian'] ?>' akan mengurangi jumlah stoknya!" data-button-text="Hapus Stok!"><i class="fas fa-trash-alt"></i></a>
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