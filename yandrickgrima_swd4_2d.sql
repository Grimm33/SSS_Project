-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2019 at 09:12 PM
-- Server version: 10.1.37-MariaDB
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
-- Database: `yandrickgrima_swd4.2d`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favourite`
--

CREATE TABLE `tbl_favourite` (
  `userId` int(4) NOT NULL,
  `propertyId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_favourite`
--

INSERT INTO `tbl_favourite` (`userId`, `propertyId`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property`
--

CREATE TABLE `tbl_property` (
  `propertyId` int(4) NOT NULL,
  `typeId` int(4) NOT NULL,
  `price` int(20) NOT NULL,
  `townId` int(4) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_property`
--

INSERT INTO `tbl_property` (`propertyId`, `typeId`, `price`, `townId`, `image`) VALUES
(1, 1, 1000000, 2, './images/maisonette.jpg'),
(2, 2, 2500000, 3, './images/villa.jpg'),
(3, 3, 750000, 1, './images/house.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_town`
--

CREATE TABLE `tbl_town` (
  `townId` int(4) NOT NULL,
  `town` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_town`
--

INSERT INTO `tbl_town` (`townId`, `town`) VALUES
(1, 'Valletta'),
(2, 'Attard'),
(3, 'Tarxien');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_type`
--

CREATE TABLE `tbl_type` (
  `typeId` int(4) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_type`
--

INSERT INTO `tbl_type` (`typeId`, `type`) VALUES
(1, 'Maisonette'),
(2, 'Villa'),
(3, 'House');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userId` int(4) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userId`, `email`, `password`, `name`, `surname`, `image`) VALUES
(1, 'yandrick@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Yandrick', 'Grima', 'images/userImages/DavidMitchell.png'),
(2, 'fake@email.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Lorry', 'Grima', 'images/userImages/ma nafx.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_favourite`
--
ALTER TABLE `tbl_favourite`
  ADD KEY `propertyId` (`propertyId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `tbl_property`
--
ALTER TABLE `tbl_property`
  ADD PRIMARY KEY (`propertyId`),
  ADD KEY `townId` (`townId`),
  ADD KEY `typeid` (`typeId`);

--
-- Indexes for table `tbl_town`
--
ALTER TABLE `tbl_town`
  ADD PRIMARY KEY (`townId`);

--
-- Indexes for table `tbl_type`
--
ALTER TABLE `tbl_type`
  ADD PRIMARY KEY (`typeId`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_property`
--
ALTER TABLE `tbl_property`
  MODIFY `propertyId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_town`
--
ALTER TABLE `tbl_town`
  MODIFY `townId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_type`
--
ALTER TABLE `tbl_type`
  MODIFY `typeId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userId` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_favourite`
--
ALTER TABLE `tbl_favourite`
  ADD CONSTRAINT `tbl_favourite_ibfk_1` FOREIGN KEY (`propertyId`) REFERENCES `tbl_property` (`propertyId`),
  ADD CONSTRAINT `tbl_favourite_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `tbl_user` (`userId`);

--
-- Constraints for table `tbl_property`
--
ALTER TABLE `tbl_property`
  ADD CONSTRAINT `tbl_property_ibfk_1` FOREIGN KEY (`townId`) REFERENCES `tbl_town` (`townId`),
  ADD CONSTRAINT `tbl_property_ibfk_2` FOREIGN KEY (`typeid`) REFERENCES `tbl_type` (`typeId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
