-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2022 at 12:10 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `images-gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `imagename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `user_id`, `imagename`) VALUES
(1, 11, '14182815071648840960.jpeg'),
(7, 11, '19400222271648846970.jpeg'),
(13, 11, '12301254381648849013.jpeg'),
(14, 11, '12103790341648849025.jpeg'),
(15, 13, '21429225581648849273.jpeg'),
(16, 13, '20909936661648849434.jpeg'),
(17, 13, '11847012751648849448.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `gender`) VALUES
(1, 'adri', 'adrian@me.com', '$2y$10$fAJ6DChJQ5UIqgTqdNA8m.eGH6fJVXEyh8EQBtbDC5EFV37VFlNRa1', 'male'),
(2, 'Remas', 'remas@mailinator.com', '$2y$10$hDdgufkMrrSBgD3Kj4to1.dyLSJdvSeb3rpobXpvAzeZ0q1zxNQbm', 'male'),
(3, 'Angela Weiss', 'mokogotytu@mailinator.com', '$2y$10$7BWAMGSyQbwy8CYX2c6F/uXIbV304.lyp3CvcJKtAuJ2TqERNrYIO', 'male'),
(4, 'Maxine Pugh', 'hekuk@mailinator.com', '$2y$10$EXxF4mElUzm1JdY6ykDky.Qy2e5HzYfMTAuORoIl16lpwQDaoOYHe', 'male'),
(5, 'Quentin Richardson', 'panonewax@mailinator.com', '$2y$10$e/SK3GZdXX90sR1R12fxZeOGiCEHbzGgEuCqz.wpoHfNlxhfA1qRe', 'female'),
(6, 'Caldwell Ross', 'sonujireb@mailinator.com', '$2y$10$nnbfuPC7pE6yi5R8u/tN0uh5rBxxo6cr0fF/d1X/94kU3XIkA5Aju', 'female'),
(7, 'Cullen Flores', 'jijofuh@mailinator.com', '$2y$10$c0.qjS/fUBhRJzGFtCbWWuB02SZOigBrA5XwreNYRnWPchV1UFQ8a', 'female'),
(8, 'Dean Carney', 'baxeha@mailinator.com', '$2y$10$qsXjI8TjdNZ4CMS/bydM4.ue2mU8SpJSqM8CSbmOoNKM.Yc5wQd.m', 'female'),
(9, 'Norman Fulton', 'bejere@mailinator.com', '$2y$10$rRP//4Q/QLutur5SC10iJOXxVKu/x3G.M7G3orY4FoVds09lSKGwS', 'female'),
(10, 'Zelda Bruce', 'hykypeduki@mailinator.com', '$2y$10$GK7RP6RyP./1SG.gA75Yx.6bVoXcppl8ALlVQidcZoSVZB5c9j.BG', 'male'),
(11, 'Ahmed Ghonaime', 'ghonaime@me.com', '$2y$10$da9w6ZPR0lO1nO3/Rrm/f.OBssDr/EKaYhfvutR7gEAMT7rooaIJ2', 'male'),
(12, 'Olympia Larsen', 'vivepogyx@mailinator.com', '$2y$10$GtnSWSs1AxhsI7GCiJI33u0NGV7alZUuGPq5TNJwS//4QQmEWrkge', 'male'),
(13, 'ana', 'ana@email.com', '$2y$10$XX9OSWtqIwTcPxeZnJK.mONsaiNtpRxEfob8kpdT9aju32HxEXOlq', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imagename` (`imagename`),
  ADD KEY `user_image_relation` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `user_image_relation` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
