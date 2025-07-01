-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 03:52 PM
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
-- Database: `home_rent`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `placement` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `expiry` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `slug` text NOT NULL,
  `body` longtext NOT NULL,
  `stat` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `of` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `of`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Kaung Home', 'kaung-home', 'property', '2025-06-30 04:25:53', '2025-06-30 04:25:53'),
(2, 1, 'Kaung', 'kaung', 'property', '2025-06-30 04:25:53', '2025-06-30 04:25:53'),
(3, 1, '', '', 'property', '2025-06-30 04:25:53', '2025-06-30 04:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `categorizables`
--

CREATE TABLE `categorizables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `categorizable_id` int(11) NOT NULL,
  `categorizable_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorizables`
--

INSERT INTO `categorizables` (`id`, `category_id`, `categorizable_id`, `categorizable_type`) VALUES
(1, 2, 1, 'property'),
(2, 3, 1, 'property');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `agent` bigint(20) UNSIGNED DEFAULT NULL,
  `contacted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `order` varchar(255) DEFAULT NULL,
  `imageable_id` int(11) NOT NULL,
  `imageable_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `user_id`, `path`, `caption`, `order`, `imageable_id`, `imageable_type`, `created_at`, `updated_at`) VALUES
(1, 1, 'things-you-must-know-before-renting-a-property-in-burma_6862058aaf094.webp', NULL, NULL, 4, 'slider', '2025-06-30 03:33:31', '2025-06-30 03:33:31'),
(2, 1, 'pexels-lisa-fotios-1090638_627e8c738faa0_68620a0caf8c4.webp', NULL, NULL, 5, 'slider', '2025-06-30 03:52:45', '2025-06-30 03:52:45'),
(3, 1, 'pexels-lisa-fotios-1090638_627e8c738faa0_68620b051955d.webp', NULL, NULL, 6, 'slider', '2025-06-30 03:56:54', '2025-06-30 03:56:54'),
(4, 1, 'pexels-lisa-fotios-1090638_627e8c738faa0_68620ba49e4d5.webp', NULL, NULL, 7, 'slider', '2025-06-30 03:59:33', '2025-06-30 03:59:33'),
(5, 1, 'images (4)_686211d18d5a0.webp', NULL, NULL, 1, 'category', '2025-06-30 04:25:53', '2025-06-30 04:25:53'),
(6, 1, '3-bed-House-for-rent-in-Bahan-Yangon-600x375_686217076ac27.webp', NULL, NULL, 1, 'location', '2025-06-30 04:48:07', '2025-06-30 04:48:07'),
(7, 1, '1550129517DJI_0011_6862177dc6f6f.webp', NULL, '0', 1, 'property', '2025-06-30 04:50:06', '2025-06-30 04:50:06'),
(8, 1, '1550129483DJI_0005_6862177e4feeb.webp', NULL, '1', 1, 'property', '2025-06-30 04:50:06', '2025-06-30 04:50:06'),
(9, 1, 'images (4)_6862177e93ba6.webp', NULL, '2', 1, 'property', '2025-06-30 04:50:06', '2025-06-30 04:50:06');

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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `postal_code` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `parent_id`, `name`, `slug`, `description`, `postal_code`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Yangon', 'yangon', '<p>Yangon</p>', 1181, '2025-06-30 04:48:07', '2025-06-30 04:48:07'),
(2, 1, 'insein', 'insein', NULL, NULL, '2025-06-30 04:48:07', '2025-06-30 04:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `location_property`
--

CREATE TABLE `location_property` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location_property`
--

INSERT INTO `location_property` (`id`, `location_id`, `property_id`) VALUES
(1, 1, 1),
(2, 2, 1);

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
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2020_12_10_113325_create_sessions_table', 1),
(4, '2020_12_10_115494_create_packages_table', 1),
(5, '2020_12_10_115495_create_property_purposes_table', 1),
(6, '2020_12_10_115496_create_categories_table', 1),
(7, '2020_12_10_115497_create_locations_table', 1),
(8, '2020_12_10_115498_create_users_table', 1),
(9, '2020_12_10_115499_create_password_resets_table', 1),
(10, '2020_12_10_115500_add_two_factor_columns_to_users_table', 1),
(11, '2020_12_10_115501_create_sliders_table', 1),
(12, '2020_12_10_121101_create_properties_table', 1),
(13, '2020_12_10_122420_create_blogs_table', 1),
(14, '2020_12_10_124351_create_enquiries_table', 1),
(15, '2020_12_12_101718_create_categorizables_table', 1),
(16, '2020_12_12_103213_create_images_table', 1),
(17, '2020_12_21_213412_create_location_property_table', 1),
(18, '2020_12_21_213413_create_property_translations_table', 1),
(19, '2021_06_30_234932_create_ads_table', 1),
(20, '2021_07_06_184938_create_savables_table', 1),
(21, '2021_10_14_234531_change_price_int_to_float_in_properties_table', 1),
(22, '2022_03_10_220921_create_search_indexes', 1),
(23, '2022_03_15_115554_create_jobs_table', 1),
(24, '2022_05_06_132127_add_order_to_images_table', 1),
(25, '2022_05_12_172440_add_status_column_to_users_table', 1),
(26, '2022_08_28_203509_add_social_ids_to_users_table', 1),
(27, '2022_09_26_182430_add_stat_to_blogs_table', 1),
(28, '2024_04_28_112129_add_expires_at_column_to_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `credit` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `property_purpose_id` bigint(20) UNSIGNED NOT NULL,
  `parking` int(11) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `beds` int(11) DEFAULT NULL,
  `baths` int(11) DEFAULT NULL,
  `featured` datetime DEFAULT NULL,
  `featured_expiry` datetime DEFAULT NULL,
  `installment` text DEFAULT NULL,
  `stat` int(11) DEFAULT NULL,
  `soldout` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `user_id`, `slug`, `price`, `type_id`, `property_purpose_id`, `parking`, `area`, `beds`, `baths`, `featured`, `featured_expiry`, `installment`, `stat`, `soldout`, `created_at`, `updated_at`) VALUES
(1, 1, 'south-dagon-industri', 200000, 1, 1, 343243, 'a:1:{s:11:\"square_feet\";s:2:\"30\";}', 3, 4, '2025-06-30 11:23:08', '2025-07-30 11:23:08', NULL, 190, NULL, '2025-06-30 04:50:05', '2025-06-30 13:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `property_purposes`
--

CREATE TABLE `property_purposes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_purposes`
--

INSERT INTO `property_purposes` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Test1', 'test1', '2025-06-30 03:29:19', '2025-06-30 03:29:19'),
(2, 'Test2', 'test2', '2025-06-30 03:29:19', '2025-06-30 03:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `property_translations`
--

CREATE TABLE `property_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `detail` longtext NOT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_translations`
--

INSERT INTO `property_translations` (`id`, `property_id`, `locale`, `title`, `detail`, `address`) VALUES
(1, 1, 'my', 'တောင်ဒဂုံစက်မှုဇုန် (၂)', '<p>တောင်ဒဂုံ စက်မှုဇုန် (၂)၊ ဧရာဝဏ်လမ်းမကြီးအနီး၊ လမ်းအရမ်းကောင်းပြီး လမ်းသာပါသည်။</p><p>သံုထပ်တိုက်ပါ၊ ပါဝါမီတာ (၂)လုံး၊ ရိုးရိုး (၁)လုံး</p><p>၁၂၀ x ၈၀</p><p>095186768</p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `savables`
--

CREATE TABLE `savables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `savable_id` bigint(20) UNSIGNED NOT NULL,
  `savable_type` varchar(255) NOT NULL
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
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `name`, `created_at`, `updated_at`) VALUES
(5, 'home', '2025-06-30 03:52:44', '2025-06-30 03:52:44'),
(6, '့home2', '2025-06-30 03:56:53', '2025-06-30 03:56:53'),
(7, 'home3', '2025-06-30 03:59:32', '2025-06-30 03:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `linkedin_user_id` varchar(255) DEFAULT NULL,
  `twitter_user_id` varchar(255) DEFAULT NULL,
  `google_user_id` varchar(255) DEFAULT NULL,
  `facebook_user_id` varchar(255) DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text DEFAULT NULL,
  `service_region_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_township_id` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `social_pages` varchar(255) DEFAULT NULL,
  `partner` date DEFAULT NULL,
  `featured` date DEFAULT NULL,
  `credit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `slug`, `phone`, `email`, `role`, `status`, `email_verified_at`, `password`, `linkedin_user_id`, `twitter_user_id`, `google_user_id`, `facebook_user_id`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `service_region_id`, `service_township_id`, `address`, `about`, `social_pages`, `partner`, `featured`, `credit`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin-user', NULL, 'admin@example.com', 'remwdstate20', 'active', '2025-06-30 03:07:52', '$2y$10$kacSPUCI.Kb0DUiWV1AdzOI1.S42D4h9d0bOiosAOMD3QGZWvCHUm', NULL, NULL, NULL, NULL, NULL, NULL, 'udkLY7oEwrbtWbwJUkMUnGBgQYzfvkVKz6EWMxFvTsdHrSWbjqPg0VhDKQOU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-30 03:07:52', '2025-06-30 03:07:52'),
(2, 'kuangkhant', 'kuangkhant', '09785220691', 'kaungkhantzin1994@gmail.com', 'user', NULL, NULL, '$2y$10$dmCTAjhG5IZR34YrCfjbLeq3hFFDDHhxWUMV0HI6P.McDVXdI//WS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a:0:{}', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-30 04:40:42', '2025-06-30 04:40:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blogs_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `categorizables`
--
ALTER TABLE `categorizables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorizable_index` (`category_id`,`categorizable_id`,`categorizable_type`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enquiries_property_id_foreign` (`property_id`),
  ADD KEY `enquiries_package_id_foreign` (`package_id`),
  ADD KEY `enquiries_agent_foreign` (`agent`),
  ADD KEY `enquiries_contacted_by_foreign` (`contacted_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_slug_unique` (`slug`);

--
-- Indexes for table `location_property`
--
ALTER TABLE `location_property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_property_index` (`location_id`,`property_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `properties_user_id_foreign` (`user_id`),
  ADD KEY `properties_type_id_foreign` (`type_id`),
  ADD KEY `properties_property_purpose_id_foreign` (`property_purpose_id`),
  ADD KEY `properties_price_index` (`price`);

--
-- Indexes for table `property_purposes`
--
ALTER TABLE `property_purposes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `property_purposes_slug_unique` (`slug`);

--
-- Indexes for table `property_translations`
--
ALTER TABLE `property_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `property_translations_property_id_locale_unique` (`property_id`,`locale`),
  ADD KEY `property_translations_locale_index` (`locale`);

--
-- Indexes for table `savables`
--
ALTER TABLE `savables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `savables_index` (`user_id`,`savable_id`,`savable_type`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
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
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categorizables`
--
ALTER TABLE `categorizables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `location_property`
--
ALTER TABLE `location_property`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_purposes`
--
ALTER TABLE `property_purposes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property_translations`
--
ALTER TABLE `property_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `savables`
--
ALTER TABLE `savables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD CONSTRAINT `enquiries_agent_foreign` FOREIGN KEY (`agent`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `enquiries_contacted_by_foreign` FOREIGN KEY (`contacted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `enquiries_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`),
  ADD CONSTRAINT `enquiries_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_property_purpose_id_foreign` FOREIGN KEY (`property_purpose_id`) REFERENCES `property_purposes` (`id`),
  ADD CONSTRAINT `properties_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `properties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `property_translations`
--
ALTER TABLE `property_translations`
  ADD CONSTRAINT `property_translations_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `savables`
--
ALTER TABLE `savables`
  ADD CONSTRAINT `savables_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
