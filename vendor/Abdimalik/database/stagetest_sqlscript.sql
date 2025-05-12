-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 12:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stagetest`
--

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `beschrijving` varchar(255) NOT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `bijgewerkt_op` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `naam`, `beschrijving`, `aangemaakt_op`, `bijgewerkt_op`) VALUES
(1, 'Lunchmenu', 'Heerlijke lunchgerechten', '2025-05-12 10:36:09', '2025-05-12 10:36:09'),
(2, 'Dinerkaart', 'Uitgebreide selectie voor het diner', '2025-05-12 10:36:09', '2025-05-12 10:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `beschrijving` varchar(255) NOT NULL,
  `prijs` decimal(8,2) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `aangemaakt_op` timestamp NOT NULL DEFAULT current_timestamp(),
  `bijgewerkt_op` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `naam`, `beschrijving`, `prijs`, `menu_id`, `aangemaakt_op`, `bijgewerkt_op`) VALUES
(1, 'Broodje gezond', 'Vers broodje met kaas, ham en groenten', 6.50, 1, '2025-05-12 10:36:16', '2025-05-12 10:36:16'),
(2, 'Soep van de dag', 'Dagverse soep met brood', 5.00, 1, '2025-05-12 10:36:16', '2025-05-12 10:36:16'),
(3, 'Hamburger', 'Runderburger met friet en salade', 12.00, 2, '2025-05-12 10:36:16', '2025-05-12 10:36:16'),
(4, 'Vegetarische pasta', 'Pasta met seizoensgroenten', 11.50, 2, '2025-05-12 10:36:16', '2025-05-12 10:36:16'),
(5, 'Biefstuk', 'Gegrilde biefstuk met saus naar keuze', 18.00, 2, '2025-05-12 10:36:16', '2025-05-12 10:36:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu` (`menu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `fk_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
