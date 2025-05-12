-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 07:38 AM
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
-- Database: `dental_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_id_patient` int(11) NOT NULL,
  `appointment_id` int(110) NOT NULL,
  `concern` varchar(255) NOT NULL,
  `confirmed` int(11) NOT NULL,
  `appointment_date` varchar(100) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `walk_in` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `user_id_patient`, `appointment_id`, `concern`, `confirmed`, `appointment_date`, `date_created`, `date_updated`, `remarks`, `walk_in`) VALUES
(35, 20256518, 20255094, 20255851, 'sample 1 ', 0, '05/30/2025', '2025-05-12', '2025-05-12', NULL, 1),
(36, 20256518, 20255859, 20256470, 'sample 2', 0, '05/30/2025', '2025-05-12', '2025-05-12', NULL, 1),
(37, 202510810, 20255859, 20259587, 'hahahahaha mathew 2 ', 0, '05/27/2025', '2025-05-12', '2025-05-12', NULL, NULL),
(38, 202510810, 20255859, 20254137, 'hahaha', 0, '05/06/2025', '2025-05-12', '2025-05-12', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`user_id_patient`),
  ADD KEY `user_id_patient` (`user_id_patient`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`user_id_patient`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
