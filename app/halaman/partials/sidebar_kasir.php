<?php
$result = $mysqli->query('SELECT * FROM merk ORDER BY nama');
$merk = $result->fetch_all(MYSQLI_ASSOC);
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative pb-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo text-center w-100">
                    <img src="../assets/images/logo.png" alt="Watchout Triset" srcset="">
                    <h4 class="text-primary">Watchout Triset</h4>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu Utama</li>
                <li class="sidebar-item <?= $active === 'kasir' ? 'active' : ''; ?>">
                    <a href="?" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Kasir</span>
                    </a>
                </li>
                <li class="sidebar-item has-sub <?= $active === 'cek_stok' ? 'active' : ''; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Stok Pakaian</span>
                    </a>
                    <ul class="submenu <?= $active === 'cek_stok' ? 'active' : ''; ?>">
                        <?php foreach ($merk as $value) : ?>
                            <li class="submenu-item <?= ($active === 'cek_stok' && $value['id'] == ($_GET['id_merk'] ?? '')) ? 'active' : '' ?>">
                                <a href="?halaman=cek_stok&id_merk=<?= $value['id']; ?>"><?= $value['nama']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="sidebar-item <?= $active === 'riwayat_penjualan' ? 'active' : ''; ?>">
                    <a href="?halaman=riwayat_penjualan" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Riwayat Penjualan</span>
                    </a>
                </li>
                <li class="sidebar-title">Pengaturan</li>

                <li class="sidebar-item  ">
                    <a href="form-layout.html" class='sidebar-link'>
                        <i class="fas fa-lock"></i>
                        <span>Ganti Password</span>
                    </a>
                </li>
                <li class="sidebar-item  ">
                    <a href="auth/logout.php" class='sidebar-link'>
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>