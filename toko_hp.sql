-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2024 at 04:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_hp`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_pelanggan` (IN `nama_pelanggan` VARCHAR(20), IN `asal` VARCHAR(20))   BEGIN
INSERT INTO pelanggan(nama_pelanggan, asal) VALUES (nama_pelanggan, asal);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_produk` (IN `nama_produk` VARCHAR(10), IN `harga` DECIMAL(10,2))   BEGIN
INSERT INTO produk(nama_produk, harga) VALUES (nama_produk, harga);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_transaksi` (IN `id_pelanggan` INT(2), IN `total_pembelian` DECIMAL(10,2))   BEGIN
INSERT INTO transaksi(id_pelanggan, total_pembelian) VALUES (id_pelanggan, total_pembelian);
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `jumlah_produk` () RETURNS INT(11)  BEGIN
    DECLARE jumlah_produk INT;
    SELECT COUNT(*) INTO jumlah_produk FROM Produk;
    RETURN jumlah_produk;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `jumlah_pembelian`
-- (See below for the actual view)
--
CREATE TABLE `jumlah_pembelian` (
`id_pelanggan` int(2)
,`nama_pelanggan` varchar(20)
,`Jumlah_Pembelian` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(2) NOT NULL,
  `nama_pelanggan` varchar(20) NOT NULL,
  `asal` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `asal`) VALUES
(1, 'Damar', 'Semarang'),
(2, 'Franklyn', 'Pati'),
(3, 'Ikharista', 'Blora'),
(4, 'Ella', 'Tasikmalaya');

--
-- Triggers `pelanggan`
--
DELIMITER $$
CREATE TRIGGER `hapus_transaksi` AFTER DELETE ON `pelanggan` FOR EACH ROW BEGIN
DELETE FROM transaksi WHERE id_pelanggan = OLD.id_pelanggan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(2) NOT NULL,
  `nama_produk` varchar(10) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga`) VALUES
(1, 'Samsung', 4499999.99),
(2, 'Iphone', 12000000.99),
(3, 'Xiaomi', 3499999.99),
(4, 'Asus', 8499999.99),
(5, 'Nokia', 7999999.99);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(2) NOT NULL,
  `id_pelanggan` int(2) NOT NULL,
  `total_pembelian` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `total_pembelian`) VALUES
(1, 1, 3499999.99),
(2, 1, 12000000.99),
(3, 2, 8499999.99),
(4, 3, 4999999.99),
(5, 4, 10000000.99);

-- --------------------------------------------------------

--
-- Structure for view `jumlah_pembelian`
--
DROP TABLE IF EXISTS `jumlah_pembelian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jumlah_pembelian`  AS SELECT `pelanggan`.`id_pelanggan` AS `id_pelanggan`, `pelanggan`.`nama_pelanggan` AS `nama_pelanggan`, count(0) AS `Jumlah_Pembelian` FROM (`pelanggan` join `transaksi` on(`pelanggan`.`id_pelanggan` = `transaksi`.`id_pelanggan`)) GROUP BY `pelanggan`.`id_pelanggan` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
