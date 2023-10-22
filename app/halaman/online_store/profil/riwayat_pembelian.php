<div class="row">
    <div class="col-12 col-md-4 mb-3">
        <div class="nav flex-column nav-pills me-3" aria-orientation="vertical">
            <a href="?halaman=riwayat_pembelian&status=1" class="nav-link text-start <?= (($_GET['status'] ?? 1) == 1) ? 'active' : '' ?>">Menunggu Pembayaran</a>
            <a href="?halaman=riwayat_pembelian&status=2" class="nav-link text-start <?= (($_GET['status'] ?? 1) == 2) ? 'active' : '' ?>">Pesanan Diproses</a>
            <a href="?halaman=riwayat_pembelian&status=3" class="nav-link text-start <?= (($_GET['status'] ?? 1) == 3) ? 'active' : '' ?>">Pesanan Selesai</a>
            <a href="?halaman=riwayat_pembelian&status=4" class="nav-link text-start <?= (($_GET['status'] ?? 1) == 4) ? 'active' : '' ?>">Pesanan Dibatalkan</a>
            <a href="?halaman=riwayat_pembelian&status=5" class="nav-link text-start <?= (($_GET['status'] ?? 1) == 5) ? 'active' : '' ?>">Pesanan Dikembalikan</a>
        </div>
    </div>
    <div class="col-12 col-md-8">
        <div class="d-flex align-items-start">
            <?php if (($_GET['status'] ?? 1) == 1) : ?>
                <?php
                $query = "
                    SELECT 
                        * 
                    FROM 
                        penjualan_online 
                    WHERE 
                        id_pembeli=" . $_SESSION['user']['pembeli']['id'] . " 
                        AND 
                        status=1 
                    ORDER BY 
                        tanggal_waktu DESC 
                ";
                $result = $mysqli->query($query);
                $penjualan_online = $result->fetch_all(MYSQLI_ASSOC);

                foreach ($penjualan_online as $key => $value) {
                    $query = "
                        SELECT 
                            (SELECT nama FROM pakaian WHERE id=wp.id_pakaian) nama_pakaian,
                            (SELECT foto FROM foto_pakaian WHERE id_warna_pakaian=wp.id LIMIT 1) foto_pakaian,
                            wp.warna,
                            up.ukuran,
                            dpo.jumlah,
                            dpo.harga_toko,
                            dpo.harga_penjualan 
                        FROM 
                            detail_penjualan_online dpo  
                        INNER JOIN 
                            ukuran_warna_pakaian uwp 
                        ON 
                            uwp.id=dpo.id_ukuran_warna_pakaian 
                        INNER JOIN 
                            ukuran_pakaian up 
                        ON 
                            up.id=uwp.id_ukuran_pakaian 
                        INNER JOIN 
                            warna_pakaian wp 
                        ON 
                            wp.id=uwp.id_warna_pakaian 
                        WHERE 
                            dpo.id_penjualan_online=" . $value['id'] . " 
                    ";

                    $result = $mysqli->query($query);
                    $penjualan_online[$key]['pakaian'] = $result->fetch_all(MYSQLI_ASSOC);
                }
                ?>
                <div class="row w-100">
                    <?php if (count($penjualan_online)) : ?>
                        <?php foreach ($penjualan_online as $item) : ?>
                            <div class="card col-12 mb-3">
                                <div class="card-body">
                                    <?php foreach ($item['pakaian'] as $pakaian) : ?>
                                        <div class="row mb-3">
                                            <div class="col-12 col-md-8 d-flex">
                                                <div style="width: 8rem; height: 8rem;">
                                                    <img src="<?= '../' . $pakaian['foto_pakaian']; ?>" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                                </div>
                                                <div class="p-3">
                                                    <h5><?= $pakaian['nama_pakaian']; ?></h5>
                                                    <h6 class="text-muted mb-1">Warna: <?= $pakaian['warna']; ?></h6>
                                                    <h6 class="text-muted mb-1">Ukuran: <?= $pakaian['ukuran']; ?></h6>
                                                    <h6 class="text-muted mb-1">Jumlah: <?= $pakaian['jumlah']; ?></h6>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12 align-items-end flex-column justify-content-center d-flex">
                                                <?php if ($pakaian['harga_toko'] != $pakaian['harga_penjualan']) : ?>
                                                    <p class="mb-0"><del>Rp <?= number_format($pakaian['harga_toko'], 0, ",", "."); ?></del></p>
                                                <?php endif; ?>
                                                <h5>Rp <?= number_format($pakaian['harga_penjualan'], 0, ",", "."); ?></h5>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <hr>
                                    <div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Sub Total</h5>
                                            <h5>Rp <?= number_format($item['harga_total'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Voucher Diskon</h5>
                                            <h5>Rp <?= number_format($item['harga_total']  - $item['harga_penjualan'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h4>Total</h4>
                                            <h4>Rp <?= number_format($item['harga_penjualan'], 0, ",", "."); ?></h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="?halaman=riwayat_pembelian&status=4&id=<?= $item['id']; ?>" class="btn btn-danger">Batalkan Pesanan</a>
                                        <button data-snap_token="<?= $item['snap_token']; ?>" data-id="<?= $item['id']; ?>" class="checkout btn btn-primary text-white">Lakukan Pembayaran</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 mt-5">
                            <h5 class="text-center">Tidak Ada Pesanan</h5>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (($_GET['status'] ?? 1) == 2) : ?>
                <?php
                if (isset($_GET['id'])) {
                    $mysqli->query("UPDATE penjualan_online SET status=2 WHERE id=" . $_GET['id']);
                    $mysqli->query("INSERT INTO status_pengiriman (id_penjualan_online, status, keterangan) VALUES ('" . $_GET['id'] . "','1','')");
                    $q = "
                        SELECT 
                            dpod.id_diskon 
                        FROM 
                            penjualan_online po 
                        INNER JOIN 
                            detail_penjualan_online dpo 
                        ON 
                            dpo.id_penjualan_online=po.id 
                        LEFT JOIN 
                            detail_penjualan_online_diskon dpod 
                        ON 
                            dpod.id_detail_penjualan_online=dpo.id 
                        WHERE 
                            po.id=" . $_GET['id'];

                    $result = $mysqli->query($q);
                    $detail_penjualan_online = $result->fetch_assoc();
                    if (!is_null($detail_penjualan_online['id_diskon'])) {
                        $mysqli->query("INSERT INTO pengguna_diskon VALUES (null, " . $_SESSION['user']['id'] . "," . $detail_penjualan_online['id_diskon'] . ")");
                    }

                    $q = "
                        SELECT 
                            dpod.id_voucher_diskon 
                        FROM 
                            penjualan_online po 
                        LEFT JOIN 
                            penjualan_online_voucher_diskon dpod 
                        ON 
                            dpod.id_penjualan_online=po.id 
                        WHERE 
                            po.id=" . $_GET['id'];

                    $result = $mysqli->query($q);
                    $penjualan_online = $result->fetch_assoc();
                    if (!is_null($penjualan_online['id_voucher_diskon'])) {
                        $mysqli->query("INSERT INTO pengguna_voucer_diskon VALUES (null, " . $_SESSION['user']['id'] . "," . $penjualan_online['id_voucher_diskon'] . ")");
                    }
                }
                ?>
                <?php
                $query = "
                    SELECT 
                        penjualan_online.*,
                        status_pengiriman.status status_pengiriman
                    FROM 
                        penjualan_online 
                    INNER JOIN 
                        status_pengiriman 
                    ON 
                        status_pengiriman.id_penjualan_online=penjualan_online.id 
                    WHERE 
                        penjualan_online.id_pembeli=" . $_SESSION['user']['pembeli']['id'] . " 
                        AND 
                        penjualan_online.status = 2 
                    ORDER BY 
                        tanggal_waktu DESC 
                ";
                $result = $mysqli->query($query);
                $penjualan_online = $result->fetch_all(MYSQLI_ASSOC);

                foreach ($penjualan_online as $key => $value) {
                    $query = "
                        SELECT 
                            (SELECT nama FROM pakaian WHERE id=wp.id_pakaian) nama_pakaian,
                            (SELECT foto FROM foto_pakaian WHERE id_warna_pakaian=wp.id LIMIT 1) foto_pakaian,
                            wp.warna,
                            up.ukuran,
                            dpo.jumlah,
                            dpo.harga_toko,
                            dpo.harga_penjualan
                        FROM 
                            detail_penjualan_online dpo  
                        INNER JOIN 
                            ukuran_warna_pakaian uwp 
                        ON 
                            uwp.id=dpo.id_ukuran_warna_pakaian 
                        INNER JOIN 
                            ukuran_pakaian up 
                        ON 
                            up.id=uwp.id_ukuran_pakaian 
                        INNER JOIN 
                            warna_pakaian wp 
                        ON 
                            wp.id=uwp.id_warna_pakaian 
                        WHERE 
                            dpo.id_penjualan_online=" . $value['id'] . " 
                    ";

                    $result = $mysqli->query($query);
                    $penjualan_online[$key]['pakaian'] = $result->fetch_all(MYSQLI_ASSOC);
                }
                ?>
                <div class="row w-100">
                    <?php if (count($penjualan_online)) : ?>
                        <?php foreach ($penjualan_online as $item) : ?>
                            <div class="card col-12 mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end gap-2">
                                        <span class="badge text-bg-success">
                                            <?php if ($item['metode_pembayaran'] == 1) : ?>
                                                Transfer
                                            <?php elseif ($item['metode_pembayaran'] == 2) : ?>
                                                COD
                                            <?php endif; ?>
                                        </span>
                                        <span class="badge text-bg-info">
                                            <?php if ($item['status_pengiriman'] == 1) : ?>
                                                Sedang Disiapkan
                                            <?php elseif ($item['status_pengiriman'] == 2) : ?>
                                                Dalam Perjalanan
                                            <?php elseif ($item['status_pengiriman'] == 3) : ?>
                                                Telah Sampai
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <?php foreach ($item['pakaian'] as $pakaian) : ?>
                                        <div class="d-flex mb-3">
                                            <div class="flex-grow-1 d-flex">
                                                <div style="width: 8rem; height: 8rem;">
                                                    <img src="<?= '../' . $pakaian['foto_pakaian']; ?>" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                                </div>
                                                <div class="p-3">
                                                    <h5><?= $pakaian['nama_pakaian']; ?></h5>
                                                    <h6 class="text-muted mb-1">Warna: <?= $pakaian['warna']; ?></h6>
                                                    <h6 class="text-muted mb-1">Ukuran: <?= $pakaian['ukuran']; ?></h6>
                                                    <h6 class="text-muted mb-1">Jumlah: <?= $pakaian['jumlah']; ?></h6>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end flex-column justify-content-center">
                                                <?php if ($pakaian['harga_toko'] != $pakaian['harga_penjualan']) : ?>
                                                    <p class="mb-0"><del>Rp <?= number_format($pakaian['harga_toko'], 0, ",", "."); ?></del></p>
                                                <?php endif; ?>
                                                <h5>Rp <?= number_format($pakaian['harga_penjualan'], 0, ",", "."); ?></h5>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <hr>
                                    <div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Sub Total</h5>
                                            <h5>Rp <?= number_format($item['harga_total'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Voucher Diskon</h5>
                                            <h5>Rp <?= number_format($item['harga_total']  - $item['harga_penjualan'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h4>Total</h4>
                                            <h4>Rp <?= number_format($item['harga_penjualan'], 0, ",", "."); ?></h4>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 mt-5">
                            <h5 class="text-center">Tidak Ada Pesanan</h5>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (($_GET['status'] ?? 1) == 3) : ?>
                <?php
                $query = "
                    SELECT 
                        * 
                    FROM 
                        penjualan_online 
                    WHERE 
                        id_pembeli=" . $_SESSION['user']['pembeli']['id'] . " 
                        AND 
                        status = 3
                    ORDER BY 
                        tanggal_waktu DESC 
                ";
                $result = $mysqli->query($query);
                $penjualan_online = $result->fetch_all(MYSQLI_ASSOC);

                foreach ($penjualan_online as $key => $value) {
                    $query = "
                        SELECT 
                            (SELECT nama FROM pakaian WHERE id=wp.id_pakaian) nama_pakaian,
                            (SELECT foto FROM foto_pakaian WHERE id_warna_pakaian=wp.id LIMIT 1) foto_pakaian,
                            wp.warna,
                            up.ukuran,
                            dpo.jumlah,
                            dpo.harga_toko,
                            dpo.harga_penjualan 
                        FROM 
                            detail_penjualan_online dpo  
                        INNER JOIN 
                            ukuran_warna_pakaian uwp 
                        ON 
                            uwp.id=dpo.id_ukuran_warna_pakaian 
                        INNER JOIN 
                            ukuran_pakaian up 
                        ON 
                            up.id=uwp.id_ukuran_pakaian 
                        INNER JOIN 
                            warna_pakaian wp 
                        ON 
                            wp.id=uwp.id_warna_pakaian 
                        WHERE 
                            dpo.id_penjualan_online=" . $value['id'] . " 
                    ";

                    $result = $mysqli->query($query);
                    $penjualan_online[$key]['pakaian'] = $result->fetch_all(MYSQLI_ASSOC);
                }
                ?>
                <div class="row w-100">
                    <?php if (count($penjualan_online)) : ?>
                        <?php foreach ($penjualan_online as $item) : ?>
                            <div class="card col-12 mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end">
                                        <span class="badge text-bg-success">
                                            <?php if ($item['metode_pembayaran'] == 1) : ?>
                                                Transfer
                                            <?php elseif ($item['metode_pembayaran'] == 2) : ?>
                                                COD
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <?php foreach ($item['pakaian'] as $pakaian) : ?>
                                        <div class="d-flex mb-3">
                                            <div class="flex-grow-1 d-flex">
                                                <div style="width: 8rem; height: 8rem;">
                                                    <img src="<?= '../' . $pakaian['foto_pakaian']; ?>" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                                </div>
                                                <div class="p-3">
                                                    <h5><?= $pakaian['nama_pakaian']; ?></h5>
                                                    <h6 class="text-muted mb-1">Warna: <?= $pakaian['warna']; ?></h6>
                                                    <h6 class="text-muted mb-1">Ukuran: <?= $pakaian['ukuran']; ?></h6>
                                                    <h6 class="text-muted mb-1">Jumlah: <?= $pakaian['jumlah']; ?></h6>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end flex-column justify-content-center">
                                                <?php if ($pakaian['harga_toko'] != $pakaian['harga_penjualan']) : ?>
                                                    <p class="mb-0"><del>Rp <?= number_format($pakaian['harga_toko'], 0, ",", "."); ?></del></p>
                                                <?php endif; ?>
                                                <h5>Rp <?= number_format($pakaian['harga_penjualan'], 0, ",", "."); ?></h5>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <hr>
                                    <div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Sub Total</h5>
                                            <h5>Rp <?= number_format($item['harga_total'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Voucher Diskon</h5>
                                            <h5>Rp <?= number_format($item['harga_total']  - $item['harga_penjualan'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h4>Total</h4>
                                            <h4>Rp <?= number_format($item['harga_penjualan'], 0, ",", "."); ?></h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="?halaman=riwayat_pembelian&status=5&id=<?= $item['id']; ?>" class="btn btn-danger">Return Barang</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 mt-5">
                            <h5 class="text-center">Tidak Ada Pesanan</h5>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (($_GET['status'] ?? 1) == 4) : ?>
                <?php
                if (isset($_GET['id'])) {
                    $mysqli->query("UPDATE penjualan_online SET status=4 WHERE id=" . $_GET['id']);
                }
                ?>
                <?php
                $query = "
                    SELECT 
                        * 
                    FROM 
                        penjualan_online 
                    WHERE 
                        id_pembeli=" . $_SESSION['user']['pembeli']['id'] . " 
                        AND 
                        status = 4
                    ORDER BY 
                        tanggal_waktu DESC 
                ";
                $result = $mysqli->query($query);
                $penjualan_online = $result->fetch_all(MYSQLI_ASSOC);

                foreach ($penjualan_online as $key => $value) {
                    $query = "
                        SELECT 
                            (SELECT nama FROM pakaian WHERE id=wp.id_pakaian) nama_pakaian,
                            (SELECT foto FROM foto_pakaian WHERE id_warna_pakaian=wp.id LIMIT 1) foto_pakaian,
                            wp.warna,
                            up.ukuran,
                            dpo.jumlah,
                            dpo.harga_toko,
                            dpo.harga_penjualan 
                        FROM 
                            detail_penjualan_online dpo  
                        INNER JOIN 
                            ukuran_warna_pakaian uwp 
                        ON 
                            uwp.id=dpo.id_ukuran_warna_pakaian 
                        INNER JOIN 
                            ukuran_pakaian up 
                        ON 
                            up.id=uwp.id_ukuran_pakaian 
                        INNER JOIN 
                            warna_pakaian wp 
                        ON 
                            wp.id=uwp.id_warna_pakaian 
                        WHERE 
                            dpo.id_penjualan_online=" . $value['id'] . " 
                    ";

                    $result = $mysqli->query($query);
                    $penjualan_online[$key]['pakaian'] = $result->fetch_all(MYSQLI_ASSOC);
                }
                ?>
                <div class="row w-100">
                    <?php if (count($penjualan_online)) : ?>
                        <?php foreach ($penjualan_online as $item) : ?>
                            <div class="card col-12 mb-3">
                                <div class="card-body">
                                    <?php foreach ($item['pakaian'] as $pakaian) : ?>
                                        <div class="d-flex mb-3">
                                            <div class="flex-grow-1 d-flex">
                                                <div style="width: 8rem; height: 8rem;">
                                                    <img src="<?= '../' . $pakaian['foto_pakaian']; ?>" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                                </div>
                                                <div class="p-3">
                                                    <h5><?= $pakaian['nama_pakaian']; ?></h5>
                                                    <h6 class="text-muted mb-1">Warna: <?= $pakaian['warna']; ?></h6>
                                                    <h6 class="text-muted mb-1">Ukuran: <?= $pakaian['ukuran']; ?></h6>
                                                    <h6 class="text-muted mb-1">Jumlah: <?= $pakaian['jumlah']; ?></h6>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end flex-column justify-content-center">
                                                <?php if ($pakaian['harga_toko'] != $pakaian['harga_penjualan']) : ?>
                                                    <p class="mb-0"><del>Rp <?= number_format($pakaian['harga_toko'], 0, ",", "."); ?></del></p>
                                                <?php endif; ?>
                                                <h5>Rp <?= number_format($pakaian['harga_penjualan'], 0, ",", "."); ?></h5>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <hr>
                                    <div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Sub Total</h5>
                                            <h5>Rp <?= number_format($item['harga_total'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Voucher Diskon</h5>
                                            <h5>Rp <?= number_format($item['harga_total']  - $item['harga_penjualan'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h4>Total</h4>
                                            <h4>Rp <?= number_format($item['harga_penjualan'], 0, ",", "."); ?></h4>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 mt-5">
                            <h5 class="text-center">Tidak Ada Pesanan</h5>
                        </div>
                    <?php endif; ?>
                </div>
            <?php elseif (($_GET['status'] ?? 1) == 5) : ?>
                <?php
                if (isset($_GET['id'])) {
                    $mysqli->query("UPDATE penjualan_online SET status=5 WHERE id=" . $_GET['id']);
                }
                ?>
                <?php
                $query = "
                    SELECT 
                        * 
                    FROM 
                        penjualan_online 
                    WHERE 
                        id_pembeli=" . $_SESSION['user']['pembeli']['id'] . " 
                        AND 
                        status = 5
                    ORDER BY 
                        tanggal_waktu DESC 
                ";
                $result = $mysqli->query($query);
                $penjualan_online = $result->fetch_all(MYSQLI_ASSOC);

                foreach ($penjualan_online as $key => $value) {
                    $query = "
                        SELECT 
                            (SELECT nama FROM pakaian WHERE id=wp.id_pakaian) nama_pakaian,
                            (SELECT foto FROM foto_pakaian WHERE id_warna_pakaian=wp.id LIMIT 1) foto_pakaian,
                            wp.warna,
                            up.ukuran,
                            dpo.jumlah,
                            dpo.harga_toko,
                            dpo.harga_penjualan 
                        FROM 
                            detail_penjualan_online dpo  
                        INNER JOIN 
                            ukuran_warna_pakaian uwp 
                        ON 
                            uwp.id=dpo.id_ukuran_warna_pakaian 
                        INNER JOIN 
                            ukuran_pakaian up 
                        ON 
                            up.id=uwp.id_ukuran_pakaian 
                        INNER JOIN 
                            warna_pakaian wp 
                        ON 
                            wp.id=uwp.id_warna_pakaian 
                        WHERE 
                            dpo.id_penjualan_online=" . $value['id'] . " 
                    ";

                    $result = $mysqli->query($query);
                    $penjualan_online[$key]['pakaian'] = $result->fetch_all(MYSQLI_ASSOC);
                }
                ?>
                <div class="row w-100">
                    <?php if (count($penjualan_online)) : ?>
                        <?php foreach ($penjualan_online as $item) : ?>
                            <div class="card col-12 mb-3">
                                <div class="card-body">
                                    <?php foreach ($item['pakaian'] as $pakaian) : ?>
                                        <div class="d-flex mb-3">
                                            <div class="flex-grow-1 d-flex">
                                                <div style="width: 8rem; height: 8rem;">
                                                    <img src="<?= '../' . $pakaian['foto_pakaian']; ?>" class="rounded" style="width: 100%; height: 8rem; object-fit: cover;">
                                                </div>
                                                <div class="p-3">
                                                    <h5><?= $pakaian['nama_pakaian']; ?></h5>
                                                    <h6 class="text-muted mb-1">Warna: <?= $pakaian['warna']; ?></h6>
                                                    <h6 class="text-muted mb-1">Ukuran: <?= $pakaian['ukuran']; ?></h6>
                                                    <h6 class="text-muted mb-1">Jumlah: <?= $pakaian['jumlah']; ?></h6>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end flex-column justify-content-center">
                                                <?php if ($pakaian['harga_toko'] != $pakaian['harga_penjualan']) : ?>
                                                    <p class="mb-0"><del>Rp <?= number_format($pakaian['harga_toko'], 0, ",", "."); ?></del></p>
                                                <?php endif; ?>
                                                <h5>Rp <?= number_format($pakaian['harga_penjualan'], 0, ",", "."); ?></h5>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <hr>
                                    <div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Sub Total</h5>
                                            <h5>Rp <?= number_format($item['harga_total'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5>Voucher Diskon</h5>
                                            <h5>Rp <?= number_format($item['harga_total']  - $item['harga_penjualan'], 0, ",", "."); ?></h5>
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <h4>Total</h4>
                                            <h4>Rp <?= number_format($item['harga_penjualan'], 0, ",", "."); ?></h4>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 mt-5">
                            <h5 class="text-center">Tidak Ada Pesanan</h5>
                        </div>
                    <?php endif; ?>
                </div>
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-EmTzU8jLumgsYI05"></script>
<script>
    document.querySelectorAll('.checkout').forEach(elm => {
        elm.addEventListener('click', () => {
            console.log(elm.getAttribute('data-snap_token'))
            window.snap.pay(elm.getAttribute('data-snap_token'), {
                onSuccess: function(result) {
                    location.href = 'profil.php?halaman=riwayat_pembelian&status=2&id=' + elm.getAttribute('data-id');
                    console.log(result);
                },
                onPending: function(result) {
                    // alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    // alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    location.href = 'profil.php?halaman=riwayat_pembelian'
                    // alert('you closed the popup without finishing the payment');
                }
            })
        })
    })
</script>