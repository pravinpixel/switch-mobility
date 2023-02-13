-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 05:50 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `project_milestone`
--

CREATE TABLE `project_milestone` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `milestone` varchar(255) DEFAULT NULL,
  `mile_start_date` varchar(255) DEFAULT NULL,
  `mile_end_date` varchar(255) DEFAULT NULL,
  `levels_to_be_crossed` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_milestone`
--

INSERT INTO `project_milestone` (`id`, `project_id`, `milestone`, `mile_start_date`, `mile_end_date`, `levels_to_be_crossed`, `is_active`, `updated_at`, `created_at`) VALUES
(1, 1, 'Mile Stoned', '2023-01-23', '2023-01-26', '11', 1, '2023-01-27 16:43:48', '2023-01-27 16:43:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project_milestone`
--
ALTER TABLE `project_milestone`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project_milestone`
--
ALTER TABLE `project_milestone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
