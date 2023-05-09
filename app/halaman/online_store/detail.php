<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../../database/koneksi.php');

// Helper 
require_once('../../helper/date.php');

$result = $mysqli->query("SELECT * FROM pakaian WHERE id=" . $_GET['id_pakaian']);
$pakaian = $result->fetch_assoc();

$warna_pakaian = $mysqli->query("SELECT * FROM warna_pakaian WHERE id_pakaian=" . $pakaian['id']);
$pakaian['warna_pakaian'] = $warna_pakaian->fetch_all(MYSQLI_ASSOC);

// $ukuran_pakaian = $mysqli->query("SELECT * FROM ukuran_pakaian WHERE id_pakaian=" . $pakaian['id'] . " ORDER BY FIELD(ukuran, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), ukuran ");
// $pakaian['ukuran_pakaian'] = $ukuran_pakaian->fetch_all(MYSQLI_ASSOC);

$pakaian['foto_pakaian'] = [];
foreach ($pakaian['warna_pakaian'] as $warna_pakaian) {
    $foto_pakaian = $mysqli->query("SELECT * FROM foto_pakaian WHERE id_warna_pakaian=" . $warna_pakaian['id']);
    $pakaian['foto_pakaian'][] = [
        'id_warna_pakaian' => $warna_pakaian['id'],
        'foto' => $foto_pakaian->fetch_all(MYSQLI_ASSOC)
    ];

    $query = "
    SELECT 
        up.id,
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
        uwp.id_warna_pakaian=" . $warna_pakaian['id'] . " 
    ORDER BY FIELD(up.ukuran, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), up.ukuran";

    $ukuran_pakaian = $mysqli->query($query);
    $pakaian['ukuran'][] = [
        'id_warna_pakaian' => $warna_pakaian['id'],
        'ukuran' => $ukuran_pakaian->fetch_all(MYSQLI_ASSOC)
    ];
}

$today = Date("Y-m-d");
$query = "
    SELECT 
        d.* 
    FROM 
        diskon_pakaian dp 
    INNER JOIN 
        diskon d 
    ON 
        dp.id_diskon=d.id  
    WHERE
        ( 
            '$today' >= d.tanggal_mulai 
            AND 
            '$today' <= d.tanggal_selesai  
        ) 
        AND 
        dp.id_pakaian=" . $pakaian['id'] . "
";
$result = $mysqli->query($query);
$pakaian['diskon'] = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Watchout Triset</title>
    <link href="../../assets/css/main/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/shared/iconly.css">
</head>

<body>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    </div>
    <style>
        @import "../../assets/css/main/fonts.css";

        body {
            font-family: 'Nunito';
        }
    </style>
    <div class="container mb-5">
        <?php $active = $_GET['from']; ?>
        <?php include_once('partials/navbar.php'); ?>
        <div class="row justify-content-between">
            <section class="col-12 col-md-4">
                <?php foreach ($pakaian['foto_pakaian'] as $index => $foto_pakaian) : ?>
                    <div id="carouselExampleIndicators<?= $index; ?>" data-id_warna_pakaian="<?= $foto_pakaian['id_warna_pakaian']; ?>" class="carousel slide <?= $index ? 'd-none' : ''; ?>" data-bs-ride="true">
                        <div class="carousel-indicators">
                            <?php foreach ($foto_pakaian['foto'] as $index_foto => $foto) : ?>
                                <img style="height: 4rem; width: 4rem; object-fit:cover;" src="<?= '../' . $foto['foto']; ?>" data-bs-target="#carouselExampleIndicators<?= $index; ?>" data-bs-slide-to="<?= $index_foto; ?>" <?= !$index_foto ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?= $index_foto + 1; ?>">
                            <?php endforeach; ?>
                        </div>
                        <div class="carousel-inner">
                            <?php foreach ($foto_pakaian['foto'] as $index_foto => $foto) : ?>
                                <div class="carousel-item <?= !$index_foto ? 'active' : ''; ?>">
                                    <img src="<?= '../' . $foto['foto']; ?>" class="d-block w-100">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators<?= $index; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators<?= $index; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                <?php endforeach; ?>
            </section>
            <section class="col-12 col-md-7">
                <h1 id="nama_pakaian"><?= $pakaian['nama']; ?></h1>
                <div class="d-flex gap-2 align-items-end mb-5">

                    <?php if ($pakaian['diskon']) : ?>
                        <h4><del>IDR <?= number_format($pakaian['harga_toko'], 0, ",", "."); ?></del></h4>
                        <?php if ($pakaian['diskon']['jenis_diskon'] == 1) : ?>
                            <h3 class="text-success">IDR <?= number_format($pakaian['harga_toko'] - $pakaian['diskon']['diskon'], 0, ",", "."); ?></h3>
                        <?php elseif ($pakaian['diskon']['jenis_diskon'] == 2) : ?>
                            <h3 class="text-success">IDR <?= number_format($pakaian['harga_toko'] * ($pakaian['diskon']['diskon'] / 100), 0, ",", "."); ?></h3>
                        <?php endif; ?>
                    <?php else : ?>
                        <h4>IDR <?= number_format($pakaian['harga_toko'], 0, ",", "."); ?></h4>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Warna</label>
                    <div class="btn-group-horizontal" role="group" aria-label="Vertical radio toggle button group">
                        <?php foreach ($pakaian['warna_pakaian'] as $index => $warna_pakaian) : ?>
                            <input type="radio" class="btn-check" name="warna" id="warna-<?= $warna_pakaian['id']; ?>" autocomplete="off" <?= !$index ? 'checked' : ''; ?> value="<?= $warna_pakaian['id']; ?>">
                            <label class="btn btn-outline-dark rounded-1 mb-2" for="warna-<?= $warna_pakaian['id']; ?>"><?= $warna_pakaian['warna']; ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ukuran</label>
                    <?php foreach ($pakaian['ukuran'] as $index => $ukuran) : ?>
                        <div class="btn-group-horizontal ukuran <?= !$index ? '' : 'd-none'; ?>" role="group" aria-label="Vertical radio toggle button group" data-id_warna_pakaian="<?= $ukuran['id_warna_pakaian']; ?>">
                            <?php foreach ($ukuran['ukuran'] as $ukuran_pakaian) : ?>
                                <input type="radio" class="btn-check" name="ukuran" value="<?= $ukuran_pakaian['id']; ?>" id="ukuran-<?= $index; ?>-<?= $ukuran_pakaian['id']; ?>" autocomplete="off" <?= $ukuran_pakaian['jumlah'] ? '' : 'disabled'; ?>>
                                <label class="btn btn-outline-dark rounded-1" for="ukuran-<?= $index; ?>-<?= $ukuran_pakaian['id']; ?>"><?= $ukuran_pakaian['ukuran']; ?></label>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <div class="d-flex">
                        <div id="minus" class="px-3 pb-1 pt-2 fs-5 border border-dark border-2" style="cursor: pointer;"><span style="display: block; margin-top: -2px;">-</span></div>
                        <div id="jumlah" contenteditable="" class="px-2 pb-1 pt-2 border-top border-bottom border-dark border-2 fs-5 text-center" style="width: 4rem; white-space: nowrap; overflow: hidden;">1</div>
                        <div id="plus" class="px-3 pb-1 pt-2 fs-5 border border-dark border-2" style="cursor: pointer;"><span style="display: block; margin-top: -2px;">+</span></div>
                    </div>
                </div>
                <div class="mb-3">
                    <button id="masukan-keranjang" disabled class="btn btn-dark rounded-1">MASUKAN KERANJANG</button>
                </div>
            </section>
        </div>
    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const id_pembeli = document.querySelector('input[name="id_pembeli"]');
        document.querySelectorAll('input[name=warna]').forEach((warna) => {
            warna.addEventListener('click', () => {
                document.querySelectorAll('.carousel').forEach((elm) => {
                    elm.classList.add('d-none');
                });
                document.querySelector(`.carousel[data-id_warna_pakaian="${warna.value}"]`).classList.remove('d-none');

                document.querySelectorAll('.ukuran').forEach((elm) => {
                    elm.classList.add('d-none');
                });

                document.querySelectorAll('input[name=ukuran]').forEach((ukuran) => {
                    ukuran.checked = false;
                });
                document.querySelector(`.ukuran[data-id_warna_pakaian="${warna.value}"]`).classList.remove('d-none');
                document.getElementById("masukan-keranjang").setAttribute('disabled', '');

            });
        });

        document.querySelectorAll('input[name=ukuran]').forEach((ukuran) => {
            ukuran.addEventListener('click', () => {
                document.getElementById("masukan-keranjang").removeAttribute('disabled');
            });
        });


        document.getElementById('masukan-keranjang').addEventListener('click', () => {
            if (!id_pembeli) {
                window.location.href = '../auth/logout.php';
                return;
            }

            const id_warna = document.querySelector('input[name="warna"]:checked').value;
            const id_ukuran = document.querySelector('input[name="ukuran"]:checked').value;
            const jumlah = document.getElementById("jumlah").innerText;

            tambahKeranjang(id_warna, id_ukuran, jumlah);
        });

        document.getElementById('jumlah').addEventListener("keypress", function(evt) {
            if (evt.which < 48 || evt.which > 57) {
                evt.preventDefault();
                return;
            }
        });

        document.getElementById('plus').addEventListener('click', function() {
            document.getElementById('jumlah').innerText = parseInt(document.getElementById('jumlah').innerText) + 1;
        });

        document.getElementById('minus').addEventListener('click', function() {
            if (parseInt(document.getElementById('jumlah').innerText) > 1)
                document.getElementById('jumlah').innerText = parseInt(document.getElementById('jumlah').innerText) - 1;
        });

        const tambahKeranjang = async (id_warna, id_ukuran, jumlah) => {
            let url = '../../ajax/keranjang.php?';
            url += `&id_pembeli=${id_pembeli.value}`;
            url += `&id_warna=${id_warna}`;
            url += `&id_ukuran=${id_ukuran}`;
            url += `&jumlah=${jumlah}`;
            url += `&tambah=true`;

            const response = await fetch(url)
                .then(response => response.text());

            if (response == 200) {
                document.querySelector('.toast-container')
                    .insertAdjacentHTML('beforeend', `
                        <div class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body text-white">
                                    ${document.getElementById('nama_pakaian').innerText} ditambahkan ke keranjang
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    `);

                new bootstrap.Toast(
                    document.querySelectorAll('.toast')[document.querySelectorAll('.toast').length - 1], {
                        animation: true,
                        autohide: true,
                        delay: 5000
                    }
                ).show();
                updateKeranjang();
            }
        }
    </script>
</body>

</html>