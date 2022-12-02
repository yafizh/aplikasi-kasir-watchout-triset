<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3>Riwayat Penjualan</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="no-td">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">Total Penjualan</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                GROUP BY 
                                    p.id 
                                ORDER BY 
                                    p.id DESC 
                            ";
                            $result = $mysqli->query($query);
                            $riwayat_penjualan = $result->fetch_all(MYSQLI_ASSOC);
                            foreach ($riwayat_penjualan as $key => $value) {
                                $query = "
                                    SELECT 
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
                                        pt.id_penjualan=" . $value['id'];
                                $riwayat_penjualan[$key]['pakaian_terjual'] = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
                            }
                            $no = 1;
                            ?>
                            <?php foreach ($riwayat_penjualan as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= indonesiaDate($row['tanggal']); ?></td>
                                    <td class="text-center"><?= $row['waktu']; ?></td>
                                    <td class="text-center">Rp <?= number_format($row['total'], 0, ",", "."); ?></td>
                                    <td class="no-td">
                                        <button class="btn btn-info btn-sm text-white zzz" data-bs-toggle="modal" data-bs-target="#detail">Lihat</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="modal fade text-left" id="detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Riwayat Penjualan</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="detail-in-basket"></div>
                <hr>
                <div class="d-flex flex-column">
                    <div class="d-flex mb-3">
                        <h6 class="mb-0">Total Pembelian</h6>
                        <h6 class="text-end flex-grow-1 mb-0 total-pembelian">Rp 0</h6>
                    </div>
                    <div class="d-flex mb-3">
                        <h6 class="mb-0">Tunai</h6>
                        <h6 class="text-end flex-grow-1 mb-0 tunai">Rp 0</h6>
                    </div>
                    <div class="d-flex mb-3">
                        <h6 class="mb-0">Kembalian</h6>
                        <h6 class="text-end flex-grow-1 mb-0 kembalian">Rp 0</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="tombol-hapus" href="?halaman=hapus_riwayat_penjualan&id=<?= $row['id']; ?>" class="btn btn-danger" data-text="Menghapus riwayat penjualan akan berdampak pada jumlah stok pakaian!" data-button-text="Hapus Riwayat Penjualan!">Hapus</a>
                <a id="edit-btn" href="" class="btn btn-warning text-white">Edit</a>
                <a id="cetak-struk-btn" href="" target="_blank" class="btn btn-primary ml-1 text-white">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cetak Struk</span>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    const riwayat_penjualan = [];
    JSON.parse('<?= json_encode($riwayat_penjualan); ?>').forEach(riwayat => {
        riwayat_penjualan.push(riwayat);
    });
    document.querySelectorAll(".zzz").forEach((button, index_button) => {
        button.addEventListener('click', () => {
            document.getElementById('detail-in-basket').innerText = '';
            riwayat_penjualan[index_button]['pakaian_terjual'].forEach((value, index) => {
                document.getElementById('detail-in-basket').insertAdjacentHTML('beforeend', `
                    <div class="border border-2 rounded p-3 mb-1">
                        <div class="d-flex gap-3 justify-content-between flex-wrap">
                            <img src="${((location.host == 'localhost') ? (location.origin + '/' + pathparts[1].trim('/') + '/') : location.origin)}/app/halaman/${value.foto}" style="height: 6rem; aspect-ratio: 1; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">${value.nama}</h5>
                                <h6 class="mb-1">Warna ${value.warna}</h6>
                                <h6 class="text-muted">Ukuran ${value.ukuran}</h6>
                                <h6>${formatter.format(value.harga)}</h6>
                            </div>
                            <div class="d-flex align-self-center border">
                                <div class="d-flex justify-content-center align-items-center" style="aspect-ratio: 1;width: 2rem;">${value.jumlah}</div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <h6 class="mb-0">Total</h6>
                            <h6 class="text-end flex-grow-1 mb-0">${formatter.format(value.harga * value.jumlah)}</h6>
                        </div>
                    </div>
                `);
            });
            document.querySelector('.total-pembelian').innerText = formatter.format(riwayat_penjualan[index_button].total);
            document.querySelector('.tunai').innerText = formatter.format(riwayat_penjualan[index_button].tunai);
            document.querySelector('.kembalian').innerText = formatter.format(riwayat_penjualan[index_button].tunai - riwayat_penjualan[index_button].total);
            document.querySelector('#detail .modal-footer #cetak-struk-btn').setAttribute('href', `kasir/struk.php?id=${riwayat_penjualan[index_button]['id']}`)
            document.querySelector('#detail .modal-footer #edit-btn').setAttribute('href', `?halaman=edit_riwayat_penjualan&id=${riwayat_penjualan[index_button]['id']}`)
        });
    });
</script>