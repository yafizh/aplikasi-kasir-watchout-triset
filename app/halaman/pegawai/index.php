<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Data Pegawai</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_pegawai" class="btn btn-primary align-self-start text-white">Tambah Pegawai</a>
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
                                <th class="text-center">Nama</th>
                                <th class="text-center">Tempat Lahir</th>
                                <th class="text-center">Tanggal Lahir</th>
                                <th class="text-center no-td"></th>
                            </tr>
                        </thead>
                        <?php
                        $data = $mysqli->query('SELECT * FROM pegawai');
                        $no = 1;
                        ?>
                        <tbody>
                            <?php if ($data->num_rows) : ?>
                                <?php while ($row = $data->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center"><?= $row['tempat_lahir']; ?></td>
                                        <td class="text-center"><?= $row['tanggal_lahir']; ?></td>
                                        <td class="no-td">
                                            <a href="?halaman=edit_pegawai&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                            <a id="tombol-hapus" href="?halaman=hapus_pegawai&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" data-text="Akun pegawai hanya dapat ditambahkan oleh pegawai lainnya!" data-button-text="Hapus Pegawai!">
                                                <i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td class="text-center" colspan="5">Data Tidak Ada</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>