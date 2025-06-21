-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 07:53 AM
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
-- Database: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `content`, `image`, `author_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Top 10 Smartphones of 2024', 'top-10-smartphones-2024', 'Discover the best smartphones available in 2024 with cutting-edge features and performance...', 'blog-smartphones.jpg', 1, 'published', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(2, 'Fashion Trends for Summer', 'fashion-trends-summer', 'Stay ahead of the fashion curve with these summer trends that are dominating the runway...', 'blog-fashion.jpg', 1, 'published', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(3, 'Must-Read Books This Year', 'must-read-books-2024', 'A curated list of the most compelling books that you should add to your reading list...', 'blog-books.jpg', 1, 'published', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(4, 'Home Improvement Tips', 'home-improvement-tips', 'Transform your living space with these practical home improvement tips and tricks...', 'blog-home.jpg', 1, 'published', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(5, 'Sustainable Living Guide', 'sustainable-living-guide', 'Learn how to live a more sustainable lifestyle with these eco-friendly practices...', 'blog-sustainable.jpg', 1, 'published', '2025-06-18 12:25:21', '2025-06-18 12:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `created_at`) VALUES
(1, 'Electronics', 'electronics', 'Electronic devices and gadgets', 'active', '2025-06-18 12:25:21'),
(2, 'Clothing', 'clothing', 'Fashion and apparel', 'active', '2025-06-18 12:25:21'),
(3, 'Books', 'books', 'Books and literature', 'active', '2025-06-18 12:25:21'),
(4, 'Home & Garden', 'home-garden', 'Home improvement and garden supplies', 'active', '2025-06-18 12:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` enum('user','admin') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `room_id`, `sender_id`, `sender_type`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 2, 'user', 'Hello, I have a question about my order', 1, '2025-06-18 12:25:21'),
(2, 1, 1, 'admin', 'Hi! Sure, I\'d be happy to help. What\'s your order number?', 1, '2025-06-18 12:25:21'),
(3, 1, 2, 'user', 'My order number is #ORD001', 1, '2025-06-18 12:25:21'),
(4, 1, 1, 'admin', 'I can see your order. It\'s currently being processed and will be shipped tomorrow.', 1, '2025-06-18 12:25:21'),
(5, 2, 3, 'user', 'Hi admin, when will my product be back in stock?', 1, '2025-06-18 12:25:21'),
(6, 2, 1, 'admin', 'Hello! The product should be back in stock by next week. Would you like me to notify you when it\'s available?', 1, '2025-06-18 12:25:21'),
(7, 3, 4, 'user', 'I need help with my account', 1, '2025-06-18 12:25:21'),
(8, 3, 1, 'admin', 'Of course! What seems to be the issue with your account?', 0, '2025-06-18 12:25:21'),
(9, 1, 1, 'admin', 'Hi', 1, '2025-06-18 12:49:41'),
(10, 1, 1, 'admin', 'hi pratik', 1, '2025-06-19 06:21:52'),
(11, 1, 2, 'user', 'Hi admin', 1, '2025-06-19 06:22:03'),
(12, 2, 1, 'admin', 'test', 1, '2025-06-19 06:58:11'),
(13, 2, 3, 'user', 'teasa', 1, '2025-06-19 06:58:50');

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_rooms`
--

INSERT INTO `chat_rooms` (`id`, `user_id`, `admin_id`, `room_name`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Chat with John Doe', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(2, 3, 1, 'Chat with Jane Smith', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(3, 4, 1, 'Chat with Mike Johnson', '2025-06-18 12:25:21', '2025-06-18 12:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `customer_chat_messages`
--

CREATE TABLE `customer_chat_messages` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` enum('customer','user') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_chat_rooms`
--

CREATE TABLE `customer_chat_rooms` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `shipping_address` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `total_amount`, `status`, `shipping_address`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 'ORD-20250619-3063', 3, 299.99, 'pending', 'surat', 'paypal', '2025-06-19 07:01:17', '2025-06-19 07:01:17');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`) VALUES
(1, 1, 3, 'Sony WH-1000XM4 Headphones', 1, 299.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `sale_price`, `image`, `category_id`, `stock_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'iPhone 13 Pro', 'iphone-13-pro', 'Latest iPhone with advanced camera system', 999.99, 899.99, 'iphone13pro-modern.jpg', 1, 1, 'active', '2025-06-18 12:25:21', '2025-06-19 07:03:31'),
(2, 'Samsung Galaxy S21', 'samsung-galaxy-s21', 'Premium Android smartphone', 799.99, 699.99, 'galaxys21-modern.jpg', 1, 30, 'active', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(3, 'Sony WH-1000XM4 Headphones', 'sony-wh-1000xm4', 'Industry-leading noise cancelling headphones', 349.99, 299.99, 'sony-headphones.jpg', 1, 39, 'active', '2025-06-18 12:25:21', '2025-06-19 07:01:17'),
(4, 'Nike Air Max', 'nike-air-max', 'Comfortable running shoes', 129.99, 99.99, 'nikeairmax-modern.jpg', 2, 100, 'active', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(5, 'Adidas T-Shirt', 'adidas-t-shirt', 'Comfortable cotton t-shirt', 29.99, 24.99, 'adidas-tshirt-modern.jpg', 2, 200, 'active', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(6, 'The Great Gatsby', 'the-great-gatsby', 'Classic American novel', 12.99, 9.99, 'greatgatsby-modern.jpg', 3, 75, 'active', '2025-06-18 12:25:21', '2025-06-18 12:25:21'),
(7, 'Garden Tool Set', 'garden-tool-set', 'Complete gardening tool kit', 89.99, 79.99, 'gardentools-modern.jpg', 4, 25, 'active', '2025-06-18 12:25:21', '2025-06-18 12:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `subtitle` varchar(200) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `image`, `link`, `status`, `sort_order`, `created_at`) VALUES
(1, 'Welcome to Our Store', 'Discover amazing products at great prices', 'slider-modern-1.jpg', '/products', 'active', 1, '2025-06-18 12:25:21'),
(2, 'New Arrivals', 'Check out our latest collection', 'slider-modern-2.jpg', '/products', 'active', 2, '2025-06-18 12:25:21'),
(3, 'Special Offers', 'Limited time deals on selected items', 'slider-modern-3.jpg', '/products', 'active', 3, '2025-06-18 12:25:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `status` enum('active','blocked') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NULL, 'admin', 'active', '2025-06-18 12:25:21', '2025-06-19 06:57:43'),
(2, 'pratik', 'pratik96872@gmail.com', '$2y$10$jHyEz.5Wls1L69E1ZjM4BOUj7Lx8O9qa/cYiynONjNjdOgH3Da8wW', '9687263711', 'surat', 'user', 'active', '2025-06-18 12:28:57', '2025-06-18 12:28:57'),
(3, 'Test', 'test@gmail.com', '$2y$10$wpb6jDGOfrj0uZbLFi4VwuKzpDKhThpHGBb/ITDNbWb1uMuQCS60y', '7894561234', 'surat', 'user', 'active', '2025-06-19 06:56:46', '2025-06-19 06:56:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `customer_chat_messages`
--
ALTER TABLE `customer_chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `customer_chat_rooms`
--
ALTER TABLE `customer_chat_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_chat_messages`
--
ALTER TABLE `customer_chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_chat_rooms`
--
ALTER TABLE `customer_chat_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD CONSTRAINT `chat_rooms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_rooms_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
