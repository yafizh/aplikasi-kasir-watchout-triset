<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3><?= $title; ?></h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_voucher_diskon" class="btn btn-primary align-self-start text-white">Tambah</a>
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
                                <th class="text-center">Nama</th>
                                <th class="text-center">Tanggal Mulai</th>
                                <th class="text-center">Tanggal Selesai</th>
                                <th class="text-center">Pengurangan Harga</th>
                                <th class="text-center">Kode Voucher</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $data = $mysqli->query("SELECT * FROM voucher_diskon ORDER BY tanggal_mulai DESC");
                        $no = 1;
                        ?>
                        <tbody>
                            <?php if ($data->num_rows) : ?>
                                <?php while ($row = $data->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center"><?= indonesiaDate($row['tanggal_mulai']); ?></td>
                                        <td class="text-center"><?= indonesiaDate($row['tanggal_selesai']); ?></td>
                                        <td class="text-center"><?= number_format($row['diskon'], 0, ",", "."); ?><?= $row['jenis_diskon'] == 1 ? '' : '%' ?></td>
                                        <td class="text-center"><?= $row['kode_voucher']; ?></td>
                                        <td class="no-td">
                                            <a href="?halaman=edit_voucher_diskon&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                                            <a id="tombol-hapus" href="?halaman=hapus_voucher_diskon&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" data-text="Menghapus voucher diskon '<?= $row['nama']; ?>' akan membuat data riwayat penjualan dengan voucher diskon '<?= $row['nama']; ?>' ikut terhapus!" data-button-text="Hapus Voucher Diskon!">
                                                Hapus
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