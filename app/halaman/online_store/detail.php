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
    </style>
    <div class="container mb-5">
        <?php include_once('partials/navbar.php'); ?>

        <div class="row justify-content-between">
            <section class="col-12 col-md-4">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                    <div class="carousel-indicators">
                        <img style="height: 4rem; width: 4rem; object-fit:cover;" src="../../../dummy/ELAINA-PANTS-ABU-ABU.jpg" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1">
                        <img style="height: 4rem; width: 4rem; object-fit:cover;" src="../../../dummy/AINE-BLOUSE-HIJAU.jpg" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 1" class="">
                        <img style="height: 4rem; width: 4rem; object-fit:cover;" src="../../../dummy/AINE-BLOUSE-MAROON.jpg" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 1" class="">
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../../../dummy/AINE-BLOUSE-HIJAU.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="../../../dummy/ELAINA-PANTS-ABU-ABU.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="../../../dummy/AINE-BLOUSE-MAROON.jpg" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- <img src="../../../dummy/ELAINA-PANTS-ABU-ABU.jpg" class="rounded w-100">
                <div class="images pt-3">
                    <img src="../../../dummy/ELAINA-PANTS-ABU-ABU.jpg" class="rounded border border-2 border-dark">
                </div> -->
            </section>
            <section class="col-12 col-md-7">
                <h1>ELAINA PANTS ABU ABU</h1>
                <div class="d-flex gap-2 align-items-end mb-5">
                    <h4><del>IDR 500.000</del></h4>
                    <h3 class="text-success">IDR 500.000</h3>
                </div>
                <div class="mb-3">
                    <label class="form-label">Warna</label>
                    <div class="btn-group-horizontal" role="group" aria-label="Vertical radio toggle button group">
                        <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio1" autocomplete="off" checked>
                        <label class="btn btn-outline-dark rounded-1" for="vbtn-radio1">Merah</label>
                        <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio2" autocomplete="off">
                        <label class="btn btn-outline-dark rounded-1" for="vbtn-radio2">Biru</label>
                        <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio3" autocomplete="off">
                        <label class="btn btn-outline-dark rounded-1" for="vbtn-radio3">Hijau</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ukuran</label>
                    <div class="btn-group-horizontal" role="group" aria-label="Vertical radio toggle button group">
                        <input type="radio" class="btn-check" name="vbtn-radio2" id="vbtn-radio4" autocomplete="off" checked>
                        <label class="btn btn-outline-dark rounded-1" for="vbtn-radio4">S</label>
                        <input type="radio" class="btn-check" name="vbtn-radio2" id="vbtn-radio5" autocomplete="off">
                        <label class="btn btn-outline-dark rounded-1" for="vbtn-radio5">M</label>
                        <input type="radio" class="btn-check" name="vbtn-radio2" id="vbtn-radio6" autocomplete="off">
                        <label class="btn btn-outline-dark rounded-1" for="vbtn-radio6">L</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ukuran</label>
                    <div class="d-flex">
                        <div class="px-3 py-1 fs-5 border border-dark border-2"><span style="display: block; margin-top: -2px;">-</span></div>
                        <div class="px-2 py-1 border-top border-bottom border-dark border-2 fs-5 text-center" style="width: 3rem; white-space: nowrap;">12</div>
                        <div class="px-3 py-1 fs-5 border border-dark border-2"><span style="display: block; margin-top: -2px;">+</span></div>
                    </div>
                </div>
                <div class="mb-3 mt-5">
                    <button class="btn btn-dark rounded-1">MASUKAN KERANJANG</button>
                </div>
            </section>
        </div>

    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>