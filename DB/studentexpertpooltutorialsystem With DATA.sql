-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 30, 2025 at 06:38 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentexpertpooltutorialsystem`
--
CREATE DATABASE IF NOT EXISTS `studentexpertpooltutorialsystem` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `studentexpertpooltutorialsystem`;

-- --------------------------------------------------------

--
-- Table structure for table `answer_table`
--

DROP TABLE IF EXISTS `answer_table`;
CREATE TABLE IF NOT EXISTS `answer_table` (
  `AnsId` int NOT NULL AUTO_INCREMENT,
  `TakeNo` int NOT NULL,
  `QuestionNo` int NOT NULL,
  `ChoiceAns` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `IsCorrect` int NOT NULL,
  PRIMARY KEY (`AnsId`),
  KEY `TakeNo` (`TakeNo`),
  KEY `QuestionNo` (`QuestionNo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer_table`
--

INSERT INTO `answer_table` (`AnsId`, `TakeNo`, `QuestionNo`, `ChoiceAns`, `IsCorrect`) VALUES
(15, 9, 14, 'C', 1),
(16, 9, 15, 'C', 1),
(17, 10, 14, 'B', 0),
(18, 10, 15, 'D', 0),
(19, 11, 14, 'C', 1),
(20, 11, 15, 'B', 0);

-- --------------------------------------------------------

--
-- Table structure for table `chat_table`
--

DROP TABLE IF EXISTS `chat_table`;
CREATE TABLE IF NOT EXISTS `chat_table` (
  `ChatId` int NOT NULL AUTO_INCREMENT,
  `StudentId` int NOT NULL,
  `InstructorId` int NOT NULL,
  `DateCreated` datetime NOT NULL,
  `MeetingId` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ChatId`),
  UNIQUE KEY `MeetingId` (`MeetingId`),
  KEY `StudentId` (`StudentId`),
  KEY `InstructorId` (`InstructorId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_table`
--

INSERT INTO `chat_table` (`ChatId`, `StudentId`, `InstructorId`, `DateCreated`, `MeetingId`) VALUES
(2, 7, 19, '2023-11-25 02:01:07', 'uc2b-qe68-nose'),
(3, 8, 19, '2023-11-27 09:06:09', '8cn8-p838-b9oq');

-- --------------------------------------------------------

--
-- Table structure for table `employees_table`
--

DROP TABLE IF EXISTS `employees_table`;
CREATE TABLE IF NOT EXISTS `employees_table` (
  `EmpKey` int NOT NULL AUTO_INCREMENT,
  `EmpId` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Firstname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `MI` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Lastname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `NameExt` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Designation` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Gender` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Contact` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Photo` text COLLATE utf8mb4_general_ci,
  `TypeOfService` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Status` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Academic Qualifications` text COLLATE utf8mb4_general_ci,
  `MaximumLoad` int DEFAULT NULL,
  `Verified` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`EmpKey`),
  UNIQUE KEY `EmpId` (`EmpId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees_table`
--

INSERT INTO `employees_table` (`EmpKey`, `EmpId`, `Firstname`, `MI`, `Lastname`, `NameExt`, `Designation`, `Gender`, `Contact`, `Email`, `Photo`, `TypeOfService`, `Status`, `Academic Qualifications`, `MaximumLoad`, `Verified`) VALUES
(19, '0465-152', 'Juan', 'P', 'Dela cruz', 'Jr', NULL, 'Male', '97896977559965', 'ins1@mail.com', 'img/ins/0465-152.jpg', NULL, 'active', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `instructorload_table`
--

DROP TABLE IF EXISTS `instructorload_table`;
CREATE TABLE IF NOT EXISTS `instructorload_table` (
  `LoadId` int NOT NULL AUTO_INCREMENT,
  `InstructorId` int NOT NULL,
  `SectionId` int NOT NULL,
  PRIMARY KEY (`LoadId`),
  KEY `InstructorId` (`InstructorId`),
  KEY `instructorload_table_ibfk_2` (`SectionId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructorload_table`
--

INSERT INTO `instructorload_table` (`LoadId`, `InstructorId`, `SectionId`) VALUES
(24, 19, 2),
(25, 19, 15),
(26, 19, 22);

-- --------------------------------------------------------

--
-- Table structure for table `learningmaterials_category_table`
--

DROP TABLE IF EXISTS `learningmaterials_category_table`;
CREATE TABLE IF NOT EXISTS `learningmaterials_category_table` (
  `LMCatId` int NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`LMCatId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learningmaterials_category_table`
--

INSERT INTO `learningmaterials_category_table` (`LMCatId`, `CategoryName`) VALUES
(1, 'Videos'),
(2, 'Images'),
(3, 'Docs/Sheets/Slides/PDF'),
(5, 'Sites'),
(6, 'Google Drive Folder/File');

-- --------------------------------------------------------

--
-- Table structure for table `learningmaterials_table`
--

DROP TABLE IF EXISTS `learningmaterials_table`;
CREATE TABLE IF NOT EXISTS `learningmaterials_table` (
  `MaterialNo` int NOT NULL AUTO_INCREMENT,
  `TopicId` int NOT NULL,
  `CategoryId` int NOT NULL,
  `Title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `MaterialsDescription` text COLLATE utf8mb4_general_ci NOT NULL,
  `URL` text COLLATE utf8mb4_general_ci,
  `Path` text COLLATE utf8mb4_general_ci,
  `Status` int NOT NULL,
  PRIMARY KEY (`MaterialNo`),
  KEY `learningmaterials_table_ibfk_1` (`CategoryId`),
  KEY `TopicId` (`TopicId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learningmaterials_table`
--

INSERT INTO `learningmaterials_table` (`MaterialNo`, `TopicId`, `CategoryId`, `Title`, `MaterialsDescription`, `URL`, `Path`, `Status`) VALUES
(3, 5, 5, 'Basic Derivatives', 'In calculus, finding the derivative of a function is a fundamental concept. The derivative of a function f(x) with respect to x, denoted as f\'(x) or dy/dx, represents the rate of change of the function with respect to the independent variable x. Here are some basic derivative rules and formulas:\r\nPower Rule: If f(x) = x^n, where n is a constant, then f\'(x) = nx^(n-1). This rule is used to find the derivative of functions like x^2, x^3, x^4, and so on.\r\nConstant Rule: If f(x) = c, where c is a constant, then f\'(x) = 0. This rule states that the derivative of a constant is always zero.\r\nSum/Difference Rule: If f(x) = g(x) ± h(x), then f\'(x) = g\'(x) ± h\'(x). This rule allows you to find the derivative of a sum or difference of two functions.\r\nProduct Rule: If f(x) = g(x) * h(x), then f\'(x) = g\'(x) * h(x) + g(x) * h\'(x). This rule is used to find the derivative of a product of two functions.\r\nQuotient Rule: If f(x) = g(x) / h(x), then f\'(x) = [g\'(x) * h(x) - g(x) * h\'(x)] / h(x)^2. This rule is used to find the derivative of a quotient of two functions.\r\nChain Rule: If f(x) = g(h(x)), then f\'(x) = g\'(h(x)) * h\'(x). This rule is used to find the derivative of composite functions.', 'https://www.youtube.com/watch?v=O_9u1P5YjVc&list=PL4cUxeGkcC9joIM91nLzd_qaH_AimmdAR', '', 1),
(5, 6, 3, 'Tutorial 1', 'Tutorial 1 for Calculus 1 on Limit', '', 'materials/5.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `materialsload_table`
--

DROP TABLE IF EXISTS `materialsload_table`;
CREATE TABLE IF NOT EXISTS `materialsload_table` (
  `InstructorLoadId` int NOT NULL,
  `MaterialsId` int NOT NULL,
  KEY `InstructorLoadId` (`InstructorLoadId`),
  KEY `MaterialsId` (`MaterialsId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materialsload_table`
--

INSERT INTO `materialsload_table` (`InstructorLoadId`, `MaterialsId`) VALUES
(24, 5),
(25, 5),
(26, 5),
(24, 3),
(25, 3),
(26, 3);

-- --------------------------------------------------------

--
-- Table structure for table `message_table`
--

DROP TABLE IF EXISTS `message_table`;
CREATE TABLE IF NOT EXISTS `message_table` (
  `MessageId` int NOT NULL AUTO_INCREMENT,
  `ChatId` int NOT NULL,
  `SenderStudent` int DEFAULT NULL,
  `SenderIns` int DEFAULT NULL,
  `SendDateTime` datetime NOT NULL,
  `Message` text COLLATE utf8mb4_general_ci NOT NULL,
  `Viewed` int NOT NULL,
  PRIMARY KEY (`MessageId`),
  KEY `SenderStudent` (`SenderStudent`),
  KEY `SenderIns` (`SenderIns`),
  KEY `ChatId` (`ChatId`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message_table`
--

INSERT INTO `message_table` (`MessageId`, `ChatId`, `SenderStudent`, `SenderIns`, `SendDateTime`, `Message`, `Viewed`) VALUES
(24, 2, 7, NULL, '2023-11-26 08:14:10', 'meeting ID:uc2b-qe68-nose\r\n', 1),
(30, 2, 7, NULL, '2023-11-26 04:33:51', 'meeting ID:uc2b-qe68-nose\r\n', 1),
(31, 2, 7, NULL, '2023-11-26 04:35:34', 'meeting ID:uc2b-qe68-nose\r\n', 1),
(33, 2, 7, NULL, '2023-11-26 17:11:27', 'hvbhkb', 1),
(34, 2, NULL, 19, '2023-11-26 18:28:21', 'blah blah', 1),
(36, 2, 7, NULL, '2023-11-27 12:54:14', 'meeting ID:uc2b-qe68-nose', 1),
(37, 2, NULL, 19, '2023-11-27 05:34:01', 'mamaya na busy pa', 1),
(38, 2, 7, NULL, '2023-11-27 06:37:45', 'meeting ID:uc2b-qe68-nose\r\n', 1),
(42, 2, NULL, 19, '2023-11-27 08:15:44', 'Ok na haha', 1),
(43, 2, 7, NULL, '2023-11-27 08:20:59', 'aw Ok', 1),
(44, 3, 8, NULL, '2023-11-27 09:06:09', 'meeting ID:8cn8-p838-b9oq', 1),
(45, 2, NULL, 19, '2023-11-27 09:15:15', 'Giat\n', 1),
(46, 3, 8, NULL, '2023-12-02 09:06:51', 'meeting ID:8cn8-p838-b9oq', 1),
(47, 3, NULL, 19, '2023-12-02 10:33:27', 'Ngen2?', 1),
(48, 3, 8, NULL, '2023-12-02 10:49:53', 'Liminog\n', 1),
(49, 2, NULL, 19, '2023-12-02 10:56:06', 'uway bah', 1),
(50, 3, NULL, 19, '2023-12-02 11:00:00', 'uwY BH', 1),
(51, 3, 8, NULL, '2023-12-02 11:00:57', 'NA NGEN?', 1),
(52, 3, 8, NULL, '2023-12-02 11:11:34', 'hAHAH', 1);

-- --------------------------------------------------------

--
-- Table structure for table `passwordresets_table`
--

DROP TABLE IF EXISTS `passwordresets_table`;
CREATE TABLE IF NOT EXISTS `passwordresets_table` (
  `ResetId` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` text COLLATE utf8mb4_general_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`ResetId`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progressbasis_table`
--

DROP TABLE IF EXISTS `progressbasis_table`;
CREATE TABLE IF NOT EXISTS `progressbasis_table` (
  `ProgressBasisId` int NOT NULL AUTO_INCREMENT,
  `ProgressBasis` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `LowerLimit` int NOT NULL,
  `HigherLimit` int NOT NULL,
  PRIMARY KEY (`ProgressBasisId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progressbasis_table`
--

INSERT INTO `progressbasis_table` (`ProgressBasisId`, `ProgressBasis`, `LowerLimit`, `HigherLimit`) VALUES
(2, 'Poor Progress', 0, 19),
(3, 'Fair Progress', 20, 40),
(4, 'Good Progress', 41, 60),
(5, 'Very Good Progress', 61, 80),
(6, 'Excellent Progress ', 81, 100);

-- --------------------------------------------------------

--
-- Table structure for table `question_table`
--

DROP TABLE IF EXISTS `question_table`;
CREATE TABLE IF NOT EXISTS `question_table` (
  `QQId` int NOT NULL AUTO_INCREMENT,
  `QuizId` int NOT NULL,
  `Question` text COLLATE utf8mb4_general_ci NOT NULL,
  `ChoiceA` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ChoiceB` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ChoiceC` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ChoiceD` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Answer` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Status` int NOT NULL,
  `Points` double NOT NULL,
  PRIMARY KEY (`QQId`),
  KEY `QuizId` (`QuizId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_table`
--

INSERT INTO `question_table` (`QQId`, `QuizId`, `Question`, `ChoiceA`, `ChoiceB`, `ChoiceC`, `ChoiceD`, `Answer`, `Status`, `Points`) VALUES
(14, 1, 'What is the Sq of 4', '4', '3', '2', '6', 'C', 1, 5),
(15, 1, 'What is the Sq of 9', '2', '5', '3', '7', 'C', 1, 5),
(17, 4, 'What is calculus?', 'Wala lang', 'Calculator', 'Math', 'One of the Branches of Math', 'D', 1, 50),
(20, 5, 'Q1', 'sa', 'sdsf', 'ds', 'd', 'A', 1, 10),
(21, 5, 'zczc', 'zx', 'dc', 'ds', 'ds', 'C', 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_table`
--

DROP TABLE IF EXISTS `quiz_table`;
CREATE TABLE IF NOT EXISTS `quiz_table` (
  `QuizNo` int NOT NULL AUTO_INCREMENT,
  `TopicId` int DEFAULT NULL,
  `MaterialId` int DEFAULT NULL,
  `DatePosted` datetime NOT NULL,
  `DateLastModefied` datetime DEFAULT NULL,
  `PercentagePassing` double NOT NULL,
  `TotalItem` int NOT NULL,
  `Retaking` int NOT NULL DEFAULT '0',
  `Status` int NOT NULL,
  PRIMARY KEY (`QuizNo`),
  KEY `quiz_table_ibfk_1` (`MaterialId`),
  KEY `TopicId` (`TopicId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_table`
--

INSERT INTO `quiz_table` (`QuizNo`, `TopicId`, `MaterialId`, `DatePosted`, `DateLastModefied`, `PercentagePassing`, `TotalItem`, `Retaking`, `Status`) VALUES
(1, 5, 3, '2023-11-18 10:08:04', '2023-12-02 09:30:43', 76, 10, 1, 1),
(4, 5, NULL, '2023-11-20 10:13:03', NULL, 80, 50, 1, 1),
(5, 5, NULL, '2023-11-22 07:28:02', '2023-11-22 07:28:30', 75, 20, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles_table`
--

DROP TABLE IF EXISTS `roles_table`;
CREATE TABLE IF NOT EXISTS `roles_table` (
  `RoleId` int NOT NULL AUTO_INCREMENT,
  `Role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`RoleId`),
  UNIQUE KEY `ID` (`RoleId`),
  UNIQUE KEY `Role` (`Role`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles_table`
--

INSERT INTO `roles_table` (`RoleId`, `Role`) VALUES
(7, 'Admin'),
(8, 'Instructor'),
(9, 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `schoolyear_table`
--

DROP TABLE IF EXISTS `schoolyear_table`;
CREATE TABLE IF NOT EXISTS `schoolyear_table` (
  `SYCode` int NOT NULL AUTO_INCREMENT,
  `YearStart` int NOT NULL,
  `YearEnd` int NOT NULL,
  `Status` int NOT NULL,
  PRIMARY KEY (`SYCode`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schoolyear_table`
--

INSERT INTO `schoolyear_table` (`SYCode`, `YearStart`, `YearEnd`, `Status`) VALUES
(4, 2023, 2024, 1),
(6, 2025, 2026, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sectionsubject_table`
--

DROP TABLE IF EXISTS `sectionsubject_table`;
CREATE TABLE IF NOT EXISTS `sectionsubject_table` (
  `SectionId` int NOT NULL,
  `SubjectId` int NOT NULL,
  KEY `SectionId` (`SectionId`,`SubjectId`),
  KEY `SubjectId` (`SubjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sectionsubject_table`
--

INSERT INTO `sectionsubject_table` (`SectionId`, `SubjectId`) VALUES
(2, 63),
(2, 64),
(22, 63),
(22, 64),
(23, 63);

-- --------------------------------------------------------

--
-- Table structure for table `section_table`
--

DROP TABLE IF EXISTS `section_table`;
CREATE TABLE IF NOT EXISTS `section_table` (
  `SectionId` int NOT NULL AUTO_INCREMENT,
  `Section` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Status` int NOT NULL,
  PRIMARY KEY (`SectionId`),
  UNIQUE KEY `Section` (`Section`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_table`
--

INSERT INTO `section_table` (`SectionId`, `Section`, `Status`) VALUES
(2, '1-BSCE-A', 1),
(15, '1-BSCE-B', 1),
(22, '1-BSCE-C', 1),
(23, '2-BSCE-A', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_table`
--

DROP TABLE IF EXISTS `student_table`;
CREATE TABLE IF NOT EXISTS `student_table` (
  `StudentId` int NOT NULL AUTO_INCREMENT,
  `StudentIDNo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Firstname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Middlename` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Lastname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `NameExt` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `DateofBirth` date DEFAULT NULL,
  `Gender` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ContactNumber` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `EmailVerified` int NOT NULL,
  `VerificationCode` varchar(6) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Image` text COLLATE utf8mb4_general_ci,
  `DateRegistered` datetime NOT NULL,
  `Status` int NOT NULL,
  `StudentType` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`StudentId`),
  UNIQUE KEY `StudentIDNo` (`StudentIDNo`),
  UNIQUE KEY `VerificationCode` (`VerificationCode`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_table`
--

INSERT INTO `student_table` (`StudentId`, `StudentIDNo`, `Firstname`, `Middlename`, `Lastname`, `NameExt`, `DateofBirth`, `Gender`, `ContactNumber`, `Email`, `EmailVerified`, `VerificationCode`, `Image`, `DateRegistered`, `Status`, `StudentType`) VALUES
(7, '00079', 'Stud1Fname', 'S1', 'Stud1Lname', 'x', NULL, 'Female', '09132323265', 'stud1@mail.com', 1, NULL, 'img/stud/7.jpg', '2023-11-05 12:24:02', 1, NULL),
(8, '987654', 'Pedroh', 'P.', 'Penduko', '', NULL, 'Female', '0961626262626', 'stud2@mail.com', 1, NULL, NULL, '2023-11-27 08:54:56', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `studsection_table`
--

DROP TABLE IF EXISTS `studsection_table`;
CREATE TABLE IF NOT EXISTS `studsection_table` (
  `StudentId` int NOT NULL,
  `SectionId` int NOT NULL,
  `SYId` int NOT NULL,
  KEY `StudentId` (`StudentId`,`SectionId`,`SYId`),
  KEY `SectionId` (`SectionId`),
  KEY `studsection_table_ibfk_3` (`SYId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studsection_table`
--

INSERT INTO `studsection_table` (`StudentId`, `SectionId`, `SYId`) VALUES
(7, 2, 6),
(7, 15, 4),
(8, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `subject_table`
--

DROP TABLE IF EXISTS `subject_table`;
CREATE TABLE IF NOT EXISTS `subject_table` (
  `SubjectCode` int NOT NULL AUTO_INCREMENT,
  `Subject` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Description` text COLLATE utf8mb4_general_ci NOT NULL,
  `Status` int NOT NULL,
  PRIMARY KEY (`SubjectCode`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_table`
--

INSERT INTO `subject_table` (`SubjectCode`, `Subject`, `Description`, `Status`) VALUES
(63, 'Advance Algebra', 'Advance Algebra', 1),
(64, 'Calculus 1', 'Calculus 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `take_table`
--

DROP TABLE IF EXISTS `take_table`;
CREATE TABLE IF NOT EXISTS `take_table` (
  `TakeNo` int NOT NULL AUTO_INCREMENT,
  `StudentId` int NOT NULL,
  `QuizId` int NOT NULL,
  `DateTaken` datetime NOT NULL,
  `TotalScore` int DEFAULT NULL,
  `PassingScore` decimal(11,2) DEFAULT NULL,
  `Remarks` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Status` int NOT NULL,
  `DurationMinutes` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `SYId` int NOT NULL,
  PRIMARY KEY (`TakeNo`),
  KEY `StudentId` (`StudentId`),
  KEY `QuizId` (`QuizId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `take_table`
--

INSERT INTO `take_table` (`TakeNo`, `StudentId`, `QuizId`, `DateTaken`, `TotalScore`, `PassingScore`, `Remarks`, `Status`, `DurationMinutes`, `SYId`) VALUES
(9, 7, 1, '2023-11-18 09:08:59', 10, 7.60, 'Passed', 1, '00:09', 4),
(10, 7, 1, '2023-11-18 10:44:14', 0, 7.60, 'Failed', 1, '00:06', 4),
(11, 8, 1, '2023-12-02 04:46:04', 5, 7.60, 'Failed', 1, '00:10', 4);

-- --------------------------------------------------------

--
-- Table structure for table `topic_table`
--

DROP TABLE IF EXISTS `topic_table`;
CREATE TABLE IF NOT EXISTS `topic_table` (
  `TopicNo` int NOT NULL AUTO_INCREMENT,
  `SubjectId` int NOT NULL,
  `TopicDescription` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `InstructorId` int NOT NULL,
  `Status` int NOT NULL,
  PRIMARY KEY (`TopicNo`),
  UNIQUE KEY `TopicDescription` (`TopicDescription`),
  KEY `SubjectId` (`SubjectId`),
  KEY `InstructorId` (`InstructorId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topic_table`
--

INSERT INTO `topic_table` (`TopicNo`, `SubjectId`, `TopicDescription`, `InstructorId`, `Status`) VALUES
(5, 64, 'Derivatives', 19, 1),
(6, 64, 'Limits', 19, 1),
(7, 64, 'Functions', 19, 1),
(8, 63, 'Polynomials', 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `userroles_table`
--

DROP TABLE IF EXISTS `userroles_table`;
CREATE TABLE IF NOT EXISTS `userroles_table` (
  `UserRoleId` int NOT NULL AUTO_INCREMENT,
  `UserId` int NOT NULL,
  `RoleId` int NOT NULL,
  PRIMARY KEY (`UserRoleId`),
  KEY `RoleId` (`RoleId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userroles_table`
--

INSERT INTO `userroles_table` (`UserRoleId`, `UserId`, `RoleId`) VALUES
(14, 21, 7),
(15, 22, 8),
(16, 23, 9),
(17, 24, 9);

-- --------------------------------------------------------

--
-- Table structure for table `users_table`
--

DROP TABLE IF EXISTS `users_table`;
CREATE TABLE IF NOT EXISTS `users_table` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `StudentId` int DEFAULT NULL,
  `EmpId` int DEFAULT NULL,
  `Username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` text COLLATE utf8mb4_general_ci NOT NULL,
  `LastLogin` datetime DEFAULT NULL,
  `Status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Username` (`Username`),
  KEY `EmpId` (`EmpId`),
  KEY `users_table_ibfk_2` (`StudentId`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`UserId`, `StudentId`, `EmpId`, `Username`, `Password`, `LastLogin`, `Status`) VALUES
(21, NULL, NULL, 'admin', '$2y$10$YhF8Z4kpyoldAGqujXxXl.5U.bnMfd0uhNSECp3wcBaoO8tWDjide', '2025-01-30 01:33:52', 'active'),
(22, NULL, 19, 'ins1@mail.com', '$2y$10$QzEik8i0R9HQIszOAvDiouMjUDHvjCKLyxCn/0van.3WoCE0d65ci', '2023-11-27 07:59:32', 'active'),
(23, 7, NULL, 'stud1@mail.com', '$2y$10$TwDAO/UAnceXSKRcpxQYTuNIKGB.oeWCrtP2QbaX8XkoB8w8wN0pm', '2025-01-30 02:30:41', 'active'),
(24, 8, NULL, 'stud2@mail.com', '$2y$10$vSOWp/Av1p32sO27Ox4.O.Qp9kgATClP09Ev805Q4XYes3xs/FUNC', '2023-12-02 04:45:42', 'active');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer_table`
--
ALTER TABLE `answer_table`
  ADD CONSTRAINT `answer_table_ibfk_1` FOREIGN KEY (`TakeNo`) REFERENCES `take_table` (`TakeNo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answer_table_ibfk_2` FOREIGN KEY (`QuestionNo`) REFERENCES `question_table` (`QQId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chat_table`
--
ALTER TABLE `chat_table`
  ADD CONSTRAINT `chat_table_ibfk_1` FOREIGN KEY (`StudentId`) REFERENCES `student_table` (`StudentId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_table_ibfk_2` FOREIGN KEY (`InstructorId`) REFERENCES `employees_table` (`EmpKey`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `instructorload_table`
--
ALTER TABLE `instructorload_table`
  ADD CONSTRAINT `instructorload_table_ibfk_1` FOREIGN KEY (`InstructorId`) REFERENCES `employees_table` (`EmpKey`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `instructorload_table_ibfk_2` FOREIGN KEY (`SectionId`) REFERENCES `section_table` (`SectionId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `learningmaterials_table`
--
ALTER TABLE `learningmaterials_table`
  ADD CONSTRAINT `learningmaterials_table_ibfk_1` FOREIGN KEY (`CategoryId`) REFERENCES `learningmaterials_category_table` (`LMCatId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `learningmaterials_table_ibfk_2` FOREIGN KEY (`TopicId`) REFERENCES `topic_table` (`TopicNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `materialsload_table`
--
ALTER TABLE `materialsload_table`
  ADD CONSTRAINT `materialsload_table_ibfk_1` FOREIGN KEY (`InstructorLoadId`) REFERENCES `instructorload_table` (`LoadId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `materialsload_table_ibfk_2` FOREIGN KEY (`MaterialsId`) REFERENCES `learningmaterials_table` (`MaterialNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message_table`
--
ALTER TABLE `message_table`
  ADD CONSTRAINT `message_table_ibfk_1` FOREIGN KEY (`SenderStudent`) REFERENCES `student_table` (`StudentId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_table_ibfk_2` FOREIGN KEY (`SenderIns`) REFERENCES `employees_table` (`EmpKey`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_table_ibfk_3` FOREIGN KEY (`ChatId`) REFERENCES `chat_table` (`ChatId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `passwordresets_table`
--
ALTER TABLE `passwordresets_table`
  ADD CONSTRAINT `passwordresets_table_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_table` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question_table`
--
ALTER TABLE `question_table`
  ADD CONSTRAINT `question_table_ibfk_1` FOREIGN KEY (`QuizId`) REFERENCES `quiz_table` (`QuizNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_table`
--
ALTER TABLE `quiz_table`
  ADD CONSTRAINT `quiz_table_ibfk_1` FOREIGN KEY (`MaterialId`) REFERENCES `learningmaterials_table` (`MaterialNo`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `quiz_table_ibfk_2` FOREIGN KEY (`TopicId`) REFERENCES `topic_table` (`TopicNo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `sectionsubject_table`
--
ALTER TABLE `sectionsubject_table`
  ADD CONSTRAINT `sectionsubject_table_ibfk_1` FOREIGN KEY (`SectionId`) REFERENCES `section_table` (`SectionId`),
  ADD CONSTRAINT `sectionsubject_table_ibfk_2` FOREIGN KEY (`SubjectId`) REFERENCES `subject_table` (`SubjectCode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `studsection_table`
--
ALTER TABLE `studsection_table`
  ADD CONSTRAINT `studsection_table_ibfk_1` FOREIGN KEY (`StudentId`) REFERENCES `student_table` (`StudentId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studsection_table_ibfk_2` FOREIGN KEY (`SectionId`) REFERENCES `section_table` (`SectionId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studsection_table_ibfk_3` FOREIGN KEY (`SYId`) REFERENCES `schoolyear_table` (`SYCode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `take_table`
--
ALTER TABLE `take_table`
  ADD CONSTRAINT `take_table_ibfk_1` FOREIGN KEY (`StudentId`) REFERENCES `student_table` (`StudentId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `take_table_ibfk_2` FOREIGN KEY (`QuizId`) REFERENCES `quiz_table` (`QuizNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topic_table`
--
ALTER TABLE `topic_table`
  ADD CONSTRAINT `topic_table_ibfk_1` FOREIGN KEY (`SubjectId`) REFERENCES `subject_table` (`SubjectCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topic_table_ibfk_2` FOREIGN KEY (`InstructorId`) REFERENCES `employees_table` (`EmpKey`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userroles_table`
--
ALTER TABLE `userroles_table`
  ADD CONSTRAINT `userroles_table_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users_table` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userroles_table_ibfk_2` FOREIGN KEY (`RoleId`) REFERENCES `roles_table` (`RoleId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_table`
--
ALTER TABLE `users_table`
  ADD CONSTRAINT `users_table_ibfk_1` FOREIGN KEY (`EmpId`) REFERENCES `employees_table` (`EmpKey`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_table_ibfk_2` FOREIGN KEY (`StudentId`) REFERENCES `student_table` (`StudentId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
