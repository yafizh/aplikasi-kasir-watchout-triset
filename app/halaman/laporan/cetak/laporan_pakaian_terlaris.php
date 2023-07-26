<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pakaian Terlaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include_once('header.php'); ?>
    <?php
    $merk = $mysqli->query("SELECT * FROM merk WHERE id='" . $_GET['id_merk'] . "'")->fetch_assoc();
    $kategori_pakaian = $mysqli->query("SELECT * FROM kategori_pakaian WHERE id='" . $_GET['id_kategori_pakaian'] . "'")->fetch_assoc();
    $bulan = explode("-", $_GET['bulan'])[1];
    $tahun = explode("-", $_GET['bulan'])[0];
    ?>
    <h4 class="text-center my-3">Laporan Data Pakaian Terlaris</h4>
    <section class="p-3">
        <strong>
            <span style="width: 150px; display: inline-block;">Filter</span>
        </strong>
        <br>
        <span style="width: 150px; display: inline-block;">Merk</span>
        <span>: <?= empty($_GET['id_merk']) ? 'Semua Merk' : $merk['nama']; ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Jenis Pakaian</span>
        <span>: <?= empty($_GET['id_kategori_pakaian']) ? 'Semua Jenis Pakaian' : $kategori_pakaian['nama']; ?></span>
        <br>
        <span style="width: 150px; display: inline-block;">Bulan</span>
        <span>: <?= MONTH_IN_INDONESIA[$bulan - 1]; ?> <?= $tahun; ?></span>
    </section>
    <main class="p-3">
        <table class="table table-striped table-bordered">
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

                if (!empty($_GET['id_merk'] ?? ''))
                    $where .= " AND p.id_merk=" . $_GET['id_merk'];

                if (!empty($_GET['id_kategori_pakaian'] ?? ''))
                    $where .= " AND p.id_kategori_pakaian=" . $_GET['id_kategori_pakaian'];

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
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>