-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 05:59 PM
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
  `user_id` varchar(255) NOT NULL,
  `day` varchar(150) NOT NULL,
  `time` varchar(100) NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `user_id`, `day`, `time`, `date_created`, `date_updated`) VALUES
(6, '20258557', 'Wednesday Saturday', '14:27', '2025-05-02', '2025-05-02'),
(7, '20257019', 'Thursday Saturday', '02:52', '2025-05-02', '2025-05-02'),
(8, '20257825', 'Thursday Saturday', '21:37', '2025-05-02', '2025-05-02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_created` date NOT NULL,
  `date_updated` date NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `role_id`, `first_name`, `middle_name`, `last_name`, `mobile_number`, `email`, `password`, `date_of_birth`, `date_created`, `date_updated`, `token`) VALUES
(5, '202510175', 2, 'mathew', 'dalisay', 'Dakota', 'Jemima', 'mathewdalisay1@gmail.com', '$2y$10$2keq.iS/tKxKIGpD51Kef.m7TgCHIxlljH88LWqsyEXa5Fcvh6ALi', '2005-08-17', '2025-05-02', '2025-05-02', '9eb35bf094469a6c10087defe5651560'),
(6, '20256264', 2, 'Hilary', 'Branden', 'Gretchen', 'Knox', 'xemymyqaju@mailinator.com', '$2y$10$hcLbSs6VZtpJtGoUtfkLnecTWIwYJ9bwJ6IDxy61FePTzCQHgr1tG', '2015-01-28', '2025-05-02', '2025-05-02', ''),
(7, '20257257', 2, 'Mechelle', 'Cody', 'Sybill', 'Imelda', 'hogefah@mailinator.com', '$2y$10$LErVETC750eOZ9CrDX9FYeucbWMFh13.SWkgfaX/2P43v1n56AzA6', '2010-07-23', '2025-05-02', '2025-05-02', ''),
(8, '20258557', 3, 'Shellie', 'Blaze', 'Lacota', 'Maisie', 'peqo@mailinator.com', '$2y$10$h3RfPh.hh50p1npPWPevKOlqtdZPuWzpHEel6CKJxulp929AJtN7S', '2016-07-08', '2025-05-02', '2025-05-02', ''),
(9, '20257019', 3, 'Demetria', 'Amy', 'Vladimir', 'Garrett', 'kiqem@mailinator.com', '$2y$10$I087h3h/ks4tmZEvsb81ZOw.EjRQdKAGk4Xr/CqiwPR0sqXGMuAce', '2007-02-12', '2025-05-02', '2025-05-02', ''),
(10, '20257825', 3, 'Nola', 'Elton', 'Hillary', 'Arsenio', 'risizog@mailinator.com', '$2y$10$wXbZoNsaTYtCrbc7boBW6uF23.akb1RmtqtNCWXF4XnipcFrpNQDm', '1991-03-06', '2025-05-02', '2025-05-02', ''),
(11, '20254583', 1, 'Iliana', 'Dennis', 'Beatrice', 'Aquila', 'mathewdalisay@gmail.com', '$2y$10$H/LEMI9kUujYIlIMvml/..vO45NpCg0pVFOg/xcmC6X/y27WLWTJK', '2010-11-28', '2025-05-02', '2025-05-02', '997ed20d681cef28b00bbc07a88c0b06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
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
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
