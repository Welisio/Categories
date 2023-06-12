-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2023 at 07:41 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `categorydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int UNSIGNED DEFAULT NULL,
  `product_type` smallint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `parent_id`, `product_type`, `name`) VALUES
(1, NULL, 0, 'Smartfonlar'),
(2, NULL, 0, 'Apple'),
(3, 2, 0, 'iphone 14 pro'),
(4, 2, 0, 'iphone 11'),
(5, 3, 0, 'white'),
(6, 3, 0, 'black'),
(8, NULL, 0, 'Samsung'),
(9, 8, 0, 'Samsung Galaxy A14'),
(10, NULL, 1, 'Smart saatlar'),
(11, NULL, 1, 'Apple'),
(12, NULL, 1, 'Samsung'),
(13, 8, 0, 'Samsung Galaxy A34');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_type` smallint UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `image`, `product_type`, `path`) VALUES
(1, 'iphone 14 pro', 'https://www.ultimateshield.co.uk/cdn/shop/products/Hdb3e1dca148f40d8a2296a360a376e384_564927c7-5f5d-423b-a896-9dad5091948c.jpg?v=1662648279', 0, '1/2/3/5'),
(2, 'iphone 14 pro', 'https://www.nfm.com/dw/image/v2/BDFM_PRD/on/demandware.static/-/Sites-nfm-master-catalog/default/dw2311962f/images/063/17/63176101-2.jpg?sw=1000&sh=1000&sm=fit', 0, '1/2/3/6'),
(3, 'iphone 11', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/refurb-iphone11-purple-2019?wid=1144&hei=1144&fmt=jpeg&qlt=90&.v=1611169055000', 0, '1/2/4'),
(4, 'Samsung Galaxy A14', 'https://image-us.samsung.com/SamsungUS/home/mobile/phones/pdp/galazy-a/galaxy-a14-5g/gallery_images/SDSAC-5314-Galaxy-A14-5G_Black_Back-R30_RGB-1600x1200_6.jpg?$product-details-jpg$', 0, '1/8/9'),
(5, 'Apple Watch 8 45 mm Midnight Aluminium / MNP13RB/A', 'https://kontakt.az/wp-content/uploads/2022/10/Apple-Watch-8-45-mm-Midnight-Aluminium_png.webp', 1, '10/11'),
(6, 'Apple Watch 8 41 mm Starlight Aluminium / MNP63RB/A', 'https://kontakt.az/wp-content/uploads/2022/09/Apple-Watch-8-41-mm_png.webp', 1, '10/11'),
(7, 'Samsung Watch5 BT 44mm Blue/SM-R910NZBACIS', 'https://kontakt.az/wp-content/uploads/2022/09/New-Project-2022-09-06T102306.643_png.webp', 1, '10/12'),
(8, 'Samsung Galaxy A34', 'https://kontakt.az/wp-content/uploads/2023/04/New-Project-2023-04-04T114228.895_png.webp', 0, '1/8/13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
