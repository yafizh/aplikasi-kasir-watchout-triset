<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include_once('header.php'); ?>
    <h4 class="text-center my-3">Laporan Keuangan</h4>
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
                    <th class="text-center align-middle">Nama Pakaian</th>
                    <th class="text-center align-middle">Terjual</th>
                    <th class="text-center align-middle">Harga Modal X Terjual</th>
                    <th class="text-center align-middle">Harga Jual X Terjual</th>
                    <th class="text-center align-middle">Laba Bersih</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
                 SELECT 
                     p.nama AS nama_pakaian,
                     p.harga_modal,
                     dpo.harga_penjualan,
                     dpo.jumlah,
                     DATE(po.tanggal_waktu) AS tanggal 
                 FROM 
                     detail_penjualan_online AS dpo 
                 INNER JOIN 
                     penjualan_online AS po 
                 ON 
                     po.id=dpo.id_penjualan_online 
                 INNER JOIN 
                     ukuran_warna_pakaian uwp 
                 ON 
                     uwp.id=dpo.id_ukuran_warna_pakaian 
                 INNER JOIN 
                     ukuran_pakaian AS up 
                 ON 
                     up.id=uwp.id_ukuran_pakaian 
                 INNER JOIN 
                     pakaian p 
                 ON 
                     p.id=up.id_pakaian 
             ";


                $where = " WHERE 1=1";

                if (!empty($_POST['dari_tanggal'] ?? ''))
                    $where .= " AND DATE(po.tanggal_waktu) >= '" . $_POST['dari_tanggal'] . "'";

                if (!empty($_POST['sampai_tanggal'] ?? ''))
                    $where .= " AND DATE(po.tanggal_waktu) <= '" . $_POST['sampai_tanggal'] . "'";

                $query .= $where . " ORDER BY po.tanggal_waktu DESC";

                $data = $mysqli->query($query);
                $no = 1;
                $total_modal = 0;
                $total_jual = 0;
                $total_laba_bersih = 0;
                ?>
                <?php if ($data->num_rows) : ?>
                    <?php while ($row = $data->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++; ?></td>
                            <td class="text-center align-middle"><?= indonesiaDate($row['tanggal']); ?></td>
                            <td class="text-center align-middle"><?= $row['nama_pakaian']; ?></td>
                            <td class="text-center align-middle"><?= $row['jumlah']; ?></td>
                            <?php $modal = $row['harga_modal'] * $row['jumlah']; ?>
                            <td class="text-center align-middle">Rp <?= number_format($modal, 0, ",", "."); ?></td>
                            <?php $jual = $row['harga_penjualan'] * $row['jumlah']; ?>
                            <td class="text-center align-middle">Rp <?= number_format($jual, 0, ",", "."); ?></td>
                            <?php $laba_bersih = $jual - $modal; ?>
                            <td class="text-center align-middle">Rp <?= number_format($laba_bersih, 0, ",", "."); ?></td>
                            <?php
                            $total_modal += $modal;
                            $total_jual += $jual;
                            $total_laba_bersih += $laba_bersih;
                            ?>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="4"><strong>Total</strong></td>
                        <td class="text-center">Rp <?= number_format($total_modal, 0, ",", "."); ?></td>
                        <td class="text-center">Rp <?= number_format($total_jual, 0, ",", "."); ?></td>
                        <td class="text-center">Rp <?= number_format($total_laba_bersih, 0, ",", "."); ?></td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td class="text-center" colspan="7">Tidak Ada Data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>