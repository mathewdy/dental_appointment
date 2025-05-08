-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 05:13 PM
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
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `user_id_patient`, `appointment_id`, `concern`, `confirmed`, `appointment_date`, `date_created`, `date_updated`, `remarks`) VALUES
(20, 20256432, 20251843, 20259685, 'haha', 1, '05/29/2025', '2025-05-08', '2025-05-08', ''),
(21, 20256432, 20251843, 202510068, 'hahahaha', 2, '05/31/2025', '2025-05-08', '2025-05-08', ''),
(22, 20256432, 20251843, 20252071, 'hahaha', 1, '08/16/2025', '2025-05-08', '2025-05-08', 'tanga ka ba doi '),
(23, 20256432, 20251843, 20257382, 'hahahahahaha ', 1, '06/14/2025', '2025-05-08', '2025-05-08', ''),
(24, 20258970, 20259281, 20259491, 'haha woah', 0, '05/28/2025', '2025-05-08', '2025-05-08', ''),
(25, 20258970, 20259281, 20252050, 'mathew ', 0, '05/24/2025', '2025-05-08', '2025-05-08', ''),
(26, 20256432, 20259281, 20253879, 'hahaha', 1, '06/28/2025', '2025-05-08', '2025-05-08', 'dahan-dahan ka lang');

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
(11, 20257230, 'Monday, Wednesday, Thursday, Friday, Saturday', '11:27', '17:00', '2025-05-07', '2025-05-07'),
(12, 20256432, 'Monday, Thursday, Saturday', '10:55', '16:36', '2025-05-07', '2025-05-07'),
(13, 20258970, 'Wednesday, Saturday', '11:49', '16:26', '2025-05-08', '2025-05-08');

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
(15, 20258428, 2, 'Madonna', 'Claire', 'Hedwig', 'Zeph', 'didapa@mailinator.com', '$2y$10$IQK.eXv7wSwZ8jxt/cJANOFJZexezHPrPL0gnWsBUx5XEQyK3uIXu', '2022-09-13', '2025-05-07', '2025-05-07', NULL, NULL, NULL),
(17, 20257230, 2, 'Brynn', 'Judah', 'Clayton', 'Oliver', 'elephant10630@dotzi.net', '$2y$10$TaDAiWN1ZqXI0y8i2tbSfOY9x7HdheNSac1wqoipvBZesIgpLJ0l.', '2024-05-25', '2025-05-07', '2025-05-07', NULL, NULL, '37896'),
(18, 20256432, 3, 'Fay', 'Shay', 'Ariana', 'Christian', 'elephant10630@dotzi.net1', '$2y$10$koIRKJxmCb8.zwVlgoZ9I.0qtMAvGU7h2f4qf3k66xyBw./cR9KnG', '1970-11-15', '2025-05-07', '2025-05-07', NULL, NULL, '70216'),
(19, 20251843, 1, 'Judah', 'Eric', 'Brittany', 'Odysseus', 'hojiyap273@benznoi.com', '$2y$10$KNx3GsJF5i/c/E0N8/I70ustpijTffdAUL5fNS0apnLbZRn4j0Khi', '1979-10-10', '2025-05-07', '2025-05-07', NULL, NULL, '43678'),
(20, 20259281, 1, 'Meredith', 'Kamal', 'Emmanuel', 'Howard', 'nenuxiwuk@mailinator.com', '$2y$10$G1/iE1l5cLW5mpRuZ3oRNOAYgLSWGDfFPTI/M0nelX3YdlVPKSTdK', '1982-12-01', '2025-05-08', '2025-05-08', NULL, NULL, '06718'),
(21, 20255050, 2, 'Uriel', 'Armando', 'Nevada', 'Gage', 'nihyl@mailinator.com', '$2y$10$oFzbnk0AAGUPtkjxu85LMeMhhnko4/voagcsBBGmwajnLxO0eUiWe', '1982-10-02', '2025-05-08', '2025-05-08', NULL, NULL, '60438'),
(22, 20258970, 3, 'Vaughan', 'Madison', 'Naida', 'Scarlett', 'mewoge@mailinator.com', '$2y$10$Z.AdREc/k2JREsjYGi/RK.qQS5TUODBzxbcqHcQ23rdpkl81tnejG', '2021-10-24', '2025-05-08', '2025-05-08', NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
