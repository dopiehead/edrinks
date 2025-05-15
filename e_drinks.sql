-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 26, 2025 at 08:11 PM
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
-- Database: `e_drinks`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `items_per_id` varchar(255) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `seller_type` varchar(255) NOT NULL,
  `noofItem` int(11) NOT NULL,
  `buyer` int(11) NOT NULL,
  `payment_status` tinyint(11) NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `itemId`, `items_per_id`, `seller_id`, `seller_type`, `noofItem`, `buyer`, `payment_status`, `date_added`) VALUES
(1, 1, '', 1, '', 2, 1, 0, '2025-1-04'),
(2, 2, '', 1, '', 2, 1, 0, '2025-01-08');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(11) NOT NULL,
  `tracking_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  `noofitem` int(11) NOT NULL,
  `buyer` int(11) NOT NULL,
  `seller` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `shipping_address` text NOT NULL,
  `lga` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pin_code` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `terms` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `id` int(11) NOT NULL,
  `mykey` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `mykey`) VALUES
(1, 'pk_test_7580449c6abedcd79dae9c1c08ff9058c6618351');

-- --------------------------------------------------------

--
-- Table structure for table `member_message`
--

CREATE TABLE `member_message` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `compose` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `compose` text NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `has_read` tinyint(11) NOT NULL,
  `is_sender_deleted` tinyint(11) NOT NULL,
  `is_receiver_deleted` tinyint(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mykeys`
--

CREATE TABLE `mykeys` (
  `id` int(11) NOT NULL,
  `mykey` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `picx`
--

CREATE TABLE `picx` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `pictures` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `picx`
--

INSERT INTO `picx` (`id`, `sid`, `pictures`) VALUES
(1, 1, 'uploads/more/showroom1.png,uploads/more/showroom2.png,uploads/more/showroom3.png,uploads/more/showroom4.png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `poster_id` int(11) NOT NULL,
  `poster_type` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_details` text NOT NULL,
  `product_category` varchar(255) NOT NULL,
  `product_location` varchar(11) NOT NULL,
  `product_address` varchar(255) NOT NULL,
  `product_color` varchar(255) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `gift_picks` tinyint(11) NOT NULL,
  `sold` tinyint(11) NOT NULL,
  `product_views` int(11) NOT NULL,
  `product_likes` int(11) NOT NULL,
  `product_rating` int(11) NOT NULL,
  `product_discount` int(11) NOT NULL,
  `featured_product` tinyint(11) NOT NULL,
  `product_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `poster_id`, `poster_type`, `product_name`, `product_price`, `product_image`, `product_details`, `product_category`, `product_location`, `product_address`, `product_color`, `quantity_sold`, `product_quantity`, `gift_picks`, `sold`, `product_views`, `product_likes`, `product_rating`, `product_discount`, `featured_product`, `product_date`) VALUES
(1, 4, 'manufacturer', '7up', '500', 'assets/images/products/7up.png', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta blanditiis unde, ut laudantium placeat beatae ratione veniam nihil dolore repudiandae accusamus error assumenda odit aperiam quis doloribus cumque laborum minima.', 'alcoholic', 'lagos', 'ikeja gra', '', 0, 10, 0, 0, 0, 0, 0, 10, 0, '2025-1-10 11:15AM'),
(2, 1, 'wholesaler', 'coke', '700', 'assets/images/products/coke.png', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta blanditiis unde, ut laudantium placeat beatae ratione veniam nihil dolore repudiandae accusamus error assumenda odit aperiam quis doloribus cumque laborum minima.', 'alcoholic', 'lagos', 'ikeja gra', '', 0, 40, 0, 0, 9, 0, 0, 0, 0, '2025-1-10 11:15AM'),
(3, 1, 'importer', 'energy drink', '500', 'assets/images/products/energy-drink.png', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta blanditiis unde, ut laudantium placeat beatae ratione veniam nihil dolore repudiandae accusamus error assumenda odit aperiam quis doloribus cumque laborum minima.', 'non-alcoholic', 'lagos', 'ikeja gra', '', 0, 12, 0, 0, 10, 0, 0, 0, 0, '2025-1-10 11:15AM'),
(4, 1, 'wholesaler', 'lemon drink', '1000', 'assets/images/products/lemon.png', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta blanditiis unde, ut laudantium placeat beatae ratione veniam nihil dolore repudiandae accusamus error assumenda odit aperiam quis doloribus cumque laborum minima.', 'alcoholic', 'lagos', 'ikeja gra', '', 0, 3, 0, 0, 3, 0, 0, 5, 0, '2025-1-10 11:15AM'),
(5, 1, 'wholesaler', 'monster', '400', 'assets/images/products/pepsi.png', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta blanditiis unde, ut laudantium placeat beatae ratione veniam nihil dolore repudiandae accusamus error assumenda odit aperiam quis doloribus cumque laborum minima.', 'non-alcoholic', 'lagos', 'ikeja gra', '', 0, 10, 0, 0, 5, 0, 0, 0, 0, '2025-1-10 11:15AM'),
(6, 2, 'importer', 'pepsi', '550', 'assets/images/products/pepsi.png', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta blanditiis unde, ut laudantium placeat beatae ratione veniam nihil dolore repudiandae accusamus error assumenda odit aperiam quis doloribus cumque laborum minima.', 'alcoholic', 'lagos', 'ikeja gra', '', 0, 13, 0, 0, 8, 0, 0, 10, 0, '2025-1-10 11:15AM'),
(7, 2, 'importer', 'soda', '800', 'assets/images/products/soda.png', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta blanditiis unde, ut laudantium placeat beatae ratione veniam nihil dolore repudiandae accusamus error assumenda odit aperiam quis doloribus cumque laborum minima.', 'non-alcoholic', 'lagos', 'ikeja gra', '', 0, 15, 0, 0, 9, 0, 0, 0, 0, '2025-1-10 11:15AM'),
(8, 3, 'distributor', 'vitamin water', '600', 'assets/images/products/vitamin-water.png', ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta blanditiis unde, ut laudantium placeat beatae ratione veniam nihil dolore repudiandae accusamus error assumenda odit aperiam quis doloribus cumque laborum minima.', 'alcoholic', 'lagos', 'ikeja gra', '', 0, 8, 0, 0, 4, 0, 0, 20, 0, '2025-1-10 11:15AM');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `pending` tinyint(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `sender_id`, `message`, `recipient_id`, `pending`, `date`) VALUES
(1, 1, 'notification from admin', 1, 0, 'jan 5, 2020');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_location` varchar(255) NOT NULL,
  `lga` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_rating` varchar(255) NOT NULL,
  `verified` tinyint(11) NOT NULL,
  `vkey` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_token_expiry` varchar(255) NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_image`, `user_phone`, `user_location`, `lga`, `user_address`, `user_rating`, `verified`, `vkey`, `reset_token`, `reset_token_expiry`, `date_added`) VALUES
(1, 'Neeyo', 'ngnimitech@gmail.com', '$2y$10$HGiVDPgxxDNG.l49vYKXBe8ZLHEbVC.lk0VTmsn3ey9DQt42JMfcW', 'Wholesaler', 'uploads/neeyo.png', '09074456453', 'Lagos', '', 'iyalla street, Ikeja Alausa', '0', 0, 'a5ec3ee7fd2cab423930471f709ed1a5', '9489a247b2fff01dde8dd4e915d4f5397ac9d1ec8ebd76aa98daad04da658242', '2025-01-31 20:30:44', '2025-01-31 16:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `verify_seller`
--

CREATE TABLE `verify_seller` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `valid_id` int(11) NOT NULL,
  `verified` tinyint(11) NOT NULL,
  `date` varchar(255) NOT NULL
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
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_message`
--
ALTER TABLE `member_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mykeys`
--
ALTER TABLE `mykeys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picx`
--
ALTER TABLE `picx`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify_seller`
--
ALTER TABLE `verify_seller`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_message`
--
ALTER TABLE `member_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mykeys`
--
ALTER TABLE `mykeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `picx`
--
ALTER TABLE `picx`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `verify_seller`
--
ALTER TABLE `verify_seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
