-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2025 at 04:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_complaints`
--

CREATE TABLE `customer_complaints` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE `customer_orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `order_details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_orders`
--

INSERT INTO `customer_orders` (`id`, `name`, `phone`, `email`, `order_details`) VALUES
(8, 'ramdan', '049', 'fajiu@gmail.com', '[{\"name\":\"Es Cendol\",\"price\":\"15000.00\",\"quantity\":1},{\"name\":\"Es Campur\",\"price\":\"17000.00\",\"quantity\":1},{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":2}]'),
(9, 'ramdan', '049', 'fajiu@gmail.com', '[{\"name\":\"Es Cendol\",\"price\":\"15000.00\",\"quantity\":1},{\"name\":\"Es Campur\",\"price\":\"17000.00\",\"quantity\":1},{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":2}]'),
(10, 'ramdan', '049', 'fajiu@gmail.com', '[{\"name\":\"Es Cendol\",\"price\":\"15000.00\",\"quantity\":1},{\"name\":\"Es Campur\",\"price\":\"17000.00\",\"quantity\":1},{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":2}]'),
(11, 'ramdan', '049', 'fajiu@gmail.com', '[{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":1}]'),
(12, 'ramdan', '049', 'fajiu@gmail.com', '[{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":1}]'),
(13, 'ramdan', '049', 'fajiu@gmail.com', '[{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":1}]'),
(14, 'Ramdan Ali', '085860725344', 'fajiuyuka@gmail.com', '[{\"name\":\"Ikan Bakar Kecap\",\"price\":\"35000.00\",\"quantity\":1},{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":1}]'),
(15, 'jih', '0899', 'windasulastri070401@gmail.com', '[{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":1},{\"name\":\"Ikan Bakar Kecap\",\"price\":\"35000.00\",\"quantity\":1},{\"name\":\"Nasi Timbel\",\"price\":\"20000.00\",\"quantity\":1},{\"name\":\"Renginang\",\"price\":\"5000.00\",\"quantity\":1},{\"name\":\"Lotek\",\"price\":\"15000.00\",\"quantity\":1},{\"name\":\"Es Oyen\",\"price\":\"16000.00\",\"quantity\":1}]');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` enum('Makanan','Minuman','Dessert') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `category`, `price`, `image_url`) VALUES
(67, 'Pepes Ikan', 'Makanan', 28000.00, 'https://tse2.mm.bing.net/th?id=OIP.URo3wsv4YrayKelZFXtMHgHaE5&pid=Api&P=0&h=220'),
(68, 'Tumis Kangkung', 'Makanan', 18000.00, 'https://tse4.mm.bing.net/th?id=OIP.wtwOo5OZ79aFT10f75UKCQHaEK&pid=Api&P=0&h=220'),
(69, 'Ikan Bakar Kecap', 'Makanan', 35000.00, 'https://tse3.mm.bing.net/th?id=OIP.yQRhIWkuEVKTpYxjoCvJ8QHaGN&pid=Api&P=0&h=220'),
(70, 'Lalapan Sambal Terasi', 'Makanan', 10000.00, 'https://tse4.mm.bing.net/th?id=OIP.6rBkdiAvCPJJOJ6D9zvy0QHaE7&pid=Api&P=0&h=220'),
(71, 'Es Doger', 'Minuman', 15000.00, 'https://tse4.mm.bing.net/th?id=OIP.TcbAvUxnIEusBzuvA2XV2AHaEK&pid=Api&P=0&h=220'),
(72, 'Nasi Timbel', 'Makanan', 20000.00, 'https://tse3.mm.bing.net/th?id=OIP.NV7-QCBqJENpdpr_Dlj0aQHaEK&pid=Api&P=0&h=220'),
(73, 'Bakakak Ayam', 'Makanan', 45000.00, 'https://tse1.mm.bing.net/th?id=OIP.4Yt8ne9EIdQjMktG9dUq3wHaEh&pid=Api&P=0&h=220'),
(74, 'Es Campur', 'Minuman', 17000.00, 'https://tse1.mm.bing.net/th?id=OIP.omsiNMzlZrXqEJy0yveP9wHaE6&pid=Api&P=0&h=220'),
(75, 'Karedok', 'Makanan', 20000.00, 'https://tse3.mm.bing.net/th?id=OIP.dEuxxTerAVRj6_5n9Em5QQHaE8&pid=Api&P=0&h=220'),
(76, 'Combro', 'Dessert', 8000.00, 'https://tse2.mm.bing.net/th?id=OIP.KwguzlthRKquiA1JbXzybQHaE7&pid=Api&P=0&h=220'),
(77, 'Misro', 'Dessert', 8000.00, 'https://tse3.mm.bing.net/th?id=OIP.X3J3hSixebWaincbEWTCbgHaGM&pid=Api&P=0&h=220'),
(78, 'Renginang', 'Makanan', 5000.00, 'https://tse1.mm.bing.net/th?id=OIP.gDNsuHw_ZcRHFEJXe-6lmQHaEK&pid=Api&P=0&h=220'),
(79, 'Gepuk Daging', 'Makanan', 32000.00, 'https://tse1.mm.bing.net/th?id=OIP.VK06SfaGHPEsQ4syNuhS9gHaFP&pid=Api&P=0&h=220'),
(80, 'Lotek', 'Makanan', 15000.00, 'https://tse4.mm.bing.net/th?id=OIP.iA7vTq8m6CutHVBXbq4YnQHaE7&pid=Api&P=0&h=220'),
(81, 'Es Oyen', 'Minuman', 16000.00, 'https://tse4.mm.bing.net/th?id=OIP.g8x7doBNXNsVOMoIeLYVuQHaEK&pid=Api&P=0&h=220'),
(82, 'Es Cendol', 'Minuman', 15000.00, 'https://tse1.mm.bing.net/th?id=OIP.xZo9t0-PzEipmSoavgsE2gHaE7&pid=Api&P=0&h=220');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_details` text NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_method`, `order_details`, `payment_date`) VALUES
(1, 'Debit', '[{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":1}]', '2025-01-14 16:32:50'),
(2, 'Cash', '[{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":1}]', '2025-01-14 16:33:15'),
(3, 'Cash', '[{\"name\":\"Ikan Bakar Kecap\",\"price\":\"35000.00\",\"quantity\":1},{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":1}]', '2025-01-18 06:15:52'),
(4, 'Cash', '[{\"name\":\"Tumis Kangkung\",\"price\":\"18000.00\",\"quantity\":1},{\"name\":\"Ikan Bakar Kecap\",\"price\":\"35000.00\",\"quantity\":1},{\"name\":\"Nasi Timbel\",\"price\":\"20000.00\",\"quantity\":1},{\"name\":\"Renginang\",\"price\":\"5000.00\",\"quantity\":1},{\"name\":\"Lotek\",\"price\":\"15000.00\",\"quantity\":1},{\"name\":\"Es Oyen\",\"price\":\"16000.00\",\"quantity\":1}]', '2025-01-18 08:13:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `customer_complaints`
--
ALTER TABLE `customer_complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_complaints`
--
ALTER TABLE `customer_complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_orders`
--
ALTER TABLE `customer_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
