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

        <section style="min-height: 50vh;">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card mb-3" style="width: 100%; height: 10rem;">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1 d-flex">
                                    <div style="width: 8rem; height: 8rem;">
                                        <img src="../../../dummy/ELAINA-PANTS-HITAM.jpg" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                    </div>
                                    <div class="p-3">
                                        <h5 class="mb-3">Celana Panjang</h5>
                                        <div class="d-flex">
                                            <div class="px-2 py-1 border fs-5"><span style="display: block; margin-top: -2px;">-</span></div>
                                            <div class="px-2 py-1 border fs-5 text-center" style="width: 3rem; white-space: nowrap;">112</div>
                                            <div class="px-2 py-1 border fs-5"><span style="display: block; margin-top: -2px;">+</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end flex-column justify-content-center">
                                    <h5>Rp 50.000</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3" style="width: 100%; height: 10rem;">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1 d-flex">
                                    <div style="width: 8rem; height: 8rem;">
                                        <img src="../../../dummy/ELAINA-PANTS-HITAM.jpg" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                    </div>
                                    <div class="p-3">
                                        <h5 class="mb-3">Celana Panjang</h5>
                                        <div class="d-flex">
                                            <div class="px-2 py-1 border fs-5"><span style="display: block; margin-top: -2px;">-</span></div>
                                            <div class="px-2 py-1 border fs-5 text-center" style="width: 3rem; white-space: nowrap;">112</div>
                                            <div class="px-2 py-1 border fs-5"><span style="display: block; margin-top: -2px;">+</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end flex-column justify-content-center">
                                    <p class="mb-0"><del>Rp 50.000</del></p>
                                    <h5>Rp 50.000</h5>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <div class="mb-3 d-flex align-items-start gap-3">
                                <div class="flex-grow-1">
                                    <label for="" class="mb-2">Kode Voucher</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="d-flex flex-column">
                                    <label for="" class="mb-2" style="visibility: hidden;">Button</label>
                                    <button class="btn btn-primary text-white">TERAPKAN</button>
                                </div>
                            </div>
                            <hr>
                            <button class="btn btn-primary w-100 text-white">CHEKOUT</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>