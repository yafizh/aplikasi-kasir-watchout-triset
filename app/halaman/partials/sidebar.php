<?php
$result = $mysqli->query('SELECT * FROM jenis_pakaian ORDER BY nama');
$data = $result->fetch_all(MYSQLI_ASSOC);
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

                <li class="sidebar-item">
                    <a href="index.html" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="fas fa-users"></i>
                        <span>Pengguna</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item ">
                            <a href="?halaman=admin">Admin</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="?halaman=kasir">Kasir</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-sub <?= $active === 'pakaian' ? 'active' : ''; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="fas fa-tshirt"></i>
                        <span>Data Pakaian</span>
                    </a>
                    <ul class="submenu <?= $active === 'pakaian' ? 'active' : ''; ?>">
                        <?php foreach ($data as $jenis_pakaian) : ?>
                            <li class="submenu-item <?= ($active === 'pakaian' && $jenis_pakaian['id'] == ($_GET['id_jenis_pakaian'] ?? '')) ? 'active' : ''; ?>">
                                <a href="?halaman=pakaian&id_jenis_pakaian=<?= $jenis_pakaian['id']; ?>"><?= $jenis_pakaian['nama']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
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
                            <a href="?halaman=riwayat_penambahan_stok">Riwayat Penambahan Stok</a>
                        </li>
                    </ul>
                </li>


                <li class="sidebar-title">Master Data</li>
                <li class="sidebar-item <?= $active === 'jenis_pakaian' ? 'active' : ''; ?>">
                    <a href="?halaman=jenis_pakaian" class='sidebar-link'>
                        <i class="fas fa-th-list"></i>
                        <span>Jenis Pakaian</span>
                    </a>
                </li>
                <li class="sidebar-item <?= $active === 'merk' ? 'active' : ''; ?>">
                    <a href="?halaman=merk" class='sidebar-link'>
                        <i class="fas fa-copyright"></i>
                        <span>Merk</span>
                    </a>
                </li>
                <li class="sidebar-item has-sub <?= $active === 'ukuran' ? 'active' : ''; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="fas fa-tags"></i>
                        <span>Ukuran</span>
                    </a>
                    <ul class="submenu <?= $active === 'ukuran' ? 'active' : ''; ?>">
                        <?php foreach ($data as $jenis_pakaian) : ?>
                            <li class="submenu-item <?= ($active === 'ukuran' && $jenis_pakaian['id'] == ($_GET['id_jenis_pakaian'] ?? '')) ? 'active' : ''; ?>">
                                <a href="?halaman=ukuran&id_jenis_pakaian=<?= $jenis_pakaian['id']; ?>"><?= $jenis_pakaian['nama']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <li class="sidebar-title">Pengaturan</li>

                <li class="sidebar-item  ">
                    <a href="form-layout.html" class='sidebar-link'>
                        <i class="fas fa-lock"></i>
                        <span>Ganti Password</span>
                    </a>
                </li>
                <li class="sidebar-item  ">
                    <a href="form-layout.html" class='sidebar-link'>
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </a>
                </li>


            </ul>
        </div>
    </div>
</div>