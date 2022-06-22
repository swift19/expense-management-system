-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2022 at 07:41 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `detsdb`
--
CREATE DATABASE IF NOT EXISTS `detsdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `detsdb`;

-- --------------------------------------------------------

--
-- Table structure for table `tblexpense`
--

CREATE TABLE `tblexpense` (
  `ID` int(10) NOT NULL,
  `UserId` int(10) NOT NULL,
  `ExpenseDate` date DEFAULT NULL,
  `ExpenseItem` varchar(200) DEFAULT NULL,
  `ExpenseCost` varchar(200) DEFAULT NULL,
  `ExpenseCategory` varchar(200) DEFAULT NULL,
  `NoteDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblexpense`
--

INSERT INTO `tblexpense` (`ID`, `UserId`, `ExpenseDate`, `ExpenseItem`, `ExpenseCost`, `ExpenseCategory`, `NoteDate`) VALUES
(30, 1, '2019-05-18', 'Milk + Bread', '80', '0', '2019-05-18 05:22:01'),
(37, 2, '2022-06-20', NULL, '600', 'Water Bill', '2022-06-22 02:47:22'),
(38, 2, '2022-06-20', NULL, '1300', 'Electric Bill', '2022-06-22 02:47:46'),
(39, 2, '2022-06-20', NULL, '200', 'Food', '2022-06-22 02:48:53'),
(42, 2, '2022-06-19', NULL, '120', 'Food', '2022-06-22 03:07:41'),
(43, 2, '2022-06-21', NULL, '150', 'Food', '2022-06-22 03:08:00'),
(44, 2, '2022-06-22', NULL, '170', 'Food', '2022-06-22 03:08:14'),
(45, 2, '2022-06-18', NULL, '500', 'Transportation', '2022-06-22 03:09:21'),
(46, 2, '2022-06-19', NULL, '500', 'Transportation', '2022-06-22 03:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `tblexpensecategory`
--

CREATE TABLE `tblexpensecategory` (
  `ID` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Category` varchar(200) DEFAULT NULL,
  `Category_Created` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblexpensecategory`
--

INSERT INTO `tblexpensecategory` (`ID`, `UserId`, `Category`, `Category_Created`) VALUES
(3, 2, 'Water Bill', '2022-06-22'),
(4, 2, 'Electric Bill', '2022-06-22'),
(5, 2, 'Food', '2022-06-22'),
(6, 2, 'Transportation', '2022-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `tblincome`
--

CREATE TABLE `tblincome` (
  `ID` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `IncomeDate` date DEFAULT current_timestamp(),
  `Income` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblincome`
--

INSERT INTO `tblincome` (`ID`, `UserId`, `Description`, `IncomeDate`, `Income`) VALUES
(1, 2, 'Monthly Salary', '2022-06-20', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `FullName` varchar(150) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Position` varchar(200) DEFAULT NULL,
  `Image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FullName`, `Email`, `MobileNumber`, `Password`, `RegDate`, `Position`, `Image`) VALUES
(1, 'Test User demo', 'testuser@gmail.com', 9876543213, 'f925916e2754e5e03f75dd58a5733251', '2019-05-18 05:34:53', 'test user position', 0x6173736574732f696d616765732f75736572732f352e6a7067),
(2, 'Test User', 'test@mailinator.com', 9354802263, 'f925916e2754e5e03f75dd58a5733251', '2022-06-22 02:21:34', 'test position', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblexpense`
--
ALTER TABLE `tblexpense`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblexpensecategory`
--
ALTER TABLE `tblexpensecategory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblincome`
--
ALTER TABLE `tblincome`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblexpense`
--
ALTER TABLE `tblexpense`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tblexpensecategory`
--
ALTER TABLE `tblexpensecategory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblincome`
--
ALTER TABLE `tblincome`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
