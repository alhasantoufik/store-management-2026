-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2026 at 06:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(8, 'Blair Page', 'blair-page', 'uploads/brands/1775288080.jpg', '2026-04-04 07:34:40', '2026-04-04 07:34:40');

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
('admin@admin.com|103.52.135.168', 'i:1;', 1768729124),
('admin@admin.com|103.52.135.168:timer', 'i:1768729124;', 1768729124),
('admin@admin.com|103.52.135.184', 'i:2;', 1770530888),
('admin@admin.com|103.52.135.184:timer', 'i:1770530888;', 1770530888),
('admin@admin.com|103.83.207.42', 'i:1;', 1772303765),
('admin@admin.com|103.83.207.42:timer', 'i:1772303765;', 1772303765),
('admin@gmail.com|103.52.135.160', 'i:2;', 1772347066),
('admin@gmail.com|103.52.135.160:timer', 'i:1772347066;', 1772347066),
('aminurba@gmail.com|114.130.156.166', 'i:1;', 1770541401),
('aminurba@gmail.com|114.130.156.166:timer', 'i:1770541401;', 1770541401),
('aminurba@gmail.com|114.130.156.49', 'i:1;', 1767418891),
('aminurba@gmail.com|114.130.156.49:timer', 'i:1767418891;', 1767418891),
('ka548301@gmail.com|114.130.156.88', 'i:2;', 1767588427),
('ka548301@gmail.com|114.130.156.88:timer', 'i:1767588427;', 1767588427),
('mahmudulhasan251030349689@gmail.com|114.130.156.173', 'i:1;', 1772518193),
('mahmudulhasan251030349689@gmail.com|114.130.156.173:timer', 'i:1772518193;', 1772518193),
('mahmudulhasan251030349689@gmail.com|114.130.157.111', 'i:2;', 1772691930),
('mahmudulhasan251030349689@gmail.com|114.130.157.111:timer', 'i:1772691930;', 1772691930),
('mdsfatmollika41@gmail.com|114.130.157.16', 'i:1;', 1768717881),
('mdsfatmollika41@gmail.com|114.130.157.16:timer', 'i:1768717881;', 1768717881),
('mdsifatmollika41@gmail.com|114.130.157.16', 'i:2;', 1768717965),
('mdsifatmollika41@gmail.com|114.130.157.16:timer', 'i:1768717965;', 1768717965),
('shakil2225553@gmail.com|114.130.156.49', 'i:1;', 1767418917),
('shakil2225553@gmail.com|114.130.156.49:timer', 'i:1767418917;', 1767418917),
('shakil225553@gmail.com|114.130.157.108', 'i:1;', 1770273179),
('shakil225553@gmail.com|114.130.157.108:timer', 'i:1770273179;', 1770273179);

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Test', 'test', '1775285111_Screenshot_2.jpg', 1, '2026-04-04 06:45:11', '2026-04-04 06:45:11');

-- --------------------------------------------------------

--
-- Table structure for table `costs`
--

CREATE TABLE `costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cost_category_id` bigint(20) UNSIGNED NOT NULL,
  `cost_field_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `cost_by` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT '2026-03-31',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `costs`
--

INSERT INTO `costs` (`id`, `cost_category_id`, `cost_field_id`, `amount`, `cost_by`, `date`, `created_at`, `updated_at`) VALUES
(5, 3, 2, 10000.00, 'Toufik', '2026-04-02', '2026-04-02 04:49:22', '2026-04-02 04:49:22'),
(6, 3, 1, 10000.00, 'Toufik', '2026-04-03', '2026-04-02 04:59:06', '2026-04-02 04:59:06'),
(7, 3, 2, 10000.00, 'Toufik', '2026-04-08', '2026-04-07 07:28:50', '2026-04-07 07:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `cost_categories`
--

CREATE TABLE `cost_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cost_categories`
--

INSERT INTO `cost_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'Salary', '2026-03-31 07:06:10', '2026-03-31 07:06:10'),
(3, 'Bill', '2026-04-01 10:38:13', '2026-04-01 10:38:13'),
(4, 'asasasa', '2026-04-07 07:28:36', '2026-04-07 07:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `cost_fields`
--

CREATE TABLE `cost_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cost_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cost_fields`
--

INSERT INTO `cost_fields` (`id`, `cost_category_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 3, 'Electricity', '2026-04-02 04:12:07', '2026-04-02 04:12:07'),
(2, 3, 'Internet Bill', '2026-04-02 04:12:27', '2026-04-02 04:12:27');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`) VALUES
(1, 'ঢাকা'),
(2, 'গাজীপুর'),
(3, 'নরসিংদী'),
(4, 'মানিকগঞ্জ'),
(5, 'নারায়ণগঞ্জ'),
(6, 'টাঙ্গাইল'),
(7, 'কিশোরগঞ্জ'),
(8, 'মুন্সীগঞ্জ'),
(9, 'রাজবাড়ী'),
(10, 'ফরিদপুর'),
(11, 'গোপালগঞ্জ'),
(12, 'মাদারীপুর'),
(13, 'শরীয়তপুর'),
(14, 'চট্টগ্রাম'),
(15, 'কক্সবাজার'),
(16, 'ব্রাহ্মণবাড়িয়া'),
(17, 'কুমিল্লা'),
(18, 'চাঁদপুর'),
(19, 'লক্ষ্মীপুর'),
(20, 'নোয়াখালী'),
(21, 'ফেনী'),
(22, 'খাগড়াছড়ি'),
(23, 'রাঙ্গামাটি'),
(24, 'বান্দরবান'),
(25, 'রাজশাহী'),
(26, 'নাটোর'),
(27, 'চাঁপাইনবাবগঞ্জ'),
(28, 'নওগাঁ'),
(29, 'বগুড়া'),
(30, 'জয়পুরহাট'),
(31, 'পাবনা'),
(32, 'সিরাজগঞ্জ'),
(33, 'খুলনা'),
(34, 'যশোর'),
(35, 'সাতক্ষীরা'),
(36, 'বাগেরহাট'),
(37, 'কুষ্টিয়া'),
(38, 'মেহেরপুর'),
(39, 'চুয়াডাঙ্গা'),
(40, 'ঝিনাইদহ'),
(41, 'মাগুরা'),
(42, 'নড়াইল'),
(43, 'বরিশাল'),
(44, 'পটুয়াখালী'),
(45, 'ভোলা'),
(46, 'পিরোজপুর'),
(47, 'বরগুনা'),
(48, 'ঝালকাঠি'),
(49, 'সিলেট'),
(50, 'মৌলভীবাজার'),
(51, 'হবিগঞ্জ'),
(52, 'সুনামগঞ্জ'),
(53, 'রংপুর'),
(54, 'দিনাজপুর'),
(55, 'কুড়িগ্রাম'),
(56, 'গাইবান্ধা'),
(57, 'লালমনিরহাট'),
(58, 'নীলফামারী'),
(59, 'পঞ্চগড়'),
(60, 'ঠাকুরগাঁও'),
(61, 'ময়মনসিংহ'),
(62, 'জামালপুর'),
(63, 'শেরপুর'),
(64, 'নেত্রকোণা');

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_pages`
--

CREATE TABLE `dynamic_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_slug` varchar(255) DEFAULT NULL,
  `page_content` longtext DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dynamic_pages`
--

INSERT INTO `dynamic_pages` (`id`, `page_title`, `page_slug`, `page_content`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Privacy And Policy', 'privacy-and-policy', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe dolorem dolor facilis ratione tempora corrupti voluptatum amet consequuntur obcaecati iste, consequatur aut delectus magnam velit magni atque modi? Sunt, laborum corporis ab iure eos earum nam aspernatur voluptates ipsa necessitatibus sint eveniet odio maxime? Voluptatum minima ducimus, veritatis libero accusantium ad sapiente culpa dolorum modi laborum repellat officiis facere saepe veniam ab? Placeat quisquam ut illum fugiat voluptate modi autem facilis eaque illo ab, exercitationem velit obcaecati explicabo, necessitatibus perferendis ipsum quibusdam eligendi culpa cum quod repellat. Quasi sed sequi, sint numquam id minima ea nostrum dolor sit expedita quis veritatis excepturi modi ipsum inventore magnam quo corporis aliquam, blanditiis officiis laborum unde ad est. Commodi nemo illum cupiditate eum. Autem fuga mollitia, praesentium laborum aut, illum consectetur earum sed at perferendis atque maxime iure deleniti id nisi debitis repellendus natus dolores accusantium, consequuntur error labore neque commodi! Rem impedit tempore nam dolores cupiditate ut et vero? Molestias, dolorem? Quisquam, nobis quibusdam quos nesciunt, dolor laboriosam tenetur quam dolorum ipsum alias accusantium atque dolores delectus harum. Adipisci, facilis earum pariatur cum nobis qui quam temporibus aspernatur ipsum excepturi mollitia officia magnam aut libero architecto saepe dignissimos voluptatibus omnis eaque vero sequi. Soluta unde eveniet consequuntur, numquam id officiis vel earum maiores aliquam enim quia modi aspernatur nobis dolores accusamus optio ipsa suscipit eius quis est distinctio cum placeat? Veniam, eum expedita cupiditate est magnam, maiores corporis quod, dolorem eius consequuntur provident nihil quam totam. Adipisci est qui eius unde et laborum maxime totam incidunt fuga. Optio, temporibus dignissimos. Amet, consequatur natus totam, libero impedit quos, blanditiis laborum iste dolorum fugit maxime voluptatum facilis beatae consequuntur aliquid nobis consectetur iusto enim laboriosam molestiae? Quisquam aperiam ea obcaecati neque magnam modi consequuntur, nisi, ipsum doloribus quasi sint placeat alias dolorem reiciendis illo blanditiis architecto mollitia dignissimos id libero? Ipsum, iure et? Doloribus quasi in adipisci, porro, accusamus dicta aut rerum voluptatum maiores ratione omnis, animi debitis officia quidem placeat voluptatem aperiam quod magnam amet ullam distinctio? Velit voluptatum ullam facilis distinctio voluptate et dolorem. Eos id, accusamus cum, animi iste, alias a voluptatibus quaerat aspernatur architecto dolore deserunt reiciendis repellat numquam. Vero veritatis amet aut tempore. Molestias, similique? Repellat doloribus laudantium tempora labore repellendus et ipsam, accusantium temporibus vel optio ipsa odit. Eaque debitis, quas dolor ad nemo totam, dolorem quam illum soluta, voluptates omnis ducimus id reiciendis pariatur ullam officiis ipsum neque cum sequi quidem quisquam fugiat earum. Nostrum atque assumenda dignissimos doloremque mollitia nemo voluptatibus dolore deleniti veniam ducimus ut delectus, illum ipsa placeat, voluptatum eius aliquid ratione rem praesentium esse! Ipsum, quae asperiores debitis ducimus rerum cumque quis labore fugiat optio cum repudiandae provident ullam reprehenderit laudantium. Animi eligendi tempore vero rerum a repellendus culpa optio assumenda illum provident, quasi blanditiis, esse eveniet minima eius? Nostrum eos impedit voluptas atque earum, quae perspiciatis voluptate qui quaerat doloremque sequi, hic quos. Dolor, non numquam dolorem maxime provident quasi vitae, doloremque veritatis molestiae aperiam, eum impedit. Corrupti id iusto accusamus beatae!', 'active', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_otps`
--

CREATE TABLE `email_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `verification_code` varchar(4) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_05_11_092920_create_system_settings_table', 1),
(5, '2024_05_12_052436_create_social_media_table', 1),
(6, '2024_05_12_082053_create_dynamic_pages_table', 1),
(7, '2024_09_15_023953_create_email_otps_table', 1),
(8, '2025_12_03_171126_create_categories_table', 1),
(9, '2025_12_03_171156_create_helpers_table', 1),
(10, '2025_12_03_171206_create_cost_sources_table', 1),
(11, '2025_12_03_171217_create_costs_table', 1),
(12, '2025_12_03_171228_create_districts_table', 1),
(13, '2025_12_03_171241_create_sub_districts_table', 1),
(14, '2025_12_03_171254_create_receivers_table', 1),
(15, '2025_12_03_171307_create_receiver_files_table', 1),
(16, '2025_12_03_171748_create_transactions_table', 1),
(17, '2025_12_08_204828_create_privileges_table', 1),
(18, '2026_03_28_143909_create_collectors_table', 2),
(19, '2026_03_28_152557_create_leads_table', 3),
(20, '2026_03_28_161315_add_sub_district_id_to_leads', 4),
(21, '2026_03_28_162737_add_collector_id_to_leads_table', 5),
(22, '2026_03_29_105200_add_status_updated_at_to_leads_table', 6),
(23, '2026_03_29_163236_add_followup_status_to_leads_table', 7),
(24, '2026_04_04_125318_create_brands_table', 8),
(25, '2026_04_04_135502_create_products_table', 9),
(26, '2026_04_04_151933_create_stocks_table', 10),
(27, '2026_04_04_162920_create_stocks_table', 11),
(28, '2026_04_07_093834_create_stock_transactions_table', 12),
(29, '2026_04_07_131036_create_cost_categories_table', 13),
(30, '2026_04_07_131124_create_cost_fields_table', 14),
(31, '2026_04_08_102149_create_stock_in_invoices_table', 15);

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
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(255) NOT NULL,
  `actions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`actions`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `user_id`, `module`, `actions`, `created_at`, `updated_at`) VALUES
(1, 1, 'dashboard', '\"[\\\"view\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(2, 1, 'categories', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(3, 1, 'helpers', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(4, 1, 'receivers', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(5, 1, 'costs', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(6, 1, 'cost_sources', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(7, 1, 'reports', '\"[\\\"view\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(8, 1, 'admins', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(9, 1, 'privileges', '\"[\\\"view\\\",\\\"edit\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(10, 1, 'settings', '\"[\\\"view\\\",\\\"edit\\\"]\"', '2025-12-10 12:23:04', '2025-12-10 12:23:04'),
(151, 8, 'dashboard', '\"[\\\"view\\\"]\"', NULL, NULL),
(152, 8, 'categories', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', NULL, NULL),
(153, 8, 'helpers', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', NULL, NULL),
(154, 8, 'receivers', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', NULL, NULL),
(155, 8, 'costs', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', NULL, NULL),
(156, 8, 'cost_sources', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', NULL, NULL),
(157, 8, 'reports', '\"[\\\"view\\\"]\"', NULL, NULL),
(158, 8, 'admins', '\"[\\\"view\\\",\\\"create\\\",\\\"edit\\\",\\\"delete\\\"]\"', NULL, NULL),
(159, 8, 'privileges', '\"[\\\"view\\\",\\\"edit\\\"]\"', NULL, NULL),
(160, 8, 'settings', '\"[\\\"view\\\",\\\"edit\\\"]\"', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `total_stock` int(50) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `brand_id`, `product_price`, `sale_price`, `unit`, `status`, `total_stock`, `created_at`, `updated_at`) VALUES
(1, 'Mango', 10, 8, 300.00, 400.00, 'pcs', 'active', 112, '2026-04-07 07:40:15', '2026-04-08 06:14:27'),
(2, 'Banana', 10, 8, 250.00, 300.00, 'kg', 'active', 107, '2026-04-07 07:40:32', '2026-04-08 06:03:49'),
(3, 'Chicken (1kg)', 10, 8, 175.00, 220.00, 'kg', 'active', 72, '2026-04-07 07:41:05', '2026-04-08 06:04:24');

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
('tpgAb8dXceXk24AOI6E4IDFEBSJKU3HJ2lFELZvO', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSHFRN240Y3JZMnVENUd3YlYxY2cySHJzYW5lWFNON1E2dmVNYkNQZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hZG1pbi9wcm9kdWN0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7fQ==', 1775631238);

-- --------------------------------------------------------

--
-- Table structure for table `sms_limits`
--

CREATE TABLE `sms_limits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `previous_sms` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(10,2) NOT NULL,
  `sms` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_limits`
--

INSERT INTO `sms_limits` (`id`, `date`, `previous_sms`, `amount`, `sms`, `created_at`, `updated_at`) VALUES
(2, '2026-03-04', 0, 0.00, 0, '2026-03-04 13:12:36', '2026-03-04 13:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `sms_count` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_logs`
--

INSERT INTO `sms_logs` (`id`, `mobile`, `message`, `status`, `sms_count`, `created_at`, `updated_at`) VALUES
(45, '8801725863605', 'Toufik, ক্রমিক নংঃ 0000374, প্রসেসিং চার্জঃ 111, অনলাইন চার্জঃ 111, মোট চার্জঃ 222, জমা হয়েছে। -ভুমিসেবা সহায়তা কেন্দ্র', 'SUCCESS', 3, '2026-03-05 07:42:55', '2026-03-05 07:42:55');

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE `social_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `social_media` varchar(255) DEFAULT NULL,
  `profile_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_media`
--

INSERT INTO `social_media` (`id`, `social_media`, `profile_link`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'facebook', 'https://www.facebook.com/', '2025-12-10 12:23:02', NULL, NULL),
(2, 'twitter', 'https://x.com/?lang=en', '2025-12-10 12:23:02', NULL, NULL),
(3, 'linkedin', 'https://bd.linkedin.com/', '2025-12-10 12:23:02', NULL, NULL),
(4, 'instagram', 'https://www.instagram.com/', '2025-12-10 12:23:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `stock_type` enum('in','out') NOT NULL DEFAULT 'in',
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_in_invoices`
--

CREATE TABLE `stock_in_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) NOT NULL,
  `pdf_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('in','out','return') NOT NULL,
  `previous_stock` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` varchar(255) NOT NULL DEFAULT '0',
  `current_stock` int(11) NOT NULL,
  `in_date` date NOT NULL DEFAULT current_timestamp(),
  `note` varchar(255) DEFAULT NULL,
  `voucher_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transactions`
--

INSERT INTO `stock_transactions` (`id`, `product_id`, `type`, `previous_stock`, `quantity`, `total_price`, `current_stock`, `in_date`, `note`, `voucher_no`, `created_at`, `updated_at`) VALUES
(4, 1, 'in', 0, 10, '4000', 10, '2026-04-08', 'Stock In', 'IN2026040001', '2026-04-08 03:20:11', '2026-04-08 03:20:11'),
(5, 2, 'in', 0, 10, '3500', 10, '2026-04-08', 'Stock In', 'IN2026040001', '2026-04-08 03:20:11', '2026-04-08 03:20:11'),
(6, 3, 'in', 0, 10, '2750', 10, '2026-04-08', 'Stock In', 'IN2026040001', '2026-04-08 03:20:11', '2026-04-08 03:20:11'),
(7, 1, 'out', 10, 5, '2500', 5, '2026-04-08', 'Stock Out', 'OUT2026040001', '2026-04-08 03:28:07', '2026-04-08 03:28:07'),
(8, 2, 'out', 10, 5, '2000', 5, '2026-04-08', 'Stock Out', 'OUT2026040001', '2026-04-08 03:28:07', '2026-04-08 03:28:07'),
(9, 3, 'out', 10, 5, '1600', 5, '2026-04-08', 'Stock Out', 'OUT2026040001', '2026-04-08 03:28:07', '2026-04-08 03:28:07'),
(10, 1, 'return', 5, 5, '-1000', 10, '2026-04-08', 'Stock Return', 'RET20260400001', '2026-04-08 03:42:27', '2026-04-08 03:42:27'),
(11, 2, 'return', 5, 5, '-1000', 10, '2026-04-08', 'Stock Return', 'RET20260400001', '2026-04-08 03:42:27', '2026-04-08 03:42:27'),
(12, 3, 'return', 5, 5, '-750', 10, '2026-04-08', 'Stock Return', 'RET20260400001', '2026-04-08 03:42:27', '2026-04-08 03:42:27'),
(13, 1, 'in', 10, 5, '1500', 15, '2026-04-08', 'Stock In', 'IN20260440002', '2026-04-08 03:50:57', '2026-04-08 03:50:57'),
(14, 2, 'in', 10, 5, '1250', 15, '2026-04-08', 'Stock In', 'IN20260440002', '2026-04-08 03:50:57', '2026-04-08 03:50:57'),
(15, 3, 'in', 10, 5, '875', 15, '2026-04-08', 'Stock In', 'IN20260440002', '2026-04-08 03:50:57', '2026-04-08 03:50:57'),
(16, 1, 'in', 15, 5, '1500', 20, '2026-04-08', 'Stock In', 'IN20260440003', '2026-04-08 03:56:10', '2026-04-08 03:56:10'),
(17, 2, 'in', 15, 5, '1250', 20, '2026-04-08', 'Stock In', 'IN20260440003', '2026-04-08 03:56:10', '2026-04-08 03:56:10'),
(18, 3, 'in', 15, 5, '875', 20, '2026-04-08', 'Stock In', 'IN20260440003', '2026-04-08 03:56:10', '2026-04-08 03:56:10'),
(19, 1, 'in', 20, 5, '1500', 25, '2026-04-08', 'Stock In', 'IN20260440004', '2026-04-08 03:57:40', '2026-04-08 03:57:40'),
(20, 2, 'in', 20, 5, '1250', 25, '2026-04-08', 'Stock In', 'IN20260440004', '2026-04-08 03:57:40', '2026-04-08 03:57:40'),
(21, 3, 'in', 20, 5, '875', 25, '2026-04-08', 'Stock In', 'IN20260440004', '2026-04-08 03:57:40', '2026-04-08 03:57:40'),
(22, 1, 'in', 25, 5, '2000', 30, '2026-04-08', 'Stock In', 'IN20260440005', '2026-04-08 03:58:07', '2026-04-08 03:58:07'),
(23, 2, 'in', 25, 5, '1750', 30, '2026-04-08', 'Stock In', 'IN20260440005', '2026-04-08 03:58:07', '2026-04-08 03:58:07'),
(24, 3, 'in', 25, 5, '1375', 30, '2026-04-08', 'Stock In', 'IN20260440005', '2026-04-08 03:58:07', '2026-04-08 03:58:07'),
(25, 1, 'in', 30, 5, '1500', 35, '2026-04-08', 'Stock In', 'IN20260440006', '2026-04-08 04:01:37', '2026-04-08 04:01:37'),
(26, 2, 'in', 30, 5, '1250', 35, '2026-04-08', 'Stock In', 'IN20260440006', '2026-04-08 04:01:37', '2026-04-08 04:01:37'),
(27, 3, 'in', 30, 5, '875', 35, '2026-04-08', 'Stock In', 'IN20260440006', '2026-04-08 04:01:37', '2026-04-08 04:01:37'),
(28, 1, 'in', 35, 5, '1500', 40, '2026-04-08', 'Stock In', 'IN20260440007', '2026-04-08 04:06:35', '2026-04-08 04:06:35'),
(29, 2, 'in', 35, 5, '1250', 40, '2026-04-08', 'Stock In', 'IN20260440007', '2026-04-08 04:06:35', '2026-04-08 04:06:35'),
(30, 3, 'in', 35, 5, '875', 40, '2026-04-08', 'Stock In', 'IN20260440007', '2026-04-08 04:06:35', '2026-04-08 04:06:35'),
(37, 2, 'in', 40, 5, '1250', 45, '2026-04-08', 'Stock In', 'IN20260440008', '2026-04-08 04:30:43', '2026-04-08 04:30:43'),
(38, 3, 'in', 40, 5, '875', 45, '2026-04-08', 'Stock In', 'IN20260440008', '2026-04-08 04:30:43', '2026-04-08 04:30:43'),
(39, 1, 'in', 40, 5, '1500', 45, '2026-04-08', 'Stock In', 'IN20260440008', '2026-04-08 04:30:43', '2026-04-08 04:30:43'),
(40, 1, 'in', 45, 5, '1250', 50, '2026-04-08', 'Stock In', 'IN20260440009', '2026-04-08 04:33:16', '2026-04-08 04:33:16'),
(41, 2, 'in', 45, 5, '1250', 50, '2026-04-08', 'Stock In', 'IN20260440009', '2026-04-08 04:33:16', '2026-04-08 04:33:16'),
(42, 3, 'in', 45, 5, '875', 50, '2026-04-08', 'Stock In', 'IN20260440009', '2026-04-08 04:33:16', '2026-04-08 04:33:16'),
(43, 1, 'out', 50, 10, '4000', 40, '2026-04-08', 'Stock Out', 'OUT20260440002', '2026-04-08 04:36:24', '2026-04-08 04:36:24'),
(44, 2, 'out', 50, 10, '3000', 40, '2026-04-08', 'Stock Out', 'OUT20260440002', '2026-04-08 04:36:24', '2026-04-08 04:36:24'),
(45, 3, 'out', 50, 10, '2200', 40, '2026-04-08', 'Stock Out', 'OUT20260440002', '2026-04-08 04:36:24', '2026-04-08 04:36:24'),
(46, 1, 'out', 40, 5, '2000', 35, '2026-04-08', 'Stock Out', 'OUT20260440003', '2026-04-08 04:38:05', '2026-04-08 04:38:05'),
(47, 2, 'out', 40, 5, '1500', 35, '2026-04-08', 'Stock Out', 'OUT20260440003', '2026-04-08 04:38:05', '2026-04-08 04:38:05'),
(48, 3, 'out', 40, 5, '1100', 35, '2026-04-08', 'Stock Out', 'OUT20260440003', '2026-04-08 04:38:05', '2026-04-08 04:38:05'),
(49, 1, 'out', 35, 10, '4000', 25, '2026-04-08', 'Stock Out', 'OUT20260440004', '2026-04-08 04:42:22', '2026-04-08 04:42:22'),
(50, 2, 'out', 35, 10, '3000', 25, '2026-04-08', 'Stock Out', 'OUT20260440004', '2026-04-08 04:42:22', '2026-04-08 04:42:22'),
(51, 3, 'out', 35, 10, '2200', 25, '2026-04-08', 'Stock Out', 'OUT20260440004', '2026-04-08 04:42:22', '2026-04-08 04:42:22'),
(52, 1, 'out', 25, 10, '4000', 15, '2026-04-08', 'Stock Out', 'OUT20260440005', '2026-04-08 04:43:42', '2026-04-08 04:43:42'),
(53, 2, 'out', 25, 10, '3000', 15, '2026-04-08', 'Stock Out', 'OUT20260440005', '2026-04-08 04:43:42', '2026-04-08 04:43:42'),
(54, 3, 'out', 25, 10, '2200', 15, '2026-04-08', 'Stock Out', 'OUT20260440005', '2026-04-08 04:43:42', '2026-04-08 04:43:42'),
(55, 1, 'out', 15, 5, '2000', 10, '2026-04-08', 'Stock Out', 'OUT20260440006', '2026-04-08 04:47:02', '2026-04-08 04:47:02'),
(56, 2, 'out', 15, 5, '1500', 10, '2026-04-08', 'Stock Out', 'OUT20260440006', '2026-04-08 04:47:02', '2026-04-08 04:47:02'),
(57, 3, 'out', 15, 5, '1100', 10, '2026-04-08', 'Stock Out', 'OUT20260440006', '2026-04-08 04:47:02', '2026-04-08 04:47:02'),
(58, 1, 'out', 10, 5, '2000', 5, '2026-04-08', 'Stock Out', 'OUT20260440007', '2026-04-08 04:48:06', '2026-04-08 04:48:06'),
(59, 2, 'out', 10, 5, '1500', 5, '2026-04-08', 'Stock Out', 'OUT20260440007', '2026-04-08 04:48:06', '2026-04-08 04:48:06'),
(60, 3, 'out', 10, 5, '1100', 5, '2026-04-08', 'Stock Out', 'OUT20260440007', '2026-04-08 04:48:06', '2026-04-08 04:48:06'),
(61, 1, 'out', 5, 2, '800', 3, '2026-04-08', 'Stock Out', 'OUT20260440008', '2026-04-08 04:48:33', '2026-04-08 04:48:33'),
(62, 2, 'out', 5, 2, '600', 3, '2026-04-08', 'Stock Out', 'OUT20260440008', '2026-04-08 04:48:33', '2026-04-08 04:48:33'),
(63, 3, 'out', 5, 2, '440', 3, '2026-04-08', 'Stock Out', 'OUT20260440008', '2026-04-08 04:48:33', '2026-04-08 04:48:33'),
(64, 1, 'out', 3, 1, '400', 2, '2026-04-08', 'Stock Out', 'OUT20260440009', '2026-04-08 04:52:12', '2026-04-08 04:52:12'),
(65, 2, 'out', 3, 1, '300', 2, '2026-04-08', 'Stock Out', 'OUT20260440009', '2026-04-08 04:52:12', '2026-04-08 04:52:12'),
(66, 3, 'out', 3, 1, '220', 2, '2026-04-08', 'Stock Out', 'OUT20260440009', '2026-04-08 04:52:12', '2026-04-08 04:52:12'),
(67, 1, 'in', 2, 100, '30000', 102, '2026-04-08', 'Stock In', 'IN20260440010', '2026-04-08 04:53:05', '2026-04-08 04:53:05'),
(68, 2, 'in', 2, 100, '25000', 102, '2026-04-08', 'Stock In', 'IN20260440010', '2026-04-08 04:53:05', '2026-04-08 04:53:05'),
(69, 3, 'in', 2, 100, '17500', 102, '2026-04-08', 'Stock In', 'IN20260440010', '2026-04-08 04:53:05', '2026-04-08 04:53:05'),
(70, 1, 'out', 102, 5, '2000', 97, '2026-04-08', 'Stock Out', 'OUT20260440010', '2026-04-08 04:53:22', '2026-04-08 04:53:22'),
(71, 2, 'out', 102, 5, '1500', 97, '2026-04-08', 'Stock Out', 'OUT20260440010', '2026-04-08 04:53:22', '2026-04-08 04:53:22'),
(72, 3, 'out', 102, 5, '1100', 97, '2026-04-08', 'Stock Out', 'OUT20260440010', '2026-04-08 04:53:22', '2026-04-08 04:53:22'),
(73, 1, 'out', 97, 5, '2000', 92, '2026-04-08', 'Stock Out', 'OUT20260440011', '2026-04-08 04:57:45', '2026-04-08 04:57:45'),
(74, 2, 'out', 97, 5, '1500', 92, '2026-04-08', 'Stock Out', 'OUT20260440011', '2026-04-08 04:57:45', '2026-04-08 04:57:45'),
(75, 3, 'out', 97, 5, '1100', 92, '2026-04-08', 'Stock Out', 'OUT20260440011', '2026-04-08 04:57:45', '2026-04-08 04:57:45'),
(76, 1, 'out', 92, 5, '2000', 87, '2026-04-08', 'Stock Out', 'OUT20260440012', '2026-04-08 05:08:03', '2026-04-08 05:08:03'),
(77, 2, 'out', 92, 5, '1500', 87, '2026-04-08', 'Stock Out', 'OUT20260440012', '2026-04-08 05:08:03', '2026-04-08 05:08:03'),
(78, 3, 'out', 92, 5, '1100', 87, '2026-04-08', 'Stock Out', 'OUT20260440012', '2026-04-08 05:08:03', '2026-04-08 05:08:03'),
(79, 1, 'out', 87, 5, '2000', 82, '2026-04-08', 'Stock Out', 'OUT20260440013', '2026-04-08 05:09:29', '2026-04-08 05:09:29'),
(80, 2, 'out', 87, 5, '1500', 82, '2026-04-08', 'Stock Out', 'OUT20260440013', '2026-04-08 05:09:29', '2026-04-08 05:09:29'),
(81, 3, 'out', 87, 5, '1100', 82, '2026-04-08', 'Stock Out', 'OUT20260440013', '2026-04-08 05:09:29', '2026-04-08 05:09:29'),
(82, 1, 'out', 82, 50, '20000', 32, '2026-04-08', 'Stock Out', 'OUT20260440014', '2026-04-08 05:09:51', '2026-04-08 05:09:51'),
(83, 2, 'out', 82, 50, '15000', 32, '2026-04-08', 'Stock Out', 'OUT20260440014', '2026-04-08 05:09:51', '2026-04-08 05:09:51'),
(84, 3, 'out', 82, 50, '11000', 32, '2026-04-08', 'Stock Out', 'OUT20260440014', '2026-04-08 05:09:51', '2026-04-08 05:09:51'),
(85, 1, 'out', 32, 20, '8000', 12, '2026-04-08', 'Stock Out', 'OUT20260440015', '2026-04-08 05:12:04', '2026-04-08 05:12:04'),
(86, 2, 'out', 32, 20, '6000', 12, '2026-04-08', 'Stock Out', 'OUT20260440015', '2026-04-08 05:12:04', '2026-04-08 05:12:04'),
(87, 3, 'out', 32, 20, '4400', 12, '2026-04-08', 'Stock Out', 'OUT20260440015', '2026-04-08 05:12:04', '2026-04-08 05:12:04'),
(88, 1, 'return', 12, 5, '-1500', 17, '2026-04-08', 'Stock Return', 'RET20260400002', '2026-04-08 05:25:32', '2026-04-08 05:25:32'),
(89, 2, 'return', 12, 5, '-1250', 17, '2026-04-08', 'Stock Return', 'RET20260400002', '2026-04-08 05:25:32', '2026-04-08 05:25:32'),
(90, 3, 'return', 12, 5, '-875', 17, '2026-04-08', 'Stock Return', 'RET20260400002', '2026-04-08 05:25:32', '2026-04-08 05:25:32'),
(91, 1, 'return', 17, 5, '-1500', 22, '2026-04-08', 'Stock Return', 'RET20260400003', '2026-04-08 05:31:28', '2026-04-08 05:31:28'),
(92, 2, 'return', 17, 5, '-1250', 22, '2026-04-08', 'Stock Return', 'RET20260400003', '2026-04-08 05:31:28', '2026-04-08 05:31:28'),
(93, 3, 'return', 17, 5, '-875', 22, '2026-04-08', 'Stock Return', 'RET20260400003', '2026-04-08 05:31:28', '2026-04-08 05:31:28'),
(94, 1, 'return', 22, 5, '-1500', 27, '2026-04-08', 'Stock Return', 'RET20260400004', '2026-04-08 05:31:58', '2026-04-08 05:31:58'),
(95, 2, 'return', 22, 5, '-1250', 27, '2026-04-08', 'Stock Return', 'RET20260400004', '2026-04-08 05:31:58', '2026-04-08 05:31:58'),
(96, 3, 'return', 22, 5, '-875', 27, '2026-04-08', 'Stock Return', 'RET20260400004', '2026-04-08 05:31:58', '2026-04-08 05:31:58'),
(97, 1, 'return', 27, 5, '-1500', 32, '2026-04-08', 'Stock Return', 'RET20260400005', '2026-04-08 05:36:15', '2026-04-08 05:36:15'),
(98, 2, 'return', 27, 5, '-1250', 32, '2026-04-08', 'Stock Return', 'RET20260400005', '2026-04-08 05:36:15', '2026-04-08 05:36:15'),
(99, 3, 'return', 27, 5, '-875', 32, '2026-04-08', 'Stock Return', 'RET20260400005', '2026-04-08 05:36:15', '2026-04-08 05:36:15'),
(100, 1, 'return', 32, 5, '-1500', 37, '2026-04-08', 'Stock Return', 'RET20260400006', '2026-04-08 05:36:58', '2026-04-08 05:36:58'),
(101, 2, 'return', 32, 5, '-1250', 37, '2026-04-08', 'Stock Return', 'RET20260400006', '2026-04-08 05:36:58', '2026-04-08 05:36:58'),
(102, 3, 'return', 32, 5, '-875', 37, '2026-04-08', 'Stock Return', 'RET20260400006', '2026-04-08 05:36:58', '2026-04-08 05:36:58'),
(103, 1, 'return', 37, 5, '-1500', 42, '2026-04-08', 'Stock Return', 'RET20260400007', '2026-04-08 05:37:08', '2026-04-08 05:37:08'),
(104, 2, 'return', 37, 5, '-1250', 42, '2026-04-08', 'Stock Return', 'RET20260400007', '2026-04-08 05:37:08', '2026-04-08 05:37:08'),
(105, 1, 'return', 42, 5, '-1500', 47, '2026-04-08', 'Stock Return', 'RET20260400008', '2026-04-08 05:40:15', '2026-04-08 05:40:15'),
(106, 2, 'return', 42, 5, '-1250', 47, '2026-04-08', 'Stock Return', 'RET20260400008', '2026-04-08 05:40:15', '2026-04-08 05:40:15'),
(107, 3, 'return', 37, 5, '-875', 42, '2026-04-08', 'Stock Return', 'RET20260400008', '2026-04-08 05:40:15', '2026-04-08 05:40:15'),
(108, 1, 'return', 47, 5, '-1500', 52, '2026-04-08', 'Stock Return', 'RET20260400009', '2026-04-08 05:42:24', '2026-04-08 05:42:24'),
(109, 2, 'return', 47, 5, '-1250', 52, '2026-04-08', 'Stock Return', 'RET20260400009', '2026-04-08 05:42:24', '2026-04-08 05:42:24'),
(110, 3, 'return', 42, 5, '-875', 47, '2026-04-08', 'Stock Return', 'RET20260400009', '2026-04-08 05:42:24', '2026-04-08 05:42:24'),
(111, 1, 'return', 52, 5, '-1500', 57, '2026-04-08', 'Stock Return', 'RET20260400010', '2026-04-08 05:42:51', '2026-04-08 05:42:51'),
(112, 2, 'return', 52, 5, '-1250', 57, '2026-04-08', 'Stock Return', 'RET20260400010', '2026-04-08 05:42:51', '2026-04-08 05:42:51'),
(113, 3, 'return', 47, 5, '-875', 52, '2026-04-08', 'Stock Return', 'RET20260400010', '2026-04-08 05:42:51', '2026-04-08 05:42:51'),
(114, 1, 'return', 57, 5, '-1500', 62, '2026-04-08', 'Stock Return', 'RET20260400011', '2026-04-08 05:44:12', '2026-04-08 05:44:12'),
(115, 2, 'return', 57, 5, '-1250', 62, '2026-04-08', 'Stock Return', 'RET20260400011', '2026-04-08 05:44:12', '2026-04-08 05:44:12'),
(116, 1, 'return', 62, 5, '-1500', 67, '2026-04-08', 'Stock Return', 'RET20260400012', '2026-04-08 05:45:32', '2026-04-08 05:45:32'),
(117, 1, 'return', 67, 5, '-1500', 72, '2026-04-08', 'Stock Return', 'RET20260400013', '2026-04-08 05:46:56', '2026-04-08 05:46:56'),
(118, 2, 'return', 62, 5, '-1250', 67, '2026-04-08', 'Stock Return', 'RET20260400013', '2026-04-08 05:46:56', '2026-04-08 05:46:56'),
(119, 3, 'return', 52, 5, '-875', 57, '2026-04-08', 'Stock Return', 'RET20260400013', '2026-04-08 05:46:56', '2026-04-08 05:46:56'),
(120, 1, 'return', 72, 5, '-1500', 77, '2026-04-08', 'Stock Return', 'RET20260400014', '2026-04-08 05:47:58', '2026-04-08 05:47:58'),
(121, 1, 'return', 77, 5, '-1500', 82, '2026-04-08', 'Stock Return', 'RET20260400015', '2026-04-08 05:48:40', '2026-04-08 05:48:40'),
(122, 1, 'return', 82, 5, '-1500', 87, '2026-04-08', 'Stock Return', 'RET20260400016', '2026-04-08 05:48:49', '2026-04-08 05:48:49'),
(123, 1, 'return', 87, 5, '-1500', 92, '2026-04-08', 'Stock Return', 'RET20260400017', '2026-04-08 05:49:16', '2026-04-08 05:49:16'),
(124, 3, 'return', 57, 10, '-1750', 67, '2026-04-08', 'Stock Return', 'RET20260400018', '2026-04-08 05:51:59', '2026-04-08 05:51:59'),
(125, 2, 'return', 67, 10, '-2500', 77, '2026-04-08', 'Stock Return', 'RET20260400019', '2026-04-08 05:55:14', '2026-04-08 05:55:14'),
(126, 2, 'return', 77, 10, '-2500', 87, '2026-04-08', 'Stock Return', 'RET20260400020', '2026-04-08 05:58:04', '2026-04-08 05:58:04'),
(127, 2, 'return', 87, 10, '-2500', 97, '2026-04-08', 'Stock Return', 'RET20260400021', '2026-04-08 05:58:41', '2026-04-08 05:58:41'),
(128, 1, 'return', 92, 5, '-1500', 97, '2026-04-08', 'Stock Return', 'RET20260400022', '2026-04-08 06:03:14', '2026-04-08 06:03:14'),
(129, 2, 'return', 97, 5, '-1250', 102, '2026-04-08', 'Stock Return', 'RET20260400022', '2026-04-08 06:03:14', '2026-04-08 06:03:14'),
(130, 1, 'return', 97, 5, '-1500', 102, '2026-04-08', 'Stock Return', 'RET20260400023', '2026-04-08 06:03:49', '2026-04-08 06:03:49'),
(131, 2, 'return', 102, 5, '-1250', 107, '2026-04-08', 'Stock Return', 'RET20260400023', '2026-04-08 06:03:49', '2026-04-08 06:03:49'),
(132, 1, 'return', 102, 5, '-1500', 107, '2026-04-08', 'Stock Return', 'RET20260400024', '2026-04-08 06:04:24', '2026-04-08 06:04:24'),
(133, 3, 'return', 67, 5, '-875', 72, '2026-04-08', 'Stock Return', 'RET20260400024', '2026-04-08 06:04:24', '2026-04-08 06:04:24'),
(134, 1, 'return', 107, 5, '-1500', 112, '2026-04-08', 'Stock Return', 'RET20260400025', '2026-04-08 06:14:27', '2026-04-08 06:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `sub_districts`
--

CREATE TABLE `sub_districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_districts`
--

INSERT INTO `sub_districts` (`id`, `district_id`, `name`) VALUES
(1, NULL, 'Amtali'),
(2, NULL, 'Bamna'),
(3, NULL, 'Barguna Sadar'),
(4, NULL, 'Betagi'),
(5, NULL, 'Patharghata'),
(6, NULL, 'Taltali'),
(7, NULL, 'Muladi'),
(8, NULL, 'Babuganj'),
(9, NULL, 'Agailjhara'),
(10, NULL, 'Barisal Sadar'),
(11, NULL, 'Bakerganj'),
(12, NULL, 'Banaripara'),
(13, NULL, 'Gaurnadi'),
(14, NULL, 'Hizla'),
(15, NULL, 'Mehendiganj'),
(16, NULL, 'Wazirpur'),
(17, NULL, 'Bhola Sadar'),
(18, NULL, 'Burhanuddin'),
(19, NULL, 'Char Fasson'),
(20, NULL, 'Daulatkhan'),
(21, NULL, 'Lalmohan'),
(22, NULL, 'Manpura'),
(23, NULL, 'Tazumuddin'),
(24, NULL, 'Jhalokati Sadar'),
(25, NULL, 'Kathalia'),
(26, NULL, 'Nalchity'),
(27, NULL, 'Rajapur'),
(28, NULL, 'Bauphal'),
(29, NULL, 'Dashmina'),
(30, NULL, 'Galachipa'),
(31, NULL, 'Kalapara'),
(32, NULL, 'Mirzaganj'),
(33, NULL, 'Patuakhali Sadar'),
(34, NULL, 'Dumki'),
(35, NULL, 'Rangabali'),
(36, NULL, 'Bhandaria'),
(37, NULL, 'Kaukhali'),
(38, NULL, 'Mathbaria'),
(39, NULL, 'Nazirpur'),
(40, NULL, 'Nesarabad'),
(41, NULL, 'Pirojpur Sadar'),
(42, NULL, 'Zianagar'),
(43, NULL, 'Bandarban Sadar'),
(44, NULL, 'Thanchi'),
(45, NULL, 'Lama'),
(46, NULL, 'Naikhongchhari'),
(47, NULL, 'Ali kadam'),
(48, NULL, 'Rowangchhari'),
(49, NULL, 'Ruma'),
(50, NULL, 'Brahmanbaria Sadar'),
(51, NULL, 'Ashuganj'),
(52, NULL, 'Nasirnagar'),
(53, NULL, 'Nabinagar'),
(54, NULL, 'Sarail'),
(55, NULL, 'Shahbazpur Town'),
(56, NULL, 'Kasba'),
(57, NULL, 'Akhaura'),
(58, NULL, 'Bancharampur'),
(59, NULL, 'Bijoynagar'),
(60, NULL, 'Chandpur Sadar'),
(61, NULL, 'Faridganj'),
(62, NULL, 'Haimchar'),
(63, NULL, 'Haziganj'),
(64, NULL, 'Kachua'),
(65, NULL, 'Matlab Uttar'),
(66, NULL, 'Matlab Dakkhin'),
(67, NULL, 'Shahrasti'),
(68, NULL, 'Anwara'),
(69, NULL, 'Banshkhali'),
(70, NULL, 'Boalkhali'),
(71, NULL, 'Chandanaish'),
(72, NULL, 'Fatikchhari'),
(73, NULL, 'Hathazari'),
(74, NULL, 'Lohagara'),
(75, NULL, 'Mirsharai'),
(76, NULL, 'Patiya'),
(77, NULL, 'Rangunia'),
(78, NULL, 'Raozan'),
(79, NULL, 'Sandwip'),
(80, NULL, 'Satkania'),
(81, NULL, 'Sitakunda'),
(82, NULL, 'Barura'),
(83, NULL, 'Brahmanpara'),
(84, NULL, 'Burichong'),
(85, NULL, 'Chandina'),
(86, NULL, 'Chauddagram'),
(87, NULL, 'Daudkandi'),
(88, NULL, 'Debidwar'),
(89, NULL, 'Homna'),
(90, NULL, 'Comilla Sadar'),
(91, NULL, 'Laksam'),
(92, NULL, 'Monohorgonj'),
(93, NULL, 'Meghna'),
(94, NULL, 'Muradnagar'),
(95, NULL, 'Nangalkot'),
(96, NULL, 'Comilla Sadar South'),
(97, NULL, 'Titas'),
(98, NULL, 'Chakaria'),
(100, NULL, 'Chakaria'),
(101, NULL, 'Kutubdia'),
(102, NULL, 'Maheshkhali'),
(103, NULL, 'Ramu'),
(104, NULL, 'Teknaf'),
(105, NULL, 'Ukhia'),
(106, NULL, 'Pekua'),
(107, NULL, 'Feni Sadar'),
(108, NULL, 'Chagalnaiya'),
(109, NULL, 'Daganbhyan'),
(110, NULL, 'Parshuram'),
(111, NULL, 'Fhulgazi'),
(112, NULL, 'Sonagazi'),
(113, NULL, 'Dighinala'),
(114, NULL, 'Khagrachhari'),
(115, NULL, 'Lakshmichhari'),
(116, NULL, 'Mahalchhari'),
(117, NULL, 'Manikchhari'),
(118, NULL, 'Matiranga'),
(119, NULL, 'Panchhari'),
(120, NULL, 'Ramgarh'),
(121, NULL, 'Lakshmipur Sadar'),
(122, NULL, 'Raipur'),
(123, NULL, 'Ramganj'),
(124, NULL, 'Ramgati'),
(125, NULL, 'Komol Nagar'),
(126, NULL, 'Noakhali Sadar'),
(127, NULL, 'Begumganj'),
(128, NULL, 'Chatkhil'),
(129, NULL, 'Companyganj'),
(130, NULL, 'Shenbag'),
(131, NULL, 'Hatia'),
(132, NULL, 'Kobirhat'),
(133, NULL, 'Sonaimuri'),
(134, NULL, 'Suborno Char'),
(135, NULL, 'Rangamati Sadar'),
(136, NULL, 'Belaichhari'),
(137, NULL, 'Bagaichhari'),
(138, NULL, 'Barkal'),
(139, NULL, 'Juraichhari'),
(140, NULL, 'Rajasthali'),
(141, NULL, 'Kaptai'),
(142, NULL, 'Langadu'),
(143, NULL, 'Nannerchar'),
(144, NULL, 'Kaukhali'),
(145, NULL, 'Dhamrai'),
(146, NULL, 'Dohar'),
(147, NULL, 'Keraniganj'),
(148, NULL, 'Nawabganj'),
(149, NULL, 'Savar'),
(150, NULL, 'Faridpur Sadar'),
(151, NULL, 'Boalmari'),
(152, NULL, 'Alfadanga'),
(153, NULL, 'Madhukhali'),
(154, NULL, 'Bhanga'),
(155, NULL, 'Nagarkanda'),
(156, NULL, 'Charbhadrasan'),
(157, NULL, 'Sadarpur'),
(158, NULL, 'Shaltha'),
(159, NULL, 'Gazipur Sadar-Joydebpur'),
(160, NULL, 'Kaliakior'),
(161, NULL, 'Kapasia'),
(162, NULL, 'Sripur'),
(163, NULL, 'Kaliganj'),
(164, NULL, 'Tongi'),
(165, NULL, 'Gopalganj Sadar'),
(166, NULL, 'Kashiani'),
(167, NULL, 'Kotalipara'),
(168, NULL, 'Muksudpur'),
(169, NULL, 'Tungipara'),
(170, NULL, 'Dewanganj'),
(171, NULL, 'Baksiganj'),
(172, NULL, 'Islampur'),
(173, NULL, 'Jamalpur Sadar'),
(174, NULL, 'Madarganj'),
(175, NULL, 'Melandaha'),
(176, NULL, 'Sarishabari'),
(177, NULL, 'Narundi Police I.C'),
(178, NULL, 'Astagram'),
(179, NULL, 'Bajitpur'),
(180, NULL, 'Bhairab'),
(181, NULL, 'Hossainpur'),
(182, NULL, 'Itna'),
(183, NULL, 'Karimganj'),
(184, NULL, 'Katiadi'),
(185, NULL, 'Kishoreganj Sadar'),
(186, NULL, 'Kuliarchar'),
(187, NULL, 'Mithamain'),
(188, NULL, 'Nikli'),
(189, NULL, 'Pakundia'),
(190, NULL, 'Tarail'),
(191, NULL, 'Madaripur Sadar'),
(192, NULL, 'Kalkini'),
(193, NULL, 'Rajoir'),
(194, NULL, 'Shibchar'),
(195, NULL, 'Manikganj Sadar'),
(196, NULL, 'Singair'),
(197, NULL, 'Shibalaya'),
(198, NULL, 'Saturia'),
(199, NULL, 'Harirampur'),
(200, NULL, 'Ghior'),
(201, NULL, 'Daulatpur'),
(202, NULL, 'Lohajang'),
(203, NULL, 'Sreenagar'),
(204, NULL, 'Munshiganj Sadar'),
(205, NULL, 'Sirajdikhan'),
(206, NULL, 'Tongibari'),
(207, NULL, 'Gazaria'),
(208, NULL, 'Bhaluka'),
(209, NULL, 'Trishal'),
(210, NULL, 'Haluaghat'),
(211, NULL, 'Muktagachha'),
(212, NULL, 'Dhobaura'),
(213, NULL, 'Fulbaria'),
(214, NULL, 'Gaffargaon'),
(215, NULL, 'Gauripur'),
(216, NULL, 'Ishwarganj'),
(217, NULL, 'Mymensingh Sadar'),
(218, NULL, 'Nandail'),
(219, NULL, 'Phulpur'),
(220, NULL, 'Araihazar'),
(221, NULL, 'Sonargaon'),
(222, NULL, 'Bandar'),
(223, NULL, 'Naryanganj Sadar'),
(224, NULL, 'Rupganj'),
(225, NULL, 'Siddirgonj'),
(226, NULL, 'Belabo'),
(227, NULL, 'Monohardi'),
(228, NULL, 'Narsingdi Sadar'),
(229, NULL, 'Palash'),
(230, NULL, 'Raipura, Narsingdi'),
(231, NULL, 'Shibpur'),
(232, NULL, 'Kendua Upazilla'),
(233, NULL, 'Atpara Upazilla'),
(234, NULL, 'Barhatta Upazilla'),
(235, NULL, 'Durgapur Upazilla'),
(236, NULL, 'Kalmakanda Upazilla'),
(237, NULL, 'Madan Upazilla'),
(238, NULL, 'Mohanganj Upazilla'),
(239, NULL, 'Netrakona-S Upazilla'),
(240, NULL, 'Purbadhala Upazilla'),
(241, NULL, 'Khaliajuri Upazilla'),
(242, NULL, 'Baliakandi'),
(243, NULL, 'Goalandaghat'),
(244, NULL, 'Pangsha'),
(245, NULL, 'Kalukhali'),
(246, NULL, 'Rajbari Sadar'),
(247, NULL, 'Shariatpur Sadar -Palong'),
(248, NULL, 'Damudya'),
(249, NULL, 'Naria'),
(250, NULL, 'Jajira'),
(251, NULL, 'Bhedarganj'),
(252, NULL, 'Gosairhat'),
(253, NULL, 'Jhenaigati'),
(254, NULL, 'Nakla'),
(255, NULL, 'Nalitabari'),
(256, NULL, 'Sherpur Sadar'),
(257, NULL, 'Sreebardi'),
(258, NULL, 'Tangail Sadar'),
(259, NULL, 'Sakhipur'),
(260, NULL, 'Basail'),
(261, NULL, 'Madhupur'),
(262, NULL, 'Ghatail'),
(263, NULL, 'Kalihati'),
(264, NULL, 'Nagarpur'),
(265, NULL, 'Mirzapur'),
(266, NULL, 'Gopalpur'),
(267, NULL, 'Delduar'),
(268, NULL, 'Bhuapur'),
(269, NULL, 'Dhanbari'),
(270, NULL, 'Bagerhat Sadar'),
(271, NULL, 'Chitalmari'),
(272, NULL, 'Fakirhat'),
(273, NULL, 'Kachua'),
(274, NULL, 'Mollahat'),
(275, NULL, 'Mongla'),
(276, NULL, 'Morrelganj'),
(277, NULL, 'Rampal'),
(278, NULL, 'Sarankhola'),
(279, NULL, 'Damurhuda'),
(280, NULL, 'Chuadanga-S'),
(281, NULL, 'Jibannagar'),
(282, NULL, 'Alamdanga'),
(283, NULL, 'Abhaynagar'),
(284, NULL, 'Keshabpur'),
(285, NULL, 'Bagherpara'),
(286, NULL, 'Jessore Sadar'),
(287, NULL, 'Chaugachha'),
(288, NULL, 'Manirampur'),
(289, NULL, 'Jhikargachha'),
(290, NULL, 'Sharsha'),
(291, NULL, 'Jhenaidah Sadar'),
(292, NULL, 'Maheshpur'),
(293, NULL, 'Kaliganj'),
(294, NULL, 'Kotchandpur'),
(295, NULL, 'Shailkupa'),
(296, NULL, 'Harinakunda'),
(297, NULL, 'Terokhada'),
(298, NULL, 'Batiaghata'),
(299, NULL, 'Dacope'),
(300, NULL, 'Dumuria'),
(301, NULL, 'Dighalia'),
(302, NULL, 'Koyra'),
(303, NULL, 'Paikgachha'),
(304, NULL, 'Phultala'),
(305, NULL, 'Rupsa'),
(306, NULL, 'Kushtia Sadar'),
(307, NULL, 'Kumarkhali'),
(308, NULL, 'Daulatpur'),
(309, NULL, 'Mirpur'),
(310, NULL, 'Bheramara'),
(311, NULL, 'Khoksa'),
(312, NULL, 'Magura Sadar'),
(313, NULL, 'Mohammadpur'),
(314, NULL, 'Shalikha'),
(315, NULL, 'Sreepur'),
(316, NULL, 'angni'),
(317, NULL, 'Mujib Nagar'),
(318, NULL, 'Meherpur-S'),
(319, NULL, 'Narail-S Upazilla'),
(320, NULL, 'Lohagara Upazilla'),
(321, NULL, 'Kalia Upazilla'),
(322, NULL, 'Satkhira Sadar'),
(323, NULL, 'Assasuni'),
(324, NULL, 'Debhata'),
(325, NULL, 'Tala'),
(326, NULL, 'Kalaroa'),
(327, NULL, 'Kaliganj'),
(328, NULL, 'Shyamnagar'),
(329, NULL, 'Adamdighi'),
(330, NULL, 'Bogra Sadar'),
(331, NULL, 'Sherpur'),
(332, NULL, 'Dhunat'),
(333, NULL, 'Dhupchanchia'),
(334, NULL, 'Gabtali'),
(335, NULL, 'Kahaloo'),
(336, NULL, 'Nandigram'),
(337, NULL, 'Sahajanpur'),
(338, NULL, 'Sariakandi'),
(339, NULL, 'Shibganj'),
(340, NULL, 'Sonatala'),
(341, NULL, 'Joypurhat S'),
(342, NULL, 'Akkelpur'),
(343, NULL, 'Kalai'),
(344, NULL, 'Khetlal'),
(345, NULL, 'Panchbibi'),
(346, NULL, 'Naogaon Sadar'),
(347, NULL, 'Mohadevpur'),
(348, NULL, 'Manda'),
(349, NULL, 'Niamatpur'),
(350, NULL, 'Atrai'),
(351, NULL, 'Raninagar'),
(352, NULL, 'Patnitala'),
(353, NULL, 'Dhamoirhat'),
(354, NULL, 'Sapahar'),
(355, NULL, 'Porsha'),
(356, NULL, 'Badalgachhi'),
(357, NULL, 'Natore Sadar'),
(358, NULL, 'Baraigram'),
(359, NULL, 'Bagatipara'),
(360, NULL, 'Lalpur'),
(361, NULL, 'Natore Sadar'),
(362, NULL, 'Baraigram'),
(363, NULL, 'Bholahat'),
(364, NULL, 'Gomastapur'),
(365, NULL, 'Nachole'),
(366, NULL, 'Nawabganj Sadar'),
(367, NULL, 'Shibganj'),
(368, NULL, 'Atgharia'),
(369, NULL, 'Bera'),
(370, NULL, 'Bhangura'),
(371, NULL, 'Chatmohar'),
(372, NULL, 'Faridpur'),
(373, NULL, 'Ishwardi'),
(374, NULL, 'Pabna Sadar'),
(375, NULL, 'Santhia'),
(376, NULL, 'Sujanagar'),
(377, NULL, 'Bagha'),
(378, NULL, 'Bagmara'),
(379, NULL, 'Charghat'),
(380, NULL, 'Durgapur'),
(381, NULL, 'Godagari'),
(382, NULL, 'Mohanpur'),
(383, NULL, 'Paba'),
(384, NULL, 'Puthia'),
(385, NULL, 'Tanore'),
(386, NULL, 'Sirajganj Sadar'),
(387, NULL, 'Belkuchi'),
(388, NULL, 'Chauhali'),
(389, NULL, 'Kamarkhanda'),
(390, NULL, 'Kazipur'),
(391, NULL, 'Raiganj'),
(392, NULL, 'Shahjadpur'),
(393, NULL, 'Tarash'),
(394, NULL, 'Ullahpara'),
(395, NULL, 'Birampur'),
(396, NULL, 'Birganj'),
(397, NULL, 'Biral'),
(398, NULL, 'Bochaganj'),
(399, NULL, 'Chirirbandar'),
(400, NULL, 'Phulbari'),
(401, NULL, 'Ghoraghat'),
(402, NULL, 'Hakimpur'),
(403, NULL, 'Kaharole'),
(404, NULL, 'Khansama'),
(405, NULL, 'Dinajpur Sadar'),
(406, NULL, 'Nawabganj'),
(407, NULL, 'Parbatipur'),
(408, NULL, 'Fulchhari'),
(409, NULL, 'Gaibandha sadar'),
(410, NULL, 'Gobindaganj'),
(411, NULL, 'Palashbari'),
(412, NULL, 'Sadullapur'),
(413, NULL, 'Saghata'),
(414, NULL, 'Sundarganj'),
(415, NULL, 'Kurigram Sadar'),
(416, NULL, 'Nageshwari'),
(417, NULL, 'Bhurungamari'),
(418, NULL, 'Phulbari'),
(419, NULL, 'Rajarhat'),
(420, NULL, 'Ulipur'),
(421, NULL, 'Chilmari'),
(422, NULL, 'Rowmari'),
(423, NULL, 'Char Rajibpur'),
(424, NULL, 'Lalmanirhat Sadar'),
(425, NULL, 'Aditmari'),
(426, NULL, 'Kaliganj'),
(427, NULL, 'Hatibandha'),
(428, NULL, 'Patgram'),
(429, NULL, 'Nilphamari Sadar'),
(430, NULL, 'Saidpur'),
(431, NULL, 'Jaldhaka'),
(432, NULL, 'Kishoreganj'),
(433, NULL, 'Domar'),
(434, NULL, 'Dimla'),
(435, NULL, 'Panchagarh Sadar'),
(436, NULL, 'Debiganj'),
(437, NULL, 'Boda'),
(438, NULL, 'Atwari'),
(439, NULL, 'Tetulia'),
(440, NULL, 'Badarganj'),
(441, NULL, 'Mithapukur'),
(442, NULL, 'Gangachara'),
(443, NULL, 'Kaunia'),
(444, NULL, 'Rangpur Sadar'),
(445, NULL, 'Pirgachha'),
(446, NULL, 'Pirganj'),
(447, NULL, 'Taraganj'),
(448, NULL, 'Thakurgaon Sadar'),
(449, NULL, 'Pirganj'),
(450, NULL, 'Baliadangi'),
(451, NULL, 'Haripur'),
(452, NULL, 'Ranisankail'),
(453, NULL, 'Ajmiriganj'),
(454, NULL, 'Baniachang'),
(455, NULL, 'Bahubal'),
(456, NULL, 'Chunarughat'),
(457, NULL, 'Habiganj Sadar'),
(458, NULL, 'Lakhai'),
(459, NULL, 'Madhabpur'),
(460, NULL, 'Nabiganj'),
(461, NULL, 'Shaistagonj'),
(462, NULL, 'Moulvibazar Sadar'),
(463, NULL, 'Barlekha'),
(464, NULL, 'Juri'),
(465, NULL, 'Kamalganj'),
(466, NULL, 'Kulaura'),
(467, NULL, 'Rajnagar'),
(468, NULL, 'Sreemangal'),
(469, NULL, 'Bishwamvarpur'),
(470, NULL, 'Chhatak'),
(471, NULL, 'Derai'),
(472, NULL, 'Dharampasha'),
(473, NULL, 'Dowarabazar'),
(474, NULL, 'Jagannathpur'),
(475, NULL, 'Jamalganj'),
(476, NULL, 'Sulla'),
(477, NULL, 'Sunamganj Sadar'),
(478, NULL, 'Shanthiganj'),
(479, NULL, 'Tahirpur'),
(480, NULL, 'Sylhet Sadar'),
(481, NULL, 'Beanibazar'),
(482, NULL, 'Bishwanath'),
(483, NULL, 'Dakshin Surma'),
(484, NULL, 'Balaganj'),
(485, NULL, 'Companiganj'),
(486, NULL, 'Fenchuganj'),
(487, NULL, 'Golapganj'),
(488, NULL, 'Gowainghat'),
(489, NULL, 'Jointapur'),
(490, NULL, 'Kanaighat'),
(491, NULL, 'Zakiganj'),
(492, NULL, 'Nobigonj'),
(493, NULL, 'Eidgaon'),
(494, NULL, 'Modhyanagar'),
(495, NULL, 'Dasar');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `copyright_text` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `title`, `email`, `system_name`, `copyright_text`, `logo`, `favicon`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Funobd', 'freelanceiT@gmail.com', '+৮৮ ০২ ৯৯৮৮২৩১৩২', 'Freelance iT', 'uploads/logos/17755627211566537256.jpg', 'uploads/favicons/17755627211983032368.jpg', NULL, '2025-12-10 12:23:02', '2026-04-07 11:52:01', NULL);

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
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '2025-12-10 12:23:01', '$2y$12$umG.oZhqjhNc57p1H0WnhufFkcBKEUHo0FQh.PXLpLf6RwHr.zHqi', 'admin', NULL, 'OOfvkYdQK5tx7f32NAQEgcYbJ3viVXfcbuAWpudb826nAnUIVMmc51Q5Xq2J', '2025-12-10 12:23:02', '2026-01-13 15:53:53'),
(8, 'Developer', 'admin@developer.com', NULL, '$2y$12$samYBT88f6vmEbSZgwZZUeAct2uvef4vQAjAyr92QzHrip4V1Bl62', 'admin', NULL, NULL, NULL, '2026-03-03 12:10:39'),
(10, 'Al Hasan Toufik', 'alhasantoufik@gmail.com', NULL, '$2y$12$MCbVFyxF6c4Dqx2lb3mrAOGoB0gYZfH8HqxUB5rw.Wqg8v6xund3i', 'admin', NULL, NULL, '2026-03-29 11:59:33', '2026-03-29 11:59:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `costs`
--
ALTER TABLE `costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `costs_cost_category_id_foreign` (`cost_category_id`),
  ADD KEY `costs_cost_field_id_foreign` (`cost_field_id`);

--
-- Indexes for table `cost_categories`
--
ALTER TABLE `cost_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cost_fields`
--
ALTER TABLE `cost_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cost_fields_cost_category_id_foreign` (`cost_category_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_pages`
--
ALTER TABLE `dynamic_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_otps`
--
ALTER TABLE `email_otps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_otps_user_id_unique` (`user_id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `privileges_user_id_foreign` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sms_limits`
--
ALTER TABLE `sms_limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_product_id_stock_type_index` (`product_id`,`stock_type`),
  ADD KEY `stocks_stock_type_index` (`stock_type`);

--
-- Indexes for table `stock_in_invoices`
--
ALTER TABLE `stock_in_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_in_invoices_voucher_no_unique` (`voucher_no`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transactions_product_id_foreign` (`product_id`);

--
-- Indexes for table `sub_districts`
--
ALTER TABLE `sub_districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_districts_district_id_foreign` (`district_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `costs`
--
ALTER TABLE `costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cost_categories`
--
ALTER TABLE `cost_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cost_fields`
--
ALTER TABLE `cost_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `dynamic_pages`
--
ALTER TABLE `dynamic_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_otps`
--
ALTER TABLE `email_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_limits`
--
ALTER TABLE `sms_limits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_in_invoices`
--
ALTER TABLE `stock_in_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `sub_districts`
--
ALTER TABLE `sub_districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=496;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `costs`
--
ALTER TABLE `costs`
  ADD CONSTRAINT `costs_cost_category_id_foreign` FOREIGN KEY (`cost_category_id`) REFERENCES `cost_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `costs_cost_field_id_foreign` FOREIGN KEY (`cost_field_id`) REFERENCES `cost_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cost_fields`
--
ALTER TABLE `cost_fields`
  ADD CONSTRAINT `cost_fields_cost_category_id_foreign` FOREIGN KEY (`cost_category_id`) REFERENCES `cost_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `email_otps`
--
ALTER TABLE `email_otps`
  ADD CONSTRAINT `email_otps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `privileges`
--
ALTER TABLE `privileges`
  ADD CONSTRAINT `privileges_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_districts`
--
ALTER TABLE `sub_districts`
  ADD CONSTRAINT `sub_districts_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
