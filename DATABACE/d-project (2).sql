-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 01 أكتوبر 2023 الساعة 21:11
-- إصدار الخادم: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `d-project`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(6) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(3, 'admin', '$2y$10$vXzaZI81q2Sgp7czhgE.u.n2XwWJK640NDrg.q3Et2gGc1DJ8A7AK');

-- --------------------------------------------------------

--
-- بنية الجدول `stores`
--

CREATE TABLE `stores` (
  `store_id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `stores`
--

INSERT INTO `stores` (`store_id`, `name`, `email`, `password`, `verified`) VALUES
(5, 'Xstore', 'x.store@gmail.com', '$2y$10$2UAH7hK99215.1kz2bJu5O7zdlprLxDl/7/VYDw6fUSTNn0.3qJ9y', 0),
(6, 'Astoer', 'a.stroe@store.com', '$2y$10$xw8DTTS0xsjfBelqJgDcIu/sd9S7wBE.TENhGhtBWp2BSyUKnQo6C', 0),
(7, 'xs', 'xs@xs.com', '$2y$10$mPb37NLqsmRyE5tZ5L6PUuo80qYdTYNz8auMmJHEykQO6ZIvacikq', 0),
(8, 'NewStore', 'new.store@example.com', 'password_hash_here', 0);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `user_id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `phone`) VALUES
(6, '  ABDUALZIZ ADEL ALHARBI ', '$2y$10$8x0Ky3xKlZP4ntzaMPX6yu4uYAEwvCukiaj2EGGEzfddW7qf5t0wm', 531630340),
(7, 'ziyad-aa ', '$2y$10$4FEWqSU5bf/fnFSWUf/4puqSvVqjzb.mcFQLDZQKPvcmk3cozLHQi', 542306005),
(8, 'khalid', '$2y$10$mIY.OYRmyuJ/Hvfcnaeb6ORLKApFfU0qC.rVjpJIMZdHMgw4VvLky', 567834519),
(9, 'asim-a', '$2y$10$c6g..sG.iOtXHGFb3YxiQOIO0LjaG/n7IFKKkTMmazcirz5QzFXnu', 544230100),
(10, 'zyad', '$2y$10$5MY4133.K2Gswy5XTe5KP.g3duSk.UwD37Fg.N6HCFrJQKHGuoH0i', 554141138);

-- --------------------------------------------------------

--
-- بنية الجدول `warranty`
--

CREATE TABLE `warranty` (
  `warranty_id` int(11) UNSIGNED NOT NULL,
  `product` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `store_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `warranty`
--

INSERT INTO `warranty` (`warranty_id`, `product`, `start_date`, `expiry_date`, `user_id`, `store_id`) VALUES
(3, 'Product A', '2023-01-01', '2024-01-01', 4, 2),
(4, 'iphone 12', '2023-05-27', '2028-05-27', 6, 5),
(5, 'ipad 14', '2023-05-28', '2028-05-28', 7, 6),
(6, 'iphone14', '2023-05-30', '2025-05-30', 7, 5),
(7, 'ipad air 13', '2021-05-30', '2023-05-30', 6, 5),
(8, 'LG TV 44', '2023-05-30', '2027-05-30', 6, 6),
(9, 'ipad air 14', '2023-05-30', '2027-05-30', 9, 5),
(10, 'ipad 13 pro', '2023-05-30', '2027-05-30', 6, 5),
(11, 'TV LG', '2023-05-30', '2027-05-30', 7, 5),
(12, 'iphone', '2023-06-12', '2025-05-12', 10, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `warranty`
--
ALTER TABLE `warranty`
  ADD PRIMARY KEY (`warranty_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `store_id` (`store_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `store_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `warranty`
--
ALTER TABLE `warranty`
  MODIFY `warranty_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
