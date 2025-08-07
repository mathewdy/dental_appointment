-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2025 at 09:53 AM
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
(53, 20258165, 20251724, 20257136, 'Wisdom tooth', 1, '10:14 AM to 11:14 AM', '07/04/2025', '2025-07-03', '2025-07-13', '', 1),
(54, 20258165, 20251724, 20254525, 'Composite Restoration', 1, '11:14 AM to 12:14 PM', '07/05/2025', '2025-07-03', '2025-07-05', 'Sample', 1),
(55, 20258165, 20257193, 20254804, 'US Plastic', 1, '01:14 PM to 02:14 PM', '07/26/2025', '2025-07-05', '2025-07-05', 'Sample ikalawa', 1),
(57, 20258165, 20256914, 20257824, 'Oral Prophylaxis', 1, '10:14 AM to 11:14 AM', '07/19/2025', '2025-07-19', '2025-07-19', 'asdas', NULL),
(58, 20258165, 20255885, 20256487, 'Oral Prophylaxis', 1, '10:14 AM to 11:14 AM', '07/25/2025', '2025-07-24', '2025-07-24', 'Nice man', NULL),
(61, 20255794, 20256914, 20254928, 'Composite Restoration', 2, '10:55 AM to 11:55 AM', '11/08/2025', '2025-08-07', '2025-08-07', NULL, NULL),
(62, 20255794, 20256914, 20259499, 'Composite Restoration', 2, '11:00 AM to 12:00 PM', '08/07/2025', '2025-08-07', '2025-08-07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `hasRead` tinyint(1) NOT NULL,
  `type` varchar(150) NOT NULL,
  `createdAt` datetime NOT NULL,
  `createdBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `message`, `hasRead`, `type`, `createdAt`, `createdBy`) VALUES
(1, 20258165, 'New Appointment Request', 0, 'Appointment', '2025-07-19 00:17:35', 20256914),
(2, 20258165, 'New Appointment Request', 0, 'Appointment', '2025-07-23 00:35:57', 20255885),
(3, 20258165, 'New Appointment Request', 0, 'Appointment', '0000-00-00 00:00:00', 20256914),
(4, 20255794, 'New Appointment Request', 0, 'Appointment', '2025-08-07 00:00:00', 20256914),
(5, 20255794, 'New Appointment Request', 0, 'Appointment', '2025-08-07 00:00:00', 20256914);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `services` varchar(200) NOT NULL,
  `initial_balance` int(11) DEFAULT NULL,
  `remaining_balance` varchar(110) NOT NULL,
  `is_deducted` int(11) DEFAULT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_id`, `user_id`, `services`, `initial_balance`, `remaining_balance`, `is_deducted`, `date_created`, `date_updated`) VALUES
(9, 20252858, 20251724, 'Composite Restoration', 5000, '0', 1, '2025-07-06', '2025-08-07'),
(10, 202545134, 20251724, 'Wisdom tooth', 5000, '4000', 1, '2025-07-06', '2025-08-07');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `payment_received` int(11) NOT NULL,
  `payment_method` varchar(110) DEFAULT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `payment_id`, `payment_received`, `payment_method`, `date_created`, `date_updated`) VALUES
(3, 202545134, 1000, 'cash', '2025-07-06', '2025-07-06'),
(4, 20252858, 452, 'Cash', '2025-08-07', '2025-08-07'),
(5, 20252858, 4548, 'Cash', '2025-08-07', '2025-08-07'),
(6, 202545134, 4001, 'Cash', '2025-08-07', '2025-08-07');

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
(23, 20255794, 'Monday, Tuesday, Wednesday, Thursday, Friday, Saturday', '11:00', '17:00', '2025-05-12', '2025-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `price_2` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `price`, `price_2`) VALUES
(1, 'Oral Prophylaxis', '800', ''),
(2, 'Composite Restoration', '800', '1500'),
(3, 'Cosmetic Dentistry (Direct Composite Veneers)', '2000', ''),
(4, 'Dental Extraction / Surgery', '800', '1000'),
(5, 'Wisdom tooth', '4000', '15000'),
(6, 'Prosthodontics (Dentures)', '20000', ''),
(7, 'Fixed (crown & bridge)', '5000', '6000'),
(8, 'Orthodontics (Braces)', '50000', '65000'),
(9, 'Removable dentures', '8000', '10000'),
(10, 'US Plastic', '4000', '8000'),
(11, 'Porcelain', '5500', '10000'),
(12, 'Flexible', '9000', '15000');

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
(37, 20256914, 1, 'Keelie', 'Buffy', 'Sydney', 'Oscar', 'zemuf@mailinator.com', '$2y$10$zFQeA8DJGs5Qj/4Hzq/HsuLFqXajHmtI5KfefCY9Q2.g2jCW62hya', '2009-09-28', '2025-05-12', '2025-05-12', NULL, '', '29756'),
(38, 20258485, 2, 'Fitzgerald', 'Octavia', 'Robert', 'Moana', 'vemimo@mailinator.com', '$2y$10$OEN8VNt7hw84.sEu6byjuOQBwE6BtefEYcc2gbjDBJ4Ppk.lInR3i', '1995-11-11', '2025-05-12', '2025-05-12', NULL, NULL, '60239'),
(39, 20258165, 3, 'Mona', 'Stacey', 'Jelani', 'Prescott', 'rozypepadi@mailinator.com', '$2y$10$8wsRTbgsFSZnp2MriojtRukWabtm2n2Qomi6g8I/e7R1pOzry8aDG', '1978-10-24', '2025-05-12', '2025-05-12', NULL, NULL, '26490'),
(40, 20255794, 3, 'Stephanie', 'Mallory', 'Lacy', 'Austin', 'tybemodily@mailinator.com', '$2y$10$naWPr0AYeF/yCsGodcNXiuYkmRKmcamS.e/6INj4pxPlpKx6TjMEK', '1970-05-09', '2025-05-12', '2025-08-07', NULL, NULL, '90186'),
(41, 20253698, 1, 'Macey', 'Graham', 'Felix', 'Xantha', '', '$2y$10$bZ4UQutLSdh76oJj0K.6QuveMofnbZISNMbWPnErVJMN.RRj.j/T6', '2018-02-26', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(42, 20257193, 1, 'Colette', 'Cyrus', 'Celeste', 'Tanisha', 'zubuqyb@mailinator.com', '$2y$10$fTMa8Mnju2nyflQVfoFB4.qdfOuc3o.jWHJaKV5flpjT45JSm0SWm', '2008-07-21', '2025-05-14', '2025-05-14', NULL, NULL, '90473'),
(43, 20257931, 1, 'Dara', 'Holly', 'Iona', 'Cassidy', 'rexahiqif@mailinator.com', '$2y$10$kTj7ySsKQ1lBvY8mwrMkg.55CgBt91BVFpwgztTVNUKv9OuptcW3.', '1997-03-11', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(44, 20252190, 1, 'Ross', 'Anne', 'Colton', 'Bell', 'bemyposyv@mailinator.com', '$2y$10$xnIq5lb0fgXudF9kIDBFcuZBidwLDuIKfwAAK5iWIlSOZtyR5/TZi', '2007-05-07', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(45, 20256526, 1, 'Giselle', 'Kathleen', 'Illiana', 'Gisela', 'johnpatrickdelmundoauro@gmail.com', '$2y$10$gsx28GAAwbKr2yl6ZBlmMOr83ddlMDpPBQ5iQTRZSEbX7X59DWnkS', '1992-02-04', '2025-05-24', '2025-05-24', NULL, NULL, '61853'),
(46, 20251724, 1, 'Ahmed', 'Cameran', 'Armand', 'Sybil', 'hocitoseja@mailinator.com', '$2y$10$WGr81gAMkitTj8duyI3XK.ppJAfnhKn3KLhCA0pb/uQ83Y4aIL3V2', '1982-07-02', '2025-05-31', '2025-05-31', NULL, NULL, '57390'),
(47, 20258543, 2, 'Madison', 'Erin', 'Deacon', 'Hasad', 'bepybe@mailinator.com', '$2y$10$tkKtC89UTD.uDPt2gsGhg.BrTF1NFZE548fYaIRUrnuJAznRcNEtC', '2005-08-20', '2025-05-31', '2025-05-31', NULL, NULL, '07135'),
(48, 20255885, 1, 'aseasfd', 'asdasd', 'asdasdasd', '09567521753', 'ryantecling@gmail.com', '$2y$10$UG6m3ZIg1knF3Ix3Nzcr3OuNqPBnpQuiUQKr/E1jBVlS8nymh2JqS', '2025-07-08', '2025-07-19', '2025-07-19', NULL, NULL, '46501');

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
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`);

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
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
