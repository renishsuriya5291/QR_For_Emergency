-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2024 at 08:07 PM
-- Server version: 8.0.36-0ubuntu0.20.04.1
-- PHP Version: 7.4.3-4ubuntu2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quicksos`
--

-- --------------------------------------------------------

--
-- Table structure for table `family_group`
--

CREATE TABLE `family_group` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group_created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr_code`
--

CREATE TABLE `qr_code` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'none',
  `hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `uid` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone_no` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uid`, `email`, `phone_no`, `photo`, `full_name`, `created_at`, `updated_at`) VALUES
(1, 'asdf2', 'foo2@foo.foo', NULL, NULL, 'Foo bar2', '2024-04-28 09:29:44', '2024-04-28 09:29:44'),
(3, '108700366339561414170', 'lyricalboii001@gmail.com', NULL, NULL, 'lyrical boii', '2024-04-28 09:37:24', '2024-04-28 09:37:24'),
(4, '114021791904503323216', 'meetsilverfly@gmail.com', NULL, NULL, 'meet dobariya', '2024-04-28 09:37:43', '2024-04-28 09:37:43'),
(5, '100347603269425246940', 'renishsuriya1441@gmail.com', NULL, NULL, 'Renish Suriya', '2024-04-29 13:24:54', '2024-04-29 13:24:54'),
(6, '113667327802780860519', 'd23cs096@charusat.edu.in', NULL, NULL, 'D23CS096 SURIYA RENISH MUKESHBHAI', '2024-04-30 20:00:51', '2024-04-30 20:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_signin_logs`
--

CREATE TABLE `user_signin_logs` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `is_logout` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_to_group`
--

CREATE TABLE `user_to_group` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `group_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `family_group`
--
ALTER TABLE `family_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `family_group_group_created_by_foreign` (`group_created_by`) USING BTREE;

--
-- Indexes for table `qr_code`
--
ALTER TABLE `qr_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hash` (`hash`),
  ADD KEY `qr_code_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `phone_no` (`phone_no`);

--
-- Indexes for table `user_signin_logs`
--
ALTER TABLE `user_signin_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_id` (`session_id`),
  ADD KEY `user_signin_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_to_group`
--
ALTER TABLE `user_to_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_to_group_user_id_foreign` (`user_id`),
  ADD KEY `user_to_group_group_id_foreign` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `family_group`
--
ALTER TABLE `family_group`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qr_code`
--
ALTER TABLE `qr_code`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_signin_logs`
--
ALTER TABLE `user_signin_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_to_group`
--
ALTER TABLE `user_to_group`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `family_group`
--
ALTER TABLE `family_group`
  ADD CONSTRAINT `family_group_user_id_foreign` FOREIGN KEY (`group_created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `qr_code`
--
ALTER TABLE `qr_code`
  ADD CONSTRAINT `qr_code_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_signin_logs`
--
ALTER TABLE `user_signin_logs`
  ADD CONSTRAINT `user_signin_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_to_group`
--
ALTER TABLE `user_to_group`
  ADD CONSTRAINT `user_to_group_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `family_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_to_group_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
