<div id="main">
    <?php
    $result = $mysqli->query("SELECT * FROM merk WHERE id=" . $_GET['id_merk']);
    $merk = $result->fetch_assoc();
    ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3><?= $merk['nama']; ?></h3>
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
                                <th class="text-center">Jenis Pakaian</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT 
                                    jp.id, 
                                    jp.nama,
                                    (SELECT COUNT(id) FROM pakaian AS p WHERE p.id_jenis_pakaian=jp.id AND p.id_merk=".$_GET['id_merk'].") AS jumlah
                                FROM 
                                    jenis_pakaian AS jp 
                                ORDER BY 
                                    jp.nama
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
                                        <a href="?halaman=pakaian_per_jenis&id_merk=<?= $_GET['id_merk']; ?>&id_jenis_pakaian=<?= $row['id']; ?>" class="btn btn-info btn-sm text-white"><i class="fas fa-eye"></i></a>
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