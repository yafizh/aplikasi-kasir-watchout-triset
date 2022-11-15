<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <?php
    $result = $mysqli->query("SELECT * FROM jenis_pakaian WHERE id=" . $_GET['id_jenis_pakaian']);
    $jenis_pakaian = $result->fetch_assoc();

    $result = $mysqli->query("SELECT * FROM pakaian WHERE id=" . $_GET['id_pakaian']);
    $pakaian = $result->fetch_assoc();
    ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3><a href="?halaman=pakaian_per_jenis&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $_GET['id_merk']; ?>" class="text-reset"><i class="bi bi-arrow-bar-left"></i></a>Data Warna <?= $jenis_pakaian['nama']; ?> <?= $pakaian['nama']; ?></h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_warna_pakaian&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $_GET['id_pakaian']; ?>" class="btn btn-primary align-self-start text-white">Tambah Warna</a>
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
                                <th class="text-center">Warna</th>
                                <th class="text-center">Ukuran yang Tersedia</th>
                                <th class="text-center no-td"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT  
                                    wp.id,
                                    w.nama 
                                FROM 
                                    warna_pakaian AS wp
                                INNER JOIN 
                                    pakaian AS p 
                                ON  
                                    wp.id_pakaian=p.id
                                INNER JOIN 
                                    warna AS w 
                                ON  
                                    wp.id_warna=w.id 
                                WHERE 
                                    wp.id_pakaian=" . $_GET['id_pakaian'] . "
                                ORDER BY w.nama 
                             ";

                            $result = $mysqli->query($query);
                            $data = $result->fetch_all(MYSQLI_ASSOC);

                            foreach ($data as $index => $warna_pakaian) {
                                $query = "
                                SELECT 
                                    u.nama 
                                FROM 
                                    ukuran_warna_pakaian AS uwp 
                                INNER JOIN
                                    ukuran AS u 
                                ON 
                                    uwp.id_ukuran=u.id
                                WHERE 
                                    id_warna_pakaian=" . $warna_pakaian['id'] . "
                                ORDER BY FIELD(u.nama, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), u.nama    
                                ";
                                $result = $mysqli->query($query);
                                $data[$index]['ukuran'] = '';
                                $ukuran = [];
                                while ($row = $result->fetch_assoc()) {
                                    $ukuran[] = $row['nama'];
                                }
                                $data[$index]['ukuran'] = implode(', ', $ukuran);
                            }
                            $no = 1;
                            ?>
                            <?php foreach ($data as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['nama']; ?></td>
                                    <td class="text-center"><?= empty($row['ukuran']) ? 'Ukuran Belum Ditambahkan' : $row['ukuran']; ?></td>
                                    <td class="no-td">
                                        <a href="?halaman=edit_warna_pakaian&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $_GET['id_pakaian']; ?>&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                        <a id="tombol-hapus" href="?halaman=hapus_warna_pakaian&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $_GET['id_pakaian']; ?>&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" data-text="Menghapus warna '<?= $row['nama']; ?>' akan membuat data pakaian dengan warna '<?= $row['nama']; ?>' dan riwayat stoknya ikut terhapus!" data-button-text="Hapus Ukuran!">
                                            <i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>