<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Laporan Pakaian Terlaris</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="section">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="merk">Merk</label>
                                            <select name="merk" id="merk" class="form-control">
                                                <option value="">Semua Merk</option>
                                                <?php $result = $mysqli->query("SELECT * FROM merk"); ?>
                                                <?php while ($row = $result->fetch_assoc()) : ?>
                                                    <option <?= (($_POST['merk'] ?? '') == $row['id']) ? 'selected' : ''; ?> value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="kategori_pakaian">Jenis Pakaian</label>
                                            <select name="kategori_pakaian" id="kategori_pakaian" class="form-control">
                                                <option value="">Semua Jenis Pakaian</option>
                                                <?php $result = $mysqli->query("SELECT * FROM kategori_pakaian"); ?>
                                                <?php while ($row = $result->fetch_assoc()) : ?>
                                                    <option <?= (($_POST['kategori_pakaian'] ?? '') == $row['id']) ? 'selected' : ''; ?> value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label for="bulan">Bulan</label>
                                            <input type="month" id="bulan" name="bulan" class="form-control" value="<?= $_POST['bulan'] ?? Date("Y-m"); ?>">
                                        </div>
                                        <div class="d-flex gap-3 flex-wrap">
                                            <a href="" class="btn btn-secondary flex-grow-1">Reset</a>
                                            <button type="submit" class="btn flex-grow-1 btn-info text-white">Filter</button>
                                            <a href="laporan/cetak/laporan_pakaian_terlaris.php?id_merk=<?= $_POST['merk'] ?? ''; ?>&bulan=<?= $_POST['bulan'] ?? Date('Y-m'); ?>&id_kategori_pakaian=<?= $_POST['kategori_pakaian'] ?? ''; ?>" target="_blank" class="btn btn-success flex-grow-1">Cetak</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="no-td text-center align-middle">No</th>
                                        <th class="text-center align-middle">Merk</th>
                                        <th class="text-center align-middle">Jenis Pakaian</th>
                                        <th class="text-center align-middle">Nama Pakaian</th>
                                        <th class="text-center align-middle">Jumlah Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "
                                        SELECT 
                                            m.nama AS merk,
                                            jp.nama AS kategori_pakaian,
                                            p.nama,
                                            (
                                                SELECT 
                                                    IFNULL(SUM(pt.jumlah), 0) 
                                                FROM 
                                                    warna_pakaian AS wp 
                                                INNER JOIN 
                                                    ukuran_warna_pakaian AS uwp  
                                                ON 
                                                    wp.id=uwp.id_warna_pakaian
                                                INNER JOIN 
                                                    detail_penjualan AS pt 
                                                ON 
                                                    pt.id_ukuran_warna_pakaian=uwp.id 
                                                INNER JOIN 
                                                    penjualan AS pe 
                                                ON 
                                                    pt.id_penjualan=pe.id 
                                                WHERE 
                                                    wp.id_pakaian=p.id 
                                                    AND 
                                                    MONTH(pe.tanggal_waktu_penjualan) = '" . (isset($_POST['bulan']) ? explode('-', $_POST['bulan'])[1] : Date('m')) . "' 
                                                    AND 
                                                    YEAR(pe.tanggal_waktu_penjualan) = '" . (isset($_POST['bulan']) ? explode('-', $_POST['bulan'])[0] : Date('Y')) . "'
                                            ) AS pakaian_keluar1,
                                            (
                                                SELECT 
                                                    IFNULL(SUM(pt.jumlah), 0) 
                                                FROM 
                                                    warna_pakaian AS wp 
                                                INNER JOIN 
                                                    ukuran_warna_pakaian AS uwp  
                                                ON 
                                                    wp.id=uwp.id_warna_pakaian
                                                INNER JOIN 
                                                    detail_penjualan_online AS pt 
                                                ON 
                                                    pt.id_ukuran_warna_pakaian=uwp.id 
                                                INNER JOIN 
                                                    penjualan_online AS pe 
                                                ON 
                                                    pt.id_penjualan_online=pe.id 
                                                WHERE 
                                                    wp.id_pakaian=p.id 
                                                    AND 
                                                    MONTH(pe.tanggal_waktu) = '" . (isset($_POST['bulan']) ? explode('-', $_POST['bulan'])[1] : Date('m')) . "' 
                                                    AND 
                                                    YEAR(pe.tanggal_waktu) = '" . (isset($_POST['bulan']) ? explode('-', $_POST['bulan'])[0] : Date('Y')) . "'
                                            ) AS pakaian_keluar2 
                                        FROM 
                                            pakaian AS p 
                                        INNER JOIN 
                                            merk AS m 
                                        ON 
                                            m.id=p.id_merk 
                                        INNER JOIN 
                                            kategori_pakaian AS jp 
                                        ON 
                                            jp.id=p.id_kategori_pakaian 
                                    ";

                                    $where = "WHERE 1=1";

                                    if (!empty($_POST['merk'] ?? ''))
                                        $where .= " AND p.id_merk=" . $_POST['merk'];

                                    if (!empty($_POST['kategori_pakaian'] ?? ''))
                                        $where .= " AND p.id_kategori_pakaian=" . $_POST['kategori_pakaian'];

                                    $query .= $where;

                                    $query .= " ORDER BY (pakaian_keluar1 + pakaian_keluar2) DESC";

                                    $data = $mysqli->query($query);
                                    $no = 1;
                                    ?>
                                    <?php if ($data->num_rows) : ?>
                                        <?php while ($row = $data->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= $row['merk']; ?></td>
                                                <td class="text-center"><?= $row['kategori_pakaian']; ?></td>
                                                <td class=""><?= $row['nama']; ?></td>
                                                <td class="text-center"><?= $row['pakaian_keluar1'] + $row['pakaian_keluar2']; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td class="text-center" colspan="5">Tidak Ada Data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>