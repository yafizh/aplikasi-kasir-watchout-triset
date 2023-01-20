<div id="main">
    <?php
    $result = $mysqli->query("SELECT * FROM jenis_pakaian WHERE id=" . $_GET['id_jenis_pakaian']);
    $jenis_pakaian = $result->fetch_assoc();

    $result = $mysqli->query("SELECT * FROM merk WHERE id=" . $_GET['id_merk']);
    $merk = $result->fetch_assoc();
    ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>
                        <a href="?halaman=pakaian&id_merk=<?= $_GET['id_merk']; ?>" class="text-reset"><i class="bi bi-arrow-bar-left"></i> <?= $jenis_pakaian['nama']; ?> <?= $merk['nama']; ?></a>
                    </h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_pakaian&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $_GET['id_merk']; ?>" class="btn btn-primary align-self-start text-white">Tambah Pakaian</a>
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
                                <th class="text-center">Harga</th>
                                <th class="text-center">Warna Pakaian yang Tersedia</th>
                                <th class="text-center no-td"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT  
                                    p.id,
                                    p.nama,
                                    p.harga,
                                    (
                                        SELECT 
                                            COUNT(id) 
                                        FROM 
                                            warna_pakaian AS wp 
                                        WHERE 
                                            wp.id_pakaian=p.id
                                    )  AS jumlah
                                FROM 
                                    pakaian AS p 
                                WHERE 
                                    p.id_merk=" . $_GET['id_merk'] . " 
                                    AND 
                                    p.id_jenis_pakaian=" . $_GET['id_jenis_pakaian'] . "
                                ORDER BY p.nama 
                             ";
                            $data = $mysqli->query($query);
                            $no = 1;
                            ?>
                            <?php while ($row = $data->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= $row['nama']; ?></td>
                                    <td class="text-center">Rp <?= number_format($row['harga'], 0, ",", "."); ?></td>
                                    <td class="text-center"><?= empty($row['jumlah']) ? 'Warna Pakaian Belum Ditambahkan' : ($row['jumlah'] . ' Warna'); ?></td>
                                    <td class="no-td">
                                        <a href="?halaman=pakaian_per_warna&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $_GET['id_merk']; ?>&id_pakaian=<?= $row['id']; ?>" class="btn btn-info btn-sm text-white"><i class="fas fa-eye"></i></a>
                                        <a href="?halaman=edit_pakaian&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                        <a id="tombol-hapus" href="?halaman=hapus_pakaian&id_jenis_pakaian=<?= $_GET['id_jenis_pakaian']; ?>&id_merk=<?= $_GET['id_merk']; ?>&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" data-text="Menghapus '<?= $row['nama']; ?>' akan membuat data pakaian berserta warna dan riwayat stoknya ikut terhapus!" data-button-text="Hapus Ukuran!">
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