-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2023 at 10:24 PM
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
  `Picture` text NOT NULL,
  `Created` varchar(200) NOT NULL DEFAULT current_timestamp(),
  `Slider` tinyint(1) DEFAULT NULL,
  `SliderImage1` varchar(255) DEFAULT NULL,
  `SliderImage2` varchar(255) DEFAULT NULL,
  `SliderImage3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='For the Homes';

--
-- Dumping data for table `homes`
--

INSERT INTO `homes` (`id`, `Location`, `Price`, `Owner`, `Contact`, `Bathrooms`, `Rooms`, `Floors`, `Area`, `Picture`, `Created`, `Slider`, `SliderImage1`, `SliderImage2`, `SliderImage3`) VALUES
(34, 'Bannu', 4, 'Atif Ashraf', '03176182415', 2, 1, 2, '1 Karnal', 'pexels-pixabay-280222.jpg', '2023-09-24 14:37:22', 0, 'Atif Ashraf_34_1.jpeg', 'Atif Ashraf_34_2.png', 'Atif Ashraf_34_3.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `Name` text NOT NULL,
  `Password` text NOT NULL,
  `Profile Picture` text DEFAULT NULL,
  `Role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Name`, `Password`, `Profile Picture`, `Role`) VALUES
(39, 'Atif Ashraf', '$2y$10$Joz49svHGq9F5R05NFctkuQRYr.9K3I8uKjm18jbcYQC69fnlsG2u', 'Atif Ashraf_1696358596.jpg', 'Admin'),
(41, 'King', '$2y$10$g2MNugXqLcvw.RTFBgyj4uQ5YDnSrSSAa78pqz9Q2GWnjfUe2Nuru', '65380fb540234_53cbc9cf4c32d668b68850c543b7f9c0-removebg-preview.png', 'User');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
