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
        <?php include_once('partials/navbar.php'); ?>

        <section class="row mb-5">
            <div class="col-12 col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                        Jenis Pakaian
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <ul>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">Baju</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                                <label class="form-check-label" for="exampleCheck2">Celana</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck3">
                                                <label class="form-check-label" for="exampleCheck3">Sepatu</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck4">
                                                <label class="form-check-label" for="exampleCheck4">Sendal</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck5">
                                                <label class="form-check-label" for="exampleCheck5">Kemeja</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        Warna Pakaian
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">
                                        <ul>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck9">
                                                <label class="form-check-label" for="exampleCheck9">Merah</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck8">
                                                <label class="form-check-label" for="exampleCheck8">Biru</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck7">
                                                <label class="form-check-label" for="exampleCheck7">Hijau</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        Merk Pakaian
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="accordion-body">
                                        <ul>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck9">
                                                <label class="form-check-label" for="exampleCheck91">Watchout</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" class="form-check-input" id="exampleCheck8">
                                                <label class="form-check-label" for="exampleCheck81">Triset</label>
                                            </li>
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
                <div class="row">
                    <div class="col-6 col-md-4 col-lg-3 item rounded">
                        <div class="position-relative" style="overflow: hidden;">
                            <!-- <div class="position-absolute pt-3" style="z-index: 999;">
                                <h6 class="bg-danger py-2 px-3 mb-0 text-white" style="border-bottom-right-radius: .3rem; border-top-right-radius: .3rem;">Sale</h6>
                            </div> -->
                            <img src="../../../dummy/AINE-BLOUSE-HIJAU.jpg" class="rounded">
                        </div>
                        <div class="body px-2 pt-3 pb-1">
                            <h5>AINE BLOUSE</h5>
                            <p class="text-muted">IDR 300.000</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3 item rounded">
                        <div class="position-relative" style="overflow: hidden;">
                            <div class="position-absolute pt-3" style="z-index: 999;">
                                <h6 class="bg-danger py-2 px-3 mb-0 text-white" style="border-bottom-right-radius: .3rem; border-top-right-radius: .3rem;">Sale</h6>
                            </div>
                            <img src="../../../dummy/AINE-BLOUSE-HIJAU.jpg" class="rounded">
                        </div>
                        <div class="body px-2 pt-3 pb-1">
                            <h5>AINE BLOUSE</h5>
                            <p class="text-muted mb-0"><del>IDR 300.000</del></p>
                            <h5 class="text-success">IDR 250.000</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        document.querySelectorAll('.item').forEach((elm) => {
            elm.addEventListener('click', () => {
                location.href = 'detail.php';
            })
        });
    </script>
</body>

</html>