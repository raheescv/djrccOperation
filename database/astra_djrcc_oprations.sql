-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 04, 2020 at 04:03 AM
-- Server version: 8.0.15
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `astra_djrcc_oprations`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ip` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci,
  `new_values` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beacons`
--

CREATE TABLE `beacons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hex_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `beacon_type_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ELT',
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `security_question` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `security_answer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_type_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radio_equipment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `air_craft_manufacturer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `air_craft_operation_agency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specific_usage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_usage` longtext COLLATE utf8mb4_unicode_ci,
  `vessel_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_life_boats` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_life_rafts` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radio_call_sign` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radio_call_sign_decode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inmarsat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vessel_cellular` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacturer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_s_type_approval_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beacon_home_device` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_information` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_address_line_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_address_line_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_phone_number_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_phone_number_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_phone_number_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_phone_number_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_address_line_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_address_line_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_phone_number_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_phone_number_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_phone_number_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_phone_number_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `check_lists`
--

CREATE TABLE `check_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL DEFAULT '2020-11-04',
  `sarp_data` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orbit_data` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ftp_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aftn_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amhs_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tele_fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `printer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ops_room_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leo_lut` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `geo_lut` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Qatar', 'QA', NULL, NULL, NULL),
(2, 'US', 'US', NULL, NULL, NULL),
(3, 'India', 'IN', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `date_of_issue` date NOT NULL,
  `date_of_expiry` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Driving Lisence', NULL, NULL, NULL),
(2, 'Health Card', NULL, NULL, NULL),
(3, 'Gate Pass', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_arabic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `name_arabic`, `employee_code`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Rahees', NULL, 'Code_1', NULL, NULL, NULL),
(2, 'Sajad', NULL, 'Code_2', NULL, NULL, NULL),
(3, 'Rashid', NULL, 'Code_3', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `language`, `created_at`, `updated_at`) VALUES
(1, NULL, 'en', '2020-11-03 22:33:31', '2020-11-03 22:33:31');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2020-11-04',
  `cordinator_id` bigint(20) UNSIGNED NOT NULL,
  `controller_id` bigint(20) UNSIGNED NOT NULL,
  `remarks` longtext COLLATE utf8mb4_unicode_ci,
  `entry_time` time NOT NULL,
  `exit_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_08_29_200844_create_languages_table', 1),
(4, '2018_08_29_205156_create_translations_table', 1),
(5, '2019_03_06_134739_create_reminders_table', 1),
(6, '2019_03_07_105942_create_profiles_table', 1),
(7, '2019_03_07_143332_create_sessions_table', 1),
(8, '2019_03_07_165928_create_project_modules_table', 1),
(9, '2019_03_07_170051_create_user_type_privileges_table', 1),
(10, '2019_03_08_050339_create_tasks_table', 1),
(11, '2019_03_15_080611_create_user_types_table', 1),
(12, '2019_09_28_041347_create_audits_table', 1),
(13, '2019_09_28_053540_create_activity_log_table', 1),
(14, '2019_10_06_062853_create_settings_table', 1),
(15, '2019_10_11_125121_create_document_types_table', 1),
(16, '2019_10_11_125809_create_employees_table', 1),
(17, '2019_10_11_125925_create_documents_table', 1),
(18, '2020_10_17_112304_create_countries_table', 1),
(19, '2020_10_17_112829_create_beacons_table', 1),
(20, '2020_10_18_101144_create_logs_table', 1),
(21, '2020_10_18_114010_create_check_lists_table', 1),
(22, '2020_10_18_123845_create_situations_table', 1),
(23, '2020_10_18_123904_create_situation_details_table', 1),
(24, '2020_10_25_081310_create_situation_views_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `company`, `logo`, `image`, `header`, `footer`, `address_line_1`, `address_line_2`, `address_line_3`, `mobile`, `email`) VALUES
(1, 'Company Name', '', '', 'header Name', 'footer Name', 'address_line_1', 'address_line_2', 'address_line_3', '+97470598308', 'shamlan@technoastra.com');

-- --------------------------------------------------------

--
-- Table structure for table `project_modules`
--

CREATE TABLE `project_modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `module` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_module` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_modules`
--

INSERT INTO `project_modules` (`id`, `module`, `sub_module`) VALUES
(1, 'User', 'User'),
(2, 'User', 'Profile'),
(3, 'User', 'UserTypePrivileges'),
(4, 'User', 'UserList'),
(5, 'User', 'UserTypes'),
(6, 'Settings', 'Download'),
(7, 'Settings', 'Settings'),
(8, 'Settings', 'DocumentType'),
(9, 'Employees', 'Employee'),
(10, 'Beacons', 'Beacons'),
(11, 'Beacons', 'Beacon'),
(12, 'Log', 'Log'),
(13, 'CheckList', 'CheckList'),
(14, 'Situations', 'Situations'),
(15, 'Situations', 'Situation');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '2020-11-04'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `collapse_menu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `fixed_nav_bar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `fixed_side_bar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `fixed_footer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `skin` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'skin-0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `collapse_menu`, `fixed_nav_bar`, `fixed_side_bar`, `fixed_footer`, `skin`, `created_at`, `updated_at`) VALUES
(1, 'No', 'Yes', 'Yes', 'No', 'md-skin', '2020-11-03 22:33:33', '2020-11-03 22:33:33');

-- --------------------------------------------------------

--
-- Table structure for table `situations`
--

CREATE TABLE `situations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `beacon_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `registered` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `opened_by` bigint(20) UNSIGNED NOT NULL,
  `closed_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `situation_details`
--

CREATE TABLE `situation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `situation_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT '2020-11-04',
  `time` time NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `initial` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `situation_views`
-- (See below for the actual view)
--
CREATE TABLE `situation_views` (
`id` bigint(20) unsigned
,`beacon_id` bigint(20) unsigned
,`beacon_type_id` varchar(191)
,`Beacon` varchar(191)
,`country_id` bigint(20) unsigned
,`Country` varchar(191)
,`registered` varchar(191)
,`opened_by` bigint(20) unsigned
,`OpenedBy` varchar(191)
,`closed_by` bigint(20) unsigned
,`ClosedBy` varchar(191)
);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#0088cc',
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nick_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `web_site` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type_id` int(11) NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `flag` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `first_name`, `country_code`, `mobile`, `last_name`, `nick_name`, `web_site`, `user_type_id`, `email`, `password`, `status`, `flag`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL, NULL, NULL, NULL, 'Admin', NULL, 1, 'admin@gmail.com', 'asdasd', 0, 0, NULL, '2020-11-03 22:33:33', '2020-11-03 22:33:33'),
(2, 'Rahees', NULL, NULL, NULL, NULL, NULL, 'Admin', NULL, 1, 'raheescv1992@gmail.com', 'asdasd', 0, 0, NULL, '2020-11-03 22:33:33', '2020-11-03 22:33:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `freeze` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `freeze`) VALUES
(1, 'Super Admin', 1),
(2, 'Admin', 1),
(3, 'Manager', 0),
(4, 'Receptionist', 0),
(5, 'Service Engineer', 0),
(6, 'Sales Excecutive', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_type_privileges`
--

CREATE TABLE `user_type_privileges` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `project_module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_type_privileges`
--

INSERT INTO `user_type_privileges` (`id`, `user_type_id`, `project_module_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 2, 1),
(17, 2, 2),
(18, 2, 3),
(19, 2, 4),
(20, 2, 5),
(21, 2, 6),
(22, 2, 7),
(23, 2, 8),
(24, 2, 9),
(25, 2, 10),
(26, 2, 11),
(27, 2, 12),
(28, 2, 13),
(29, 2, 14),
(30, 2, 15),
(31, 3, 1),
(32, 3, 2),
(33, 3, 3),
(34, 3, 4),
(35, 3, 5),
(36, 3, 6),
(37, 3, 7),
(38, 3, 8),
(39, 3, 9),
(40, 3, 10),
(41, 3, 11),
(42, 3, 12),
(43, 3, 13),
(44, 3, 14),
(45, 3, 15),
(46, 4, 1),
(47, 4, 2),
(48, 4, 3),
(49, 4, 4),
(50, 4, 5),
(51, 4, 6),
(52, 4, 7),
(53, 4, 8),
(54, 4, 9),
(55, 4, 10),
(56, 4, 11),
(57, 4, 12),
(58, 4, 13),
(59, 4, 14),
(60, 4, 15),
(61, 5, 1),
(62, 5, 2),
(63, 5, 3),
(64, 5, 4),
(65, 5, 5),
(66, 5, 6),
(67, 5, 7),
(68, 5, 8),
(69, 5, 9),
(70, 5, 10),
(71, 5, 11),
(72, 5, 12),
(73, 5, 13),
(74, 5, 14),
(75, 5, 15),
(76, 6, 1),
(77, 6, 2),
(78, 6, 3),
(79, 6, 4),
(80, 6, 5),
(81, 6, 6),
(82, 6, 7),
(83, 6, 8),
(84, 6, 9),
(85, 6, 10),
(86, 6, 11),
(87, 6, 12),
(88, 6, 13),
(89, 6, 14),
(90, 6, 15);

-- --------------------------------------------------------

--
-- Structure for view `situation_views`
--
DROP TABLE IF EXISTS `situation_views`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `situation_views`  AS  select `A`.`id` AS `id`,`A`.`beacon_id` AS `beacon_id`,`B`.`beacon_type_id` AS `beacon_type_id`,`B`.`hex_no` AS `Beacon`,`A`.`country_id` AS `country_id`,`C`.`name` AS `Country`,`A`.`registered` AS `registered`,`A`.`opened_by` AS `opened_by`,`D`.`name` AS `OpenedBy`,`A`.`closed_by` AS `closed_by`,`E`.`name` AS `ClosedBy` from ((((`situations` `A` join `beacons` `B` on((`B`.`id` = `A`.`beacon_id`))) join `countries` `C` on((`C`.`id` = `A`.`country_id`))) join `employees` `D` on((`D`.`id` = `A`.`opened_by`))) join `employees` `E` on((`E`.`id` = `A`.`closed_by`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_index` (`user_id`);

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indexes for table `beacons`
--
ALTER TABLE `beacons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `beacons_hex_no_unique` (`hex_no`),
  ADD KEY `beacons_country_id_foreign` (`country_id`),
  ADD KEY `beacons_created_by_foreign` (`created_by`),
  ADD KEY `beacons_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `check_lists`
--
ALTER TABLE `check_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `check_lists_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`),
  ADD UNIQUE KEY `countries_code_unique` (`code`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_types_name_unique` (`name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employee_code_unique` (`employee_code`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logs_cordinator_id_foreign` (`cordinator_id`),
  ADD KEY `logs_controller_id_foreign` (`controller_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_modules`
--
ALTER TABLE `project_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `situations`
--
ALTER TABLE `situations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `situations_beacon_id_foreign` (`beacon_id`),
  ADD KEY `situations_country_id_foreign` (`country_id`),
  ADD KEY `situations_opened_by_foreign` (`opened_by`),
  ADD KEY `situations_closed_by_foreign` (`closed_by`);

--
-- Indexes for table `situation_details`
--
ALTER TABLE `situation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `situation_details_situation_id_foreign` (`situation_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_language_id_foreign` (`language_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_types_name_unique` (`name`);

--
-- Indexes for table `user_type_privileges`
--
ALTER TABLE `user_type_privileges`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beacons`
--
ALTER TABLE `beacons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_lists`
--
ALTER TABLE `check_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_modules`
--
ALTER TABLE `project_modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `situations`
--
ALTER TABLE `situations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `situation_details`
--
ALTER TABLE `situation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_type_privileges`
--
ALTER TABLE `user_type_privileges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beacons`
--
ALTER TABLE `beacons`
  ADD CONSTRAINT `beacons_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `beacons_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `beacons_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `check_lists`
--
ALTER TABLE `check_lists`
  ADD CONSTRAINT `check_lists_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_controller_id_foreign` FOREIGN KEY (`controller_id`) REFERENCES `employees` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `logs_cordinator_id_foreign` FOREIGN KEY (`cordinator_id`) REFERENCES `employees` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `situations`
--
ALTER TABLE `situations`
  ADD CONSTRAINT `situations_beacon_id_foreign` FOREIGN KEY (`beacon_id`) REFERENCES `beacons` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `situations_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `employees` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `situations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `situations_opened_by_foreign` FOREIGN KEY (`opened_by`) REFERENCES `employees` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `situation_details`
--
ALTER TABLE `situation_details`
  ADD CONSTRAINT `situation_details_situation_id_foreign` FOREIGN KEY (`situation_id`) REFERENCES `situations` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `translations`
--
ALTER TABLE `translations`
  ADD CONSTRAINT `translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
