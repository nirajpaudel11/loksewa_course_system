-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2026 at 10:41 AM
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
-- Database: `loksewa_course`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1777835169),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1777835169;', 1777835169),
('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:2;', 1784863190),
('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1784863190;', 1784863190),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}', 1784949558);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `module_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES
(35, 35, 'Geography and History of Nepal', 'geography-and-history-of-nepal', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(36, 36, 'Numerical and Verbal Reasoning', 'numerical-and-verbal-reasoning', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(37, 37, 'Nepal Rastra Bank Act, 2058', 'nepal-rastra-bank-act-2058', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(38, 38, 'Banking Accounting Principles', 'banking-accounting-principles', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(39, 39, 'Concepts of Governance and Administration', 'concepts-of-governance-and-administration', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(40, 40, 'Filing Systems and Record Management', 'filing-systems-and-record-management', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `level` varchar(255) NOT NULL DEFAULT 'beginner',
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `trending_score` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `level`, `is_published`, `created_at`, `updated_at`, `trending_score`) VALUES
(1, 'Nayab Subba Tayari', 'nayab_subba', 'Complete preparation course for Nayab Subba covering General Knowledge (GK), IQ, and General Administration.', 'course-thumbnails/01KQQJT72T7721JDYJFWCTSTSK.jpg', 'intermediate', 1, '2026-05-03 10:00:38', '2026-07-23 22:02:38', 0.13065211894732),
(2, 'Nepal Rastra Bank Tayari(Assistant Director)', 'rastra_bank_ad', 'Premium syllabus covering Macroeconomics, Nepalese Financial System, Banking Laws, and Corporate Governance.', 'course-thumbnails/01KQQK60JBD3MHXRT7FQQTY9EX.jpg', 'advanced', 1, '2026-05-03 10:00:38', '2026-07-23 22:02:38', 0.14252958430617),
(3, 'Nepal Rastra Bank Tayari(Officer)', 'rastra_bank_o', 'Comprehensive course for Officer level preparation, highlighting Accounting, Management, IT, and Commercial Banking.', 'course-thumbnails/01KQQKC383PKTG3YA1427VGNYW.jpg', 'advanced', 1, '2026-05-03 10:00:38', '2026-07-23 22:02:38', 0.11877465358848),
(4, 'Section Officer', 'sec_off', 'Ultimate syllabus preparation guide for Gazetted Third Class Section Officer position in administrative service.', 'course-thumbnails/01KQQKGSBBVTHZ9QRPJQMFZX2P.jpg', 'advanced', 1, '2026-05-03 10:00:38', '2026-07-23 22:02:38', 0.083142257511934),
(5, 'Kharidar', 'kharidar', 'Complete preparation course for Kharidar level focusing on general knowledge, office procedures, and job knowledge.', 'course-thumbnails/01KQQKNXE8YCS4TZ1ECX62BSZR.jpg', 'beginner', 1, '2026-05-03 12:49:00', '2026-07-23 22:02:38', 0.11908166398448);

-- --------------------------------------------------------

--
-- Table structure for table `course_prerequisites`
--

CREATE TABLE `course_prerequisites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `prerequisite_course_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_prerequisites`
--

INSERT INTO `course_prerequisites` (`id`, `course_id`, `prerequisite_course_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, NULL, NULL),
(2, 4, 1, NULL, NULL),
(3, 3, 5, NULL, NULL),
(4, 2, 4, NULL, NULL),
(5, 2, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `progress_percentage` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'active', 0, '2026-05-03 10:27:08', '2026-06-02 15:19:19'),
(6, 2, 1, 'completed', 100, '2026-06-02 21:43:23', '2026-06-02 21:43:39'),
(7, 1, 1, 'completed', 100, '2026-07-18 01:42:42', '2026-07-18 01:44:14'),
(8, 3, 1, 'active', 60, '2026-07-22 14:02:38', '2026-07-23 22:02:38'),
(9, 3, 2, 'active', 72, '2026-07-21 01:02:38', '2026-07-23 22:02:38'),
(10, 3, 3, 'active', 67, '2026-07-10 09:02:38', '2026-07-23 22:02:38'),
(11, 4, 1, 'active', 87, '2026-07-20 16:02:38', '2026-07-23 22:02:38'),
(12, 4, 2, 'active', 81, '2026-07-17 23:02:38', '2026-07-23 22:02:38'),
(13, 4, 3, 'active', 76, '2026-07-12 22:02:38', '2026-07-23 22:02:38'),
(14, 5, 1, 'active', 67, '2026-07-20 11:02:38', '2026-07-23 22:02:38'),
(15, 5, 2, 'active', 18, '2026-07-20 13:02:38', '2026-07-23 22:02:38'),
(16, 5, 3, 'active', 77, '2026-07-10 23:02:38', '2026-07-23 22:02:38'),
(17, 6, 1, 'completed', 92, '2026-07-22 02:02:38', '2026-07-23 22:02:38'),
(18, 6, 2, 'completed', 93, '2026-07-18 03:02:38', '2026-07-23 22:02:38'),
(19, 6, 3, 'active', 63, '2026-07-08 01:02:38', '2026-07-23 22:02:38'),
(21, 7, 2, 'completed', 95, '2026-07-20 10:02:38', '2026-07-23 22:02:38'),
(22, 7, 3, 'active', 46, '2026-07-12 17:02:38', '2026-07-23 22:02:38'),
(23, 8, 1, 'active', 39, '2026-07-17 23:02:38', '2026-07-23 22:02:38'),
(24, 8, 4, 'active', 13, '2026-07-11 01:02:38', '2026-07-23 22:02:38'),
(25, 8, 5, 'active', 79, '2026-06-25 12:02:38', '2026-07-23 22:02:38'),
(26, 9, 1, 'active', 51, '2026-07-19 07:02:38', '2026-07-23 22:02:38'),
(27, 9, 4, 'active', 68, '2026-07-05 11:02:38', '2026-07-23 22:02:38'),
(28, 9, 5, 'active', 19, '2026-06-27 10:02:38', '2026-07-23 22:02:38'),
(29, 10, 1, 'active', 86, '2026-07-16 03:02:38', '2026-07-23 22:02:38'),
(30, 10, 4, 'active', 42, '2026-07-07 06:02:38', '2026-07-23 22:02:38'),
(31, 10, 5, 'active', 64, '2026-06-28 03:02:38', '2026-07-23 22:02:38'),
(32, 11, 1, 'active', 76, '2026-07-19 06:02:38', '2026-07-23 22:02:38'),
(33, 11, 4, 'active', 46, '2026-07-04 02:02:38', '2026-07-23 22:02:38'),
(34, 11, 5, 'active', 72, '2026-06-25 22:02:38', '2026-07-23 22:02:38'),
(35, 12, 1, 'active', 46, '2026-07-19 17:02:38', '2026-07-23 22:02:38'),
(36, 12, 4, 'active', 38, '2026-07-05 21:02:38', '2026-07-23 22:02:38'),
(37, 12, 5, 'active', 38, '2026-06-24 08:02:38', '2026-07-23 22:02:38'),
(38, 13, 2, 'active', 27, '2026-07-19 04:02:38', '2026-07-23 22:02:38'),
(39, 13, 3, 'active', 19, '2026-07-09 10:02:38', '2026-07-23 22:02:38'),
(40, 13, 5, 'active', 56, '2026-06-30 14:02:38', '2026-07-23 22:02:38'),
(41, 14, 2, 'active', 22, '2026-07-21 22:02:38', '2026-07-23 22:02:38'),
(42, 14, 3, 'active', 29, '2026-07-12 02:02:38', '2026-07-23 22:02:38'),
(43, 14, 5, 'active', 71, '2026-06-26 00:02:38', '2026-07-23 22:02:38'),
(44, 15, 2, 'active', 56, '2026-07-20 15:02:38', '2026-07-23 22:02:38'),
(45, 15, 3, 'active', 70, '2026-07-15 05:02:38', '2026-07-23 22:02:38'),
(46, 15, 5, 'active', 57, '2026-07-01 00:02:38', '2026-07-23 22:02:38'),
(47, 16, 2, 'completed', 92, '2026-07-20 03:02:38', '2026-07-23 22:02:38'),
(48, 16, 3, 'active', 17, '2026-07-12 07:02:38', '2026-07-23 22:02:38'),
(49, 16, 5, 'active', 17, '2026-07-01 22:02:38', '2026-07-23 22:02:38'),
(50, 17, 2, 'active', 13, '2026-07-19 08:02:38', '2026-07-23 22:02:38'),
(51, 17, 3, 'active', 72, '2026-07-10 20:02:38', '2026-07-23 22:02:38'),
(52, 17, 5, 'completed', 94, '2026-06-30 12:02:38', '2026-07-23 22:02:38'),
(53, 3, 4, 'active', 36, '2026-07-13 23:02:38', '2026-07-23 22:02:38'),
(54, 4, 4, 'active', 75, '2026-07-13 09:02:38', '2026-07-23 22:02:38'),
(55, 8, 2, 'active', 39, '2026-07-18 15:02:38', '2026-07-23 22:02:38'),
(56, 9, 2, 'active', 52, '2026-07-17 09:02:38', '2026-07-23 22:02:38'),
(57, 7, 1, 'active', 0, '2026-07-23 22:37:08', '2026-07-23 22:37:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chapter_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `type` enum('text','video','pdf','quiz') NOT NULL DEFAULT 'text',
  `order` int(11) NOT NULL DEFAULT 0,
  `duration_minutes` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES
(54, 35, 'Physical Geography of Nepal', 'physical-geography-of-nepal', '<h3>Physical Divisions of Nepal</h3><p>Nepal is divided into three main ecological regions:</p><ul><li><strong>Himalayan Region:</strong> Covers 15% of the total land area. It lies in the north and ranges from 3,000m to 8,848.86m altitude.</li><li><strong>Hilly Region:</strong> Covers 68% of the total land area. It lies in the middle and contains valleys like Kathmandu and Pokhara.</li><li><strong>Terai Region:</strong> Covers 17% of the total land area. It lies in the south and is the agricultural breadbasket of Nepal.</li></ul><h3>Major Rivers and Water Resources</h3><p>Nepal is highly rich in water resources, divided into three major river systems:</p><ol><li><strong>Koshi River System:</strong> The largest river system in Nepal (eastern part).</li><li><strong>Gandaki River System:</strong> The deepest river system (central part).</li><li><strong>Karnali River System:</strong> The longest river system (western part).</li></ol>', NULL, 'storage/notes/Sample questions.pdf', 'text', 1, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(55, 35, 'Official Nayab Subba Syllabus PDF', 'official-nayab-subba-syllabus-pdf', 'Download and print the official Loksewa syllabus for Nayab Subba to plan your learning journey.', NULL, 'storage/notes/Sample questions.pdf', 'pdf', 2, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(56, 35, 'Geography GK Assessment', 'geography-gk-assessment', '[{\"question\":\"What percentage of Nepal\'s total land area is covered by the Hilly Region?\",\"options\":[\"15%\",\"68%\",\"17%\",\"50%\"],\"answer\":1,\"explanation\":\"The Hilly Region covers approximately 68% of Nepal\'s total land area, consisting of several valleys, basins, and low mountain ranges.\"},{\"question\":\"Which is the longest river system in Nepal?\",\"options\":[\"Koshi\",\"Gandaki\",\"Karnali\",\"Bagmati\"],\"answer\":2,\"explanation\":\"The Karnali River is the longest river system in Nepal, flowing from the Himalayas of Tibet down to India.\"},{\"question\":\"What is the exact height of Mount Everest as agreed by Nepal and China in 2020?\",\"options\":[\"8848 meters\",\"8848.48 meters\",\"8848.86 meters\",\"8850 meters\"],\"answer\":2,\"explanation\":\"The officially recognized and measured height of Mount Everest is 8848.86 meters.\"}]', NULL, NULL, 'quiz', 3, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(57, 36, 'Verbal Analogy and Series Methods', 'verbal-analogy-and-series-methods', '<h3>Understanding Verbal Series</h3><p>Verbal series questions test your ability to recognize logical patterns in letter structures, word formations, and conceptual sequences. Here are the core methods to solve them quickly:</p><ul><li><strong>Letter Spacing:</strong> Check the intervals between letters (e.g., A, C, E, G, ... has an interval of +2).</li><li><strong>Reverse Positions:</strong> Remember the alphabetical ranking from both ends (A=1, Z=26; Z=1, A=26).</li><li><strong>Vowel-Consonant Patterns:</strong> Some series switch strictly based on English vowels (A, E, I, O, U).</li></ul>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(58, 36, 'IQ Mini Test', 'iq-mini-test', '[{\"question\":\"Find the next term in the series: B, D, F, H, ?\",\"options\":[\"I\",\"J\",\"K\",\"L\"],\"answer\":1,\"explanation\":\"The series advances by skipping one letter each time (+2 interval). After H, skipping I gives J.\"},{\"question\":\"If LION is coded as MJPO, how is TIGER coded?\",\"options\":[\"UJHFS\",\"UKHFS\",\"UJGFS\",\"UIHFS\"],\"answer\":0,\"explanation\":\"Each letter in the word is shifted forward by one position (+1). T->U, I->J, G->H, E->F, R->S.\"}]', NULL, NULL, 'quiz', 2, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(59, 37, 'Objectives and Functions of NRB', 'objectives-and-functions-of-nrb', '<h3>Objectives of NRB (Section 4)</h3><p>According to Section 4 of the NRB Act, 2058, the central bank is established with the following primary objectives:</p><ul><li>To formulate and manage necessary monetary and foreign exchange policies to maintain price stability and balance of payment stability.</li><li>To promote stability and healthy growth of banking and financial sectors.</li><li>To develop a secure, healthy, and efficient payment system.</li></ul><h3>Core Functions of NRB</h3><p>NRB acts as the supervisor, regulator, bank of banks, and financial advisor to the Government of Nepal.</p>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(60, 37, 'NRB Act Section 4 Quiz', 'nrb-act-section-4-quiz', '[{\"question\":\"Under which section of the Nepal Rastra Bank Act, 2058 are the objectives of the Bank defined?\",\"options\":[\"Section 3\",\"Section 4\",\"Section 5\",\"Section 10\"],\"answer\":1,\"explanation\":\"Section 4 of the Nepal Rastra Bank Act, 2058 explicitly defines the objectives of the central bank.\"}]', NULL, NULL, 'quiz', 2, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(61, 38, 'Double Entry System and Bank Ledgers', 'double-entry-system-and-bank-ledgers', '<h3>Double Entry System in Banking</h3><p>Every transaction in a bank involves a debit and a credit of equal amounts. A bank ledger records client deposits as liabilities (since the bank owes that money) and loans advanced as assets (since they generate interest income).</p>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(62, 39, 'New Public Management (NPM) Concepts', 'new-public-management-npm-concepts', '<h3>New Public Management (NPM)</h3><p>New Public Management is an approach to running public service organizations that is used in government and public sector institutions. It emphasizes market orientation, efficiency, customer focus, and decentralization of authority.</p>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(63, 40, 'Office Filing Techniques', 'office-filing-techniques', '<h3>What is Filing?</h3><p>Filing is the process of arranging and storing records in a systematic, orderly manner so they can be easily retrieved when needed. In Nepalese government offices, filing ensures transparency, audit compliance, and memory retention of administrative actions.</p>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 15:19:19', '2026-06-02 15:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `easiness_factor` double NOT NULL DEFAULT 2.5,
  `interval` int(11) NOT NULL DEFAULT 0,
  `repetitions` int(11) NOT NULL DEFAULT 0,
  `next_review_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES
(5, 2, 54, '2026-06-02 15:19:56', '2026-06-02 15:19:56', '2026-06-02 15:19:56', 2.5, 0, 0, NULL),
(6, 2, 55, '2026-06-02 15:19:59', '2026-06-02 15:19:59', '2026-06-02 15:19:59', 2.5, 0, 0, NULL),
(7, 2, 56, '2026-06-02 15:20:17', '2026-06-02 15:20:17', '2026-06-02 15:20:17', 2.5, 0, 0, NULL),
(8, 2, 57, '2026-06-02 15:20:24', '2026-06-02 15:20:24', '2026-06-02 15:20:24', 2.5, 0, 0, NULL),
(9, 2, 58, '2026-06-02 15:20:37', '2026-06-02 15:20:37', '2026-06-02 15:20:37', 2.5, 0, 0, NULL),
(10, 1, 54, '2026-07-18 01:43:07', '2026-07-18 01:43:07', '2026-07-18 01:43:07', 2.5, 0, 0, NULL),
(11, 1, 55, '2026-07-18 01:43:14', '2026-07-18 01:43:14', '2026-07-18 01:43:14', 2.5, 0, 0, NULL),
(12, 1, 56, '2026-07-18 01:43:42', '2026-07-18 01:43:42', '2026-07-18 01:43:42', 2.5, 0, 0, NULL),
(13, 1, 57, '2026-07-18 01:43:45', '2026-07-18 01:43:45', '2026-07-18 01:43:45', 2.5, 0, 0, NULL),
(14, 1, 58, '2026-07-18 01:44:14', '2026-07-18 01:44:14', '2026-07-18 01:44:14', 2.5, 0, 0, NULL),
(15, 3, 54, '2026-07-23 06:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.77, 6, 5, '2026-09-13 22:02:38'),
(16, 3, 55, '2026-07-23 14:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.99, 15, 8, '2026-07-29 22:02:38'),
(17, 3, 56, '2026-07-23 21:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.99, 30, 5, '2026-07-24 22:02:38'),
(18, 3, 57, '2026-07-23 14:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.39, 3, 1, '2026-07-27 22:02:38'),
(19, 3, 59, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.83, 15, 3, '2026-07-22 22:02:38'),
(20, 3, 61, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.53, 1, 1, '2026-07-20 22:02:38'),
(21, 3, 62, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.88, 6, 3, '2026-07-21 22:02:38'),
(22, 4, 54, '2026-07-22 07:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.88, 15, 3, '2026-07-25 22:02:38'),
(23, 4, 55, '2026-07-23 15:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.65, 15, 3, '2026-09-16 22:02:38'),
(24, 4, 56, '2026-07-23 20:34:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.66, 6, 5, '2026-07-23 22:02:38'),
(25, 4, 59, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.53, 30, 8, '2026-08-28 22:02:38'),
(26, 4, 61, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.62, 15, 3, '2026-09-08 22:02:38'),
(27, 4, 62, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.13, 3, 3, '2026-07-26 22:02:38'),
(28, 5, 54, '2026-07-20 10:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.69, 1, 1, '2026-08-04 22:02:38'),
(29, 5, 55, '2026-07-22 16:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.63, 30, 3, '2026-07-27 22:02:38'),
(30, 5, 56, '2026-07-23 20:30:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.82, 15, 5, '2026-07-25 22:02:38'),
(31, 5, 59, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.59, 2, 1, '2026-08-24 22:02:38'),
(32, 5, 61, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.63, 1, 1, '2026-07-28 22:02:38'),
(33, 6, 54, '2026-07-23 10:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 3, 15, 5, '2026-09-04 22:02:38'),
(34, 6, 55, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.87, 3, 1, '2026-07-25 22:02:38'),
(35, 6, 56, '2026-07-23 19:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.35, 2, 1, '2026-08-09 22:02:38'),
(36, 6, 59, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.24, 1, 2, '2026-09-13 22:02:38'),
(37, 6, 61, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.79, 6, 3, '2026-07-20 22:02:38'),
(38, 7, 54, '2026-07-21 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.85, 15, 5, '2026-07-29 22:02:38'),
(39, 7, 55, '2026-07-23 06:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.83, 3, 2, '2026-08-30 22:02:38'),
(40, 7, 56, '2026-07-23 21:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.64, 1, 1, '2026-07-30 22:02:38'),
(41, 7, 57, '2026-07-23 06:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.51, 30, 8, '2026-07-21 22:02:38'),
(42, 7, 59, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.52, 30, 5, '2026-09-14 22:02:38'),
(43, 7, 61, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.86, 15, 3, '2026-07-22 22:02:38'),
(44, 8, 54, '2026-07-20 10:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.27, 6, 3, '2026-08-03 22:02:38'),
(45, 8, 55, '2026-07-23 06:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.82, 30, 5, '2026-07-21 22:02:38'),
(46, 8, 56, '2026-07-23 01:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.39, 1, 1, '2026-09-01 22:02:38'),
(47, 8, 59, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.63, 1, 0, '2026-07-21 22:02:38'),
(48, 8, 62, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.6, 30, 5, '2026-09-14 22:02:38'),
(49, 8, 63, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.73, 6, 8, '2026-09-12 22:02:38'),
(50, 9, 54, '2026-07-23 06:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.82, 15, 8, '2026-07-29 22:02:38'),
(51, 9, 55, '2026-07-23 10:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.13, 3, 2, '2026-07-24 22:02:38'),
(52, 9, 56, '2026-07-23 15:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.87, 3, 2, '2026-07-24 22:02:38'),
(53, 9, 57, '2026-07-23 21:45:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.75, 6, 8, '2026-07-21 22:02:38'),
(54, 9, 59, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.99, 6, 5, '2026-07-22 22:02:38'),
(55, 9, 62, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.88, 6, 3, '2026-07-20 22:02:38'),
(56, 9, 63, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.45, 1, 0, '2026-07-29 22:02:38'),
(57, 10, 54, '2026-07-22 07:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.27, 6, 3, '2026-07-27 22:02:38'),
(58, 10, 55, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.61, 2, 0, '2026-07-21 22:02:38'),
(59, 10, 56, '2026-07-23 20:13:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.33, 6, 1, '2026-08-30 22:02:38'),
(60, 10, 62, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.45, 1, 0, '2026-08-30 22:02:38'),
(61, 10, 63, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.58, 6, 5, '2026-07-28 22:02:38'),
(62, 11, 54, '2026-07-20 10:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.78, 30, 5, '2026-08-23 22:02:38'),
(63, 11, 55, '2026-07-22 22:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.55, 30, 3, '2026-09-21 22:02:38'),
(64, 11, 56, '2026-07-23 20:58:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.65, 6, 3, '2026-07-23 22:02:38'),
(65, 11, 62, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.95, 6, 1, '2026-09-05 22:02:38'),
(66, 11, 63, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.93, 3, 1, '2026-07-21 22:02:38'),
(67, 12, 54, '2026-07-23 06:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.53, 6, 8, '2026-07-24 22:02:38'),
(68, 12, 55, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.29, 1, 2, '2026-09-15 22:02:38'),
(69, 12, 56, '2026-07-23 12:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.99, 30, 8, '2026-08-31 22:02:38'),
(70, 12, 57, '2026-07-23 21:35:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.74, 30, 5, '2026-07-22 22:02:38'),
(71, 12, 62, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.84, 15, 3, '2026-07-24 22:02:38'),
(72, 12, 63, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.67, 30, 3, '2026-07-26 22:02:38'),
(73, 13, 59, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.96, 6, 8, '2026-07-30 22:02:38'),
(74, 13, 61, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.66, 30, 5, '2026-07-21 22:02:38'),
(75, 13, 63, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.39, 6, 3, '2026-08-22 22:02:38'),
(76, 14, 59, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.62, 30, 8, '2026-07-20 22:02:38'),
(77, 14, 61, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.57, 1, 0, '2026-07-20 22:02:38'),
(78, 14, 63, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.05, 1, 3, '2026-09-10 22:02:38'),
(79, 15, 59, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.56, 1, 1, '2026-07-30 22:02:38'),
(80, 15, 61, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.82, 6, 8, '2026-07-25 22:02:38'),
(81, 15, 63, '2026-07-23 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.77, 6, 8, '2026-07-22 22:02:38'),
(82, 16, 59, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.9, 1, 3, '2026-07-28 22:02:38'),
(83, 16, 61, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.57, 6, 3, '2026-07-21 22:02:38'),
(84, 16, 63, '2026-07-23 09:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.84, 6, 5, '2026-07-20 22:02:38'),
(85, 17, 59, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 1.54, 1, 1, '2026-07-28 22:02:38'),
(86, 17, 61, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.92, 15, 8, '2026-09-03 22:02:38'),
(87, 17, 63, '2026-07-22 18:02:38', '2026-07-23 22:02:38', '2026-07-23 22:02:38', 2.72, 15, 8, '2026-09-20 22:02:38');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '0001_01_01_000000_create_users_table', 1),
(22, '0001_01_01_000001_create_cache_table', 1),
(23, '0001_01_01_000002_create_jobs_table', 1),
(24, '2026_05_03_082923_create_courses_table', 1),
(25, '2026_05_03_082924_create_modules_table', 1),
(26, '2026_05_03_082925_create_chapters_table', 1),
(27, '2026_05_03_082925_create_lessons_table', 1),
(28, '2026_05_03_082926_create_course_prerequisites_table', 1),
(29, '2026_05_03_084546_create_permission_tables', 1),
(30, '2026_05_03_153318_create_enrollments_and_progress_tables', 1),
(31, '2026_07_18_100000_add_algorithm_fields_to_tables', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `course_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES
(35, 1, 'First Paper: General Knowledge (GK)', 'first-paper-general-knowledge-gk', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(36, 1, 'First Paper: Intelligence Quotient (IQ)', 'first-paper-intelligence-quotient-iq', NULL, 2, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(37, 2, 'Banking Laws & Economics', 'banking-laws-economics', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(38, 3, 'Financial Accounting & Banking', 'financial-accounting-banking', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(39, 4, 'Second Paper: Governance System', 'second-paper-governance-system', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19'),
(40, 5, 'Office Management and Work Procedures', 'office-management-and-work-procedures', NULL, 1, 0, '2026-06-02 15:19:19', '2026-06-02 15:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-05-03 10:00:36', '2026-05-03 10:00:36'),
(2, 'user', 'web', '2026-05-03 10:00:36', '2026-05-03 10:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1kK2uC7l3WQMHku8Ao7KW90t8eZpNCT6hM6qpcGN', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWVlTTE5OW82UEZhUjlZeTRka0VneFZQdU02NnY3aWZsWW1DVkRQbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9sb2tzZXdhX2NvdXJzZS50ZXN0L2NvdXJzZXMvbmF5YWJfc3ViYmEiO3M6NToicm91dGUiO3M6MTU6ImNvdXJzZXMuZGV0YWlscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1784866928),
('bguZqusTcZgYwF14vjcL3HuO9CJKpbQWXs6rw84Q', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNXM0SXpCT0drVWdQNjFueTBCOGp4NnM2bFBuYkN4eTU0ZnZkWDUzVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9sb2tzZXdhX2NvdXJzZS50ZXN0L2NvdXJzZXMvbmF5YWJfc3ViYmEiO3M6NToicm91dGUiO3M6MTU6ImNvdXJzZXMuZGV0YWlscyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1784775331),
('eiH7MJRD5BdycQEgLs9srLfrlrc48G2M9LmglUvd', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiT3ZHTFFVQWg3dngxOXppUjlUUVFpcHhrWlNveWNFNGcwdWFOT0dmZiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ5OiJodHRwOi8vbG9rc2V3YV9jb3Vyc2UudGVzdC9hZG1pbi9hbGdvcml0aG0tcmVwb3J0IjtzOjU6InJvdXRlIjtzOjM3OiJmaWxhbWVudC5hZG1pbi5wYWdlcy5hbGdvcml0aG0tcmVwb3J0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiMjczNjg2ZTBlMmJlMGM3YTQyMWM3ZjIzZjdmNDQ0ZWIwNTk3ZjQ1MmM5OGE5ZWJkMjAyOTM2Yjg4MTRjMWM3YSI7czo2OiJ0YWJsZXMiO2E6NDp7czo0MDoiYjczYmY4ODc4ZmRjMWQ5ZjA1NzAyNTIzMGRmNmMxZGFfY29sdW1ucyI7YTo3OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToibW9kdWxlX2lkIjtzOjU6ImxhYmVsIjtzOjk6Ik1vZHVsZSBpZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToidGl0bGUiO3M6NToibGFiZWwiO3M6NToiVGl0bGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6InNsdWciO3M6NToibGFiZWwiO3M6NDoiU2x1ZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToib3JkZXIiO3M6NToibGFiZWwiO3M6NToiT3JkZXIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEyOiJpc19wdWJsaXNoZWQiO3M6NToibGFiZWwiO3M6MTI6IklzIHB1Ymxpc2hlZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiNDZjYzA5NGRhMDVmYzFlMGI3YzRkOGQwNmZlNWIxZDFfY29sdW1ucyI7YTo3OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToidGl0bGUiO3M6NToibGFiZWwiO3M6NToiVGl0bGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6InNsdWciO3M6NToibGFiZWwiO3M6NDoiU2x1ZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToidGh1bWJuYWlsIjtzOjU6ImxhYmVsIjtzOjk6IlRodW1ibmFpbCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTI6ImlzX3B1Ymxpc2hlZCI7czo1OiJsYWJlbCI7czoxMjoiSXMgcHVibGlzaGVkIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNDoidHJlbmRpbmdfc2NvcmUiO3M6NToibGFiZWwiO3M6MTQ6IlRyZW5kaW5nIFNjb3JlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiIxYTAwYWRhYmNhN2VlMjZkMTU0NmViMDE3NjM5ZGY0NF9jb2x1bW5zIjthOjExOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNoYXB0ZXJfaWQiO3M6NToibGFiZWwiO3M6MTA6IkNoYXB0ZXIgaWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InRpdGxlIjtzOjU6ImxhYmVsIjtzOjU6IlRpdGxlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJzbHVnIjtzOjU6ImxhYmVsIjtzOjQ6IlNsdWciO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6InZpZGVvX3VybCI7czo1OiJsYWJlbCI7czo5OiJWaWRlbyB1cmwiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE1OiJhdHRhY2htZW50X3BhdGgiO3M6NToibGFiZWwiO3M6MTU6IkF0dGFjaG1lbnQgcGF0aCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoidHlwZSI7czo1OiJsYWJlbCI7czo0OiJUeXBlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJvcmRlciI7czo1OiJsYWJlbCI7czo1OiJPcmRlciI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTY6ImR1cmF0aW9uX21pbnV0ZXMiO3M6NToibGFiZWwiO3M6MTY6IkR1cmF0aW9uIG1pbnV0ZXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEyOiJpc19wdWJsaXNoZWQiO3M6NToibGFiZWwiO3M6MTI6IklzIHB1Ymxpc2hlZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjk7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjEwO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6ImNkZmE3M2ExZDA2MmVjZjI2M2VhNzEwNGJlNTMwYTkxX2NvbHVtbnMiO2E6Nzp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6ImNvdXJzZV9pZCI7czo1OiJsYWJlbCI7czo5OiJDb3Vyc2UgaWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InRpdGxlIjtzOjU6ImxhYmVsIjtzOjU6IlRpdGxlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJzbHVnIjtzOjU6ImxhYmVsIjtzOjQ6IlNsdWciO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6Im9yZGVyIjtzOjU6ImxhYmVsIjtzOjU6Ik9yZGVyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMjoiaXNfcHVibGlzaGVkIjtzOjU6ImxhYmVsIjtzOjEyOiJJcyBwdWJsaXNoZWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJDcmVhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fX19', 1784790281),
('FqY4zvxm0xET3PDF9MvF88QndmUxESUoefVgkYDo', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNVVIbldZZTBucEtheUtrbHRQTWhNOGVQcnJ0ZEJFSkE3YzdwM2RVQiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ5OiJodHRwOi8vbG9rc2V3YV9jb3Vyc2UudGVzdC9hZG1pbi9hbGdvcml0aG0tcmVwb3J0IjtzOjU6InJvdXRlIjtzOjM3OiJmaWxhbWVudC5hZG1pbi5wYWdlcy5hbGdvcml0aG0tcmVwb3J0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiMjczNjg2ZTBlMmJlMGM3YTQyMWM3ZjIzZjdmNDQ0ZWIwNTk3ZjQ1MmM5OGE5ZWJkMjAyOTM2Yjg4MTRjMWM3YSI7fQ==', 1784774650),
('HOOMisHJKWxEOIz4zFU2fTIuWKfCwE9q9TjHlFIV', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiMnI1YVg4TWpJR2huaGZmMHkwVFQ5SVlVaGtMeU9GV1VZME9lSGtkTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9sb2tzZXdhX2NvdXJzZS50ZXN0L2FkbWluL3VzZXJzLzcvZWRpdCI7czo1OiJyb3V0ZSI7czozNToiZmlsYW1lbnQuYWRtaW4ucmVzb3VyY2VzLnVzZXJzLmVkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiIyNzM2ODZlMGUyYmUwYzdhNDIxYzdmMjNmN2Y0NDRlYjA1OTdmNDUyYzk4YTllYmQyMDI5MzZiODgxNGMxYzdhIjtzOjY6InRhYmxlcyI7YTozOntzOjQwOiJiNzNiZjg4NzhmZGMxZDlmMDU3MDI1MjMwZGY2YzFkYV9jb2x1bW5zIjthOjc6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJtb2R1bGVfaWQiO3M6NToibGFiZWwiO3M6OToiTW9kdWxlIGlkIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJ0aXRsZSI7czo1OiJsYWJlbCI7czo1OiJUaXRsZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoic2x1ZyI7czo1OiJsYWJlbCI7czo0OiJTbHVnIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJvcmRlciI7czo1OiJsYWJlbCI7czo1OiJPcmRlciI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTI6ImlzX3B1Ymxpc2hlZCI7czo1OiJsYWJlbCI7czoxMjoiSXMgcHVibGlzaGVkIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiIyNmMxYjBjNGIyOGYzYjhiZTg4YjM5N2FjNTM4ZGQ4Yl9jb2x1bW5zIjthOjU6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJ1c2VyLm5hbWUiO3M6NToibGFiZWwiO3M6NzoiU3R1ZGVudCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTI6ImNvdXJzZS50aXRsZSI7czo1OiJsYWJlbCI7czo2OiJDb3Vyc2UiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6InN0YXR1cyI7czo1OiJsYWJlbCI7czo2OiJTdGF0dXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE5OiJwcm9ncmVzc19wZXJjZW50YWdlIjtzOjU6ImxhYmVsIjtzOjg6IlByb2dyZXNzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czo4OiJFbnJvbGxlZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiZTY0NDgzM2Y0ZTRlMDg3MTIzMTVkYTcxYjMzZmFjZDJfY29sdW1ucyI7YTo2OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtZSI7czo1OiJsYWJlbCI7czo0OiJOYW1lIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJlbWFpbCI7czo1OiJsYWJlbCI7czoxMzoiRW1haWwgYWRkcmVzcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MjQ6ImxlYXJuaW5nX3BhY2VfbXVsdGlwbGllciI7czo1OiJsYWJlbCI7czoxMzoiTGVhcm5pbmcgUGFjZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTc6ImVtYWlsX3ZlcmlmaWVkX2F0IjtzOjU6ImxhYmVsIjtzOjE3OiJFbWFpbCB2ZXJpZmllZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319fX0=', 1784866581),
('N2G42tQHOKDyWiVEAj9jmy5aTScwkYyc5XpXRpLS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV1pWS1FZekVjQ2dEQXpDeGF1MWNmTE4xQTZXYTk0eVRSdjVmRXB1QiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMjoiaHR0cDovL2xva3Nld2FfY291cnNlLnRlc3QvYWRtaW4iO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozODoiaHR0cDovL2xva3Nld2FfY291cnNlLnRlc3QvYWRtaW4vbG9naW4iO3M6NToicm91dGUiO3M6MjU6ImZpbGFtZW50LmFkbWluLmF1dGgubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1784773428),
('p8vtYc2fWofGFWUQCos5OrWTl5awIZCAGBMxI4Xh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVVVPamdNaTlrSmdyNm16MUJBT1JFdElkckZaU2N4a0R0Ym1oNE5wOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2tzZXdhX2NvdXJzZS50ZXN0L2FkbWluL2xvZ2luIjtzOjU6InJvdXRlIjtzOjI1OiJmaWxhbWVudC5hZG1pbi5hdXRoLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMjoiaHR0cDovL2xva3Nld2FfY291cnNlLnRlc3QvYWRtaW4iO319', 1784773420),
('PtXfvj8nCzakKEi4njm3uSIvfwPDtJXpvIDRdpEs', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ052c0RvWlJ3M3B4eXZSYzhxMUdGZVZNYW9PUzBwTjNFYjBCNEtEWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2tzZXdhX2NvdXJzZS50ZXN0IjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1784790265);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `learning_pace_multiplier` double NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES
(1, 'System Admin', 'admin@loksewa.com', NULL, '$2y$12$x4M732BmtEDdOaF3jHowAOYx2945y4mSFNF.rO3qgFBjLAGbMpzYG', NULL, '2026-05-03 10:00:37', '2026-07-23 22:33:16', 0.00019386574074074),
(2, 'Regular User', 'user@loksewa.com', NULL, '$2y$12$HqM/IbG2Q4sS/zkp8NU30.VCf9of0Si6aisETKUi48S2aTQrs6AaK', NULL, '2026-05-03 10:00:37', '2026-07-23 22:33:16', 0.00011863425925926),
(3, 'Aarav Sharma', 'aarav.sharma@demo.test', NULL, '$2y$12$ect0m61lJLYjUl40Rgw8UeTlrpQ7jFaWaetKikN6VcxG.IkBDBru.', NULL, '2026-07-23 22:02:33', '2026-07-23 22:33:16', 0.083333333333333),
(4, 'Bikash Thapa', 'bikash.thapa@demo.test', NULL, '$2y$12$.6Sj5SOwpiLZGSbrRo/zHeNO1Dhjx482Q4eV8.GkJj6IsZ/wzQWXy', NULL, '2026-07-23 22:02:34', '2026-07-23 22:33:17', 0.21666666666667),
(5, 'Chandani Gurung', 'chandani.gurung@demo.test', NULL, '$2y$12$bYJMYKRyS0C5Dfj6A/tsTOMm/mxETTm4B73hmrx6GviO6bNT1QMQ6', NULL, '2026-07-23 22:02:34', '2026-07-23 22:33:17', 0.027777777777778),
(6, 'Deepak Adhikari', 'deepak.adhikari@demo.test', NULL, '$2y$12$K9gj8A//Gj4WwfqN./flCeru71/DRTcLvf3AQrzsEzTjkZFPVa8Jy', NULL, '2026-07-23 22:02:34', '2026-07-23 22:33:17', 0.75),
(7, 'Elina Maharjan', 'elina.maharjan@demo.test', NULL, '$2y$12$DKtOM7oxLSCKPLs1ydYliuO1EbaUzWyfYU.LXDH9hczw.UjPKkUb2', NULL, '2026-07-23 22:02:35', '2026-07-23 22:33:18', 0.8),
(8, 'Firoz Magar', 'firoz.magar@demo.test', NULL, '$2y$12$W/TNF5txC/MWKhSV9AcPXeAnaFtE0Qt5VW31s2vNYBiS2XuYwkoH2', NULL, '2026-07-23 22:02:35', '2026-07-23 22:33:18', 1),
(9, 'Gita Basnet', 'gita.basnet@demo.test', NULL, '$2y$12$4uTDrW1jLYGsQVQOIbFv6uz2tJqPiavRrWdA.jQUZbJMTGExd0zYy', NULL, '2026-07-23 22:02:35', '2026-07-23 22:33:18', 1),
(10, 'Hari Koirala', 'hari.koirala@demo.test', NULL, '$2y$12$ACamIQku15ro/XJuc/fcW./zupDYW5WkiuZT8bunHF1IW5tNJ2u2u', NULL, '2026-07-23 22:02:35', '2026-07-23 22:33:19', 1.1),
(11, 'Isha Pandey', 'isha.pandey@demo.test', NULL, '$2y$12$Y043zlzX56QzoRIO3YX8XuYdDvUk3iWbJYXro6yn9Sayw6MX8kCk.', NULL, '2026-07-23 22:02:36', '2026-07-23 22:33:19', 1.3),
(12, 'Jeevan Rai', 'jeevan.rai@demo.test', NULL, '$2y$12$qTRChKSUBCiU/EZXAkAbZuPt/N0cuTSmlFGL2d1FQ/TrgrZt3PSdC', NULL, '2026-07-23 22:02:36', '2026-07-23 22:33:19', 1.5),
(13, 'Kabita Shrestha', 'kabita.shrestha@demo.test', NULL, '$2y$12$sSIk02U4/c3H1pAg3wKMR.IjJnx.vhZWsG2rj33OEZLHSYmru/xpm', NULL, '2026-07-23 22:02:36', '2026-07-23 22:33:19', 1.8),
(14, 'Laxmi Bhatt', 'laxmi.bhatt@demo.test', NULL, '$2y$12$lWM8yj7hEpvLm4fVjlivr.61H3urfDkup1qMAWgQCq1GnrRhXKHvC', NULL, '2026-07-23 22:02:37', '2026-07-23 22:33:20', 2),
(15, 'Manish Tamang', 'manish.tamang@demo.test', NULL, '$2y$12$XJ4YzKKv40hguqey5oLjjePex1BoAbfy9DhEy5ZhD9Dyh1sGNErbS', NULL, '2026-07-23 22:02:37', '2026-07-23 22:33:20', 0.4),
(16, 'Nisha Dhakal', 'nisha.dhakal@demo.test', NULL, '$2y$12$K/ZqCONOtMDwP/mMyKGx7.WxtohORbSQvP7ZDPBqIRKYj14Ti.Sfu', NULL, '2026-07-23 22:02:37', '2026-07-23 22:33:20', 0.9),
(17, 'Om Prasad Poudel', 'om.poudel@demo.test', NULL, '$2y$12$vKbg25OnDk0UmOR7A7WyZel9cE7Cj1s.189gM9o63HOdRSCR9lyYq', NULL, '2026-07-23 22:02:37', '2026-07-23 22:33:21', 1.2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chapters_slug_unique` (`slug`),
  ADD KEY `chapters_module_id_foreign` (`module_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`);

--
-- Indexes for table `course_prerequisites`
--
ALTER TABLE `course_prerequisites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_prerequisite_unique` (`course_id`,`prerequisite_course_id`),
  ADD KEY `course_prerequisites_prerequisite_course_id_foreign` (`prerequisite_course_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollments_user_id_course_id_unique` (`user_id`,`course_id`),
  ADD KEY `enrollments_course_id_foreign` (`course_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lessons_slug_unique` (`slug`),
  ADD KEY `lessons_chapter_id_foreign` (`chapter_id`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lesson_progress_user_id_lesson_id_unique` (`user_id`,`lesson_id`),
  ADD KEY `lesson_progress_lesson_id_foreign` (`lesson_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modules_slug_unique` (`slug`),
  ADD KEY `modules_course_id_foreign` (`course_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_prerequisites`
--
ALTER TABLE `course_prerequisites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_prerequisites`
--
ALTER TABLE `course_prerequisites`
  ADD CONSTRAINT `course_prerequisites_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_prerequisites_prerequisite_course_id_foreign` FOREIGN KEY (`prerequisite_course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `lesson_progress_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
