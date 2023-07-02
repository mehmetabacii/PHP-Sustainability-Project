-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 15, 2022 at 08:10 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `256proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `consumer`
--

DROP TABLE IF EXISTS `consumer`;
CREATE TABLE IF NOT EXISTS `consumer` (
  `email` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_turkish_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `district` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `consumer`
--

INSERT INTO `consumer` (`email`, `name`, `password`, `city`, `district`, `address`) VALUES
('admin.consumer@localhost', 'admin.consumer', '$2a$12$z0ZxM58ZpfJJaqT5ZOwmfuFsmjPW58h18LBhEPFApkEjdywhnvbz.', 'Ankara  ', '&Ccedil;ankaya', '06800');

-- --------------------------------------------------------

--
-- Table structure for table `market`
--

DROP TABLE IF EXISTS `market`;
CREATE TABLE IF NOT EXISTS `market` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_turkish_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `district` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`mid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `market`
--

INSERT INTO `market` (`mid`, `email`, `name`, `password`, `city`, `district`, `address`) VALUES
(1, 'admin.market@localhost', 'admin.market', '$2a$12$iJueYHJzkc6wcIv2lIe0muCtFV3zakbU.ODd0gPqTeEP1XAZ88ClS', 'Ankara', 'Çankaya', '06800'),
(2, 'huseyinkolcu43@gmail.com', 'Hasan', '$2y$10$KsFN5KcaNzgrejbpJkUv2e1vEaC/HpuJk0XL6PJFd8p5P7mJIkMA6', 'Ankara   ', 'Yenimahalle', '06210'),
(3, 'aybukeyaren4@gmail.com', 'Aybuke Yaren&lt;3', '$2y$10$IC/G/gqGkugD/RiV9bDmWuLXF.b.7S.6HIduwcxHVGtMk4ABeB.4.', 'Ankara', 'Sincan', 'Cart Mahallesi, Curt Sokagi');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `normal_price` decimal(13,2) NOT NULL,
  `discnt_price` decimal(13,2) NOT NULL,
  `expr_date` date NOT NULL,
  `img` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `mid_fk` (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pid`, `mid`, `title`, `stock`, `normal_price`, `discnt_price`, `expr_date`, `img`) VALUES
(1, 1, 'Porcelain Cup - One of a kind', 1, '50000.00', '3999.99', '2122-04-17', '25f4bb956b00213b67e926d2b88f74bba6870b52.jpg'),
(2, 1, 'Nutella', 100, '44.99', '44.98', '2022-08-26', '764cab691d7bf5314f8e0c31f89d38ee88510d69.jfif'),
(4, 1, 'Milk', 100, '11.95', '7.95', '2022-05-16', '4b759a84fa27f1a124dddd9bc3cccafcc5b27e42.png'),
(6, 3, 'Cheese', 1, '39.99', '30.95', '2022-05-17', 'ca8047c093e322dd4645dbef0c850709b96a8ee7.jpg'),
(7, 3, 'Jambon - Dana', 4, '6.95', '5.00', '2022-05-22', '4f3acf437e358f1748da2a3e173cc6ce49443ea2.jpg'),
(8, 3, 'Cupcake', 20, '34.95', '30.95', '2022-05-28', '8503e18d422241bc0a0520d74b4e7c4f1c5af7fd.jpeg'),
(9, 3, 'Pretzel', 54, '6.00', '4.00', '2022-05-24', 'c260a637cd34371410cdc5b3bf787d9a1be84605.jpg'),
(10, 3, 'Apple', 300, '3.00', '2.49', '2022-06-01', 'product.jpeg'),
(12, 3, 'Strawberry', 87, '16.78', '15.65', '2023-02-22', 'product.jpeg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `mid_fk` FOREIGN KEY (`mid`) REFERENCES `market` (`mid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
