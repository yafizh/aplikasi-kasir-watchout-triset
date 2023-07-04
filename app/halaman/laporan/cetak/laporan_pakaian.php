<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pakaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include_once('header.php'); ?>
    <?php
    $merk = $mysqli->query("SELECT * FROM merk WHERE id='" . $_GET['id_merk'] . "'")->fetch_assoc();
    $kategori_pakaian = $mysqli->query("SELECT * FROM kategori_pakaian WHERE id='" . $_GET['id_kategori_pakaian'] . "'")->fetch_assoc();
    ?>
    <h4 class="text-center my-3">Laporan Data Pakaian</h4>
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
    </section>
    <main class="p-3">
        <table class="table table-striped table-bordered">
            <thead class="text-center">
                <tr>
                    <th class="text-center align-middle">No</th>
                    <th class="text-center align-middle">Merk</th>
                    <th class="text-center align-middle">Jenis Pakaian</th>
                    <th class="text-center align-middle">Nama Pakaian</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
                    SELECT 
                        m.nama AS merk,
                        jp.nama AS kategori_pakaian,
                        p.nama 
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

                $query .= $where . " ORDER BY p.nama ASC";

                $data = $mysqli->query($query);
                $no = 1;
                ?>
                <?php if ($data->num_rows) : ?>
                    <?php while ($row = $data->fetch_assoc()) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $no++; ?></td>
                            <td class="text-center align-middle"><?= $row['merk']; ?></td>
                            <td class="text-center align-middle"><?= $row['kategori_pakaian']; ?></td>
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
    </main>
    <?php include_once('footer.php'); ?>
</body>

</html>