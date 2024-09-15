<?php
switch ($_GET['halaman'] ?? '') {
    case '':
    case 'dashboard':
        include 'halaman/dashboard.php';
        break;
    case 'pengguna':
        include 'halaman/pengguna/index.php';
        break;
    case 'pelanggan':
        include 'halaman/pelanggan/index.php';
        break;
    case 'supplier':
        include 'halaman/supplier/index.php';
        break;
    case 'produk':
        include 'halaman/produk/index.php';
        break;
    case 'pembelian':
        include 'halaman/pembelian/index.php';
        break;
    case 'penjualan':
        include 'halaman/penjualan/index.php';
        break;
    case 'akun':
        include 'halaman/akun/index.php';
        break;
    case 'jurnal':
        include 'halaman/jurnal/index.php';
        break;
    case 'stok':
        include 'halaman/laporan-stok/index.php';
        break;
    case 'laporan-penjualan':
        include 'halaman/laporan-penjualan/index.php';
        break;
    case 'laporan-pembelian':
        include 'halaman/laporan-pembelian/index.php';
        break;
    case 'neraca':
        include 'halaman/neraca/index.php';
        break;
    case 'laba-rugi':
        include 'halaman/laba-rugi/index.php';
        break;
    case 'return-penjualan':
        include 'halaman/return-penjualan/index.php';
        break;
    case 'return-pembelian':
        include 'halaman/return-pembelian/index.php';
        break;
    case 'laporan-return-pembelian':
        include 'halaman/laporan-return-pembelian/index.php';
        break;
    case 'laporan-return-penjualan':
        include 'halaman/laporan-return-penjualan/index.php';
        break;
    case 'buku-besar':
        include 'halaman/buku-besar/index.php';
        break;
    case 'laporan-stok':
        include 'halaman/laporan-stok/index.php';
        break;
    default:
        include 'halaman/404.php';
}