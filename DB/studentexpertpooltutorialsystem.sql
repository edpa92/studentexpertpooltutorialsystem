-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 02, 2023 at 03:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


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
-- Creation: Nov 18, 2023 at 06:57 PM
-- Last update: Dec 02, 2023 at 04:46 PM
--

CREATE TABLE IF NOT EXISTS `answer_table` (
  `AnsId` int(11) NOT NULL AUTO_INCREMENT,
  `TakeNo` int(11) NOT NULL,
  `QuestionNo` int(11) NOT NULL,
  `ChoiceAns` varchar(100) NOT NULL,
  `IsCorrect` int(11) NOT NULL,
  PRIMARY KEY (`AnsId`),
  KEY `TakeNo` (`TakeNo`),
  KEY `QuestionNo` (`QuestionNo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `answer_table`:
--   `TakeNo`
--       `take_table` -> `TakeNo`
--   `QuestionNo`
--       `question_table` -> `QQId`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_table`
--
-- Creation: Nov 27, 2023 at 07:25 PM
--

CREATE TABLE IF NOT EXISTS `chat_table` (
  `ChatId` int(11) NOT NULL AUTO_INCREMENT,
  `StudentId` int(11) NOT NULL,
  `InstructorId` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `MeetingId` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ChatId`),
  UNIQUE KEY `MeetingId` (`MeetingId`),
  KEY `StudentId` (`StudentId`),
  KEY `InstructorId` (`InstructorId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `chat_table`:
--   `StudentId`
--       `student_table` -> `StudentId`
--   `InstructorId`
--       `employees_table` -> `EmpKey`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `employees_table` (
  `EmpKey` int(11) NOT NULL AUTO_INCREMENT,
  `EmpId` varchar(50) DEFAULT NULL,
  `Firstname` varchar(100) NOT NULL,
  `MI` varchar(100) DEFAULT NULL,
  `Lastname` varchar(100) NOT NULL,
  `NameExt` varchar(10) DEFAULT NULL,
  `Designation` varchar(300) DEFAULT NULL,
  `Gender` varchar(100) DEFAULT NULL,
  `Contact` varchar(100) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Photo` text DEFAULT NULL,
  `TypeOfService` varchar(100) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL,
  `Academic Qualifications` text DEFAULT NULL,
  `MaximumLoad` int(11) DEFAULT NULL,
  `Verified` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`EmpKey`),
  UNIQUE KEY `EmpId` (`EmpId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `employees_table`:
--

-- --------------------------------------------------------

--
-- Table structure for table `instructorload_table`
--
-- Creation: Nov 11, 2023 at 05:32 PM
--

CREATE TABLE IF NOT EXISTS `instructorload_table` (
  `LoadId` int(11) NOT NULL AUTO_INCREMENT,
  `InstructorId` int(11) NOT NULL,
  `SectionId` int(11) NOT NULL,
  PRIMARY KEY (`LoadId`),
  KEY `InstructorId` (`InstructorId`),
  KEY `instructorload_table_ibfk_2` (`SectionId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `instructorload_table`:
--   `InstructorId`
--       `employees_table` -> `EmpKey`
--   `SectionId`
--       `section_table` -> `SectionId`
--

-- --------------------------------------------------------

--
-- Table structure for table `learningmaterials_category_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `learningmaterials_category_table` (
  `LMCatId` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(500) NOT NULL,
  PRIMARY KEY (`LMCatId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `learningmaterials_category_table`:
--

-- --------------------------------------------------------

--
-- Table structure for table `learningmaterials_table`
--
-- Creation: Nov 19, 2023 at 02:18 PM
-- Last update: Nov 28, 2023 at 08:46 PM
--

CREATE TABLE IF NOT EXISTS `learningmaterials_table` (
  `MaterialNo` int(11) NOT NULL AUTO_INCREMENT,
  `TopicId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `MaterialsDescription` text NOT NULL,
  `URL` text DEFAULT NULL,
  `Path` text DEFAULT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`MaterialNo`),
  KEY `learningmaterials_table_ibfk_1` (`CategoryId`),
  KEY `TopicId` (`TopicId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `learningmaterials_table`:
--   `CategoryId`
--       `learningmaterials_category_table` -> `LMCatId`
--   `TopicId`
--       `topic_table` -> `TopicNo`
--

-- --------------------------------------------------------

--
-- Table structure for table `materialsload_table`
--
-- Creation: Nov 11, 2023 at 07:32 PM
-- Last update: Nov 28, 2023 at 08:46 PM
--

CREATE TABLE IF NOT EXISTS `materialsload_table` (
  `InstructorLoadId` int(11) NOT NULL,
  `MaterialsId` int(11) NOT NULL,
  KEY `InstructorLoadId` (`InstructorLoadId`),
  KEY `MaterialsId` (`MaterialsId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `materialsload_table`:
--   `InstructorLoadId`
--       `instructorload_table` -> `LoadId`
--   `MaterialsId`
--       `learningmaterials_table` -> `MaterialNo`
--

-- --------------------------------------------------------

--
-- Table structure for table `message_table`
--
-- Creation: Nov 25, 2023 at 08:34 PM
-- Last update: Dec 02, 2023 at 11:12 PM
--

CREATE TABLE IF NOT EXISTS `message_table` (
  `MessageId` int(11) NOT NULL AUTO_INCREMENT,
  `ChatId` int(11) NOT NULL,
  `SenderStudent` int(11) DEFAULT NULL,
  `SenderIns` int(11) DEFAULT NULL,
  `SendDateTime` datetime NOT NULL,
  `Message` text NOT NULL,
  `Viewed` int(11) NOT NULL,
  PRIMARY KEY (`MessageId`),
  KEY `SenderStudent` (`SenderStudent`),
  KEY `SenderIns` (`SenderIns`),
  KEY `ChatId` (`ChatId`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `message_table`:
--   `SenderStudent`
--       `student_table` -> `StudentId`
--   `SenderIns`
--       `employees_table` -> `EmpKey`
--   `ChatId`
--       `chat_table` -> `ChatId`
--

-- --------------------------------------------------------

--
-- Table structure for table `passwordresets_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `passwordresets_table` (
  `ResetId` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` text NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`ResetId`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `passwordresets_table`:
--   `user_id`
--       `users_table` -> `UserId`
--

-- --------------------------------------------------------

--
-- Table structure for table `question_table`
--
-- Creation: Nov 13, 2023 at 08:37 AM
--

CREATE TABLE IF NOT EXISTS `question_table` (
  `QQId` int(11) NOT NULL AUTO_INCREMENT,
  `QuizId` int(11) NOT NULL,
  `Question` text NOT NULL,
  `ChoiceA` varchar(100) NOT NULL,
  `ChoiceB` varchar(100) NOT NULL,
  `ChoiceC` varchar(100) NOT NULL,
  `ChoiceD` varchar(100) NOT NULL,
  `Answer` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `Points` double NOT NULL,
  PRIMARY KEY (`QQId`),
  KEY `QuizId` (`QuizId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `question_table`:
--   `QuizId`
--       `quiz_table` -> `QuizNo`
--

-- --------------------------------------------------------

--
-- Table structure for table `quiz_table`
--
-- Creation: Dec 02, 2023 at 08:22 PM
-- Last update: Dec 02, 2023 at 09:30 PM
--

CREATE TABLE IF NOT EXISTS `quiz_table` (
  `QuizNo` int(11) NOT NULL AUTO_INCREMENT,
  `TopicId` int(11) DEFAULT NULL,
  `MaterialId` int(11) DEFAULT NULL,
  `DatePosted` datetime NOT NULL,
  `DateLastModefied` datetime DEFAULT NULL,
  `PercentagePassing` double NOT NULL,
  `TotalItem` int(11) NOT NULL,
  `Retaking` int(11) NOT NULL DEFAULT 0,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`QuizNo`),
  KEY `quiz_table_ibfk_1` (`MaterialId`),
  KEY `TopicId` (`TopicId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `quiz_table`:
--   `MaterialId`
--       `learningmaterials_table` -> `MaterialNo`
--   `TopicId`
--       `topic_table` -> `TopicNo`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `roles_table` (
  `RoleId` int(11) NOT NULL AUTO_INCREMENT,
  `Role` varchar(50) NOT NULL,
  PRIMARY KEY (`RoleId`),
  UNIQUE KEY `ID` (`RoleId`),
  UNIQUE KEY `Role` (`Role`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `roles_table`:
--

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
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `schoolyear_table` (
  `SYCode` int(11) NOT NULL AUTO_INCREMENT,
  `YearStart` int(11) NOT NULL,
  `YearEnd` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`SYCode`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `schoolyear_table`:
--

-- --------------------------------------------------------

--
-- Table structure for table `sectionsubject_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `sectionsubject_table` (
  `SectionId` int(11) NOT NULL,
  `SubjectId` int(11) NOT NULL,
  KEY `SectionId` (`SectionId`,`SubjectId`),
  KEY `SubjectId` (`SubjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `sectionsubject_table`:
--   `SectionId`
--       `section_table` -> `SectionId`
--   `SubjectId`
--       `subject_table` -> `SubjectCode`
--

-- --------------------------------------------------------

--
-- Table structure for table `section_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `section_table` (
  `SectionId` int(11) NOT NULL AUTO_INCREMENT,
  `Section` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`SectionId`),
  UNIQUE KEY `Section` (`Section`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `section_table`:
--

-- --------------------------------------------------------

--
-- Table structure for table `student_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `student_table` (
  `StudentId` int(11) NOT NULL AUTO_INCREMENT,
  `StudentIDNo` varchar(100) NOT NULL,
  `Firstname` varchar(100) NOT NULL,
  `Middlename` varchar(100) DEFAULT NULL,
  `Lastname` varchar(100) NOT NULL,
  `NameExt` varchar(10) DEFAULT NULL,
  `DateofBirth` date DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `ContactNumber` varchar(50) DEFAULT NULL,
  `Email` varchar(50) NOT NULL,
  `EmailVerified` int(11) NOT NULL,
  `VerificationCode` varchar(6) DEFAULT NULL,
  `Image` text DEFAULT NULL,
  `DateRegistered` datetime NOT NULL,
  `Status` int(11) NOT NULL,
  `StudentType` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`StudentId`),
  UNIQUE KEY `StudentIDNo` (`StudentIDNo`),
  UNIQUE KEY `VerificationCode` (`VerificationCode`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `student_table`:
--

-- --------------------------------------------------------

--
-- Table structure for table `studsection_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
-- Last update: Dec 02, 2023 at 12:41 PM
--

CREATE TABLE IF NOT EXISTS `studsection_table` (
  `StudentId` int(11) NOT NULL,
  `SectionId` int(11) NOT NULL,
  `SYId` int(11) NOT NULL,
  KEY `StudentId` (`StudentId`,`SectionId`,`SYId`),
  KEY `SectionId` (`SectionId`),
  KEY `studsection_table_ibfk_3` (`SYId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `studsection_table`:
--   `StudentId`
--       `student_table` -> `StudentId`
--   `SectionId`
--       `section_table` -> `SectionId`
--   `SYId`
--       `schoolyear_table` -> `SYCode`
--

-- --------------------------------------------------------

--
-- Table structure for table `subject_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `subject_table` (
  `SubjectCode` int(11) NOT NULL AUTO_INCREMENT,
  `Subject` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`SubjectCode`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `subject_table`:
--

-- --------------------------------------------------------

--
-- Table structure for table `take_table`
--
-- Creation: Nov 18, 2023 at 08:14 PM
-- Last update: Dec 02, 2023 at 04:46 PM
--

CREATE TABLE IF NOT EXISTS `take_table` (
  `TakeNo` int(11) NOT NULL AUTO_INCREMENT,
  `StudentId` int(11) NOT NULL,
  `QuizId` int(11) NOT NULL,
  `DateTaken` datetime NOT NULL,
  `TotalScore` int(11) DEFAULT NULL,
  `PassingScore` decimal(11,2) DEFAULT NULL,
  `Remarks` varchar(100) DEFAULT NULL,
  `Status` int(11) NOT NULL,
  `DurationMinutes` varchar(100) NOT NULL,
  PRIMARY KEY (`TakeNo`),
  KEY `StudentId` (`StudentId`),
  KEY `QuizId` (`QuizId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `take_table`:
--   `StudentId`
--       `student_table` -> `StudentId`
--   `QuizId`
--       `quiz_table` -> `QuizNo`
--

-- --------------------------------------------------------

--
-- Table structure for table `topic_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `topic_table` (
  `TopicNo` int(11) NOT NULL AUTO_INCREMENT,
  `SubjectId` int(11) NOT NULL,
  `TopicDescription` text NOT NULL,
  `InstructorId` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  PRIMARY KEY (`TopicNo`),
  UNIQUE KEY `TopicDescription` (`TopicDescription`) USING HASH,
  KEY `SubjectId` (`SubjectId`),
  KEY `InstructorId` (`InstructorId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `topic_table`:
--   `SubjectId`
--       `subject_table` -> `SubjectCode`
--   `InstructorId`
--       `employees_table` -> `EmpKey`
--

-- --------------------------------------------------------

--
-- Table structure for table `userroles_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
--

CREATE TABLE IF NOT EXISTS `userroles_table` (
  `UserRoleId` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  PRIMARY KEY (`UserRoleId`),
  KEY `RoleId` (`RoleId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `userroles_table`:
--   `UserId`
--       `users_table` -> `UserId`
--   `RoleId`
--       `roles_table` -> `RoleId`
--

--
-- Dumping data for table `userroles_table`
--

INSERT INTO `userroles_table` (`UserRoleId`, `UserId`, `RoleId`) VALUES
(14, 21, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users_table`
--
-- Creation: Nov 09, 2023 at 12:10 PM
-- Last update: Dec 02, 2023 at 04:45 PM
--

CREATE TABLE IF NOT EXISTS `users_table` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `StudentId` int(11) DEFAULT NULL,
  `EmpId` int(11) DEFAULT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` text NOT NULL,
  `LastLogin` datetime DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Username` (`Username`),
  KEY `EmpId` (`EmpId`),
  KEY `users_table_ibfk_2` (`StudentId`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `users_table`:
--   `EmpId`
--       `employees_table` -> `EmpKey`
--   `StudentId`
--       `student_table` -> `StudentId`
--

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`UserId`, `StudentId`, `EmpId`, `Username`, `Password`, `LastLogin`, `Status`) VALUES
(21, NULL, NULL, 'admin', '$2y$10$YhF8Z4kpyoldAGqujXxXl.5U.bnMfd0uhNSECp3wcBaoO8tWDjide', '2023-11-27 09:04:45', 'active');

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
