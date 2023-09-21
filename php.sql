-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2023 at 10:11 PM
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
-- Database: `php`
--

-- --------------------------------------------------------

--
-- Table structure for table `homes`
--

CREATE TABLE `homes` (
  `id` int(11) NOT NULL,
  `Location` text NOT NULL,
  `Price` bigint(11) NOT NULL,
  `Owner` text NOT NULL,
  `Contact` varchar(11) NOT NULL,
  `Bathrooms` int(11) NOT NULL,
  `Rooms` int(11) NOT NULL,
  `Floors` int(11) NOT NULL,
  `Area` text NOT NULL,
  `Picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='For the Homes';

--
-- Dumping data for table `homes`
--

INSERT INTO `homes` (`id`, `Location`, `Price`, `Owner`, `Contact`, `Bathrooms`, `Rooms`, `Floors`, `Area`, `Picture`) VALUES
(27, 'Bannu', 2, 'Atif Ashraf', '567576', 2, 2, 2, '1 Karnal', 'home_Atif Ashraf_1695134504_6509b3289a47c.jpg'),
(29, 'Askari 9', 2000000, 'Atif Ashraf', '03053339909', 6, 6, 4, '2 Karnal', 'home_Atif Ashraf_1695322128_650c90108228c.jpg'),
(30, 'Askari 11', 5000000, 'Atif Ashraf', '03176182415', 4, 5, 2, '5 marla', 'home_Atif Ashraf_1695322708_650c925431945.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `Name` text NOT NULL,
  `Password` text NOT NULL,
  `Profile Picture` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Name`, `Password`, `Profile Picture`) VALUES
(18, 'admin', '$2y$10$5PFBaRSAdD5jAIQ2Uj0BzeIrst8snrKPivtTDGtUikWEd6URXKrvi', NULL),
(21, 'Atif Ashraf', '$2y$10$EkiGkhGcO56lf3.3JAqTiOYjQdU/ltWXjbDCFmpbHW/q5cMj3MJfm', 'Purple and Pink Illustration Youtube Profile Picture (1).png'),
(22, 'wasif', '$2y$10$fEUTI3seM23ozUCW0nTBo.iXtz2ZjKu5VqSiCbsn/0UROCKa54siy', '6509d539756e3_Blue Modern Electricity Technology Initial Logo (2).png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `homes`
--
ALTER TABLE `homes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `homes`
--
ALTER TABLE `homes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
