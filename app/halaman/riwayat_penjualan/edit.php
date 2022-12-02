<?php
if (isset($_POST['submit'])) {
    $tunai = implode('', explode('.', $_POST['tunai']));
    $id_ukuran_warna_pakaian = $_POST['id_ukuran_warna_pakaian'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];

    $q = "
    UPDATE penjualan SET 
        tunai='$tunai' 
    WHERE 
        id=" . $_GET['id'];

    if ($mysqli->query($q)) {
        $mysqli->query("DELETE FROM pakaian_terjual WHERE id_penjualan=" . $_GET['id']);
        for ($i = 0; $i < count($id_ukuran_warna_pakaian); $i++) {
            $q = "
             INSERT INTO pakaian_terjual (
                id_penjualan, 
                id_ukuran_warna_pakaian, 
                harga, 
                jumlah 
            ) VALUES (
                '" . $_GET['id'] . "',
                '" . $id_ukuran_warna_pakaian[$i] . "',
                '" . $harga[$i] . "',
                '" . $jumlah[$i] . "'
            )";
            $mysqli->query($q);
        }
        echo "<script>sessionStorage.setItem('tambah','Edit Penjualan Berhasil!.');</script>";
        echo "<script>location.href = '?halaman=riwayat_penjualan';</script>";
    } else {
        echo "<script>alert('Gagal!')</script>";
        die($mysqli->error);
    }
}
?>
<style>
    a[class='text-muted'] {
        cursor: not-allowed;
    }
</style>
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <?php
    $query = "
        SELECT 
            p.id,
            p.tunai,
            DATE(tanggal_waktu_penjualan) AS tanggal,
            TIME_FORMAT(tanggal_waktu_penjualan, '%H:%i') AS waktu,
            SUM(pt.harga * pt.jumlah) AS total
        FROM 
            penjualan AS p 
        INNER JOIN 
            pakaian_terjual AS pt 
        ON 
            p.id=pt.id_penjualan 
        WHERE 
            p.id=" . $_GET['id'] . "
        GROUP BY 
            p.id 
        ";
    $result = $mysqli->query($query);
    $riwayat_penjualan = $result->fetch_assoc();
    $query = "
        SELECT 
            uwp.id,
            pt.jumlah,
            pt.harga,
            u.nama AS ukuran,
            w.nama AS warna,
            p.nama, 
            wp.foto  
        FROM 
            pakaian_terjual AS pt 
        INNER JOIN 
            ukuran_warna_pakaian AS uwp 
        ON 
            uwp.id=pt.id_ukuran_warna_pakaian
        INNER JOIN 
            ukuran AS u 
        ON 
            u.id=uwp.id_ukuran 
        INNER JOIN 
            warna_pakaian AS wp 
        ON 
            wp.id=uwp.id_warna_pakaian
        INNER JOIN 
            warna AS w 
        ON 
            w.id=wp.id_warna 
        INNER JOIN 
            pakaian AS p 
        ON 
            p.id=wp.id_pakaian
        WHERE 
            pt.id_penjualan=" . $_GET['id'];
    $riwayat_penjualan['pakaian_terjual'] = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    ?>

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
                                uwp.*,
                                (
                                    IFNULL((SELECT SUM(pd.jumlah) FROM pakaian_disuplai AS pd WHERE pd.id_ukuran_warna_pakaian=uwp.id), 0)
                                    - 
                                    IFNULL((SELECT SUM(pt.jumlah) FROM pakaian_terjual AS pt WHERE pt.id_ukuran_warna_pakaian=uwp.id), 0)
                                ) AS jumlah 
                            FROM 
                                ukuran_warna_pakaian AS uwp
                            INNER JOIN 
                                ukuran 
                            ON 
                                ukuran.id=uwp.id_ukuran  
                            WHERE 
                                uwp.id_warna_pakaian=" . $value_warna_pakaian['id'] . "
                            GROUP BY 
                                uwp.id
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
                    <h3>Edit Riwayat Penjualan</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
                                <?php foreach ($merk as $m_index => $m_value) : ?>
                                    <a class="list-group-item list-group-item-action <?= !$m_index ? 'active' : ''; ?>" id="list-<?= $m_value['id']; ?>-list" data-bs-toggle="list" href="#list-<?= $m_value['id']; ?>" role="tab"><?= $m_value['nama']; ?></a>
                                <?php endforeach; ?>
                            </div>
                            <div class="tab-content text-justify">
                                <?php foreach ($merk as $m_index => $m_value) : ?>
                                    <div class="tab-pane fade <?= !$m_index ? 'show active' : ''; ?>" id="list-<?= $m_value['id']; ?>" role="tabpanel" aria-labelledby="list-<?= $m_value['id']; ?>-list">
                                        <div class="row py-3">
                                            <div class="col-3 mb-3">
                                                <div class="list-group" role="tablist">
                                                    <?php foreach ($m_value['jenis_pakaian'] as $jp_index => $jp_value) : ?>
                                                        <a class="list-group-item list-group-item-action <?= !$jp_index ? 'active' : ''; ?>" id="list-merk-<?= $m_index; ?>-jenis_pakaian-<?= $jp_index; ?>-list" data-bs-toggle="list" href="#list-merk-<?= $m_index; ?>-jenis_pakaian-<?= $jp_index; ?>" role="tab"><?= $jp_value['nama']; ?></a>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <div class="tab-content text-justify">
                                                    <?php foreach ($m_value['jenis_pakaian'] as $jp_index => $jp_value) : ?>
                                                        <div class="tab-pane <?= !$jp_index ? 'show active' : ''; ?>" id="list-merk-<?= $m_index; ?>-jenis_pakaian-<?= $jp_index; ?>" role="tabpanel" aria-labelledby="list-merk-<?= $m_index; ?>-jenis_pakaian-<?= $jp_index; ?>-list">
                                                            <div class="d-flex flex-wrap gap-3 text-center">
                                                                <?php foreach ($jp_value['pakaian'] as $p_value) : ?>
                                                                    <div class="card border m-0" style="width: 12rem;">
                                                                        <div class="card-body px-3 py-0 text-center">
                                                                            <div style="height: 3.5rem;" class="mt-2 d-flex align-items-center justify-content-center">
                                                                                <h5><?= $p_value['nama']; ?></h5>
                                                                            </div>
                                                                            <button class="btn btn-primary text-white btn-sm w-100 mb-3" data-bs-toggle="modal" data-bs-target="#detail-pakaian">Masukkan Keranjang</button>
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
                <div class="card" style="min-height: 90.5%;">
                    <div class="card-header">
                        <h5>Keranjang</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <div id="empty-basket" class="text-center align-self-center">
                            <h5 class="text-muted">Keranjang Kosong</h5>
                        </div>
                        <div id="basket" class="w-100 d-none">
                            <div id="in-basket"></div>
                            <hr>
                            <div class="d-flex mb-3">
                                <h6 class="mb-0">Total Pembelian</h6>
                                <h6 class="text-end flex-grow-1 mb-0" id="total-in-basket">Rp 0</h6>
                            </div>
                            <button class="btn btn-primary text-white w-100" data-bs-toggle="modal" data-bs-target="#detail-basket">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left modal-borderless" id="detail-pakaian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
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

<div class="modal fade text-left modal-borderless" id="basket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="detail-basket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Keranjang</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div id="detail-in-basket"></div>
                    <hr>
                    <div class="d-flex flex-column">
                        <div class="d-flex mb-3">
                            <h6 class="mb-0">Total Pembelian</h6>
                            <h6 class="text-end flex-grow-1 mb-0 total-pembelian">Rp 0</h6>
                        </div>
                        <div class="row mb-3">
                            <h6 class="col col-form-label">Tunai</h6>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="tunai" style="text-align: right;" autocomplete="off" value="<?= number_format($riwayat_penjualan['tunai'], 0, ",", "."); ?>">
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <h6 class="mb-0">Kembalian</h6>
                            <h6 class="text-end flex-grow-1 mb-0 kembalian">Rp <?= number_format($riwayat_penjualan['tunai'] - $riwayat_penjualan['total'], 0, ",", "."); ?></h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <button type="submit" name="submit" class="btn btn-primary ml-1 text-white">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Lakukan Penjualan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const riwayat_penjualan = JSON.parse('<?= json_encode($riwayat_penjualan); ?>');
    const merk = JSON.parse('<?= json_encode($merk); ?>');
    let pakaian = [];
    merk.forEach(element1 => {
        element1['jenis_pakaian'].forEach(element2 => {
            element2['pakaian'].forEach(element3 => {
                pakaian.push(element3);
            });
        });
    });
</script>
<script>
    const modalDetailPakaian = document.getElementById('detail-pakaian');
    const modalDetailPakaianModalTitle = modalDetailPakaian.querySelector('.modal-title');
    const modalDetailPakaianTbody = modalDetailPakaian.querySelector('tbody');
    const basket = {
        total: 0
    };
    const totalInBasket = document.getElementById('total-in-basket');
    riwayat_penjualan['pakaian_terjual'].forEach((value, index) => {
        basket[value.id] = {
            jumlah: Number(value.jumlah),
            harga: Number(value.harga),
            nama: value.nama,
            warna: value.warna,
            ukuran: value.ukuran,
            foto: value.foto,
        };
    });

    // ---
    pakaian.forEach((a, index) => {
        if (a['warna_pakaian'].length) {
            pakaian[index]['warna_pakaian'].forEach(warna_pakaian => {
                warna_pakaian['ukuran'].forEach((ukuran, index_ukuran) => {
                    if (ukuran['id'] in basket) {
                        const inputIdUkuranPakaian = document.createElement('input');
                        const inputJumlah = document.createElement('input');
                        const inputHarga = document.createElement('input');
                        inputIdUkuranPakaian.setAttribute('name', 'id_ukuran_warna_pakaian[]');
                        inputJumlah.setAttribute('name', 'jumlah[]');
                        inputJumlah.setAttribute('id', `input-jumlah-${ukuran['id']}`);
                        inputHarga.setAttribute('name', 'harga[]');
                        inputIdUkuranPakaian.classList.add('d-none');
                        inputJumlah.classList.add('d-none');
                        inputHarga.classList.add('d-none');

                        basket.total += basket[ukuran['id']].harga * basket[ukuran['id']].jumlah;
                        totalInBasket.innerText = formatter.format(basket.total);

                        // Generate Item In Basket
                        const container = document.createElement('div');
                        container.classList.add('border', 'border-2', 'rounded', 'p-3', 'mb-1');

                        const containerItem = document.createElement('div');
                        const image = document.createElement('img');

                        const item = document.createElement('div');
                        const itemNama = document.createElement('h5');
                        const itemWarna = document.createElement('h6');
                        const itemUkuran = document.createElement('h6');
                        const itemHarga = document.createElement('h6');

                        const itemMinusJumlahPlus = document.createElement('div');
                        const buttonMinus = document.createElement('div');
                        const jumlah = document.createElement('div');
                        const buttonPlus = document.createElement('div');

                        const containerTotalPembelianPakaian = document.createElement('div');
                        const totalPembelianText = document.createElement('h6');
                        const totalPembelianTotal = document.createElement('h6');

                        containerTotalPembelianPakaian.classList.add('d-flex');
                        totalPembelianText.classList.add('mb-0');
                        totalPembelianTotal.classList.add('text-end', 'flex-grow-1', 'mb-0');
                        totalPembelianText.innerText = 'Total';
                        totalPembelianTotal.innerText = formatter.format(basket[ukuran['id']].harga * basket[ukuran['id']].jumlah);
                        totalPembelianTotal.setAttribute('id', `jumlah-ukuran-${ukuran['id']}-total`);

                        containerItem.classList.add('d-flex', 'gap-3', 'justify-content-between');

                        item.classList.add('flex-grow-1');

                        image.setAttribute('src', `${window.location.origin}/app/halaman/${warna_pakaian.foto}`);
                        image.style.height = '6rem';
                        image.style.aspectRatio = 1;
                        image.style.keranjangectFit = 'cover';

                        itemNama.classList.add('mb-1');
                        itemWarna.classList.add('mb-1');
                        itemUkuran.classList.add('text-muted');
                        itemMinusJumlahPlus.classList.add('d-flex', 'align-self-center', 'border', 'count');
                        buttonMinus.classList.add('d-flex', 'justify-content-center', 'align-items-center');
                        jumlah.classList.add('d-flex', 'justify-content-center', 'align-items-center', 'border-start', 'border-end');
                        buttonPlus.classList.add('d-flex', 'justify-content-center', 'align-items-center');

                        itemNama.innerText = pakaian[index]['nama'];
                        itemWarna.innerText = `Warna ${warna_pakaian['nama']}`;
                        itemUkuran.innerText = `Ukuran ${ukuran.nama}`;
                        itemHarga.innerText = formatter.format(pakaian[index]['harga']);

                        jumlah.setAttribute('contenteditable', '');
                        jumlah.setAttribute('id', `jumlah-ukuran-${ukuran['id']}`);
                        jumlah.innerText = basket[ukuran['id']].jumlah;
                        jumlah.style.width = '2.5rem';

                        item.append(itemNama);
                        item.append(itemWarna);
                        item.append(itemUkuran);
                        item.append(itemHarga);

                        buttonMinus.style.aspectRatio = 1;
                        buttonMinus.style.width = '2rem';
                        buttonMinus.innerHTML = `<a href="#"><i class="fas fa-minus"></i></a>`;
                        buttonMinus.addEventListener('click', () => {
                            basket[ukuran['id']].jumlah -= 1;
                            basket.total -= Number(pakaian[index]['harga']);
                            inputJumlah.value = basket[ukuran['id']].jumlah;
                            jumlah.innerText = basket[ukuran['id']].jumlah;
                            totalInBasket.innerText = formatter.format(basket.total);
                            totalPembelianTotal.innerText = formatter.format(pakaian[index]['harga'] * basket[ukuran['id']].jumlah);

                            if (Number(ukuran['jumlah']) - Number(jumlah.innerText) >= 0) {
                                jumlah.classList.remove('bg-danger');
                                jumlah.classList.remove('text-white');
                            }
                            if (Number(ukuran['jumlah']) - Number(jumlah.innerText) > 0)
                                buttonPlus.children[0].classList.remove('text-muted');

                            if (basket[ukuran['id']].jumlah == 0) {
                                container.remove();
                                delete basket[ukuran['id']];
                                inputIdUkuranPakaian.remove();
                                inputJumlah.remove();
                            }

                            if (!basket.total) {
                                document.getElementById('basket').classList.add('d-none');
                                document.getElementById('empty-basket').classList.remove('d-none');
                            }
                        });

                        jumlah.addEventListener("keypress", (evt) => {
                            if (evt.which < 48 || evt.which > 57) {
                                evt.preventDefault();
                                return;
                            }

                            jumlah.addEventListener('input', function() {
                                if (Number(ukuran['jumlah']) - Number(jumlah.innerText) < 0) {
                                    jumlah.classList.add('bg-danger');
                                    jumlah.classList.add('text-white');
                                    buttonPlus.children[0].classList.add('text-muted');
                                    return;
                                } else {
                                    jumlah.classList.remove('bg-danger');
                                    jumlah.classList.remove('text-white');
                                    buttonPlus.children[0].classList.remove('text-muted');
                                }
                                basket.total = basket.total + ((Number(this.innerText) * Number(pakaian[index]['harga'])) - (basket[ukuran['id']].jumlah * Number(pakaian[index]['harga'])));
                                basket[ukuran['id']].jumlah = Number(this.innerText);
                                totalInBasket.innerText = formatter.format(basket.total);
                                totalPembelianTotal.innerText = formatter.format(pakaian[index]['harga'] * basket[ukuran['id']].jumlah);
                                inputJumlah.value = basket[ukuran['id']].jumlah;
                                if (basket[ukuran['id']].jumlah == 0) {
                                    container.remove();
                                    delete basket[ukuran['id']];
                                    inputIdUkuranPakaian.remove();
                                    inputJumlah.remove();
                                }
                            });
                        });

                        buttonPlus.style.aspectRatio = 1;
                        buttonPlus.style.width = '2rem';
                        if (Number(ukuran['jumlah']) - Number(jumlah.innerText) <= 0)
                            buttonPlus.innerHTML = `<a href="#" class="text-muted"><i class="fas fa-plus"></i></a>`;
                        else
                            buttonPlus.innerHTML = `<a href="#"><i class="fas fa-plus"></i></a>`;

                        buttonPlus.addEventListener('click', function() {
                            if (Number(ukuran['jumlah']) - Number(jumlah.innerText) > 0) {
                                basket[ukuran['id']].jumlah += 1;
                                basket.total += Number(pakaian[index]['harga'])
                                jumlah.innerText = basket[ukuran['id']].jumlah;
                                totalInBasket.innerText = formatter.format(basket.total);
                                inputJumlah.value = basket[ukuran['id']].jumlah;
                                totalPembelianTotal.innerText = formatter.format(pakaian[index]['harga'] * basket[ukuran['id']].jumlah);
                            }
                            if (Number(ukuran['jumlah']) - Number(jumlah.innerText) <= 0) {
                                buttonPlus.children[0].classList.add('text-muted');
                                return;
                            }
                        });

                        itemMinusJumlahPlus.append(buttonMinus);
                        itemMinusJumlahPlus.append(jumlah);
                        itemMinusJumlahPlus.append(buttonPlus);

                        containerItem.append(image);
                        containerItem.append(item);
                        containerItem.append(itemMinusJumlahPlus);

                        containerTotalPembelianPakaian.append(totalPembelianText);
                        containerTotalPembelianPakaian.append(totalPembelianTotal);

                        container.append(containerItem);
                        container.append(document.createElement('hr'));
                        container.append(containerTotalPembelianPakaian);

                        document.getElementById('in-basket').append(container);

                        document.querySelector('form').append(inputIdUkuranPakaian);
                        document.querySelector('form').append(inputJumlah);
                        document.querySelector('form').append(inputHarga);

                        inputHarga.value = Number(pakaian[index]['harga']);
                        inputIdUkuranPakaian.value = ukuran['id'];
                        inputJumlah.value = basket[ukuran['id']].jumlah;
                        document.getElementById('empty-basket').classList.add('d-none');
                        document.getElementById('basket').classList.remove('d-none');
                    }
                });
            });
        }
    })
    // ---

    document.querySelector("button[data-bs-target='#detail-basket']").addEventListener('click', () => {
        document.getElementById('detail-in-basket').innerText = "";
        Object.keys(basket).forEach(key => {
            if (key != 'total') {
                document.getElementById('detail-in-basket').insertAdjacentHTML('beforeend', `
                <div class="border border-2 rounded p-3 mb-1">
                    <div class="d-flex gap-3 justify-content-between flex-wrap">
                        <img src="${window.location.origin}/app/halaman/${basket[key].foto}" style="height: 6rem; aspect-ratio: 1; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">${basket[key].nama}</h5>
                            <h6 class="mb-1">Warna ${basket[key].warna}</h6>
                            <h6 class="text-muted">Ukuran ${basket[key].ukuran}</h6>
                            <h6>${formatter.format(basket[key].harga)}</h6>
                        </div>
                        <div class="d-flex align-self-center border">
                            <div class="d-flex justify-content-center align-items-center" style="aspect-ratio: 1;width: 2rem;">${basket[key].jumlah}</div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex">
                        <h6 class="mb-0">Total</h6>
                        <h6 class="text-end flex-grow-1 mb-0">${formatter.format(basket[key].harga * basket[key].jumlah)}</h6>
                    </div>
                </div>
            `);
            }
        });

        document.querySelector('input[name=tunai]').addEventListener("keypress", (evt) => {
            if (evt.which < 48 || evt.which > 57) {
                evt.preventDefault();
                return;
            }
            document.querySelector('input[name=tunai]').addEventListener('input', function() {
                const tunai = Number(((this.value).split('.')).join(''));
                document.querySelector('input[name=tunai]').value = formatNumberWithDot.format(tunai);
                if (tunai - basket.total >= 0) {
                    document.querySelector('button[name=submit]').removeAttribute('disabled');
                    document.querySelector('.kembalian').innerText = formatter.format(tunai - basket.total);
                    return;
                }
                document.querySelector('.kembalian').innerText = formatter.format(0);
                document.querySelector('button[name=submit]').setAttribute('disabled', '');
            });
        });

        document.querySelector('.total-pembelian').innerText = formatter.format(basket.total);

    });

    document.querySelectorAll("button[data-bs-target='#detail-pakaian']").forEach((button, index) => {
        button.addEventListener('click', () => {
            modalDetailPakaianModalTitle.innerText = pakaian[index]['nama'];
            modalDetailPakaianTbody.innerText = '';

            if (pakaian[index]['warna_pakaian'].length) {
                const tr = document.createElement('tr');
                tr.classList.add('text-center');

                pakaian[index]['warna_pakaian'].forEach(warna_pakaian => {
                    const tdGambar = document.createElement('td');
                    const tdWarna = document.createElement('td');
                    const gambar = document.createElement('img');

                    tdGambar.setAttribute('rowspan', warna_pakaian['ukuran'].length);
                    tdWarna.setAttribute('rowspan', warna_pakaian['ukuran'].length);

                    gambar.setAttribute('width', '100px');
                    gambar.setAttribute('src', `${window.location.origin}/app/halaman/${warna_pakaian.foto}`);

                    tdGambar.append(gambar);
                    tdWarna.innerText = warna_pakaian['nama'];

                    tr.append(tdGambar);
                    tr.append(tdWarna);

                    if (!warna_pakaian['ukuran'].length) {
                        const tdUkuran = document.createElement('td');
                        tdUkuran.setAttribute('colspan', 2);
                        tdUkuran.innerText = "Ukuran Belum Ditambahkan";
                        tr.append(tdUkuran);
                        modalDetailPakaianTbody.append(tr);
                        return;
                    }

                    warna_pakaian['ukuran'].forEach((ukuran, index_ukuran) => {
                        const tdUkuran = document.createElement('td');
                        const tdJumlahUkuran = document.createElement('td');
                        const tdButtonMoveToBasket = document.createElement('td');
                        const buttonMoveToBasket = document.createElement('button');

                        buttonMoveToBasket.classList.add('btn', 'btn-primary', 'text-white', 'd-flex', 'justify-content-center', 'align-items-center');
                        buttonMoveToBasket.style.aspectRatio = 1;
                        buttonMoveToBasket.innerHTML = '<i class="fas fa-cart-plus me-1"></i>';
                        buttonMoveToBasket.addEventListener('click', function() {
                            const inputIdUkuranPakaian = document.createElement('input');
                            const inputJumlah = document.createElement('input');
                            const inputHarga = document.createElement('input');
                            inputIdUkuranPakaian.setAttribute('name', 'id_ukuran_warna_pakaian[]');
                            inputJumlah.setAttribute('name', 'jumlah[]');
                            inputJumlah.setAttribute('id', `input-jumlah-${ukuran['id']}`);
                            inputHarga.setAttribute('name', 'harga[]');
                            inputIdUkuranPakaian.classList.add('d-none');
                            inputJumlah.classList.add('d-none');
                            inputHarga.classList.add('d-none');

                            if (ukuran['id'] in basket) {
                                if (Number(ukuran['jumlah']) - Number(basket[ukuran['id']].jumlah) <= 0) {
                                    alert('Stok Habis!');
                                    return;
                                }
                                basket[ukuran['id']].jumlah += 1;
                                basket.total += Number(pakaian[index]['harga']);
                                document.getElementById(`jumlah-ukuran-${ukuran['id']}`).innerText = basket[ukuran['id']].jumlah;
                                document.getElementById(`jumlah-ukuran-${ukuran['id']}-total`).innerText = formatter.format(pakaian[index]['harga'] * basket[ukuran['id']].jumlah);
                                totalInBasket.innerText = formatter.format(basket.total);
                                document.getElementById(`input-jumlah-${ukuran['id']}`).value = basket[ukuran['id']].jumlah;
                            } else {
                                basket[ukuran['id']] = {
                                    jumlah: 1,
                                    harga: Number(pakaian[index]['harga']),
                                    nama: pakaian[index]['nama'],
                                    warna: warna_pakaian['nama'],
                                    ukuran: ukuran['nama'],
                                    foto: warna_pakaian['foto'],
                                };
                                basket.total += Number(pakaian[index]['harga']);
                                totalInBasket.innerText = formatter.format(basket.total);

                                // Generate Item In Basket
                                const container = document.createElement('div');
                                container.classList.add('border', 'border-2', 'rounded', 'p-3', 'mb-1');

                                const containerItem = document.createElement('div');
                                const image = document.createElement('img');

                                const item = document.createElement('div');
                                const itemNama = document.createElement('h5');
                                const itemWarna = document.createElement('h6');
                                const itemUkuran = document.createElement('h6');
                                const itemHarga = document.createElement('h6');

                                const itemMinusJumlahPlus = document.createElement('div');
                                const buttonMinus = document.createElement('div');
                                const jumlah = document.createElement('div');
                                const buttonPlus = document.createElement('div');

                                const containerTotalPembelianPakaian = document.createElement('div');
                                const totalPembelianText = document.createElement('h6');
                                const totalPembelianTotal = document.createElement('h6');

                                containerTotalPembelianPakaian.classList.add('d-flex');
                                totalPembelianText.classList.add('mb-0');
                                totalPembelianTotal.classList.add('text-end', 'flex-grow-1', 'mb-0');
                                totalPembelianText.innerText = 'Total';
                                totalPembelianTotal.innerText = formatter.format(pakaian[index]['harga']);
                                totalPembelianTotal.setAttribute('id', `jumlah-ukuran-${ukuran['id']}-total`);

                                containerItem.classList.add('d-flex', 'gap-3', 'justify-content-between');

                                item.classList.add('flex-grow-1');

                                image.setAttribute('src', `${window.location.origin}/app/halaman/${warna_pakaian.foto}`);
                                image.style.height = '6rem';
                                image.style.aspectRatio = 1;
                                image.style.keranjangectFit = 'cover';

                                itemNama.classList.add('mb-1');
                                itemWarna.classList.add('mb-1');
                                itemUkuran.classList.add('text-muted');
                                itemMinusJumlahPlus.classList.add('d-flex', 'align-self-center', 'border', 'count');
                                buttonMinus.classList.add('d-flex', 'justify-content-center', 'align-items-center');
                                jumlah.classList.add('d-flex', 'justify-content-center', 'align-items-center', 'border-start', 'border-end');
                                buttonPlus.classList.add('d-flex', 'justify-content-center', 'align-items-center');

                                itemNama.innerText = pakaian[index]['nama'];
                                itemWarna.innerText = `Warna ${warna_pakaian['nama']}`;
                                itemUkuran.innerText = `Ukuran ${ukuran.nama}`;
                                itemHarga.innerText = formatter.format(pakaian[index]['harga']);

                                jumlah.setAttribute('contenteditable', '');
                                jumlah.setAttribute('id', `jumlah-ukuran-${ukuran['id']}`);
                                jumlah.innerText = 1;
                                jumlah.style.width = '2.5rem';

                                item.append(itemNama);
                                item.append(itemWarna);
                                item.append(itemUkuran);
                                item.append(itemHarga);

                                buttonMinus.style.aspectRatio = 1;
                                buttonMinus.style.width = '2rem';
                                buttonMinus.innerHTML = `<a href="#"><i class="fas fa-minus"></i></a>`;
                                buttonMinus.addEventListener('click', () => {
                                    basket[ukuran['id']].jumlah -= 1;
                                    basket.total -= Number(pakaian[index]['harga']);
                                    inputJumlah.value = basket[ukuran['id']].jumlah;
                                    jumlah.innerText = basket[ukuran['id']].jumlah;
                                    totalInBasket.innerText = formatter.format(basket.total);
                                    totalPembelianTotal.innerText = formatter.format(pakaian[index]['harga'] * basket[ukuran['id']].jumlah);

                                    if (Number(ukuran['jumlah']) - Number(jumlah.innerText) >= 0) {
                                        jumlah.classList.remove('bg-danger');
                                        jumlah.classList.remove('text-white');
                                    }
                                    if (Number(ukuran['jumlah']) - Number(jumlah.innerText) > 0)
                                        buttonPlus.children[0].classList.remove('text-muted');

                                    if (basket[ukuran['id']].jumlah == 0) {
                                        container.remove();
                                        delete basket[ukuran['id']];
                                        inputIdUkuranPakaian.remove();
                                        inputJumlah.remove();
                                    }

                                    if (!basket.total) {
                                        document.getElementById('basket').classList.add('d-none');
                                        document.getElementById('empty-basket').classList.remove('d-none');
                                    }
                                });

                                jumlah.addEventListener("keypress", (evt) => {
                                    if (evt.which < 48 || evt.which > 57) {
                                        evt.preventDefault();
                                        return;
                                    }

                                    jumlah.addEventListener('input', function() {
                                        if (Number(ukuran['jumlah']) - Number(jumlah.innerText) < 0) {
                                            jumlah.classList.add('bg-danger');
                                            jumlah.classList.add('text-white');
                                            buttonPlus.children[0].classList.add('text-muted');
                                            return;
                                        } else {
                                            jumlah.classList.remove('bg-danger');
                                            jumlah.classList.remove('text-white');
                                            buttonPlus.children[0].classList.remove('text-muted');
                                        }
                                        basket.total = basket.total + ((Number(this.innerText) * Number(pakaian[index]['harga'])) - (basket[ukuran['id']].jumlah * Number(pakaian[index]['harga'])));
                                        basket[ukuran['id']].jumlah = Number(this.innerText);
                                        totalInBasket.innerText = formatter.format(basket.total);
                                        totalPembelianTotal.innerText = formatter.format(pakaian[index]['harga'] * basket[ukuran['id']].jumlah);
                                        inputJumlah.value = basket[ukuran['id']].jumlah;
                                        if (basket[ukuran['id']].jumlah == 0) {
                                            container.remove();
                                            delete basket[ukuran['id']];
                                            inputIdUkuranPakaian.remove();
                                            inputJumlah.remove();
                                        }
                                    });
                                });

                                buttonPlus.style.aspectRatio = 1;
                                buttonPlus.style.width = '2rem';
                                if (Number(ukuran['jumlah']) - Number(jumlah.innerText) <= 0)
                                    buttonPlus.innerHTML = `<a href="#" class="text-muted"><i class="fas fa-plus"></i></a>`;
                                else
                                    buttonPlus.innerHTML = `<a href="#"><i class="fas fa-plus"></i></a>`;

                                buttonPlus.addEventListener('click', function() {
                                    if (Number(ukuran['jumlah']) - Number(jumlah.innerText) > 0) {
                                        basket[ukuran['id']].jumlah += 1;
                                        basket.total += Number(pakaian[index]['harga'])
                                        jumlah.innerText = basket[ukuran['id']].jumlah;
                                        totalInBasket.innerText = formatter.format(basket.total);
                                        inputJumlah.value = basket[ukuran['id']].jumlah;
                                        totalPembelianTotal.innerText = formatter.format(pakaian[index]['harga'] * basket[ukuran['id']].jumlah);
                                    }
                                    if (Number(ukuran['jumlah']) - Number(jumlah.innerText) <= 0) {
                                        buttonPlus.children[0].classList.add('text-muted');
                                        return;
                                    }
                                });

                                itemMinusJumlahPlus.append(buttonMinus);
                                itemMinusJumlahPlus.append(jumlah);
                                itemMinusJumlahPlus.append(buttonPlus);

                                containerItem.append(image);
                                containerItem.append(item);
                                containerItem.append(itemMinusJumlahPlus);

                                containerTotalPembelianPakaian.append(totalPembelianText);
                                containerTotalPembelianPakaian.append(totalPembelianTotal);

                                container.append(containerItem);
                                container.append(document.createElement('hr'));
                                container.append(containerTotalPembelianPakaian);

                                document.getElementById('in-basket').append(container);

                                document.querySelector('form').append(inputIdUkuranPakaian);
                                document.querySelector('form').append(inputJumlah);
                                document.querySelector('form').append(inputHarga);
                            }
                            inputHarga.value = Number(pakaian[index]['harga']);
                            inputIdUkuranPakaian.value = ukuran['id'];
                            inputJumlah.value = basket[ukuran['id']].jumlah;

                            document.getElementById('empty-basket').classList.add('d-none');
                            document.getElementById('basket').classList.remove('d-none');
                        });

                        tdUkuran.innerText = ukuran['nama'];
                        tdJumlahUkuran.innerText = ukuran['jumlah'];
                        if (Number(ukuran['jumlah']))
                            tdButtonMoveToBasket.append(buttonMoveToBasket);

                        if (!index_ukuran) {
                            tr.append(tdUkuran);
                            tr.append(tdJumlahUkuran);
                            tr.append(tdButtonMoveToBasket);
                            modalDetailPakaianTbody.append(tr);
                            return;
                        }

                        const newTr = document.createElement('tr');
                        newTr.classList.add('text-center')
                        newTr.append(tdUkuran);
                        newTr.append(tdJumlahUkuran);
                        newTr.append(tdButtonMoveToBasket);
                        modalDetailPakaianTbody.append(newTr);
                    });
                });
            }
        });
    });
</script>