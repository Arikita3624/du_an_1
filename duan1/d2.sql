-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 27, 2025 lúc 02:55 PM
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
(2, 3, 0, '2025-05-27 12:35:55', '2025-05-27 12:35:55');

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
(11, 1, 10, 850000, 1, 850000.00, '2025-05-27 10:05:59', '2025-05-27 10:05:59'),
(13, 2, 2, 250000, 1, 250000.00, '2025-05-27 12:36:18', '2025-05-27 12:36:18');

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
  `content` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `payment_method` enum('cod','banking','momo','zalopay') DEFAULT 'cod',
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Áo sơ mi trắng nam', 'Áo sơ mi trắng cổ trụ, chất liệu cotton', 350000.00, 299000.00, 'uploads/products/1748297889_ao-so-mi-nam-bycotton-trang-art-nhan_8ec622a241ea4deb93a02bdbdcb87954.png', 1, 50, 2311, 'active', '2025-05-25 07:20:36', '2025-05-26 22:18:09'),
(2, 'Áo thun nam basic', 'Áo thun nam basic, chất liệu cotton 100%', 250000.00, 199000.00, 'uploads/products/1748297898_8-XAM-LD9202.png', 1, 100, 800, 'active', '2025-05-25 07:20:36', '2025-05-26 22:18:18'),
(3, 'Áo polo nam', 'Áo polo nam, chất liệu cotton pique', 450000.00, 399000.00, 'uploads/products/1748297910_548e103d31d2952b748f18f04406a434_37d5015da5cd409790f296c97c279909_89c4cdbacbc647a9a61c1b22fb4fa7b4.png', 1, 75, 13, 'active', '2025-05-25 07:20:36', '2025-05-26 22:18:30'),
(4, 'Quần jean nam slim', 'Quần jean nam slim fit, chất liệu denim', 650000.00, 550000.00, 'uploads/products/1748297919_xucqn-jean-slim-fit-4_472c3f0ac7ea4248b4e9892783114695.png', 2, 40, 230000, 'active', '2025-05-25 07:20:36', '2025-05-26 22:18:39'),
(5, 'Quần khaki nam', 'Quần khaki nam, chất liệu cotton', 450000.00, 399000.00, 'uploads/products/1748297928_4002A--1.png', 2, 55, 241, 'active', '2025-05-25 07:20:36', '2025-05-26 22:18:48'),
(6, 'Quần short nam', 'Quần short nam, chất liệu cotton thoáng mát', 350000.00, 299000.00, 'uploads/products/1748297782_3-xam-ld4136.png', 2, 70, 1555, 'active', '2025-05-25 07:20:36', '2025-05-26 22:16:22'),
(7, 'Thắt lưng da nam', 'Thắt lưng da nam, chất liệu da thật', 350000.00, 299000.00, 'uploads/products/1748333177_thatlung.png', 3, 30, 1211, 'active', '2025-05-25 07:20:36', '2025-05-27 08:06:17'),
(8, 'Ví da nam', 'Ví da nam, nhiều ngăn tiện dụng', 450000.00, 399000.00, 'uploads/products/1748333136_vida.png', 3, 35, 1211, 'active', '2025-05-25 07:20:36', '2025-05-27 08:05:36'),
(9, 'Đồng hồ nam dây da', 'Đồng hồ nam dây da, thiết kế thanh lịch', 1200000.00, 999000.00, 'uploads/products/1748297757_dh.png', 3, 25, 10000, 'active', '2025-05-25 07:20:36', '2025-05-26 22:15:57'),
(10, 'Giày lười nam da', 'Giày lười nam da thật, thiết kế tối giản', 850000.00, 750000.00, 'uploads/products/1748292957_1748292869_Giayluoi.png', 4, 45, 2500, 'active', '2025-05-25 07:20:36', '2025-05-26 20:55:57'),
(11, 'Giày thể thao nam', 'Giày thể thao nam, đế cao su bền bỉ', 1200000.00, 999000.00, 'uploads/products/1748292943_dc9fda50f24f5456c48681312c0da4c1.jpg_720x720q80.png', 4, 100, 2000, 'active', '2025-05-25 07:20:36', '2025-05-26 20:55:43'),
(12, 'Dép quai ngang nam', 'Dép quai ngang nam, chất liệu cao su', 250000.00, 199000.00, 'uploads/products/1748293004_img_9143_2a377f31f88a423eae2c9609478fed3b_master.png', 4, 80, 1990, 'active', '2025-05-25 07:20:36', '2025-05-26 20:56:44'),
(13, 'Túi đeo chéo nam', 'Túi đeo chéo nam, thiết kế đơn giản', 550000.00, 499000.00, 'uploads/products/1748333096_1748297743_TX1TLDK011D02.png', 5, 40, 2100, 'active', '2025-05-25 07:20:36', '2025-05-27 08:04:56'),
(14, 'Ba lô nam công sở', 'Ba lô nam công sở, nhiều ngăn tiện dụng', 750000.00, 650000.00, 'uploads/products/1748297750_balo-dung-laptop-cong-so-gubag-gb-bl46-1.png', 5, 35, 12311, 'active', '2025-05-25 07:20:36', '2025-05-26 22:15:50'),
(15, 'Túi xách tay nam', 'Túi xách tay nam, chất liệu da tổng hợp', 950000.00, 850000.00, 'uploads/products/1748297743_TX1TLDK011D02.png', 5, 30, 12002, 'active', '2025-05-25 07:20:36', '2025-05-26 22:15:43');

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
(1, 'admin', 'admin@gmail.com', 'admin', 'admin@gmail.com', '0123456789', 'Hà Nội', 'admin', 'active', NULL, '2025-05-25 09:50:48', '2025-05-25 09:50:48'),
(2, 'admin2', '$2y$10$bYzCh.1R5V9svE8.1RgNYecYw.ivaMk5fPu.hA.GH8ObUu0Uql9cK', '', 'admin2@gmail.com', NULL, NULL, 'admin', 'active', NULL, '2025-05-25 09:53:03', '2025-05-25 09:53:28'),
(3, 'admin3', '$2y$10$vqRKoHSsGEaK5wwEzwROm.cUNYs8rN4YeEdq4LYtgalaj9QUg7Bzu', '', 'admin3@gmail.com', '0394879813', 'Hà Nội', 'user', 'active', NULL, '2025-05-27 12:34:06', '2025-05-27 12:34:06');

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
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
