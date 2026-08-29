/*
 Navicat Premium Dump SQL

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 90701 (9.7.1-1)
 Source Host           : localhost:3306
 Source Schema         : loksewa

 Target Server Type    : MySQL
 Target Server Version : 90701 (9.7.1-1)
 File Encoding         : 65001

 Date: 26/08/2026 08:21:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------
BEGIN;
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1777835169);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1777835169;', 1777835169);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:2;', 1784863190);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1784863190;', 1784863190);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}', 1784949558);
COMMIT;

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for chapters
-- ----------------------------
DROP TABLE IF EXISTS `chapters`;
CREATE TABLE `chapters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chapters_slug_unique` (`slug`),
  KEY `chapters_module_id_foreign` (`module_id`),
  CONSTRAINT `chapters_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of chapters
-- ----------------------------
BEGIN;
INSERT INTO `chapters` (`id`, `module_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (35, 35, 'Geography and History of Nepal', 'geography-and-history-of-nepal', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `chapters` (`id`, `module_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (36, 36, 'Numerical and Verbal Reasoning', 'numerical-and-verbal-reasoning', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `chapters` (`id`, `module_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (37, 37, 'Nepal Rastra Bank Act, 2058', 'nepal-rastra-bank-act-2058', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `chapters` (`id`, `module_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (38, 38, 'Banking Accounting Principles', 'banking-accounting-principles', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `chapters` (`id`, `module_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (39, 39, 'Concepts of Governance and Administration', 'concepts-of-governance-and-administration', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `chapters` (`id`, `module_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (40, 40, 'Filing Systems and Record Management', 'filing-systems-and-record-management', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
COMMIT;

-- ----------------------------
-- Table structure for course_prerequisites
-- ----------------------------
DROP TABLE IF EXISTS `course_prerequisites`;
CREATE TABLE `course_prerequisites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `prerequisite_course_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_prerequisite_unique` (`course_id`,`prerequisite_course_id`),
  KEY `course_prerequisites_prerequisite_course_id_foreign` (`prerequisite_course_id`),
  CONSTRAINT `course_prerequisites_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_prerequisites_prerequisite_course_id_foreign` FOREIGN KEY (`prerequisite_course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of course_prerequisites
-- ----------------------------
BEGIN;
INSERT INTO `course_prerequisites` (`id`, `course_id`, `prerequisite_course_id`, `created_at`, `updated_at`) VALUES (1, 1, 5, NULL, NULL);
INSERT INTO `course_prerequisites` (`id`, `course_id`, `prerequisite_course_id`, `created_at`, `updated_at`) VALUES (2, 4, 1, NULL, NULL);
INSERT INTO `course_prerequisites` (`id`, `course_id`, `prerequisite_course_id`, `created_at`, `updated_at`) VALUES (3, 3, 5, NULL, NULL);
INSERT INTO `course_prerequisites` (`id`, `course_id`, `prerequisite_course_id`, `created_at`, `updated_at`) VALUES (4, 2, 4, NULL, NULL);
INSERT INTO `course_prerequisites` (`id`, `course_id`, `prerequisite_course_id`, `created_at`, `updated_at`) VALUES (5, 2, 3, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for courses
-- ----------------------------
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'beginner',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `trending_score` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of courses
-- ----------------------------
BEGIN;
INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `level`, `is_published`, `created_at`, `updated_at`, `trending_score`) VALUES (1, 'Nayab Subba Tayari', 'nayab_subba', 'Complete preparation course for Nayab Subba covering General Knowledge (GK), IQ, and General Administration.', 'course-thumbnails/01KQQJT72T7721JDYJFWCTSTSK.jpg', 'intermediate', 1, '2026-05-03 15:45:38', '2026-07-24 03:47:38', 0.13065211894732);
INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `level`, `is_published`, `created_at`, `updated_at`, `trending_score`) VALUES (2, 'Nepal Rastra Bank Tayari(Assistant Director)', 'rastra_bank_ad', 'Premium syllabus covering Macroeconomics, Nepalese Financial System, Banking Laws, and Corporate Governance.', 'course-thumbnails/01KQQK60JBD3MHXRT7FQQTY9EX.jpg', 'advanced', 1, '2026-05-03 15:45:38', '2026-07-24 03:47:38', 0.14252958430617);
INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `level`, `is_published`, `created_at`, `updated_at`, `trending_score`) VALUES (3, 'Nepal Rastra Bank Tayari(Officer)', 'rastra_bank_o', 'Comprehensive course for Officer level preparation, highlighting Accounting, Management, IT, and Commercial Banking.', 'course-thumbnails/01KQQKC383PKTG3YA1427VGNYW.jpg', 'advanced', 1, '2026-05-03 15:45:38', '2026-07-24 03:47:38', 0.11877465358848);
INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `level`, `is_published`, `created_at`, `updated_at`, `trending_score`) VALUES (4, 'Section Officer', 'sec_off', 'Ultimate syllabus preparation guide for Gazetted Third Class Section Officer position in administrative service.', 'course-thumbnails/01KQQKGSBBVTHZ9QRPJQMFZX2P.jpg', 'advanced', 1, '2026-05-03 15:45:38', '2026-07-24 03:47:38', 0.083142257511934);
INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `thumbnail`, `level`, `is_published`, `created_at`, `updated_at`, `trending_score`) VALUES (5, 'Kharidar', 'kharidar', 'Complete preparation course for Kharidar level focusing on general knowledge, office procedures, and job knowledge.', 'course-thumbnails/01KQQKNXE8YCS4TZ1ECX62BSZR.jpg', 'beginner', 1, '2026-05-03 18:34:00', '2026-07-24 03:47:38', 0.11908166398448);
COMMIT;

-- ----------------------------
-- Table structure for enrollments
-- ----------------------------
DROP TABLE IF EXISTS `enrollments`;
CREATE TABLE `enrollments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `progress_percentage` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `enrollments_user_id_course_id_unique` (`user_id`,`course_id`),
  KEY `enrollments_course_id_foreign` (`course_id`),
  CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of enrollments
-- ----------------------------
BEGIN;
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (1, 1, 2, 'active', 0, '2026-05-03 16:12:08', '2026-06-02 21:04:19');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (6, 2, 1, 'completed', 100, '2026-06-03 03:28:23', '2026-06-03 03:28:39');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (7, 1, 1, 'completed', 100, '2026-07-18 07:27:42', '2026-07-18 07:29:14');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (8, 3, 1, 'active', 60, '2026-07-22 19:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (9, 3, 2, 'active', 72, '2026-07-21 06:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (10, 3, 3, 'active', 67, '2026-07-10 14:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (11, 4, 1, 'active', 87, '2026-07-20 21:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (12, 4, 2, 'active', 81, '2026-07-18 04:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (13, 4, 3, 'active', 76, '2026-07-13 03:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (14, 5, 1, 'active', 67, '2026-07-20 16:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (15, 5, 2, 'active', 18, '2026-07-20 18:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (16, 5, 3, 'active', 77, '2026-07-11 04:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (17, 6, 1, 'completed', 92, '2026-07-22 07:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (18, 6, 2, 'completed', 93, '2026-07-18 08:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (19, 6, 3, 'active', 63, '2026-07-08 06:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (21, 7, 2, 'completed', 95, '2026-07-20 15:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (22, 7, 3, 'active', 46, '2026-07-12 22:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (23, 8, 1, 'active', 39, '2026-07-18 04:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (24, 8, 4, 'active', 13, '2026-07-11 06:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (25, 8, 5, 'active', 79, '2026-06-25 17:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (26, 9, 1, 'active', 51, '2026-07-19 12:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (27, 9, 4, 'active', 68, '2026-07-05 16:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (28, 9, 5, 'active', 19, '2026-06-27 15:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (29, 10, 1, 'active', 86, '2026-07-16 08:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (30, 10, 4, 'active', 42, '2026-07-07 11:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (31, 10, 5, 'active', 64, '2026-06-28 08:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (32, 11, 1, 'active', 76, '2026-07-19 11:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (33, 11, 4, 'active', 46, '2026-07-04 07:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (34, 11, 5, 'active', 72, '2026-06-26 03:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (35, 12, 1, 'active', 46, '2026-07-19 22:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (36, 12, 4, 'active', 38, '2026-07-06 02:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (37, 12, 5, 'active', 38, '2026-06-24 13:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (38, 13, 2, 'active', 27, '2026-07-19 09:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (39, 13, 3, 'active', 19, '2026-07-09 15:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (40, 13, 5, 'active', 56, '2026-06-30 19:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (41, 14, 2, 'active', 22, '2026-07-22 03:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (42, 14, 3, 'active', 29, '2026-07-12 07:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (43, 14, 5, 'active', 71, '2026-06-26 05:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (44, 15, 2, 'active', 56, '2026-07-20 20:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (45, 15, 3, 'active', 70, '2026-07-15 10:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (46, 15, 5, 'active', 57, '2026-07-01 05:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (47, 16, 2, 'completed', 92, '2026-07-20 08:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (48, 16, 3, 'active', 17, '2026-07-12 12:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (49, 16, 5, 'active', 17, '2026-07-02 03:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (50, 17, 2, 'active', 13, '2026-07-19 13:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (51, 17, 3, 'active', 72, '2026-07-11 01:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (52, 17, 5, 'completed', 94, '2026-06-30 17:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (53, 3, 4, 'active', 36, '2026-07-14 04:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (54, 4, 4, 'active', 75, '2026-07-13 14:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (55, 8, 2, 'active', 39, '2026-07-18 20:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (56, 9, 2, 'active', 52, '2026-07-17 14:47:38', '2026-07-24 03:47:38');
INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `progress_percentage`, `created_at`, `updated_at`) VALUES (57, 7, 1, 'active', 0, '2026-07-24 04:22:08', '2026-07-24 04:22:08');
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of job_batches
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for lesson_progress
-- ----------------------------
DROP TABLE IF EXISTS `lesson_progress`;
CREATE TABLE `lesson_progress` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `lesson_id` bigint unsigned NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `easiness_factor` double NOT NULL DEFAULT '2.5',
  `interval` int NOT NULL DEFAULT '0',
  `repetitions` int NOT NULL DEFAULT '0',
  `next_review_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lesson_progress_user_id_lesson_id_unique` (`user_id`,`lesson_id`),
  KEY `lesson_progress_lesson_id_foreign` (`lesson_id`),
  CONSTRAINT `lesson_progress_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lesson_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lesson_progress
-- ----------------------------
BEGIN;
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (5, 2, 54, '2026-06-02 21:04:56', '2026-06-02 21:04:56', '2026-06-02 21:04:56', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (6, 2, 55, '2026-06-02 21:04:59', '2026-06-02 21:04:59', '2026-06-02 21:04:59', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (7, 2, 56, '2026-06-02 21:05:17', '2026-06-02 21:05:17', '2026-06-02 21:05:17', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (8, 2, 57, '2026-06-02 21:05:24', '2026-06-02 21:05:24', '2026-06-02 21:05:24', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (9, 2, 58, '2026-06-02 21:05:37', '2026-06-02 21:05:37', '2026-06-02 21:05:37', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (10, 1, 54, '2026-07-18 07:28:07', '2026-07-18 07:28:07', '2026-07-18 07:28:07', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (11, 1, 55, '2026-07-18 07:28:14', '2026-07-18 07:28:14', '2026-07-18 07:28:14', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (12, 1, 56, '2026-07-18 07:28:42', '2026-07-18 07:28:42', '2026-07-18 07:28:42', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (13, 1, 57, '2026-07-18 07:28:45', '2026-07-18 07:28:45', '2026-07-18 07:28:45', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (14, 1, 58, '2026-07-18 07:29:14', '2026-07-18 07:29:14', '2026-07-18 07:29:14', 2.5, 0, 0, NULL);
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (15, 3, 54, '2026-07-23 11:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.77, 6, 5, '2026-09-14 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (16, 3, 55, '2026-07-23 19:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.99, 15, 8, '2026-07-30 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (17, 3, 56, '2026-07-24 02:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.99, 30, 5, '2026-07-25 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (18, 3, 57, '2026-07-23 19:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.39, 3, 1, '2026-07-28 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (19, 3, 59, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.83, 15, 3, '2026-07-23 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (20, 3, 61, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.53, 1, 1, '2026-07-21 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (21, 3, 62, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.88, 6, 3, '2026-07-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (22, 4, 54, '2026-07-22 12:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.88, 15, 3, '2026-07-26 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (23, 4, 55, '2026-07-23 20:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.65, 15, 3, '2026-09-17 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (24, 4, 56, '2026-07-24 02:19:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.66, 6, 5, '2026-07-24 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (25, 4, 59, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.53, 30, 8, '2026-08-29 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (26, 4, 61, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.62, 15, 3, '2026-09-09 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (27, 4, 62, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.13, 3, 3, '2026-07-27 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (28, 5, 54, '2026-07-20 15:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.69, 1, 1, '2026-08-05 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (29, 5, 55, '2026-07-22 21:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.63, 30, 3, '2026-07-28 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (30, 5, 56, '2026-07-24 02:15:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.82, 15, 5, '2026-07-26 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (31, 5, 59, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.59, 2, 1, '2026-08-25 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (32, 5, 61, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.63, 1, 1, '2026-07-29 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (33, 6, 54, '2026-07-23 15:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 3, 15, 5, '2026-09-05 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (34, 6, 55, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.87, 3, 1, '2026-07-26 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (35, 6, 56, '2026-07-24 00:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.35, 2, 1, '2026-08-10 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (36, 6, 59, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.24, 1, 2, '2026-09-14 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (37, 6, 61, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.79, 6, 3, '2026-07-21 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (38, 7, 54, '2026-07-21 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.85, 15, 5, '2026-07-30 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (39, 7, 55, '2026-07-23 11:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.83, 3, 2, '2026-08-31 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (40, 7, 56, '2026-07-24 02:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.64, 1, 1, '2026-07-31 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (41, 7, 57, '2026-07-23 11:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.51, 30, 8, '2026-07-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (42, 7, 59, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.52, 30, 5, '2026-09-15 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (43, 7, 61, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.86, 15, 3, '2026-07-23 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (44, 8, 54, '2026-07-20 15:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.27, 6, 3, '2026-08-04 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (45, 8, 55, '2026-07-23 11:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.82, 30, 5, '2026-07-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (46, 8, 56, '2026-07-23 06:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.39, 1, 1, '2026-09-02 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (47, 8, 59, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.63, 1, 0, '2026-07-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (48, 8, 62, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.6, 30, 5, '2026-09-15 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (49, 8, 63, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.73, 6, 8, '2026-09-13 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (50, 9, 54, '2026-07-23 11:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.82, 15, 8, '2026-07-30 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (51, 9, 55, '2026-07-23 15:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.13, 3, 2, '2026-07-25 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (52, 9, 56, '2026-07-23 20:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.87, 3, 2, '2026-07-25 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (53, 9, 57, '2026-07-24 03:30:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.75, 6, 8, '2026-07-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (54, 9, 59, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.99, 6, 5, '2026-07-23 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (55, 9, 62, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.88, 6, 3, '2026-07-21 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (56, 9, 63, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.45, 1, 0, '2026-07-30 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (57, 10, 54, '2026-07-22 12:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.27, 6, 3, '2026-07-28 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (58, 10, 55, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.61, 2, 0, '2026-07-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (59, 10, 56, '2026-07-24 01:58:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.33, 6, 1, '2026-08-31 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (60, 10, 62, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.45, 1, 0, '2026-08-31 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (61, 10, 63, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.58, 6, 5, '2026-07-29 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (62, 11, 54, '2026-07-20 15:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.78, 30, 5, '2026-08-24 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (63, 11, 55, '2026-07-23 03:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.55, 30, 3, '2026-09-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (64, 11, 56, '2026-07-24 02:43:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.65, 6, 3, '2026-07-24 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (65, 11, 62, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.95, 6, 1, '2026-09-06 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (66, 11, 63, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.93, 3, 1, '2026-07-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (67, 12, 54, '2026-07-23 11:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.53, 6, 8, '2026-07-25 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (68, 12, 55, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.29, 1, 2, '2026-09-16 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (69, 12, 56, '2026-07-23 17:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.99, 30, 8, '2026-09-01 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (70, 12, 57, '2026-07-24 03:20:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.74, 30, 5, '2026-07-23 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (71, 12, 62, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.84, 15, 3, '2026-07-25 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (72, 12, 63, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.67, 30, 3, '2026-07-27 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (73, 13, 59, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.96, 6, 8, '2026-07-31 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (74, 13, 61, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.66, 30, 5, '2026-07-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (75, 13, 63, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.39, 6, 3, '2026-08-23 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (76, 14, 59, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.62, 30, 8, '2026-07-21 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (77, 14, 61, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.57, 1, 0, '2026-07-21 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (78, 14, 63, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.05, 1, 3, '2026-09-11 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (79, 15, 59, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.56, 1, 1, '2026-07-31 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (80, 15, 61, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.82, 6, 8, '2026-07-26 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (81, 15, 63, '2026-07-23 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.77, 6, 8, '2026-07-23 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (82, 16, 59, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.9, 1, 3, '2026-07-29 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (83, 16, 61, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.57, 6, 3, '2026-07-22 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (84, 16, 63, '2026-07-23 14:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.84, 6, 5, '2026-07-21 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (85, 17, 59, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 1.54, 1, 1, '2026-07-29 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (86, 17, 61, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.92, 15, 8, '2026-09-04 03:47:38');
INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed_at`, `created_at`, `updated_at`, `easiness_factor`, `interval`, `repetitions`, `next_review_date`) VALUES (87, 17, 63, '2026-07-22 23:47:38', '2026-07-24 03:47:38', '2026-07-24 03:47:38', 2.72, 15, 8, '2026-09-21 03:47:38');
COMMIT;

-- ----------------------------
-- Table structure for lessons
-- ----------------------------
DROP TABLE IF EXISTS `lessons`;
CREATE TABLE `lessons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `chapter_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('text','video','pdf','quiz') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `order` int NOT NULL DEFAULT '0',
  `duration_minutes` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lessons_slug_unique` (`slug`),
  KEY `lessons_chapter_id_foreign` (`chapter_id`),
  CONSTRAINT `lessons_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lessons
-- ----------------------------
BEGIN;
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (54, 35, 'Physical Geography of Nepal', 'physical-geography-of-nepal', '<h3>Physical Divisions of Nepal</h3><p>Nepal is divided into three main ecological regions:</p><ul><li><strong>Himalayan Region:</strong> Covers 15% of the total land area. It lies in the north and ranges from 3,000m to 8,848.86m altitude.</li><li><strong>Hilly Region:</strong> Covers 68% of the total land area. It lies in the middle and contains valleys like Kathmandu and Pokhara.</li><li><strong>Terai Region:</strong> Covers 17% of the total land area. It lies in the south and is the agricultural breadbasket of Nepal.</li></ul><h3>Major Rivers and Water Resources</h3><p>Nepal is highly rich in water resources, divided into three major river systems:</p><ol><li><strong>Koshi River System:</strong> The largest river system in Nepal (eastern part).</li><li><strong>Gandaki River System:</strong> The deepest river system (central part).</li><li><strong>Karnali River System:</strong> The longest river system (western part).</li></ol>', NULL, 'storage/notes/Sample questions.pdf', 'text', 1, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (55, 35, 'Official Nayab Subba Syllabus PDF', 'official-nayab-subba-syllabus-pdf', 'Download and print the official Loksewa syllabus for Nayab Subba to plan your learning journey.', NULL, 'storage/notes/Sample questions.pdf', 'pdf', 2, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (56, 35, 'Geography GK Assessment', 'geography-gk-assessment', '[{\"question\":\"What percentage of Nepal\'s total land area is covered by the Hilly Region?\",\"options\":[\"15%\",\"68%\",\"17%\",\"50%\"],\"answer\":1,\"explanation\":\"The Hilly Region covers approximately 68% of Nepal\'s total land area, consisting of several valleys, basins, and low mountain ranges.\"},{\"question\":\"Which is the longest river system in Nepal?\",\"options\":[\"Koshi\",\"Gandaki\",\"Karnali\",\"Bagmati\"],\"answer\":2,\"explanation\":\"The Karnali River is the longest river system in Nepal, flowing from the Himalayas of Tibet down to India.\"},{\"question\":\"What is the exact height of Mount Everest as agreed by Nepal and China in 2020?\",\"options\":[\"8848 meters\",\"8848.48 meters\",\"8848.86 meters\",\"8850 meters\"],\"answer\":2,\"explanation\":\"The officially recognized and measured height of Mount Everest is 8848.86 meters.\"}]', NULL, NULL, 'quiz', 3, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (57, 36, 'Verbal Analogy and Series Methods', 'verbal-analogy-and-series-methods', '<h3>Understanding Verbal Series</h3><p>Verbal series questions test your ability to recognize logical patterns in letter structures, word formations, and conceptual sequences. Here are the core methods to solve them quickly:</p><ul><li><strong>Letter Spacing:</strong> Check the intervals between letters (e.g., A, C, E, G, ... has an interval of +2).</li><li><strong>Reverse Positions:</strong> Remember the alphabetical ranking from both ends (A=1, Z=26; Z=1, A=26).</li><li><strong>Vowel-Consonant Patterns:</strong> Some series switch strictly based on English vowels (A, E, I, O, U).</li></ul>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (58, 36, 'IQ Mini Test', 'iq-mini-test', '[{\"question\":\"Find the next term in the series: B, D, F, H, ?\",\"options\":[\"I\",\"J\",\"K\",\"L\"],\"answer\":1,\"explanation\":\"The series advances by skipping one letter each time (+2 interval). After H, skipping I gives J.\"},{\"question\":\"If LION is coded as MJPO, how is TIGER coded?\",\"options\":[\"UJHFS\",\"UKHFS\",\"UJGFS\",\"UIHFS\"],\"answer\":0,\"explanation\":\"Each letter in the word is shifted forward by one position (+1). T->U, I->J, G->H, E->F, R->S.\"}]', NULL, NULL, 'quiz', 2, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (59, 37, 'Objectives and Functions of NRB', 'objectives-and-functions-of-nrb', '<h3>Objectives of NRB (Section 4)</h3><p>According to Section 4 of the NRB Act, 2058, the central bank is established with the following primary objectives:</p><ul><li>To formulate and manage necessary monetary and foreign exchange policies to maintain price stability and balance of payment stability.</li><li>To promote stability and healthy growth of banking and financial sectors.</li><li>To develop a secure, healthy, and efficient payment system.</li></ul><h3>Core Functions of NRB</h3><p>NRB acts as the supervisor, regulator, bank of banks, and financial advisor to the Government of Nepal.</p>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (60, 37, 'NRB Act Section 4 Quiz', 'nrb-act-section-4-quiz', '[{\"question\":\"Under which section of the Nepal Rastra Bank Act, 2058 are the objectives of the Bank defined?\",\"options\":[\"Section 3\",\"Section 4\",\"Section 5\",\"Section 10\"],\"answer\":1,\"explanation\":\"Section 4 of the Nepal Rastra Bank Act, 2058 explicitly defines the objectives of the central bank.\"}]', NULL, NULL, 'quiz', 2, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (61, 38, 'Double Entry System and Bank Ledgers', 'double-entry-system-and-bank-ledgers', '<h3>Double Entry System in Banking</h3><p>Every transaction in a bank involves a debit and a credit of equal amounts. A bank ledger records client deposits as liabilities (since the bank owes that money) and loans advanced as assets (since they generate interest income).</p>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (62, 39, 'New Public Management (NPM) Concepts', 'new-public-management-npm-concepts', '<h3>New Public Management (NPM)</h3><p>New Public Management is an approach to running public service organizations that is used in government and public sector institutions. It emphasizes market orientation, efficiency, customer focus, and decentralization of authority.</p>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (63, 40, 'Office Filing Techniques', 'office-filing-techniques', '<h3>What is Filing?</h3><p>Filing is the process of arranging and storing records in a systematic, orderly manner so they can be easily retrieved when needed. In Nepalese government offices, filing ensures transparency, audit compliance, and memory retention of administrative actions.</p>', NULL, NULL, 'text', 1, 0, 1, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (64, 35, 'MCQ Practice: Physical Geography of Nepal', 'mcq-physical-geography-of-nepal', '[{\"question\":\"Which statement best describes Nepal’s location?\",\"options\":[\"An island country in South Asia\",\"A landlocked country between China and India\",\"A coastal state on the Bay of Bengal\",\"A plateau country east of Bhutan\"],\"answer\":1,\"explanation\":\"Nepal is a landlocked South Asian country with China to the north and India to the south, east, and west.\"},{\"question\":\"Which ecological region of Nepal lies along the southern plains?\",\"options\":[\"Himalayan region\",\"Mid-hill region\",\"Tarai region\",\"Trans-Himalayan region\"],\"answer\":2,\"explanation\":\"The Tarai is the low, flat southern belt of Nepal.\"},{\"question\":\"Which river is listed among Nepal’s perennial Himalayan-origin rivers?\",\"options\":[\"Koshi\",\"Bagmati only\",\"Kamala only\",\"Kankai only\"],\"answer\":0,\"explanation\":\"Koshi is one of Nepal’s major perennial rivers that drains southward from the Himalayan system.\"},{\"question\":\"What is the jointly announced latest height of Mount Everest?\",\"options\":[\"8,848.00 m\",\"8,848.86 m\",\"8,850.00 m\",\"8,586.00 m\"],\"answer\":1,\"explanation\":\"Nepal and China jointly announced Mount Everest’s height as 8,848.86 meters in 2020.\"},{\"question\":\"Which pair of valleys is commonly associated with Nepal’s mid-hill region?\",\"options\":[\"Kathmandu and Pokhara\",\"Biratnagar and Janakpur\",\"Kechana and Kakarbhitta\",\"Mustang and Dolpo only\"],\"answer\":0,\"explanation\":\"Kathmandu and Pokhara valleys lie in the mid-hill region north of the Mahabharat range.\"}]', NULL, NULL, 'quiz', 4, 0, 1, '2026-08-07 09:47:57', '2026-08-07 09:47:57');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (65, 35, 'MCQ Practice: Official Nayab Subba Syllabus PDF', 'mcq-official-nayab-subba-syllabus-pdf', '[{\"question\":\"What should a candidate do first after receiving the Nayab Subba syllabus?\",\"options\":[\"Memorize only current affairs\",\"Map topics by paper and marks weight\",\"Skip objective sections\",\"Read only model answers\"],\"answer\":1,\"explanation\":\"A syllabus is most useful when topics are mapped by paper, marks, and priority before study begins.\"},{\"question\":\"Which section is commonly tested in the first-paper objective preparation?\",\"options\":[\"General Knowledge and IQ\",\"Interview dress code only\",\"Only accounting vouchers\",\"Only foreign policy essays\"],\"answer\":0,\"explanation\":\"Nayab Subba first-paper preparation commonly includes GK and IQ\\/objective aptitude topics.\"},{\"question\":\"Why should candidates print or save the official syllabus?\",\"options\":[\"To replace all textbooks\",\"To track coverage and avoid off-syllabus study\",\"To avoid practice questions\",\"To skip revision\"],\"answer\":1,\"explanation\":\"The official syllabus keeps preparation aligned with examinable areas.\"},{\"question\":\"Which study habit best supports syllabus-based preparation?\",\"options\":[\"Random reading without notes\",\"Topic checklist with repeated revision\",\"Studying only one subject\",\"Avoiding past patterns\"],\"answer\":1,\"explanation\":\"A checklist plus scheduled revision helps ensure each syllabus topic is covered.\"},{\"question\":\"What is the main purpose of a syllabus PDF in this LMS?\",\"options\":[\"Entertainment reading\",\"Course planning and preparation tracking\",\"Replacing login credentials\",\"Changing course prerequisites\"],\"answer\":1,\"explanation\":\"The syllabus PDF supports course planning and helps students track exam preparation scope.\"}]', NULL, NULL, 'quiz', 5, 0, 1, '2026-08-07 09:47:57', '2026-08-07 09:47:57');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (66, 36, 'MCQ Practice: Verbal Analogy and Series Methods', 'mcq-verbal-analogy-and-series-methods', '[{\"question\":\"Find the next term: C, F, I, L, ?\",\"options\":[\"M\",\"N\",\"O\",\"P\"],\"answer\":2,\"explanation\":\"The sequence increases by three letters each time: C, F, I, L, O.\"},{\"question\":\"If A = 1 and Z = 26, what is the reverse-position value of B?\",\"options\":[\"2\",\"24\",\"25\",\"26\"],\"answer\":2,\"explanation\":\"In reverse alphabet position, Z = 1, Y = 2, and B = 25.\"},{\"question\":\"Complete the analogy: Book : Reading :: Pen : ?\",\"options\":[\"Writing\",\"Running\",\"Cooking\",\"Measuring\"],\"answer\":0,\"explanation\":\"A book is used for reading; a pen is used for writing.\"},{\"question\":\"If CAT is coded as DBU, which rule is used?\",\"options\":[\"Each letter moves one step forward\",\"Each letter moves one step backward\",\"Letters are reversed\",\"Only vowels change\"],\"answer\":0,\"explanation\":\"C->D, A->B, and T->U, so every letter advances by one position.\"},{\"question\":\"Which pattern is most likely in A, E, I, O, ?\",\"options\":[\"Consonants\",\"Prime numbers\",\"English vowels\",\"Months\"],\"answer\":2,\"explanation\":\"A, E, I, O, U are the common English vowels.\"}]', NULL, NULL, 'quiz', 3, 0, 1, '2026-08-07 09:47:57', '2026-08-07 09:47:57');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (67, 37, 'MCQ Practice: Objectives and Functions of NRB', 'mcq-objectives-and-functions-of-nrb', '[{\"question\":\"Which law defines the objectives and functions of Nepal Rastra Bank?\",\"options\":[\"Companies Act\",\"Nepal Rastra Bank Act, 2058\",\"Civil Service Act\",\"Public Procurement Act\"],\"answer\":1,\"explanation\":\"The Nepal Rastra Bank Act, 2058 establishes NRB and states its objectives and functions.\"},{\"question\":\"Which section of the NRB Act states the objectives of the Bank?\",\"options\":[\"Section 2\",\"Section 4\",\"Section 8\",\"Section 12\"],\"answer\":1,\"explanation\":\"Section 4 lists the objectives of Nepal Rastra Bank.\"},{\"question\":\"Which objective is directly related to monetary and foreign exchange policy?\",\"options\":[\"Maintaining price and balance of payment stability\",\"Constructing highways\",\"Managing schools\",\"Issuing citizenship certificates\"],\"answer\":0,\"explanation\":\"NRB formulates monetary and foreign exchange policies to support price and balance of payment stability.\"},{\"question\":\"Which system is NRB expected to help develop securely and efficiently?\",\"options\":[\"Payment system\",\"Road transport system\",\"Postal stamp system\",\"Land registration system\"],\"answer\":0,\"explanation\":\"Developing a secure, healthy, and efficient payment system is one objective of NRB.\"},{\"question\":\"In Nepal’s financial sector, NRB primarily acts as which type of institution?\",\"options\":[\"Central bank and regulator\",\"Commercial retailer\",\"Municipality\",\"Insurance broker only\"],\"answer\":0,\"explanation\":\"NRB is Nepal’s central bank and regulates, supervises, and supports the banking and monetary system.\"}]', NULL, NULL, 'quiz', 3, 0, 1, '2026-08-07 09:47:57', '2026-08-07 09:47:57');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (68, 38, 'MCQ Practice: Double Entry System and Bank Ledgers', 'mcq-double-entry-system-and-bank-ledgers', '[{\"question\":\"What is the core rule of the double-entry system?\",\"options\":[\"Only cash transactions are recorded\",\"Every transaction has equal debit and credit effects\",\"Assets are never recorded\",\"Only profit is recorded\"],\"answer\":1,\"explanation\":\"Double-entry accounting records every transaction with equal debit and credit effects.\"},{\"question\":\"For a bank, customer deposits are usually classified as:\",\"options\":[\"Assets\",\"Liabilities\",\"Owner drawings\",\"Fixed expenses only\"],\"answer\":1,\"explanation\":\"Customer deposits are liabilities because the bank owes that money to depositors.\"},{\"question\":\"Loans advanced by a bank are generally recorded as:\",\"options\":[\"Assets\",\"Liabilities\",\"Capital losses\",\"Suspense only\"],\"answer\":0,\"explanation\":\"Loans are assets for a bank because borrowers owe repayment and interest to the bank.\"},{\"question\":\"Which book records account-wise classified transactions?\",\"options\":[\"Ledger\",\"Attendance sheet\",\"Dispatch register only\",\"Minute book only\"],\"answer\":0,\"explanation\":\"A ledger classifies transactions under their respective accounts.\"},{\"question\":\"Why is equal debit-credit recording important?\",\"options\":[\"It helps detect arithmetic imbalance\",\"It removes the need for documents\",\"It hides liabilities\",\"It prevents audits\"],\"answer\":0,\"explanation\":\"If debits and credits do not match, it signals an error that needs review.\"}]', NULL, NULL, 'quiz', 2, 0, 1, '2026-08-07 09:47:57', '2026-08-07 09:47:57');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (69, 39, 'MCQ Practice: New Public Management (NPM) Concepts', 'mcq-new-public-management-npm-concepts', '[{\"question\":\"What does New Public Management emphasize most?\",\"options\":[\"Citizen focus, efficiency, and results\",\"More paperwork only\",\"No performance measurement\",\"Abolition of public services\"],\"answer\":0,\"explanation\":\"NPM emphasizes performance, efficiency, service quality, and citizen\\/customer orientation.\"},{\"question\":\"Which practice best reflects NPM?\",\"options\":[\"Performance targets for service units\",\"No delegation of authority\",\"Ignoring service users\",\"Only seniority-based decisions\"],\"answer\":0,\"explanation\":\"Performance targets and measurable results are typical NPM tools.\"},{\"question\":\"Which term is closest to the NPM view of citizens receiving services?\",\"options\":[\"Customers or service users\",\"Subjects without rights\",\"Internal files only\",\"Suppliers only\"],\"answer\":0,\"explanation\":\"NPM often treats citizens as service users whose satisfaction and outcomes matter.\"},{\"question\":\"Which feature is commonly linked with NPM reforms?\",\"options\":[\"Decentralization of authority\",\"Centralizing every minor decision\",\"Removing accountability\",\"Ending budgeting\"],\"answer\":0,\"explanation\":\"NPM supports delegation and decentralization to improve responsiveness and performance.\"},{\"question\":\"What is a likely risk if NPM is applied without public accountability?\",\"options\":[\"Equity and public-interest goals may be weakened\",\"All corruption automatically ends\",\"Laws become unnecessary\",\"Citizens stop needing services\"],\"answer\":0,\"explanation\":\"Efficiency-focused reforms must still protect equity, accountability, and public interest.\"}]', NULL, NULL, 'quiz', 2, 0, 1, '2026-08-07 09:47:57', '2026-08-07 09:47:57');
INSERT INTO `lessons` (`id`, `chapter_id`, `title`, `slug`, `content`, `video_url`, `attachment_path`, `type`, `order`, `duration_minutes`, `is_published`, `created_at`, `updated_at`) VALUES (70, 40, 'MCQ Practice: Office Filing Techniques', 'mcq-office-filing-techniques', '[{\"question\":\"What is the main purpose of office filing?\",\"options\":[\"Systematic storage and easy retrieval of records\",\"Destroying all records immediately\",\"Avoiding registration\",\"Replacing official correspondence\"],\"answer\":0,\"explanation\":\"Filing arranges records systematically so they can be found and used when needed.\"},{\"question\":\"Which activity supports tracking incoming and outgoing letters?\",\"options\":[\"Registration and dispatch\",\"Budget speech\",\"Leave approval only\",\"Furniture repair\"],\"answer\":0,\"explanation\":\"Registration and dispatch help track official correspondence movement.\"},{\"question\":\"What does indexing help with in record management?\",\"options\":[\"Finding files quickly by reference\",\"Increasing file weight\",\"Deleting subject headings\",\"Avoiding classification\"],\"answer\":0,\"explanation\":\"Indexing provides references that make files and records easier to locate.\"},{\"question\":\"Which is a good quality of an office filing system?\",\"options\":[\"Simple, secure, and expandable\",\"Secret from all authorized staff\",\"Randomly arranged\",\"Dependent on memory only\"],\"answer\":0,\"explanation\":\"A useful filing system should be simple, secure, economical, and able to grow with records.\"},{\"question\":\"Why are modern record systems useful in public offices?\",\"options\":[\"They improve storage, search, backup, and accountability\",\"They remove all legal duties\",\"They make indexing impossible\",\"They prevent transparency\"],\"answer\":0,\"explanation\":\"Modern record systems help offices manage records efficiently while supporting accountability and retrieval.\"}]', NULL, NULL, 'quiz', 2, 0, 1, '2026-08-07 09:47:57', '2026-08-07 09:47:57');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24, '2026_05_03_082923_create_courses_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25, '2026_05_03_082924_create_modules_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26, '2026_05_03_082925_create_chapters_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27, '2026_05_03_082925_create_lessons_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28, '2026_05_03_082926_create_course_prerequisites_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29, '2026_05_03_084546_create_permission_tables', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30, '2026_05_03_153318_create_enrollments_and_progress_tables', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31, '2026_07_18_100000_add_algorithm_fields_to_tables', 2);
COMMIT;

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
BEGIN;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (1, 'App\\Models\\User', 1);
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (2, 'App\\Models\\User', 2);
COMMIT;

-- ----------------------------
-- Table structure for modules
-- ----------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `modules_slug_unique` (`slug`),
  KEY `modules_course_id_foreign` (`course_id`),
  CONSTRAINT `modules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of modules
-- ----------------------------
BEGIN;
INSERT INTO `modules` (`id`, `course_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (35, 1, 'First Paper: General Knowledge (GK)', 'first-paper-general-knowledge-gk', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `modules` (`id`, `course_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (36, 1, 'First Paper: Intelligence Quotient (IQ)', 'first-paper-intelligence-quotient-iq', NULL, 2, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `modules` (`id`, `course_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (37, 2, 'Banking Laws & Economics', 'banking-laws-economics', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `modules` (`id`, `course_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (38, 3, 'Financial Accounting & Banking', 'financial-accounting-banking', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `modules` (`id`, `course_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (39, 4, 'Second Paper: Governance System', 'second-paper-governance-system', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
INSERT INTO `modules` (`id`, `course_id`, `title`, `slug`, `description`, `order`, `is_published`, `created_at`, `updated_at`) VALUES (40, 5, 'Office Management and Work Procedures', 'office-management-and-work-procedures', NULL, 1, 0, '2026-06-02 21:04:19', '2026-06-02 21:04:19');
COMMIT;

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (1, 'admin', 'web', '2026-05-03 15:45:36', '2026-05-03 15:45:36');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (2, 'user', 'web', '2026-05-03 15:45:36', '2026-05-03 15:45:36');
COMMIT;

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------
BEGIN;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('JHe3CLkhbwaZjnHAs8oRLMEe6QD47uy3ruemdhip', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUFDTlpXNXRaMHp5UmtpRUpzUGpKcmFHdHZYUzFlNkRFZHdpY2NIRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1786096309);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('v5ITYm22eQpVVC8CP2fcVyV0r0c3hqbcxjXk69kV', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR05NdVdJelBEemZrTU5qWlh1U3hHZ1l4T0N5cG96TlNITWI4ZDhneCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1786092819);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `learning_pace_multiplier` double NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (1, 'System Admin', 'admin@loksewa.com', NULL, '$2y$12$x4M732BmtEDdOaF3jHowAOYx2945y4mSFNF.rO3qgFBjLAGbMpzYG', NULL, '2026-05-03 15:45:37', '2026-07-24 04:18:16', 0.00019386574074074);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (2, 'Regular User', 'user@loksewa.com', NULL, '$2y$12$HqM/IbG2Q4sS/zkp8NU30.VCf9of0Si6aisETKUi48S2aTQrs6AaK', NULL, '2026-05-03 15:45:37', '2026-07-24 04:18:16', 0.00011863425925926);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (3, 'Aarav Sharma', 'aarav.sharma@demo.test', NULL, '$2y$12$ect0m61lJLYjUl40Rgw8UeTlrpQ7jFaWaetKikN6VcxG.IkBDBru.', NULL, '2026-07-24 03:47:33', '2026-07-24 04:18:16', 0.083333333333333);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (4, 'Bikash Thapa', 'bikash.thapa@demo.test', NULL, '$2y$12$.6Sj5SOwpiLZGSbrRo/zHeNO1Dhjx482Q4eV8.GkJj6IsZ/wzQWXy', NULL, '2026-07-24 03:47:34', '2026-07-24 04:18:17', 0.21666666666667);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (5, 'Chandani Gurung', 'chandani.gurung@demo.test', NULL, '$2y$12$bYJMYKRyS0C5Dfj6A/tsTOMm/mxETTm4B73hmrx6GviO6bNT1QMQ6', NULL, '2026-07-24 03:47:34', '2026-07-24 04:18:17', 0.027777777777778);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (6, 'Deepak Adhikari', 'deepak.adhikari@demo.test', NULL, '$2y$12$K9gj8A//Gj4WwfqN./flCeru71/DRTcLvf3AQrzsEzTjkZFPVa8Jy', NULL, '2026-07-24 03:47:34', '2026-07-24 04:18:17', 0.75);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (7, 'Elina Maharjan', 'elina.maharjan@demo.test', NULL, '$2y$12$DKtOM7oxLSCKPLs1ydYliuO1EbaUzWyfYU.LXDH9hczw.UjPKkUb2', NULL, '2026-07-24 03:47:35', '2026-07-24 04:18:18', 0.8);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (8, 'Firoz Magar', 'firoz.magar@demo.test', NULL, '$2y$12$W/TNF5txC/MWKhSV9AcPXeAnaFtE0Qt5VW31s2vNYBiS2XuYwkoH2', NULL, '2026-07-24 03:47:35', '2026-07-24 04:18:18', 1);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (9, 'Gita Basnet', 'gita.basnet@demo.test', NULL, '$2y$12$4uTDrW1jLYGsQVQOIbFv6uz2tJqPiavRrWdA.jQUZbJMTGExd0zYy', NULL, '2026-07-24 03:47:35', '2026-07-24 04:18:18', 1);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (10, 'Hari Koirala', 'hari.koirala@demo.test', NULL, '$2y$12$ACamIQku15ro/XJuc/fcW./zupDYW5WkiuZT8bunHF1IW5tNJ2u2u', NULL, '2026-07-24 03:47:35', '2026-07-24 04:18:19', 1.1);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (11, 'Isha Pandey', 'isha.pandey@demo.test', NULL, '$2y$12$Y043zlzX56QzoRIO3YX8XuYdDvUk3iWbJYXro6yn9Sayw6MX8kCk.', NULL, '2026-07-24 03:47:36', '2026-07-24 04:18:19', 1.3);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (12, 'Jeevan Rai', 'jeevan.rai@demo.test', NULL, '$2y$12$qTRChKSUBCiU/EZXAkAbZuPt/N0cuTSmlFGL2d1FQ/TrgrZt3PSdC', NULL, '2026-07-24 03:47:36', '2026-07-24 04:18:19', 1.5);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (13, 'Kabita Shrestha', 'kabita.shrestha@demo.test', NULL, '$2y$12$sSIk02U4/c3H1pAg3wKMR.IjJnx.vhZWsG2rj33OEZLHSYmru/xpm', NULL, '2026-07-24 03:47:36', '2026-07-24 04:18:19', 1.8);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (14, 'Laxmi Bhatt', 'laxmi.bhatt@demo.test', NULL, '$2y$12$lWM8yj7hEpvLm4fVjlivr.61H3urfDkup1qMAWgQCq1GnrRhXKHvC', NULL, '2026-07-24 03:47:37', '2026-07-24 04:18:20', 2);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (15, 'Manish Tamang', 'manish.tamang@demo.test', NULL, '$2y$12$XJ4YzKKv40hguqey5oLjjePex1BoAbfy9DhEy5ZhD9Dyh1sGNErbS', NULL, '2026-07-24 03:47:37', '2026-07-24 04:18:20', 0.4);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (16, 'Nisha Dhakal', 'nisha.dhakal@demo.test', NULL, '$2y$12$K/ZqCONOtMDwP/mMyKGx7.WxtohORbSQvP7ZDPBqIRKYj14Ti.Sfu', NULL, '2026-07-24 03:47:37', '2026-07-24 04:18:20', 0.9);
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `learning_pace_multiplier`) VALUES (17, 'Om Prasad Poudel', 'om.poudel@demo.test', NULL, '$2y$12$vKbg25OnDk0UmOR7A7WyZel9cE7Cj1s.189gM9o63HOdRSCR9lyYq', NULL, '2026-07-24 03:47:37', '2026-07-24 04:18:21', 1.2);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
