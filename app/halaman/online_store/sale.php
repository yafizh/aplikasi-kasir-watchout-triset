<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../../database/koneksi.php');

// Helper 
require_once('../../helper/date.php');
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
    <style>
        @import "../../assets/css/main/fonts.css";

        body {
            font-family: 'Nunito';
        }

        .text-header {
            font-weight: 700;
        }

        .accordion-button:not(.collapsed) {
            background-color: #ffffff;
            color: black;
        }

        .accordion {
            --bs-accordion-border-width: 0 !important;
        }

        .accordion-heading a:not(.collapsed) {
            border-bottom: 1px solid red !important;
        }

        .accordion-item {
            border: 0 !important;
            padding: .6rem 0;
        }

        .accordion-body {
            padding: 0;
        }

        .accordion-button {
            padding-top: 0;
            padding-bottom: .4rem;
        }

        .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .accordion-body ul li {
            padding: .2rem;
        }

        ul {
            list-style: none;
        }
    </style>
    <div class="container">
        <?php $active = 'sale'; ?>
        <?php include_once('partials/navbar.php'); ?>

        <section class="row mb-5" style="min-height: 80vh;">
            <div class="col-12">
                <h1 class="text-center fw-bold text-primary">Sedang Diskon</h1>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <?php $merk = $mysqli->query("SELECT * FROM merk"); ?>
                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                                        Merk Pakaian
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="accordion-body">
                                        <ul>
                                            <?php while ($row = $merk->fetch_assoc()) : ?>
                                                <li>
                                                    <input type="checkbox" class="form-check-input" name="merk" id="merk-<?= $row['id']; ?>" value="<?= $row['id']; ?>">
                                                    <label class="form-check-label" for="merk-<?= $row['id']; ?>"><?= $row['nama']; ?></label>
                                                </li>
                                            <?php endwhile; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <?php $kategori_pakaian = $mysqli->query("SELECT * FROM kategori_pakaian"); ?>
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        Kategori Pakaian
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <ul>
                                            <?php while ($row = $kategori_pakaian->fetch_assoc()) : ?>
                                                <li>
                                                    <input type="checkbox" class="form-check-input" name="kategori_pakaian" id="kategori-pakaian-<?= $row['id']; ?>" value="<?= $row['id']; ?>">
                                                    <label class="form-check-label" for="kategori-pakaian-<?= $row['id']; ?>"><?= $row['nama']; ?></label>
                                                </li>
                                            <?php endwhile; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <?php $warna = $mysqli->query("SELECT DISTINCT warna FROM warna_pakaian"); ?>
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        Warna Pakaian
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">
                                        <ul>
                                            <?php while ($row = $warna->fetch_assoc()) : ?>
                                                <li>
                                                    <input type="checkbox" class="form-check-input" name="warna" id="warna-<?= $row['warna']; ?>" value="<?= $row['warna']; ?>">
                                                    <label class="form-check-label" for="warna-<?= $row['warna']; ?>"><?= $row['warna']; ?></label>
                                                </li>
                                            <?php endwhile; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .item {
                    cursor: pointer;
                }

                .item:hover img {
                    transform: scale(1.5);
                }

                .item img {
                    width: 100%;
                    object-fit: cover;
                    height: 16rem;
                    transition: 0.5s all ease-in-out;
                }
            </style>
            <div class="col-12 col-md-9 mb-3">
                <div class="row" id="sale-container">
                </div>
            </div>
        </section>

    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        const id_kategori_pakaian = [];
        const nama_warna = [];
        const id_merk = [];
        document.querySelectorAll('input[name=kategori_pakaian]').forEach((kategori_pakaian) => {
            kategori_pakaian.addEventListener('click', () => {
                if (id_kategori_pakaian.includes(kategori_pakaian.value)) {
                    if (id_kategori_pakaian.indexOf(kategori_pakaian.value) !== -1)
                        id_kategori_pakaian.splice(id_kategori_pakaian.indexOf(kategori_pakaian.value), 1);
                } else
                    id_kategori_pakaian.push(kategori_pakaian.value);

                getData();
            })
        });

        document.querySelectorAll('input[name=warna]').forEach((warna) => {
            warna.addEventListener('click', () => {
                if (nama_warna.includes(warna.value)) {
                    if (nama_warna.indexOf(warna.value) !== -1)
                        nama_warna.splice(nama_warna.indexOf(warna.value), 1);
                } else
                    nama_warna.push(warna.value);

                getData();
            })
        });

        document.querySelectorAll('input[name=merk]').forEach((merk) => {
            merk.addEventListener('click', () => {
                if (id_merk.includes(merk.value)) {
                    if (id_merk.indexOf(merk.value) !== -1)
                        id_merk.splice(id_merk.indexOf(merk.value), 1);
                } else
                    id_merk.push(merk.value);

                getData();
            })
        });

        const getData = async () => {
            let url = '../../ajax/sale.php?';
            if (id_kategori_pakaian.length)
                url += `&id_kategori_pakaian=${id_kategori_pakaian.toString()}`;

            if (nama_warna.length)
                url += `&warna=${nama_warna.toString()}`;

            if (id_merk.length)
                url += `&id_merk=${id_merk.toString()}`;
            // console.log(url)
            const html = await fetch(url)
                .then(response => response.text());

            document.getElementById('sale-container').innerHTML = html;

            document.querySelectorAll('.item').forEach((elm) => {
                elm.addEventListener('click', () => {
                    location.href = `detail.php?from=sale&id_pakaian=${elm.getAttribute('data-id_pakaian')}`;
                })
            });
        }

        getData();
    </script>
</body>

</html>