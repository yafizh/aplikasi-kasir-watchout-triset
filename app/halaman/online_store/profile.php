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
        <?php include_once('partials/navbar.php'); ?>

        <section class="d-flex justify-content-center mb-5" style="min-height: 50vh;">
            <div class="w-100 d-flex align-items-center flex-column">
                <div style="width: fit-content;">
                    <ul class="nav justify-content-center nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Riwayat Pembelian</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Ganti Password</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content w-100" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <form action="">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="email" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nomor Telepon</label>
                                <input type="email" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Tempat Lahir</label>
                                <input type="email" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Tanggal Lahir</label>
                                <input type="email" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button class="btn btn-primary text-white">Perbaharui Profile</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <div class="d-flex align-items-start">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link text-start active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Menunggu Pembayaran</button>
                                <button class="nav-link text-start" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Pesanan Diantar</button>
                                <button class="nav-link text-start" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Pembelian Selesai</button>
                            </div>
                            <div class="tab-content w-100" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                                    <div class="d-flex flex-column">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex mb-3">
                                                    <div class="flex-grow-1 d-flex">
                                                        <div style="width: 8rem; height: 8rem;">
                                                            <img src="../../../dummy/ELAINA-PANTS-HITAM.jpg" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                                        </div>
                                                        <div class="p-3">
                                                            <h5>Celana Panjang</h5>
                                                            <h5>x2</h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end flex-column justify-content-center">
                                                        <h5>Rp 50.000</h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex mb-3">
                                                    <div class="flex-grow-1 d-flex">
                                                        <div style="width: 8rem; height: 8rem;">
                                                            <img src="../../../dummy/ELAINA-PANTS-HITAM.jpg" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                                        </div>
                                                        <div class="p-3">
                                                            <h5>Celana Panjang</h5>
                                                            <h5>x2</h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end flex-column justify-content-center">
                                                        <p class="mb-0"><del>Rp 50.000</del></p>
                                                        <h5>Rp 50.000</h5>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div>
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
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button class="btn btn-danger">Batalkan Pesanan</button>
                                                    <button class="btn btn-primary text-white">Lakukan Pembayaran</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                                    <div class="d-flex flex-column">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex mb-3">
                                                    <div class="flex-grow-1 d-flex">
                                                        <div style="width: 8rem; height: 8rem;">
                                                            <img src="../../../dummy/ELAINA-PANTS-HITAM.jpg" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                                        </div>
                                                        <div class="p-3">
                                                            <h5>Celana Panjang</h5>
                                                            <h5>x2</h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end flex-column justify-content-center">
                                                        <h5>Rp 50.000</h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex mb-3">
                                                    <div class="flex-grow-1 d-flex">
                                                        <div style="width: 8rem; height: 8rem;">
                                                            <img src="../../../dummy/ELAINA-PANTS-HITAM.jpg" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                                        </div>
                                                        <div class="p-3">
                                                            <h5>Celana Panjang</h5>
                                                            <h5>x2</h5>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end flex-column justify-content-center">
                                                        <p class="mb-0"><del>Rp 50.000</del></p>
                                                        <h5>Rp 50.000</h5>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">...</div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                        <form action="">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Password Lama</label>
                                <input type="email" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Pasasword Baru</label>
                                <input type="email" class="form-control" id="nama" name="nama">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Konfirmasi Password Baru</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <button class="btn btn-primary text-white">Perbaharui Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>