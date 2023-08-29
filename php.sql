-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2023 at 08:53 PM
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
(9, 'Askari 11', 200000000, 'Atif Ashraf', '03176182415', 2, 2, 2, '1 Karnal', '10-marla-house-for-sale-in-askari-11-lahore-for-rs-186-crore-132780-image-1-actual.jpg'),
(10, 'Askari 9', 20000000, 'Waseem', '03053339909', 4, 6, 2, '1 Karnal', '02.jpg'),
(11, 'Kashmir', 200000, 'Wasif', '03379382039', 2, 2, 1, '5 marla', 'GettyImages-176459402.jpg'),
(12, 'Lahore', 2000000000, 'Atif Ashraf', '03176182415', 6, 6, 2, '1 Karnal', 'GettyImages-176459402.jpg');

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
(18, 'admin', '$2y$10$5PFBaRSAdD5jAIQ2Uj0BzeIrst8snrKPivtTDGtUikWEd6URXKrvi', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
