-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 03:59 PM
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
-- Database: `bank_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `balance`) VALUES
(1, 1, 23566.98),
(2, 2, 14999.00),
(3, 3, 29999.00),
(4, 4, 998923.00),
(5, 1, 23566.98),
(6, 2, 14999.00),
(7, 3, 29999.00),
(8, 4, 998923.00),
(9, 1, 23566.98),
(10, 2, 14999.00),
(11, 3, 29999.00),
(12, 4, 998923.00),
(13, 5, 12000.00),
(14, 6, 18000.00),
(15, 7, 24976.00),
(16, 8, 16000.00),
(17, 9, 22000.00),
(18, 10, 14000.00),
(19, 11, 19000.00),
(27, 26, 0.00),
(28, 7, 10000.00),
(29, 27, 0.00),
(30, 8, 10000.00),
(31, 29, 0.00),
(32, 9, 10000.00),
(33, 30, 0.00),
(34, 10, 10000.00),
(35, 31, 0.00),
(36, 11, 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `timestamp`) VALUES
(1, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-11 22:56:07'),
(2, 4, 'Đăng nhập', 'Người dùng admin đã đăng nhập thành công.', '2024-10-11 23:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`) VALUES
(1, 'view_account'),
(2, 'edit_account'),
(3, 'delete_transaction'),
(4, 'manage_users');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `transaction_type` varchar(50) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `transaction_type`, `amount`, `transaction_date`) VALUES
(22, 1, 'withdraw', 1.00, '2024-09-30 10:51:34'),
(23, 1, 'withdraw', 1.00, '2024-09-30 11:09:41'),
(24, 1, 'withdraw', 1.00, '2024-09-30 11:52:16'),
(25, 1, 'withdraw', 1.00, '2024-09-30 11:55:12'),
(26, 1, 'withdraw', 1.00, '2024-09-30 11:55:20'),
(27, 1, 'withdraw', 1.00, '2024-09-30 11:55:24'),
(28, 2, 'withdraw', 1.00, '2024-10-01 01:15:01'),
(29, 7, 'withdraw', 24.00, '2024-10-01 11:42:21'),
(30, 3, 'withdraw', 1.00, '2024-10-02 05:26:43'),
(31, 1, 'withdraw', 100.00, '2024-10-02 05:29:00'),
(32, 1, 'withdraw', 1000.00, '2024-10-02 05:29:12'),
(33, 4, 'withdraw', 8.00, '2024-10-02 06:09:51'),
(34, 4, 'withdraw', 1000.00, '2024-10-02 07:24:03'),
(35, 1, 'withdraw', 1000.00, '2024-10-02 07:24:11'),
(36, 4, 'withdraw', 1.00, '2024-10-08 08:48:44'),
(37, 1, 'withdraw', 1.00, '2024-10-08 10:52:49'),
(38, 1, 'withdraw', 0.01, '2024-10-08 10:53:48'),
(39, 1, 'withdraw', 0.01, '2024-10-08 10:56:50'),
(40, 1, 'withdraw', 1.00, '2024-10-08 10:56:52'),
(41, 1, 'withdraw', 2.00, '2024-10-08 10:57:52'),
(42, 4, 'withdraw', 24.00, '2024-10-09 06:26:33'),
(43, 4, 'withdraw', 24.00, '2024-10-09 06:27:04'),
(44, 4, 'withdraw', 10.00, '2024-10-11 04:09:27'),
(45, 4, 'withdraw', 10.00, '2024-10-11 04:09:35'),
(46, 1, 'withdraw', 1.00, '2024-10-11 09:05:13'),
(47, 1, 'withdraw', 222.00, '2024-10-11 22:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `created_at`, `phone_number`, `address`, `hashed_password`, `email`) VALUES
(1, 'user1', '2', 'Nguyen Van A', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(2, 'user2', 'password', 'Tran Thi B', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(3, 'user3', 'password', 'Le Van C', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(4, 'admin', '3', 'Admin User', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(5, 'alice_smith', 'password1', 'Alice Smith', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(6, 'bob_johnson', 'password2', 'Bob Johnson', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(7, 'charlie_williams', 'password3', 'Charlie Williams', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(8, 'david_brown', 'password4', 'David Brown', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(9, 'emma_jones', 'password5', 'Emma Jones', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(10, 'fiona_garcia', 'password6', 'Fiona Garcia', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(11, 'george_martinez', 'password7', 'George Martinez', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(12, 'hannah_davis', 'password8', 'Hannah Davis', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(13, 'ivan_miller', 'password9', 'Ivan Miller', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(14, 'julia_wilson', 'password10', 'Julia Wilson', '2024-09-30 14:52:38', NULL, NULL, '', NULL),
(26, 'PMK2001', '$2y$10$LukFxRFi1SpahKA7td9MwOJVxcHoHkAUX0UYhxmxD0EPHIxirCB0q', 'Phạm Minh Kha', '2024-10-08 10:17:08', '0704591770', 'linh tay, Tp thủ đức', '', 'phamminhkha19091710@gmail.com'),
(27, 'phong', '$2y$10$e5f82wOL9uU.ZwPw9700xewtCeA0ym0wV9baDb9gNq93HvtdhkIHi', 'nguyễn hồng phong', '2024-10-08 10:21:52', '0921321412', 'Vinhome Q9', '', 'phong@gmail.com'),
(29, 'phong1', '$2y$10$ZQoNLfBbUfENrZQvH2cacOWvfYi8fk7A12kWQM/P5EKW8eNUiEqNG', 'nguyễn hồng phong', '2024-10-08 10:27:03', '0921321412', 'Vinhome Q9', '', 'phong@gmail.com'),
(30, 'KHA', '$2y$10$moJXhQjg.q6L287Wdn0v2O3VvxoWozOfqHrfcfmlS./xYjg8uN5Tu', 'phạm minh kha', '2024-10-11 09:13:30', '0935876370', 'Linh Tay Thu Duc', '', 'kha@gmail.com'),
(31, 'KHA1', '$2y$10$.3bihhJuf9upMgZGPTmDXOagZBqPXq4XQfTx/qltSmCi24qRsVrmO', 'Phạm Minh Kha', '2024-10-11 22:47:39', '0935876370', 'LInh Tay Thu Duc', '', 'kha1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  `granted` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_registration_logs`
--

CREATE TABLE `user_registration_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `plain_password` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `registration_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_registration_logs`
--

INSERT INTO `user_registration_logs` (`id`, `username`, `plain_password`, `hashed_password`, `full_name`, `email`, `phone_number`, `address`, `registration_time`) VALUES
(10, 'KHA', '123', '$2y$10$moJXhQjg.q6L287Wdn0v2O3VvxoWozOfqHrfcfmlS./xYjg8uN5Tu', 'phạm minh kha', 'kha@gmail.com', '0935876370', 'Linh Tay Thu Duc', '2024-10-11 09:13:30'),
(11, 'KHA1', '1', '$2y$10$.3bihhJuf9upMgZGPTmDXOagZBqPXq4XQfTx/qltSmCi24qRsVrmO', 'Phạm Minh Kha', 'kha1@gmail.com', '0935876370', 'LInh Tay Thu Duc', '2024-10-11 22:47:39');

--
-- Triggers `user_registration_logs`
--
DELIMITER $$
CREATE TRIGGER `after_user_registration` AFTER INSERT ON `user_registration_logs` FOR EACH ROW BEGIN
    INSERT INTO accounts (user_id, balance)
    VALUES (NEW.id, 10000);  -- Sử dụng 'NEW.id' vì đây là cột chính (auto_increment)
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 2),
(2, 2),
(3, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(1, 2),
(1, 2),
(4, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_registration_logs`
--
ALTER TABLE `user_registration_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_registration_logs`
--
ALTER TABLE `user_registration_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
