-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2025 at 04:16 PM
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
(69, 20255794, 20254293, 20255827, 'Porcelain', 1, '11:00 AM to 12:00 PM', '09/02/2025', '2025-09-02', '0000-00-00', '', 1),
(70, 20255794, 20252342, 20256841, 'Fixed (crown & bridge)', 1, '11:00 AM to 12:00 PM', '09/02/2025', '2025-09-02', '2025-09-02', '', NULL),
(71, 20258076, 20252342, 20255980, 'Wisdom tooth', 2, '10:49 AM to 11:49 AM', '09/06/2025', '2025-09-02', '2025-09-02', NULL, NULL),
(72, 20258076, 20251724, 20258602, 'Flexible', 1, '12:49 PM to 01:49 PM', '09/02/2025', '2025-09-02', '2025-09-02', NULL, 1),
(73, 20254836, 20252190, 20252635, 'Porcelain', 1, '10:36 AM to 11:36 AM', '09/03/2025', '2025-09-03', '2025-09-03', NULL, 1);

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
(6, 20255794, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 13:15:37', 20254820),
(7, 20251724, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 13:15:37', 20254820),
(8, 20255794, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 13:17:26', 20254820),
(9, 20256914, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 13:17:26', 20254820),
(10, 20251724, 'Initial Balance Added', 0, 'Payment', '2025-09-02 13:18:53', 2025),
(11, 20254820, 'Initial Balance Added', 0, 'Payment', '2025-09-02 13:18:53', 2025),
(12, 20255794, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 13:20:09', 20254820),
(13, 20253698, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 13:20:09', 20254820),
(14, 20255794, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 13:24:14', 20254820),
(15, 20254293, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 13:24:14', 20254820),
(16, 20255794, 'New Appointment Request', 0, 'Appointment', '2025-09-02 00:00:00', 20252342),
(17, 20258076, 'New Appointment Request', 0, 'Appointment', '2025-09-02 00:00:00', 20252342),
(18, 20258076, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 22:58:25', 20258485),
(19, 20251724, 'New Appointment Schedule', 0, 'Appointment', '2025-09-02 22:58:25', 20258485),
(20, 20252342, 'Initial Balance Added', 0, 'Payment', '2025-09-02 23:01:04', 2025),
(21, 20258485, 'Initial Balance Added', 0, 'Payment', '2025-09-02 23:01:04', 2025),
(22, 20254293, 'Initial Balance Added', 0, 'Payment', '2025-09-02 23:02:18', 2025),
(23, 20258485, 'Initial Balance Added', 0, 'Payment', '2025-09-02 23:02:18', 2025),
(24, 20254293, 'New Payment Transaction', 0, 'Payment', '2025-09-02 23:02:34', 2025),
(25, 20254836, 'New Appointment Schedule', 0, 'Appointment', '2025-09-03 22:11:56', 20255958),
(26, 20252190, 'New Appointment Schedule', 0, 'Appointment', '2025-09-03 22:11:56', 20255958),
(27, 20252190, 'Initial Balance Added', 0, 'Payment', '2025-09-03 22:12:35', 2025),
(28, 20255958, 'Initial Balance Added', 0, 'Payment', '2025-09-03 22:12:35', 2025),
(29, 20252190, 'New Payment Transaction', 0, 'Payment', '2025-09-03 22:12:44', 2025);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
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

INSERT INTO `payments` (`id`, `payment_id`, `user_id`, `appointment_id`, `services`, `initial_balance`, `remaining_balance`, `is_deducted`, `date_created`, `date_updated`) VALUES
(27, 202553198, 20251724, 202510670, 'US Plastic', 5000, '5000', NULL, '2025-09-02', '0000-00-00'),
(28, 20257542, 20252342, 20256841, 'Fixed (crown & bridge)', 5000, '5000', NULL, '2025-09-02', '0000-00-00'),
(29, 202514058, 20254293, 20255827, 'Porcelain', 2000, '1800', 1, '2025-09-02', '2025-09-02'),
(30, 202548740, 20252190, 20252635, 'Porcelain', 7000, '6200', 1, '2025-09-03', '2025-09-03');

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
(11, 202514058, 200, 'Cash', '2025-09-02', '0000-00-00'),
(12, 202548740, 800, 'Cash', '2025-09-03', '0000-00-00');

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
(23, 20255794, 'Monday, Tuesday, Wednesday, Thursday, Friday, Saturday', '11:00', '17:00', '2025-05-12', '2025-05-12'),
(24, 20259473, 'Monday, Friday', '10:20', '15:21', '2025-09-02', '0000-00-00'),
(25, 20254836, 'Monday, Tuesday, Wednesday, Thursday, Friday, Saturday', '10:36', '13:15', '2025-09-02', '2025-09-02'),
(26, 20258076, 'Monday, Tuesday, Wednesday, Friday, Saturday', '10:49', '15:53', '2025-09-02', '0000-00-00'),
(27, 20254967, 'Monday, Tuesday, Wednesday, Thursday, Friday', '11:23', '15:36', '2025-09-02', '2025-09-02'),
(28, 202510294, 'Monday, Tuesday, Thursday, Friday, Saturday', '10:00', '16:52', '2025-09-03', '0000-00-00'),
(29, 20255067, 'Wednesday, Friday, Saturday', '10:50', '15:44', '2025-09-16', '0000-00-00');

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
(37, 20256914, 1, 'Keelie', 'Buffy', 'Sydney', 'Oscar', 'zemuf@mailinator.com', '$2y$10$zFQeA8DJGs5Qj/4Hzq/HsuLFqXajHmtI5KfefCY9Q2.g2jCW62hya', '2009-09-28', '2025-05-12', '2025-05-12', NULL, '', '49637'),
(38, 20258485, 2, 'Fitzgerald', 'Octavia', 'Robert', 'Moana', 'vemimo@mailinator.com', '$2y$10$OEN8VNt7hw84.sEu6byjuOQBwE6BtefEYcc2gbjDBJ4Ppk.lInR3i', '1995-11-11', '2025-05-12', '2025-05-12', NULL, NULL, '59643'),
(40, 20255794, 3, 'Stephanie', 'Mallory', 'Lacy', 'Austin', 'tybemodily@mailinator.com', '$2y$10$naWPr0AYeF/yCsGodcNXiuYkmRKmcamS.e/6INj4pxPlpKx6TjMEK', '1970-05-09', '2025-05-12', '2025-08-07', NULL, NULL, '49728'),
(41, 20253698, 1, 'Macey', 'Graham', 'Felix', 'Xantha', '', '$2y$10$bZ4UQutLSdh76oJj0K.6QuveMofnbZISNMbWPnErVJMN.RRj.j/T6', '2018-02-26', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(42, 20257193, 1, 'Colette', 'Cyrus', 'Celeste', 'Tanisha', 'zubuqyb@mailinator.com', '$2y$10$fTMa8Mnju2nyflQVfoFB4.qdfOuc3o.jWHJaKV5flpjT45JSm0SWm', '2008-07-21', '2025-05-14', '2025-05-14', NULL, NULL, '90473'),
(43, 20257931, 1, 'Dara', 'Holly', 'Iona', 'Cassidy', 'rexahiqif@mailinator.com', '$2y$10$kTj7ySsKQ1lBvY8mwrMkg.55CgBt91BVFpwgztTVNUKv9OuptcW3.', '1997-03-11', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(44, 20252190, 1, 'Ross', 'Anne', 'Colton', 'Bell', 'bemyposyv@mailinator.com', '$2y$10$xnIq5lb0fgXudF9kIDBFcuZBidwLDuIKfwAAK5iWIlSOZtyR5/TZi', '2007-05-07', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(45, 20256526, 1, 'Giselle', 'Kathleen', 'Illiana', 'Gisela', 'johnpatrickdelmundoauro@gmail.com', '$2y$10$gsx28GAAwbKr2yl6ZBlmMOr83ddlMDpPBQ5iQTRZSEbX7X59DWnkS', '1992-02-04', '2025-05-24', '2025-05-24', NULL, NULL, '61853'),
(46, 20251724, 1, 'Ahmed', 'Cameran', 'Armand', 'Sybil', 'hocitoseja@mailinator.com', '$2y$10$WGr81gAMkitTj8duyI3XK.ppJAfnhKn3KLhCA0pb/uQ83Y4aIL3V2', '1982-07-02', '2025-05-31', '2025-05-31', NULL, NULL, '57390'),
(47, 20258543, 2, 'Madison', 'Erin', 'Deacon', 'Hasad', 'bepybe@mailinator.com', '$2y$10$tkKtC89UTD.uDPt2gsGhg.BrTF1NFZE548fYaIRUrnuJAznRcNEtC', '2005-08-20', '2025-05-31', '2025-05-31', NULL, NULL, '07135'),
(48, 20255885, 1, 'aseasfd', 'asdasd', 'asdasdasd', '09567521753', 'ryantecling@gmail.com', '$2y$10$UG6m3ZIg1knF3Ix3Nzcr3OuNqPBnpQuiUQKr/E1jBVlS8nymh2JqS', '2025-07-08', '2025-07-19', '2025-07-19', NULL, NULL, '46501'),
(49, 20259473, 3, 'Urielle', 'Tillman', 'Lee', 'Head', 'ciby@mailinator.com', '$2y$10$aB1XsEa5kiqfP7Adsjsol.AgkTAvVP7GZu0O/ENvtNlCP9E/TW8fm', '1977-11-19', '2025-09-02', '0000-00-00', NULL, NULL, NULL),
(50, 20254293, 1, 'Gay', 'Padilla', 'Sharpe', 'Head', 'cugufiba@mailinator.com', '$2y$10$YPgCqdWIJD2ENeIFiGAG7Oewl14xR3s22dLv7blZ/6hQl/teHNJui', '2005-08-31', '2025-09-02', '0000-00-00', NULL, NULL, NULL),
(51, 20254431, 2, 'MacKensie', 'Sigourney', 'Darius', '920', 'cyza@mailinator.com', '$2y$10$VVG.XYpQZj9k4l9zvhSfFOSd4d9nycNSMfmu8IabRxY8fzmY0FXqa', '2024-07-20', '2025-09-02', '2025-09-02', NULL, NULL, '73981'),
(52, 20254836, 3, 'Whitneysadas', 'Benjaminasd', 'Langasdasdasd', 'Benson', 'xezuguj@mailinator.com', '$2y$10$h5hdZOfQ1f3Xv8Y3cZMRh.rKCJdnXSJUnry6wrUxKqnfROlKKoMv2', '1998-04-01', '2025-09-02', '2025-09-02', NULL, NULL, NULL),
(53, 20252342, 1, 'mathew', 'francisco', 'dalisay', '09171379796', 'mathewdalisay@gmail.com', '$2y$10$/J7Cuv1cS1aoy4wT2QZ2x.Nt54M7X86zu.4ABHgHxJUMU.awi49HG', '2000-09-02', '2025-09-02', '2025-09-02', NULL, NULL, '19523'),
(54, 20255958, 2, 'Gisela', 'Dieter', 'Deborah', '436', 'cmdyzxcvbnm123@gmail.com', '$2y$10$jxTWgSmDfHKCAdSHrkLKzeTZ.8uldsRVTwZMJXDm64OV2GAtmO8p2', '1982-11-25', '2025-09-02', '2025-09-02', NULL, NULL, '14957'),
(55, 20258076, 3, 'Emily', 'Berg', 'Kent', 'Moody', 'watagu@mailinator.com', '$2y$10$LKAXN.diDzUed6OLQ59ce.C2y9qPQx3uicZcTCr6c4oSSgUDJwZ2S', '2015-07-02', '2025-09-02', '0000-00-00', NULL, NULL, NULL),
(56, 20255433, 1, 'Karyn', 'Vinson', 'Cervantes', 'Castaneda', 'junatana@mailinator.com', '$2y$10$ZSpSphRHAgdZ2mQExFZP6uWlye..XzF.1J68cfvc6STyHmWUco08q', '1989-07-12', '2025-09-02', '0000-00-00', NULL, NULL, NULL),
(57, 20254967, 3, 'Jenna1', 'Dixon', 'Rowland', 'Sutton', 'mogazylaqi@mailinator.com', '$2y$10$fpI1tZ9twFWYZN.9DvBFVOBmm.3Z5cnx1ERNbSH6kfdpc9YSqKclW', '1982-07-26', '2025-09-02', '2025-09-02', NULL, NULL, '27196'),
(58, 20254539, 1, 'James', 'Rivers', 'Neal', 'Randolph', 'jyfoda@mailinator.com', '$2y$10$IJfQOljxd2CCNgZR7xRHr.tLQj2wnW..ANq2a4NZeQMlJwHpDDvBi', '2000-09-04', '2025-09-03', '0000-00-00', NULL, NULL, NULL),
(59, 202510294, 3, 'Mary', 'Stanton', 'King', 'Tucker', 'johyz@mailinator.com', '$2y$10$Z/X2lZshLnC00f1xBcbBiuUJ0AdqpQZMTEvcccVDWKlLMAPLWnpHe', '2015-12-24', '2025-09-03', '0000-00-00', NULL, NULL, '32581'),
(60, 20255067, 3, 'Melanie', 'Douglas', 'Tyler', 'Terrell', 'vovysinis@mailinator.com', '$2y$10$z27CpAw1WmaSNbVUPL8EnOCKt4//eS171X9HQ/8zVPrbHbjlEE02C', '1979-01-31', '2025-09-16', '0000-00-00', NULL, NULL, NULL);

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
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `appointment_id` (`appointment_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
