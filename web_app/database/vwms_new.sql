-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 09, 2019 at 09:23 AM
-- Server version: 10.3.13-MariaDB
-- PHP Version: 7.3.1

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
  `vehicle_weight` float NOT NULL,
  `unit` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
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

INSERT INTO `transaction` (`id`, `vehicle_weight`, `unit`, `created_at`, `img_url`, `vehicle_id`, `station_id`, `is_read`, `status`) VALUES
('007', 100, 'tấn', '2019-03-17 12:27:26', 'data/transaction/007.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('098', 100, 'tấn', '2019-03-13 23:13:02', 'data/transaction/098.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('118', 100, 'tấn', '2019-03-15 14:25:01', 'data/transaction/118.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('123', 33, 'tấn', '2019-03-13 22:53:38', 'data/transaction/123.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('123123123', 12, 'tấn', '2019-03-30 09:54:00', 'a', '0987654321', 'TRAMCAN_01', 0, 1),
('12312312312321321321', 12, 'tấn', '2019-03-30 21:55:00', 'a', '0987654321', 'TRAMCAN_01', 0, 1),
('331', 100, 'tấn', '2019-03-13 23:38:35', 'data/transaction/331.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('3453456784567', 33, 'tấn', '2019-03-13 22:52:17', 'data/transaction/3453456784567.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('456', 33, 'tấn', '2019-03-13 22:54:44', 'data/transaction/456.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('531', 100, 'tấn', '2019-03-13 23:14:50', 'data/transaction/531.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('678', 100, 'tấn', '2019-03-13 22:55:59', 'data/transaction/678.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('69', 100, 'tấn', '2019-03-13 23:16:46', 'data/transaction/69.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('789', 100, 'tấn', '2019-03-17 12:34:17', 'data/transaction/789.jpg', '0987654321', 'TRAMCAN_01', 0, 2),
('801', 100, 'tấn', '2019-03-13 23:23:17', 'data/transaction/801.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('876', 100, 'tấn', '2019-03-13 23:10:17', 'data/transaction/876.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('911', 100, 'tấn', '2019-03-14 22:32:34', 'data/transaction/911.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('990', 100, 'tấn', '2019-03-13 23:26:10', 'data/transaction/990.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('bcvbc', 21, 'tấn', '2019-04-04 06:30:00', 'a', '0987654321', 'TRAMCAN_01', 0, 4),
('dasdaszcxczxc', 12, 'tấn', '2019-04-11 00:00:00', 'a', '0987654321', 'TRAMCAN_01', 0, 1),
('hjk', 33, 'tấn', '2019-03-20 15:43:27', 'data/transaction/hjk.jpg', '0987654321', 'TRAMCAN_01', 0, 1),
('n bvmnv', 23, 'tấn', '2019-04-04 06:30:00', 'a', '0987654321', 'TRAMCAN_01', 0, 4),
('T02262019_1', 66, 'tấn', '2019-03-05 23:05:31', 'data/transaction/T02262019_1.jpg', '0987654321', 'TRAMCAN_01', 0, 2),
('T02262019_1123', 33, 'tấn', '2019-03-06 09:45:51', 'data/transaction/T02262019_1123.jpg', '0987654321', 'TRAMCAN_01', 0, 1);

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
(1, 'admin', '$2y$13$36oHiMFYsFM1qJQCxqJTGuBzLzB83E40DwuvSbF/b4BgCmsUKFd3O', 'admin@gmail.com', '_sdL9qe3wbJJ0UfmeCvSO9HY3aZHZLLe', 'EQoSct-mO2hi1tgWS-AsmBHigjIJylZElFD31g2y', 2, 1),
(2, 'huytd', '$2y$13$EH2dSjZu8BXnrRVBmlpFZ.3YoDJNFJshArsGAvtAe9roKoDr.ZaIC', 'tahuy08@outlook.com', 'YaDcrdDO6sB6HCN7mxEh4CfW8MKO3dg2', 'RbRtDM6kmDCXOX4C8-DzMYoQ9SSVDhDmSHGcCMcj', 2, 2),
(3, 'adad', '$2y$13$09q1McSNeRcPdmJYvOhaJ.qS6sYSuJSDeqpeMxK00MEVDWydkv0HO', 'ahihi12@gmail.com', 'cnSGcVCTAX04r2bMXqugfo3QQujokHXi', 'a_ul5rJZ9HIuPo8oYQmikWGQfaxgANO6f-kfeSLb', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(300) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `last_name` varchar(300) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(1000) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `gender` varchar(100) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `phone_number` varchar(50) NOT NULL,
  `img_url` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_id`, `first_name`, `last_name`, `date_of_birth`, `address`, `gender`, `phone_number`, `img_url`) VALUES
(2, 'Nex', 'Abc', '1996-01-02', '6969', 'Male', '123123', 'data/user_profile/2.jpg');

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
  `status` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `license_plates`, `name`, `expiration_date`, `vehicle_weight_id`, `status`, `user_id`) VALUES
('0987654321', '51A-9876', 'Xe KIA', '2021-01-01', 'XETAI_60TAN', 2, 2),
('1234567890', '58A-6789', 'Xe Huyndai', '2020-01-01', 'XETAI_30TAN', 1, 2);

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
(33, 'data/vehicle_img/123123311233_3.jpg', '0000-00-00 00:00:00', '123123311233'),
(34, 'data/vehicle_img/1234567890_0.jpg', '0000-00-00 00:00:00', '1234567890'),
(35, 'data/vehicle_img/1234567890_1.jpg', '0000-00-00 00:00:00', '1234567890'),
(36, 'data/vehicle_img/0987654321_0.jpg', '0000-00-00 00:00:00', '0987654321'),
(37, 'data/vehicle_img/0987654321_1.jpg', '0000-00-00 00:00:00', '0987654321');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_weight`
--

CREATE TABLE `vehicle_weight` (
  `id` varchar(300) NOT NULL,
  `vehicle_weight` double NOT NULL,
  `unit` varchar(50) CHARACTER SET utf8 COLLATE utf8_vietnamese_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_weight`
--

INSERT INTO `vehicle_weight` (`id`, `vehicle_weight`, `unit`, `status`) VALUES
('XETAI_30TAN', 30, 'tấn', 2),
('XETAI_30TAN1', -0, 'tấn', 3),
('XETAI_30TAN112312', -0, 'tấn', 3),
('XETAI_60TAN', 60, 'tấn', 2);

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`user_id`);

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
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicle_img`
--
ALTER TABLE `vehicle_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
