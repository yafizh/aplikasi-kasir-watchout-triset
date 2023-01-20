<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Laporan Pakaian</h3>
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
                                            <label for="jenis_pakaian">Jenis Pakaian</label>
                                            <select name="jenis_pakaian" id="jenis_pakaian" class="form-control">
                                                <option value="">Semua Jenis Pakaian</option>
                                                <?php $result = $mysqli->query("SELECT * FROM jenis_pakaian"); ?>
                                                <?php while ($row = $result->fetch_assoc()) : ?>
                                                    <option <?= (($_POST['jenis_pakaian'] ?? '') == $row['id']) ? 'selected' : ''; ?> value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
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
                                            <a href="laporan/cetak/laporan_mutasi_pakaian.php?id_merk=<?= $_POST['merk'] ?? ''; ?>&bulan=<?= $_POST['bulan'] ?? Date('Y-m'); ?>&id_jenis_pakaian=<?= $_POST['jenis_pakaian'] ?? ''; ?>" target="_blank" class="btn btn-success flex-grow-1">Cetak</a>
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
                                        <th class="no-td text-center align-middle" rowspan="2">No</th>
                                        <th class="text-center align-middle" rowspan="2">Merk</th>
                                        <th class="text-center align-middle" rowspan="2">Jenis Pakaian</th>
                                        <th class="text-center align-middle" rowspan="2">Nama Pakaian</th>
                                        <th class="text-center align-middle" colspan="2">Mutasi</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center align-middle">Masuk</th>
                                        <th class="text-center align-middle">Keluar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "
                                        SELECT 
                                            m.nama AS merk,
                                            jp.nama AS jenis_pakaian,
                                            p.nama,
                                            (
                                                SELECT 
                                                    IFNULL(SUM(pd.jumlah), 0) 
                                                FROM 
                                                    warna_pakaian AS wp 
                                                INNER JOIN 
                                                    ukuran_warna_pakaian AS uwp  
                                                ON 
                                                    wp.id=uwp.id_warna_pakaian
                                                INNER JOIN 
                                                    pakaian_disuplai AS pd 
                                                ON 
                                                    pd.id_ukuran_warna_pakaian=uwp.id 
                                                WHERE 
                                                    wp.id_pakaian=p.id 
                                                    AND 
                                                    MONTH(pd.tanggal_masuk) = '" . (isset($_POST['bulan']) ? explode('-', $_POST['bulan'])[1] : Date('m')) . "' 
                                                    AND 
                                                    YEAR(pd.tanggal_masuk) = '" . (isset($_POST['bulan']) ? explode('-', $_POST['bulan'])[0] : Date('Y')) . "'
                                            ) AS pakaian_masuk,
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
                                                    pakaian_terjual AS pt 
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
                                            ) AS pakaian_keluar
                                        FROM 
                                            pakaian AS p 
                                        INNER JOIN 
                                            merk AS m 
                                        ON 
                                            m.id=p.id_merk 
                                        INNER JOIN 
                                            jenis_pakaian AS jp 
                                        ON 
                                            jp.id=p.id_jenis_pakaian
                                    ";

                                    $where = "WHERE 1=1";

                                    if (!empty($_POST['merk'] ?? ''))
                                        $where .= " AND p.id_merk=" . $_POST['merk'];

                                    if (!empty($_POST['jenis_pakaian'] ?? ''))
                                        $where .= " AND p.id_jenis_pakaian=" . $_POST['jenis_pakaian'];

                                    $query .= $where;

                                    $data = $mysqli->query($query);
                                    $no = 1;
                                    ?>
                                    <?php if ($data->num_rows) : ?>
                                        <?php while ($row = $data->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= $row['merk']; ?></td>
                                                <td class="text-center"><?= $row['jenis_pakaian']; ?></td>
                                                <td class=""><?= $row['nama']; ?></td>
                                                <td class="text-center"><?= $row['pakaian_masuk']; ?></td>
                                                <td class="text-center"><?= $row['pakaian_keluar']; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td class="text-center" colspan="6">Tidak Ada Data</td>
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