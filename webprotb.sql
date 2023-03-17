-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2023 at 06:42 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webprotb`
--

-- --------------------------------------------------------

--
-- Table structure for table `dailyscheduledb`
--

CREATE TABLE `dailyscheduledb` (
  `scheduleID` varchar(10) NOT NULL,
  `workDate` date NOT NULL,
  `workLocation` varchar(20) NOT NULL,
  `workHours` time NOT NULL,
  `workReport` varchar(50) NOT NULL,
  `supervisorComments` varchar(30) NOT NULL,
  `employeeID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `departmentdb`
--

CREATE TABLE `departmentdb` (
  `deptID` varchar(20) NOT NULL,
  `deptName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departmentdb`
--

INSERT INTO `departmentdb` (`deptID`, `deptName`) VALUES
('COM', 'Compliance'),
('ENG', 'Engineering'),
('FIN', 'Finance');

-- --------------------------------------------------------

--
-- Table structure for table `employeedb`
--

CREATE TABLE `employeedb` (
  `employeeID` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `position` enum('HR Admin','Supervisor','Employee') NOT NULL,
  `email` varchar(30) NOT NULL,
  `fwaStatus` varchar(20) DEFAULT NULL,
  `deptID` varchar(20) NOT NULL,
  `supervisorID` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employeedb`
--

INSERT INTO `employeedb` (`employeeID`, `password`, `name`, `position`, `email`, `fwaStatus`, `deptID`, `supervisorID`) VALUES
('EMP1', 'EMP1123', 'Bernard', 'Employee', 'bernard@gmail.com', 'Flexi-Hour\r\n', 'COM', 'SUP1'),
('EMP2', 'EMP2123', 'Hong Zhan', 'Employee', 'hongzhan@gmail.com', 'None', 'COM', 'SUP1'),
('EMP3', 'EMP3123', 'Zhi Qing', 'Employee', 'zhiwing@gmail.com', 'New', 'COM', NULL),
('EMP4', 'EMP4123', 'Morgan', '', 'moaaa', 'New', 'ENG', NULL),
('HR1', 'hr1', 'Marcus Liew Jin Shen', 'HR Admin', 'hradmin@gmail.com', 'None', 'COM', NULL),
('SUP1', 'SUP1123', 'Marcus', 'Supervisor', 'marcus@fgmail.coim', 'New', 'ENG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fwarequestdb`
--

CREATE TABLE `fwarequestdb` (
  `requestID` int(11) NOT NULL,
  `requestDate` date NOT NULL,
  `workType` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `comment` varchar(50) DEFAULT NULL,
  `employeeID` varchar(20) NOT NULL,
  `supervisorID` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fwarequestdb`
--

INSERT INTO `fwarequestdb` (`requestID`, `requestDate`, `workType`, `description`, `reason`, `status`, `comment`, `employeeID`, `supervisorID`) VALUES
(1, '2023-03-17', 'H', 'sss', 'ssss', 'Pending', NULL, 'EMP1', 'SUP1'),
(2, '2023-03-17', 'H', 'sss', 'ssss', 'Accepted', 'AAAAA', 'EMP1', 'SUP1'),
(56, '2023-03-17', 'FH', 'aa', 'a', 'Nope', 'WOAH!! ITS WORKING', 'EMP1', 'SUP1'),
(57, '2023-03-17', 'H', 'sss', 'ssss', 'Accepted', 'aaaaaa', 'EMP1', 'SUP1'),
(59, '2023-03-15', 'Work From Home\r\n', 'aaaee', 'dasas', 'Pending', NULL, 'EMP1', 'SUP1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dailyscheduledb`
--
ALTER TABLE `dailyscheduledb`
  ADD PRIMARY KEY (`scheduleID`),
  ADD KEY `employeeID` (`employeeID`);

--
-- Indexes for table `departmentdb`
--
ALTER TABLE `departmentdb`
  ADD PRIMARY KEY (`deptID`);

--
-- Indexes for table `employeedb`
--
ALTER TABLE `employeedb`
  ADD PRIMARY KEY (`employeeID`),
  ADD KEY `deptID` (`deptID`),
  ADD KEY `deptID_2` (`deptID`),
  ADD KEY `departmentID` (`deptID`),
  ADD KEY `employeedb_employeeID` (`supervisorID`);

--
-- Indexes for table `fwarequestdb`
--
ALTER TABLE `fwarequestdb`
  ADD PRIMARY KEY (`requestID`),
  ADD KEY `employeeID` (`employeeID`),
  ADD KEY `supervisorID` (`supervisorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fwarequestdb`
--
ALTER TABLE `fwarequestdb`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dailyscheduledb`
--
ALTER TABLE `dailyscheduledb`
  ADD CONSTRAINT `dailyscheduledb_employeeID` FOREIGN KEY (`employeeID`) REFERENCES `employeedb` (`employeeID`) ON UPDATE CASCADE;

--
-- Constraints for table `employeedb`
--
ALTER TABLE `employeedb`
  ADD CONSTRAINT `employeedb_deptID` FOREIGN KEY (`deptID`) REFERENCES `departmentdb` (`deptID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `employeedb_employeeID` FOREIGN KEY (`supervisorID`) REFERENCES `employeedb` (`employeeID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `fwarequestdb`
--
ALTER TABLE `fwarequestdb`
  ADD CONSTRAINT `fwarequest_employeeID` FOREIGN KEY (`employeeID`) REFERENCES `employeedb` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fwarequest_supervisorID` FOREIGN KEY (`supervisorID`) REFERENCES `employeedb` (`supervisorID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
