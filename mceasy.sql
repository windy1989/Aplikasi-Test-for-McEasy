-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2022 at 09:03 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mceasy`
--
CREATE DATABASE IF NOT EXISTS `mceasy` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mceasy`;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` bigint(20) NOT NULL,
  `no` varchar(155) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `date_join` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `no`, `name`, `address`, `date_birth`, `date_join`, `created_at`, `updated_at`) VALUES
(1, 'IP0001', 'Yustinus Windy', 'Jl. Sumbawa Barat No. 101', '2022-01-03', '2022-05-19', '2022-05-20 07:46:01', '2022-05-21 09:21:28'),
(2, 'IP0002', 'Tedjo Setio', 'Jl. Pemuda 0001', '2021-12-21', '2022-05-18', '2022-05-20 07:46:52', '2022-05-21 09:21:39'),
(3, 'IP0003', 'Ika Edit', 'Jl. Tandes 100 Edit', '1990-01-05', '2022-05-21', '2022-05-21 08:58:07', '2022-05-21 09:24:36'),
(4, 'IP0004', 'Budi', 'Krakalan', '2022-05-21', '2022-05-22', '2022-05-21 08:59:02', '2022-05-21 08:59:02');

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave`
--

CREATE TABLE `employee_leave` (
  `id` bigint(20) NOT NULL,
  `employee_id` bigint(20) DEFAULT NULL,
  `date_leave` date DEFAULT NULL,
  `date_count` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_leave`
--

INSERT INTO `employee_leave` (`id`, `employee_id`, `date_leave`, `date_count`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-06-15', 2, 'Sakit Tipes', '2022-05-21 10:53:45', '2022-05-21 10:53:45'),
(2, 2, '2022-05-26', 10, 'Cuti ada kondangan (Edit)', '2022-05-21 10:54:20', '2022-05-21 11:08:40'),
(3, 4, '2022-05-01', 1, 'Kerja lembur', '2022-05-21 11:17:22', '2022-05-21 11:17:22'),
(5, 1, '2022-12-21', 1, 'Sakit', '2022-05-21 11:37:10', '2022-05-21 11:37:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_leave`
--
ALTER TABLE `employee_leave`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee_leave`
--
ALTER TABLE `employee_leave`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
