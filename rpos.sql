-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 23, 2018 at 06:41 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpos`
--

-- --------------------------------------------------------

--
-- Table structure for table `foodcategories`
--

CREATE TABLE `foodcategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `foodcategories`
--

INSERT INTO `foodcategories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Snacks', '2018-01-23 07:38:10', '2018-01-23 09:30:46'),
(2, 'Breakfast', '2018-01-23 07:38:45', '2018-01-23 07:38:45'),
(3, 'Beverages', '2018-01-23 07:39:33', '2018-01-23 07:45:00'),
(4, 'Lunch & Dinner', '2018-01-23 07:40:28', '2018-01-23 07:50:52'),
(6, 'Appetizers', '2018-01-23 07:42:01', '2018-01-23 07:42:01'),
(7, 'Salads', '2018-01-23 07:42:08', '2018-01-23 07:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodcategory_id` int(11) NOT NULL,
  `medium` double(15,2) DEFAULT NULL,
  `large` double(15,2) DEFAULT NULL,
  `small` double(15,2) DEFAULT NULL,
  `normal` double(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `image`, `name`, `foodcategory_id`, `medium`, `large`, `small`, `normal`, `created_at`, `updated_at`) VALUES
(1, '1516699961-pepperoni.jpg', 'Pepperoni Pizza', 1, 650.00, 900.00, 500.00, 0.00, '2018-01-23 09:02:36', '2018-01-23 09:32:41'),
(2, '1516698411-chips.jpeg', 'French Fries', 1, 0.00, 0.00, 0.00, 100.00, '2018-01-23 09:06:51', '2018-01-23 09:06:51'),
(3, '1516698473-bhajia.jpeg', 'Bhajia', 1, 0.00, 0.00, 0.00, 100.00, '2018-01-23 09:07:53', '2018-01-23 09:07:53'),
(4, '1516698525-sausage.jpeg', 'Sausage', 1, 0.00, 0.00, 0.00, 45.00, '2018-01-23 09:08:45', '2018-01-23 09:08:45'),
(5, '1516698548-samosa.jpeg', 'Samosa', 1, 0.00, 0.00, 0.00, 45.00, '2018-01-23 09:09:08', '2018-01-23 09:09:08'),
(6, '1516698588-soda.jpeg', 'Plastic Soda', 3, 0.00, 0.00, 0.00, 90.00, '2018-01-23 09:09:48', '2018-01-23 09:09:48'),
(7, '1516698641-tea.jpeg', 'Tea', 3, 0.00, 0.00, 0.00, 50.00, '2018-01-23 09:10:41', '2018-01-23 09:10:41'),
(8, '1516698683-coffee.jpeg', 'Coffee', 3, 0.00, 0.00, 0.00, 80.00, '2018-01-23 09:11:23', '2018-01-23 09:11:23'),
(9, '1516698708-water.jpeg', 'Water', 3, 0.00, 0.00, 0.00, 70.00, '2018-01-23 09:11:48', '2018-01-23 09:33:41'),
(10, '1516698781-orange juice.jpeg', 'Orange Juice', 3, 0.00, 0.00, 0.00, 100.00, '2018-01-23 09:13:01', '2018-01-23 09:13:01'),
(11, '1516698874-toast tea.jpeg', 'Toast and Tea', 2, 0.00, 0.00, 0.00, 150.00, '2018-01-23 09:14:34', '2018-01-23 09:14:34'),
(12, '1516698905-bacon.jpeg', 'Eggs and Coffee', 2, 0.00, 0.00, 0.00, 200.00, '2018-01-23 09:15:05', '2018-01-23 09:15:05'),
(13, '1516698961-nyama choma.jpeg', 'Nyama Choma and Ugali', 4, 0.00, 0.00, 0.00, 1000.00, '2018-01-23 09:16:01', '2018-01-23 09:16:01'),
(14, '1516698992-beef and rice.jpeg', 'Beef and Rice', 4, 0.00, 0.00, 0.00, 360.00, '2018-01-23 09:16:32', '2018-01-23 09:16:32'),
(15, '1516699032-pilau.jpeg', 'Pilau', 4, 0.00, 0.00, 0.00, 250.00, '2018-01-23 09:17:12', '2018-01-23 09:17:12'),
(16, '1516699088-chicken.jpeg', 'Chicken Fry', 4, 0.00, 0.00, 0.00, 500.00, '2018-01-23 09:18:08', '2018-01-23 09:18:08'),
(17, '1516699110-chapati.jpeg', 'Chapati', 1, 0.00, 0.00, 0.00, 50.00, '2018-01-23 09:18:30', '2018-01-23 09:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_01_22_150207_create_foodcategories_table', 1),
(4, '2018_01_22_150227_create_foods_table', 1),
(5, '2018_01_22_150656_create_orders_table', 1),
(6, '2018_01_22_150717_create_settings_table', 1),
(7, '2018_01_22_150907_create_payments_table', 1),
(8, '2018_01_22_152954_create_orderitems_table', 1),
(9, '2018_01_22_154436_create_paymentmethods_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(15,2) NOT NULL,
  `is_complete` int(11) NOT NULL,
  `is_received` int(11) NOT NULL,
  `received_time` datetime NOT NULL,
  `delivered_time` datetime NOT NULL,
  `waiter_id` int(11) NOT NULL,
  `kitchen_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(15,2) NOT NULL,
  `is_paid` int(11) NOT NULL,
  `is_complete` int(11) NOT NULL,
  `waiter_id` int(11) NOT NULL,
  `kitchen_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethods`
--

CREATE TABLE `paymentmethods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(15,2) NOT NULL,
  `paymentmethod_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receipt_footer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `name`, `receipt_footer`, `created_at`, `updated_at`) VALUES
(1, '1516710022-chef-28762_640.png', 'RPOS', 'Always ready to serve your taste', NULL, '2018-01-23 12:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `photo`, `name`, `email`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '1516709014-admin.jpeg', 'kenkode', 'wangoken2@gmail.com', '$2y$10$8HAqAv1CTktZiV8j7t2Gs.C6y2dFSkL5zyMfoAmGfx6TmsPKmCrO.', 'admin', 1, 'k68mXT52BMqiQddM31O1hGhsHFf94agtFfjoU9G7WSvEVjqS7jjCit5IofrW', '2018-01-22 17:12:00', '2018-01-23 16:48:48'),
(2, '1516705054-waiter.jpeg', 'Mary Njoki', 'mary.njoki@gmail.com', '$2y$10$4P2lnBskl8fPlennAvEo/.UmcjMoVv77WlURCZz05SMh4TtRKL9/C', 'waiter', 1, 'CG6kXojdjCKAI6pbJcXa2RCmTYliHApqvqGLMDeDqWB2LC27ZRom7xGoG2He', '2018-01-23 10:57:34', '2018-01-23 16:49:48'),
(3, '1516705114-chef.jpeg', 'Michael Kang`ethe', 'mike.k@gmail.com', '$2y$10$ehnJLnN5dsT.8FgQGo9Mou.ujgpg8W85X1AHfZwc3SqnkE82DsoC.', 'kitchen', 1, 'VbdbOXInjFYvGyOtxJQH1hj9H7aYSB047vnRhViW8fEZRs2gl8dLXhUkkJ5m', '2018-01-23 10:58:34', '2018-01-23 16:56:16'),
(4, '1516705222-cashier.jpeg', 'Shantel Odieng', 'shanto@gmail.com', '$2y$10$sJzlbo5wbOppASC67WTa0egRwOy5vRpvA5uiCTh9aEykJIzAVRW52', 'cashier', 1, 'yWAQ4VhSpzorESilf2PjyNGCHPSQUU585oeMX2YkK4XeeMTrYpH6kTC7cdxY', '2018-01-23 11:00:22', '2018-01-23 16:57:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foodcategories`
--
ALTER TABLE `foodcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foodcategories`
--
ALTER TABLE `foodcategories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paymentmethods`
--
ALTER TABLE `paymentmethods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
