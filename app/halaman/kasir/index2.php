<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <?php
    $query = "SELECT 
    m.id,
    m.nama,
    (
        SELECT 
            JSON_ARRAYAGG(JSON_OBJECT(
                'nama', jp.nama,
                'pakaian', (
                    SELECT 
                        JSON_ARRAYAGG(JSON_OBJECT(
                            'nama', p.nama,
                            'warna', (
                                SELECT 
                                    JSON_ARRAYAGG(JSON_OBJECT(
                                        'warna', w.nama,
                                        'ukuran', (
                                            SELECT 
                                                JSON_ARRAYAGG(JSON_OBJECT(
                                                    'ukuran', u.nama,
                                                    'jumlah', (SELECT SUM(jumlah) FROM pakaian_disuplai AS pd WHERE pd.id_ukuran_warna_pakaian=uwp.id)
                                                )) 
                                            FROM 
                                                ukuran_warna_pakaian AS uwp 
                                            INNER JOIN 
                                                ukuran AS u 
                                            ON 
                                                u.id=uwp.id_ukuran 
                                            WHERE 
                                                uwp.id_warna_pakaian=wp.id
                                        )
                                    )) 
                                FROM 
                                    warna_pakaian AS wp 
                                INNER JOIN 
                                    warna AS w 
                                ON 
                                    w.id=wp.id_warna 
                                WHERE 
                                    wp.id_pakaian=p.id
                            )
                        )) 
                    FROM 
                        pakaian AS p 
                    WHERE 
                        p.id_merk=m.id AND p.id_jenis_pakaian=jp.id
                )
            ))
        FROM 
            jenis_pakaian AS jp  
    ) AS jenis_pakaian
    FROM 
        merk AS m";
    $result = $mysqli->query($query);
    $data = $result->fetch_all(MYSQLI_ASSOC);
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
            <div class="col">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
                                <?php foreach ($data as $merk_index => $merk) : ?>
                                    <a class="list-group-item list-group-item-action <?= !$merk_index ? 'active' : ''; ?>" id="list-<?= $merk['id']; ?>-list" data-bs-toggle="list" href="#list-<?= $merk['id']; ?>" role="tab"><?= $merk['nama']; ?></a>
                                <?php endforeach; ?>
                            </div>
                            <div class="tab-content text-justify">
                                <?php foreach ($data as $merk_index => $merk) : ?>
                                    <div class="tab-pane fade <?= !$merk_index ? 'show active' : ''; ?>" id="list-<?= $merk['id']; ?>" role="tabpanel" aria-labelledby="list-<?= $merk['id']; ?>-list">
                                        <div class="row py-3">
                                            <div class="col-3 col-md-auto mb-3">
                                                <div class="list-group" role="tablist">
                                                    <?php foreach (json_decode($merk['jenis_pakaian']) as $index_jp => $jenis_pakaian) : ?>
                                                        <a class="list-group-item list-group-item-action <?= !$index_jp ? 'active' : ''; ?>" id="list-merk-<?= $merk_index; ?>-jenis_pakaian-<?= $index_jp; ?>-list" data-bs-toggle="list" href="#list-merk-<?= $merk_index; ?>-jenis_pakaian-<?= $index_jp; ?>" role="tab"><?= $jenis_pakaian->nama; ?></a>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-auto mb-3">
                                                <div class="tab-content text-justify">
                                                    <?php foreach (json_decode($merk['jenis_pakaian']) as $index_jp => $jenis_pakaian) : ?>
                                                        <div class="tab-pane <?= !$index_jp ? 'show active' : ''; ?>" id="list-merk-<?= $merk_index; ?>-jenis_pakaian-<?= $index_jp; ?>" role="tabpanel" aria-labelledby="list-merk-<?= $merk_index; ?>-jenis_pakaian-<?= $index_jp; ?>-list">
                                                            <div class="d-flex gap-3 text-center">
                                                                <?php foreach ($jenis_pakaian->pakaian as $index_p =>  $pakaian) : ?>
                                                                    <div class="card border" style="width: 12rem;">
                                                                        <div class="card-body px-3 py-0 text-center">
                                                                            <div style="height: 3.5rem;" class="mt-2 d-flex align-items-center justify-content-center">
                                                                                <h5><?= $pakaian->nama; ?></h5>
                                                                            </div>
                                                                            <button class="btn btn-primary text-white btn-sm w-100 mb-3" data-bs-toggle="modal" data-bs-target="#border-less">Masukkan Keranjang</button>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
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