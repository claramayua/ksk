-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2020 at 03:33 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ksk`
--

-- --------------------------------------------------------

--
-- Table structure for table `donorproduct`
--

CREATE TABLE `donorproduct` (
  `donorproductid` int(11) NOT NULL,
  `donorid` int(11) NOT NULL,
  `productid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE `family` (
  `familyid` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `latitude` decimal(12,8) NOT NULL,
  `longitude` decimal(12,8) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `babynumber` int(11) NOT NULL,
  `childrennumber` int(11) NOT NULL,
  `adultnumber` int(11) NOT NULL,
  `elderlynumber` int(11) NOT NULL,
  `activeflag` int(11) NOT NULL,
  `startdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`familyid`, `address`, `fullname`, `latitude`, `longitude`, `email`, `phone`, `babynumber`, `childrennumber`, `adultnumber`, `elderlynumber`, `activeflag`, `startdate`) VALUES
(3, 'Semantan', 'Family A', '3.15080000', '101.67050000', 'clairejane.idv@gmail.com', '0198765432', 1, 0, 3, 4, 1, '2020-04-13');

-- --------------------------------------------------------

--
-- Table structure for table `familyspecialorder`
--

CREATE TABLE `familyspecialorder` (
  `familyspecialorderid` int(11) NOT NULL,
  `familyid` int(11) NOT NULL,
  `specialorderdescription` varchar(500) NOT NULL,
  `productid` int(11) NOT NULL,
  `dateneeded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `packedinventory`
--

CREATE TABLE `packedinventory` (
  `packedinventoryid` int(11) NOT NULL,
  `packingid` int(11) NOT NULL,
  `productinventoryid` int(11) NOT NULL,
  `packedquantity` int(11) NOT NULL,
  `packeddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `packing`
--

CREATE TABLE `packing` (
  `packingid` int(11) NOT NULL,
  `familyid` int(11) NOT NULL,
  `driverid` int(11) NOT NULL,
  `firstvolunteerid` int(11) NOT NULL,
  `secondvolunteerid` int(11) NOT NULL,
  `deliverystatus` int(11) NOT NULL,
  `deliverydate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `measurement` varchar(50) NOT NULL,
  `totalavailablestock` int(11) NOT NULL,
  `requiredstock` int(11) NOT NULL,
  `purchasedstockneeded` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `productinventory`
--

CREATE TABLE `productinventory` (
  `productinventoryid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `donorid` int(11) NOT NULL,
  `addedstock` int(11) NOT NULL,
  `addeddate` date NOT NULL,
  `expireddate` date NOT NULL,
  `barcodeimage` varchar(200) NOT NULL,
  `totalpackedstock` int(11) NOT NULL,
  `totaldeliveredstock` int(11) NOT NULL,
  `totalreturnedstock` int(11) NOT NULL,
  `availablestock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `returnedinventory`
--

CREATE TABLE `returnedinventory` (
  `returnedinventoryid` int(11) NOT NULL,
  `productinventoryid` int(11) NOT NULL,
  `returnedquantity` int(11) NOT NULL,
  `returneddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `returnedpackedinventory`
--

CREATE TABLE `returnedpackedinventory` (
  `returnedpackedinventoryid` int(11) NOT NULL,
  `packedinventoryid` int(11) NOT NULL,
  `returnedquantity` int(11) NOT NULL,
  `returneddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `verificationcode` varchar(250) NOT NULL,
  `verificationstatus` int(11) NOT NULL,
  `activeflag` int(11) NOT NULL,
  `role` varchar(9) NOT NULL,
  `driverlicense` varchar(20) DEFAULT NULL,
  `verificationdate` date NOT NULL,
  `lastpassworddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `fullname`, `address`, `phone`, `email`, `password`, `verificationcode`, `verificationstatus`, `activeflag`, `role`, `driverlicense`, `verificationdate`, `lastpassworddate`) VALUES
(1, 'Clara Mayu', 'Semantan', '0173081545', 'claramayuagusta@gmail.com', '878b2cbd0b2df4cd5c75dd1fa963f824', '54db555f3582012b4c16fd3cc45d7a7f', 1, 1, 'Donor', NULL, '2020-04-13', '2020-04-13'),
(2, 'Aya Agusta', 'Semantan', '0123456789', 'claramayuagusta@yahoo.com', '457db58bcdefd7a8bcf40cedb7f3ddba', '1a99357fad0306bcbd097c12473eac0c', 1, 1, 'Volunteer', '0102030405', '2020-04-13', '2020-04-13'),
(3, 'Staff', 'Semantan', '0172345689', 'claramayua.cm@gmail.com', 'b99165cd2609bbb891390120ed2df1cb', 'f8cd2a9a197ccc641cd63f1ac4e633af', 1, 1, 'Staff', '', '2020-04-13', '2020-04-13');

-- --------------------------------------------------------

--
-- Table structure for table `volunteerattendance`
--

CREATE TABLE `volunteerattendance` (
  `volunteerattendanceid` int(11) NOT NULL,
  `volunteerid` int(11) NOT NULL,
  `date` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `totaltime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `volunteerschedule`
--

CREATE TABLE `volunteerschedule` (
  `volunteerscheduleid` int(11) NOT NULL,
  `volunteerid` int(11) NOT NULL,
  `date` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donorproduct`
--
ALTER TABLE `donorproduct`
  ADD PRIMARY KEY (`donorproductid`);

--
-- Indexes for table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`familyid`);

--
-- Indexes for table `familyspecialorder`
--
ALTER TABLE `familyspecialorder`
  ADD PRIMARY KEY (`familyspecialorderid`);

--
-- Indexes for table `packedinventory`
--
ALTER TABLE `packedinventory`
  ADD PRIMARY KEY (`packedinventoryid`);

--
-- Indexes for table `packing`
--
ALTER TABLE `packing`
  ADD PRIMARY KEY (`packingid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `productinventory`
--
ALTER TABLE `productinventory`
  ADD PRIMARY KEY (`productinventoryid`);

--
-- Indexes for table `returnedinventory`
--
ALTER TABLE `returnedinventory`
  ADD PRIMARY KEY (`returnedinventoryid`);

--
-- Indexes for table `returnedpackedinventory`
--
ALTER TABLE `returnedpackedinventory`
  ADD PRIMARY KEY (`returnedpackedinventoryid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `volunteerattendance`
--
ALTER TABLE `volunteerattendance`
  ADD PRIMARY KEY (`volunteerattendanceid`);

--
-- Indexes for table `volunteerschedule`
--
ALTER TABLE `volunteerschedule`
  ADD PRIMARY KEY (`volunteerscheduleid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donorproduct`
--
ALTER TABLE `donorproduct`
  MODIFY `donorproductid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family`
--
ALTER TABLE `family`
  MODIFY `familyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `familyspecialorder`
--
ALTER TABLE `familyspecialorder`
  MODIFY `familyspecialorderid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packedinventory`
--
ALTER TABLE `packedinventory`
  MODIFY `packedinventoryid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packing`
--
ALTER TABLE `packing`
  MODIFY `packingid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productinventory`
--
ALTER TABLE `productinventory`
  MODIFY `productinventoryid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returnedinventory`
--
ALTER TABLE `returnedinventory`
  MODIFY `returnedinventoryid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returnedpackedinventory`
--
ALTER TABLE `returnedpackedinventory`
  MODIFY `returnedpackedinventoryid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `volunteerattendance`
--
ALTER TABLE `volunteerattendance`
  MODIFY `volunteerattendanceid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `volunteerschedule`
--
ALTER TABLE `volunteerschedule`
  MODIFY `volunteerscheduleid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
