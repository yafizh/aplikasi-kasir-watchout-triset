<div id="main">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 mb-3">
                    <h3><?= $title; ?></h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 d-flex justify-content-end">
                    <a href="?halaman=tambah_diskon" class="btn btn-primary align-self-start text-white">Tambah</a>
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
                                <th class="text-center">Pakaian Terdaftar</th>
                                <th class="text-center no-td">Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $query = "
                            SELECT 
                                d.*,
                                (SELECT COUNT(*) FROM diskon_pakaian pd WHERE pd.id_diskon=d.id) pakaian 
                            FROM 
                                diskon d 
                            ORDER BY 
                                d.tanggal_mulai DESC
                        ";
                        $data = $mysqli->query($query);
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
                                        <td class="text-center">
                                            <?= $row['pakaian']; ?>
                                            |
                                            <a href="?halaman=diskon_pakaian&id_diskon=<?= $row['id']; ?>">Lihat</a>
                                        </td>
                                        <td class="no-td">
                                            <button onclick="broadcast('<?= $row['nama']; ?>','<?= indonesiaDate($row['tanggal_mulai']); ?>','<?= indonesiaDate($row['tanggal_selesai']); ?>')" class="btn btn-success btn-sm text-white" title="Broadcast">
                                                Broadcast
                                            </button>
                                            <a href="?halaman=edit_diskon&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white">Edit</i></a>
                                            <a id="tombol-hapus" href="?halaman=hapus_diskon&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" data-text="Menghapus diskon '<?= $row['nama']; ?>' akan membuat data riwayat penjualan dengan diskon '<?= $row['nama']; ?>' ikut terhapus!" data-button-text="Hapus Diskon!">
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

    const broadcast = async (promo, dari, sampai) => {
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
                message: `Halo ${item.nama}!\n\nPromo ${promo} menanti Anda! Dari tanggal ${dari} hingga ${sampai}, nikmati diskon besar-besaran untuk produk-produk tertentu kami! Kunjungi toko kami atau kunjungi situs web kami sekarang juga dan jangan lewatkan kesempatan ini untuk mendapatkan penawaran spesial.\n\nTerima kasih!`
            });

            alert('Berhasil membagikan notifikasi!')
        });
    }
</script>