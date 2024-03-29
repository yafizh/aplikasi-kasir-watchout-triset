<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Data Stok Pakaian <?= $mysqli->query("SELECT * FROM merk WHERE id=" . $_GET['id_merk'])->fetch_assoc()['nama']; ?></h3>
                </div>
            </div>
        </div>
        <section class="section">
            <form action="" method="POST">
                <input type="text" class="form-control" placeholder="Cari Nama Pakaian..." name="keyword" autofocus autocomplete="off" value="<?= ($_POST['keyword'] ?? '') ?>">
            </form>
        </section>
        <hr>
        <?php
        $kategori_pakaian = $mysqli->query("SELECT * FROM kategori_pakaian")->fetch_all(MYSQLI_ASSOC);
        foreach ($kategori_pakaian as $key_kategori_pakaian => $value_kategori_pakaian) {
            $query = "
                SELECT 
                    * 
                FROM 
                    pakaian 
                WHERE 
                    id_kategori_pakaian=" . $value_kategori_pakaian['id'] . " 
                    AND 
                    id_merk=" . $_GET['id_merk'] . " 
                    AND 
                    nama LIKE '%" . ($_POST['keyword'] ?? '') . "%'
            ";
            $pakaian = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
            foreach ($pakaian as $key_pakaian => $value_pakaian) {
                $query = "
                    SELECT 
                        id,
                        warna as nama,
                        (SELECT foto FROM foto_pakaian fp WHERE fp.id_warna_pakaian=warna_pakaian.id LIMIT 1) foto 
                    FROM 
                        warna_pakaian 
                    WHERE 
                        warna_pakaian.id_pakaian=" . $value_pakaian['id'];
                $warna_pakaian = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
                foreach ($warna_pakaian as $key_warna_pakaian => $value_warna_pakaian) {
                    $query = "
                        SELECT 
                            up.ukuran nama,
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
                            uwp.id_warna_pakaian=" . $value_warna_pakaian['id'] . " 
                        ORDER BY FIELD(up.ukuran, 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'), up.ukuran    
                    ";
                    $warna_pakaian[$key_warna_pakaian]['ukuran'] = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
                }
                $pakaian[$key_pakaian]['warna_pakaian'] = $warna_pakaian;
            }
            $kategori_pakaian[$key_kategori_pakaian]['pakaian'] = $pakaian;
        }
        ?>
        <?php $data_kosong = true; ?>
        <?php foreach ($kategori_pakaian as $value_kategori_pakaian) : ?>
            <?php if (count($value_kategori_pakaian['pakaian'])) : ?>
                <?php $data_kosong = false; ?>
                <section class="section mb-3">
                    <div class="title-section">
                        <h4><?= $value_kategori_pakaian['nama']; ?></h4>
                    </div>
                    <div class="inner-section d-flex gap-3 text-center">
                        <?php foreach ($value_kategori_pakaian['pakaian'] as $key_value_pakaian =>  $value_pakaian) : ?>
                            <div class="card" style="width: 12rem;">
                                <div class="card-image p-2" style="height: 12rem;">
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
                                    <div style="height: 3.5rem;" class="d-flex align-items-center justify-content-center">
                                        <h5><?= $value_pakaian['nama']; ?></h5>
                                    </div>
                                    <button class="btn btn-primary text-white btn-sm w-100 mb-3" data-bs-toggle="modal" data-bs-target="#border-less">Lihat Stok</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif ?>
        <?php endforeach; ?>
        <?php if ($data_kosong) : ?>
            <section class="section my-5">
                <div class="title-section">
                    <h4 class="text-center">Data Tidak Ditemukan</h4>
                </div>
            </section>
        <?php endif; ?>
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
    const kategori_pakaian = JSON.parse('<?= json_encode($kategori_pakaian); ?>');
    let pakaian = [];
    kategori_pakaian.forEach(element => {
        element['pakaian'].forEach(element2 => {
            pakaian.push(element2);
        });
    });

    document.querySelectorAll("button[data-bs-target='#border-less']").forEach((button, index) => {
        button.addEventListener('click', () => {
            document.querySelector('#border-less tbody').innerText = '';
            document.querySelector('#border-less .modal-title').innerText = pakaian[index]['nama'];
            if (pakaian[index]['warna_pakaian'].length) {
                pakaian[index]['warna_pakaian'].forEach((warna_pakaian, a) => {
                    const tr = document.createElement('tr');
                    tr.classList.add('text-center');

                    const td_gambar = document.createElement('td');
                    const gambar = document.createElement('img');
                    gambar.setAttribute('width', '100px');
                    gambar.setAttribute('src', `${((location.host == 'localhost') ? (location.origin + '/' + (window.location.pathname).split('/')[1]) : location.origin)}/app/halaman/${warna_pakaian.foto}`);
                    td_gambar.append(gambar);

                    const td_warna = document.createElement('td');
                    td_warna.innerText = warna_pakaian['nama'];

                    td_gambar.setAttribute('rowspan', warna_pakaian['ukuran'].length);
                    td_warna.setAttribute('rowspan', warna_pakaian['ukuran'].length);
                    tr.append(td_gambar);
                    tr.append(td_warna);

                    if (warna_pakaian['ukuran'].length) {
                        warna_pakaian['ukuran'].forEach((ukuran, index) => {
                            const td_ukuran = document.createElement('td');
                            const td_jumlah_ukuran = document.createElement('td');
                            td_ukuran.innerText = ukuran['nama'];
                            td_jumlah_ukuran.innerText = ukuran['jumlah'];
                            if (index) {
                                const tr_ukuran = document.createElement('tr');
                                tr_ukuran.classList.add('text-center')
                                tr_ukuran.append(td_ukuran);
                                tr_ukuran.append(td_jumlah_ukuran);
                                document.querySelector('#border-less tbody').append(tr_ukuran);
                            } else {
                                tr.append(td_ukuran);
                                tr.append(td_jumlah_ukuran);
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