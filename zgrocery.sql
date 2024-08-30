-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2024 at 12:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zgrocery`
--

CREATE DATABASE zgrocery;
USE zgrocery;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `number`, `email`, `address`, `total_products`, `total_price`, `placed_on`) VALUES
(21, 'Alex', '0456456777', 'alex@gmail.com', '8/9 Broadway Street, Burwood, VIC 2009, Australia', ' Cabbage ( 10 )', 30, '20-Apr-2024'),
(22, 'Sandy', '0567456345', 'sandy@gmail.com', '8/9 Broadway Street, Burwood, NSW 2009, Australia', ' Cabbage ( 10 )', 30, '20-Apr-2024'),
(26, 'John Smith', '0678764567', '898@gmail.com', '8/1 Broadway Street, maey, QLD 2002, Australia', ' Apple ( 100 )', 200, '20-Apr-2024'),
(28, 'john ', '0459888898', 'ho@989.com', '0kkkkk, Bui, WA 2000, Australia', ' Apple ( 100 )', 200, '20-Apr-2024'),
(30, 'Jone Smith', '0564765456', 'jone@gmail.com', '8/1 Broadway Street, Burwood, NSW 2005, Australia', ' Cabbage ( 10 )', 30, '20-Apr-2024'),
(32, 'John Smith', '0567876878', 'john@gmail.com', '6/9 Jones Street, Burwood, NSW 2005, Australia', ' Apple ( 10 )', 20, '20-Apr-2024'),
(33, 'John Smith', '0567876567', 'john@smith.com', '8/40 Broadway Street, Burwood, NSW 2009, Australia', ' Cabbage ( 10 )', 30, '20-Apr-2024'),
(34, 'John Smith', '0456765456', 'john@gmail.com', '8/106 Jones Street, Burwood, NSW 2098, Australia', ' Apple ( 20 )', 40, '20-Apr-2024'),
(40, 'John', '1231231230', 'john@gmail.com', '1 Main St, Sydney, NSW 2000, Australia', ' Broccoli ( 2 ) Orange ( 2 )', 16, '27-Apr-2024'),
(41, 'john@gmail.com', '1231231230', 'john@gmail.com', '1 Main St, Sydney, NSW 2000, Australia', ' Orange ( 2 ) Broccoli ( 6 )', 36, '27-Apr-2024'),
(42, 'John', '0456544555', 'john@gmail.com', '8/450 Jones Street, Burwood, NSW 2007, Australia', ' Orange ( 4 ) Banana ( 0 )', 12, '27-Apr-2024'),
(43, 'John ', '0465656765', 'john@gmail.com', '460 Jones street, Ultimo, NSW 2007, Australia', ' Kiwi ( 20 )', 100, '27-Apr-2024'),
(44, 'John', '0456978765', 'john@gmail.com', '8/1 Jones Street, Ultimo, NSW 2007, Australia', ' Watermelon ( 20 ) Orange ( 12 )', 146, '27-Apr-2024'),
(45, 'John ', '0455455455', 'john@gmail.com', '1 Jones Street, Burwood, NSW 2007, Australia', ' Watermelon ( 20 )', 110, '27-Apr-2024');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `product_id`, `price`, `quantity`) VALUES
(40, 38, 5.00, 2),
(40, 39, 3.00, 2),
(41, 39, 3.00, 2),
(41, 38, 5.00, 6),
(42, 39, 3.00, 4),
(42, 41, 4.00, 0),
(43, 43, 5.00, 20),
(44, 44, 5.50, 20),
(44, 39, 3.00, 12),
(45, 44, 5.50, 20);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL DEFAULT 0,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `unit`, `quantity`, `image`) VALUES
(44, 'Watermelon', 'fruits', 5.50, 'Each', 0, 'watermelon.png'),
(45, 'Apple', 'fruits', 0.80, 'Each', 20, 'apple.png'),
(47, 'Grapes', 'fruits', 5.50, '1kg', 20, 'grape.png'),
(48, 'Mandarin', 'fruits', 0.50, 'Each', 20, 'mandarin.png'),
(50, 'Beef', 'meat', 25.00, '1kg', 0, 'beef.png'),
(51, 'Chicken', 'meat', 15.00, '1kg', 20, 'chicken.png'),
(52, 'Lamb', 'meat', 22.50, '1kg', 20, 'lamb.png'),
(53, 'Pork', 'meat', 16.50, '1kg', 20, 'pork.png'),
(54, 'Avocado', 'vegetables', 1.50, 'Each', 20, 'avocado.png'),
(56, 'Carrots', 'vegetables', 1.50, 'Pack', 20, 'carrot.png'),
(57, 'Onion', 'vegetables', 6.50, '1kg', 20, 'onion.png'),
(58, 'Tamato', 'vegetables', 8.50, '1kg', 20, 'tomato.png'),
(59, 'Ice Cream', 'others', 9.90, 'Each', 20, 'ice cream.png'),
(60, 'Panadol', 'others', 8.90, 'Each', 20, 'panadol.png'),
(61, 'Yoghurt', 'others', 10.50, 'Each', 20, 'yoghurt.png'),
(62, 'Sunscreen', 'others', 19.90, 'Each', 20, 'sunscreen.png'),
(63, 'Kiwi', 'fruits', 1.50, 'Each', 20, 'kiwi.png');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
