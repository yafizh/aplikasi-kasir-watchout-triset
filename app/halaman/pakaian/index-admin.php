<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <?php
    $result = $mysqli->query("SELECT * FROM jenis_pakaian WHERE id=" . $_GET['id_jenis_pakaian']);
    $jenis_pakaian = $result->fetch_assoc();
    ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Data <?= $jenis_pakaian['nama']; ?></h3>
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
                                <th class="text-center">Jumlah Pakaian</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT 
                                    m.id,
                                    m.nama,
                                    (
                                        SELECT 
                                            COUNT(DISTINCT p.nama) 
                                        FROM 
                                            pakaian AS p 
                                        WHERE 
                                            p.id_merk=m.id 
                                            AND 
                                            p.id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "
                                        GROUP BY 
                                            p.nama
                                    ) AS jumlah 
                                FROM 
                                    merk AS m 
                                ORDER BY m.nama
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
                                        <a href="?halaman=pakaian_per_merk&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $row['id']; ?>" class="btn btn-info btn-sm text-white"><i class="fas fa-eye"></i></a>
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