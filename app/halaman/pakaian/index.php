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
                                " href="?halaman=pakaian&id_merk=<?= $value['id']; ?><?= isset($_GET['id_kategori_pakaian']) ? '&id_kategori_pakaian=' . $_GET['id_kategori_pakaian'] : ''; ?>">
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
                                " href="?halaman=pakaian&id_merk=<?= $id_merk; ?>&id_kategori_pakaian=<?= $value['id']; ?>">
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
                                <?php
                                $result = $mysqli->query("SELECT * FROM pakaian WHERE id=" . $_GET['id_pakaian']);
                                $pakaian = $result->fetch_assoc()
                                ?>
                                <h5><a href="<?= $_SERVER['HTTP_REFERER']; ?>">Pakaian</a></h5>
                                <h5 class="text-muted mx-2">/</h5>
                                <h5 class="text-muted"><?= $pakaian['nama']; ?></h5>
                            <?php else : ?>
                                <h5>Pakaian</h5>
                            <?php endif; ?>
                            <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                                <a href="?halaman=tambah_pakaian&id_merk=<?= $id_merk ?>&id_kategori_pakaian=<?= $id_kategori_pakaian ?>" class="btn btn-primary align-self-start text-white">
                                    Tambah Pakaian
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center no-td">No</th>
                                            <th class="text-center">Nama Pakaian</th>
                                            <th class="text-center">Ukuran Tersedia</th>
                                            <th class="text-center">Warna Tersedia</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $query = "
                                        SELECT 
                                            p.*,
                                            (
                                                SELECT 
                                                    GROUP_CONCAT(up.ukuran SEPARATOR ', ') 
                                                FROM 
                                                    ukuran_pakaian up 
                                                WHERE 
                                                    up.id_pakaian=p.id 
                                                ORDER BY FIELD(up.ukuran, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), up.ukuran    
                                            ) AS ukuran,
                                            (
                                                SELECT 
                                                    COUNT(id) 
                                                FROM 
                                                    warna_pakaian AS wp 
                                                WHERE 
                                                    wp.id_pakaian=p.id
                                            ) AS warna_pakaian
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
                                                <td class="text-center"><?= $row['ukuran']; ?></td>
                                                <td class="text-center">
                                                    <?= $row['warna_pakaian']; ?> Warna
                                                    |
                                                    <a href="?<?= $_SERVER['QUERY_STRING']; ?>&id_pakaian=<?= $row['id']; ?>">
                                                        Lihat
                                                    </a>
                                                </td>
                                                <td class="no-td">
                                                    <a href="?halaman=edit_pakaian&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white" title="Edit">
                                                        Edit
                                                    </a>
                                                    <a id="tombol-hapus" href="?halaman=hapus_pakaian&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" title="Hapus" data-text="Menghapus pakaian '<?= $row['nama']; ?>' akan membuat riwayat stok dan penjualannya ikut terhapus!" data-button-text="Hapus Pakaian!">
                                                        Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
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