-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2023 at 06:53 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accr_rav`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_documents`
--

CREATE TABLE `add_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `section_id` varchar(255) DEFAULT NULL,
  `doc_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `doc_file` varchar(560) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `add_documents`
--

INSERT INTO `add_documents` (`id`, `application_id`, `course_id`, `section_id`, `doc_id`, `status`, `created_at`, `updated_at`, `doc_file`) VALUES
(12, NULL, NULL, NULL, NULL, NULL, '2023-06-08 05:20:33', '2023-06-08 05:20:33', NULL),
(13, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:22:52', '2023-06-08 05:22:52', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5).pdf'),
(14, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:27:36', '2023-06-08 05:27:36', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5).pdf'),
(15, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:29:31', '2023-06-08 05:29:31', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5) (1).pdf'),
(16, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:29:59', '2023-06-08 05:29:59', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5).pdf'),
(17, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:30:38', '2023-06-08 05:30:38', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5).pdf'),
(18, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:32:35', '2023-06-08 05:32:35', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5) (1).pdf'),
(19, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:33:05', '2023-06-08 05:33:05', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5).pdf'),
(20, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:36:24', '2023-06-08 05:36:24', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5) (1).pdf'),
(21, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:37:50', '2023-06-08 05:37:50', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5) (1).pdf'),
(22, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:38:37', '2023-06-08 05:38:37', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5) (1).pdf'),
(23, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:38:47', '2023-06-08 05:38:47', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5).pdf'),
(24, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:44:13', '2023-06-08 05:44:13', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5) (1).pdf'),
(25, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:45:58', '2023-06-08 05:45:58', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5).pdf'),
(26, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:47:49', '2023-06-08 05:47:49', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5) (1).pdf'),
(27, NULL, 50, 'VMO', 'VMO1', NULL, '2023-06-08 05:49:06', '2023-06-08 05:49:06', 'C:\\fakepath\\1685955073Daily hourly timesheet template - PDF_copy.pdf. (5) (1).pdf'),
(28, NULL, NULL, NULL, NULL, NULL, '2023-06-08 06:16:00', '2023-06-08 06:16:00', NULL),
(29, NULL, NULL, NULL, NULL, NULL, '2023-06-08 23:12:49', '2023-06-08 23:12:49', NULL),
(30, NULL, NULL, NULL, NULL, NULL, '2023-06-08 23:13:02', '2023-06-08 23:13:02', NULL),
(31, NULL, NULL, NULL, NULL, NULL, '2023-06-08 23:13:13', '2023-06-08 23:13:13', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_documents`
--
ALTER TABLE `add_documents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_documents`
--
ALTER TABLE `add_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
