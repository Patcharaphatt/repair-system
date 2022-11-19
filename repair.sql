-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2022 at 11:22 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `repair-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `repair`
--

CREATE TABLE `repair` (
  `Id` int(11) NOT NULL,
  `ownerRoom_Id` int(2) NOT NULL,
  `rp_details` varchar(500) NOT NULL,
  `rp_img` varchar(255) NOT NULL,
  `ownerRoom_notify_date` datetime NOT NULL,
  `rp_status` int(2) NOT NULL,
  `inventory_Id` int(11) NOT NULL,
  `computer_Id` int(11) NOT NULL,
  `admin_Id` int(11) DEFAULT NULL,
  `technician_Id` int(11) DEFAULT NULL,
  `admin_operates_date` datetime DEFAULT NULL,
  `technician_operates_date` datetime DEFAULT NULL,
  `description_job` varchar(500) DEFAULT NULL,
  `technicial_rp_img` varchar(50) DEFAULT NULL,
  `rp_date_success` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `repair`
--

INSERT INTO `repair` (`Id`, `ownerRoom_Id`, `rp_details`, `rp_img`, `ownerRoom_notify_date`, `rp_status`, `inventory_Id`, `computer_Id`, `admin_Id`, `technician_Id`, `admin_operates_date`, `technician_operates_date`, `description_job`, `technicial_rp_img`, `rp_date_success`) VALUES
(5, 3, '123', '/repair-system/repair/imgs/8006381ac59b44924df51c037be31586.jpg', '2022-11-12 15:25:15', 1, 53, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 3, 'คอมพิวเตอร์เสียขึ้นหน้าจอสีฟ้า รบกวนช่วยเช็คให้หน่อยครับ ขอบคุณครับ', '/repair-system/repair/imgs/be853f613fcf9ca60863ca2d60ba7ed0.jpg', '2022-11-12 16:48:12', 1, 53, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 3, '132456', '/repair-system/repair/imgs/2f9ff956c5fab0e589cee9f4c12df849.png', '2022-11-12 16:54:11', 1, 53, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 3, '789465', '/repair-system/repair/imgs/e7f1ef89c3bb04c9d25a60aa455dc8cd.jpg', '2022-11-19 10:41:23', 1, 103, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 3, '789456132', '../repair-system/repair/imgs/ba7679419f8fde403c60998125969796.jpg', '2022-11-19 10:44:11', 1, 53, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 3, '789456', '../repair/imgs/d8f7732ea50275d70dfce856de67f12e.jpg', '2022-11-19 10:44:46', 1, 53, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 3, '7894564123', '/repair-system/repair/imgs/3507f6bdd4afdfd51edbdc51ea61585e.jpg', '2022-11-19 10:48:16', 1, 103, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 3, 'คอมเสีย รบกวนหน่อยครับ ขอบคุณครับ', '/repair-system/repair/imgs/fd5f0f07789971847a44a564b1d2f7eb.jpg', '2022-11-19 10:52:35', 1, 13, 51, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `repair`
--
ALTER TABLE `repair`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `repair`
--
ALTER TABLE `repair`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
