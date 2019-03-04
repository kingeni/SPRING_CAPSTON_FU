-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 04, 2019 at 10:54 AM
-- Server version: 10.3.11-MariaDB
-- PHP Version: 7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vwms`
--

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `status`) VALUES
(1, 'Administrator', 2),
(2, 'User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE `station` (
  `id` varchar(300) NOT NULL,
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `address` varchar(1000) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`id`, `name`, `phone_number`, `address`, `status`) VALUES
('TRAMCAN_01', 'Trạm cân 1', '0905824851', 'Thủ Đức, Việt Nam', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` varchar(300) NOT NULL,
  `vehicle_weight` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `img_url` varchar(1000) NOT NULL,
  `vehicle_id` varchar(300) NOT NULL,
  `station_id` varchar(300) NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `vehicle_weight`, `unit_id`, `created_at`, `img_url`, `vehicle_id`, `station_id`, `is_read`, `status`) VALUES
('T02262019_1', 33, 1, '2019-02-26 22:35:45', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 1, 1),
('T02262019_69', 33, 1, '2019-03-01 14:19:58', 'data/transaction/T02262019_69.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T2312', 12, 1, '2019-03-03 14:15:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T3212', 53, 1, '2019-03-01 18:00:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T3421', 66, 1, '2019-03-01 14:00:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T4235', 65, 1, '2019-03-02 14:00:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T5432', 52, 1, '2019-03-02 18:00:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T6743', 66, 1, '2019-03-02 10:00:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T7891', 40, 1, '2019-02-28 14:00:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T7896', 44, 1, '2019-02-28 18:00:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T9192', 30, 1, '2019-02-28 10:00:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1),
('T9908', 55, 1, '2019-03-01 10:00:00', 'data/transaction/T02262019_1.jpg', '123123311233', 'TRAMCAN_01', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `name`, `status`) VALUES
(1, 'tấn', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(10000) NOT NULL,
  `email` varchar(300) NOT NULL,
  `auth_key` varchar(1000) NOT NULL,
  `access_token` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password_hash`, `email`, `auth_key`, `access_token`, `status`, `role_id`) VALUES
(2, 'huyta', '$2y$13$X7z0lYumBIBLZIDuzyJsYusskdp3adqW3T6JIqO0XUn73uWcs4mWe', 'tahuy08@outlook.com', '456456.a', 'qwe', 2, 2),
(10, 'QWEQWEQWE', '$2y$13$2WKKI4Vqfp6oc5QgYQuL4.fiiXUJtrwnNPMvSJgas9alXa6U/zdja', 'ASDASDASD@gmail.com', '8KQcMRK2LKM3Fs1V_8GSG9R_jRzb4VQ0', 'dZ_-Pw4fcGt3VYvDwYY8hY83Bt1jqHOnWl44JiRd', 2, 2),
(11, 'admin', '$2y$13$WgFpo4RFmhByxGaWomac4O8SbGhNzt.SDLBsOH0w1QuZnKphnWI.2', 'admin@gmail.com', '3G5pE_fxJ0ImvHV3SQaElUsEvz7bsNJ9', '8pzVR6ZiPoqFxEXjqNti70GfUENL0sYEHUPbeRWe', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(300) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `last_name` varchar(300) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `identity_number` double DEFAULT NULL,
  `gender` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `phone_number` varchar(50) NOT NULL,
  `img_url` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_id`, `first_name`, `last_name`, `date_of_birth`, `identity_number`, `gender`, `phone_number`, `img_url`) VALUES
(2, 'Nex', 'Abc', '1996-01-02', 123, 'Male', '0901234567', 'data/user_profile/2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` varchar(300) NOT NULL,
  `license_plates` varchar(100) NOT NULL,
  `name` varchar(300) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `expiration_date` date NOT NULL,
  `vehicle_weight_id` varchar(300) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `license_plates`, `name`, `expiration_date`, `vehicle_weight_id`, `user_id`) VALUES
('123123311233', '31Q-12312', 'Xe KIA', '2020-01-01', 'XETAI_30TAN', 2),
('23123123123123123', '51A-0123', 'Xe Huyndai', '2020-01-01', 'XETAI_60TAN', 2),
('AASASASASA', '41Q-12312', 'Xe Auto', '2019-03-02', 'XETAI_30TAN', 10);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_img`
--

CREATE TABLE `vehicle_img` (
  `id` int(11) NOT NULL,
  `img_url` varchar(1000) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `vehicle_id` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_img`
--

INSERT INTO `vehicle_img` (`id`, `img_url`, `created_at`, `vehicle_id`) VALUES
(29, 'data/vehicle_img/AASASASASA_0.jpg', '0000-00-00 00:00:00', 'AASASASASA'),
(30, 'data/vehicle_img/123123311233_0.jpg', '0000-00-00 00:00:00', '123123311233'),
(31, 'data/vehicle_img/123123311233_1.jpg', '0000-00-00 00:00:00', '123123311233'),
(32, 'data/vehicle_img/123123311233_2.jpg', '0000-00-00 00:00:00', '123123311233'),
(33, 'data/vehicle_img/123123311233_3.jpg', '0000-00-00 00:00:00', '123123311233');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_weight`
--

CREATE TABLE `vehicle_weight` (
  `id` varchar(300) NOT NULL,
  `vehicle_weight` double NOT NULL,
  `unit_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_weight`
--

INSERT INTO `vehicle_weight` (`id`, `vehicle_weight`, `unit_id`, `status`) VALUES
('XETAI_30TAN', 30, 1, 2),
('XETAI_60TAN', 60, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `identity_number` (`identity_number`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `license_plates` (`license_plates`);

--
-- Indexes for table `vehicle_img`
--
ALTER TABLE `vehicle_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_weight`
--
ALTER TABLE `vehicle_weight`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vehicle_img`
--
ALTER TABLE `vehicle_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
