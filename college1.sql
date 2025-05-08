-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 07:42 AM
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
-- Database: `college1`
--

-- --------------------------------------------------------

--
-- Table structure for table `magic_links`
--

CREATE TABLE `magic_links` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `remember_token`, `google_id`, `created_at`) VALUES
(1, 'kani@gmail.com', '$2y$10$2MWT5fjfReBD6.Th.dUtweK2AWvjYMTQpre/4WAUVh8xQjhBvdkpO', NULL, NULL, '2025-05-07 04:42:20'),
(2, 'siva@gmail.com', '$2y$10$9adr.Fk/qbIOaeADpBDJa.XHy3YoEl4s3CShBjIeLIWWKJqwMtE66', NULL, NULL, '2025-05-07 04:53:26'),
(3, 'meena@gmail.com', '$2y$10$opypabWaKzhETJekX03ncuV4are.LM6mctNuvDBSWYsJ1My6GYtvm', NULL, NULL, '2025-05-07 09:06:41'),
(4, 'yadhu@gmail.com', '$2y$10$jEuCZXIn2Ut9lWNT9SamR.saLgab6RFvMDDrtqKO6q8nr.eAMGvcm', NULL, NULL, '2025-05-08 03:41:16'),
(5, 'kanimozhis.sse@saveetha.com', '$2y$10$LoF2EmFV0IwdNM6J1LvtIOb76Xi3HJu8yNeUyx2z86MQUv5o5iFJS', NULL, NULL, '2025-05-08 04:24:23'),
(6, 'ravi@gmail.com', '$2y$10$w9jZ7WP.twGE38OOrsL6EuEbuuy1NX.Wa85C6h6p.fy.qgATenf/.', NULL, NULL, '2025-05-08 04:44:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `magic_links`
--
ALTER TABLE `magic_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `magic_links`
--
ALTER TABLE `magic_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `magic_links`
--
ALTER TABLE `magic_links`
  ADD CONSTRAINT `magic_links_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
