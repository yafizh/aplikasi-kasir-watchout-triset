<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3><?= $title; ?></h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_voucher_diskon" class="btn btn-primary align-self-start text-white">Tambah</a>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table id="table1" class="table">
                        <thead>
                            <tr>
                                <th class="no-td">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Tanggal Mulai</th>
                                <th class="text-center">Tanggal Selesai</th>
                                <th class="text-center">Pengurangan Harga</th>
                                <th class="text-center">Kode Voucher</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $data = $mysqli->query("SELECT * FROM voucher_diskon ORDER BY tanggal_mulai DESC");
                        $no = 1;
                        ?>
                        <tbody>
                            <?php if ($data->num_rows) : ?>
                                <?php while ($row = $data->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center"><?= indonesiaDate($row['tanggal_mulai']); ?></td>
                                        <td class="text-center"><?= indonesiaDate($row['tanggal_selesai']); ?></td>
                                        <td class="text-center"><?= number_format($row['diskon'], 0, ",", "."); ?><?= $row['jenis_diskon'] == 1 ? '' : '%' ?></td>
                                        <td class="text-center"><?= $row['kode_voucher']; ?></td>
                                        <td class="no-td">
                                            <button onclick="broadcast('<?= $row['kode_voucher']; ?>','<?= indonesiaDate($row['tanggal_mulai']); ?>','<?= indonesiaDate($row['tanggal_selesai']); ?>')" class="btn btn-success btn-sm text-white" title="Broadcast">
                                                Broadcast
                                            </button>
                                            <a href="?halaman=edit_voucher_diskon&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                                            <a id="tombol-hapus" href="?halaman=hapus_voucher_diskon&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" data-text="Menghapus voucher diskon '<?= $row['nama']; ?>' akan membuat data riwayat penjualan dengan voucher diskon '<?= $row['nama']; ?>' ikut terhapus!" data-button-text="Hapus Voucher Diskon!">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
$result = $mysqli->query("SELECT * FROM pembeli");
$pembeli = $result->fetch_all(MYSQLI_ASSOC);
?>
<script>
    const pembeli = JSON.parse('<?= json_encode($pembeli); ?>');
    async function postData(url = "", data = {}) {
        // Default options are marked with *
        const response = await fetch(url, {
            method: "POST", // *GET, POST, PUT, DELETE, etc.
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(Object.entries(data)).toString(), // body data type must match "Content-Type" header
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }

    const broadcast = async (kode, dari, sampai) => {
        pembeli.forEach(async (item) => {
            let nomor_telepon = item.nomor_telepon;
            if (nomor_telepon[0] == '0') {
                nomor_telepon = `62${item.nomor_telepon.substr(1)}`
            }
            if (nomor_telepon[0] == '+') {
                nomor_telepon = `${item.nomor_telepon.substr(1)}`
            }
            const response = await postData("http://localhost:8000/send-message", {
                number: `${nomor_telepon}@c.us`,
                message: `Halo ${item.nama}!\n\nKami punya promo spesial dengan kode voucher "${kode}". Dapatkan diskon ekstra untuk semua pembelian Anda dari tanggal ${dari} hingga ${sampai}. Jangan lewatkan kesempatan ini untuk berbelanja hemat di toko kami. Kunjungi kami sekarang dan gunakan kode voucher tersebut saat check-out.\n\nTerima kasih`
            });

            alert('Berhasil membagikan notifikasi!')
        });
    }
</script>