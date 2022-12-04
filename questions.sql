-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2022 at 08:42 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `marks` int(11) NOT NULL DEFAULT 0,
  `has_multiple` tinyint(1) DEFAULT NULL,
  `answer_explaination` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `module_id`, `type`, `title`, `marks`, `has_multiple`, `answer_explaination`, `created_at`, `updated_at`) VALUES
(7, 4, 'MATCH', '<figure class=\"table\"><table><tbody><tr><td><p>1.Airplane&nbsp;</p><p>2.Train</p></td><td><p>1.Rickshaw</p><p>2.Car</p></td></tr></tbody></table></figure>', 0, NULL, NULL, '2022-11-15 12:32:26', NULL),
(9, 1, 'MCQ', 'Demo question?', 2, NULL, 'N/A', '2022-11-18 06:11:35', NULL),
(10, 1, 'DESC', 'random', 5, NULL, NULL, '2022-11-18 06:11:46', '2022-11-18 06:11:46'),
(11, 1, 'FILL', 'Random___blank', 5, NULL, NULL, '2022-11-18 06:12:11', NULL),
(12, 1, 'MATCH', '<figure class=\"table\"><table><tbody><tr><td><p>1.Random1</p><p>2.Random2</p><p>3.Random3</p></td><td><p>1.Random3</p><p>2.Random1</p><p>3.Random2</p></td></tr></tbody></table></figure>', 0, NULL, NULL, '2022-11-18 06:13:31', NULL),
(13, 1, 'MCQ', 'Sam is liar ? is it true or false?', 2, NULL, 'NOne', '2022-11-29 13:03:35', NULL),
(21, 11, 'MCQ', 'Where was kabi Raindranath Tagore Born?', 2, NULL, NULL, '2022-11-29 13:26:28', NULL),
(22, 11, 'MCQ', 'Where was kabi nazrul burried?', 0, NULL, NULL, '2022-11-29 13:27:14', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
