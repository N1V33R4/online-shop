-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2022 at 02:49 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(2, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(3, 'pokka', '7c4a8d09ca3762af61e59520943dc26494f8941b');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(9, 1, 7, 'Mouse', 10, 21, 'mouse-1.webp'),
(10, 1, 5, 'Laptop', 1250, 3, 'laptop-1.webp'),
(11, 1, 8, 'Delicate Washing Machine', 269, 1, 'washing machine-1.webp'),
(12, 1, 9, 'Burner Phone', 199, 2, 'smartphone-1.webp'),
(14, 2, 4, 'Watch', 59, 15, 'watch-1.webp');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`) VALUES
(2, 'Fridge', 'icon-5.png'),
(3, 'Watch', 'icon-8.png'),
(4, 'Phone', 'icon-7.png'),
(5, 'Washing Machine', 'icon-6.png'),
(6, 'Laptop', 'icon-1.png'),
(7, 'TV', 'icon-2.png'),
(8, 'Camera', 'icon-3.png'),
(9, 'Mouse', 'icon-4.png'),
(10, 'Gaming', 'game.png');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0,
  `sent_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`, `resolved`, `sent_on`) VALUES
(1, 1, 'big Chungus', 'chungus@big.com', '1122334499', 'You got my order wrong, amigo', 1, '2022-09-11 10:24:44'),
(3, 0, 'Bobby', 'bob@builder.com', '012853129', 'Hi, I am bob the builder. May I interest you in a proposition?', 1, '2022-09-12 15:55:22');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` float NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 1, 'pong', '011682055', 'neavireakpong.hou@gmail.com', 'visa', 'NR5, #820B, Phnom Penh', '(1) - Smartphone, (2) - TV', 555, '2022-09-01 00:00:00', 'completed'),
(3, 1, 'John F. Kennedy', '11882910', 'john@ken.org', 'visa', '125 W, Rosecrans Ave, Manhattan Beach, California(CA), United States - 90266', 'Smart Fridge (3) - Camera (3) - 32\' TV (5) - ', 7517, '2022-09-13 14:33:28', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` float NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`, `category_id`) VALUES
(3, 'Smart Fridge', 'Be careful not to get hacked and be part of a DDOS attack. ', 1569, 'fridge-1.webp', 'fridge-2.webp', 'fridge-3.webp', 2),
(4, 'Watch', 'Awesome watch for cheap. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam impedit consectetur quasi ducimus? Corporis saepe dolores harum! ', 59, 'watch-1.webp', 'watch-2.webp', 'watch-3.webp', 3),
(5, 'Laptop', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem magnam quas, sequi ipsum illum illo.', 1250, 'laptop-1.webp', 'laptop-2.webp', 'laptop-3.webp', 6),
(6, '32&#39; Smart TV', 'Super cheap, super nice. ', 229, 'tv-01.webp', 'tv-02.webp', 'tv-03.webp', 7),
(7, 'Mouse', 'Best affordable mouse. Durable, can use for years. ', 10, 'mouse-1.webp', 'mouse-2.webp', 'mouse-3.webp', 9),
(8, 'Delicate Washing Machine', 'Can wash your clothes without damaging them. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi, ad?', 269, 'washing machine-1.webp', 'washing machine-2.webp', 'washing machine-3.webp', 5),
(9, 'Burner Phone', 'Not great but affordable and reliable device. ', 199, 'smartphone-1.webp', 'smartphone-2.webp', 'smartphone-3.webp', 4),
(10, 'Nintendo Switch – OLED Model w/ White Joy-Con', '7-inch OLED screen - Enjoy vivid colors and crisp contrast with a screen that makes colors pop\r\nWired LAN port - Use the dock’s LAN port when playing in TV mode for a wired internet connection\r\n64 GB internal storage - Save games to your system with 64 GB of internal storage\r\nEnhanced audio – Enjoy enhanced sound from the system’s onboard speakers when playing in Handheld and Tabletop modes.\r\nWide adjustable stand – Freely angle the system’s wide, adjustable stand for comfortable viewing', 199, 'switch1.jpg', 'swtich2.jpg', '3.jpg', 10),
(11, 'AMD Ryzen 9 5900X 12-core, 24-Thread', 'The world&#39;s best gaming desktop processor, with 12 cores and 24 processing threads\r\nCan deliver elite 100-plus FPS performance in the world&#39;s most popular games\r\nCooler not included, high-performance cooler recommended. Max Temperature- 90°C\r\n4.8 GHz Max Boost, unlocked for overclocking, 70 MB of cache, DDR-3200 support\r\nFor the advanced Socket AM4 platform, can support PCIe 4.0 on X570 and B550 motherboards', 339, 'ryzen1.jpg', 'ryzen2.jpg', 'ryzen3.jpg', 10),
(13, 'Sony PlayStation 4 Pro', 'PlayStation 4 Pro - the super charged PS4 - take play to the next level with PS4 Pro: See every detail explode into life with 4K gaming and entertainment, experience faster, smoother frame rates and more powerful gaming performance and enjoy richer, more vibrant colours with HDR technology\r\n4K gaming and entertainment - games and movies shine with amazing 4K clarity\r\ngraphics become sharper and more realistic, skin tones become warmer and more lifelike, while textures and environments burst into', 529, 'ps4-1.jpg', 'ps4-2.jpg', 'ps4-3.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'pong', 'neavireakpong.hou@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(2, 'boba', 'bobo@builder.com.org', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
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
-- Indexes for table `users`
--
ALTER TABLE `users`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
