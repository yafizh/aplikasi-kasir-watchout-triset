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

        #carouselExampleCaptions img {
            width: 100%;
            object-fit: cover;
            height: 28rem;
            border-radius: .4rem;
        }
    </style>
    <div class="container">
        <?php include_once('partials/navbar.php'); ?>

        <div id="carouselExampleCaptions" class="carousel slide mb-5" data-bs-ride="false">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1591085686350-798c0f9faa7f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1031&q=80" class="d-block w-100">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1528698827591-e19ccd7bc23d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=876&q=80" class="d-block w-100">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" class="d-block w-100">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <section class="mb-5">
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
            <div class="d-flex justify-content-between">
                <h3 class="text-header mb-3">Sale</h3>
                <a href="sale.php">Lihat Selengkapnya...</a>
            </div>
            <div class="row pb-3">
                <div class="col-6 col-md-4 col-lg-2 item rounded">
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
                <div class="col-6 col-md-4 col-lg-2 item rounded">
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
                <div class="col-6 col-md-4 col-lg-2 item rounded">
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
                <div class="col-6 col-md-4 col-lg-2 item rounded">
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
                <div class="col-6 col-md-4 col-lg-2 item rounded">
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
                <div class="col-6 col-md-4 col-lg-2 item rounded">
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
        </section>

        <section class="mb-5">
            <h3 class="text-header mb-3">Our Brands</h3>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <img src="../../assets/images/watcout.webp" style="width: 100%; height: 12rem; object-fit: cover; border-radius: .4rem;">
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <img src="../../assets/images/TR.png" style="width: 100%; height: 12rem; object-fit: cover; border-radius: .4rem;">
                </div>
            </div>
        </section>

        <section class="mb-5">
            <h3 class="text-header mb-3">FAQ</h3>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            bagaimana cara melihat pesanan yang pernah saya lakukan?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            bagaimana cara mengubah informasi pada akun saya?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            bagaimana cara mengkonfirmasi pembayaran saya?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            siapa yang dapat saya hubungi ketika memerlukan bantuan?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <h3 class="text-header mb-3">Contact Us</h3>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <form action="">
                        <form>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea name="pesan" id="pesan" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary text-white w-100">KIRIM PESAN</button>
                        </form>
                    </form>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10035.58127342353!2d114.84744522367716!3d-3.441302828120041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de6810683a0fa17%3A0xe5f6d68e79b948b!2sQ%20Mall!5e0!3m2!1sen!2sid!4v1679814042079!5m2!1sen!2sid" class="w-100" style="border:0; height: 25.2rem;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
    </div>
    <?php include_once('partials/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>