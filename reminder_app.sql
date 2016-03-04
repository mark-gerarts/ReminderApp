-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 04, 2016 at 04:38 pm
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reminder_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `name`, `number`, `deleted_at`) VALUES
(1, 3, 'TestContact', '12345667', '2016-03-01 16:00:08'),
(2, 3, 'TestContact2', '15432222667', NULL),
(5, 3, 'azerty', '123456', '2016-03-01 15:59:49'),
(7, 3, 'Mark', '456213', NULL),
(21, 3, 'NieuwContact', '123465', NULL),
(22, 3, '321654', '321654', NULL),
(23, 3, 'DeleteMe', '999666333', '2016-03-01 15:20:32'),
(24, 3, 'Azertyuiop', '123456789', NULL),
(25, 3, 'Test', '321654', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(5, 'mark.gerarts@gmail.com', 'b523f383b4c908a66a03cf89b793235648417cecd84fa6e56c906410df1d5737', '2016-01-13 10:20:16');

-- --------------------------------------------------------

--
-- Table structure for table `quick_reminders`
--

CREATE TABLE `quick_reminders` (
  `id` int(11) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `send_datetime` datetime NOT NULL,
  `message` text NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_payed` tinyint(1) NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quick_reminders`
--

INSERT INTO `quick_reminders` (`id`, `recipient`, `send_datetime`, `message`, `deleted_at`, `updated_at`, `created_at`, `is_payed`, `payment_id`) VALUES
(4, '+32494896349', '2015-05-05 11:11:00', 'Hello, world!', '2016-03-03 18:24:27', NULL, '2016-03-03 19:18:20', 1, 'tr_Z5Zh8tweH7'),
(5, '321654', '2015-05-05 20:20:00', 'Dit is een test', '2016-03-03 18:23:43', NULL, '2016-03-03 19:21:14', 1, 'tr_Wq4LBkCcep'),
(6, '321654987', '2015-06-07 20:20:00', 'sqdf', '2016-03-04 10:34:44', NULL, '2016-03-03 23:27:37', 1, 'tr_7f9WsTLmmM');

-- --------------------------------------------------------

--
-- Table structure for table `repeats`
--

CREATE TABLE `repeats` (
  `id` int(11) NOT NULL,
  `repeat_interval` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `repeats`
--

INSERT INTO `repeats` (`id`, `repeat_interval`) VALUES
(1, 'never'),
(2, 'daily'),
(3, 'weekly'),
(4, 'monthly'),
(5, 'yearly');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `reminder_credits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `reminder_credits`) VALUES
(3, 'Mark', 'mark.gerarts@gmail.com', '$2y$10$KJaW/tnhfHfcveVFfnUx5OZVlqEZ7d0AHSqGLU6rPzpS3dc9udDRK', 'mKVU4ngo7dGO5ANnQLLlaVBunZAUbFwWA3eoEMXXPlffiwqJRIdMi77tWslO', '2016-01-12 19:20:11', '2016-03-04 12:16:47', 49),
(4, 'Test', 'test@test.com', '$2y$10$E2B47AyYX7Ood/CbgKtY2OODkSU9Fq4dI8IMfPXIH.aqIb2zyvsQG', '', '2016-01-17 16:57:46', '2016-01-17 16:57:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `reminder_credits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`id`, `payment_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `amount`, `reminder_credits`) VALUES
(1, 'tr_LB8Wgy8Kqk', 3, '2016-03-03 22:08:20', '2016-03-03 22:08:21', '0000-00-00 00:00:00', '5', 10),
(2, 'tr_J3Yhf5wegK', 3, '2016-03-03 22:09:22', '2016-03-03 22:09:22', '0000-00-00 00:00:00', '5', 10),
(3, 'tr_hueCGaCXDU', 3, '2016-03-03 22:10:06', '2016-03-03 22:10:06', '0000-00-00 00:00:00', '5', 10),
(4, 'tr_HDYqqk3qR9', 3, '2016-03-03 22:11:39', '2016-03-03 22:11:39', '0000-00-00 00:00:00', '5', 10),
(6, 'tr_yAfYnffeV5', 3, '2016-03-03 22:18:08', '2016-03-03 22:18:12', '2016-03-03 22:18:12', '5', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_reminders`
--

CREATE TABLE `user_reminders` (
  `id` int(11) NOT NULL,
  `recipient` varchar(255) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `send_datetime` datetime NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `repeat_id` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_reminders`
--

INSERT INTO `user_reminders` (`id`, `recipient`, `contact_id`, `send_datetime`, `message`, `user_id`, `repeat_id`, `deleted_at`) VALUES
(14, '3216549', NULL, '2016-03-04 09:00:00', 'testReminder', 3, 2, '2016-03-04 10:34:44'),
(16, '321654', NULL, '2016-03-04 09:10:00', 'hello', 3, 2, '2016-03-04 10:35:45'),
(18, '12346579', NULL, '2016-01-01 11:01:00', 'sdf', 3, 5, '2016-03-04 10:38:34'),
(20, '123456789', NULL, '2016-02-15 15:15:00', 'Monthly', 3, 4, '2016-03-04 10:39:16'),
(22, '159753', NULL, '2016-02-27 10:10:00', 'Weekly', 3, 3, '2016-03-04 10:39:53'),
(25, '321', NULL, '2017-05-02 10:10:00', 'sdf', 3, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quick_reminders`
--
ALTER TABLE `quick_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repeats`
--
ALTER TABLE `repeats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_reminders`
--
ALTER TABLE `user_reminders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_id` (`contact_id`),
  ADD KEY `repeat_id` (`repeat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `quick_reminders`
--
ALTER TABLE `quick_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `repeats`
--
ALTER TABLE `repeats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_reminders`
--
ALTER TABLE `user_reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_contacts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_reminders`
--
ALTER TABLE `user_reminders`
  ADD CONSTRAINT `FK_reminder_to_contacts` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`),
  ADD CONSTRAINT `FK_reminder_to_repeats` FOREIGN KEY (`repeat_id`) REFERENCES `repeats` (`id`),
  ADD CONSTRAINT `FK_reminder_to_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
