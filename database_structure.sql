-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 05:48 PM
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
-- Database: `aquapark`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `author_id`, `created_at`, `image`) VALUES
(9, 'Nowo otwarty Aquapark!', 'W naszym aquaparku znajdziecie Państwo mnóstwo atrakcji, basenów, a nawet sekcję saun! Zapraszamy!!!', 1, '2024-06-21 22:23:50', 'image20240622002350Aquapark Sliders With Pool.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `night_discount`
--

CREATE TABLE `night_discount` (
  `id` int(11) NOT NULL,
  `discount` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `night_discount`
--

INSERT INTO `night_discount` (`id`, `discount`) VALUES
(1, 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `special_discounts`
--

CREATE TABLE `special_discounts` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `discount` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `special_discounts`
--

INSERT INTO `special_discounts` (`id`, `type`, `discount`) VALUES
(1, 'student', 20.00),
(2, 'senior', 30.00),
(3, 'dziecko', 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ticket_type` enum('Bilet do aquaparku','Bilet do sauny','Basen profesjonalny','Dostęp do wszystkiego') NOT NULL,
  `hours` enum('1 godzina','2 godziny','3 godziny','4+ godziny') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` enum('none','student','senior','child') DEFAULT 'none',
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `ticket_type`, `hours`, `price`, `discount`, `date`, `time`, `purchase_date`) VALUES
(14, 1, 'Bilet do aquaparku', '1 godzina', 40.00, 'none', '2024-06-18', '18:00:00', '2024-06-10 13:40:39'),
(15, 1, 'Bilet do aquaparku', '1 godzina', 40.00, 'student', '2024-06-18', '18:00:00', '2024-06-10 13:41:17'),
(16, 1, 'Bilet do aquaparku', '1 godzina', 40.00, 'senior', '2024-06-18', '18:00:00', '2024-06-10 13:41:17'),
(17, 1, 'Bilet do aquaparku', '1 godzina', 40.00, 'student', '2024-06-17', '18:45:00', '2024-06-10 13:42:58'),
(18, 1, 'Bilet do aquaparku', '1 godzina', 40.00, 'senior', '2024-06-17', '18:45:00', '2024-06-10 13:42:58'),
(19, 1, 'Bilet do aquaparku', '1 godzina', 32.00, 'student', '2024-06-17', '19:30:00', '2024-06-10 13:44:31'),
(20, 1, 'Bilet do aquaparku', '1 godzina', 28.00, 'senior', '2024-06-17', '19:30:00', '2024-06-10 13:44:31'),
(21, 1, 'Bilet do aquaparku', '1 godzina', 40.00, 'none', '2024-06-08', '10:00:00', '2024-06-10 15:06:14'),
(22, 1, 'Bilet do aquaparku', '1 godzina', 40.00, 'none', '2025-06-20', '20:11:00', '2024-06-10 15:08:40'),
(23, 1, 'Bilet do aquaparku', '1 godzina', 40.00, 'none', '2024-06-10', '17:44:00', '2024-06-10 15:40:55'),
(24, 1, 'Bilet do aquaparku', '1 godzina', 40.00, 'none', '2024-06-11', '17:45:00', '2024-06-10 18:46:33'),
(25, 1, 'Bilet do aquaparku', '1 godzina', 32.00, 'student', '2024-06-17', '10:00:00', '2024-06-10 19:43:09'),
(26, 1, 'Bilet do aquaparku', '1 godzina', 28.00, 'senior', '2024-06-17', '10:00:00', '2024-06-10 19:43:09'),
(27, 1, 'Bilet do aquaparku', '1 godzina', 24.00, 'child', '2024-06-17', '19:00:00', '2024-06-10 19:43:09'),
(28, 1, 'Bilet do aquaparku', '2 godziny', 61.20, 'none', '2024-06-17', '00:10:00', '2024-06-10 19:43:09'),
(29, 1, 'Bilet do aquaparku', '2 godziny', 48.96, 'student', '2024-06-18', '02:00:00', '2024-06-10 19:43:09'),
(30, 1, 'Dostęp do wszystkiego', '4+ godziny', 156.00, 'none', '2024-06-17', '10:00:00', '2024-06-10 19:43:09'),
(31, 1, 'Dostęp do wszystkiego', '4+ godziny', 132.60, 'none', '2024-06-17', '03:30:00', '2024-06-10 19:43:09'),
(32, 1, 'Dostęp do wszystkiego', '4+ godziny', 106.08, 'student', '2024-06-17', '03:00:00', '2024-06-10 19:43:09'),
(33, 1, 'Dostęp do wszystkiego', '1 godzina', 30.60, 'child', '2024-06-17', '04:00:00', '2024-06-10 19:43:09'),
(34, 1, 'Bilet do aquaparku', '1 godzina', 32.00, 'student', '2024-06-19', '13:00:00', '2024-06-12 19:57:06'),
(35, 1, 'Bilet do aquaparku', '1 godzina', 23.80, 'senior', '2024-06-22', '02:00:00', '2024-06-12 19:57:06'),
(37, 27, 'Bilet do aquaparku', '1 godzina', 32.00, 'student', '2024-06-23', '10:00:00', '2024-06-22 03:49:35'),
(38, 27, 'Bilet do aquaparku', '2 godziny', 57.60, 'student', '2024-06-24', '12:00:00', '2024-06-22 03:50:30'),
(39, 27, 'Dostęp do wszystkiego', '1 godzina', 60.00, 'none', '2024-06-23', '09:54:00', '2024-06-22 03:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_discounts`
--

CREATE TABLE `ticket_discounts` (
  `id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `discount` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_discounts`
--

INSERT INTO `ticket_discounts` (`id`, `hours`, `discount`) VALUES
(1, 2, 10.00),
(2, 3, 25.00),
(3, 4, 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_prices`
--

CREATE TABLE `ticket_prices` (
  `id` int(11) NOT NULL,
  `ticket_type` varchar(255) NOT NULL,
  `hour_1_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_prices`
--

INSERT INTO `ticket_prices` (`id`, `ticket_type`, `hour_1_price`) VALUES
(1, 'Bilet do aquaparku', 40.00),
(2, 'Bilet do sauny', 25.00),
(3, 'Bilet na basen profesjonalny', 25.00),
(4, 'Dostęp do wszystkiego', 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_code` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`, `verification_code`) VALUES
(1, 'dawid', '$2y$10$pc.uNjWxKxohxdg65ecazuai.GiRc7rfWBt2WxMV3s22XUFTjQoaO', 'dawid@mail.com', 'user', '2024-06-09 16:54:17', NULL),
(2, 'test', '$2y$10$wPD7q/LMfIIpFbfg07klHesXaEQflQniDMC5RznEA/qGz1NjXHH0u', 'test@gmail.com', 'user', '2024-06-09 19:11:07', NULL),
(27, 'daveman', '$2y$10$C83jI05x/qd5EOxipjjYPuMpq1Ir7sNB4uEiv5CAznVSfSnTDoIAO', 'dawidecki.2002@gmail.com', 'user', '2024-06-19 00:01:30', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `night_discount`
--
ALTER TABLE `night_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special_discounts`
--
ALTER TABLE `special_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ticket_discounts`
--
ALTER TABLE `ticket_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_prices`
--
ALTER TABLE `ticket_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `night_discount`
--
ALTER TABLE `night_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `special_discounts`
--
ALTER TABLE `special_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `ticket_discounts`
--
ALTER TABLE `ticket_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket_prices`
--
ALTER TABLE `ticket_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
