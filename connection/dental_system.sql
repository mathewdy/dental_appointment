-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2025 at 06:07 PM
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
  `appointment_time` varchar(100) NOT NULL,
  `appointment_date` varchar(100) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `walk_in` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `user_id_patient`, `appointment_id`, `concern`, `confirmed`, `appointment_time`, `appointment_date`, `date_created`, `date_updated`, `remarks`, `walk_in`) VALUES
(39, 20258165, 20256914, 20254060, 'haha', 2, '', '05/31/2025', '2025-05-12', '2025-05-12', NULL, 0),
(40, 20255794, 20256914, 20255996, 'sample concern 2 ', 1, '', '06/28/2025', '2025-05-14', '2025-05-14', 'Completed transaction ', 1),
(41, 20255794, 20257193, 20256762, 'haha ', 1, '', '12/27/2025', '2025-05-21', '2025-05-21', 'tapos na ito mag pa brace', 0),
(42, 20255794, 20252190, 20251773, 'hahaha', 0, '', '05/31/2025', '2025-05-24', '2025-05-24', NULL, 1),
(43, 20255794, 20256526, 20251261, 'Porcelain', 0, '', '05/31/2025', '2025-05-24', '2025-05-24', NULL, 1),
(44, 20258165, 20251724, 20251249, 'Prosthodontics', 2, '', '12/27/2025', '2025-05-31', '2025-05-31', NULL, NULL),
(45, 20258165, 20251724, 20257495, 'Porcelain', 0, '', '05/31/2025', '2025-05-31', '2025-05-31', NULL, NULL),
(46, 20255794, 20251724, 202510410, 'Fixed (crown & bridge)', 2, '', '06/07/2025', '2025-05-31', '2025-05-31', NULL, NULL),
(47, 20258165, 20251724, 20257553, 'Fixed (crown & bridge)', 0, '', '07/26/2025', '2025-05-31', '2025-05-31', NULL, NULL),
(48, 20258165, 20251724, 20257521, 'Porcelain', 0, '', '06/28/2025', '2025-06-28', '2025-06-28', NULL, 1),
(49, 20258165, 20251724, 20255452, 'Fixed (crown & bridge)', 0, '12:14 PM to 01:14 PM', '06/30/2025', '2025-06-28', '2025-06-28', NULL, 1),
(50, 20255794, 20256914, 20257431, 'Removable dentures', 2, '01:55 PM to 02:55 PM', '07/26/2025', '2025-06-28', '2025-06-28', NULL, NULL),
(51, 20255794, 20256914, 20258139, 'Removable dentures', 0, '11:55 AM to 12:55 PM', '07/05/2025', '2025-06-29', '2025-06-29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Patient'),
(2, 'Admin'),
(3, 'Doctor');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `day` varchar(150) NOT NULL,
  `start_time` varchar(100) NOT NULL,
  `end_time` varchar(100) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `user_id`, `day`, `start_time`, `end_time`, `date_created`, `date_updated`) VALUES
(22, 20258165, 'Monday, Friday, Saturday', '10:14', '16:51', '2025-05-12', '2025-05-12'),
(23, 20255794, 'Saturday', '10:55', '16:19', '2025-05-12', '2025-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `otp` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `role_id`, `first_name`, `middle_name`, `last_name`, `mobile_number`, `email`, `password`, `date_of_birth`, `date_created`, `date_updated`, `token`, `address`, `otp`) VALUES
(37, 20256914, 1, 'Keelie', 'Buffy', 'Sydney', 'Oscar', 'zemuf@mailinator.com', '$2y$10$zFQeA8DJGs5Qj/4Hzq/HsuLFqXajHmtI5KfefCY9Q2.g2jCW62hya', '2009-09-28', '2025-05-12', '2025-05-12', NULL, '', '50498'),
(38, 20258485, 2, 'Fitzgerald', 'Octavia', 'Robert', 'Moana', 'vemimo@mailinator.com', '$2y$10$OEN8VNt7hw84.sEu6byjuOQBwE6BtefEYcc2gbjDBJ4Ppk.lInR3i', '1995-11-11', '2025-05-12', '2025-05-12', NULL, NULL, '61325'),
(39, 20258165, 3, 'Mona', 'Stacey', 'Jelani', 'Prescott', 'rozypepadi@mailinator.com', '$2y$10$8wsRTbgsFSZnp2MriojtRukWabtm2n2Qomi6g8I/e7R1pOzry8aDG', '1978-10-24', '2025-05-12', '2025-05-12', NULL, NULL, '74102'),
(40, 20255794, 3, 'Stephanie', 'Mallory', 'Lacy', 'Austin', 'tybemodily@mailinator.com', '$2y$10$naWPr0AYeF/yCsGodcNXiuYkmRKmcamS.e/6INj4pxPlpKx6TjMEK', '1970-05-09', '2025-05-12', '2025-05-12', NULL, NULL, '90186'),
(41, 20253698, 1, 'Macey', 'Graham', 'Felix', 'Xantha', '', '$2y$10$bZ4UQutLSdh76oJj0K.6QuveMofnbZISNMbWPnErVJMN.RRj.j/T6', '2018-02-26', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(42, 20257193, 1, 'Colette', 'Cyrus', 'Celeste', 'Tanisha', 'zubuqyb@mailinator.com', '$2y$10$fTMa8Mnju2nyflQVfoFB4.qdfOuc3o.jWHJaKV5flpjT45JSm0SWm', '2008-07-21', '2025-05-14', '2025-05-14', NULL, NULL, '90473'),
(43, 20257931, 1, 'Dara', 'Holly', 'Iona', 'Cassidy', 'rexahiqif@mailinator.com', '$2y$10$kTj7ySsKQ1lBvY8mwrMkg.55CgBt91BVFpwgztTVNUKv9OuptcW3.', '1997-03-11', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(44, 20252190, 1, 'Ross', 'Anne', 'Colton', 'Bell', 'bemyposyv@mailinator.com', '$2y$10$xnIq5lb0fgXudF9kIDBFcuZBidwLDuIKfwAAK5iWIlSOZtyR5/TZi', '2007-05-07', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(45, 20256526, 1, 'Giselle', 'Kathleen', 'Illiana', 'Gisela', 'johnpatrickdelmundoauro@gmail.com', '$2y$10$gsx28GAAwbKr2yl6ZBlmMOr83ddlMDpPBQ5iQTRZSEbX7X59DWnkS', '1992-02-04', '2025-05-24', '2025-05-24', NULL, NULL, '61853'),
(46, 20251724, 1, 'Ahmed', 'Cameran', 'Armand', 'Sybil', 'hocitoseja@mailinator.com', '$2y$10$WGr81gAMkitTj8duyI3XK.ppJAfnhKn3KLhCA0pb/uQ83Y4aIL3V2', '1982-07-02', '2025-05-31', '2025-05-31', NULL, NULL, '57390'),
(47, 20258543, 2, 'Madison', 'Erin', 'Deacon', 'Hasad', 'bepybe@mailinator.com', '$2y$10$tkKtC89UTD.uDPt2gsGhg.BrTF1NFZE548fYaIRUrnuJAznRcNEtC', '2005-08-20', '2025-05-31', '2025-05-31', NULL, NULL, '07135');

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`user_id_patient`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
