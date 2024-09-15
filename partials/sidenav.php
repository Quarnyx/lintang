<!-- ========== Menu ========== -->
<div class="app-menu">

    <!-- Brand Logo -->
    <div class="logo-box">
        <!-- Brand Logo Light -->
        <a href="index.php" class="logo-light">
            <img src="assets/images/logo-light.png" alt="logo" class="logo-lg">
            <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>

        <!-- Brand Logo Dark -->
        <a href="index.php" class="logo-dark">
            <img src="assets/images/logo-dark.png" alt="dark logo" class="logo-lg">
            <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>
    </div>

    <!-- menu-left -->
    <div class="scrollbar">

        <!-- User box -->
        <div class="user-box text-center">
            <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block" data-bs-toggle="dropdown">Geneva
                    Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted mb-0">Admin Head</p>
        </div>

        <!--- Menu -->
        <ul class="menu">

            <li class="menu-title">Navigasi</li>

            <li class="menu-item">
                <a href="?halaman=dashboard" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-view-dashboard-outline"></i></span>
                    <span class="menu-text"> Dashboards </span>
                </a>
            </li>
            <?php if ($_SESSION['level'] == 'Admin') { ?>
                <li class="menu-title">Master Data</li>
                <li class="menu-item">
                    <a href="?halaman=pengguna" class="menu-link">
                        <span class="menu-icon"><i class="mdi mdi-account"></i></span>
                        <span class="menu-text"> Pengguna </span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="?halaman=produk" class="menu-link">
                        <span class="menu-icon"><i class="mdi mdi-archive-outline"></i></span>
                        <span class="menu-text"> Produk </span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="?halaman=supplier" class="menu-link">
                        <span class="menu-icon"><i class="mdi mdi-clipboard-flow-outline"></i></span>
                        <span class="menu-text"> Supplier </span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="?halaman=pelanggan" class="menu-link">
                        <span class="menu-icon"><i class="mdi mdi-account-group"></i></span>
                        <span class="menu-text"> Pelanggan </span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="?halaman=akun" class="menu-link">
                        <span class="menu-icon"><i class="mdi mdi-card-account-details-outline"></i></span>
                        <span class="menu-text"> Akun </span>
                    </a>
                </li>
            <?php } ?>

            <li class="menu-title">Transaksi</li>

            <li class="menu-item">
                <a href="?halaman=penjualan" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-cart"></i></span>
                    <span class="menu-text"> Penjualan </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="?halaman=pembelian" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-cart"></i></span>
                    <span class="menu-text"> Pembelian </span>
                </a>
            </li>

            <li class="menu-title">Laporan</li>
            <li class="menu-item">
                <a href="?halaman=laporan-stok" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-chart-box-outline"></i></span>
                    <span class="menu-text"> Stok </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="?halaman=laporan-penjualan" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-chart-box-outline"></i></span>
                    <span class="menu-text"> Penjualan </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="?halaman=laporan-pembelian" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-chart-box-outline"></i></span>
                    <span class="menu-text"> Pembelian </span>
                </a>
            </li>


            <li class="menu-item">
                <a href="?halaman=jurnal" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-chart-box-outline"></i></span>
                    <span class="menu-text"> Jurnal </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="?halaman=buku-besar" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-chart-box-outline"></i></span>
                    <span class="menu-text"> Buku Besar </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="?halaman=laba-rugi" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-chart-box-outline"></i></span>
                    <span class="menu-text"> Laba Rugi </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="?halaman=neraca" class="menu-link">
                    <span class="menu-icon"><i class="mdi mdi-chart-box-outline"></i></span>
                    <span class="menu-text"> Neraca </span>
                </a>
            </li>


        </ul>
        <!--- End Menu -->
        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left menu End ========== -->