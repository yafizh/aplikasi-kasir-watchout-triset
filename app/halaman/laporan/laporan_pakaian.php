<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

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
                                        <div class="d-flex gap-3 flex-wrap">
                                            <a href="" class="btn btn-secondary flex-grow-1">Reset</a>
                                            <button type="submit" class="btn flex-grow-1 btn-info text-white">Filter</button>
                                            <a href="laporan/cetak/laporan_pakaian.php?id_merk=<?= $_POST['merk'] ?? ''; ?>&id_jenis_pakaian=<?= $_POST['jenis_pakaian'] ?? ''; ?>" target="_blank" class="btn btn-success flex-grow-1">Cetak</a>
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
                                        <th class="no-td">No</th>
                                        <th class="text-center">Merk</th>
                                        <th class="text-center">Jenis Pakaian</th>
                                        <th class="text-center">Nama Pakaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $merk = $_POST['merk'] ?? '';
                                    $jenis_pakaian = $_POST['jenis_pakaian'] ?? '';

                                    $query = "
                                        SELECT 
                                            m.nama AS merk,
                                            jp.nama AS jenis_pakaian,
                                            p.nama 
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
                                        WHERE 
                                            m.id LIKE '%$merk%' AND jp.id LIKE '%$jenis_pakaian%' 
                                        ORDER BY 
                                            p.nama ASC
                                    ";
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
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td class="text-center" colspan="4">Tidak Ada Data</td>
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