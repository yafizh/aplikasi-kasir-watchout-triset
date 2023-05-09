<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

// Database
require_once('../../database/koneksi.php');

// Helper 
require_once('../../helper/date.php');

if (!isset($_SESSION['user']['pembeli'])) {
    header('Location: ../index.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Watchout Triset</title>
    <link href="../../assets/css/main/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/shared/iconly.css">
    <style>
        @import "../../assets/css/main/fonts.css";

        body {
            font-family: 'Nunito';
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $active = 'keranjang'; ?>
        <?php include_once('partials/navbar.php'); ?>

        <section style="min-height: 50vh;">
            <h3 class="my-4 text-primary fw-bold">Keranjang</h3>
            <div class="row">
                <div id="keranjang-container" class="col-12 col-md-8">

                </div>
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Sub Total</h5>
                                <h5>Rp 100.000</h5>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Voucher Diskon</h5>
                                <h5>Rp 0</h5>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h4>Total</h4>
                                <h4>Rp 100.000</h4>
                            </div>
                            <hr>
                            <style>
                                #terapkan:hover {
                                    color: white;
                                }
                            </style>
                            <div class="mb-3">
                                <label for="" class="mb-2">Kode Voucher</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="KODE VOUCER" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-primary" type="button" id="terapkan">TERAPKAN</button>
                                </div>
                            </div>
                            <hr>
                            <button id="chekout" class="btn btn-primary w-100 text-white">CHEKOUT</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const id_pembeli = document.querySelector('input[name=id_pembeli]').value;

        const updateJumlah = (index) => {
            fetch(`../../ajax/keranjang.php?id_pembeli=${id_pembeli}&id_ukuran_warna_pakaian=${document.querySelectorAll('.item')[index].getAttribute('data-id_ukuran_warna_pakaian')}&jumlah=${document.querySelectorAll('.jumlah')[index].innerText}`)
                .then(response => response.text())
                .then(text => console.log(text))
        }

        const removeItem = (index) => {
            fetch(`../../ajax/keranjang.php?id_pembeli=${id_pembeli}&id_ukuran_warna_pakaian=${document.querySelectorAll('.item')[index].getAttribute('data-id_ukuran_warna_pakaian')}&hapus=true`)
                .then(response => response.text())
                .then(text => console.log(text))
        }

        const getData = async () => {
            let url = `../../ajax/keranjang.php?id_pembeli=${id_pembeli}`;

            const html = await fetch(url)
                .then(response => response.text());

            document.getElementById('keranjang-container').innerHTML = html;

            document.querySelectorAll('.item').forEach((elm, index) => {
                document.querySelectorAll('.jumlah')[index].addEventListener("keypress", function(evt) {
                    if (evt.which < 48 || evt.which > 57) {
                        evt.preventDefault();
                        return;
                    }
                });

                document.querySelectorAll('.jumlah')[index].addEventListener("focusin", function(evt) {
                    const jumlah_sekarang = this.innerText;

                    document.querySelectorAll('.jumlah')[index].addEventListener("focusout", function(evt) {
                        if (jumlah_sekarang != this.innerText) {
                            updateJumlah(index);
                        }
                    });
                });



                document.querySelectorAll('.plus')[index].addEventListener('click', function() {
                    document.querySelectorAll('.jumlah')[index].innerText = parseInt(document.querySelectorAll('.jumlah')[index].innerText) + 1;
                    updateJumlah(index);
                });

                document.querySelectorAll('.minus')[index].addEventListener('click', function() {
                    if (parseInt(document.querySelectorAll('.jumlah')[index].innerText) > 1) {
                        document.querySelectorAll('.jumlah')[index].innerText = parseInt(document.querySelectorAll('.jumlah')[index].innerText) - 1;
                        updateJumlah(index);
                    } else {
                        removeItem(index);
                        getData();
                    }
                });
            });
        }

        getData();
    </script>
</body>

</html>