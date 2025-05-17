-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 08:19 AM
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
-- Database: `quizmgm`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `answer_text`, `is_correct`) VALUES
(1, 1, '34°C – 35°C', 0),
(2, 1, '35.5°C – 36°C', 0),
(3, 1, '36.1°C – 37.2°C', 1),
(4, 1, '37.5°C – 38°C', 0),
(5, 2, 'Loop of Henle', 0),
(6, 2, 'Collecting duct', 0),
(7, 2, 'Glomerulus', 1),
(8, 2, 'Distal convoluted tubule', 0),
(9, 3, 'Insulin', 1),
(10, 3, 'Adrenaline', 0),
(11, 3, 'Thyroxine', 0),
(12, 3, 'Estrogen', 0),
(13, 4, 'AB+', 0),
(14, 4, 'O+', 0),
(15, 4, 'A-', 0),
(16, 4, 'O-', 1),
(17, 5, 'Brain', 0),
(18, 5, 'Spinal cord', 0),
(19, 5, 'Nerves', 1),
(20, 5, 'Meninges', 0),
(21, 6, 'Bronchi', 0),
(22, 6, 'Alveoli', 1),
(23, 6, 'Trachea', 0),
(24, 6, 'Bronchioles', 0),
(25, 7, 'Ball and socket', 0),
(26, 7, 'Hinge', 1),
(27, 7, 'Pivot', 0),
(28, 7, 'Saddle', 0),
(29, 8, 'Vitamin A', 0),
(30, 8, 'Vitamin B', 0),
(31, 8, 'Vitamin C', 0),
(32, 8, 'Vitamin D', 1),
(33, 9, 'Melanin', 0),
(34, 9, 'Hemoglobin', 1),
(35, 9, 'Myoglobin', 0),
(36, 9, 'Keratin', 0),
(37, 10, 'Stomach', 0),
(38, 10, 'Large intestine', 0),
(39, 10, 'Esophagus', 0),
(40, 10, 'Small intestine', 1),
(41, 11, 'ans 1', 0),
(42, 11, 'ans 2', 1),
(43, 11, 'ans 3', 0),
(44, 11, 'ans 4', 0),
(45, 12, 'ans 1', 1),
(46, 12, 'ans 2', 0),
(47, 12, 'ans 3', 0),
(48, 12, 'ans 4', 0),
(49, 13, 'ans 1', 1),
(50, 13, 'ans 2', 0),
(51, 13, 'ans 3', 0),
(52, 13, 'ans 4', 0),
(53, 14, 'ans 1', 0),
(54, 14, 'ans 2', 0),
(55, 14, 'ans 3', 1),
(56, 14, 'ans 4', 0),
(57, 15, 'ans 1', 0),
(58, 15, 'ans 2', 0),
(59, 15, 'ans 3', 1),
(60, 15, 'ans 4', 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_session`
--

CREATE TABLE `login_session` (
  `id` char(40) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_session`
--

INSERT INTO `login_session` (`id`, `expire`, `data`) VALUES
('13ni0sghhaad7m7q8ntfit5p73', 1746787575, 0x5f5f666c6173687c613a303a7b7d),
('2k4h2m61q08ea0nbd04fig3v91', 1746096270, 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a34303b5f5f617574684b65797c733a33323a22712d3278586752575355567673593666477a7a615372324d6d507a7831506558223b),
('e32gb26alf7gpqgkna50j8uqoj', 1746078667, 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a34303b5f5f617574684b65797c733a33323a22712d3278586752575355567673593666477a7a615372324d6d507a7831506558223b),
('pd82pflg1gtu2vlbddh9qlctjc', 1746096220, 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a313b5f5f617574684b65797c733a33323a226752374d7236656d37426c5470525f4b325350655744504b7335367244655a4c223b),
('vlrgfddbn7j21jugpa5hjq7dqh', 1746882430, 0x5f5f666c6173687c613a303a7b7d);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `created_at`) VALUES
(3, 'Demo Session!', 'Now demo session is available for unpaid and new students.', '2025-03-17 10:29:38'),
(4, 'News 2', 'This is news 2 description', '2025-03-21 10:50:54'),
(5, 'News 3', 'This is news 3 description', '2025-03-21 10:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `qnumber` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `quiz_id`, `question_text`, `type`, `created_at`, `updated_at`, `qnumber`) VALUES
(1, 1, 'What is the normal range of human body temperature?', 'mcq', '2025-04-11 10:12:47', '2025-04-11 10:12:47', 1),
(2, 1, 'Which part of the nephron is responsible for filtration?', 'mcq', '2025-04-11 10:14:15', '2025-04-11 10:14:15', 2),
(3, 1, 'Which hormone regulates blood sugar levels?', 'mcq', '2025-04-11 10:15:07', '2025-04-11 10:15:07', 3),
(4, 1, 'What is the universal donor blood group?', 'mcq', '2025-04-11 10:16:33', '2025-04-11 10:16:33', 4),
(5, 1, 'Which of the following is not a part of the central nervous system?', 'mcq', '2025-04-11 10:17:23', '2025-04-11 10:17:23', 5),
(6, 1, 'The functional unit of the lungs is:', 'mcq', '2025-04-11 10:18:25', '2025-04-11 10:18:25', 6),
(7, 1, 'What type of joint is the knee joint?', 'mcq', '2025-04-11 10:19:18', '2025-04-11 10:19:18', 7),
(8, 1, 'Which vitamin is mainly synthesized by the skin in the presence of sunlight?', 'mcq', '2025-04-11 10:20:04', '2025-04-11 10:20:04', 8),
(9, 1, 'What is the name of the pigment that gives red blood cells their color?', 'mcq', '2025-04-11 10:21:03', '2025-04-11 10:21:03', 9),
(10, 1, 'Which part of the digestive system is responsible for most nutrient absorption?', 'mcq', '2025-04-11 10:21:58', '2025-04-11 10:21:58', 10),
(11, 2, 'This is question 1', 'mcq', '2025-04-15 06:33:27', '2025-04-15 06:33:27', 1),
(12, 2, 'This is question 2?', 'mcq', '2025-04-15 06:34:06', '2025-04-15 06:34:06', 2),
(13, 2, 'This is question 3', 'mcq', '2025-04-15 06:34:36', '2025-04-15 06:34:36', 3),
(14, 2, 'This is question 4', 'mcq', '2025-04-15 06:35:09', '2025-04-15 06:35:09', 4),
(15, 2, 'This is question 5', 'mcq', '2025-04-15 06:35:39', '2025-04-15 06:35:39', 5);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `duration_in_minutes` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `session_id`, `title`, `description`, `start_at`, `end_at`, `duration_in_minutes`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '01 - Quiz', 'This is just demo quiz.', '2025-04-01 15:10:00', '2025-05-31 15:10:00', 15, 'active', '2025-04-11 10:10:42', '2025-04-11 10:10:42'),
(2, 2, 'Demo Quiz', 'This is demo quiz.', '2025-04-01 11:32:00', '2025-05-30 11:32:00', 20, 'active', '2025-04-15 06:32:46', '2025-04-30 09:31:22'),
(3, 2, 'Test Quiz', '', '2025-04-01 15:39:00', '2025-04-30 15:39:00', 15, 'active', '2025-04-28 10:39:43', '2025-04-28 10:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_time_log`
--

CREATE TABLE `quiz_time_log` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `total_time` int(11) NOT NULL,
  `spend_time` int(11) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_time_log`
--

INSERT INTO `quiz_time_log` (`id`, `quiz_id`, `student_id`, `total_time`, `spend_time`, `start_time`, `log_time`, `created_at`, `updated_at`) VALUES
(2, 1, 35, 15, 214, '2025-04-11 15:30:00', '0000-00-00 00:00:00', '2025-04-11 10:30:00', '2025-04-11 10:35:25'),
(4, 1, 37, 15, 45, '2025-04-11 15:59:40', '0000-00-00 00:00:00', '2025-04-11 10:59:40', '2025-04-11 11:00:26'),
(10, 1, 34, 15, 110, '2025-04-14 16:47:34', '0000-00-00 00:00:00', '2025-04-14 11:47:34', '2025-04-14 11:49:29'),
(13, 2, 34, 5, 50, '2025-04-15 17:24:04', '0000-00-00 00:00:00', '2025-04-15 12:24:04', '2025-04-15 12:24:59'),
(14, 2, 39, 5, 25, '2025-04-28 16:21:31', '0000-00-00 00:00:00', '2025-04-28 11:21:31', '2025-04-28 11:21:57'),
(22, 3, 40, 15, 0, '2025-04-30 14:39:19', '2025-04-30 14:39:19', '2025-04-30 09:39:19', '2025-04-30 09:39:19'),
(27, 2, 40, 20, 40, '2025-04-30 15:43:45', '0000-00-00 00:00:00', '2025-04-30 10:43:45', '2025-04-30 10:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `reattempts`
--

CREATE TABLE `reattempts` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `reason` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reattempts`
--

INSERT INTO `reattempts` (`id`, `student_id`, `quiz_id`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 37, 1, 'reason', 1, '2025-04-11 10:59:16', '2025-04-11 10:59:29'),
(2, 34, 1, 'sfsad', 1, '2025-04-14 09:32:56', '2025-04-14 09:33:48'),
(3, 34, 1, 'h', 1, '2025-04-14 09:49:58', '2025-04-14 09:50:06'),
(4, 34, 1, 'sees', 1, '2025-04-14 10:05:50', '2025-04-14 10:05:55'),
(5, 34, 1, 'as', 1, '2025-04-14 10:23:25', '2025-04-14 10:23:34'),
(6, 34, 1, 'bsi ib', 1, '2025-04-14 10:30:59', '2025-04-14 11:15:01'),
(7, 34, 1, 'vaasd', 1, '2025-04-14 11:47:17', '2025-04-14 11:47:28'),
(8, 34, 2, 'asfds', 1, '2025-04-15 12:20:31', '2025-04-15 12:20:35'),
(9, 34, 2, 'aasd', 1, '2025-04-15 12:23:53', '2025-04-15 12:23:58'),
(10, 40, 2, 'need to be re attempt', 1, '2025-04-29 12:43:26', '2025-04-29 12:49:55'),
(11, 40, 2, 'Need to be improve', 1, '2025-04-29 12:52:02', '2025-04-29 12:52:14'),
(12, 40, 2, 'this is quiz need to be attempt', 1, '2025-04-29 12:55:42', '2025-04-29 12:56:33'),
(13, 40, 2, 'Un Attempted', 1, '2025-04-29 13:04:11', '2025-04-29 13:05:24'),
(14, 40, 2, 'g', 1, '2025-04-29 13:35:00', '2025-04-29 13:35:04'),
(15, 40, 2, 'Need to re Attempt', 1, '2025-04-30 09:32:16', '2025-04-30 09:32:21'),
(16, 40, 2, 'aad', 1, '2025-04-30 09:57:46', '2025-04-30 09:57:51'),
(17, 40, 2, 'assd', 1, '2025-04-30 10:29:51', '2025-04-30 10:29:56'),
(18, 40, 2, 'zx', 1, '2025-04-30 10:33:42', '2025-04-30 10:33:47'),
(19, 40, 2, 'aadsffsad', 1, '2025-04-30 10:40:08', '2025-04-30 10:40:16'),
(20, 40, 2, 'fsdads', 1, '2025-04-30 10:43:34', '2025-04-30 10:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `type`, `name`, `description`, `start_time`, `end_time`, `created_at`, `updated_at`, `status`) VALUES
(2, 'demo', 'Demo Session', 'This is demo session.', '2025-04-01 11:31:00', '2025-04-30 11:32:00', '2025-04-15 06:32:04', '2025-04-15 06:32:04', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `stream`
--

CREATE TABLE `stream` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `stream_url` text NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `meeting_id` varchar(50) NOT NULL,
  `meeting_passcode` varchar(50) NOT NULL,
  `stream_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stream`
--

INSERT INTO `stream` (`id`, `title`, `description`, `stream_url`, `start_time`, `end_time`, `active`, `meeting_id`, `meeting_passcode`, `stream_type`) VALUES
(1, 'First Stream', 'This is test stream', 'https://www.youtube.com/embed/i2KhSv96M5k?si=gU3-AGU5xsFNFuvK', '2025-04-28 15:50:00', '2025-04-28 16:52:00', 1, '87652797002', '630162', 'zoom');

-- --------------------------------------------------------

--
-- Table structure for table `student_response`
--

CREATE TABLE `student_response` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `student_answer` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_response`
--

INSERT INTO `student_response` (`id`, `student_id`, `question_id`, `answer_id`, `session_id`, `submitted_at`, `quiz_id`, `created_at`, `student_answer`) VALUES
(11, 35, 1, 3, 1, '2025-04-11 10:30:04', 1, '2025-04-11 15:30:05', '36.1°C – 37.2°C'),
(12, 35, 2, 7, 1, '2025-04-11 10:33:20', 1, '2025-04-11 15:33:23', 'Glomerulus'),
(13, 35, 3, 9, 1, '2025-04-11 10:34:39', 1, '2025-04-11 15:34:40', 'Insulin'),
(14, 35, 4, 13, 1, '2025-04-11 10:35:05', 1, '2025-04-11 15:35:10', 'AB+'),
(15, 35, 5, 19, 1, '2025-04-11 10:35:10', 1, '2025-04-11 15:35:12', 'Nerves'),
(16, 35, 6, 24, 1, '2025-04-11 10:35:12', 1, '2025-04-11 15:35:15', 'Bronchioles'),
(17, 35, 7, 25, 1, '2025-04-11 10:35:15', 1, '2025-04-11 15:35:19', 'Ball and socket'),
(18, 35, 8, 32, 1, '2025-04-11 10:35:19', 1, '2025-04-11 15:35:20', 'Vitamin D'),
(19, 35, 9, 34, 1, '2025-04-11 10:35:24', 1, '2025-04-11 15:35:25', 'Hemoglobin'),
(20, 35, 10, 40, 1, '2025-04-11 10:35:27', 1, '2025-04-11 15:35:27', 'Small intestine'),
(29, 37, 1, 3, 0, '2025-04-11 10:59:45', 1, '2025-04-11 15:59:46', '36.1°C – 37.2°C'),
(30, 37, 2, 7, 0, '2025-04-11 10:59:50', 1, '2025-04-11 15:59:51', 'Glomerulus'),
(31, 37, 3, 9, 0, '2025-04-11 10:59:54', 1, '2025-04-11 15:59:56', 'Insulin'),
(32, 37, 4, 13, 0, '2025-04-11 10:59:59', 1, '2025-04-11 16:00:01', 'AB+'),
(33, 37, 5, 19, 0, '2025-04-11 11:00:05', 1, '2025-04-11 16:00:06', 'Nerves'),
(34, 37, 6, 23, 0, '2025-04-11 11:00:09', 1, '2025-04-11 16:00:11', 'Trachea'),
(35, 37, 7, 26, 0, '2025-04-11 11:00:14', 1, '2025-04-11 16:00:16', 'Hinge'),
(36, 37, 8, 32, 0, '2025-04-11 11:00:17', 1, '2025-04-11 16:00:21', 'Vitamin D'),
(37, 37, 9, 34, 0, '2025-04-11 11:00:24', 1, '2025-04-11 16:00:26', 'Hemoglobin'),
(38, 37, 10, 40, 0, '2025-04-11 11:00:28', 1, '2025-04-11 16:00:28', 'Small intestine'),
(52, 34, 1, 3, 0, '2025-04-14 11:47:53', 1, '2025-04-14 16:47:56', '36.1°C – 37.2°C'),
(53, 34, 2, 7, 0, '2025-04-14 11:47:56', 1, '2025-04-14 16:47:59', 'Glomerulus'),
(54, 34, 3, 12, 0, '2025-04-14 11:47:59', 1, '2025-04-14 16:48:01', 'Estrogen'),
(55, 34, 4, 16, 0, '2025-04-14 11:48:02', 1, '2025-04-14 16:48:04', 'O-'),
(56, 34, 5, 19, 0, '2025-04-14 11:48:04', 1, '2025-04-14 16:48:06', 'Nerves'),
(57, 34, 6, 22, 0, '2025-04-14 11:48:06', 1, '2025-04-14 16:48:08', 'Alveoli'),
(58, 34, 7, 25, 0, '2025-04-14 11:48:08', 1, '2025-04-14 16:48:11', 'Ball and socket'),
(59, 34, 9, 36, 0, '2025-04-14 11:48:17', 1, '2025-04-14 16:48:21', 'Keratin'),
(60, 34, 10, 40, 0, '2025-04-14 11:48:21', 1, '2025-04-14 16:48:26', 'Small intestine'),
(61, 34, 8, 32, 0, '2025-04-14 11:49:31', 1, '2025-04-14 16:49:31', 'Vitamin D'),
(69, 34, 11, 41, 0, '2025-04-15 12:24:08', 2, '2025-04-15 17:24:10', 'ans 1'),
(70, 34, 12, 48, 0, '2025-04-15 12:24:34', 2, '2025-04-15 17:24:39', 'ans 4'),
(71, 34, 15, 60, 0, '2025-04-15 12:24:50', 2, '2025-04-15 17:24:54', 'ans 4'),
(72, 34, 13, 52, 0, '2025-04-15 12:24:58', 2, '2025-04-15 17:24:59', 'ans 4'),
(73, 34, 14, 56, 0, '2025-04-15 12:25:02', 2, '2025-04-15 17:25:02', 'ans 4'),
(74, 39, 11, 41, 0, '2025-04-28 11:21:41', 2, '2025-04-28 16:21:42', 'ans 1'),
(75, 39, 14, 55, 0, '2025-04-28 11:21:47', 2, '2025-04-28 16:21:52', 'ans 3'),
(117, 40, 11, 41, 0, '2025-04-30 10:43:56', 2, '2025-04-30 15:43:57', 'ans 1'),
(118, 40, 13, 52, 0, '2025-04-30 10:44:00', 2, '2025-04-30 15:44:02', 'ans 4'),
(119, 40, 15, 57, 0, '2025-04-30 10:44:05', 2, '2025-04-30 15:44:07', 'ans 1'),
(120, 40, 12, 47, 0, '2025-04-30 10:44:17', 2, '2025-04-30 15:44:22', 'ans 3'),
(121, 40, 14, 56, 0, '2025-04-30 10:44:29', 2, '2025-04-30 15:44:29', 'ans 4');

-- --------------------------------------------------------

--
-- Table structure for table `student_session_assignment`
--

CREATE TABLE `student_session_assignment` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `assigned_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_session_assignment`
--

INSERT INTO `student_session_assignment` (`id`, `student_id`, `session_id`, `assigned_at`) VALUES
(1, 34, 1, '2025-04-11 15:22:30'),
(2, 35, 1, '2025-04-11 15:29:54'),
(3, 37, 1, '2025-04-11 15:56:37'),
(4, 34, 2, '2025-04-15 11:35:52'),
(5, 39, 2, '2025-04-28 16:18:50'),
(6, 40, 2, '2025-04-29 17:30:26');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` int(11) DEFAULT NULL,
  `otp_expire` datetime DEFAULT NULL,
  `email_verified` datetime DEFAULT NULL,
  `status` varchar(100) DEFAULT 'active',
  `fee_paid` varchar(100) NOT NULL DEFAULT 'no',
  `usertype` varchar(100) NOT NULL DEFAULT 'student',
  `password_hash` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `full_name` varchar(100) DEFAULT NULL,
  `number` varchar(100) DEFAULT NULL,
  `cnic` varchar(100) DEFAULT NULL,
  `cnic_front` text NOT NULL,
  `cnic_back` text NOT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `father_name` varchar(255) NOT NULL,
  `uni` text NOT NULL,
  `workplace` varchar(255) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `register_for` varchar(500) NOT NULL,
  `timeout` datetime DEFAULT NULL,
  `last_user_agent` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `login_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `otp`, `otp_expire`, `email_verified`, `status`, `fee_paid`, `usertype`, `password_hash`, `auth_key`, `created_at`, `updated_at`, `full_name`, `number`, `cnic`, `cnic_front`, `cnic_back`, `gender`, `father_name`, `uni`, `workplace`, `city`, `register_for`, `timeout`, `last_user_agent`, `ip`, `session_id`, `login_time`) VALUES
(1, 'admin@gmail.com', 'admin@gmail.com', NULL, NULL, '2025-03-16 15:54:25', 'active', 'no', 'admin', '$2y$12$OTWISbC/GZyYaqbiMbFiWu3NbRpSTbc8adSiHdg8GcYvqSCqaK69K', 'gR7Mr6em7BlTpR_K2SPeWDPKs56rDeZL', '2024-10-02 18:50:14', '2025-04-30 09:24:21', '', '', NULL, '', '', NULL, '', '', '', '', '2', '2025-05-01 14:24:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '::1', 'pd82pflg1gtu2vlbddh9qlctjc', '2025-04-30 14:24:21'),
(3, 'client@gmail.com', 'client@gmail.com', NULL, NULL, NULL, 'active', 'no', 'student', '$2y$13$7CLgw52uhWfY20Ts/qvTUOw99rkAR7I.7MWwXIzeo.K6zuDqkKZnS', 'SEQ-qIFkFH1Qb2msS5ZflGb3UIHmLOpy', '2024-10-09 01:41:41', '2024-10-09 01:41:41', 'adsf', '98989', NULL, '', '', NULL, '', '', '', 'kjkjkj', '1,2', NULL, '', '', '', NULL),
(4, 'rmabsone2@gmail.com', 'rmabsone2@gmail.com', NULL, NULL, NULL, 'active', 'yes', 'student', '$2y$13$Kql3DzOPwujJ8b6BOg2IcObPHMXSashzYMTeGifDZBT.zM8t6UoX.', 'wRAonzCN27aEZfpXqXMPUdiowtVeDdRS', '2024-10-09 01:42:42', '2024-10-10 18:36:44', 'Muhammad Ali Baig', 'adf', NULL, '', '', NULL, '', '', '', 'Islamabad', '1,2', NULL, '', '', '', NULL),
(5, 'admin@user.com', 'admin@user.com', NULL, NULL, NULL, 'active', 'no', 'admin', '$2y$13$xagvmBY9C3EAXlAP7OEa1eayRNUGppCisr58vEujboNsrNrXKPe5m', '4YA8X-6b2dUdj0fSBmvq5m5ZotlF2cHn', '2024-10-10 10:03:14', '2024-10-10 10:10:34', 'Muhammad Ali Baig', '03365359967', NULL, '', '', NULL, '', '', '', 'Islamabad', '1', NULL, '', '', '', NULL),
(6, 'student@user.com', 'student@user.com', NULL, NULL, NULL, 'active', 'yes', 'student', '$2y$13$DAXLh1Ve2qnS.qqniNACtOh9ZpGQcoZHSTaBs.P2Dz3UvhbGkCAQG', 'FDF93mH6uvb-fdNeC5gQNEL6KvauD-N4', '2024-10-10 12:30:53', '2024-10-10 15:50:12', 'student name', '98989', NULL, '', '', NULL, '', '', '', 'alialiali', '3', NULL, '', '', '', NULL),
(7, 'rmabsone2@gmail.comali', 'rmabsone2@gmail.comali', NULL, NULL, NULL, 'active', 'no', 'admin', '$2y$13$k9w4n7B.CK3AOMr1lWTVK.sGWU/oZ8Ix1kEWoBwcMlt9vy.Gxbg4u', '0Im0MG_Pem-invUpdMsMNWbUlG3_5zG0', '2024-10-10 15:38:33', '2024-10-10 15:48:56', 'Muhammad Ali Baig', '03365359967', NULL, '', '', NULL, '', '', '', 'Islamabad', '1,2,3', NULL, '', '', '', NULL),
(8, 'jibran@gmail.com', 'jibran@gmail.com', NULL, NULL, NULL, 'active', 'yes', 'student', '$2y$13$nuDS17AB8Qrl63mpNc7HoewKrlTY7FfGqiicnk0/H09QCB0/hC2Bm', 'O8tvlKyhN7BIQZZB7OWlsOF5-WruNOsg', '2024-10-10 18:27:52', '2024-10-10 18:31:03', 'jibran', '9898', NULL, '', '', NULL, '', '', '', 'islamabd', '4', NULL, '', '', '', NULL),
(9, 'gg@student.com', 'gg@student.com', NULL, NULL, NULL, 'active', 'yes', 'student', '$2y$13$dcSLQAGXDKgU86SDe8v6G.L8batiSAG1xJbghE76xgWykWBGsnb2i', 'CRvGT0sElysafRRGhKseupgfvwg-fdl6', '2024-10-10 19:03:26', '2024-10-21 14:59:28', 'Muhammad Ali Baig', '03365359967', NULL, '', '', NULL, '', '', '', 'Islamabad', '6', NULL, '', '', '', NULL),
(31, 'rmabsone@gmail.com', 'rmabsone@gmail.com', 607406, '2025-03-17 16:08:14', '2025-03-17 16:04:01', 'active', 'no', 'student', '$2y$13$/jP31q3R2VvJqgwz81/IvOTDgckO7iV3EnTuuBPqZkoXEKyt4Q6Ai', 'Rezqnj61EmTFiE231_BAEVU7WsEtUY-o', '2025-03-17 11:03:14', '2025-03-17 11:04:40', 'Ali', '03000000000', NULL, '', '', NULL, '', '', '', 'Rawalpindi', '7', '2025-03-18 16:03:42', '', '', '', NULL),
(35, 'shoaibshokat100@gmail.com', 'shoaibshokat100@gmail.com', 37705, '2025-04-11 15:33:32', '2025-04-11 15:29:53', 'active', 'no', 'student', '$2y$13$8nBWii7fRfiRVW53WmIpWu9hNHthT.ip4p6fb37J7Nh4zoHoAd8aO', 'IjH6FiQc_hf6X1d6pOSSdu24ScSPPurs', '2025-04-11 10:28:32', '2025-04-11 10:29:53', 'Muhammad Shoaib', '03011840378', '36602-0000000-1', '', '', 'male', 'Shokat Ali', 'CUV', 'HOME', 'Vehari', '1', '2025-04-12 15:29:16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '::1', 'gd9rl5pbsus5dfdm0ung9md9ij', '2025-04-11 15:29:16'),
(36, 'hamidwawan68@gmail.com', 'hamidwawan68@gmail.com', 968768, '2025-04-11 15:58:19', NULL, 'active', 'no', 'student', '$2y$13$ukOcfWnQRkDT9u5cA7KX0O98sIL9kaZiLwg1mZRKochqqaESOvLUq', 'fsfQw4XPrRJpf2wNKkDP-j8ZixcxoPy2', '2025-04-11 10:53:19', '2025-04-11 10:53:37', 'Muhammad Hamid', '03115328886', '3600000000000', '', '', 'male', 'Attique', 'ABC', 'ONLINE', 'Islamabad Capital Territory', '1', '2025-04-12 15:53:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '192.168.18.143', 'dhg6vu4o5k8tj528rc40b3dh4s', '2025-04-11 15:53:37'),
(40, 'shoaibshokat6@gmail.com', 'shoaibshokat6@gmail.com', 165622, '2025-04-29 17:34:50', '2025-04-29 17:30:26', 'active', 'no', 'student', '$2y$13$jZt7SrYwcSB7oFTlh3EFN.w8NXA2SquMJxZe6gKbjBaM5W75uvk26', 'q-2xXgRWSUVvsY6fGzzaSr2MmPzx1PeX', '2025-04-29 12:29:50', '2025-04-30 09:23:40', 'Muhammad Shoaib 001', '03011840378', '36602-0000000-1', '', '', 'male', 'Shokat Ali', 'CUV', 'HOME', 'Vehari', '2', '2025-05-01 14:23:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '::1', '2k4h2m61q08ea0nbd04fig3v91', '2025-04-30 14:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_images`
--

CREATE TABLE `user_images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_images`
--

INSERT INTO `user_images` (`id`, `user_id`, `file_path`, `created_at`) VALUES
(1, 5, 'uploads/6707ae73719e5.jfif', '2024-10-10 10:37:39'),
(2, 5, 'uploads/6707ae7af332c.png', '2024-10-10 10:37:47'),
(4, 5, 'uploads/6707aea462fae.png', '2024-10-10 10:38:28'),
(5, 5, 'uploads/6707aeaa800a0.png', '2024-10-10 10:38:34'),
(6, 6, 'uploads/6707ca7717782.png', '2024-10-10 12:37:11'),
(7, 7, 'uploads/6707f71cca307.jfif', '2024-10-10 15:47:40'),
(8, 8, 'uploads/67081d21be007.png', '2024-10-10 18:29:53'),
(9, 9, 'uploads/67082577b404e.png', '2024-10-10 19:05:27');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `description` varchar(500) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_session`
--
ALTER TABLE `login_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_time_log`
--
ALTER TABLE `quiz_time_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reattempts`
--
ALTER TABLE `reattempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stream`
--
ALTER TABLE `stream`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_response`
--
ALTER TABLE `student_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_session_assignment`
--
ALTER TABLE `student_session_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_images`
--
ALTER TABLE `user_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_time_log`
--
ALTER TABLE `quiz_time_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reattempts`
--
ALTER TABLE `reattempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stream`
--
ALTER TABLE `stream`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_response`
--
ALTER TABLE `student_response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `student_session_assignment`
--
ALTER TABLE `student_session_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user_images`
--
ALTER TABLE `user_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
