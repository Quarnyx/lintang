/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : 127.0.0.1:3306
 Source Schema         : lintang

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 12/09/2024 19:00:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for akun
-- ----------------------------
DROP TABLE IF EXISTS `akun`;
CREATE TABLE `akun`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_akun` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_akun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kategori_akun` enum('Aktiva Lancar','Aktiva Tetap','Kewajiban','Ekuitas','Pendapatan','Beban') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `wajib` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of akun
-- ----------------------------
INSERT INTO `akun` VALUES (1, '100001', 'Kas', 'Aktiva Lancar', 1);
INSERT INTO `akun` VALUES (2, '50005', 'Pembelian', 'Beban', 1);
INSERT INTO `akun` VALUES (3, '40001', 'Pendapatan', 'Pendapatan', 1);
INSERT INTO `akun` VALUES (5, '300001', 'Peralatan Kantor', 'Aktiva Tetap', 0);
INSERT INTO `akun` VALUES (6, '90000', 'Modal', 'Ekuitas', 1);
INSERT INTO `akun` VALUES (7, '60001', 'Utang Bank', 'Kewajiban', 1);
INSERT INTO `akun` VALUES (8, '100002', 'Persediaan', 'Aktiva Lancar', 1);
INSERT INTO `akun` VALUES (9, '100003', 'Bank BRI', 'Aktiva Lancar', 0);
INSERT INTO `akun` VALUES (10, '10005', 'HPP', 'Beban', 1);
INSERT INTO `akun` VALUES (11, '2321323', 'Listrik', 'Beban', 0);
INSERT INTO `akun` VALUES (12, '2132131', 'Utang Bank', 'Kewajiban', 0);

-- ----------------------------
-- Table structure for keranjang
-- ----------------------------
DROP TABLE IF EXISTS `keranjang`;
CREATE TABLE `keranjang`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_penjualan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_produk` int NULL DEFAULT NULL,
  `tanggal_transaksi` date NULL DEFAULT NULL,
  `harga_jual` decimal(10, 2) NULL DEFAULT NULL,
  `qty` int NULL DEFAULT NULL,
  `id_pelanggan` int NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `harga_beli` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_produk`(`id_produk` ASC) USING BTREE,
  INDEX `id_pelanggan`(`id_pelanggan` ASC) USING BTREE,
  CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of keranjang
-- ----------------------------

-- ----------------------------
-- Table structure for pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_pelanggan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `kontak` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelanggan
-- ----------------------------
INSERT INTO `pelanggan` VALUES (1, 'Umum', 'PURIN Kendal', '02212135');

-- ----------------------------
-- Table structure for pembelian
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_pembelian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `qty` int NULL DEFAULT NULL,
  `harga_beli` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `tanggal_transaksi` date NULL DEFAULT NULL,
  `id_pengguna` int NULL DEFAULT NULL,
  `id_supplier` int NULL DEFAULT NULL,
  `id_produk` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_produk`(`id_produk` ASC) USING BTREE,
  INDEX `id_supplier`(`id_supplier` ASC) USING BTREE,
  INDEX `id_pengguna`(`id_pengguna` ASC) USING BTREE,
  CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembelian_ibfk_3` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
INSERT INTO `pembelian` VALUES (5, 'PBL-001', 100, 2400.00, 240000.00, '2024-09-01', 1, 1, 4);

-- ----------------------------
-- Table structure for pengguna
-- ----------------------------
DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE `pengguna`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengguna
-- ----------------------------
INSERT INTO `pengguna` VALUES (1, 'admin', '$2y$10$NdIEuC1rFSRlz88KWbaLNemm2SJ497qel9.v3s2p2MbSR4eFG.JvO', 'Lintang', 'Admin');
INSERT INTO `pengguna` VALUES (8, 'jono', '$2y$10$3O3NMQgwTS4/l0wO7Y9sV.rAaQgLpS5tk6IKv2MzX.eAHSpkWvu/.', 'Jono1', 'Karyawan');

-- ----------------------------
-- Table structure for penjualan
-- ----------------------------
DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE `penjualan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_penjualan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total` decimal(10, 2) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `id_pengguna` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_pengguna`(`id_pengguna` ASC) USING BTREE,
  CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan
-- ----------------------------

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga_beli` decimal(10, 2) NOT NULL,
  `harga_jual` decimal(10, 2) NOT NULL,
  `satuan` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kategori_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (1, 'ADIDAS SUPERSTAR EG4958', 2400.00, 2700.00, 'pcs', 'asdadsada');
INSERT INTO `produk` VALUES (4, 'Indomie', 2500.00, 3000.00, 'pcs', 'Makanan');

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kontak_supplier` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (1, 'Indofood', '0254424');
INSERT INTO `supplier` VALUES (4, 'PT. ABC', '20254545');

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` date NOT NULL,
  `jenis_transaksi` enum('Pendapatan','Pengeluaran') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `akun_debit` int NOT NULL,
  `akun_kredit` int NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`id_transaksi`) USING BTREE,
  INDEX `akun_debit`(`akun_debit` ASC) USING BTREE,
  INDEX `akun_kredit`(`akun_kredit` ASC) USING BTREE,
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`akun_debit`) REFERENCES `akun` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`akun_kredit`) REFERENCES `akun` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES (20, '2024-08-01', 'Pendapatan', 1, 6, 'Modal', 'JRNL20240912115833', 50000000.00);
INSERT INTO `transaksi` VALUES (21, '2024-09-01', 'Pengeluaran', 8, 1, 'Pembelian dengan kodePBL-001', 'PBL-001', 240000.00);

-- ----------------------------
-- View structure for jurnal
-- ----------------------------
DROP VIEW IF EXISTS `jurnal`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `jurnal` AS select `t`.`tanggal_transaksi` AS `tanggal_transaksi`,`t`.`deskripsi` AS `deskripsi`,`t`.`kode_transaksi` AS `kode_transaksi`,`a1`.`nama_akun` AS `nama_akun`,`a1`.`kategori_akun` AS `kategori_akun`,`t`.`id_transaksi` AS `id_transaksi`,(case when (`t`.`akun_debit` = `a1`.`id`) then `t`.`total` else 0 end) AS `debit`,(case when (`t`.`akun_kredit` = `a1`.`id`) then `t`.`total` else 0 end) AS `kredit` from (`transaksi` `t` join `akun` `a1` on(((`t`.`akun_debit` = `a1`.`id`) or (`t`.`akun_kredit` = `a1`.`id`)))) order by `t`.`tanggal_transaksi`;

-- ----------------------------
-- View structure for stok
-- ----------------------------
DROP VIEW IF EXISTS `stok`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `stok` AS select `p`.`id` AS `id`,`p`.`nama_produk` AS `nama_produk`,ifnull(`pur`.`total_purchased`,0) AS `total_beli`,ifnull(`sal`.`total_sold`,0) AS `total_terjual`,(ifnull(`pur`.`total_purchased`,0) - ifnull(`sal`.`total_sold`,0)) AS `stok`,`p`.`harga_beli` AS `harga_beli`,`p`.`harga_jual` AS `harga_jual` from ((`produk` `p` left join (select `pembelian`.`id_produk` AS `id_produk`,sum(`pembelian`.`qty`) AS `total_purchased` from `pembelian` group by `pembelian`.`id_produk`) `pur` on((`p`.`id` = `pur`.`id_produk`))) left join (select `keranjang`.`id_produk` AS `id_produk`,sum(`keranjang`.`qty`) AS `total_sold` from `keranjang` group by `keranjang`.`id_produk`) `sal` on((`p`.`id` = `sal`.`id_produk`)));

-- ----------------------------
-- View structure for view_keranjang
-- ----------------------------
DROP VIEW IF EXISTS `view_keranjang`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_keranjang` AS select `keranjang`.`id` AS `id`,`keranjang`.`kode_penjualan` AS `kode_penjualan`,`keranjang`.`id_produk` AS `id_produk`,`keranjang`.`tanggal_transaksi` AS `tanggal_transaksi`,`keranjang`.`harga_jual` AS `harga_jual`,`keranjang`.`qty` AS `qty`,`keranjang`.`id_pelanggan` AS `id_pelanggan`,`keranjang`.`total` AS `total`,`produk`.`nama_produk` AS `nama_produk`,`keranjang`.`harga_beli` AS `harga_beli` from (`keranjang` join `produk` on((`keranjang`.`id_produk` = `produk`.`id`)));

-- ----------------------------
-- View structure for view_pembelian
-- ----------------------------
DROP VIEW IF EXISTS `view_pembelian`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_pembelian` AS select `pembelian`.`id` AS `id`,`pembelian`.`kode_pembelian` AS `kode_pembelian`,`pembelian`.`qty` AS `qty`,`pembelian`.`harga_beli` AS `harga_beli`,`pembelian`.`total` AS `total`,`pembelian`.`tanggal_transaksi` AS `tanggal_transaksi`,`pembelian`.`id_pengguna` AS `id_pengguna`,`pembelian`.`id_supplier` AS `id_supplier`,`pembelian`.`id_produk` AS `id_produk`,`supplier`.`nama_supplier` AS `nama_supplier`,`produk`.`nama_produk` AS `nama_produk`,`transaksi`.`akun_debit` AS `akun_debit`,`transaksi`.`akun_kredit` AS `akun_kredit` from (((`pembelian` join `supplier` on((`pembelian`.`id_supplier` = `supplier`.`id`))) join `produk` on((`pembelian`.`id_produk` = `produk`.`id`))) join `transaksi` on((`pembelian`.`kode_pembelian` = `transaksi`.`kode_transaksi`)));

SET FOREIGN_KEY_CHECKS = 1;
