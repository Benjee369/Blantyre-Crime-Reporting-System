-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 27, 2024 at 06:38 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admindetails`
--

INSERT INTO `admindetails` (`ID`, `First_Name`, `Last_Name`, `Email`, `Password`, `Role`) VALUES
(1, 'Benjamin', 'Phiri', 'Admin@gmail.com', '$2y$10$scc9n1EE9NH0VTNdhJLou.oeQ4StbTLnaB3zA8KJ4X5xPXHVb.M1W', 'admin'),
(2, 'Adrian', 'Malika', 'Officer@gmail.com', '$2y$10$kCLagbWTVuf5vi4LX5JOoeSH1PMJ1FrVJkos0yyd0W4wqGS7rKTqa', 'officer'),
(4, 'Lisa', 'Gulumba', 'officer2@gmail.com', '$2y$10$OtQNvcXRCZM3yTQcY4XbvOM3H4gLnr6R329qitcNLV6nyXV4jNaau', 'officer');

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
  `Notes` text,
  PRIMARY KEY (`AssignmentID`),
  KEY `ReportID` (`ReportID`),
  KEY `OfficerID` (`OfficerID`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`AssignmentID`, `ReportID`, `OfficerID`, `PriorityLevel`, `Status`, `AssignedDate`, `CompletionDate`, `Notes`) VALUES
(7, 2, 2, 'Medium', 'On Hold', NULL, NULL, NULL),
(6, 2, 4, 'Medium', 'On Hold', NULL, NULL, NULL),
(5, 2, 4, 'Medium', 'On Hold', NULL, NULL, NULL),
(8, 3, 2, 'High', 'Closed', NULL, NULL, NULL),
(9, 1, 2, 'High', NULL, NULL, NULL, NULL),
(10, 19, 2, 'High', 'Reopened', NULL, NULL, NULL),
(11, 19, 2, 'High', 'Reopened', '2024-03-24', NULL, NULL),
(12, 19, 2, 'High', 'Reopened', '0000-00-00', NULL, NULL),
(13, 19, 2, 'High', 'Reopened', '2024-03-24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
CREATE TABLE IF NOT EXISTS `chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `report_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `officer_id` int DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  `sender_type` enum('user','officer') DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `report_id` (`report_id`),
  KEY `user_id` (`user_id`),
  KEY `officer_id` (`officer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `report_id`, `user_id`, `officer_id`, `message`, `sender_type`, `created_at`) VALUES
(1, 3, 3, NULL, 'ff', '', '2024-03-27 03:49:47'),
(2, 3, 3, NULL, 'h', '', '2024-03-27 03:51:25'),
(3, 3, 3, NULL, 'hello', '', '2024-03-27 03:56:22'),
(4, 3, 3, NULL, 'nigga', '', '2024-03-27 04:00:11'),
(5, 3, 3, NULL, 'john', '', '2024-03-27 04:03:35'),
(6, 3, NULL, 2, 'mmm', '', '2024-03-27 04:07:31'),
(7, 3, 3, 0, 'message 1', '', '2024-03-27 04:18:06'),
(8, 3, 0, 2, 'message 2', '', '2024-03-27 04:18:20'),
(9, 3, 0, 2, 'this is  the officer', '', '2024-03-27 04:19:21'),
(10, 3, 3, 0, 'This is the user', '', '2024-03-27 04:19:35'),
(11, 3, 3, 0, 'user', '', '2024-03-27 05:05:01'),
(12, 3, 3, 0, 'user', '', '2024-03-27 05:05:08'),
(13, 3, 3, 0, 'n', '', '2024-03-27 05:07:12'),
(14, 3, 3, 0, 'n', '', '2024-03-27 05:07:15'),
(15, 3, 3, 0, 'v', '', '2024-03-27 05:10:02'),
(16, 3, 3, 0, 'me', '', '2024-03-27 05:10:33'),
(17, 3, 3, 0, 'benja', '', '2024-03-27 05:12:02'),
(18, 3, 3, 0, 'nn', '', '2024-03-27 05:14:40'),
(19, 3, 3, 0, 'jjj', '', '2024-03-27 05:34:58'),
(20, 3, 0, 2, 'yufuyjfu', '', '2024-03-27 08:13:48');

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
  `CurrentDate` timestamp(6) NOT NULL,
  `WitnessedDate` date NOT NULL,
  `Description` varchar(100) NOT NULL,
  `People_Involved` int NOT NULL,
  `If_Affected` int NOT NULL,
  `Multimedia` varchar(255) NOT NULL,
  `Location` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `crimereports`
--

INSERT INTO `crimereports` (`ID`, `UserID`, `First_Name`, `Last_Name`, `Incident_Category`, `CurrentDate`, `WitnessedDate`, `Description`, `People_Involved`, `If_Affected`, `Multimedia`, `Location`) VALUES
(1, 1, 'ben', 'ome', 'Theft', '2024-02-03 05:50:57.000000', '2024-02-06', 'kflwkef', 2, 1, 'ReportMultimedia/IMG_20221010_064049.jpg', ''),
(2, 2, 'John', 'banda', 'Fraud', '2024-03-12 22:43:56.000000', '2024-03-07', 'I have been a suspect of credit card fraud', 4, 1, 'ReportMultimedia/Screenshot (555).png', ''),
(3, 2, 'adrian', 'malika', 'Assault', '2024-03-13 04:47:59.000000', '2024-03-11', 'I was assaulted by five people coming from work', 6, 1, 'ReportMultimedia/IMG_20220915_130306.jpg', ''),
(4, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:17:58.000000', '2024-03-13', 'ddd', 3, 1, 'ReportMultimedia/IMG_20221010_064049.jpg', ''),
(5, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:21:18.000000', '2024-03-13', 'ddd', 3, 1, 'ReportMultimedia/IMG_20221010_064049.jpg', ''),
(6, 3, 'adrian', 'malika', 'Fraud', '2024-03-16 07:31:56.000000', '2024-03-14', 'frfere', 3, 1, 'ReportMultimedia/F1Gl76HXsAUgcki.jpg', ''),
(7, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:33:53.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/IMG_20221010_064049.jpg', ''),
(8, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:37:55.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/F1HI0jGXsAAf-XS.jpg', ''),
(9, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:38:21.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/F1HI0jGXsAAf-XS.jpg', ''),
(10, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:38:31.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/F1HI0jGXsAAf-XS.jpg', ''),
(11, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:38:34.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/F1HI0jGXsAAf-XS.jpg', ''),
(12, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:38:39.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/F1HI0jGXsAAf-XS.jpg', ''),
(13, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:38:59.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/F1HI0jGXsAAf-XS.jpg', ''),
(14, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:39:13.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/F1HI0jGXsAAf-XS.jpg', ''),
(15, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:39:23.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/F1HI0jGXsAAf-XS.jpg', ''),
(16, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:39:33.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/F1HI0jGXsAAf-XS.jpg', ''),
(17, 3, 'adrian', 'malika', 'Assault', '2024-03-16 07:44:11.000000', '2024-04-10', 'ddd', 4, 1, 'ReportMultimedia/Small short test video (1).mp4', ''),
(18, 3, 'adrian', 'malika', 'Assault', '2024-03-20 04:43:00.000000', '2024-03-08', 'faef', 2, 1, 'ReportMultimedia/Small short test video (1).mp4', ''),
(19, 3, 'benjamin', 'phiri', 'Theft', '2024-03-20 09:21:44.000000', '2024-03-13', 'the theft happened near blantyre market', 3, 1, 'ReportMultimedia/Campground_at_Tidal_River.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

DROP TABLE IF EXISTS `userdetails`;
CREATE TABLE IF NOT EXISTS `userdetails` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `First_Name` varchar(70) NOT NULL,
  `Last_Name` varchar(70) NOT NULL,
  `Email_Address` varchar(20) NOT NULL,
  `Phone_Number` varchar(11) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`ID`, `First_Name`, `Last_Name`, `Email_Address`, `Phone_Number`, `Address`, `Password`) VALUES
(1, 'ben', 'last', 'ben@mail', '88', 'dsd', '$2y$10$DMOqGy2kvULZnOpyckDKzeKB.9eQBaZd.W0w54ya6FTuUU2npgQTa'),
(2, 'Adrian', 'Malika', 'dee@mail.com', '70960870', 'Manase', '$2y$10$GL9FNXOLiNWagSmot/grk.F1ugiYXaF/b6pUmPCmMyKqi.UATC23.'),
(3, 'benja', 'min', 'ben@mail.com', '70960870', 'Manase', '$2y$10$wYKxrIyV7mFRLqCFrQHAS.KG3HS2A25Y7VRX1bFh0IeQnxgADRx3m'),
(4, 'Adrian', 'Malika', 'Officer@gmail.com', '70960870', 'Manase', '$2y$10$darqoidWt3nDU32rGmU8x.XGW9YlM.XR6n4ND7TgCeID/u9RyB97i'),
(5, 'Adrian', 'min', 'john@mail.com', '999', 'Manase', '$2y$10$JlCqJ5rmAiJ.ltECufqK0uNLaC.8ER.Nt/rXFRL32O.FCskhh/aV6'),
(6, 'Adrian', 'Malika', 'man@mail.com', '70960870', 'Manase', '$2y$10$ku1jZIxaWfqxCQJzWO3M.OQ1UJH.dBWTJRQh7VJ2oPEz4H7At9h/m'),
(7, 'rr', 'r', 'officer2@gmail.com', '333', '33', '$2y$10$ZBcUrxstB/jWm2pGeaocouqE8aikj9GZaiiR4OI355p29x3HT6QEm'),
(8, 'rr', 'r', 'hsfohjoeir@mail.com', '333', '33', '$2y$10$FuGPAsBSnRizi8BwnyGIF.QaaX.5Y/ebuiIACA3.8hjSSoas4sQPW');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
