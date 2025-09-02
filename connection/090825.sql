-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2025 at 06:36 AM
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
(37, 20256914, 1, 'Keelie', 'Buffy', 'Sydney', 'Oscar', 'mathewdalisay@gmail.com', '$2y$10$zFQeA8DJGs5Qj/4Hzq/HsuLFqXajHmtI5KfefCY9Q2.g2jCW62hya', '2009-09-28', '2025-05-12', '2025-05-12', NULL, '', '89046'),
(38, 20258485, 2, 'Fitzgerald', 'Octavia', 'Robert', 'Moana', 'vemimo@mailinator.com', '$2y$10$OEN8VNt7hw84.sEu6byjuOQBwE6BtefEYcc2gbjDBJ4Ppk.lInR3i', '1995-11-11', '2025-05-12', '2025-05-12', NULL, NULL, '75316'),
(39, 20258165, 3, 'Mona', 'Stacey', 'Jelani', 'Prescott', 'rozypepadi@mailinator.com', '$2y$10$8wsRTbgsFSZnp2MriojtRukWabtm2n2Qomi6g8I/e7R1pOzry8aDG', '1978-10-24', '2025-05-12', '2025-08-31', NULL, NULL, '38276'),
(40, 20255794, 3, 'Stephanie', 'Mallory', 'Lacy', 'Austin', 'tybemodily@mailinator.com', '$2y$10$naWPr0AYeF/yCsGodcNXiuYkmRKmcamS.e/6INj4pxPlpKx6TjMEK', '1970-05-09', '2025-05-12', '2025-08-07', NULL, NULL, '60347'),
(41, 20253698, 1, 'Macey', 'Graham', 'Felix', 'Xantha', '', '$2y$10$bZ4UQutLSdh76oJj0K.6QuveMofnbZISNMbWPnErVJMN.RRj.j/T6', '2018-02-26', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(42, 20257193, 1, 'Colette', 'Cyrus', 'Celeste', 'Tanisha', 'zubuqyb@mailinator.com', '$2y$10$fTMa8Mnju2nyflQVfoFB4.qdfOuc3o.jWHJaKV5flpjT45JSm0SWm', '2008-07-21', '2025-05-14', '2025-05-14', NULL, NULL, '90473'),
(43, 20257931, 1, 'Dara', 'Holly', 'Iona', 'Cassidy', 'rexahiqif@mailinator.com', '$2y$10$kTj7ySsKQ1lBvY8mwrMkg.55CgBt91BVFpwgztTVNUKv9OuptcW3.', '1997-03-11', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(44, 20252190, 1, 'Ross', 'Anne', 'Colton', 'Bell', 'bemyposyv@mailinator.com', '$2y$10$xnIq5lb0fgXudF9kIDBFcuZBidwLDuIKfwAAK5iWIlSOZtyR5/TZi', '2007-05-07', '2025-05-14', '2025-05-14', NULL, NULL, NULL),
(45, 20256526, 1, 'Giselle', 'Kathleen', 'Illiana', 'Gisela', 'johnpatrickdelmundoauro@gmail.com', '$2y$10$gsx28GAAwbKr2yl6ZBlmMOr83ddlMDpPBQ5iQTRZSEbX7X59DWnkS', '1992-02-04', '2025-05-24', '2025-05-24', NULL, NULL, '61853'),
(46, 20251724, 1, 'Ahmed', 'Cameran', 'Armand', 'Sybil', 'hocitoseja@mailinator.com', '$2y$10$WGr81gAMkitTj8duyI3XK.ppJAfnhKn3KLhCA0pb/uQ83Y4aIL3V2', '1982-07-02', '2025-05-31', '2025-05-31', NULL, NULL, '57390'),
(47, 20258543, 2, 'Madison', 'Erin', 'Deacon', 'Hasad', 'bepybe@mailinator.com', '$2y$10$tkKtC89UTD.uDPt2gsGhg.BrTF1NFZE548fYaIRUrnuJAznRcNEtC', '2005-08-20', '2025-05-31', '2025-05-31', NULL, NULL, '07135'),
(48, 20255885, 1, 'aseasfd', 'asdasd', 'asdasdasd', '09567521753', 'ryantecling@gmail.com', '$2y$10$UG6m3ZIg1knF3Ix3Nzcr3OuNqPBnpQuiUQKr/E1jBVlS8nymh2JqS', '2025-07-08', '2025-07-19', '2025-07-19', NULL, NULL, '46501'),
(49, 20252087, 3, 'Quinn', 'Mcconnell', 'Ward', 'Calderon', 'funipa@mailinator.com', '$2y$10$aIuIIofbfLv3C6yHoCBO2OGXr4wIxl6ebf7V0WobVjXIqeCYdYA5y', '2021-07-16', '2025-09-02', '0000-00-00', NULL, NULL, NULL),
(50, 20254714, 3, 'Barrett', 'Rhodes', 'Burton', 'Pennington', 'vokasezy@mailinator.com', '$2y$10$HCAChH30XmjblWGktB5GcO0Z24gm.yZf0.m/wIk2DKYvl84iBlH8i', '1987-02-24', '2025-09-02', '0000-00-00', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
