<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <?php
    $merk = $mysqli->query("SELECT * FROM merk")->fetch_all(MYSQLI_ASSOC);
    foreach ($merk as $key_merk => $value_merk) {
        $jenis_pakaian = $mysqli->query("SELECT * FROM jenis_pakaian")->fetch_all(MYSQLI_ASSOC);
        foreach ($jenis_pakaian as $key_jenis_pakaian => $value_jenis_pakaian) {
            $query = "
                    SELECT 
                        * 
                    FROM 
                        pakaian 
                    WHERE 
                        id_jenis_pakaian=" . $value_jenis_pakaian['id'] . " 
                        AND 
                        id_merk=" . $value_merk['id'] . " 
                        AND 
                        nama LIKE '%" . ($_POST['keyword'] ?? '') . "%'
                ";
            $pakaian = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
            foreach ($pakaian as $key_pakaian => $value_pakaian) {
                $query = "
                        SELECT 
                            warna_pakaian.*, 
                            warna.nama 
                        FROM 
                            warna_pakaian 
                        INNER JOIN 
                            warna 
                        ON 
                            warna.id=warna_pakaian.id_warna 
                        WHERE 
                            warna_pakaian.id_pakaian=" . $value_pakaian['id'];
                $warna_pakaian = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
                foreach ($warna_pakaian as $key_warna_pakaian => $value_warna_pakaian) {
                    $query = "
                            SELECT 
                                ukuran.nama,
                                ukuran_warna_pakaian.*,
                                IFNULL(SUM(pakaian_disuplai.jumlah), 0) AS jumlah 
                            FROM 
                                ukuran_warna_pakaian 
                            LEFT JOIN 
                                pakaian_disuplai 
                            ON 
                                pakaian_disuplai.id_ukuran_warna_pakaian=ukuran_warna_pakaian.id 
                            INNER JOIN 
                                ukuran 
                            ON 
                                ukuran.id=ukuran_warna_pakaian.id_ukuran  
                            WHERE 
                                ukuran_warna_pakaian.id_warna_pakaian=" . $value_warna_pakaian['id'] . "
                            GROUP BY 
                                ukuran_warna_pakaian.id
                        ";
                    $warna_pakaian[$key_warna_pakaian]['ukuran'] = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
                }
                $pakaian[$key_pakaian]['warna_pakaian'] = $warna_pakaian;
            }
            $jenis_pakaian[$key_jenis_pakaian]['pakaian'] = $pakaian;
        }
        $merk[$key_merk]['jenis_pakaian'] = $jenis_pakaian;
    }
    ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Kasir</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
                                <?php foreach ($merk as $key => $value) : ?>
                                    <?php if (!$key) : ?>
                                        <a class="list-group-item list-group-item-action active" id="list-<?= $value['id']; ?>-list" data-bs-toggle="list" href="#list-<?= $value['id']; ?>" role="tab"><?= $value['nama']; ?></a>
                                    <?php else : ?>
                                        <a class="list-group-item list-group-item-action" id="list-<?= $value['id']; ?>-list" data-bs-toggle="list" href="#list-<?= $value['id']; ?>" role="tab"><?= $value['nama']; ?></a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="tab-content text-justify">
                                <?php foreach ($merk as $key => $value) : ?>
                                    <?php if (!$key) : ?>
                                        <div class="tab-pane fade show active" id="list-<?= $value['id']; ?>" role="tabpanel" aria-labelledby="list-<?= $value['id']; ?>-list">
                                            <div class="row py-3">
                                                <div class="col-12 col-sm-12 col-md-2">
                                                    <div class="list-group" role="tablist">
                                                        <?php foreach ($value['jenis_pakaian'] as $key_jenis_pakaian => $value_jenis_pakaian) : ?>
                                                            <?php if (!$key_jenis_pakaian) : ?>
                                                                <a class="list-group-item list-group-item-action active" id="list-jenis_pakaian-<?= $value_jenis_pakaian['id']; ?>-list" data-bs-toggle="list" href="#list-jenis_pakaian-<?= $value_jenis_pakaian['id']; ?>" role="tab"><?= $value_jenis_pakaian['nama']; ?></a>
                                                            <?php else : ?>
                                                                <a class="list-group-item list-group-item-action" id="list-jenis_pakaian-<?= $value_jenis_pakaian['id']; ?>-list" data-bs-toggle="list" href="#list-jenis_pakaian-<?= $value_jenis_pakaian['id']; ?>" role="tab"><?= $value_jenis_pakaian['nama']; ?></a>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-10 mt-1">
                                                    <div class="tab-content text-justify" id="nav-tabContent">
                                                        <?php foreach ($value['jenis_pakaian'] as $key_jenis_pakaian => $value_jenis_pakaian) : ?>
                                                            <?php if (!$key_jenis_pakaian) : ?>
                                                                <div class="tab-pane show active" id="list-jenis_pakaian-<?= $value_jenis_pakaian['id']; ?>" role="tabpanel" aria-labelledby="list-jenis_pakaian-<?= $value_jenis_pakaian['id']; ?>-list">
                                                                    <div class="d-flex gap-3 text-center">
                                                                        <?php foreach ($value_jenis_pakaian['pakaian'] as $key_value_pakaian =>  $value_pakaian) : ?>
                                                                            <div class="card border" style="width: 12rem;">
                                                                                <div class="card-image" style="height: 12rem;">
                                                                                    <?php if (count($value_pakaian['warna_pakaian'])) : ?>
                                                                                        <div class="carousel slide h-100" data-bs-ride="carousel">
                                                                                            <div class="carousel-inner h-100 rounded">
                                                                                                <?php foreach ($value_pakaian['warna_pakaian'] as $index => $value_warna_pakaian) : ?>
                                                                                                    <?php if (!$index) : ?>
                                                                                                        <div class="carousel-item h-100 active">
                                                                                                            <img src="<?= $value_warna_pakaian['foto']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                        </div>
                                                                                                    <?php else : ?>
                                                                                                        <div class="carousel-item h-100">
                                                                                                            <img src="<?= $value_warna_pakaian['foto']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                        </div>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php else : ?>
                                                                                        <div class="w-100 h-100 rounded d-flex justify-content-center align-items-center p-3" style="background-color: #CCCCCC;">
                                                                                            <h6 class="text-white">Gambar Tidak Tersedia</h6>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                                <div class="card-body px-3 py-0 text-center">
                                                                                    <div style="height: 3.5rem;" class="mt-2 d-flex align-items-center justify-content-center">
                                                                                        <h5><?= $value_pakaian['nama']; ?></h5>
                                                                                    </div>
                                                                                    <button class="btn btn-primary text-white btn-sm w-100 mb-3" data-bs-toggle="modal" data-bs-target="#border-less">Masukkan Keranjang</button>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                            <?php else : ?>
                                                                <div class="tab-pane" id="list-jenis_pakaian-<?= $value_jenis_pakaian['id']; ?>" role="tabpanel" aria-labelledby="list-jenis_pakaian-<?= $value_jenis_pakaian['id']; ?>-list">
                                                                    <div class="d-flex gap-3 text-center">
                                                                        <?php foreach ($value_jenis_pakaian['pakaian'] as $key_value_pakaian =>  $value_pakaian) : ?>
                                                                            <div class="card border" style="width: 12rem;">
                                                                                <div class="card-image" style="height: 12rem;">
                                                                                    <?php if (count($value_pakaian['warna_pakaian'])) : ?>
                                                                                        <div class="carousel slide h-100" data-bs-ride="carousel">
                                                                                            <div class="carousel-inner h-100 rounded">
                                                                                                <?php foreach ($value_pakaian['warna_pakaian'] as $index => $value_warna_pakaian) : ?>
                                                                                                    <?php if (!$index) : ?>
                                                                                                        <div class="carousel-item h-100 active">
                                                                                                            <img src="<?= $value_warna_pakaian['foto']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                        </div>
                                                                                                    <?php else : ?>
                                                                                                        <div class="carousel-item h-100">
                                                                                                            <img src="<?= $value_warna_pakaian['foto']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                        </div>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php else : ?>
                                                                                        <div class="w-100 h-100 rounded d-flex justify-content-center align-items-center p-3" style="background-color: #CCCCCC;">
                                                                                            <h6 class="text-white">Gambar Tidak Tersedia</h6>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                                <div class="card-body px-3 py-0 text-center">
                                                                                    <div style="height: 3.5rem;" class="mt-2 d-flex align-items-center justify-content-center">
                                                                                        <h5><?= $value_pakaian['nama']; ?></h5>
                                                                                    </div>
                                                                                    <button class="btn btn-primary text-white btn-sm w-100 mb-3" data-bs-toggle="modal" data-bs-target="#border-less">Masukkan Keranjang</button>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="tab-pane fade" id="list-<?= $value['id']; ?>" role="tabpanel" aria-labelledby="list-<?= $value['id']; ?>-list">
                                            <div class="row py-3">
                                                <div class="col-12 col-sm-12 col-md-2">
                                                    <div class="list-group" role="tablist">
                                                        <?php foreach ($value['jenis_pakaian'] as $key_jenis_pakaian => $value_jenis_pakaian) : ?>
                                                            <?php if (!$key_jenis_pakaian) : ?>
                                                                <a class="list-group-item list-group-item-action active" id="list-jenis_pakaian_merk_<?= $value['id']; ?>-<?= $value_jenis_pakaian['id']; ?>-list" data-bs-toggle="list" href="#list-jenis_pakaian_merk_<?= $value['id']; ?>-<?= $value_jenis_pakaian['id']; ?>" role="tab"><?= $value_jenis_pakaian['nama']; ?></a>
                                                            <?php else : ?>
                                                                <a class="list-group-item list-group-item-action" id="list-jenis_pakaian_merk_<?= $value['id']; ?>-<?= $value_jenis_pakaian['id']; ?>-list" data-bs-toggle="list" href="#list-jenis_pakaian_merk_<?= $value['id']; ?>-<?= $value_jenis_pakaian['id']; ?>" role="tab"><?= $value_jenis_pakaian['nama']; ?></a>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-10 mt-1">
                                                    <div class="tab-content text-justify" id="nav-tabContent">
                                                        <?php foreach ($value['jenis_pakaian'] as $key_jenis_pakaian => $value_jenis_pakaian) : ?>
                                                            <?php if (!$key_jenis_pakaian) : ?>
                                                                <div class="tab-pane show active" id="list-jenis_pakaian_merk_<?= $value['id']; ?>-<?= $value_jenis_pakaian['id']; ?>" role="tabpanel" aria-labelledby="list-jenis_pakaian_merk_<?= $value['id']; ?>-<?= $value_jenis_pakaian['id']; ?>-list">
                                                                    <div class="d-flex gap-3 text-center">
                                                                        <?php foreach ($value_jenis_pakaian['pakaian'] as $key_value_pakaian =>  $value_pakaian) : ?>
                                                                            <div class="card border" style="width: 12rem;">
                                                                                <div class="card-image" style="height: 12rem;">
                                                                                    <?php if (count($value_pakaian['warna_pakaian'])) : ?>
                                                                                        <div class="carousel slide h-100" data-bs-ride="carousel">
                                                                                            <div class="carousel-inner h-100 rounded">
                                                                                                <?php foreach ($value_pakaian['warna_pakaian'] as $index => $value_warna_pakaian) : ?>
                                                                                                    <?php if (!$index) : ?>
                                                                                                        <div class="carousel-item h-100 active">
                                                                                                            <img src="<?= $value_warna_pakaian['foto']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                        </div>
                                                                                                    <?php else : ?>
                                                                                                        <div class="carousel-item h-100">
                                                                                                            <img src="<?= $value_warna_pakaian['foto']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                        </div>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php else : ?>
                                                                                        <div class="w-100 h-100 rounded d-flex justify-content-center align-items-center p-3" style="background-color: #CCCCCC;">
                                                                                            <h6 class="text-white">Gambar Tidak Tersedia</h6>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                                <div class="card-body px-3 py-0 text-center">
                                                                                    <div style="height: 3.5rem;" class="mt-2 d-flex align-items-center justify-content-center">
                                                                                        <h5><?= $value_pakaian['nama']; ?></h5>
                                                                                    </div>
                                                                                    <button class="btn btn-primary text-white btn-sm w-100 mb-3" data-bs-toggle="modal" data-bs-target="#border-less">Masukkan Keranjang</button>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                            <?php else : ?>
                                                                <div class="tab-pane" id="list-jenis_pakaian_merk_<?= $value['id']; ?>-<?= $value_jenis_pakaian['id']; ?>" role="tabpanel" aria-labelledby="list-jenis_pakaian_merk_<?= $value['id']; ?>-<?= $value_jenis_pakaian['id']; ?>-list">
                                                                    <div class="d-flex gap-3 text-center">
                                                                        <?php foreach ($value_jenis_pakaian['pakaian'] as $key_value_pakaian =>  $value_pakaian) : ?>
                                                                            <div class="card border" style="width: 12rem;">
                                                                                <div class="card-image" style="height: 12rem;">
                                                                                    <?php if (count($value_pakaian['warna_pakaian'])) : ?>
                                                                                        <div class="carousel slide h-100" data-bs-ride="carousel">
                                                                                            <div class="carousel-inner h-100 rounded">
                                                                                                <?php foreach ($value_pakaian['warna_pakaian'] as $index => $value_warna_pakaian) : ?>
                                                                                                    <?php if (!$index) : ?>
                                                                                                        <div class="carousel-item h-100 active">
                                                                                                            <img src="<?= $value_warna_pakaian['foto']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                        </div>
                                                                                                    <?php else : ?>
                                                                                                        <div class="carousel-item h-100">
                                                                                                            <img src="<?= $value_warna_pakaian['foto']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                                                                        </div>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php else : ?>
                                                                                        <div class="w-100 h-100 rounded d-flex justify-content-center align-items-center p-3" style="background-color: #CCCCCC;">
                                                                                            <h6 class="text-white">Gambar Tidak Tersedia</h6>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                                <div class="card-body px-3 py-0 text-center">
                                                                                    <div style="height: 3.5rem;" class="mt-2 d-flex align-items-center justify-content-center">
                                                                                        <h5><?= $value_pakaian['nama']; ?></h5>
                                                                                    </div>
                                                                                    <button class="btn btn-primary text-white btn-sm w-100 mb-3" data-bs-toggle="modal" data-bs-target="#border-less">Masukkan Keranjang</button>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="list-keranjang-list" data-bs-toggle="list" href="#list-keranjang" role="tab">Keranjang</a>
                            </div>
                            <div class="tab-content text-justify">
                                <div class="tab-pane fade show active" id="list-keranjang" role="tabpanel" aria-labelledby="list-keranjang-list">
                                    <div id="keranjang">
                                        <!-- <div class="border border-2 rounded p-3 mb-1">
                                            <div class="d-flex gap-3 justify-content-between flex-wrap">
                                                <img src="../../dummy/1.jpg" style="height: 6rem; aspect-ratio: 1; object-fit: cover;">
                                                <div class="flex-grow-1">
                                                    <h5 class="mb-1">KYNA BLOUSE</h5>
                                                    <h6 class="mb-1">Warna Merah</h6>
                                                    <h6 class="text-muted">Ukuran L</h6>
                                                    <h6>Rp 50.000</h6>
                                                </div>
                                                <div class="d-flex align-self-center border">
                                                    <div class="d-flex justify-content-center align-items-center " style="aspect-ratio: 1; width: 2rem;">
                                                        <a href="#"><i class="fas fa-minus"></i></a>
                                                    </div>
                                                    <div class="d-flex justify-content-center align-items-center border-start border-end" contenteditable="" style="width: 2.5rem;">1</div>
                                                    <div class="d-flex justify-content-center align-items-center " style="aspect-ratio: 1; width: 2rem;">
                                                        <a href="#"><i class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="d-flex">
                                                <h6 class="mb-0">Total Pembelian</h6>
                                                <h6 class="text-end flex-grow-1 mb-0">Rp 50.000</h6>
                                            </div>
                                        </div> -->
                                    </div>
                                    <hr>
                                    <div class="d-flex">
                                        <h6 class="mb-0">Total</h6>
                                        <h6 class="text-end flex-grow-1 mb-0">Rp 50.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Border-Less</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-lg">
                        <thead>
                            <tr>
                                <th class="text-center">Gambar</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Ukuran</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const obj = {};
    const merk = JSON.parse('<?= json_encode($merk); ?>');
    let pakaian = [];
    merk.forEach(element1 => {
        element1['jenis_pakaian'].forEach(element2 => {
            element2['pakaian'].forEach(element3 => {
                pakaian.push(element3);
            });
        });
    });
    console.log(pakaian)
    document.querySelectorAll("button[data-bs-target='#border-less']").forEach((button, index) => {
        button.addEventListener('click', () => {
            document.querySelector('#border-less tbody').innerText = '';
            document.querySelector('#border-less .modal-title').innerText = pakaian[index]['nama'];
            if (pakaian[index]['warna_pakaian'].length) {
                const tr = document.createElement('tr');
                tr.classList.add('text-center');
                pakaian[index]['warna_pakaian'].forEach(warna_pakaian => {
                    const td_gambar = document.createElement('td');
                    const gambar = document.createElement('img');
                    gambar.setAttribute('width', '100px');
                    gambar.setAttribute('src', `${window.location.origin}/app/halaman/${warna_pakaian.foto}`);
                    td_gambar.append(gambar);


                    const td_warna = document.createElement('td');
                    td_warna.innerText = warna_pakaian['nama'];

                    td_gambar.setAttribute('rowspan', warna_pakaian['ukuran'].length);
                    td_warna.setAttribute('rowspan', warna_pakaian['ukuran'].length);
                    tr.append(td_gambar);
                    tr.append(td_warna);

                    if (warna_pakaian['ukuran'].length) {
                        warna_pakaian['ukuran'].forEach((ukuran, index_ukuran) => {
                            const td_ukuran = document.createElement('td');
                            const td_jumlah_ukuran = document.createElement('td');
                            const td_button = document.createElement('td');
                            const button = document.createElement('button');
                            button.classList.add('btn', 'btn-primary', 'text-white', 'd-flex', 'justify-content-center', 'align-items-center');
                            button.style.aspectRatio = 1;
                            button.innerHTML = '<i class="fas fa-cart-plus me-1"></i>';
                            button.addEventListener('click', function() {
                                obj[ukuran['id']] = {
                                    nama: '',
                                    warna: '',
                                    ukuran: '',
                                    harga: '',
                                    jumlah: ''
                                };
                                const container_outer = document.createElement('div');
                                container_outer.classList.add('border', 'border-2', 'rounded', 'p-3', 'mb-1');
                                const container = document.createElement('div');
                                container.classList.add('d-flex', 'gap-3', 'justify-content-between');
                                const image = document.createElement('img');
                                image.setAttribute('src', `${window.location.origin}/app/halaman/${warna_pakaian.foto}`);
                                image.style.height = '6rem';
                                image.style.aspectRatio = 1;
                                image.style.objectFit = 'cover';

                                const formatter = new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    maximumFractionDigits: 0,
                                });

                                const content = document.createElement('div');
                                content.classList.add('flex-grow-1');

                                const content_nama = document.createElement('h5');
                                content_nama.classList.add('mb-1');
                                content_nama.innerText = pakaian[index]['nama'];
                                const content_warna = document.createElement('h6');
                                content_warna.classList.add('mb-1');
                                content_warna.innerText = `Warna ${warna_pakaian['nama']}`;
                                const content_ukuran = document.createElement('h6');
                                content_ukuran.classList.add('text-muted');
                                content_ukuran.innerText = `Ukuran ${ukuran.nama}`;
                                const content_harga = document.createElement('h6');
                                content_harga.innerText = formatter.format(pakaian[index]['harga']);

                                content.append(content_nama);
                                content.append(content_warna);
                                content.append(content_ukuran);
                                content.append(content_harga);

                                const jumlah_beli = document.createElement('div');
                                jumlah_beli.classList.add('d-flex', 'align-self-center', 'border');

                                const minus = document.createElement('div');
                                minus.classList.add('d-flex', 'justify-content-center', 'align-items-center');
                                minus.style.aspectRatio = 1;
                                minus.style.width = '2rem';
                                minus.innerHTML = `<a href="#"><i class="fas fa-minus"></i></a>`;
                                minus.addEventListener('click', function() {
                                    beli.innerText = Number(beli.innerText) - 1;
                                });

                                const beli = document.createElement('div');
                                beli.classList.add('d-flex', 'justify-content-center', 'align-items-center', 'border-start', 'border-end');
                                beli.setAttribute('contenteditable', '');
                                beli.innerText = 1;
                                beli.style.width = '2.5rem';

                                const plus = document.createElement('div');
                                plus.classList.add('d-flex', 'justify-content-center', 'align-items-center');
                                plus.style.aspectRatio = 1;
                                plus.style.width = '2rem';
                                plus.innerHTML = `<a href="#"><i class="fas fa-plus"></i></a>`;
                                plus.addEventListener('click', function() {
                                    beli.innerText = Number(beli.innerText) + 1;
                                });

                                jumlah_beli.append(minus);
                                jumlah_beli.append(beli);
                                jumlah_beli.append(plus);

                                container.append(image);
                                container.append(content);
                                container.append(jumlah_beli);
                                container_outer.append(container);

                                document.getElementById('keranjang').append(container_outer);
                            });

                            td_button.append(button);
                            td_ukuran.innerText = ukuran['nama'];
                            td_jumlah_ukuran.innerText = ukuran['jumlah'];
                            if (index_ukuran) {
                                const tr_ukuran = document.createElement('tr');
                                tr_ukuran.classList.add('text-center')
                                tr_ukuran.append(td_ukuran);
                                tr_ukuran.append(td_jumlah_ukuran);
                                tr_ukuran.append(td_button);
                                document.querySelector('#border-less tbody').append(tr_ukuran);
                            } else {
                                tr.append(td_ukuran);
                                tr.append(td_jumlah_ukuran);
                                tr.append(td_button);
                                document.querySelector('#border-less tbody').append(tr);
                            }
                        });
                    } else {
                        const td_ukuran = document.createElement('td');
                        td_ukuran.setAttribute('colspan', 2);
                        td_ukuran.innerText = "Ukuran Belum Ditambahkan";
                        tr.append(td_ukuran);
                        document.querySelector('#border-less tbody').append(tr);
                    }
                });
            }
        });
    });
</script>