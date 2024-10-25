-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2024 at 08:53 PM
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
(1, 1, 23642.98),
(2, 2, 14975.00),
(3, 3, 29999.00),
(4, 4, 998923.00),
(5, 1, 23642.98),
(6, 2, 14975.00),
(7, 3, 29999.00),
(8, 4, 998923.00),
(9, 1, 23642.98),
(10, 2, 14975.00),
(11, 3, 29999.00),
(12, 4, 998923.00),
(13, 5, 12000.00),
(14, 6, 18000.00),
(15, 7, 24976.00),
(16, 8, 16000.00),
(28, 7, 10000.00),
(30, 8, 10000.00),
(87, 65, 0.00),
(88, 66, 1000.00);

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
(106, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 22:59:01'),
(107, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 23:12:16'),
(108, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 23:15:06'),
(109, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 23:22:20'),
(110, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 23:24:37'),
(111, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 23:30:43'),
(112, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 23:31:48'),
(113, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 23:40:54'),
(114, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 23:41:16'),
(115, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-17 23:45:32'),
(116, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-19 00:14:44'),
(117, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-19 00:25:32'),
(118, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-19 00:39:04'),
(119, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-19 00:43:41'),
(120, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-19 01:10:08'),
(121, 4, 'Đăng nhập', 'Người dùng admin đã đăng nhập thành công.', '2024-10-19 01:29:52'),
(123, 4, 'Đăng nhập', 'Người dùng admin đã đăng nhập thành công.', '2024-10-19 02:42:47'),
(124, 4, 'Đăng nhập', 'Người dùng admin đã đăng nhập thành công.', '2024-10-19 02:45:54'),
(125, 4, 'Đăng nhập', 'Người dùng admin đã đăng nhập thành công.', '2024-10-20 10:52:37'),
(126, 1, 'Đăng nhập', 'Người dùng user1 đã đăng nhập thành công.', '2024-10-20 11:29:16'),
(127, 1, 'Rút tiền', 'Người dùng 1 đã rút 24 từ tài khoản.', '2024-10-20 11:29:48'),
(128, 4, 'Đăng nhập', 'Người dùng admin đã đăng nhập thành công.', '2024-10-20 11:30:25'),
(129, 4, 'Xóa người dùng', 'Admin đã xóa người dùng có ID: 9', '2024-10-20 11:31:25'),
(130, 66, 'Đăng ký tài khoản', 'Người dùng mới với username 1 đã đăng ký thành công.', '2024-10-25 18:46:45');

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
(47, 1, 'withdraw', 222.00, '2024-10-11 22:42:36'),
(49, 1, 'withdraw', 24.00, '2024-10-20 11:29:48'),
(50, 2, 'withdraw', 24.00, '2024-10-20 11:31:09');

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
  `email` varchar(255) DEFAULT NULL,
  `is_2fa_enabled` tinyint(1) DEFAULT 0,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expiry` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `created_at`, `phone_number`, `address`, `hashed_password`, `email`, `is_2fa_enabled`, `otp_code`, `otp_expiry`) VALUES
(1, 'user1', '7', 'Phạm Minh Kha ', '2024-09-30 14:52:38', '0935876370', 'Linh Tay Thu Duc ', '', 'pmk@gmail.com', 0, '841193', '2024-10-14 11:51:02'),
(2, 'user2', 'newpassword', 'Tran Thi B', '2024-09-30 14:52:38', NULL, NULL, '', NULL, 0, NULL, NULL),
(3, 'user3', 'password', 'Le Van C', '2024-09-30 14:52:38', NULL, NULL, '', NULL, 0, NULL, NULL),
(4, 'admin', 'pmkadmin', 'Phạm Minh Kha ', '2024-09-30 14:52:38', '0935876370', 'Linh Tay Thu Duc', '', 'phamminhkha@gmail.com', 0, '201589', '2024-10-15 07:10:39'),
(5, 'alice_smith', 'password1', 'Alice Smith', '2024-09-30 14:52:38', NULL, NULL, '', NULL, 0, NULL, NULL),
(6, 'bob_johnson', 'password2', 'Bob Johnson', '2024-09-30 14:52:38', NULL, NULL, '', NULL, 0, NULL, NULL),
(7, 'charlie_williams', 'password3', 'Charlie Williams', '2024-09-30 14:52:38', NULL, NULL, '', NULL, 0, NULL, NULL),
(8, 'david_brown', 'password4', 'David Brown', '2024-09-30 14:52:38', NULL, NULL, '', NULL, 0, NULL, NULL),
(65, 'john_doe', 'Pass123!', 'John Doe', '2024-10-25 18:46:07', '0901234567', '123 Main St', '46708f23d682fef9aa996ecbb139bfb6c9ffdc039905ad6ad5c85a88b9411d97', 'john@example.com', 0, NULL, NULL),
(66, '1', '$2y$10$QnvIpTcPrhGFyZaMTyt8redViBtZqhUN22V01NF.anB9/FFI0DW/q', '1', '2024-10-25 18:46:45', '1', '1', '', '1@gmail.com', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_encrypted`
--

CREATE TABLE `users_encrypted` (
  `id` int(11) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `hashed_full_name` varchar(255) NOT NULL,
  `hashed_email` varchar(255) NOT NULL,
  `hashed_phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_encrypted`
--

INSERT INTO `users_encrypted` (`id`, `hashed_password`, `hashed_full_name`, `hashed_email`, `hashed_phone`) VALUES
(1, '7902699be42c8a8e46fbbb4501726517e86b22c56a189f7625a6da49081b2451', '35d26065cdec9807049b7610c853c295d48977474a70ffe8b8c2e5846cb01e14', '0cd5deed99cfdbef451355497e0f5d294089672e1c659737eb2a42c820d8f107', 'e1f80ac9f21ab1b1e6ff5624842578e264ddaa1f5b25afa27de2c8ebc9902767'),
(2, '089542505d659cecbb988bb5ccff5bccf85be2dfa8c221359079aee2531298bb', 'e9b7da6ee172c5736d97253ee18baa4c0edd72e2c9f474503fa91efce041f5ac', '999917ac9c78ec4f2bdffb0b8f73aab38f94ce235cafa4fe4612728b4c8dad67', NULL),
(3, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', '34c9e9919105bb7bbf0190c654fec745b1049d6ffa158fdb5256e57e29fde6fe', '999917ac9c78ec4f2bdffb0b8f73aab38f94ce235cafa4fe4612728b4c8dad67', NULL),
(4, '3a311390320a2d0bb4f53b66aae3ad921155eb439852e5c7719e0ccdd584507e', '6b4ce2a060f985dbfef05b485d78c9f2211f320f804d00b0cf99a3f87c728809', 'ff83939fa854ad2540915953b5f18b73bfd887d3b0704322d43984ad32c50b5d', 'e1f80ac9f21ab1b1e6ff5624842578e264ddaa1f5b25afa27de2c8ebc9902767'),
(5, '0b14d501a594442a01c6859541bcb3e8164d183d32937b851835442f69d5c94e', '8ae10dfc9a69f97dcc91e1f51bced3aff442bc57a869e04126bd0ca7cb4af29d', '999917ac9c78ec4f2bdffb0b8f73aab38f94ce235cafa4fe4612728b4c8dad67', NULL),
(6, '6cf615d5bcaac778352a8f1f3360d23f02f34ec182e259897fd6ce485d7870d4', '63ee5af378b5f3ff4650f62d0205db5ee418e4837c9df82f16787352fd806a9a', '999917ac9c78ec4f2bdffb0b8f73aab38f94ce235cafa4fe4612728b4c8dad67', NULL),
(7, '5906ac361a137e2d286465cd6588ebb5ac3f5ae955001100bc41577c3d751764', '9b4deaa9739923f8addb478536aae7569a3322f3b73ab077e314dd303b87fbbb', '999917ac9c78ec4f2bdffb0b8f73aab38f94ce235cafa4fe4612728b4c8dad67', NULL),
(8, 'b97873a40f73abedd8d685a7cd5e5f85e4a9cfb83eac26886640a0813850122b', 'd622a4539b476f3a308b8210a46b69b952851c218fa3b4188d1d31f72a15a84e', '999917ac9c78ec4f2bdffb0b8f73aab38f94ce235cafa4fe4612728b4c8dad67', NULL),
(9, '8b2c86ea9cf2ea4eb517fd1e06b74f399e7fec0fef92e3b482a6cf2e2b092023', 'bab7af0f4c3ad793a56ee3abea84df6e4fb7c169802eacc6d268d05ca18c77b7', '999917ac9c78ec4f2bdffb0b8f73aab38f94ce235cafa4fe4612728b4c8dad67', NULL);

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
  `username` varchar(50) NOT NULL,
  `plain_password` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `registration_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `registration_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_registration_logs`
--

INSERT INTO `user_registration_logs` (`id`, `username`, `plain_password`, `hashed_password`, `full_name`, `email`, `phone_number`, `address`, `registration_time`, `status`, `registration_status`) VALUES
(52, 'john_doe', 'Pass123!', '46708f23d682fef9aa996ecbb139bfb6c9ffdc039905ad6ad5c85a88b9411d97', 'John Doe', 'john@example.com', '0901234567', '123 Main St', '2024-10-25 18:46:07', 'completed', 'success'),
(53, '1', '2', '$2y$10$QnvIpTcPrhGFyZaMTyt8redViBtZqhUN22V01NF.anB9/FFI0DW/q', '1', '1@gmail.com', '1', '1', '2024-10-25 18:46:45', 'pending', NULL);

--
-- Triggers `user_registration_logs`
--
DELIMITER $$
CREATE TRIGGER `after_registration_insert` AFTER INSERT ON `user_registration_logs` FOR EACH ROW BEGIN
    DECLARE new_user_id INT;
    
    -- Chỉ thực hiện khi registration thành công
    IF NEW.status = 'completed' THEN
        -- 1. Insert vào bảng users và lưu ID
        INSERT INTO users (
            username,
            password,
            full_name,
            email,
            phone_number,
            address,
            created_at,
            hashed_password
        ) VALUES (
            NEW.username,
            NEW.plain_password,
            NEW.full_name,
            NEW.email,
            NEW.phone_number,
            NEW.address,
            NEW.registration_time,
            NEW.hashed_password
        );
        
        -- Lấy ID của user vừa tạo
        SET new_user_id = LAST_INSERT_ID();
        
        -- 2. Tạo tài khoản cho user với số dư ban đầu là 0
        INSERT INTO accounts (user_id, balance) 
        VALUES (new_user_id, 0);
    END IF;
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
  ADD KEY `activity_logs_ibfk_1` (`user_id`);

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
  ADD KEY `transactions_ibfk_1` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `uk_username` (`username`);

--
-- Indexes for table `users_encrypted`
--
ALTER TABLE `users_encrypted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_registration_logs`
--
ALTER TABLE `user_registration_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_username` (`username`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_roles_ibfk_1` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_registration_logs`
--
ALTER TABLE `user_registration_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
