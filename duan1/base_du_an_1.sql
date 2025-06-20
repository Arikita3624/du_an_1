-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 20, 2025 lúc 04:11 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `base_du_an_1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `full_name`, `email`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@example.com', NULL, '2025-05-25 07:20:36', '2025-05-25 07:20:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(11,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 2, 0, '2025-05-26 14:28:34', '2025-05-26 14:28:34'),
(2, 3, 0, '2025-05-27 12:35:55', '2025-05-27 12:35:55'),
(3, 4, 0, '2025-06-02 08:53:53', '2025-06-02 08:53:53'),
(4, 5, 0, '2025-06-05 12:53:07', '2025-06-05 12:53:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `price`, `quantity`, `total_price`, `created_at`, `updated_at`) VALUES
(13, 2, 2, 250000, 1, 250000.00, '2025-05-27 12:36:18', '2025-05-27 12:36:18'),
(66, 1, 8, 450000, 1, 450000.00, '2025-06-10 08:10:46', '2025-06-10 08:10:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Áo Nam', 'Các loại áo dành cho nam giới', '2025-05-25 07:20:36', '2025-05-25 07:20:36'),
(2, 'Quần Nam', 'Các loại quần dành cho nam giới', '2025-05-25 07:20:36', '2025-05-25 07:20:36'),
(3, 'Phụ kiện', 'Các loại phụ kiện thời trang nam', '2025-05-25 07:20:36', '2025-05-25 07:20:36'),
(4, 'Giày Dép', 'Giày dép nam thời trang', '2025-05-25 07:20:36', '2025-05-25 07:20:36'),
(5, 'Túi Xách', 'Túi xách nam công sở và du lịch', '2025-05-25 07:20:36', '2025-05-25 07:20:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `user_id`, `comment_text`, `status`, `created_at`, `updated_at`) VALUES
(1, 14, 4, 'HIHI', 'approved', '2025-06-04 00:11:10', '2025-06-04 00:27:37'),
(2, 14, 4, 'hihi', 'approved', '2025-06-04 00:11:51', '2025-06-04 00:14:04'),
(3, 1, 2, 'như tuyệt vời', 'approved', '2025-06-10 05:30:11', '2025-06-10 05:30:11'),
(4, 3, 5, 'aaaaa', 'approved', '2025-06-11 06:56:19', '2025-06-11 06:56:19'),
(5, 14, 5, 'dùng không ổn :)', 'approved', '2025-06-16 17:23:46', '2025-06-16 17:23:46'),
(6, 14, 5, 'huhu', 'approved', '2025-06-16 20:54:09', '2025-06-16 20:54:09'),
(7, 2, 5, 'áo xinh', 'approved', '2025-06-16 21:06:55', '2025-06-16 21:06:55'),
(8, 3, 5, 'áo đẹppp', 'approved', '2025-06-16 21:09:34', '2025-06-16 21:09:34'),
(9, 3, 5, 'áo xấu :(', 'approved', '2025-06-16 21:09:50', '2025-06-16 21:09:50'),
(10, 14, 5, 'Mua cái khác đi', 'approved', '2025-06-16 21:39:54', '2025-06-16 21:39:54'),
(11, 14, 5, 'HIHI', 'approved', '2025-06-16 21:41:06', '2025-06-16 21:41:06'),
(12, 3, 5, 'Đẹp', 'approved', '2025-06-18 19:52:47', '2025-06-18 19:52:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','confirmed','delivering','completed','finished','cancelled') DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `full_name`, `email`, `phone`, `address`, `total_price`, `status`, `payment_status`, `payment_method`, `reason`, `created_at`, `updated_at`) VALUES
(2, 4, '', 'user10@gmail.com', '0945084526', '', 250000.00, 'cancelled', 'failed', 'cod', '', '2025-06-02 11:38:31', '2025-06-11 20:05:22'),
(3, 4, '', 'user10@gmail.com', '0945084526', '', 350000.00, 'cancelled', 'failed', 'cod', '', '2025-06-02 11:50:10', '2025-06-11 20:05:22'),
(4, 4, '', 'user10@gmail.com', '0945084526', '', 250000.00, 'cancelled', 'failed', 'cod', '', '2025-06-02 11:52:13', '2025-06-11 20:05:22'),
(6, 4, '', 'user10@gmail.com', '0945084526', '', 350000.00, 'cancelled', 'failed', 'cod', '', '2025-06-02 16:22:44', '2025-06-11 20:05:22'),
(7, 4, '', 'user10@gmail.com', '0945084526', '', 750000.00, 'cancelled', 'failed', 'cod', '', '2025-06-03 11:44:23', '2025-06-11 20:05:22'),
(8, 4, '', 'user10@gmail.com', '0945084526', '', 350000.00, 'delivering', 'pending', 'cod', '', '2025-06-04 06:29:12', '2025-06-13 04:43:59'),
(9, 4, '', 'user10@gmail.com', '0945084526', '', 700000.00, 'delivering', 'pending', 'cod', '', '2025-06-04 06:43:40', '2025-06-04 06:49:54'),
(21, 5, '', 'hung123@gmail.com', '0394879813', 'Hà Nội', 450000.00, 'cancelled', 'failed', 'cod', '', '2025-06-10 08:12:58', '2025-06-11 20:05:22'),
(22, 5, '', 'hung123@gmail.com', '0394879813', 'Hà Nội', 450000.00, 'cancelled', 'failed', 'cod', '', '2025-06-10 08:37:47', '2025-06-11 20:05:22'),
(23, 5, '', 'hung123@gmail.com', '0394879813', 'Hà Nội', 700000.00, 'cancelled', 'pending', 'cod', '', '2025-06-10 08:39:47', '2025-06-10 08:48:21'),
(24, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 900000.00, 'cancelled', 'failed', 'cod', '', '2025-06-10 08:51:34', '2025-06-13 05:19:07'),
(26, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 250000.00, 'cancelled', 'failed', 'cod', '', '2025-06-10 12:23:37', '2025-06-11 20:05:22'),
(27, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 900000.00, 'completed', 'paid', 'cod', '', '2025-06-11 14:26:49', '2025-06-13 04:43:35'),
(28, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 2000000.00, 'finished', 'paid', 'cod', '', '2025-06-11 15:18:30', '2025-06-14 16:59:05'),
(29, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 1500000.00, 'cancelled', 'failed', 'cod', '', '2025-06-11 15:19:51', '2025-06-13 05:10:34'),
(30, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 450000.00, 'completed', 'paid', 'cod', '', '2025-06-11 19:01:48', '2025-06-13 04:45:12'),
(31, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 900000.00, 'finished', 'paid', 'cod', '', '2025-06-11 19:06:09', '2025-06-14 16:58:39'),
(32, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 650000.00, 'cancelled', 'pending', 'cod', '', '2025-06-11 19:08:13', '2025-06-11 19:08:38'),
(33, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 250000.00, 'cancelled', 'failed', 'cod', '', '2025-06-11 19:12:30', '2025-06-11 20:05:22'),
(34, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 250000.00, 'cancelled', 'failed', 'cod', '', '2025-06-11 19:16:56', '2025-06-11 20:05:22'),
(35, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 750000.00, 'cancelled', 'failed', 'cod', '', '2025-06-11 19:20:53', '2025-06-11 20:05:22'),
(36, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 350000.00, 'cancelled', 'failed', 'cod', '', '2025-06-11 19:32:04', '2025-06-11 20:03:26'),
(37, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 250000.00, 'cancelled', 'failed', 'cod', '', '2025-06-11 19:37:10', '2025-06-11 20:03:26'),
(38, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 350000.00, 'cancelled', 'failed', 'cod', 'thích', '2025-06-11 19:44:02', '2025-06-11 20:03:26'),
(39, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 450000.00, 'cancelled', 'failed', 'cod', 'không muốn mua nữa', '2025-06-11 19:46:41', '2025-06-11 20:03:02'),
(40, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 450000.00, 'cancelled', 'failed', 'cod', 'không ', '2025-06-11 20:02:22', '2025-06-11 20:02:37'),
(41, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 3000000.00, 'finished', 'paid', 'cod', '', '2025-06-12 06:08:01', '2025-06-13 05:30:48'),
(42, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 2600000.00, 'finished', 'paid', 'cod', '', '2025-06-12 06:15:57', '2025-06-13 05:30:41'),
(43, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 1200000.00, 'cancelled', 'failed', 'cod', 'không muốn mua nữa', '2025-06-12 06:17:14', '2025-06-12 06:17:27'),
(44, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 1650000.00, 'finished', 'paid', 'cod', '', '2025-06-13 04:28:46', '2025-06-13 05:30:24'),
(45, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 1500000.00, 'finished', 'paid', 'cod', '', '2025-06-13 05:21:31', '2025-06-13 05:27:31'),
(46, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 450000.00, 'finished', 'paid', 'cod', '', '2025-06-13 05:32:57', '2025-06-13 05:33:44'),
(47, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 1550000.00, 'finished', 'paid', 'cod', '', '2025-06-14 12:09:41', '2025-06-14 12:13:57'),
(48, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 250000.00, 'finished', 'paid', 'cod', '', '2025-06-14 16:59:57', '2025-06-14 17:00:42'),
(49, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 500.00, 'cancelled', 'failed', 'cod', '', '2025-06-14 17:02:43', '2025-06-14 17:03:03'),
(50, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 650000.00, 'finished', 'paid', 'cod', '', '2025-06-14 17:05:55', '2025-06-14 17:08:11'),
(51, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 3300000.00, 'finished', 'paid', 'cod', '', '2025-06-17 05:30:46', '2025-06-17 05:31:28'),
(52, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 25000000.00, 'pending', 'pending', 'cod', '', '2025-06-17 05:33:37', '2025-06-17 05:33:37'),
(53, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 1000000.00, 'pending', 'pending', 'cod', '', '2025-06-17 16:11:44', '2025-06-17 16:11:44'),
(54, 5, 'hung123', 'bgird538@gmail.com', '0394879813', 'Hà Nội', 500000.00, 'cancelled', 'failed', 'cod', 'thích thì huỷ\r\n', '2025-06-18 14:57:18', '2025-06-18 14:59:26'),
(55, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 350000.00, 'pending', 'pending', 'cod', '', '2025-06-18 15:46:27', '2025-06-18 15:46:27'),
(56, 5, 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 650000.00, 'pending', 'pending', 'cod', '', '2025-06-19 12:16:54', '2025-06-19 12:16:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `total_price`, `discount_price`, `created_at`) VALUES
(8, 6, NULL, 1, 350000.00, 350000.00, NULL, '2025-06-02 08:56:34'),
(9, 7, 14, 1, 750000.00, 750000.00, NULL, '2025-06-02 09:07:36'),
(10, 8, 5, 1, 450000.00, 450000.00, NULL, '2025-06-02 09:48:01'),
(12, 2, 2, 1, 250000.00, 250000.00, NULL, '2025-06-02 11:38:31'),
(13, 3, 6, 1, 350000.00, 350000.00, NULL, '2025-06-02 11:50:10'),
(14, 4, 2, 1, 250000.00, 250000.00, NULL, '2025-06-02 11:52:13'),
(16, 6, 7, 1, 350000.00, 350000.00, NULL, '2025-06-02 16:22:44'),
(17, 7, 14, 1, 750000.00, 750000.00, NULL, '2025-06-03 11:44:23'),
(18, 8, NULL, 1, 350000.00, 350000.00, NULL, '2025-06-04 06:29:12'),
(19, 9, 2, 1, 250000.00, 250000.00, NULL, '2025-06-04 06:43:41'),
(20, 9, 3, 1, 450000.00, 450000.00, NULL, '2025-06-04 06:43:41'),
(32, 21, 5, 1, 450000.00, 450000.00, NULL, '2025-06-10 08:12:58'),
(33, 22, 5, 1, 450000.00, 450000.00, NULL, '2025-06-10 08:37:47'),
(34, 23, NULL, 2, 350000.00, 700000.00, NULL, '2025-06-10 08:39:47'),
(35, 24, 8, 2, 450000.00, 900000.00, NULL, '2025-06-10 08:51:34'),
(39, 26, 2, 1, 250000.00, 250000.00, NULL, '2025-06-10 12:23:37'),
(40, 27, 3, 2, 450000.00, 900000.00, NULL, '2025-06-11 14:26:49'),
(41, 28, 4, 2, 650000.00, 1300000.00, NULL, '2025-06-11 15:18:30'),
(42, 28, 7, 2, 350000.00, 700000.00, NULL, '2025-06-11 15:18:30'),
(43, 29, 14, 2, 750000.00, 1500000.00, NULL, '2025-06-11 15:19:51'),
(44, 30, 3, 1, 450000.00, 450000.00, NULL, '2025-06-11 19:01:48'),
(45, 31, 5, 2, 450000.00, 900000.00, NULL, '2025-06-11 19:06:09'),
(46, 32, 4, 1, 650000.00, 650000.00, NULL, '2025-06-11 19:08:13'),
(47, 33, 2, 1, 250000.00, 250000.00, NULL, '2025-06-11 19:12:30'),
(48, 34, 2, 1, 250000.00, 250000.00, NULL, '2025-06-11 19:16:56'),
(49, 35, 2, 3, 250000.00, 750000.00, NULL, '2025-06-11 19:20:53'),
(50, 36, 7, 1, 350000.00, 350000.00, NULL, '2025-06-11 19:32:04'),
(51, 37, 12, 1, 250000.00, 250000.00, NULL, '2025-06-11 19:37:10'),
(52, 38, 6, 1, 350000.00, 350000.00, NULL, '2025-06-11 19:44:02'),
(53, 39, 3, 1, 450000.00, 450000.00, NULL, '2025-06-11 19:46:41'),
(54, 40, 3, 1, 450000.00, 450000.00, NULL, '2025-06-11 20:02:22'),
(55, 41, 13, 2, 550000.00, 1100000.00, NULL, '2025-06-12 06:08:01'),
(56, 41, 15, 2, 950000.00, 1900000.00, NULL, '2025-06-12 06:08:01'),
(57, 42, 5, 2, 450000.00, 900000.00, NULL, '2025-06-12 06:15:57'),
(58, 42, 10, 2, 850000.00, 1700000.00, NULL, '2025-06-12 06:15:57'),
(59, 43, 11, 1, 1200000.00, 1200000.00, NULL, '2025-06-12 06:17:14'),
(60, 44, 13, 3, 550000.00, 1650000.00, NULL, '2025-06-13 04:28:46'),
(61, 45, 14, 2, 750000.00, 1500000.00, NULL, '2025-06-13 05:21:31'),
(62, 46, 3, 1, 450000.00, 450000.00, NULL, '2025-06-13 05:32:57'),
(63, 47, 3, 2, 450000.00, 900000.00, NULL, '2025-06-14 12:09:41'),
(64, 47, 4, 1, 650000.00, 650000.00, NULL, '2025-06-14 12:09:41'),
(65, 48, 2, 1, 250000.00, 250000.00, NULL, '2025-06-14 16:59:57'),
(66, 49, 3, 1, 500.00, 500.00, NULL, '2025-06-14 17:02:43'),
(67, 50, 4, 1, 650000.00, 650000.00, NULL, '2025-06-14 17:05:55'),
(68, 51, 4, 3, 650000.00, 1950000.00, NULL, '2025-06-17 05:30:46'),
(69, 51, 5, 3, 450000.00, 1350000.00, NULL, '2025-06-17 05:30:46'),
(70, 52, 2, 100, 250000.00, 25000000.00, NULL, '2025-06-17 05:33:37'),
(71, 53, 4, 1, 650000.00, 650000.00, NULL, '2025-06-17 16:11:44'),
(72, 53, 6, 1, 350000.00, 350000.00, NULL, '2025-06-17 16:11:44'),
(73, 54, 3, 1, 500000.00, 500000.00, NULL, '2025-06-18 14:57:18'),
(74, 55, 6, 1, 350000.00, 350000.00, NULL, '2025-06-18 15:46:27'),
(75, 56, 4, 1, 650000.00, 650000.00, NULL, '2025-06-19 12:16:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `discount_price`, `image`, `category_id`, `stock`, `views`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Áo thun nam basic', 'Áo thun nam basic, chất liệu cotton 100%', 250000.00, 199000.00, 'uploads/products/pro13.webp', 1, 3, 800, 'active', '2025-05-25 07:20:36', '2025-06-17 05:33:37'),
(3, 'Áo polo nam', 'Áo polo nam, chất liệu cotton pique', 500000.00, 399000.00, 'uploads/products/pro12.jpg', 1, 71, 13, 'active', '2025-05-25 07:20:36', '2025-06-18 14:59:26'),
(4, 'Quần jean nam slim', 'Quần jean nam slim fit, chất liệu denim', 650000.00, 550000.00, 'uploads/products/pro12.webp', 2, 31, 230000, 'active', '2025-05-25 07:20:36', '2025-06-19 12:16:54'),
(5, 'Quần khaki nam', 'Quần khaki nam, chất liệu cotton', 450000.00, 399000.00, 'uploads/products/pro11.jpg', 2, 48, 241, 'active', '2025-05-25 07:20:36', '2025-06-17 05:30:46'),
(6, 'Quần short nam', 'Quần short nam, chất liệu cotton thoáng mát', 350000.00, 299000.00, 'uploads/products/pro10.jpg', 2, 169, 1555, 'active', '2025-05-25 07:20:36', '2025-06-18 15:46:27'),
(7, 'Thắt lưng da nam', 'Thắt lưng da nam, chất liệu da thật', 350000.00, 299000.00, 'uploads/products/pro9.jpg', 3, 28, 1211, 'active', '2025-05-25 07:20:36', '2025-06-11 19:32:20'),
(8, 'Ví da nam', 'Ví da nam, nhiều ngăn tiện dụng', 450000.00, 399000.00, 'uploads/products/pro8.jpg', 3, 34, 1211, 'active', '2025-05-25 07:20:36', '2025-06-13 05:19:07'),
(9, 'Đồng hồ nam dây da', 'Đồng hồ nam dây da, thiết kế thanh lịch', 1200000.00, 999000.00, 'uploads/products/pro7.jpg', 3, 25, 10000, 'active', '2025-05-25 07:20:36', '2025-06-02 09:52:18'),
(10, 'Giày lười nam da', 'Giày lười nam da thật, thiết kế tối giản', 850000.00, 750000.00, 'uploads/products/pro6.jpg', 4, 43, 2500, 'active', '2025-05-25 07:20:36', '2025-06-12 06:15:57'),
(11, 'Giày thể thao nam', 'Giày thể thao nam, đế cao su bền bỉ', 1200000.00, 999000.00, 'uploads/products/pro5.jpg', 4, 100, 2000, 'active', '2025-05-25 07:20:36', '2025-06-12 06:17:27'),
(12, 'Dép quai ngang nam', 'Dép quai ngang nam, chất liệu cao su', 250000.00, 199000.00, 'uploads/products/pro4.jpg', 4, 80, 1990, 'active', '2025-05-25 07:20:36', '2025-06-11 19:37:19'),
(13, 'Túi đeo chéo nam', 'Túi đeo chéo nam, thiết kế đơn giản', 550000.00, 499000.00, 'uploads/products/pro3.jpg', 5, 35, 2100, 'active', '2025-05-25 07:20:36', '2025-06-13 04:28:46'),
(14, 'Ba lô nam công sở', 'Ba lô nam công sở, nhiều ngăn tiện dụng', 750000.00, 650000.00, 'uploads/products/pro2.jpg', 5, 39, 12311, 'active', '2025-05-25 07:20:36', '2025-06-13 05:21:31'),
(15, 'Túi xách tay nam', 'Túi xách tay nam, chất liệu da tổng hợp', 950000.00, 850000.00, 'uploads/products/pro1.jpg', 5, 28, 12002, 'active', '2025-05-25 07:20:36', '2025-06-12 06:08:01'),
(16, 'Product 10 updated', 'Mô tả', 1000000.00, NULL, 'uploads/products/1750275699_8828bf511eca27c0df0b914cc3780c1b.jpg', 1, 100, 0, 'active', '2025-06-18 19:24:06', '2025-06-18 19:41:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('active','inactive','locked') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `phone`, `address`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', 'admin@gmail.com', '0123456789', 'Hà Nội', 'user', 'active', NULL, '2025-05-25 09:50:48', '2025-06-11 20:10:37'),
(2, 'admin2', '$2y$10$bYzCh.1R5V9svE8.1RgNYecYw.ivaMk5fPu.hA.GH8ObUu0Uql9cK', '', 'admin2@gmail.com', NULL, NULL, 'admin', 'active', '2025-06-19 12:07:17', '2025-05-25 09:53:03', '2025-06-19 12:07:17'),
(3, 'admin3', '$2y$10$vqRKoHSsGEaK5wwEzwROm.cUNYs8rN4YeEdq4LYtgalaj9QUg7Bzu', '', 'admin3@gmail.com', '0394879813', 'Hà Nội', 'user', 'active', NULL, '2025-05-27 12:34:06', '2025-06-11 20:32:52'),
(4, 'user10', '$2y$10$c2sxG/LwMxhzB2XVmq2m8unMErvM4P3zcXzWNYmUcXWn1bJzBjS8m', 'Lê Đức Quân', 'user10@gmail.com', '0945084526', 'hihi', 'user', 'active', NULL, '2025-06-02 08:52:43', '2025-06-02 08:52:43'),
(5, 'hung123', '$2y$10$vaMhkpPJHIW1tK30ie0LQuOirBeTshY0TKkW3NqZ4oQ/j078wAj8.', 'hung123', 'hung123@gmail.com', '0394879813', 'Hà Nội', 'user', 'active', NULL, '2025-06-05 12:52:56', '2025-06-05 12:52:56');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`,`user_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
