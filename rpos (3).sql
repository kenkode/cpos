-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2018 at 08:14 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

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
  `is_cancelled` int(11) NOT NULL DEFAULT '0',
  `waiter_id` int(11) NOT NULL,
  `kitchen_id` int(11) DEFAULT NULL,
  `cancel_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `order_id`, `food_id`, `quantity`, `size`, `amount`, `is_cancelled`, `waiter_id`, `kitchen_id`, `cancel_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'medium', 650.00, 0, 2, NULL, NULL, '2018-01-30 11:32:30', '2018-01-30 13:53:37'),
(2, 1, 2, 1, 'normal', 100.00, 1, 2, NULL, 2, '2018-01-30 11:32:30', '2018-01-31 17:11:06'),
(3, 1, 6, 1, 'normal', 90.00, 0, 2, NULL, NULL, '2018-01-30 11:32:30', '2018-01-30 11:32:30'),
(4, 2, 3, 1, 'normal', 100.00, 1, 1, NULL, 1, '2018-01-30 16:53:30', '2018-01-30 17:29:27'),
(5, 2, 5, 1, 'normal', 45.00, 0, 1, NULL, NULL, '2018-01-30 16:53:30', '2018-01-30 16:53:30'),
(6, 2, 9, 1, 'normal', 70.00, 0, 1, NULL, NULL, '2018-01-30 16:53:30', '2018-01-30 16:53:30'),
(7, 3, 3, 1, 'normal', 100.00, 0, 2, NULL, NULL, '2018-01-31 07:17:27', '2018-01-31 17:10:00'),
(8, 3, 6, 1, 'normal', 90.00, 0, 2, NULL, NULL, '2018-01-31 07:17:27', '2018-01-31 07:17:27'),
(9, 4, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 07:18:59', '2018-01-31 07:18:59'),
(10, 5, 12, 1, 'normal', 200.00, 0, 2, NULL, NULL, '2018-01-31 07:20:55', '2018-01-31 07:20:55'),
(11, 6, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 07:21:16', '2018-01-31 07:21:16'),
(12, 7, 12, 1, 'normal', 200.00, 0, 2, NULL, NULL, '2018-01-31 07:22:01', '2018-01-31 07:22:01'),
(13, 9, 12, 1, 'normal', 200.00, 0, 2, NULL, NULL, '2018-01-31 07:25:11', '2018-01-31 07:25:11'),
(14, 10, 2, 1, 'normal', 100.00, 0, 2, NULL, NULL, '2018-01-31 07:27:55', '2018-01-31 07:27:55'),
(15, 10, 4, 1, 'normal', 45.00, 0, 2, NULL, NULL, '2018-01-31 07:27:55', '2018-01-31 07:27:55'),
(16, 11, 17, 1, 'normal', 50.00, 0, 2, NULL, NULL, '2018-01-31 07:35:21', '2018-01-31 07:35:21'),
(17, 11, 7, 1, 'normal', 50.00, 0, 2, NULL, NULL, '2018-01-31 07:35:21', '2018-01-31 07:35:21'),
(18, 12, 8, 1, 'normal', 80.00, 0, 2, NULL, NULL, '2018-01-31 07:37:54', '2018-01-31 07:37:54'),
(19, 13, 7, 1, 'normal', 50.00, 0, 2, NULL, NULL, '2018-01-31 07:38:20', '2018-01-31 07:38:20'),
(20, 14, 6, 1, 'normal', 90.00, 0, 2, NULL, NULL, '2018-01-31 07:45:44', '2018-01-31 07:45:44'),
(21, 15, 7, 1, 'normal', 50.00, 0, 2, NULL, NULL, '2018-01-31 07:59:20', '2018-01-31 07:59:20'),
(22, 16, 7, 1, 'normal', 50.00, 0, 2, NULL, NULL, '2018-01-31 08:00:49', '2018-01-31 08:00:49'),
(23, 17, 8, 1, 'normal', 80.00, 0, 2, NULL, NULL, '2018-01-31 08:01:08', '2018-01-31 08:01:08'),
(24, 18, 6, 1, 'normal', 90.00, 0, 2, NULL, NULL, '2018-01-31 08:02:08', '2018-01-31 08:02:08'),
(25, 19, 6, 1, 'normal', 90.00, 0, 2, NULL, NULL, '2018-01-31 08:03:33', '2018-01-31 08:03:33'),
(26, 20, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 08:04:47', '2018-01-31 08:04:47'),
(27, 21, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 08:09:01', '2018-01-31 08:09:01'),
(28, 22, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 08:09:59', '2018-01-31 08:09:59'),
(29, 23, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 08:10:33', '2018-01-31 08:10:33'),
(30, 24, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 08:11:34', '2018-01-31 08:11:34'),
(31, 25, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 08:13:47', '2018-01-31 08:13:47'),
(32, 26, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 08:14:55', '2018-01-31 08:14:55'),
(33, 27, 1, 1, 'large', 900.00, 0, 2, NULL, NULL, '2018-01-31 08:16:09', '2018-01-31 08:16:09'),
(34, 28, 11, 1, 'normal', 150.00, 0, 2, NULL, NULL, '2018-01-31 08:17:13', '2018-01-31 08:17:13'),
(35, 29, 12, 1, 'normal', 200.00, 0, 2, NULL, NULL, '2018-01-31 08:20:40', '2018-01-31 08:20:40'),
(36, 30, 12, 1, 'normal', 200.00, 0, 2, NULL, NULL, '2018-01-31 08:36:08', '2018-01-31 08:36:08'),
(37, 31, 1, 1, 'large', 900.00, 0, 2, NULL, NULL, '2018-02-02 13:48:31', '2018-02-02 13:48:31');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(15,2) NOT NULL,
  `is_paid` int(11) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount_paid` float(15,2) DEFAULT NULL,
  `transaction_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_complete` int(11) NOT NULL,
  `is_received` int(11) NOT NULL DEFAULT '0',
  `is_beep` int(11) NOT NULL DEFAULT '0',
  `receiver_id` int(11) DEFAULT NULL,
  `received_time` datetime DEFAULT NULL,
  `delivered_time` datetime DEFAULT NULL,
  `is_cancelled` int(11) NOT NULL DEFAULT '0',
  `waiter_id` int(11) NOT NULL,
  `kitchen_id` int(11) DEFAULT NULL,
  `cashier_id` int(11) DEFAULT NULL,
  `cancel_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_no`, `amount`, `is_paid`, `payment_method`, `amount_paid`, `transaction_number`, `is_complete`, `is_received`, `is_beep`, `receiver_id`, `received_time`, `delivered_time`, `is_cancelled`, `waiter_id`, `kitchen_id`, `cashier_id`, `cancel_id`, `created_at`, `updated_at`) VALUES
(1, '#R000000', 840.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, 3, NULL, 3, '2018-01-30 11:32:30', '2018-01-31 07:58:49'),
(2, '#R000002', 215.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 1, 1, NULL, 1, '2018-01-30 16:53:30', '2018-01-31 07:58:49'),
(3, '#R000003', 190.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:17:27', '2018-01-31 07:58:49'),
(4, '#R000004', 150.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:18:59', '2018-01-31 07:58:49'),
(5, '#R000005', 200.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:20:55', '2018-01-31 07:58:49'),
(6, '#R000006', 150.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:21:16', '2018-01-31 07:58:49'),
(7, '#R000007', 200.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:22:00', '2018-01-31 07:58:50'),
(8, '#R000008', 0.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:24:54', '2018-01-31 07:58:50'),
(9, '#R000009', 200.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:25:10', '2018-01-31 07:58:50'),
(10, '#R000010', 145.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:27:55', '2018-01-31 07:58:50'),
(11, '#R000011', 100.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:35:21', '2018-01-31 07:58:50'),
(12, '#R000012', 80.00, 0, NULL, NULL, NULL, 0, 1, 1, 3, '2018-01-31 10:38:10', NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:37:53', '2018-01-31 07:58:50'),
(13, '#R000013', 50.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:38:20', '2018-01-31 07:58:50'),
(14, '#R000014', 90.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:45:44', '2018-01-31 07:58:50'),
(15, '#R000015', 50.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 07:59:18', '2018-01-31 08:01:52'),
(16, '#R000016', 50.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 08:00:48', '2018-01-31 08:01:52'),
(17, '#R000017', 80.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 08:01:08', '2018-01-31 08:01:52'),
(18, '#R000018', 90.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 08:02:07', '2018-01-31 08:02:08'),
(19, '#R000019', 90.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 08:03:32', '2018-01-31 08:03:33'),
(20, '#R000020', 150.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 08:04:47', '2018-01-31 08:08:01'),
(21, '#R000021', 150.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 08:08:59', '2018-01-31 08:09:45'),
(22, '#R000022', 150.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 08:09:58', '2018-01-31 08:09:59'),
(23, '#R000023', 150.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-01-31 08:10:33', '2018-01-31 08:10:34'),
(24, '#R000024', 150.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 1, 2, NULL, NULL, 3, '2018-01-31 08:11:34', '2018-01-31 17:21:55'),
(25, '#R000025', 150.00, 1, 'Cash', 200.00, '', 1, 0, 1, NULL, NULL, NULL, 0, 2, 3, 4, NULL, '2018-01-31 08:13:47', '2018-02-02 09:44:36'),
(26, '#R000026', 150.00, 0, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 0, 2, 3, NULL, NULL, '2018-01-31 08:14:53', '2018-02-02 09:40:40'),
(27, '#R000027', 900.00, 0, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, 0, 2, 1, NULL, NULL, '2018-01-31 08:16:09', '2018-02-02 09:40:26'),
(28, '#R000028', 150.00, 1, 'Bank', 200.00, '1213123123', 1, 0, 1, NULL, NULL, NULL, 0, 2, 1, 4, NULL, '2018-01-31 08:17:13', '2018-02-02 09:41:16'),
(29, '#R000029', 200.00, 1, 'Cash', 500.00, '', 1, 0, 1, NULL, NULL, NULL, 0, 2, 1, 4, NULL, '2018-01-31 08:20:39', '2018-02-02 09:39:51'),
(30, '#R000030', 200.00, 1, 'Paybill', 1000.00, 'LX123123X', 1, 0, 1, NULL, NULL, NULL, 0, 2, 1, 4, NULL, '2018-01-31 08:36:07', '2018-02-02 09:38:24'),
(31, '#R000031', 900.00, 0, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, 0, 2, NULL, NULL, NULL, '2018-02-02 13:48:31', '2018-02-02 13:48:33');

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
  `address` text COLLATE utf8_unicode_ci,
  `receipt_footer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `name`, `address`, `receipt_footer`, `created_at`, `updated_at`) VALUES
(1, '1516710022-chef-28762_640.png', 'RPOS', 'P.O. Box 123,\r\nNairobi', 'Always ready to serve your taste', NULL, '2018-02-02 06:58:48');

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
(1, '1516709014-admin.jpeg', 'kenkode', 'wangoken2@gmail.com', '$2y$10$8HAqAv1CTktZiV8j7t2Gs.C6y2dFSkL5zyMfoAmGfx6TmsPKmCrO.', 'admin', 1, 'FYiBGjCpzZl1DsbBuPnkZThNDQpSnczrcOIJohWCu4OQw8nA9VuE27hAHcqv', '2018-01-22 17:12:00', '2018-02-02 11:28:18'),
(2, '1516705054-waiter.jpeg', 'Mary Njoki', 'mary.njoki@gmail.com', '$2y$10$4P2lnBskl8fPlennAvEo/.UmcjMoVv77WlURCZz05SMh4TtRKL9/C', 'waiter', 1, 'OdJrkmbknlVI5HLeCLcZB20u2zgnhsGMb7iioAQ60qOfe5x9kTZ3KCU5qqPO', '2018-01-23 10:57:34', '2018-02-02 14:18:59'),
(3, '1516705114-chef.jpeg', 'Michael Kang`ethe', 'mike.k@gmail.com', '$2y$10$ehnJLnN5dsT.8FgQGo9Mou.ujgpg8W85X1AHfZwc3SqnkE82DsoC.', 'kitchen', 1, 'yAvmTZsODZsYuxkB1oPXfenj2qJO6t2r2k4Xa1SrMLkRdO9qHB4t5tEbwGwO', '2018-01-23 10:58:34', '2018-02-02 13:47:25'),
(4, '1516705222-cashier.jpeg', 'Shantel Odieng', 'shanto@gmail.com', '$2y$10$sJzlbo5wbOppASC67WTa0egRwOy5vRpvA5uiCTh9aEykJIzAVRW52', 'cashier', 1, '3vJDl7FHeVQrRW85jTNh8mpfLB6XV3weTi4i431DN7J0AeYpYQIphpOIXoVO', '2018-01-23 11:00:22', '2018-02-02 12:40:53');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
