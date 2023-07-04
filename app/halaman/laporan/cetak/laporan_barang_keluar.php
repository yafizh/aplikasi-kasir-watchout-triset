<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Barang Keluar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include_once('header.php'); ?>
    <h4 class="text-center my-3">Laporan Data Barang Keluar</h4>
    <section class="p-3">
        <strong>
            <span style="width: 150px; display: inline-block;">Filter</span>
        </strong>
        <br>
        <span style="width: 150px; display: inline-block;">Dari Tanggal</span>
        <span>: <?= empty($_GET['dari_tanggal']) ? 'Tidak Ditentukan' : indonesiaDate($_GET['dari_tanggal']); ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Sampai Tanggal</span>
        <span>: <?= empty($_GET['sampai_tanggal']) ? 'Tidak Ditentukan' : indonesiaDate($_GET['sampai_tanggal']); ?></span>
    </section>
    <main class="p-3">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center align-middle no-td">No</th>
                    <th class="text-center align-middle">Tanggal</th>
                    <th class="text-center align-middle">Merk</th>
                    <th class="text-center align-middle">Jenis Pakaian</th>
                    <th class="text-center align-middle">Nama</th>
                    <th class="text-center align-middle">Warna</th>
                    <th class="text-center align-middle">Ukuran</th>
                    <th class="text-center align-middle">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
                    SELECT 
                        m.nama AS merk,
                        jp.nama AS kategori_pakaian,
                        p.nama AS nama_pakaian,
                        wp.warna,
                        u.ukuran,
                        pt.jumlah,
                        DATE(pe.tanggal_waktu_penjualan) AS tanggal,
                        pt.id  
                    FROM 
                        detail_penjualan AS pt 
                    INNER JOIN 
                        penjualan AS pe 
                    ON 
                        pe.id=pt.id_penjualan 
                    INNER JOIN 
                        ukuran_warna_pakaian AS uwp 
                    ON 
                        uwp.id=pt.id_ukuran_warna_pakaian 
                    INNER JOIN 
                        ukuran_pakaian AS u 
                    ON 
                        u.id=uwp.id_ukuran_pakaian
                    INNER JOIN 
                        warna_pakaian AS wp 
                    ON 
                        wp.id=uwp.id_warna_pakaian  
                    INNER JOIN 
                        pakaian AS p 
                    ON 
                        p.id=wp.id_pakaian 
                    INNER JOIN
                    kategori_pakaian AS jp 
                    ON 
                        jp.id=p.id_kategori_pakaian 
                    INNER JOIN 
                        merk AS m 
                    ON 
                        m.id=p.id_merk 
                ";

                $where = " WHERE 1=1 ";
                if (!empty($_GET['dari_tanggal'] ?? ''))
                    $where .= " AND DATE(pe.tanggal_waktu_penjualan) >= '" . $_GET['dari_tanggal'] . "'";

                if (!empty($_GET['sampai_tanggal'] ?? '')) {
                    $where .= " AND DATE(pe.tanggal_waktu_penjualan) <= '" . $_GET['sampai_tanggal'] . "'";
                }

                $query .= $where . " ORDER BY DATE(pe.tanggal_waktu_penjualan) DESC";
                $data = $mysqli->query($query);
                $no = 1;
                ?>
                <?php if ($data->num_rows) : ?>
                    <?php while ($row = $data->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++; ?></td>
                            <td class="text-center align-middle"><?= indonesiaDate($row['tanggal']); ?></td>
                            <td class="text-center align-middle"><?= $row['merk']; ?></td>
                            <td class="text-center align-middle"><?= $row['kategori_pakaian']; ?></td>
                            <td class="text-center align-middle"><?= $row['nama_pakaian']; ?></td>
                            <td class="text-center align-middle"><?= $row['warna']; ?></td>
                            <td class="text-center align-middle"><?= $row['ukuran']; ?></td>
                            <td class="text-center align-middle"><?= $row['jumlah']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="8">Tidak Ada Data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>