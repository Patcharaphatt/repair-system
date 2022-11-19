-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2022 at 11:24 AM
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
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `Id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(2) NOT NULL,
  `roleId` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`Id`, `username`, `password`, `fullname`, `mobile`, `email`, `created_at`, `status`, `roleId`) VALUES
(1, 'patcharaphat.pit@sbac.ac.th', 'e10adc3949ba59abbe56e057f20f883e', 'patcharaphat.pit@sbac.ac.th', '000000000', 'patcharaphat.pit@sbac.ac.th', '2022-11-12 11:10:50', 1, 1),
(3, 'Araya', 'e10adc3949ba59abbe56e057f20f883e', 'คุณ อรญา สิทธิ์พิทักษ์', '0000000000', 'test@sbac.ac.th', '2022-11-12 13:07:43', 1, 3),
(5, 'ธวัช', 'e10adc3949ba59abbe56e057f20f883e', 'ธวัช พิทักษ์พูลศิลป์', '0902725819', 'Tawat@sbac.ac.th', '2022-11-19 08:47:49', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `Id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`Id`, `title`) VALUES
(1, 'Acer');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Id`, `title`) VALUES
(1, 'คอมพิวเตอร์');

-- --------------------------------------------------------

--
-- Table structure for table `class_room_owner`
--

CREATE TABLE `class_room_owner` (
  `Id` int(11) NOT NULL,
  `account_Id` int(2) NOT NULL,
  `department_Id` int(2) NOT NULL,
  `room_Id` int(2) NOT NULL,
  `status_comfirm_inventory` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class_room_owner`
--

INSERT INTO `class_room_owner` (`Id`, `account_Id`, `department_Id`, `room_Id`, `status_comfirm_inventory`) VALUES
(5, 3, 1, 2, 0),
(6, 5, 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `computer`
--

CREATE TABLE `computer` (
  `Id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `roomId` int(11) NOT NULL,
  `mainComCode` int(11) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `computer`
--

INSERT INTO `computer` (`Id`, `code`, `roomId`, `mainComCode`, `status`) VALUES
(1, '1101-001', 1, 0, 1),
(2, '1101-002', 1, 0, 1),
(3, '1101-003', 1, 0, 1),
(4, '1101-004', 1, 0, 1),
(5, '1101-005', 1, 0, 1),
(6, '1101-006', 1, 0, 1),
(7, '1101-007', 1, 0, 1),
(8, '1101-008', 1, 0, 1),
(9, '1101-009', 1, 0, 1),
(10, '1101-010', 1, 0, 1),
(11, '1101-011', 1, 0, 1),
(12, '1101-012', 1, 0, 1),
(13, '1101-013', 1, 0, 1),
(14, '1101-014', 1, 0, 1),
(15, '1101-015', 1, 0, 1),
(16, '1101-016', 1, 0, 1),
(17, '1101-017', 1, 0, 1),
(18, '1101-018', 1, 0, 1),
(19, '1101-019', 1, 0, 1),
(20, '1101-020', 1, 0, 1),
(21, '1101-021', 1, 0, 1),
(22, '1101-022', 1, 0, 1),
(23, '1101-023', 1, 0, 1),
(24, '1101-024', 1, 0, 1),
(25, '1101-025', 1, 0, 1),
(26, '1101-026', 1, 0, 1),
(27, '1101-027', 1, 0, 1),
(28, '1101-028', 1, 0, 1),
(29, '1101-029', 1, 0, 1),
(30, '1101-030', 1, 0, 1),
(31, '1101-031', 1, 0, 1),
(32, '1101-032', 1, 0, 1),
(33, '1101-033', 1, 0, 1),
(34, '1101-034', 1, 0, 1),
(35, '1101-035', 1, 0, 1),
(36, '1101-036', 1, 0, 1),
(37, '1101-037', 1, 0, 1),
(38, '1101-038', 1, 0, 1),
(39, '1101-039', 1, 0, 1),
(40, '1101-040', 1, 0, 1),
(41, '1101-041', 1, 0, 1),
(42, '1101-042', 1, 0, 1),
(43, '1101-043', 1, 0, 1),
(44, '1101-044', 1, 0, 1),
(45, '1101-045', 1, 0, 1),
(46, '1101-046', 1, 0, 1),
(47, '1101-047', 1, 0, 1),
(48, '1101-048', 1, 0, 1),
(49, '1101-049', 1, 0, 1),
(50, '1101-050', 1, 0, 1),
(51, '1102-001', 2, 0, 1),
(52, '1102-002', 2, 0, 1),
(53, '1102-003', 2, 0, 1),
(54, '1102-004', 2, 0, 1),
(55, '1102-005', 2, 0, 1),
(56, '1102-006', 2, 0, 1),
(57, '1102-007', 2, 0, 1),
(58, '1102-008', 2, 0, 1),
(59, '1102-009', 2, 0, 1),
(60, '1102-010', 2, 0, 1),
(61, '1102-011', 2, 0, 1),
(62, '1102-012', 2, 0, 1),
(63, '1102-013', 2, 0, 1),
(64, '1102-014', 2, 0, 1),
(65, '1102-015', 2, 0, 1),
(66, '1102-016', 2, 0, 1),
(67, '1102-017', 2, 0, 1),
(68, '1102-018', 2, 0, 1),
(69, '1102-019', 2, 0, 1),
(70, '1102-020', 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `conect_inventory_computer`
--

CREATE TABLE `conect_inventory_computer` (
  `Id` int(11) NOT NULL,
  `computerId` int(5) NOT NULL,
  `inventoryId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conect_inventory_computer`
--

INSERT INTO `conect_inventory_computer` (`Id`, `computerId`, `inventoryId`) VALUES
(1, 1, 101),
(2, 1, 15),
(3, 1, 62),
(4, 2, 102),
(5, 2, 66),
(6, 2, 12),
(7, 51, 103),
(8, 51, 53),
(9, 51, 13);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Id`, `title`) VALUES
(1, 'เทคโนโลยีสารสนเทศ'),
(2, 'การตลาด'),
(3, 'การบัญชี'),
(4, 'ภาษาต่างประเทศ');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `Id` int(11) NOT NULL,
  `serial` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand_Id` int(2) NOT NULL,
  `category_Id` int(2) NOT NULL,
  `type_Id` int(2) NOT NULL,
  `unit_Id` int(2) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`Id`, `serial`, `name`, `brand_Id`, `category_Id`, `type_Id`, `unit_Id`, `status`) VALUES
(1, '256511010001', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(2, '256511010002', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(3, '256511010003', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(4, '256511010004', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(5, '256511010005', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(6, '256511010006', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(7, '256511010007', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(8, '256511010008', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(9, '256511010009', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(10, '256511010010', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(11, '256511010011', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(12, '256511010012', 'จอมอนิเตอร์', 1, 1, 1, 1, 1),
(13, '256511010013', 'จอมอนิเตอร์', 1, 1, 1, 1, 1),
(14, '256511010014', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(15, '256511010015', 'จอมอนิเตอร์', 1, 1, 1, 1, 1),
(16, '256511010016', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(17, '256511010017', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(18, '256511010018', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(19, '256511010019', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(20, '256511010020', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(21, '256511010021', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(22, '256511010022', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(23, '256511010023', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(24, '256511010024', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(25, '256511010025', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(26, '256511010026', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(27, '256511010027', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(28, '256511010028', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(29, '256511010029', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(30, '256511010030', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(31, '256511010031', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(32, '256511010032', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(33, '256511010033', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(34, '256511010034', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(35, '256511010035', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(36, '256511010036', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(37, '256511010037', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(38, '256511010038', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(39, '256511010039', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(40, '256511010040', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(41, '256511010041', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(42, '256511010042', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(43, '256511010043', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(44, '256511010044', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(45, '256511010045', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(46, '256511010046', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(47, '256511010047', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(48, '256511010048', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(49, '256511010049', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(50, '256511010050', 'จอมอนิเตอร์', 1, 1, 1, 1, 0),
(51, '256511020001', 'เมาส์', 1, 1, 1, 1, 0),
(52, '256511020002', 'เมาส์', 1, 1, 1, 1, 0),
(53, '256511020003', 'เมาส์', 1, 1, 1, 1, 1),
(54, '256511020004', 'เมาส์', 1, 1, 1, 1, 0),
(55, '256511020005', 'เมาส์', 1, 1, 1, 1, 0),
(56, '256511020006', 'เมาส์', 1, 1, 1, 1, 0),
(57, '256511020007', 'เมาส์', 1, 1, 1, 1, 0),
(58, '256511020008', 'เมาส์', 1, 1, 1, 1, 0),
(59, '256511020009', 'เมาส์', 1, 1, 1, 1, 0),
(60, '256511020010', 'เมาส์', 1, 1, 1, 1, 0),
(61, '256511020011', 'เมาส์', 1, 1, 1, 1, 0),
(62, '256511020012', 'เมาส์', 1, 1, 1, 1, 1),
(63, '256511020013', 'เมาส์', 1, 1, 1, 1, 0),
(64, '256511020014', 'เมาส์', 1, 1, 1, 1, 0),
(65, '256511020015', 'เมาส์', 1, 1, 1, 1, 0),
(66, '256511020016', 'เมาส์', 1, 1, 1, 1, 1),
(67, '256511020017', 'เมาส์', 1, 1, 1, 1, 0),
(68, '256511020018', 'เมาส์', 1, 1, 1, 1, 0),
(69, '256511020019', 'เมาส์', 1, 1, 1, 1, 0),
(70, '256511020020', 'เมาส์', 1, 1, 1, 1, 0),
(71, '256511020021', 'เมาส์', 1, 1, 1, 1, 0),
(72, '256511020022', 'เมาส์', 1, 1, 1, 1, 0),
(73, '256511020023', 'เมาส์', 1, 1, 1, 1, 0),
(74, '256511020024', 'เมาส์', 1, 1, 1, 1, 0),
(75, '256511020025', 'เมาส์', 1, 1, 1, 1, 0),
(76, '256511020026', 'เมาส์', 1, 1, 1, 1, 0),
(77, '256511020027', 'เมาส์', 1, 1, 1, 1, 0),
(78, '256511020028', 'เมาส์', 1, 1, 1, 1, 0),
(79, '256511020029', 'เมาส์', 1, 1, 1, 1, 0),
(80, '256511020030', 'เมาส์', 1, 1, 1, 1, 0),
(81, '256511020031', 'เมาส์', 1, 1, 1, 1, 0),
(82, '256511020032', 'เมาส์', 1, 1, 1, 1, 0),
(83, '256511020033', 'เมาส์', 1, 1, 1, 1, 0),
(84, '256511020034', 'เมาส์', 1, 1, 1, 1, 0),
(85, '256511020035', 'เมาส์', 1, 1, 1, 1, 0),
(86, '256511020036', 'เมาส์', 1, 1, 1, 1, 0),
(87, '256511020037', 'เมาส์', 1, 1, 1, 1, 0),
(88, '256511020038', 'เมาส์', 1, 1, 1, 1, 0),
(89, '256511020039', 'เมาส์', 1, 1, 1, 1, 0),
(90, '256511020040', 'เมาส์', 1, 1, 1, 1, 0),
(91, '256511020041', 'เมาส์', 1, 1, 1, 1, 0),
(92, '256511020042', 'เมาส์', 1, 1, 1, 1, 0),
(93, '256511020043', 'เมาส์', 1, 1, 1, 1, 0),
(94, '256511020044', 'เมาส์', 1, 1, 1, 1, 0),
(95, '256511020045', 'เมาส์', 1, 1, 1, 1, 0),
(96, '256511020046', 'เมาส์', 1, 1, 1, 1, 0),
(97, '256511020047', 'เมาส์', 1, 1, 1, 1, 0),
(98, '256511020048', 'เมาส์', 1, 1, 1, 1, 0),
(99, '256511020049', 'เมาส์', 1, 1, 1, 1, 0),
(100, '256511020050', 'เมาส์', 1, 1, 1, 1, 0),
(101, '5245-58460001', 'คีย์บอร์ด', 1, 1, 1, 1, 1),
(102, '5245-58460002', 'คีย์บอร์ด', 1, 1, 1, 1, 1),
(103, '5245-58460003', 'คีย์บอร์ด', 1, 1, 1, 1, 1),
(104, '5245-58460004', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(105, '5245-58460005', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(106, '5245-58460006', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(107, '5245-58460007', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(108, '5245-58460008', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(109, '5245-58460009', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(110, '5245-58460010', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(111, '5245-58460011', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(112, '5245-58460012', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(113, '5245-58460013', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(114, '5245-58460014', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(115, '5245-58460015', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(116, '5245-58460016', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(117, '5245-58460017', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(118, '5245-58460018', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(119, '5245-58460019', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(120, '5245-58460020', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(121, '5245-58460021', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(122, '5245-58460022', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(123, '5245-58460023', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(124, '5245-58460024', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(125, '5245-58460025', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(126, '5245-58460026', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(127, '5245-58460027', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(128, '5245-58460028', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(129, '5245-58460029', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(130, '5245-58460030', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(131, '5245-58460031', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(132, '5245-58460032', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(133, '5245-58460033', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(134, '5245-58460034', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(135, '5245-58460035', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(136, '5245-58460036', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(137, '5245-58460037', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(138, '5245-58460038', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(139, '5245-58460039', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(140, '5245-58460040', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(141, '5245-58460041', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(142, '5245-58460042', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(143, '5245-58460043', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(144, '5245-58460044', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(145, '5245-58460045', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(146, '5245-58460046', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(147, '5245-58460047', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(148, '5245-58460048', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(149, '5245-58460049', 'คีย์บอร์ด', 1, 1, 1, 1, 0),
(150, '5245-58460050', 'คีย์บอร์ด', 1, 1, 1, 1, 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `Id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`Id`, `title`) VALUES
(1, 'Admin'),
(2, 'Technician'),
(3, 'ClassroomOwner');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Id` int(11) NOT NULL,
  `build` varchar(50) NOT NULL,
  `floor` varchar(2) NOT NULL,
  `name` varchar(8) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`Id`, `build`, `floor`, `name`, `status`) VALUES
(1, '1', '1', '1101', 1),
(2, '1', '1', '1102', 1),
(3, '1', '1', '1103', 0),
(4, '1', '1', '1104', 0),
(5, '1', '1', '1105', 0),
(6, '1', '1', '1106', 0),
(7, '1', '1', '1107', 0),
(8, '1', '1', '1108', 0),
(9, '1', '1', '1109', 0),
(10, '1', '1', '1110', 0),
(11, '1', '2', '1201', 0),
(12, '1', '2', '1202', 0),
(13, '1', '2', '1203', 0),
(14, '1', '2', '1204', 0),
(15, '1', '2', '1205', 0),
(16, '1', '2', '1206', 0),
(17, '1', '2', '1207', 0),
(18, '1', '2', '1208', 0),
(19, '1', '2', '1209', 0),
(20, '1', '2', '1210', 0),
(21, '1', '3', '1301', 0),
(22, '1', '3', '1302', 0),
(23, '1', '3', '1303', 0),
(24, '1', '3', '1304', 0),
(25, '1', '3', '1305', 0),
(26, '1', '3', '1306', 0),
(27, '1', '3', '1307', 0),
(28, '1', '3', '1308', 0),
(29, '1', '3', '1309', 0),
(30, '1', '3', '1310', 0);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `Id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`Id`, `title`) VALUES
(1, 'คอมพิวเตอร์');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `Id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`Id`, `title`) VALUES
(1, 'เครื่อง');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `class_room_owner`
--
ALTER TABLE `class_room_owner`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `computer`
--
ALTER TABLE `computer`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `conect_inventory_computer`
--
ALTER TABLE `conect_inventory_computer`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `repair`
--
ALTER TABLE `repair`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class_room_owner`
--
ALTER TABLE `class_room_owner`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `computer`
--
ALTER TABLE `computer`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `conect_inventory_computer`
--
ALTER TABLE `conect_inventory_computer`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `repair`
--
ALTER TABLE `repair`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
