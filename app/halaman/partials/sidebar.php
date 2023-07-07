<?php
$result = $mysqli->query('SELECT * FROM merk ORDER BY nama');
$merk = $result->fetch_all(MYSQLI_ASSOC);
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active h-100">
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

                <li class="sidebar-item <?= $active === 'dashboard' ? 'active' : ''; ?>">
                    <a href="?" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item has-sub <?= ($active === 'pengguna' || $active === 'ganti_password') ? 'active' : ''; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="fas fa-users"></i>
                        <span>Pengguna</span>
                    </a>
                    <ul class="submenu <?= $active === 'pengguna' ? 'active' : ''; ?>">
                        <li class="submenu-item <?= ($active === 'pengguna' && ($sub_active ?? '') == 'admin') ? 'active' : '' ?>">
                            <a href="?halaman=admin">Admin</a>
                        </li>
                        <!-- <li class="submenu-item <?= (($active === 'pengguna' || $active === 'ganti_password') && ($sub_active ?? '') == 'gudang') ? 'active' : '' ?>">
                            <a href="?halaman=gudang">Gudang</a>
                        </li> -->
                        <li class="submenu-item <?= (($active === 'pengguna' || $active === 'ganti_password') && ($sub_active ?? '') == 'kasir') ? 'active' : '' ?>">
                            <a href="?halaman=kasir">Kasir</a>
                        </li>
                        <li class="submenu-item <?= (($active === 'pengguna' || $active === 'ganti_password') && ($sub_active ?? '') == 'pembeli') ? 'active' : '' ?>">
                            <a href="?halaman=pembeli">Pembeli</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-title">Master Data</li>
                <li class="sidebar-item <?= $active === 'kategori_pakaian' ? 'active' : ''; ?>">
                    <a href="?halaman=kategori_pakaian" class='sidebar-link'>
                        <i class="fas fa-th-list"></i>
                        <span>Kategori Pakaian</span>
                    </a>
                </li>
                <li class="sidebar-item <?= $active === 'merk' ? 'active' : ''; ?>">
                    <a href="?halaman=merk" class='sidebar-link'>
                        <i class="fas fa-copyright"></i>
                        <span>Merk</span>
                    </a>
                </li>
                <li class="sidebar-title">Menu Pakaian</li>
                <li class="sidebar-item <?= $active === 'pakaian' ? 'active' : ''; ?>">
                    <a href="?halaman=pakaian" class='sidebar-link'>
                        <i class="fas fa-copyright"></i>
                        <span>Data Pakaian</span>
                    </a>
                </li>
                <li class="sidebar-item has-sub <?= $active === 'stok' ? 'active' : ''; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="fas fa-cubes"></i>
                        <span>Stok Pakaian</span>
                    </a>
                    <ul class="submenu <?= $active === 'stok' ? 'active' : ''; ?>">
                        <li class="submenu-item <?= ($active === 'stok' && ($sub_active ?? '') === 'stok_pakaian') ? 'active' : ''; ?>">
                            <a href="?halaman=stok">Stok</a>
                        </li>
                        <li class="submenu-item <?= ($active === 'stok' && ($sub_active ?? '') === 'riwayat_penambahan_stok') ? 'active' : ''; ?>">
                            <a href="?halaman=riwayat_penambahan_stok">Riwayat Barang Masuk</a>
                        </li>
                        <li class="submenu-item <?= ($active === 'stok' && ($sub_active ?? '') === 'riwayat_barang_keluar') ? 'active' : ''; ?>">
                            <a href="?halaman=riwayat_barang_keluar">Riwayat Barang Keluar</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title">Menu Diskon</li>
                <li class="sidebar-item <?= $active === 'diskon' ? 'active' : ''; ?>">
                    <a href="?halaman=diskon" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Diskon Pakaian</span>
                    </a>
                </li>
                <li class="sidebar-item <?= $active === 'voucher_diskon' ? 'active' : ''; ?>">
                    <a href="?halaman=voucher_diskon" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Voucher Diskon</span>
                    </a>
                </li>

                <li class="sidebar-title">Laporan</li>
                <li class="sidebar-item has-sub <?= ($active === 'laporan') ? 'active' : ''; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="fas fa-file"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="submenu <?= $active === 'laporan' ? 'active' : ''; ?>">
                        <li class="submenu-item <?= (($active === 'laporan') && ($sub_active ?? '') == 'laporan_pakaian') ? 'active' : '' ?>">
                            <a href="?halaman=laporan_pakaian">Laporan Pakaian</a>
                        </li>
                        <li class="submenu-item <?= ($active === 'laporan' && ($sub_active ?? '') == 'laporan_penjualan') ? 'active' : '' ?>">
                            <a href="?halaman=laporan_penjualan">Laporan Penjualan</a>
                        </li>
                        <li class="submenu-item <?= ($active === 'laporan' && ($sub_active ?? '') == 'laporan_penjualan_online') ? 'active' : '' ?>">
                            <a href="?halaman=laporan_penjualan_online">Laporan Penjualan Online</a>
                        </li>
                        <li class="submenu-item <?= (($active === 'laporan') && ($sub_active ?? '') == 'laporan_barang_masuk') ? 'active' : '' ?>">
                            <a href="?halaman=laporan_barang_masuk">Laporan Barang Masuk</a>
                        </li>
                        <li class="submenu-item <?= (($active === 'laporan') && ($sub_active ?? '') == 'laporan_barang_keluar') ? 'active' : '' ?>">
                            <a href="?halaman=laporan_barang_keluar">Laporan Barang Keluar</a>
                        </li>
                        <li class="submenu-item <?= (($active === 'laporan') && ($sub_active ?? '') == 'laporan_mutasi_pakaian') ? 'active' : '' ?>">
                            <a href="?halaman=laporan_mutasi_pakaian">Laporan Mutasi Pakaian</a>
                        </li>
                        <li class="submenu-item <?= (($active === 'laporan') && ($sub_active ?? '') == '#') ? 'active' : '' ?>">
                            <a href="#">Laporan Keuangan</a>
                        </li>
                        <li class="submenu-item <?= (($active === 'laporan') && ($sub_active ?? '') == '#') ? 'active' : '' ?>">
                            <a href="#">Laporan Pakain Terlaris</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title">Pengaturan</li>

                <li class="sidebar-item <?= $active === 'ganti_password_sendiri' ? 'active' : ''; ?>">
                    <a href="?halaman=ganti_password" class='sidebar-link'>
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