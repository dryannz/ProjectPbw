-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2026 at 08:29 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_transaksiyoko`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `idbarang` varchar(20) NOT NULL,
  `ukuran` varchar(255) NOT NULL,
  `ukuran_tamu` varchar(255) DEFAULT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`idbarang`, `ukuran`, `ukuran_tamu`, `harga`) VALUES
('BR-001', 'M8*15WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 7*15SET BMK', '1200'),
('BR-002', 'M8*30WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*30SET BMK', '1250'),
('BR-003', 'M8*40WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*40SET BMK', '1500'),
('BR-004', 'M8*50WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*50SET BMK', '1600'),
('BR-005', 'M8*80WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*80SET BMK', '1700'),
('BR-006', 'M8*100WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*100SET BMK', '1800'),
('BR-007', 'M8*20WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*20SET BMK', '1230'),
('BR-008', 'M8*25WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*25SET BMK', '1240'),
('BR-009', 'M8*35WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*35SET BMK', '1372'),
('BR-010', 'M8*45WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*45SET BMK', '1870'),
('BR-011', 'M8*55WXXB-B-15-K-KC12#1.25(SD4B6)', 'BAUT HEX 8*55SET BMK', '1930');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `idcustomer` varchar(20) NOT NULL,
  `kepada_yth` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`idcustomer`, `kepada_yth`, `alamat`) VALUES
('CS-001', 'PT RODA PRIMA LANCAR', 'Jl. Gatot Subroto KM. 4 (Komp. Industri Kali Sabik) Desa Keroncong, Jatiuwung,  Kota Tangerang, Banten'),
('CS-002', 'PT Astra Honda Motor', 'Kawasan Industri MM2100, Jl. Kalimantan Blok AA-1, Danau Indah, Kec. Cikarang Barat, Kabupaten Bekasi, Jawa Barat 17530.'),
('CS-003', 'PT Hyundai Motor Manufacturing Indonesia (HMMI)', 'Kawasan Industri Deltamas, Bojongmangu, Cikarang, Kabupaten Bekasi, Jawa Barat 17530.'),
('CS-004', 'PT Toyota Motor Manufacturing Indonesia (TMMIN)', 'Kawasan Industri KIIC, Jl. Permata Raya Lot DD-1, Sirnabaya, Telukjambe Timur, Kabupaten Karawang, Jawa Barat 41361.'),
('CS-005', 'PT Dharma Polimetal Tbk', 'Kawasan Industri Lippo Cikarang, Delta Silicon I, Jl. Angsana Raya Blok A9 No. 8, Sukaresmi, Cikarang Selatan, Kabupaten Bekasi, Jawa Barat 17550.'),
('CS-006', 'PT Denso Indonesia', 'Kawasan Industri MM2100, Jl. Kalimantan Blok E 1-2, Cikarang Barat, Kabupaten Bekasi, Jawa Barat 17520.'),
('CS-007', 'PT Aisin Indonesia', 'East Jakarta Industrial Park (EJIP) Plot 5J, Cikarang Selatan, Bekasi, Jawa Barat 17550');

-- --------------------------------------------------------

--
-- Table structure for table `detail_invoice`
--

CREATE TABLE `detail_invoice` (
  `no_invoice` varchar(70) NOT NULL,
  `no_order` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_invoice`
--

INSERT INTO `detail_invoice` (`no_invoice`, `no_order`) VALUES
('IN-001', 'PO-2212'),
('IN-001', 'PO-2215'),
('IN-002', 'PO-2214'),
('IN-003', 'PO-2213');

-- --------------------------------------------------------

--
-- Table structure for table `detail_po`
--

CREATE TABLE `detail_po` (
  `no_order` varchar(70) NOT NULL,
  `idbarang` varchar(20) NOT NULL,
  `wrn` char(1) DEFAULT NULL,
  `pcs_krg` int(30) DEFAULT NULL,
  `jmlh_krg` int(30) DEFAULT NULL,
  `total_pcs` int(30) DEFAULT NULL,
  `kg_krg` int(30) DEFAULT NULL,
  `total_kg` int(30) DEFAULT NULL,
  `jumlah_harga` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_po`
--

INSERT INTO `detail_po` (`no_order`, `idbarang`, `wrn`, `pcs_krg`, `jmlh_krg`, `total_pcs`, `kg_krg`, `total_kg`, `jumlah_harga`) VALUES
('PO-2212', 'BR-006', 'A', 999, 5, 4995, 0, 0, '8991000'),
('PO-2212', 'BR-002', 'B', 999, 1, 999, 0, 0, '1248750'),
('PO-2213', 'BR-001', 'C', 999, 10, 9990, 0, 0, '11988000'),
('PO-2215', 'BR-003', 'K', 499, 9, 4491, 0, 0, '6736500'),
('PO-2214', 'BR-001', 'P', 990, 10, 9900, 0, 0, '11880000'),
('PO-2216', 'BR-003', 'K', 999, 1, 999, 0, 0, '1498500'),
('PO-2212', 'BR-001', 'K', 999, 9, 8991, 0, 0, '10789200'),
('PO-2212', 'BR-007', 'A', 999, 9, 8991, 0, 0, '11058930'),
('PO-2212', 'BR-011', 'A', 10000, 28, 280000, 0, 0, '540400000'),
('PO-2212', 'BR-010', 'K', 9999, 20, 199980, 0, 0, '373962600'),
('PO-2212', 'BR-004', 'H', 19999, 16, 319984, 0, 0, '511974400');

-- --------------------------------------------------------

--
-- Table structure for table `detail_surat_jalan`
--

CREATE TABLE `detail_surat_jalan` (
  `no_surat` varchar(70) NOT NULL,
  `no_invoice` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_surat_jalan`
--

INSERT INTO `detail_surat_jalan` (`no_surat`, `no_invoice`) VALUES
('SJ-001', 'IN-002'),
('SJ-003', 'IN-003');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `no_invoice` varchar(70) NOT NULL,
  `idpetugas_admin` varchar(20) NOT NULL,
  `no_order` varchar(70) NOT NULL,
  `tgl_invoice` date NOT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL,
  `ppn` decimal(10,0) DEFAULT NULL,
  `dpp` decimal(10,0) DEFAULT NULL,
  `total` decimal(11,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`no_invoice`, `idpetugas_admin`, `no_order`, `tgl_invoice`, `subtotal`, `ppn`, `dpp`, `total`) VALUES
('IN-001', 'P-007', 'PO-2212', '2026-05-31', '0', '175819366', '500000', '0'),
('IN-002', 'P-001', 'PO-2214', '2026-06-19', '0', '0', '0', '0'),
('IN-003', 'P-001', 'PO-2213', '2026-06-01', '0', '1438560', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `idpetugas` varchar(20) NOT NULL,
  `namapetugas` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `jabatan` varchar(30) DEFAULT NULL,
  `ttdpetugas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`idpetugas`, `namapetugas`, `password`, `jabatan`, `ttdpetugas`) VALUES
('P-001', 'Zahra Kinasih', '$2y$12$tTTrTtBBDt2ofCPWh47ZceuQtDyRWQ1Bpj43DQqiMWWNhjl62Lc0u', 'Admin', NULL),
('P-002', 'Agus Setyono', NULL, 'Driver', NULL),
('P-003', 'Ramadhan Suryono', NULL, 'Driver', NULL),
('P-004', 'Dewi Santika', NULL, 'Admin', NULL),
('P-005', 'Agustian Sadewa', NULL, 'Warehouse', NULL),
('P-006', 'Bagas Adi ', NULL, 'Driver', NULL),
('P-007', 'Evelyn', NULL, 'Admin', NULL),
('P-008', 'Antonio Subagja', NULL, 'Warehouse', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `no_order` varchar(70) NOT NULL,
  `idcustomer` varchar(20) NOT NULL,
  `tgl_order` date NOT NULL,
  `schedule_delivery` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`no_order`, `idcustomer`, `tgl_order`, `schedule_delivery`) VALUES
('PO-2212', 'CS-001', '2026-05-29', '2026-06-19'),
('PO-2213', 'CS-002', '2026-06-10', '2026-06-27'),
('PO-2214', 'CS-007', '2026-06-11', '2026-06-25'),
('PO-2215', 'CS-001', '2026-05-31', '2026-06-25'),
('PO-2216', 'CS-004', '2026-06-01', '2026-06-25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_jalan`
--

CREATE TABLE `surat_jalan` (
  `no_surat` varchar(70) NOT NULL,
  `no_invoice` varchar(70) NOT NULL,
  `idpetugas_admin` varchar(20) NOT NULL,
  `idpetugas_warehouse` varchar(20) NOT NULL,
  `idpetugas_driver` varchar(20) NOT NULL,
  `tgl_surat` date NOT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat_jalan`
--

INSERT INTO `surat_jalan` (`no_surat`, `no_invoice`, `idpetugas_admin`, `idpetugas_warehouse`, `idpetugas_driver`, `tgl_surat`, `subtotal`) VALUES
('SJ-001', 'IN-002', 'P-001', 'P-005', 'P-003', '2026-06-03', '0'),
('SJ-003', 'IN-003', 'P-001', 'P-005', 'P-002', '2026-06-03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`idbarang`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`idcustomer`);

--
-- Indexes for table `detail_invoice`
--
ALTER TABLE `detail_invoice`
  ADD PRIMARY KEY (`no_invoice`,`no_order`),
  ADD KEY `no_order` (`no_order`);

--
-- Indexes for table `detail_po`
--
ALTER TABLE `detail_po`
  ADD KEY `barang` (`idbarang`),
  ADD KEY `fk_po` (`no_order`);

--
-- Indexes for table `detail_surat_jalan`
--
ALTER TABLE `detail_surat_jalan`
  ADD PRIMARY KEY (`no_surat`,`no_invoice`),
  ADD KEY `no_order` (`no_invoice`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`no_invoice`),
  ADD KEY `fk_petugas_admin` (`idpetugas_admin`),
  ADD KEY `fk_order_invoice` (`no_order`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`idpetugas`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`no_order`),
  ADD KEY `fk_customer` (`idcustomer`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `surat_jalan`
--
ALTER TABLE `surat_jalan`
  ADD PRIMARY KEY (`no_surat`),
  ADD KEY `fk_po_sj` (`no_invoice`),
  ADD KEY `fkadmin_sj` (`idpetugas_admin`),
  ADD KEY `fkdriver_sj` (`idpetugas_driver`),
  ADD KEY `fkwarehouse_sj` (`idpetugas_warehouse`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_invoice`
--
ALTER TABLE `detail_invoice`
  ADD CONSTRAINT `detail_invoice_ibfk_1` FOREIGN KEY (`no_invoice`) REFERENCES `invoice` (`no_invoice`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_invoice_ibfk_2` FOREIGN KEY (`no_order`) REFERENCES `purchase_order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_po`
--
ALTER TABLE `detail_po`
  ADD CONSTRAINT `barang` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_po` FOREIGN KEY (`no_order`) REFERENCES `purchase_order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_surat_jalan`
--
ALTER TABLE `detail_surat_jalan`
  ADD CONSTRAINT `detail_surat_jalan_ibfk_1` FOREIGN KEY (`no_surat`) REFERENCES `surat_jalan` (`no_surat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_surat_jalan_ibfk_2` FOREIGN KEY (`no_invoice`) REFERENCES `invoice` (`no_invoice`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk_order_invoice` FOREIGN KEY (`no_order`) REFERENCES `purchase_order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_petugas_admin` FOREIGN KEY (`idpetugas_admin`) REFERENCES `petugas` (`idpetugas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`idcustomer`) REFERENCES `customer` (`idcustomer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surat_jalan`
--
ALTER TABLE `surat_jalan`
  ADD CONSTRAINT `fk_inv_sj` FOREIGN KEY (`no_invoice`) REFERENCES `invoice` (`no_invoice`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkadmin_sj` FOREIGN KEY (`idpetugas_admin`) REFERENCES `petugas` (`idpetugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkdriver_sj` FOREIGN KEY (`idpetugas_driver`) REFERENCES `petugas` (`idpetugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkwarehouse_sj` FOREIGN KEY (`idpetugas_warehouse`) REFERENCES `petugas` (`idpetugas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
