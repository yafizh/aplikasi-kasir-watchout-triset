<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Data Ukuran Pakaian</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_ukuran&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>" class="btn btn-primary align-self-start text-white">Tambah</a>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="no-td">No</th>
                                <th class="text-center">Ukuran</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $data = $mysqli->query('SELECT * FROM ukuran WHERE id_jenis_pakaian=' . $_GET['id_jenis_pakaian'] . " ORDER BY FIELD(nama, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), nama");
                        $no = 1;
                        ?>
                        <tbody>
                            <?php if ($data->num_rows) : ?>
                                <?php while ($row = $data->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="no-td">
                                            <a href="?halaman=edit_ukuran&id=<?= $row['id']; ?>&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                            <a id="tombol-hapus" href="?halaman=hapus_ukuran&id=<?= $row['id']; ?>&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>" class="btn btn-danger btn-sm" data-text="Menghapus ukuran '<?= $row['nama']; ?>' akan membuat data pakaian dengan ukuran '<?= $row['nama']; ?>' dan riwayat stoknya ikut terhapus!" data-button-text="Hapus Ukuran!">
                                                <i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td class="text-center" colspan="4">Data Tidak Ada</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>