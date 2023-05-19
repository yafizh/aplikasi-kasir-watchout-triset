<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <h3><?= $title; ?></h3>
        </div>
        <hr>
        <section class="section">
            <?php
            $result = $mysqli->query("SELECT * FROM merk");
            $merk = $result->fetch_all(MYSQLI_ASSOC);
            ?>
            <h5>Merk</h5>
            <?php if (count($merk)) : ?>
                <ul class="nav nav-pills mb-3">
                    <?php $id_merk = $_GET['id_merk'] ?? $merk[0]['id']; ?>
                    <?php foreach ($merk as $index => $value) : ?>
                        <li class="nav-item me-2">
                            <a class="
                                nav-link 
                                <?= $value['id'] == $id_merk ? 'active' : 'bg-white shadow'; ?>
                                " href="?halaman=stok&id_merk=<?= $value['id']; ?><?= isset($_GET['id_kategori_pakaian']) ? '&id_kategori_pakaian=' . $_GET['id_kategori_pakaian'] : ''; ?>">
                                <?= $value['nama']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php
                $result = $mysqli->query("SELECT * FROM kategori_pakaian");
                $kategori_pakaian = $result->fetch_all(MYSQLI_ASSOC);
                ?>
                <h5>Kategori Pakaian</h5>
                <?php if (count($kategori_pakaian)) : ?>
                    <ul class="nav nav-pills mb-3">
                        <?php $id_kategori_pakaian = $_GET['id_kategori_pakaian'] ?? $kategori_pakaian[0]['id']; ?>
                        <?php foreach ($kategori_pakaian as $index => $value) : ?>
                            <li class="nav-item me-2">
                                <a class="
                                nav-link 
                                <?= $value['id'] == $id_kategori_pakaian ? 'active' : 'bg-white shadow'; ?>
                                " href="?halaman=stok&id_merk=<?= $id_merk; ?>&id_kategori_pakaian=<?= $value['id']; ?>">
                                    <?= $value['nama']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                    $result = $mysqli->query("SELECT * FROM pakaian WHERE id_merk=$id_merk AND id_kategori_pakaian=$id_kategori_pakaian");
                    $kategori_pakaian = $result->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <div class="card rounded-1">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <?php if (isset($_GET['id_pakaian'])) : ?>
                                <div class="d-flex">
                                    <?php
                                    $result = $mysqli->query("SELECT * FROM pakaian WHERE id=" . $_GET['id_pakaian']);
                                    $pakaian = $result->fetch_assoc();
                                    ?>
                                    <h5><a href="?halaman=stok&id_merk=<?= $id_merk; ?>&id_kategori_pakaian=<?= $id_kategori_pakaian; ?>">Pakaian</a></h5>
                                    <h5 class="text-muted mx-2">/</h5>
                                    <h5 class="text-muted"><?= $pakaian['nama']; ?></h5>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="?halaman=tambah_stok&id_pakaian=<?= $pakaian['id']; ?>" class="btn btn-primary align-self-start text-white">
                                        Suplai Pakaian
                                    </a>
                                </div>
                            <?php else : ?>
                                <h5>Pakaian</h5>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_GET['id_pakaian'])) : ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center no-td">No</th>
                                                <th class="text-center">Warna</th>
                                                <th class="text-center">Ukuran</th>
                                                <th class="text-center">Stok</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $result = $mysqli->query("SELECT * FROM warna_pakaian WHERE id_pakaian=" . $pakaian['id']);
                                        $warna_pakaian = $result->fetch_all(MYSQLI_ASSOC);
                                        foreach ($warna_pakaian as $index => $warna) {
                                            $query = "
                                                SELECT 
                                                    up.ukuran,
                                                    (
                                                        IFNULL((SELECT SUM(pd.jumlah) FROM pakaian_disuplai pd WHERE pd.id_ukuran_warna_pakaian=uwp.id), 0)
                                                        - 
                                                        IFNULL((SELECT SUM(dp.jumlah) FROM detail_penjualan dp WHERE dp.id_ukuran_warna_pakaian=uwp.id), 0)
                                                    ) AS jumlah 
                                                FROM 
                                                    ukuran_warna_pakaian uwp
                                                INNER JOIN 
                                                    ukuran_pakaian up
                                                ON 
                                                    up.id=uwp.id_ukuran_pakaian 
                                                WHERE 
                                                    uwp.id_warna_pakaian=" . $warna['id'] . " 
                                                ORDER BY FIELD(up.ukuran, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), up.ukuran    
                                            ";
                                            $result = $mysqli->query($query);
                                            $warna_pakaian[$index]['ukuran_pakaian'] = $result->fetch_all(MYSQLI_ASSOC);
                                        }
                                        $no = 1;
                                        ?>
                                        <tbody>
                                            <?php foreach ($warna_pakaian as $warna) : ?>
                                                <tr>
                                                    <td rowspan="<?= count($warna) - 2 ?>" class="text-center no-td"><?= $no++; ?></td>
                                                    <td rowspan="<?= count($warna) - 2 ?>" class="text-center"><?= $warna['warna']; ?></td>
                                                    <td class="text-center"><?= $warna['ukuran_pakaian'][0]['ukuran']; ?></td>
                                                    <td class="text-center"><?= $warna['ukuran_pakaian'][0]['jumlah']; ?></td>
                                                </tr>
                                                <?php foreach ($warna['ukuran_pakaian'] as $index => $ukuran_pakaian) : ?>
                                                    <?php if ($index) : ?>
                                                        <tr>
                                                            <td class="text-center"><?= $ukuran_pakaian['ukuran']; ?></td>
                                                            <td class="text-center"><?= $ukuran_pakaian['jumlah']; ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center no-td">No</th>
                                                <th class="text-center">Nama Pakaian</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $query = "
                                            SELECT 
                                                p.* 
                                            FROM 
                                                pakaian p
                                            WHERE 
                                                p.id_merk=" . $id_merk . "
                                                AND 
                                                p.id_kategori_pakaian=" . $id_kategori_pakaian . "
                                        ";
                                        $result = $mysqli->query($query);
                                        $no = 1;
                                        ?>
                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()) : ?>
                                                <tr>
                                                    <td class="text-center no-td"><?= $no++; ?></td>
                                                    <td class="text-center"><?= $row['nama']; ?></td>
                                                    <td class="no-td">
                                                        <a href="?<?= $_SERVER['QUERY_STRING']; ?>&id_pakaian=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white" title="Edit">
                                                            Lihat Stok
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <h5 class="text-center">Kategori Pakaian Belum Ditambahkan</h5>
                <?php endif; ?>
            <?php else : ?>
                <h5 class="text-center">Merk Belum Ditambahkan</h5>
            <?php endif; ?>
        </section>
    </div>
</div>