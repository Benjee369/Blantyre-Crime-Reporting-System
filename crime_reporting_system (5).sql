-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 08, 2024 at 12:51 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crime_reporting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admindetails`
--

DROP TABLE IF EXISTS `admindetails`;
CREATE TABLE IF NOT EXISTS `admindetails` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `First_Name` text NOT NULL,
  `Last_Name` text NOT NULL,
  `Email` varchar(70) NOT NULL,
  `Password` varchar(70) NOT NULL,
  `Role` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admindetails`
--

INSERT INTO `admindetails` (`ID`, `First_Name`, `Last_Name`, `Email`, `Password`, `Role`) VALUES
(1, 'Benjamin', 'Phiri', 'Admin@gmail.com', '$2y$10$scc9n1EE9NH0VTNdhJLou.oeQ4StbTLnaB3zA8KJ4X5xPXHVb.M1W', 'admin'),
(2, 'Adrian', 'Malika', 'Officer@gmail.com', '$2y$10$kCLagbWTVuf5vi4LX5JOoeSH1PMJ1FrVJkos0yyd0W4wqGS7rKTqa', 'officer'),
(4, 'Lisa', 'Gulumba', 'officer2@gmail.com', '$2y$10$OtQNvcXRCZM3yTQcY4XbvOM3H4gLnr6R329qitcNLV6nyXV4jNaau', 'officer'),
(5, 'John', 'Banda', 'officer3@gmail.com', '$2y$10$oCP/EpB5uMQZ4i7DACEczOJbqrVIKw.7AqVgH2ezeUkHkVuMrMbN.', 'officer');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
CREATE TABLE IF NOT EXISTS `assignments` (
  `AssignmentID` int NOT NULL AUTO_INCREMENT,
  `ReportID` int DEFAULT NULL,
  `OfficerID` int DEFAULT NULL,
  `PriorityLevel` varchar(255) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `AssignedDate` date DEFAULT NULL,
  `CompletionDate` date DEFAULT NULL,
  `PaymentApproved` tinyint(1) DEFAULT '0',
  `Paid` tinyint(1) DEFAULT '0',
  `Notes` text,
  PRIMARY KEY (`AssignmentID`),
  KEY `ReportID` (`ReportID`),
  KEY `OfficerID` (`OfficerID`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`AssignmentID`, `ReportID`, `OfficerID`, `PriorityLevel`, `Status`, `AssignedDate`, `CompletionDate`, `PaymentApproved`, `Paid`, `Notes`) VALUES
(18, 21, 2, 'Low', 'Reopened', '2024-03-28', NULL, 1, 0, NULL),
(19, 23, 4, 'High', 'Closed', '2024-04-02', NULL, 1, 1, NULL),
(20, 22, 2, 'High', 'In Progress', '2024-04-02', NULL, 1, 1, NULL),
(21, 25, 2, 'High', 'In Progress', '2024-04-03', NULL, 1, 0, NULL),
(22, 24, 5, 'High', 'Reopened', '2024-04-03', NULL, 1, 1, NULL),
(23, 27, 2, 'High', 'Closed', '2024-04-04', NULL, 1, 1, NULL),
(24, 28, 5, 'Medium', 'Closed', '2024-04-04', NULL, 1, 1, NULL),
(25, 30, 5, 'High', 'In Progress', '2024-04-05', NULL, 1, 1, NULL),
(26, 29, 2, 'Medium', 'In Progress', '2024-04-05', NULL, 0, 0, NULL),
(27, 31, 4, 'Medium', 'In Progress', '2024-04-05', NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
CREATE TABLE IF NOT EXISTS `chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `report_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `sender_name` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `sender_type` enum('user','officer') NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `report_id` (`report_id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `report_id`, `sender_id`, `sender_name`, `message`, `sender_type`, `created_at`) VALUES
(18, 31, 4, 'Officer', 'hey back to ya!', '', '2024-04-08 12:21:47'),
(17, 31, 16, 'User', 'hello', '', '2024-04-08 12:21:30'),
(16, 28, 15, 'User', 'i am user john', '', '2024-04-04 13:29:33'),
(15, 28, 5, 'Officer', 'i am officer benjamin', '', '2024-04-04 13:29:21'),
(14, 27, 14, 'User', 'i am a user', '', '2024-04-04 12:02:54'),
(13, 27, 2, 'Officer', 'i am a officer', '', '2024-04-04 12:02:36'),
(12, 24, 12, 'User', 'im am user', '', '2024-04-04 07:54:47'),
(19, 31, 16, 'User', 'so how\'s you doing?', '', '2024-04-08 12:22:10'),
(20, 31, 4, 'Officer', 'good good\r\nbut i guess i can\'t say the same about you', '', '2024-04-08 12:22:37'),
(21, 31, 16, 'User', 'ye man\r\ngot stabbed in the back', '', '2024-04-08 12:22:56'),
(22, 31, 4, 'Officer', 'been there, done that', '', '2024-04-08 12:23:10'),
(23, 31, 16, 'User', 'ha ha\r\nsow will you help me or not? ', '', '2024-04-08 12:23:42');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Full_Name` varchar(30) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Phone_Number` varchar(30) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`ID`, `Full_Name`, `Email`, `Phone_Number`, `Description`, `Date`) VALUES
(1, 'ff', 'Officer@gmail.com', '3333', 'ff', '2024-04-03 21:14:54'),
(2, 'adrian malika', 'adrian@gmail.com', '0894304718341', 'Im trying to get in touch', '2024-04-04 07:56:23');

-- --------------------------------------------------------

--
-- Table structure for table `crimereports`
--

DROP TABLE IF EXISTS `crimereports`;
CREATE TABLE IF NOT EXISTS `crimereports` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `First_Name` varchar(70) NOT NULL,
  `Last_Name` varchar(70) NOT NULL,
  `Incident_Category` varchar(20) NOT NULL,
  `SubmittedDate` timestamp(6) NOT NULL,
  `WitnessedDate` date NOT NULL,
  `Description` varchar(100) NOT NULL,
  `People_Involved` int NOT NULL,
  `If_Affected` int NOT NULL,
  `Multimedia` varchar(255) NOT NULL,
  `Location` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `crimereports`
--

INSERT INTO `crimereports` (`ID`, `UserID`, `First_Name`, `Last_Name`, `Incident_Category`, `SubmittedDate`, `WitnessedDate`, `Description`, `People_Involved`, `If_Affected`, `Multimedia`, `Location`) VALUES
(31, 16, 'Lwendo', 'Chawera', 'Missing Person', '2024-04-05 06:35:23.000000', '2024-04-02', 'My eldest son has been missing for 4 days', 1, 1, 'ReportMultimedia/IMG_20220915_130306.jpg', '-15.743244, 34.975376'),
(30, 15, 'fredrick', 'jamu', 'Theft', '2024-04-05 05:40:05.000000', '2024-04-10', 'hh', 1, 1, 'ReportMultimedia/IMG_20221206_014128.jpg', '-15.797649, 35.042324'),
(29, 15, 'fredrick', 'jamu', 'Theft', '2024-04-05 05:37:54.000000', '2024-04-13', 'anamaskini', 2, 1, 'ReportMultimedia/IMG_20221206_014353.jpg', '-15.813699, 35.065370'),
(28, 15, 'john', 'Banda', 'Theft', '2024-04-04 09:21:07.000000', '2024-04-02', 'i was robbed of my laptop bag and my phone', 2, 1, 'ReportMultimedia/join us.png', '-15.801455, 35.036112'),
(27, 14, 'Eugene', 'Onions', 'Theft', '2024-04-04 07:56:22.000000', '2024-04-02', 'A Man in the streets of malawi Has stolen a car', 2, 1, 'ReportMultimedia/printable-police-report-form-preview.png', '-15.770338, 35.032711'),
(26, 12, 'Golden', 'Boy', 'Missing Identity Car', '2024-04-04 04:00:04.000000', '2024-05-05', 'hhhh', 2, 1, 'ReportMultimedia/Small short test video (1).mp4', '-15.738018, 35.021671'),
(25, 13, 'Adrian', 'Malika', 'Theft', '2024-04-03 03:58:17.000000', '2024-04-02', 'My phone ', 2, 1, 'ReportMultimedia/IMG_20221205_105124.jpg', '-15.797567, 35.004086'),
(24, 12, 'Racheal', 'Kapakasa', 'Vandalism', '2024-04-02 09:27:46.000000', '2024-04-27', 'my house was vandaled mazulo', 3, 1, 'ReportMultimedia/IMG_20221010_064049.jpg', '-15.759612, 35.022580'),
(23, 12, 'Lisa', 'Gulumba', 'Missing Person', '2024-04-02 04:08:14.000000', '2024-04-04', 'the person was last seen near queens, wearing a blue shirt', 1, 1, 'ReportMultimedia/IMG_20220915_130306.jpg', '-15.800960, 35.021959'),
(22, 12, 'john', 'banda', 'Vandalism', '2024-04-01 18:31:27.000000', '2024-04-19', 'my house was vandalized around 12 midnight ', 1, 1, 'ReportMultimedia/F1Gl76HXsAUgcki.jpg', '51.498164, -0.093527'),
(21, 12, 'benjamin', 'phiri', 'Missing Identity Car', '2024-03-28 06:26:36.000000', '2024-03-28', 'Last place I saw my National ID was when I was at Road Traffic', 1, 1, 'ReportMultimedia/Campground_at_Tidal_River.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `reportprice`
--

DROP TABLE IF EXISTS `reportprice`;
CREATE TABLE IF NOT EXISTS `reportprice` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Category` varchar(255) NOT NULL,
  `Price` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reportprice`
--

INSERT INTO `reportprice` (`ID`, `Category`, `Price`) VALUES
(1, 'Traffic Accident', 2000),
(2, 'Missing Identity Card', 3000),
(3, 'Theft', 2000),
(4, 'Assault', 2000),
(5, 'Vandalism', 2000),
(6, 'Fraud', 2000),
(7, 'Missing Person', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

DROP TABLE IF EXISTS `userdetails`;
CREATE TABLE IF NOT EXISTS `userdetails` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(70) NOT NULL,
  `Last_Name` varchar(70) NOT NULL,
  `Email_Address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Phone_Number` varchar(11) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`ID`, `First_Name`, `Last_Name`, `Email_Address`, `Phone_Number`, `Address`, `Password`) VALUES
(12, 'Benjamin', 'Phiri', 'benjaminphiri@gmail.com', '0881945574', 'Nyambadwe, Magalasi', '$2y$10$F0nSW43AJiKvDwrTw73IreUnOQQbnMtX8TzAVaIpkYqnzW6wFIEmW'),
(13, 'Adrian', 'Malika', 'adrianmalika01@gmail.com', '0881945574', 'Manase', '$2y$10$5rbbNtJrdKxbiJP0ZAFL2u.CWXtQgHGcA.7ZvBakXcOt59u8uAYp6'),
(14, 'Eugene', 'Onions', 'eugeneonions8@gmail.com', '0998777777', 'Blantyre Malawi Baby', '$2y$10$oZKO5vA0GjyZTzRORYPw1.4gEd8g5.QVM8Td6CEGf4z6nxysrjmU.'),
(16, 'Lwendo', 'Chabwera', 'lwendoooo@gmail.com', '0997421343', 'Magalasi', '$2y$10$bzkYWdr.jVBMdFJkFyS3sOrwptxWbiaJjpBaEGkZ6.3LD4FT7PU7K');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
