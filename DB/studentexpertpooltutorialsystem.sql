-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 30, 2025 at 06:40 AM
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
