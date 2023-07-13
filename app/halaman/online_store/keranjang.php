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
    <link rel="stylesheet" href="../../assets/extensions/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="../../assets/css/shared/iconly.css">
    <style>
        @import "../../assets/css/main/fonts.css";

        body {
            font-family: 'Nunito';
        }

        .custom-loader {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: conic-gradient(#0000 10%, #F58731);
            -webkit-mask: radial-gradient(farthest-side, #0000 calc(100% - 8px), #000 0);
            animation: s3 1s infinite linear;
        }

        @keyframes s3 {
            to {
                transform: rotate(1turn)
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php $active = 'keranjang'; ?>
        <?php include_once('partials/navbar.php'); ?>

        <section class="mb-5" style="min-height: 50vh;">
            <h3 class="my-4 text-primary fw-bold">Keranjang</h3>
            <div class="row position-relative justify-content-center">
                <div id="loader"
                class="col-12 d-none d-flex justify-content-center rounded pt-5"
                style="position: absolute; z-index: 2; background-color: rgba(0, 0, 0, .3); width: 98%; height: 100%;"
                >
                    <div class="custom-loader"></div>
                </div>
                <div id="keranjang-container" class="col-12 col-md-8">
                </div>
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Sub Total</h5>
                                <h5 id="sub-total"></h5>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Voucher Diskon</h5>
                                <h5 id="voucher-diskon">Rp 0</h5>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h4>Total</h4>
                                <h4 id="total"></h4>
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
                                    <input type="text" class="form-control" placeholder="KODE VOUCER" name="kode_voucher">
                                    <button class="btn btn-outline-primary" type="button" id="terapkan">TERAPKAN</button>
                                </div>
                            </div>
                            <hr>
                            <button id="checkout" class="btn btn-primary w-100 text-white">CHEKOUT</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="../../helper/currency.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/extensions/sweetalert2/sweetalert2.min.js"></script>
    <script>
        const loader = document.getElementById('loader');
        const id_pembeli = document.querySelector('input[name=id_pembeli]').value;

        const updateJumlah = async (index) => {
            await fetch(`../../ajax/keranjang.php?id_pembeli=${id_pembeli}&id_ukuran_warna_pakaian=${document.querySelectorAll('.item')[index].getAttribute('data-id_ukuran_warna_pakaian')}&jumlah=${document.querySelectorAll('.jumlah')[index].innerText}`);
        }

        const removeItem = async (index) => {
            await fetch(`../../ajax/keranjang.php?id_pembeli=${id_pembeli}&id_ukuran_warna_pakaian=${document.querySelectorAll('.item')[index].getAttribute('data-id_ukuran_warna_pakaian')}&hapus=true`);
        }

        const getData = async () => {
            // loader.classList.remove('d-none');
            let url = `../../ajax/keranjang.php?id_pembeli=${id_pembeli}`;

            const html = await fetch(url)
                .then(response => response.text());

                console.log(html)

            document.getElementById('keranjang-container').innerHTML = html;

            let sub_total = 0;
            let voucher_diskon = 0;
            document.querySelectorAll('.item').forEach((elm, index) => {
                document.querySelectorAll('.jumlah')[index].addEventListener("keypress", function(evt) {
                    if (evt.which < 48 || evt.which > 57) {
                        evt.preventDefault();
                        return;
                    }
                });

                document.querySelectorAll('.jumlah')[index].addEventListener("focusin", function(evt) {
                    const jumlah_sekarang = this.innerText;

                    document.querySelectorAll('.jumlah')[index].addEventListener("focusout", async function(evt) {
                        if (jumlah_sekarang != this.innerText) {
                            await updateJumlah(index);
                            getData();
                        }
                    });
                });


                document.querySelectorAll('.plus')[index].addEventListener('click', async function() {
                    document.querySelectorAll('.jumlah')[index].innerText = parseInt(document.querySelectorAll('.jumlah')[index].innerText) + 1;
                    await updateJumlah(index);
                    getData();
                });

                document.querySelectorAll('.minus')[index].addEventListener('click', async function() {
                    if (parseInt(document.querySelectorAll('.jumlah')[index].innerText) > 1) {
                        document.querySelectorAll('.jumlah')[index].innerText = parseInt(document.querySelectorAll('.jumlah')[index].innerText) - 1;
                        await updateJumlah(index);
                    } else {
                        await removeItem(index);
                    }
                    getData();
                });

                sub_total = parseInt(document.querySelectorAll('.jumlah')[index].innerText) * parseInt(document.querySelectorAll('.harga')[index].getAttribute('data-harga_toko'))
            });

            if (document.getElementById('voucher-diskon').getAttribute('data-diskon')) {
                if (document.getElementById('voucher-diskon').getAttribute('data-jenis_diskon') == 1) {
                    voucher_diskon = parseInt(document.getElementById('voucher-diskon').getAttribute('data-diskon'))
                }

                if (document.getElementById('voucher-diskon').getAttribute('data-jenis_diskon') == 2) {
                    voucher_diskon = parseInt(sub_total) * (parseInt(document.getElementById('voucher-diskon').getAttribute('data-diskon')) / 100)
                }
                document.getElementById('voucher-diskon').innerText = formatter.format(voucher_diskon);
            }

            document.getElementById('sub-total').innerText = formatter.format(sub_total);
            document.getElementById('sub-total').setAttribute('data-total', sub_total);
            document.getElementById('total').innerText = formatter.format(sub_total - voucher_diskon);
            document.getElementById('total').setAttribute('data-total', sub_total - voucher_diskon);
            loader.classList.add('d-none');
        }

        document.getElementById('terapkan').addEventListener('click', async () => {
            const kode_voucher = document.querySelector('input[name=kode_voucher]').value;
            const response = await fetch(`../../ajax/voucher_diskon.php?kode_voucher=${kode_voucher}`)
                .then(response => response.json());
            if (response) {
                console.log(response)
                document.getElementById('voucher-diskon').setAttribute('data-id', response.id);
                document.getElementById('voucher-diskon').setAttribute('data-diskon', response.diskon);
                document.getElementById('voucher-diskon').setAttribute('data-jenis_diskon', response.jenis_diskon);
                getData();
            } else {
                Swal.fire({
                    title: 'Kode Voucher Tidak Valid',
                    icon: 'danger',
                    showCancelButton: true,
                    showConfirmButton: false,
                    cancelButtonText: 'Tutup'
                });
            }
        });

        getData();
    </script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-EmTzU8jLumgsYI05"></script>
    <script>
        document.getElementById("checkout").addEventListener('click', async () => {
            document.getElementById("checkout").setAttribute('disabled', '');
            const data = {
                penjualan_online: {
                    harga_total: document.getElementById('sub-total').getAttribute('data-total'),
                    harga_penjualan: document.getElementById('total').getAttribute('data-total'),
                    voucher_diskon: document.getElementById('voucher-diskon').getAttribute('data-id'),
                },
                pakaian: [],
            };

            document.querySelectorAll('.item').forEach((item, index) => {
                data.pakaian.push({
                    id_ukuran_warna_pakaian: document.querySelectorAll('.item')[index].getAttribute('data-id_ukuran_warna_pakaian'),
                    diskon: document.querySelectorAll('.harga')[index].getAttribute('data-id_diskon'),
                    jumlah: document.querySelectorAll('.jumlah')[index].innerText,
                    harga_toko: document.querySelectorAll('.harga')[index].getAttribute('data-harga_toko'),
                    harga_penjualan: document.querySelectorAll('.harga')[index].getAttribute('data-harga_penjualan'),
                });
            });


            const midtrans = await fetch(`../../ajax/midtrans.php?id_pembeli=${id_pembeli}`, {
                method: "POST",
                body: JSON.stringify(data),
            }).then(response => response.json());

            window.snap.pay(midtrans['snap_token'], {
                onSuccess: function(result) {
                    location.href = 'profil.php?halaman=riwayat_pembelian&status=3&id=' + midtrans['id'];
                    console.log(result);
                },
                onPending: function(result) {
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    location.href = 'profil.php?halaman=riwayat_pembelian'
                    // alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
</body>

</html>