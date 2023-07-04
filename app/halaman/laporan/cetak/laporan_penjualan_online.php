<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Penjualan Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include_once('header.php'); ?>
    <h4 class="text-center my-3">Laporan Data Penjualan Online</h4>
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
            <thead class="text-center">
                <tr>
                    <th class="text-center align-middle">No</th>
                    <th class="text-center align-middle">Tanggal</th>
                    <th class="text-center align-middle">Nama Pembeli</th>
                    <th class="text-center align-middle">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
                SELECT 
                    DATE(tanggal_waktu) AS tanggal,
                    pembeli.nama AS nama_pembeli,
                    SUM(pt.harga_penjualan * pt.jumlah) AS total 
                FROM 
                    penjualan_online AS p 
                INNER JOIN 
                    detail_penjualan_online AS pt 
                ON 
                    p.id=pt.id_penjualan_online 
                INNER JOIN 
                    pembeli  
                ON 
                    pembeli.id=p.id_pembeli 
                ";

                $where = " WHERE 1=1";

                if (!empty($_GET['dari_tanggal'] ?? ''))
                    $where .= " AND DATE(tanggal_waktu) >= '" . $_GET['dari_tanggal'] . "'";

                if (!empty($_GET['sampai_tanggal'] ?? ''))
                    $where .= " AND DATE(tanggal_waktu) <= '" . $_GET['sampai_tanggal'] . "'";

                $query .= $where . " GROUP BY p.id ORDER BY tanggal_waktu DESC";

                $data = $mysqli->query($query);
                $no = 1;
                ?>
                <?php if ($data->num_rows) : ?>
                    <?php while ($row = $data->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++; ?></td>
                            <td class="text-center align-middle"><?= indonesiaDate($row['tanggal']); ?></td>
                            <td class="text-center align-middle"><?= $row['nama_pembeli']; ?></td>
                            <td class="text-center align-middle">Rp <?= number_format($row['total'], 0, ",", "."); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="4">Tidak Ada Data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>