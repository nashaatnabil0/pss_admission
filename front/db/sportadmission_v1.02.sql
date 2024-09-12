-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 11:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportadmission`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `ID` int(10) NOT NULL,
  `traineeNID` bigint(14) NOT NULL,
  `groupId` int(10) NOT NULL,
  `paymentPlan` varchar(20) NOT NULL,
  `paymentState` varchar(20) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `discount` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`ID`, `traineeNID`, `groupId`, `paymentPlan`, `paymentState`, `state`, `date`, `discount`) VALUES
(1, 3201211258749, 1, 'Full', 'complete', 'on', '2024-09-08', NULL),
(2, 3201008159514, 1, 'installments', 'partial', 'on', '2024-09-08', NULL),
(3, 32008060101234, 2, 'installments', 'partial', 'on', '2024-09-08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `ID` int(10) NOT NULL,
  `Title` varchar(200) DEFAULT NULL,
  `place` mediumtext DEFAULT NULL,
  `days` varchar(100) DEFAULT NULL,
  `Timeslot` varchar(100) NOT NULL,
  `minAge` int(5) DEFAULT NULL,
  `maxAge` int(5) DEFAULT NULL,
  `trainerId` int(10) DEFAULT NULL,
  `sportId` int(10) DEFAULT NULL,
  `seasonId` int(10) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `capacity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`ID`, `Title`, `place`, `days`, `Timeslot`, `minAge`, `maxAge`, `trainerId`, `sportId`, `seasonId`, `price`, `capacity`) VALUES
(1, 'Tigers', 'main playground', 'sat -  tue', '3:00', 10, 14, 1, 1, 1, 400, 30),
(2, 'Lions', 'main playground', 'sat - tue', '5:30 ', 15, 18, 2, 1, 1, 400, 30);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `ID` int(10) NOT NULL,
  `enrollmentId` int(10) NOT NULL,
  `paymentAmount` int(10) NOT NULL,
  `paymentMethod` varchar(30) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `userId` int(10) NOT NULL,
  `notes` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`ID`, `enrollmentId`, `paymentAmount`, `paymentMethod`, `date`, `userId`, `notes`) VALUES
(1, 1, 400, 'cash', '2024-09-08', 1, NULL),
(2, 2, 200, 'cash', '2024-09-08', 1, NULL),
(3, 3, 200, 'cash', '2024-09-08', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `season`
--

CREATE TABLE `season` (
  `ID` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `state` varchar(10) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `season`
--

INSERT INTO `season` (`ID`, `name`, `state`, `startDate`, `image`) VALUES
(1, 'winter 2025', 'on', '2025-01-15', 'summer.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `ID` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `supervisorID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`ID`, `name`, `supervisorID`) VALUES
(1, 'football', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trainees`
--

CREATE TABLE `trainees` (
  `Name` varchar(250) NOT NULL,
  `NID` bigint(14) NOT NULL,
  `birthDate` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `photo` varchar(250) NOT NULL,
  `birthCertificate` varchar(250) NOT NULL,
  `contactMobNum` bigint(11) NOT NULL,
  `fatherName` varchar(250) DEFAULT NULL,
  `fatherMobNum` bigint(11) DEFAULT NULL,
  `fatherJob` varchar(200) DEFAULT NULL,
  `motherName` varchar(250) DEFAULT NULL,
  `motherMobNum` bigint(11) DEFAULT NULL,
  `motherJob` varchar(250) DEFAULT NULL,
  `Notes` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `trainees`
--

INSERT INTO `trainees` (`Name`, `NID`, `birthDate`, `gender`, `photo`, `birthCertificate`, `contactMobNum`, `fatherName`, `fatherMobNum`, `fatherJob`, `motherName`, `motherMobNum`, `motherJob`, `Notes`) VALUES
('Samy labib', 3201008159514, '2010-08-15', 'male', 'samy.jpg', 'certificate.jpg', 1098523647, 'labib Magdy', 1095175365, 'engineer', NULL, NULL, NULL, NULL),
('Ali Essam Elnagar', 3201211258749, '2012-11-25', 'male', 'ali.jpg', 'certificate.jpg', 1123654789, 'Essam Elnagar', 1098745632, 'Doctor', 'Dina Saad', 1074185296, 'Teacher', NULL),
('Mazen Emad Ali', 32008060101234, '2008-06-10', 'male', 'mazen.jpg', 'certificate.jpg', 1023456789, 'Emad Ali Ahmed', 1012345678, 'Engineer', 'Mai ali Zain', 1123456789, 'Teacher', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `ID` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `MobileNumber` bigint(11) NOT NULL,
  `sportId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`ID`, `name`, `MobileNumber`, `sportId`) VALUES
(1, 'Hamdi Fayez ', 1012345678, 1),
(2, 'John Amir', 1234567895, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `MobileNumber` bigint(11) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `name`, `MobileNumber`, `Email`, `role`, `password`) VALUES
(1, 'admin', 1012345678, 'admin@gmail.com', 'admin', '0192023a7bbd73250516f069df18b500');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `traineeNID` (`traineeNID`),
  ADD KEY `groupId` (`groupId`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `trainerId` (`trainerId`),
  ADD KEY `seasonId` (`seasonId`),
  ADD KEY `sportId` (`sportId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `enrollmentId` (`enrollmentId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `season`
--
ALTER TABLE `season`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `trainees`
--
ALTER TABLE `trainees`
  ADD PRIMARY KEY (`NID`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `sportId` (`sportId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `season`
--
ALTER TABLE `season`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sport`
--
ALTER TABLE `sport`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`groupId`) REFERENCES `groups` (`ID`),
  ADD CONSTRAINT `enrollment_ibfk_3` FOREIGN KEY (`traineeNID`) REFERENCES `trainees` (`NID`),
  ADD CONSTRAINT `enrollment_ibfk_4` FOREIGN KEY (`groupId`) REFERENCES `groups` (`ID`),
  ADD CONSTRAINT `enrollment_ibfk_5` FOREIGN KEY (`groupId`) REFERENCES `groups` (`ID`),
  ADD CONSTRAINT `enrollment_ibfk_6` FOREIGN KEY (`groupId`) REFERENCES `groups` (`ID`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`trainerId`) REFERENCES `trainers` (`ID`),
  ADD CONSTRAINT `groups_ibfk_2` FOREIGN KEY (`seasonId`) REFERENCES `season` (`ID`),
  ADD CONSTRAINT `groups_ibfk_3` FOREIGN KEY (`sportId`) REFERENCES `sport` (`ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`enrollmentId`) REFERENCES `enrollment` (`ID`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`ID`);

--
-- Constraints for table `sport`
--
ALTER TABLE `sport`
  ADD CONSTRAINT `sport_ibfk_2` FOREIGN KEY (`supervisorID`) REFERENCES `trainers` (`ID`);

--
-- Constraints for table `trainers`
--
ALTER TABLE `trainers`
  ADD CONSTRAINT `trainers_ibfk_1` FOREIGN KEY (`sportId`) REFERENCES `sport` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
