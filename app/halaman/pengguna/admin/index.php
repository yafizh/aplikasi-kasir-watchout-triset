<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Data Admin</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_admin" class="btn btn-primary align-self-start text-white">Tambah Admin</a>
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
                                <th class="text-center">Username</th>
                                <th class="text-center no-td"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = $mysqli->query('SELECT * FROM pengguna WHERE status="ADMIN" ORDER BY username');
                            $no = 1;
                            ?>
                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['username']; ?></td>
                                    <td class="no-td">
                                        <a href="?halaman=edit_admin&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                        <a id="tombol-hapus" href="?halaman=hapus_admin&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" data-text="Akun admin hanya dapat ditambahkan oleh admin lainnya!" data-button-text="Hapus Admin!">
                                            <i class="fas fa-trash-alt"></i></a>
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