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
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="no-td">No</th>
                                <th class="text-center">Ukuran</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = $mysqli->query('SELECT * FROM ukuran WHERE id_jenis_pakaian=' . $_GET['id_jenis_pakaian'] . " ORDER BY FIELD(nama, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), nama");
                            $no = 1;
                            ?>
                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['nama']; ?></td>
                                    <td><?= $row['keterangan']; ?></td>
                                    <td class="no-td">
                                        <a href="?halaman=edit_ukuran&id=<?= $row['id']; ?>&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                                        <a id="tombol-hapus" href="?halaman=hapus_ukuran&id=<?= $row['id']; ?>&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>" class="btn btn-danger btn-sm" data-text="Menghapus ukuran '<?= $row['nama']; ?>' akan membuat data pakaian dengan ukuran '<?= $row['nama']; ?>' dan riwayat stoknya ikut terhapus!" data-button-text="Hapus Ukuran!">
                                            Hapus</a>
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