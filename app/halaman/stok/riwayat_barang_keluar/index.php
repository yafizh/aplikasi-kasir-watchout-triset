<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Riwayat Barang Keluar</h3>
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
                                    m.nama merk,
                                    kp.nama kategori_pakaian,
                                    p.nama nama_pakaian,
                                    wp.warna,
                                    up.ukuran,
                                    dp.jumlah,
                                    DATE(pe.tanggal_waktu_penjualan) tanggal,
                                    dp.id  
                                FROM 
                                    detail_penjualan dp 
                                INNER JOIN 
                                    penjualan pe 
                                ON 
                                    pe.id=dp.id_penjualan 
                                INNER JOIN 
                                    ukuran_warna_pakaian uwp 
                                ON 
                                    uwp.id=dp.id_ukuran_warna_pakaian 
                                INNER JOIN 
                                    ukuran_pakaian up 
                                ON 
                                    up.id=uwp.id_ukuran_pakaian
                                INNER JOIN 
                                    warna_pakaian wp 
                                ON 
                                    wp.id=uwp.id_warna_pakaian  
                                INNER JOIN 
                                    pakaian p 
                                ON 
                                    p.id=wp.id_pakaian 
                                INNER JOIN
                                    kategori_pakaian kp 
                                ON 
                                    kp.id=p.id_kategori_pakaian 
                                INNER JOIN 
                                    merk m 
                                ON 
                                    m.id=p.id_merk 
                                ORDER BY 
                                    dp.id DESC
                            ";
                            $data = $mysqli->query($query);
                            $no = 1;
                            ?>
                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= indonesiaDate($row['tanggal']); ?></td>
                                    <td class="text-center"><?= $row['merk']; ?></td>
                                    <td class="text-center"><?= $row['kategori_pakaian']; ?></td>
                                    <td class="text-center"><?= $row['nama_pakaian']; ?></td>
                                    <td class="text-center"><?= $row['warna']; ?></td>
                                    <td class="text-center"><?= $row['ukuran']; ?></td>
                                    <td class="text-center"><?= $row['jumlah']; ?></td>
                                    <td class="no-td">
                                        <a href="?halaman=edit_riwayat_barang_keluar&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="ffa-edit"></i></a>
                                        <a id="tombol-hapus" href="?halaman=hapus_riwayat_barang_keluar&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm text-white" data-text="Menghapus riwayat barang keluar pada '<?= $row['nama_pakaian'] ?>' akan menambah jumlah stoknya!" data-button-text="Hapus!"><i class="ffa-trash-alt"></i></a>
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