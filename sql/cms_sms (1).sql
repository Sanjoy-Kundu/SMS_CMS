-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 15, 2025 at 02:49 AM
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
(2, 3, 2, 'college', 'APE-101-DFG', '1999-01-01', 'Approval', 'Heigher Secondary', '2025-08-13 05:04:29', '2025-08-13 08:02:21', NULL),
(3, 3, 2, 'school', 'AEP-102', '2000-01-01', 'Final Approval', 'Secondary', '2025-08-13 05:05:25', '2025-08-13 08:02:25', NULL),
(8, 7, 1, 'school', NULL, '2005-01-01', 'Approval', 'Secondary', '2025-08-13 08:08:01', '2025-08-13 08:08:14', NULL);

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
(1, 4, '01759351546', 'Madaripur Sadar, Mdaripur-7902', '/uploads/admin/profile/1754922740_6899fef4b18e4.jpg', '1997-01-01', '981574751005', 'male', 1, '2025-08-10 07:49:45', '2025-08-11 08:39:02'),
(2, 5, '01873428918', 'Madaripur-7902, Dhaka, Banagladesh', '/uploads/admin/profile/1754998542_689b270e32e73.jpg', '1998-01-01', '1122365874150', 'male', 1, '2025-08-10 08:03:24', '2025-08-12 05:35:42');

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
(1, 8, 1, 'Six', NULL, '2025-08-13 11:09:13', '2025-08-13 11:09:41'),
(2, 3, 2, 'Six', NULL, '2025-08-13 11:10:40', '2025-08-13 11:10:40'),
(3, 3, 2, 'Seven', NULL, '2025-08-13 11:10:47', '2025-08-13 11:10:47'),
(4, 3, 2, 'Eight', NULL, '2025-08-13 11:10:53', '2025-08-13 11:10:53'),
(5, 3, 2, 'Nine', NULL, '2025-08-13 11:11:01', '2025-08-13 11:11:01'),
(6, 3, 2, 'Ten', NULL, '2025-08-13 11:11:09', '2025-08-13 11:11:09'),
(7, 2, 2, 'Eleven', NULL, '2025-08-13 11:11:20', '2025-08-13 11:11:20'),
(8, 2, 2, 'Twelve', NULL, '2025-08-13 11:11:27', '2025-08-13 11:13:35');

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
(1, 5, 2, 'Science', NULL, '2025-08-13 12:08:25', '2025-08-13 12:08:25'),
(2, 5, 2, 'Arts', NULL, '2025-08-13 12:11:26', '2025-08-13 12:11:26'),
(3, 5, 2, 'Commerce', NULL, '2025-08-13 12:17:39', '2025-08-13 12:18:26'),
(4, 6, 2, 'Science', NULL, '2025-08-13 12:18:07', '2025-08-13 12:18:07'),
(5, 6, 2, 'Commerce', NULL, '2025-08-13 12:18:15', '2025-08-13 12:19:46'),
(6, 6, 2, 'Arts', NULL, '2025-08-13 12:18:20', '2025-08-13 12:19:42'),
(7, 7, 2, 'Science', NULL, '2025-08-13 13:32:02', '2025-08-13 13:32:02'),
(8, 8, 2, 'Science', NULL, '2025-08-13 13:32:31', '2025-08-13 13:32:31'),
(9, 7, 2, 'Arts', NULL, '2025-08-13 13:32:42', '2025-08-13 13:32:42'),
(10, 8, 2, 'Arts', NULL, '2025-08-13 13:32:46', '2025-08-13 13:32:46');

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
(3, 2, 'SB School & College', 'combined', '10118', 'Dhanmondi,22/7 Plot-B, Dhaka, Bangladesh', NULL, '2025-08-12 11:20:25', '2025-08-14 12:08:39', NULL),
(7, 1, 'ABC Scholl', 'school', '101', 'Dhaka', NULL, '2025-08-13 08:07:06', '2025-08-13 08:07:06', NULL);

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
(6, '2025_08_10_133333_create_admins_table', 2),
(7, '2025_08_11_185543_create_password_otps_table', 3),
(9, '2025_08_12_114312_create_institutions_table', 4),
(10, '2025_08_13_013113_create_academic_sections_table', 5),
(12, '2025_08_13_122018_create_class_models_table', 6),
(13, '2025_08_13_172006_create_divisions_table', 7),
(15, '2025_08_13_183253_create_subjects_table', 8),
(16, '2025_08_14_194548_create_papers_table', 9);

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

--
-- Dumping data for table `password_otps`
--

INSERT INTO `password_otps` (`id`, `email`, `otp`, `created_at`, `expires_at`) VALUES
(1, 'admin@gmail.com', '808114', '2025-08-11 15:09:54', '2025-08-11 15:19:54');

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
(3, 'App\\Models\\User', 4, 'token', 'a0f212165cf1256d8e15d070327be4b6a9454b1fc186c14850980619a497cbe4', '[\"*\"]', NULL, NULL, '2025-08-10 08:41:08', '2025-08-10 08:41:08'),
(4, 'App\\Models\\User', 5, 'token', '14386c9a5a9943191fa84cc6da13fcc8cd73a382cd9bec5e60d843a3f12dc92d', '[\"*\"]', NULL, NULL, '2025-08-11 05:58:38', '2025-08-11 05:58:38'),
(5, 'App\\Models\\User', 5, 'token', '2520bc684ed493a008af2452cd77a1be7aa1570f0598b5b3d55a766dcff118aa', '[\"*\"]', NULL, NULL, '2025-08-11 06:00:16', '2025-08-11 06:00:16'),
(6, 'App\\Models\\User', 5, 'token', '045620df8cca2e02993cd42329b9653cafb571c7ef20b1e74242f9dcc04a4894', '[\"*\"]', NULL, NULL, '2025-08-11 06:00:24', '2025-08-11 06:00:24'),
(8, 'App\\Models\\User', 4, 'token', '1c31162010a8797e2783f1313f2743121e1553fee3d4cc5eb538a26e949fbadb', '[\"*\"]', '2025-08-11 08:02:34', NULL, '2025-08-11 06:49:13', '2025-08-11 08:02:34'),
(9, 'App\\Models\\User', 5, 'token', '2925198b2797d03973aaaac0055d23ebe98f720d751340ee0aa6720fa92d8102', '[\"*\"]', '2025-08-11 08:03:06', NULL, '2025-08-11 08:02:52', '2025-08-11 08:03:06'),
(11, 'App\\Models\\User', 4, 'token', 'a87a9eb4d0e266bbc3ba78cd2a8f154419d180fa1876eac7c88852dcaf9c8e70', '[\"*\"]', '2025-08-11 08:47:39', NULL, '2025-08-11 08:08:44', '2025-08-11 08:47:39'),
(12, 'App\\Models\\User', 4, 'token', '69fd46d8793428682d3ad4b4e6152b1d8d946e9d2f015838fa30f028f4939829', '[\"*\"]', '2025-08-11 12:46:21', NULL, '2025-08-11 11:21:04', '2025-08-11 12:46:21'),
(13, 'App\\Models\\User', 4, 'token', 'b68812ce121c40d2c10bbe7c0ccd95b22312550f3bf96c18ca5ac260e5e7e40a', '[\"*\"]', '2025-08-11 14:55:36', NULL, '2025-08-11 12:46:44', '2025-08-11 14:55:36'),
(14, 'App\\Models\\User', 5, 'token', '3151603a7281611f2c66779b444576bcae1c82160816776022e8d4c1acde4acd', '[\"*\"]', NULL, NULL, '2025-08-11 15:03:26', '2025-08-11 15:03:26'),
(15, 'App\\Models\\User', 5, 'token', '8dc6bf54df2a26a39a0eaf0e8e5628659caf807333180abcd3544d75b3441649', '[\"*\"]', NULL, NULL, '2025-08-11 15:03:38', '2025-08-11 15:03:38'),
(16, 'App\\Models\\User', 4, 'token', 'e4833e1ba91a6921d3d3de538d86bbd244e97a37c0feeaee8dbfb925b17d0077', '[\"*\"]', NULL, NULL, '2025-08-11 15:04:11', '2025-08-11 15:04:11'),
(17, 'App\\Models\\User', 5, 'token', '1d12652a82a699e25fdd400417ce46e5e3eb0445b117e208ff22a30db16e4778', '[\"*\"]', NULL, NULL, '2025-08-11 15:06:10', '2025-08-11 15:06:10'),
(18, 'App\\Models\\User', 4, 'token', 'df65908b7ec5ed03f97dfbce327dfcbb68ad8f1d150ba1b83ce85dd7d303960f', '[\"*\"]', '2025-08-11 15:21:32', NULL, '2025-08-11 15:09:54', '2025-08-11 15:21:32'),
(19, 'App\\Models\\User', 5, 'token', '06b330fce64f5a017db1cb096645f5bf43d8e6dd47e36acdd8d4dbcdeaf69ac3', '[\"*\"]', '2025-08-11 15:23:42', NULL, '2025-08-11 15:21:44', '2025-08-11 15:23:42'),
(20, 'App\\Models\\User', 5, 'token', 'd3dbf5d756768ce4b88839a869c21130a6c7422d12bff369f68eac6a2a7b793b', '[\"*\"]', '2025-08-12 04:30:03', NULL, '2025-08-12 04:28:48', '2025-08-12 04:30:03'),
(23, 'App\\Models\\User', 5, 'token', '28f3a93bb15922909f34a6d7074403da4f7cbc6397e8fe69236e92eb5a5d8b27', '[\"*\"]', '2025-08-12 04:36:21', NULL, '2025-08-12 04:35:51', '2025-08-12 04:36:21'),
(24, 'App\\Models\\User', 5, 'token', 'f3ad800033662cb60e5953ce5ae1e579c31f1d04cc3ebb557c4aa2a136417983', '[\"*\"]', '2025-08-12 05:20:09', NULL, '2025-08-12 04:40:03', '2025-08-12 05:20:09'),
(25, 'App\\Models\\User', 5, 'token', 'a4c1bbb53ca0290ee3693b099688e455629338636b6b2054087d74bcef61174b', '[\"*\"]', '2025-08-12 05:31:32', NULL, '2025-08-12 05:28:56', '2025-08-12 05:31:32'),
(26, 'App\\Models\\User', 5, 'token', '1207fe8e14735018028a160132c835eae37b212deeb2844bbc5efb6d563f0869', '[\"*\"]', '2025-08-12 09:02:57', NULL, '2025-08-12 05:32:00', '2025-08-12 09:02:57'),
(27, 'App\\Models\\User', 5, 'token', 'b85a32551b5e790290a2e6e1e66060c52a5f8237c1a732d50870dbb46bd3aed1', '[\"*\"]', '2025-08-12 21:19:42', NULL, '2025-08-12 10:13:16', '2025-08-12 21:19:42'),
(29, 'App\\Models\\User', 5, 'token', '0559dce745e6bd9c8834f019a40c72e36c2741c6c60146b6917644c668c36cbc', '[\"*\"]', '2025-08-13 07:56:05', NULL, '2025-08-13 07:55:04', '2025-08-13 07:56:05'),
(32, 'App\\Models\\User', 5, 'token', '558eb3e33f1789fe9d6ee961e411e6b5257bccf6399234688e41c521f7a9e35f', '[\"*\"]', '2025-08-14 08:44:01', NULL, '2025-08-13 11:10:10', '2025-08-14 08:44:01'),
(33, 'App\\Models\\User', 5, 'token', '76ea2449d0a4dd781e7ddbe37b2062247dfc6fd488672407a6f58ad773da1214', '[\"*\"]', '2025-08-14 11:22:01', NULL, '2025-08-14 11:08:05', '2025-08-14 11:22:01'),
(34, 'App\\Models\\User', 5, 'token', 'e5eb4d8c8bae307467e2c08623570e04b3b1e3dd2448499421ab8849ea0cda32', '[\"*\"]', '2025-08-14 13:39:50', NULL, '2025-08-14 11:38:02', '2025-08-14 13:39:50'),
(35, 'App\\Models\\User', 5, 'token', 'ab8b832e7524be527bcfae1d9658b31581a8836bf9f5939a433196f2c6fb81ff', '[\"*\"]', '2025-08-14 20:48:21', NULL, '2025-08-14 20:42:12', '2025-08-14 20:48:21');

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
(1, 2, NULL, 2, 'Bangla', NULL, 'compulsory', 1, '2025-08-14 13:26:29', '2025-08-14 13:26:56', NULL),
(2, 2, NULL, 2, 'English', NULL, 'compulsory', 1, '2025-08-14 13:28:48', '2025-08-14 13:28:48', NULL),
(3, 2, NULL, 2, 'Mathematics', '505', 'compulsory', 1, '2025-08-14 13:28:57', '2025-08-14 13:39:16', NULL),
(4, 2, NULL, 2, 'Science', '506', 'compulsory', 1, '2025-08-14 13:39:50', '2025-08-14 13:39:50', NULL),
(5, 5, 1, 2, 'Physic', NULL, 'additional', 1, '2025-08-14 20:42:35', '2025-08-14 20:42:35', NULL),
(6, 5, 1, 2, 'Chemistry', NULL, 'additional', 1, '2025-08-14 20:42:53', '2025-08-14 20:42:53', NULL),
(7, 5, 1, 2, 'Biology', NULL, 'additional', 1, '2025-08-14 20:43:17', '2025-08-14 20:43:17', NULL),
(8, 5, 1, 2, 'HigherMath', NULL, 'optional', 1, '2025-08-14 20:43:42', '2025-08-14 20:43:42', NULL),
(9, 5, 1, 2, 'Agriculture', NULL, 'optional', 1, '2025-08-14 20:44:16', '2025-08-14 20:44:16', NULL),
(10, 5, 2, 2, 'History', NULL, 'additional', 1, '2025-08-14 20:44:57', '2025-08-14 20:44:57', NULL),
(11, 5, 2, 2, 'Political Science', NULL, 'additional', 1, '2025-08-14 20:45:13', '2025-08-14 20:45:13', NULL),
(12, 5, 2, 2, 'Economics', NULL, 'additional', 1, '2025-08-14 20:45:31', '2025-08-14 20:45:31', NULL),
(13, 5, 2, 2, 'Agriculture', NULL, 'optional', 1, '2025-08-14 20:45:50', '2025-08-14 20:45:50', NULL),
(14, 5, 3, 2, 'Accounting', NULL, 'additional', 1, '2025-08-14 20:46:30', '2025-08-14 20:46:30', NULL),
(15, 5, 3, 2, 'Business Studies', NULL, 'additional', 1, '2025-08-14 20:46:52', '2025-08-14 20:46:52', NULL),
(16, 5, 3, 2, 'Finance', NULL, 'additional', 1, '2025-08-14 20:47:11', '2025-08-14 20:47:11', NULL),
(17, 5, 3, 2, 'Agriculture', NULL, 'optional', 1, '2025-08-14 20:47:30', '2025-08-14 20:47:30', NULL),
(18, 5, NULL, 2, 'Bangla', NULL, 'compulsory', 1, '2025-08-14 20:47:50', '2025-08-14 20:47:50', NULL),
(19, 5, NULL, 2, 'English', NULL, 'compulsory', 1, '2025-08-14 20:48:01', '2025-08-14 20:48:01', NULL),
(20, 5, NULL, 2, 'Mathematics', NULL, 'compulsory', 1, '2025-08-14 20:48:09', '2025-08-14 20:48:09', NULL),
(21, 5, NULL, 2, 'Ict', NULL, 'compulsory', 1, '2025-08-14 20:48:21', '2025-08-14 20:48:21', NULL);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'admin', 'admin@gmail.com', NULL, '$2y$12$yn6ym0aUNy6wrhT2dK9H1.j331bi17H4OyRdc3HIP5oM24oNcgxoi', 'admin', NULL, '2025-08-10 07:49:45', '2025-08-11 12:46:22'),
(5, 'Sanjoy Kundu', 'sanjoykundu187@gmail.com', NULL, '$2y$12$IH.5zb2fPOw9.CFGAE.VyOWGP3Jujb.Mz/AaEOC5bi045rmRySgwm', 'admin', NULL, '2025-08-10 08:03:24', '2025-08-13 07:56:17');

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
-- Indexes for table `class_models`
--
ALTER TABLE `class_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_models_academic_section_id_foreign` (`academic_section_id`),
  ADD KEY `class_models_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divisions_class_id_foreign` (`class_id`),
  ADD KEY `divisions_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class_models`
--
ALTER TABLE `class_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `papers`
--
ALTER TABLE `papers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_otps`
--
ALTER TABLE `password_otps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `class_models`
--
ALTER TABLE `class_models`
  ADD CONSTRAINT `class_models_academic_section_id_foreign` FOREIGN KEY (`academic_section_id`) REFERENCES `academic_sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_models_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `divisions`
--
ALTER TABLE `divisions`
  ADD CONSTRAINT `divisions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `divisions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `class_models` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
