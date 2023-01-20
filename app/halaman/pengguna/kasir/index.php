<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Data Kasir</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_kasir" class="btn btn-primary align-self-start text-white">Tambah Kasir</a>
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
                                <th class="text-center">Username</th>
                                <th class="text-center no-td"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = $mysqli->query('
                                SELECT 
                                    p.id,
                                    k.nama,
                                    p.username  
                                FROM 
                                    pengguna AS p 
                                INNER JOIN 
                                    kasir AS k 
                                ON 
                                    k.id_pengguna=p.id 
                                WHERE 
                                    p.status="KASIR" 
                                ORDER BY 
                                    k.nama
                                ');
                            $no = 1;
                            ?>
                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['nama']; ?></td>
                                    <td class="text-center"><?= $row['username']; ?></td>
                                    <td class="no-td">
                                        <a href="?halaman=ganti_password&id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm text-white" title="Ganti Password"><i class="fas fa-lock"></i></a>
                                        <a href="?halaman=edit_kasir&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a id="tombol-hapus" href="?halaman=hapus_kasir&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" title="Hapus" data-text="Akun kasir hanya dapat ditambahkan oleh admin lainnya!" data-button-text="Hapus Admin!">
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