<div id="main">
    <h3 class="mb-3">Profile Statistics</h3>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <?php $kasir = $mysqli->query("SELECT * FROM kasir"); ?>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Kasir</h6>
                                        <h6 class="font-extrabold mb-0"><?= $kasir->num_rows; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <?php $pakaian = $mysqli->query("SELECT * FROM pakaian"); ?>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Pakaian</h6>
                                        <h6 class="font-extrabold mb-0"><?= $pakaian->num_rows; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <?php $jenis_pakaian = $mysqli->query("SELECT * FROM jenis_pakaian"); ?>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jenis Pakaian</h6>
                                        <h6 class="font-extrabold mb-0"><?= $jenis_pakaian->num_rows; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <?php $merk = $mysqli->query("SELECT * FROM merk"); ?>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Merk Pakaian</h6>
                                        <h6 class="font-extrabold mb-0"><?= $merk->num_rows; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Penjualan</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
$query = "
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='1' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='2' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='3' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='4' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='5' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='6' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='7' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='8' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='9' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='10' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='11' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
        UNION ALL
        SELECT (SELECT COUNT(*) FROM penjualan WHERE MONTH(tanggal_waktu_penjualan)='12' AND YEAR(tanggal_waktu_penjualan)='" . Date('Y') . "') penjualan
    ";
$penjualan = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
$sales = [];
foreach ($penjualan as $value) {
    $sales[] = $value['penjualan'];
}
?>
<script>
    const sales = JSON.parse('<?= json_encode($sales); ?>');
</script>