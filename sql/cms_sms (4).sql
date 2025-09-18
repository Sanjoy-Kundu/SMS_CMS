-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 18, 2025 at 06:21 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_sections`
--

CREATE TABLE `academic_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `institution_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `section_type` enum('school','college') COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_letter_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `approval_stage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_sections`
--

INSERT INTO `academic_sections` (`id`, `institution_id`, `admin_id`, `section_type`, `approval_letter_no`, `approval_date`, `approval_stage`, `level`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'school', NULL, NULL, NULL, NULL, '2025-08-18 05:58:54', '2025-08-18 05:58:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `phone`, `address`, `image`, `birth_date`, `nid`, `gender`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '01759351546', 'Madaripur Dhaka, Bangladesh', '/uploads/admin/profile/1755694999_68a5c79730145.jpg', '1999-07-12', '12355887001', 'male', 1, '2025-08-18 05:57:23', '2025-08-20 07:03:19');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` enum('High','Medium','Low') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medium',
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audience` enum('Students','Teachers','All') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Students',
  `category` enum('Exam','Event','Homework','General') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'General',
  `recurring` enum('None','Daily','Weekly','Monthly') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'None',
  `read_count` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `valid_until` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `user_id`, `class_id`, `title`, `description`, `priority`, `attachment`, `link`, `audience`, `category`, `recurring`, `read_count`, `is_active`, `valid_until`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Mathematics Exam Notice', '<p>গণিত পরীক্ষা আগামী <b>15 সেপ্টেম্বর </b>অনুষ্ঠিত হবে।&nbsp;<span style=\"font-size: 1rem;\">পরীক্ষার সময় সকাল <b>10টা থেকে দুপুর 1টা</b> পর্যন্ত।&nbsp;</span><span style=\"font-size: 1rem;\">সবাইকে প্রস্তুত থাকতে বলা হলো।</span></p>', 'High', NULL, NULL, 'All', 'Exam', 'None', 0, 1, '2025-10-08 18:00:00', '2025-09-05 06:20:13', '2025-09-17 10:45:46', NULL),
(2, 1, 1, 'Science Project Submission', '<p>সকল শিক্ষার্থীকে আগামী 20 সেপ্টেম্বরের মধ্যে বিজ্ঞান প্রজেক্ট জমা দিতে হবে।</p>', 'High', NULL, NULL, 'Students', 'Homework', 'None', 0, 1, '2025-09-19 18:00:00', '2025-09-05 06:23:11', '2025-09-05 06:23:11', NULL),
(3, 1, 1, 'Parent-Teacher Meeting', '<p>অভিভাবক-শিক্ষক সভা অনুষ্ঠিত হবে <b>25 সেপ্টেম্বর</b> বিকেল 4টায়।</p>', 'High', NULL, 'https://classroom.google.com', 'All', 'Event', 'None', 0, 1, '2025-09-24 18:00:00', '2025-09-05 06:25:17', '2025-09-05 06:25:17', NULL),
(4, 1, 2, 'Library Book Submission', '<p>শিক্ষার্থীদের আগামী <b>10 সেপ্টেম্বরের </b>মধ্যে লাইব্রেরি বই ফেরত দিতে হবে।</p>', 'High', NULL, NULL, 'Students', 'General', 'None', 0, 1, '2025-09-09 18:00:00', '2025-09-05 06:28:00', '2025-09-05 06:28:00', NULL),
(5, 1, 2, 'Sports Day Announcement', '<p>School Sports Day অনুষ্ঠিত হবে <b>5 অক্টোবর</b>। শিক্ষার্থীরা খেলার জন্য নাম রেজিস্ট্রেশন করবে।</p><p><br></p>', 'High', NULL, NULL, 'Students', 'Event', 'None', 0, 1, '2025-10-04 18:00:00', '2025-09-05 06:29:41', '2025-09-05 06:29:41', NULL),
(6, 1, 2, 'Computer Lab Schedule', '<p>শিক্ষার্থীদের জন্য প্রতি <b>বুধবার বিকেলে</b> কম্পিউটার ল্যাব খোলা থাকবে।</p>', 'Medium', NULL, NULL, 'Students', 'General', 'Weekly', 0, 1, NULL, '2025-09-05 06:46:01', '2025-09-05 06:46:01', NULL),
(8, 1, 1, 'dfasvfdafa', '<p>dfdf dfas dfa</p>', 'Medium', 'uploads/attachments/1758217522_90785921-9c7a-47e1-aca3-5f1fea73e69a.jpg', NULL, 'Students', 'General', 'None', 0, 1, '2025-12-11 18:00:00', '2025-09-18 11:45:22', '2025-09-18 11:45:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_models`
--

CREATE TABLE `class_models` (
  `id` bigint UNSIGNED NOT NULL,
  `academic_section_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_models`
--

INSERT INTO `class_models` (`id`, `academic_section_id`, `admin_id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Six', NULL, '2025-08-18 05:59:09', '2025-08-18 05:59:09'),
(2, 1, 1, 'Seven', NULL, '2025-08-18 06:03:11', '2025-08-18 06:03:11'),
(3, 1, 1, 'Eight', NULL, '2025-08-18 06:03:18', '2025-08-18 06:03:18'),
(4, 1, 1, 'Nine', NULL, '2025-08-18 06:03:31', '2025-08-18 06:03:31'),
(5, 1, 1, 'Ten', NULL, '2025-08-18 06:03:44', '2025-08-18 06:03:44'),
(6, 1, 1, 'Eleven', NULL, '2025-08-29 00:19:03', '2025-08-29 00:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint UNSIGNED NOT NULL,
  `institution_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `institution_id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Headmaster', '2025-08-26 05:32:45', '2025-08-26 06:54:52', NULL),
(2, 1, 'Assistant Headmaster', '2025-08-26 05:49:29', '2025-08-26 06:24:46', NULL),
(3, 1, 'Assistant Teacher', '2025-08-26 05:57:00', '2025-08-26 07:04:44', NULL),
(6, 1, 'Senior Teacher', '2025-09-05 07:23:02', '2025-09-05 07:23:02', NULL),
(7, 1, 'Subject Teacher', '2025-09-05 07:23:26', '2025-09-05 07:23:26', NULL),
(8, 1, 'Physical Education Teacher / Sports Teacher', '2025-09-05 07:23:39', '2025-09-05 07:23:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `class_id`, `admin_id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'Science', NULL, '2025-08-18 06:04:16', '2025-08-18 06:04:16'),
(2, 4, 1, 'Business Studies', NULL, '2025-08-18 06:04:30', '2025-08-18 06:04:30'),
(3, 4, 1, 'Humanities', NULL, '2025-08-18 06:04:40', '2025-08-18 06:04:40'),
(4, 5, 1, 'Science', NULL, '2025-08-18 06:04:50', '2025-08-18 06:04:50'),
(5, 5, 1, 'Business Studies', NULL, '2025-08-18 06:05:04', '2025-08-18 06:05:04'),
(6, 5, 1, 'Humanities', NULL, '2025-08-18 06:05:19', '2025-08-18 06:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `editors`
--

CREATE TABLE `editors` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `institution_id` bigint UNSIGNED NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joined_at` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` enum('Hindu','Muslim','Buddhist','Christian','Other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` enum('single','married','divorced','widowed') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `editors`
--

INSERT INTO `editors` (`id`, `user_id`, `institution_id`, `designation`, `joined_at`, `is_active`, `father_name`, `mother_name`, `phone`, `address`, `image`, `nationality`, `birth_date`, `nid`, `gender`, `religion`, `marital_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, NULL, '2025-08-18', 1, 'Osman Mia', 'Sadia Akter Jui', '0175935840', 'Madaripur Dhaka Bangladesh', '1755523284.jpg', 'Bangladeshi', '2000-01-01', '123458400454', 'male', 'Muslim', 'single', '2025-08-18 06:08:34', '2025-08-18 07:45:40', NULL),
(2, 3, 1, NULL, '2025-08-18', 1, 'Alamin Bepari', 'Amena Akter', '01759351478', 'Puran Dhka', '1755527410.png', 'Bangladeshi', '2000-01-01', '112564640054', 'male', 'Muslim', 'single', '2025-08-18 08:12:40', '2025-08-21 08:05:35', NULL),
(3, 27, 1, NULL, '2025-08-21', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-21 04:38:50', '2025-08-21 07:38:41', NULL),
(4, 31, 1, NULL, '2025-08-21', 1, 'Abul Kashem', 'Amena Akter', '01968574112', 'Prosonno Podder len, 3/4 Block-C, Vatara Dhaka', '1755884827.jpg', 'Bangladeshi', '1998-01-01', '45801214025120', 'male', 'Muslim', 'single', '2025-08-21 06:30:58', '2025-08-22 11:47:07', NULL),
(7, 34, 1, NULL, '2025-08-21', 1, 'Akramul Hassan', 'N/A', '01759351454', 'N/A', '1755786522.jpg', 'N/A', NULL, 'N/A', NULL, NULL, NULL, '2025-08-21 08:25:40', '2025-08-21 08:34:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `editor_addresses`
--

CREATE TABLE `editor_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `editor_id` bigint UNSIGNED NOT NULL,
  `type` enum('present','permanent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upazila` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_office` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `editor_addresses`
--

INSERT INTO `editor_addresses` (`id`, `editor_id`, `type`, `village`, `district`, `upazila`, `post_office`, `postal_code`, `created_at`, `updated_at`) VALUES
(1, 2, 'present', 'Charbaramodi', 'Madaripur', 'Madaripur Sadar', 'Madaripur Sadar', '9900', '2025-08-19 07:37:38', '2025-09-18 11:56:25'),
(2, 2, 'permanent', 'Kulpaddi', 'Madaripur', 'Madaripur Sadar', 'Kulpaddi', '7902', '2025-08-19 08:11:59', '2025-08-19 08:16:43'),
(3, 7, 'present', 'Kulpaddi', 'Madaripur', 'Madaripur Sadar', 'Kulpaddi', '7902', '2025-08-21 08:27:44', '2025-08-21 08:27:44'),
(4, 7, 'permanent', 'Kulpaddi', 'Madaripur', 'Madaripur Sadar', 'Madaripur Sadar', '7905', '2025-08-21 08:28:16', '2025-08-21 08:28:25'),
(7, 4, 'present', 'Chadpur', 'Chadpur', 'Mayapur', 'Chadpur Sadar', '7800', '2025-08-23 04:38:52', '2025-08-23 04:38:52');

-- --------------------------------------------------------

--
-- Table structure for table `editor_educations`
--

CREATE TABLE `editor_educations` (
  `id` bigint UNSIGNED NOT NULL,
  `editor_id` bigint UNSIGNED NOT NULL,
  `level` enum('SSC','HSC','Graduation','Masters') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roll_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `board_university` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passing_year` year DEFAULT NULL,
  `course_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `editor_educations`
--

INSERT INTO `editor_educations` (`id`, `editor_id`, `level`, `roll_number`, `board_university`, `result`, `passing_year`, `course_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'SSC', '158094', 'Dhaka Board', '4.5', '2016', NULL, '2025-08-19 05:21:23', '2025-08-19 05:21:23', NULL),
(2, 2, 'HSC', '169485', 'Dhaka Board', '4.52', '2018', NULL, '2025-08-19 05:50:43', '2025-08-19 06:45:16', NULL),
(3, 2, 'Graduation', NULL, 'National University', '3.32', '2022', '4', '2025-08-19 05:58:27', '2025-08-19 06:45:09', NULL),
(4, 2, 'Masters', NULL, 'NT University', '3.32', '2023', '1.5', '2025-08-19 06:03:30', '2025-08-19 08:16:54', NULL),
(5, 1, 'SSC', '158081', 'Dhaka Board', '4.25', '2010', NULL, '2025-08-22 11:31:22', '2025-08-22 11:35:11', NULL),
(6, 1, 'HSC', '168081', 'Dhaka Board', '3.25', '2012', NULL, '2025-08-22 11:35:18', '2025-08-22 11:35:33', NULL),
(7, 1, 'Graduation', NULL, 'National University', '3.32', '2016', '4', '2025-08-22 11:40:24', '2025-08-22 11:40:24', NULL),
(8, 1, 'Masters', NULL, 'National University', '3.56', '2017', '1', '2025-08-22 11:40:52', '2025-08-22 11:40:52', NULL),
(9, 4, 'SSC', '404142', 'Dhaka Board', '4.55', '2008', NULL, '2025-08-22 11:47:37', '2025-08-22 11:47:37', NULL),
(10, 4, 'HSC', '424140', 'Dhaka Board', '4.30', '2010', NULL, '2025-08-22 11:48:00', '2025-08-22 11:48:00', NULL),
(11, 4, 'Graduation', NULL, 'Northern University', '2.99', '2014', '4', '2025-08-22 11:48:28', '2025-08-22 11:48:47', NULL),
(12, 4, 'Masters', NULL, 'Jagannath University', '3.12', '2016', '1.5', '2025-08-22 11:49:17', '2025-08-22 11:49:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grading_scales`
--

CREATE TABLE `grading_scales` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NOT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `min_range` int DEFAULT NULL,
  `max_range` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grading_scales`
--

INSERT INTO `grading_scales` (`id`, `user_id`, `class_id`, `grade`, `gpa`, `min_range`, `max_range`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 'A+', 5.00, 80, 100, '2025-08-29 07:15:41', '2025-08-29 07:15:41'),
(9, 1, 1, 'A', 4.00, 70, 79, '2025-08-29 07:21:28', '2025-08-29 11:24:30'),
(10, 1, 1, 'A-', 3.50, 60, 69, '2025-08-29 07:51:06', '2025-08-29 07:51:06'),
(11, 1, 1, 'B', 3.00, 50, 59, '2025-08-29 07:53:38', '2025-08-29 07:53:38'),
(12, 1, 1, 'C', 2.00, 40, 49, '2025-08-29 07:54:12', '2025-08-29 07:54:12'),
(13, 1, 1, 'D', 1.00, 33, 39, '2025-08-29 07:54:39', '2025-08-29 07:54:39'),
(15, 1, 1, 'F', 0.00, 0, 32, '2025-08-29 10:05:20', '2025-08-29 10:05:20'),
(16, 1, 2, 'A+', 5.00, 80, 100, '2025-08-29 11:26:12', '2025-08-29 11:26:12'),
(17, 1, 2, 'A', 4.00, 70, 79, '2025-08-29 11:26:25', '2025-08-29 11:26:25'),
(18, 1, 2, 'A-', 3.50, 60, 69, '2025-08-29 11:26:56', '2025-08-29 11:26:56'),
(19, 1, 2, 'B', 3.00, 50, 59, '2025-08-29 11:27:37', '2025-08-29 11:27:37'),
(20, 1, 2, 'C', 2.50, 40, 49, '2025-08-29 11:28:10', '2025-08-29 11:28:10'),
(21, 1, 2, 'D', 2.00, 33, 39, '2025-08-29 11:28:32', '2025-08-29 11:28:32'),
(22, 1, 2, 'F', 0.00, 0, 32, '2025-08-29 11:28:47', '2025-08-29 11:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE `institutions` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('school','college','combined') COLLATE utf8mb4_unicode_ci NOT NULL,
  `eiin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`id`, `admin_id`, `name`, `type`, `eiin`, `address`, `parent_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'AB High School', 'school', '1231', 'Madaripur-7902, Dhaka, Bangladesh', NULL, '2025-08-18 05:58:38', '2025-09-18 11:31:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_08_10_133333_create_admins_table', 2),
(6, '2025_08_11_185543_create_password_otps_table', 3),
(7, '2025_08_12_114312_create_institutions_table', 4),
(8, '2025_08_13_013113_create_academic_sections_table', 5),
(9, '2025_08_13_122018_create_class_models_table', 6),
(10, '2025_08_13_172006_create_divisions_table', 7),
(11, '2025_08_13_183253_create_subjects_table', 8),
(12, '2025_08_14_194548_create_papers_table', 9),
(13, '2025_08_17_121855_create_editors_table', 10),
(14, '2025_08_19_101815_create_editor_educations_table', 11),
(16, '2025_08_19_125109_create_editor_addresses_table', 12),
(19, '2025_08_20_001519_create_teachers_table', 13),
(20, '2025_08_20_190319_add_soft_deletes_to_users_table', 14),
(21, '2025_08_24_221939_create_teacher_educations_table', 15),
(22, '2025_08_24_230939_create_teacher_addresses_table', 16),
(23, '2025_08_26_005533_create_designations_table', 17),
(24, '2025_08_26_005851_add_designation_id_to_teachers_table', 18),
(26, '2025_08_28_195028_create_grading_scales_table', 19),
(27, '2025_08_29_174815_create_announcements_table', 20);

-- --------------------------------------------------------

--
-- Table structure for table `papers`
--

CREATE TABLE `papers` (
  `id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `papers`
--

INSERT INTO `papers` (`id`, `subject_id`, `name`, `code`, `admin_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'First Paper', '201', 1, 1, '2025-08-18 06:07:00', '2025-08-18 06:07:00', NULL),
(2, 1, 'Second Paper', '202', 1, 1, '2025-08-18 06:07:18', '2025-08-18 06:07:18', NULL),
(3, 2, 'First Paper', '301', 1, 1, '2025-08-18 06:07:31', '2025-08-18 06:07:31', NULL),
(4, 2, 'Second Paper', '302', 1, 1, '2025-08-18 06:07:47', '2025-08-18 06:07:47', NULL),
(5, 9, 'First Paper', '960', 1, 1, '2025-09-17 13:26:39', '2025-09-17 13:26:39', NULL),
(6, 9, 'Second Paper', '961', 1, 1, '2025-09-17 13:27:01', '2025-09-17 13:27:01', NULL),
(7, 10, 'First Paper', '202', 1, 1, '2025-09-17 13:27:17', '2025-09-17 13:27:17', NULL),
(8, 10, 'Second Paper', '205', 1, 1, '2025-09-17 13:27:29', '2025-09-17 13:27:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_otps`
--

CREATE TABLE `password_otps` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'token', '997cf633ada127e3aa62e8c43f2f53969482fe4189c609e33f4c8e40c30f8de1', '[\"*\"]', '2025-08-18 06:01:00', NULL, '2025-08-18 05:57:44', '2025-08-18 06:01:00'),
(2, 'App\\Models\\User', 1, 'token', '0e26d88e6eb56f6f1c52c4be1248234d9cbe8ac53a2af56066ac1bce3d403ba3', '[\"*\"]', '2025-08-18 06:08:34', NULL, '2025-08-18 06:01:39', '2025-08-18 06:08:34'),
(4, 'App\\Models\\User', 2, 'token', '184747800effd4213531c93b2ec82a6f87151332de576c96335bf1ab06ff495d', '[\"*\"]', '2025-08-18 08:00:08', NULL, '2025-08-18 07:13:36', '2025-08-18 08:00:08'),
(5, 'App\\Models\\User', 2, 'token', '99c97353ba47ebda6d44c16c1d29e6f7afdd1622fbf9336a7042d34c34fc33d6', '[\"*\"]', '2025-08-18 08:11:37', NULL, '2025-08-18 08:00:31', '2025-08-18 08:11:37'),
(6, 'App\\Models\\User', 1, 'token', '96d8a181181d0ad1ad6466ef875f4db469436a6b40720bdebf3ed1bef0c0dafa', '[\"*\"]', '2025-08-18 08:12:39', NULL, '2025-08-18 08:12:24', '2025-08-18 08:12:39'),
(7, 'App\\Models\\User', 3, 'token', 'f94ea27619aaff2936d8385988be1c3a2dbec46e96255e4df6ef19709c9e9864', '[\"*\"]', '2025-08-18 08:33:03', NULL, '2025-08-18 08:16:59', '2025-08-18 08:33:03'),
(8, 'App\\Models\\User', 3, 'token', '49c7fb8729dbaf7a321a545ce5d3ff34dbb40bfdd6380e8b5e4383a328d03bac', '[\"*\"]', '2025-08-18 08:39:01', NULL, '2025-08-18 08:33:12', '2025-08-18 08:39:01'),
(9, 'App\\Models\\User', 3, 'token', '6797911f24c486d34d234553d1821fdf268cb00593ea47e3b3e55313566b1bb9', '[\"*\"]', '2025-08-19 08:49:14', NULL, '2025-08-19 03:53:38', '2025-08-19 08:49:14'),
(10, 'App\\Models\\User', 1, 'token', 'd352e50d97cad4b9bf139980ce96d86ffd3c4a8681a0f591f32ae583acdb715e', '[\"*\"]', '2025-08-19 19:48:51', NULL, '2025-08-19 18:03:02', '2025-08-19 19:48:51'),
(11, 'App\\Models\\User', 3, 'token', 'f4b47c49005abbbace4125a6cafe97f1f8a2e042f32ae29015f926d1a7aef558', '[\"*\"]', '2025-08-19 19:30:25', NULL, '2025-08-19 19:29:46', '2025-08-19 19:30:25'),
(12, 'App\\Models\\User', 3, 'token', '7d1fe78c842fc9dc358a9edd44cb9bf40cede321657516caf25f4a6e352d865a', '[\"*\"]', '2025-08-19 19:33:04', NULL, '2025-08-19 19:32:58', '2025-08-19 19:33:04'),
(13, 'App\\Models\\User', 3, 'token', '1fc4d9a3a6d053d18ea639a5e958ffe20f7308fb1767bf10e8dac557231dd160', '[\"*\"]', '2025-08-19 19:42:14', NULL, '2025-08-19 19:42:05', '2025-08-19 19:42:14'),
(14, 'App\\Models\\User', 3, 'token', '926a0277e1d245145824a6503b2ec50a8acebf3b288d22fbdb20b1e9f5acaba8', '[\"*\"]', '2025-08-19 19:54:15', NULL, '2025-08-19 19:43:29', '2025-08-19 19:54:15'),
(17, 'App\\Models\\User', 1, 'token', '3b574b3decbf2b95b7d7a0e46c3c14f9c8cda67062e7ff78fdc202cfaf027288', '[\"*\"]', '2025-08-20 15:16:33', NULL, '2025-08-20 10:13:51', '2025-08-20 15:16:33'),
(18, 'App\\Models\\User', 3, 'token', '3f7030a0f046c719720d2da11217ca345856e0aaa272bfe8d744b794f7edb2dd', '[\"*\"]', '2025-08-20 14:55:57', NULL, '2025-08-20 10:22:51', '2025-08-20 14:55:57'),
(19, 'App\\Models\\User', 1, 'token', '50186dd0d2fa869703fd892ff0d3b9820e2e6d044b109e8f04091b729ea98cd0', '[\"*\"]', '2025-08-20 13:58:52', NULL, '2025-08-20 11:45:23', '2025-08-20 13:58:52'),
(20, 'App\\Models\\User', 3, 'token', 'b7f33e446dadfd48ca8ea428a60eb5f53e704c3646dc66ce7d236ccb9516f3fc', '[\"*\"]', '2025-08-20 15:21:55', NULL, '2025-08-20 14:57:18', '2025-08-20 15:21:55'),
(21, 'App\\Models\\User', 3, 'token', '4b5d65058f38c2b0f32587c5481308ad255708a7255254f6c372efda6abf48d9', '[\"*\"]', '2025-08-20 15:21:03', NULL, '2025-08-20 14:57:29', '2025-08-20 15:21:03'),
(23, 'App\\Models\\User', 3, 'token', '3245cbe69a729e35e60259e48ec7c75d13ba4d53339936296dcd1cf27158865e', '[\"*\"]', '2025-08-21 05:29:38', NULL, '2025-08-21 04:05:30', '2025-08-21 05:29:38'),
(24, 'App\\Models\\User', 3, 'token', '0091107a3644c3ff7de0a8a294e4acc238b6475facc59aa29fa54933bc2eae60', '[\"*\"]', '2025-08-21 04:31:31', NULL, '2025-08-21 04:31:10', '2025-08-21 04:31:31'),
(25, 'App\\Models\\User', 1, 'token', 'f78e9f77ea19c5167fb5ea13cb0d056dfb8c2d3cd1c38c0bd943e6bf1f0dcee6', '[\"*\"]', '2025-08-21 04:44:34', NULL, '2025-08-21 04:43:31', '2025-08-21 04:44:34'),
(27, 'App\\Models\\User', 3, 'token', '957bb4354b67a22ff5fe4bbafb8c1a429b811cb4d841bf3c6061cc5aa97a7dea', '[\"*\"]', '2025-08-21 07:39:23', NULL, '2025-08-21 05:29:49', '2025-08-21 07:39:23'),
(28, 'App\\Models\\User', 3, 'token', 'd226f27f99758a7719b67e5e7e8182d89e2f60ad9f6cb19d92392bb87cb7e305', '[\"*\"]', '2025-08-21 07:39:33', NULL, '2025-08-21 07:39:30', '2025-08-21 07:39:33'),
(29, 'App\\Models\\User', 3, 'token', 'fd895465b0c146ca19be4a0fb888fd99aeeafecf6b891f261933a7fd8cc6a0ce', '[\"*\"]', '2025-08-21 07:39:43', NULL, '2025-08-21 07:39:40', '2025-08-21 07:39:43'),
(30, 'App\\Models\\User', 3, 'token', 'bad99569ab65f8f028bdd156c1212722e8f7a0ce17a3fb7d4c6c56bec05a9f9a', '[\"*\"]', '2025-08-21 07:45:32', NULL, '2025-08-21 07:45:26', '2025-08-21 07:45:32'),
(32, 'App\\Models\\User', 34, 'token', 'a29fe42ac5d9fe8c27b002da8eb70feaa060b4a623733d67940db9859169cc83', '[\"*\"]', '2025-08-21 08:30:43', NULL, '2025-08-21 08:26:09', '2025-08-21 08:30:43'),
(35, 'App\\Models\\User', 3, 'token', 'dc4314f2bf595e9b89e71eadeda6e2e2f76d3d28d9f91e7d35efe35597d47e3f', '[\"*\"]', '2025-08-22 05:00:28', NULL, '2025-08-22 03:59:03', '2025-08-22 05:00:28'),
(37, 'App\\Models\\User', 1, 'token', 'f9e71ccbe829120484817f2af0c4476bf28f4768e606a7c13b5a801b03d1bf64', '[\"*\"]', '2025-08-23 06:37:54', NULL, '2025-08-22 10:28:37', '2025-08-23 06:37:54'),
(38, 'App\\Models\\User', 2, 'token', '1320f7952172cd3c1acb4c937f889f21248eb3381b17c674dfa960ca47f15268', '[\"*\"]', '2025-08-22 11:23:32', NULL, '2025-08-22 11:22:58', '2025-08-22 11:23:32'),
(40, 'App\\Models\\User', 31, 'token', '0f7218eef86743c9a7d4c6441be225411174aa58ea0c8d6aa4d7f145435ff52d', '[\"*\"]', '2025-08-22 11:44:23', NULL, '2025-08-22 11:43:59', '2025-08-22 11:44:23'),
(42, 'App\\Models\\User', 31, 'token', '690cdc9dffe658437263d02fbdcb4538e2619a7f20a692e197195772876eb247', '[\"*\"]', '2025-08-23 04:36:11', NULL, '2025-08-23 04:22:00', '2025-08-23 04:36:11'),
(44, 'App\\Models\\User', 3, 'token', '573a02df72d0cea2b22e145fbaef81fa5475c1423da3f4efb92b4724224afed6', '[\"*\"]', '2025-08-23 06:48:12', NULL, '2025-08-23 06:25:09', '2025-08-23 06:48:12'),
(45, 'App\\Models\\User', 35, 'token', '513e174349b3c655cfa905d93c933451c753a3290ab44fd03225c4837cd3a368', '[\"*\"]', NULL, NULL, '2025-08-23 07:09:14', '2025-08-23 07:09:14'),
(46, 'App\\Models\\User', 35, 'token', '82ae581de3a098993e024b23e45746c1a8fa15a190614129f5bdae14ade4bf53', '[\"*\"]', '2025-08-23 07:39:27', NULL, '2025-08-23 07:31:41', '2025-08-23 07:39:27'),
(47, 'App\\Models\\User', 35, 'token', 'eedc914676351aef710f18d037fc3f3527e474a42e6cabd5a106ff01cc7873eb', '[\"*\"]', '2025-08-23 07:40:48', NULL, '2025-08-23 07:40:47', '2025-08-23 07:40:48'),
(49, 'App\\Models\\User', 35, 'token', '3a0208405e1b6cc3bd58fe32784fb5dd45e631b32038f378301ed91affd6012d', '[\"*\"]', '2025-08-23 10:53:13', NULL, '2025-08-23 10:43:31', '2025-08-23 10:53:13'),
(50, 'App\\Models\\User', 35, 'token', 'd06cc2e909c7f9c1e5ee0ff00bba238338cc95bc714f95139f376f3dd54f4fcc', '[\"*\"]', '2025-08-24 15:27:56', NULL, '2025-08-23 17:44:38', '2025-08-24 15:27:56'),
(51, 'App\\Models\\User', 1, 'token', 'bd76699ab638389d0ed3c04db286c65a47e2d92bf6e2339002f6f45e15b91c6c', '[\"*\"]', '2025-08-24 15:40:59', NULL, '2025-08-24 15:28:13', '2025-08-24 15:40:59'),
(52, 'App\\Models\\User', 35, 'token', '84a7df0c3cc563cccfabe044c91368f75aef840c1b729c1e27716f209ce9b2a5', '[\"*\"]', '2025-08-24 17:04:49', NULL, '2025-08-24 15:30:26', '2025-08-24 17:04:49'),
(53, 'App\\Models\\User', 2, 'token', 'e9de3b76c4e1f8d5c94f7e045e13b9e4fff5bb07e7aaefa0e58bbfc89213464c', '[\"*\"]', '2025-08-24 17:40:23', NULL, '2025-08-24 15:41:07', '2025-08-24 17:40:23'),
(54, 'App\\Models\\User', 35, 'token', '8d6dd8f3b4e690eaa950736f0d70213d05ae263d99e7432f6ee06b0839bc3b15', '[\"*\"]', '2025-08-24 18:09:41', NULL, '2025-08-24 17:05:25', '2025-08-24 18:09:41'),
(56, 'App\\Models\\User', 2, 'token', 'cf9375044de88d2a422b16a6eeda47fbe9e91fb8dc352254950ed7bc0ca67ab6', '[\"*\"]', '2025-08-25 04:15:29', NULL, '2025-08-24 17:41:15', '2025-08-25 04:15:29'),
(57, 'App\\Models\\User', 35, 'token', 'f242a73aeb4d9309b4caa89385feb0ac9dbfd0dd27a9f285d2667291739ff1a9', '[\"*\"]', '2025-08-24 18:10:37', NULL, '2025-08-24 18:10:02', '2025-08-24 18:10:37'),
(58, 'App\\Models\\User', 35, 'token', '8f0d72a3feafbdf7988dc3e7b72bdf174ca7cad982d2d18e7b85e2eff39405c6', '[\"*\"]', '2025-08-24 18:11:32', NULL, '2025-08-24 18:10:47', '2025-08-24 18:11:32'),
(59, 'App\\Models\\User', 35, 'token', '0bb8de8df27566a0093147a9c794c9553df526ccc839817bab7f7af0a723a91a', '[\"*\"]', '2025-08-24 18:11:44', NULL, '2025-08-24 18:11:41', '2025-08-24 18:11:44'),
(60, 'App\\Models\\User', 35, 'token', '7eff7e7a0444336bee7b7db8687f064779e8315e8d70d2539407784567492676', '[\"*\"]', '2025-08-24 18:17:02', NULL, '2025-08-24 18:12:10', '2025-08-24 18:17:02'),
(61, 'App\\Models\\User', 35, 'token', '441f3d3e2ae2ba9654f117f15b24f0ef35a436060071c3debefebb316a73939a', '[\"*\"]', '2025-08-24 18:17:52', NULL, '2025-08-24 18:17:51', '2025-08-24 18:17:52'),
(62, 'App\\Models\\User', 35, 'token', '230211cb0e47073b5db27c3b447e987e02250dceadc75ccb13052d2d60652627', '[\"*\"]', '2025-08-24 18:19:51', NULL, '2025-08-24 18:18:13', '2025-08-24 18:19:51'),
(63, 'App\\Models\\User', 1, 'token', '2b006fcf02fedde80027e65ed31a5c1e3c3b36344185bcd90fc1f7d4442fba62', '[\"*\"]', '2025-08-25 04:30:30', NULL, '2025-08-25 04:15:46', '2025-08-25 04:30:30'),
(64, 'App\\Models\\User', 1, 'token', 'f7bf030ec290a8e9dab468446e3d0448501c15a408fbf18fbf2ec7eb4e6536a9', '[\"*\"]', '2025-08-25 04:56:37', NULL, '2025-08-25 04:42:07', '2025-08-25 04:56:37'),
(69, 'App\\Models\\User', 3, 'token', 'a3c078c7a4255b8366951b4cb25e81eab01f57e74caa57856da23f7b4d1c4f8c', '[\"*\"]', '2025-08-25 11:09:03', NULL, '2025-08-25 08:26:43', '2025-08-25 11:09:03'),
(70, 'App\\Models\\User', 1, 'token', 'ac61429cbef88a42163d06ad86caf35adcf48505274042f3848fa73e4a8a6dcf', '[\"*\"]', '2025-08-25 11:41:56', NULL, '2025-08-25 11:03:50', '2025-08-25 11:41:56'),
(71, 'App\\Models\\User', 35, 'token', '1505edca6202afc6906738d20f03613fbf13fa0a2d4bf311f391e186020c1dd3', '[\"*\"]', '2025-08-25 11:15:27', NULL, '2025-08-25 11:10:02', '2025-08-25 11:15:27'),
(72, 'App\\Models\\User', 37, 'token', 'f9034614d1ce1d09985cd9486f14c94f17c0f8062accea17d863d5fedd961d14', '[\"*\"]', '2025-08-25 11:32:08', NULL, '2025-08-25 11:31:40', '2025-08-25 11:32:08'),
(73, 'App\\Models\\User', 37, 'token', '0511428fff369eeab60b7dad685bd4567f9056323dac5656419454de5bb06c1e', '[\"*\"]', '2025-08-25 11:41:35', NULL, '2025-08-25 11:32:19', '2025-08-25 11:41:35'),
(74, 'App\\Models\\User', 1, 'token', 'b0e71cd4c6468033a7804ecb013cf29042fdca93df8f8632ac2b7dc775041da3', '[\"*\"]', '2025-08-25 19:57:36', NULL, '2025-08-25 19:09:57', '2025-08-25 19:57:36'),
(75, 'App\\Models\\User', 1, 'token', '42ef5f22e2c376777dfb765da09ef016afdbbcc7dfaff38cb8e448f2053f651f', '[\"*\"]', '2025-08-26 18:31:52', NULL, '2025-08-26 04:39:34', '2025-08-26 18:31:52'),
(76, 'App\\Models\\User', 1, 'token', '944518650344857423d06a549bf5a81c283455e4d0bab624fe79fdbfba1c8889', '[\"*\"]', '2025-08-27 07:59:07', NULL, '2025-08-27 07:09:31', '2025-08-27 07:59:07'),
(77, 'App\\Models\\User', 3, 'token', '649da8df0c2f727ecc01ae09a81cc023d0245069a7b40bd2e4b0ee2a7e013f56', '[\"*\"]', '2025-08-27 07:58:33', NULL, '2025-08-27 07:14:41', '2025-08-27 07:58:33'),
(78, 'App\\Models\\User', 1, 'token', 'a74090ae2cf792406a6c5b87f75319c2bd1b98a993c08a76e5c269e1201d813c', '[\"*\"]', '2025-08-28 13:57:21', NULL, '2025-08-27 10:46:08', '2025-08-28 13:57:21'),
(79, 'App\\Models\\User', 1, 'token', 'e3ad3b5f11e85934ef64b414a5946d8d9d00dbc3ed61d8df1dd188e4551c0bb0', '[\"*\"]', '2025-08-29 07:55:47', NULL, '2025-08-29 00:12:42', '2025-08-29 07:55:47'),
(80, 'App\\Models\\User', 1, 'token', 'b5c9e61d1989864dc0a053c99632f6c2aef7ed5b73b10757020c3088d1221c78', '[\"*\"]', '2025-08-29 11:52:29', NULL, '2025-08-29 09:54:01', '2025-08-29 11:52:29'),
(81, 'App\\Models\\User', 1, 'token', 'f0fef7f27716ef1525605234ae5823137067c9e2b87dd7e50e5e0d40664bb252', '[\"*\"]', '2025-08-30 06:33:07', NULL, '2025-08-30 05:43:27', '2025-08-30 06:33:07'),
(82, 'App\\Models\\User', 1, 'token', 'e4cc08cd31fb1c90550be68ae9c8ee92849de2a11564d5e60d5548af364d1c95', '[\"*\"]', '2025-09-01 07:56:41', NULL, '2025-09-01 06:57:46', '2025-09-01 07:56:41'),
(83, 'App\\Models\\User', 1, 'token', 'b594f886038e0e21da150e05ab6751c1bd9af81b848ad794ed6a26965fb7a8be', '[\"*\"]', '2025-09-02 12:03:02', NULL, '2025-09-02 05:00:53', '2025-09-02 12:03:02'),
(84, 'App\\Models\\User', 1, 'token', '64400ae3efaccd682a47e8f1268d228e23514097a12e1331bc174095b18e5521', '[\"*\"]', '2025-09-04 07:49:12', NULL, '2025-09-04 04:35:22', '2025-09-04 07:49:12'),
(85, 'App\\Models\\User', 1, 'token', '8671e157b8b46593a23ce5a1be44c2c86054c44bdab9d8d51931baf44188636a', '[\"*\"]', '2025-09-05 07:56:30', NULL, '2025-09-04 07:58:44', '2025-09-05 07:56:30'),
(86, 'App\\Models\\User', 39, 'token', '128f973ed1eb3a24174ab18f373a60eca138ae636e089ac49640ca5a25847944', '[\"*\"]', '2025-09-05 06:36:49', NULL, '2025-09-05 06:36:11', '2025-09-05 06:36:49'),
(87, 'App\\Models\\User', 39, 'token', 'c964807dc1670b7d5dd780134cc368f9130f92072f87b4ef84fc2969fff545ea', '[\"*\"]', '2025-09-05 06:38:28', NULL, '2025-09-05 06:37:24', '2025-09-05 06:38:28'),
(89, 'App\\Models\\User', 1, 'token', '4c5ca2ce8a4db92e0bb976454d6b04f3d7dd77dc9fdfe61ea756411c193be793', '[\"*\"]', '2025-09-06 10:50:34', NULL, '2025-09-06 10:46:57', '2025-09-06 10:50:34'),
(91, 'App\\Models\\User', 1, 'token', '152adc69ee2c76f0a4dde8727fc6d8f3eccd2a3e266c213f83566d6a2845c698', '[\"*\"]', '2025-09-17 12:12:51', NULL, '2025-09-17 12:12:45', '2025-09-17 12:12:51'),
(92, 'App\\Models\\User', 1, 'token', '2345106bdd3e4bf6235fa0fe04f5ec0e1723f9d9f82daddea16eb7390cff4575', '[\"*\"]', '2025-09-18 12:19:12', NULL, '2025-09-18 11:30:31', '2025-09-18 12:19:12'),
(93, 'App\\Models\\User', 3, 'token', '96e8e0d2f4db42776d4064b1312a59edb2c26bb0c8c5ab9ec835d64c3ed48dd0', '[\"*\"]', '2025-09-18 11:54:24', NULL, '2025-09-18 11:52:36', '2025-09-18 11:54:24'),
(94, 'App\\Models\\User', 3, 'token', '9fb7eba3978417544c2a1f369094a56936e535629b8952a2c85a9d3a2c4f0b24', '[\"*\"]', '2025-09-18 11:56:48', NULL, '2025-09-18 11:55:08', '2025-09-18 11:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NOT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('compulsory','optional','additional') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'compulsory',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `class_id`, `division_id`, `admin_id`, `name`, `code`, `type`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 1, 'Bangla', NULL, 'compulsory', 1, '2025-08-18 06:05:39', '2025-08-18 06:05:39', NULL),
(2, 1, NULL, 1, 'English', NULL, 'compulsory', 1, '2025-08-18 06:05:48', '2025-08-18 06:05:48', NULL),
(3, 1, NULL, 1, 'Mathematics', '107', 'compulsory', 1, '2025-08-18 06:06:01', '2025-08-18 06:06:01', NULL),
(4, 1, NULL, 1, 'Information and Communication Technology', '109', 'compulsory', 1, '2025-08-18 06:06:17', '2025-08-18 06:06:17', NULL),
(5, 1, NULL, 1, 'Agriculture', '111', 'optional', 1, '2025-08-18 06:06:35', '2025-08-18 06:06:35', NULL),
(7, 4, NULL, 1, 'Bangla', NULL, 'compulsory', 1, '2025-09-17 13:25:19', '2025-09-17 13:25:19', NULL),
(8, 4, NULL, 1, 'English', NULL, 'compulsory', 1, '2025-09-17 13:25:33', '2025-09-17 13:25:33', NULL),
(9, 4, 1, 1, 'Physic', NULL, 'additional', 1, '2025-09-17 13:25:50', '2025-09-17 13:25:50', NULL),
(10, 4, 2, 1, 'Accounting', NULL, 'additional', 1, '2025-09-17 13:26:10', '2025-09-17 13:26:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `added_by` bigint UNSIGNED DEFAULT NULL,
  `institution_id` bigint UNSIGNED NOT NULL,
  `joined_at` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_me` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` enum('Hindu','Muslim','Buddhist','Christian','Other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` enum('single','married','divorced','widowed') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `designation_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `added_by`, `institution_id`, `joined_at`, `is_active`, `father_name`, `mother_name`, `phone`, `address`, `about_me`, `image`, `nationality`, `birth_date`, `nid`, `gender`, `religion`, `marital_status`, `created_at`, `updated_at`, `deleted_at`, `designation_id`) VALUES
(18, 37, 1, 1, '2025-08-25', 1, 'Anwar Haque', 'Amena Begum', '01568740124', 'House # 23, Road # 5,\r\nShyamoli, Mohammadpur,\r\nDhaka – 1207,\r\nBangladesh', 'My name is Enamul Kazi, and I am from Natore, Bangladesh. I have recently joined Green Valley High School, Dhaka as an English Teacher. I completed my Bachelor of Arts in English Literature and Language from the University of Rajshahi, followed by a Master’s degree in Applied Linguistics.\r\n\r\nTeaching has always been my dream profession. From an early age, I was inspired by my teachers and their ability to change students’ lives. As an English teacher, I try to make learning both enjoyable and meaningful. My classroom approach focuses on developing students’ reading, writing, listening, and speaking skills, while also helping them to build confidence in using English in their daily life.\r\n\r\nI strongly believe that education is not just about textbooks and exams—it is about preparing young minds for the future. Therefore, I encourage creativity, critical thinking, and interactive learning among my students.\r\n\r\nApart from teaching, I enjoy reading novels, traveling, and participating in cultural activities. I also love guiding students in debates and public speaking, as these activities improve their communication and leadership skills.\r\n\r\nMy ultimate goal as a teacher is to inspire students, help them achieve academic excellence, and motivate them to become responsible citizens who will contribute positively to society.', '1756143692.png', 'Bangladeshi', '1980-01-01', '202154001410', 'male', 'Muslim', 'single', '2025-08-25 11:31:03', '2025-08-27 07:56:00', NULL, 2),
(19, 38, 3, 1, '2025-08-27', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-27 07:15:08', '2025-08-27 07:59:00', NULL, 3),
(20, 39, 1, 1, '2025-09-05', 1, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '1757075900.jpg', 'N/A', NULL, 'N/A', NULL, NULL, NULL, '2025-09-05 06:33:50', '2025-09-18 11:39:09', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_addresses`
--

CREATE TABLE `teacher_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `type` enum('present','permanent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upazila` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_office` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_addresses`
--

INSERT INTO `teacher_addresses` (`id`, `teacher_id`, `type`, `village`, `district`, `upazila`, `post_office`, `postal_code`, `created_at`, `updated_at`) VALUES
(4, 18, 'permanent', 'Kazipara', 'Natore', 'Natore Sadar', 'Baraigram', '8085', '2025-08-25 11:41:13', '2025-08-25 11:41:13');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_educations`
--

CREATE TABLE `teacher_educations` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `level` enum('SSC','HSC','Graduation','Masters') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roll_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `board_university` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passing_year` year DEFAULT NULL,
  `course_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_educations`
--

INSERT INTO `teacher_educations` (`id`, `teacher_id`, `level`, `roll_number`, `board_university`, `result`, `passing_year`, `course_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 18, 'SSC', '158088', 'Dhaka Board', '4.25', '2007', NULL, '2025-08-25 11:38:40', '2025-08-25 11:38:40', NULL),
(9, 18, 'HSC', '169490', 'Dhaka Board', '4.45', '2009', NULL, '2025-08-25 11:39:02', '2025-08-25 11:39:02', NULL),
(10, 18, 'Graduation', NULL, 'National University', '3.75', '2013', '4', '2025-08-25 11:39:28', '2025-08-25 11:39:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','teacher','staff','editor','student','parent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sanjoy Kundu', 'sanjoykundu187@gmail.com', NULL, '$2y$12$A841J.k.5YoGiqFyu4DUjuCy1YJb31i8oPYbdraSc3Tt6jT3nvXJu', 'admin', NULL, NULL, '2025-08-18 05:57:23', '2025-08-18 05:57:23'),
(2, 'Romen Munshi', 'romen@gmail.com', NULL, '$2y$12$q/nKeH4EFQmAd19k8t5Ql.Pbua9hkMQhm.Jf.VWRaC0OD1Jh5CwjG', 'editor', NULL, NULL, '2025-08-18 06:08:34', '2025-08-22 11:23:42'),
(3, 'Zihad Hossain', 'zihad@gmail.com', NULL, '$2y$12$SJCQLBzekb6leCrhG2aTp.FwHwMpEgJDDIntz1ckdsM4CCZ8P8ozy', 'editor', NULL, NULL, '2025-08-18 08:12:40', '2025-09-18 11:54:35'),
(27, 'Rubel Khan', 'khan@gmail.com', NULL, '$2y$12$xebBIxKlXeAo5jwoNGTK/eVocdi23DxFRln.CYPXPieNDSarzKHWG', 'editor', NULL, NULL, '2025-08-21 04:38:50', '2025-08-21 04:38:50'),
(31, 'Sunmon Roy', 'sunmon@gmail.com', NULL, '$2y$12$4rqkS4DgjiYXdlVr/iTA.eGS2qk/Fyi0Rou08aSCGX90aGsGNVVgW', 'editor', NULL, NULL, '2025-08-21 06:30:58', '2025-08-23 06:29:14'),
(34, 'Himel Chowdhury', 'himel@gmail.com', NULL, '$2y$12$ZxatexJ6qZPTzOeNoSJyD.p4bVp26m7n3hzdvqK/fUVmukShwi7QC', 'editor', NULL, NULL, '2025-08-21 08:25:40', '2025-08-21 08:34:55'),
(37, 'MD. Enamul Haque', 'enamul112haque@gmail.com', NULL, '$2y$12$zofWLxqberUT/8JX3zASqeWJFloe7yUburpaMFU/9ogNTV.1Ji312', 'teacher', NULL, NULL, '2025-08-25 11:31:03', '2025-08-25 11:32:08'),
(38, 'Abdur Rahman', 'abdur101@gmail.com', NULL, '$2y$12$iw62wVXszbRJdninb7tkdO0dYyNRIN8QvL3gKoghNu93A8fCad80W', 'teacher', NULL, NULL, '2025-08-27 07:15:08', '2025-08-27 07:59:00'),
(39, 'Kaniz Fatema', 'kanizfatema10@gmail.com', NULL, '$2y$12$VcGoAwWn6BYLT3ze3q5MgOORLAd69YVXzHAl0uKNH0D1Sj9LkHPca', 'teacher', NULL, NULL, '2025-09-05 06:33:50', '2025-09-05 06:36:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_sections`
--
ALTER TABLE `academic_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_sections_institution_id_foreign` (`institution_id`),
  ADD KEY `academic_sections_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_phone_unique` (`phone`),
  ADD UNIQUE KEY `admins_nid_unique` (`nid`),
  ADD KEY `admins_user_id_foreign` (`user_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_user_id_foreign` (`user_id`),
  ADD KEY `announcements_class_id_foreign` (`class_id`);

--
-- Indexes for table `class_models`
--
ALTER TABLE `class_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_models_academic_section_id_foreign` (`academic_section_id`),
  ADD KEY `class_models_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_institution_id_foreign` (`institution_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divisions_class_id_foreign` (`class_id`),
  ADD KEY `divisions_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `editors`
--
ALTER TABLE `editors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `editors_user_id_institution_id_unique` (`user_id`,`institution_id`),
  ADD UNIQUE KEY `editors_phone_unique` (`phone`),
  ADD UNIQUE KEY `editors_nid_unique` (`nid`),
  ADD KEY `editors_institution_id_foreign` (`institution_id`);

--
-- Indexes for table `editor_addresses`
--
ALTER TABLE `editor_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `editor_addresses_editor_id_foreign` (`editor_id`);

--
-- Indexes for table `editor_educations`
--
ALTER TABLE `editor_educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `editor_educations_editor_id_foreign` (`editor_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grading_scales`
--
ALTER TABLE `grading_scales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_class_grade` (`class_id`,`grade`),
  ADD KEY `grading_scales_user_id_foreign` (`user_id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `institutions_admin_id_foreign` (`admin_id`),
  ADD KEY `institutions_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `papers_subject_id_foreign` (`subject_id`),
  ADD KEY `papers_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `password_otps`
--
ALTER TABLE `password_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_otps_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_class_id_foreign` (`class_id`),
  ADD KEY `subjects_division_id_foreign` (`division_id`),
  ADD KEY `subjects_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_user_id_institution_id_unique` (`user_id`,`institution_id`),
  ADD UNIQUE KEY `teachers_phone_unique` (`phone`),
  ADD UNIQUE KEY `teachers_nid_unique` (`nid`),
  ADD KEY `teachers_added_by_foreign` (`added_by`),
  ADD KEY `teachers_institution_id_foreign` (`institution_id`),
  ADD KEY `teachers_designation_id_foreign` (`designation_id`);

--
-- Indexes for table `teacher_addresses`
--
ALTER TABLE `teacher_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_addresses_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `teacher_educations`
--
ALTER TABLE `teacher_educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_educations_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_sections`
--
ALTER TABLE `academic_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `class_models`
--
ALTER TABLE `class_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `editors`
--
ALTER TABLE `editors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `editor_addresses`
--
ALTER TABLE `editor_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `editor_educations`
--
ALTER TABLE `editor_educations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grading_scales`
--
ALTER TABLE `grading_scales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `papers`
--
ALTER TABLE `papers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `password_otps`
--
ALTER TABLE `password_otps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `teacher_addresses`
--
ALTER TABLE `teacher_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teacher_educations`
--
ALTER TABLE `teacher_educations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_sections`
--
ALTER TABLE `academic_sections`
  ADD CONSTRAINT `academic_sections_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `academic_sections_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `class_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_models`
--
ALTER TABLE `class_models`
  ADD CONSTRAINT `class_models_academic_section_id_foreign` FOREIGN KEY (`academic_section_id`) REFERENCES `academic_sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_models_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designations_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `divisions`
--
ALTER TABLE `divisions`
  ADD CONSTRAINT `divisions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `divisions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `class_models` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `editors`
--
ALTER TABLE `editors`
  ADD CONSTRAINT `editors_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `editors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `editor_addresses`
--
ALTER TABLE `editor_addresses`
  ADD CONSTRAINT `editor_addresses_editor_id_foreign` FOREIGN KEY (`editor_id`) REFERENCES `editors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `editor_educations`
--
ALTER TABLE `editor_educations`
  ADD CONSTRAINT `editor_educations_editor_id_foreign` FOREIGN KEY (`editor_id`) REFERENCES `editors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grading_scales`
--
ALTER TABLE `grading_scales`
  ADD CONSTRAINT `grading_scales_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `class_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grading_scales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `institutions`
--
ALTER TABLE `institutions`
  ADD CONSTRAINT `institutions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `institutions_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `papers`
--
ALTER TABLE `papers`
  ADD CONSTRAINT `papers_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `papers_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subjects_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `class_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subjects_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teachers_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teachers_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_addresses`
--
ALTER TABLE `teacher_addresses`
  ADD CONSTRAINT `teacher_addresses_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_educations`
--
ALTER TABLE `teacher_educations`
  ADD CONSTRAINT `teacher_educations_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
