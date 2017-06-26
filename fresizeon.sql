-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2016 at 02:41 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fresizeon`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jack Niño Ladrera', 'jack.ladrera@gmail.com', '$2y$10$499kBcLs6nQDMJc4UaHiT.sfG3HnryUu0A7jZZO67cZjI3xmD.TXO', '2016-12-18 23:29:34', 'PWpwSzjKofnzvUK4KMiuAXQ5IGuI5nhpQIqIsNfIoshNxC2aLXIPnU95A5MD', '2015-04-29 12:03:15', '2016-12-19 06:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(10) UNSIGNED NOT NULL,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` enum('absent','present') COLLATE utf8_unicode_ci NOT NULL,
  `leaveType` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `halfDayType` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `application_status` enum('approved','rejected','pending') COLLATE utf8_unicode_ci DEFAULT NULL,
  `applied_on` date DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employeeID`, `date`, `status`, `leaveType`, `halfDayType`, `reason`, `application_status`, `applied_on`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '00001', '2016-12-01', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-19 05:52:56', '2016-12-19 05:52:56'),
(2, '00001', '2016-12-02', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-19 05:53:02', '2016-12-19 05:53:02'),
(3, '00001', '2016-12-05', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-19 05:53:08', '2016-12-19 05:53:08'),
(4, '00001', '2016-12-06', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-19 05:53:16', '2016-12-19 05:53:16'),
(5, '00002', '2016-12-01', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:09', '2016-12-20 02:52:09'),
(6, '00002', '2016-12-02', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:16', '2016-12-20 02:52:16'),
(7, '00002', '2016-12-05', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:25', '2016-12-20 02:52:25'),
(8, '00002', '2016-12-06', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:34', '2016-12-20 02:52:34'),
(9, '00001', '2016-12-07', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:41', '2016-12-20 02:52:41'),
(10, '00002', '2016-12-07', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:41', '2016-12-20 02:52:41'),
(11, '00001', '2016-12-08', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:47', '2016-12-20 02:52:47'),
(12, '00002', '2016-12-08', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:48', '2016-12-20 02:52:48'),
(13, '00001', '2016-12-09', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:55', '2016-12-20 02:52:55'),
(14, '00002', '2016-12-09', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:52:55', '2016-12-20 02:52:55'),
(15, '00001', '2016-12-12', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:53:02', '2016-12-20 02:53:02'),
(16, '00002', '2016-12-12', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 02:53:02', '2016-12-20 02:53:02'),
(17, '00003', '2016-11-21', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 05:50:09', '2016-12-20 05:50:09'),
(18, '00003', '2016-11-22', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 05:50:18', '2016-12-20 05:50:18'),
(19, '00003', '2016-11-23', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 05:50:27', '2016-12-20 05:50:27'),
(20, '00003', '2016-11-24', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 05:50:35', '2016-12-20 05:50:35'),
(21, '00003', '2016-11-25', 'present', NULL, NULL, '', NULL, NULL, 'jack.ladrera@gmail.com', '2016-12-20 05:50:42', '2016-12-20 05:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `id` int(10) UNSIGNED NOT NULL,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `awardName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gift` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cashPrice` double NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`id`, `employeeID`, `awardName`, `gift`, `cashPrice`, `date`, `created_at`, `updated_at`) VALUES
(1, '00001', 'Christmas Bonus', 'Cash', 5000, '2016-12-09', '2016-12-19 06:35:25', '2016-12-19 06:35:25'),
(2, '00001', 'No Lates', 'Cash', 2000, '2016-12-12', '2016-12-19 06:35:39', '2016-12-19 06:35:39'),
(3, '00002', 'Christmas Bonus', 'Cash', 5000, '2016-12-05', '2016-12-20 02:56:30', '2016-12-20 02:56:30');

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `accountName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `accountNumber` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `bank` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pan` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `branch` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ifsc` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(10) UNSIGNED NOT NULL,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `employeeID`, `reason`, `amount`, `date`, `created_at`, `updated_at`) VALUES
(1, '00001', 'GWAPA RA!', 500, '2016-12-02', '2016-12-19 04:04:17', '2016-12-19 04:04:17'),
(2, '00001', 'GWAPA KAAYO!', 1000, '2016-12-06', '2016-12-19 05:59:26', '2016-12-19 05:59:26');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(10) UNSIGNED NOT NULL,
  `deptName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `deptName`, `created_at`, `updated_at`) VALUES
(1, 'PMC - CONCHING', '2016-12-19 02:50:08', '2016-12-19 02:50:08'),
(2, 'HERMAG', '2016-12-20 03:08:06', '2016-12-20 03:08:06');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(10) UNSIGNED NOT NULL,
  `deptID` int(10) UNSIGNED NOT NULL,
  `designation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `deptID`, `designation`, `created_at`, `updated_at`) VALUES
(1, 1, 'Worker', '2016-12-19 02:50:08', '2016-12-19 02:50:08'),
(2, 2, 'Worker', '2016-12-20 03:08:06', '2016-12-20 03:08:06');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL,
  `fatherName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mobileNumber` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `designation` int(10) UNSIGNED DEFAULT NULL,
  `joiningDate` date DEFAULT NULL,
  `profileImage` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'default.jpg',
  `localAddress` text COLLATE utf8_unicode_ci NOT NULL,
  `permanentAddress` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exit_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employeeID`, `fullName`, `email`, `password`, `gender`, `fatherName`, `mobileNumber`, `date_of_birth`, `designation`, `joiningDate`, `profileImage`, `localAddress`, `permanentAddress`, `status`, `last_login`, `remember_token`, `exit_date`, `created_at`, `updated_at`) VALUES
(1, '00001', 'Zaida Suarez', 'test@test.com', '$2y$10$e/hRSOItXp0SPjMbBSn1aem6obxBgyTeUyDnEO/ipDf3q5eyzY5D2', 'female', '', '', '1970-01-01', 1, '2016-12-01', 'Zaida_00001.jpg', '', '', 'active', '0000-00-00 00:00:00', NULL, NULL, '2016-12-19 02:50:57', '2016-12-20 01:54:03'),
(2, '00002', 'Rolly Parolan', 'test@test.com', '$2y$10$uYOh5VbJoNOo.5V/6wWJieZs2AfgE9R313yNaOPZYGH4cgKwTd0RC', 'male', '', '', '1989-03-31', 1, '2016-12-01', 'Rolly_00002.png', '', '', 'active', '0000-00-00 00:00:00', NULL, NULL, '2016-12-20 01:49:35', '2016-12-20 01:53:40'),
(3, '00003', 'Johnry Flores', 'test@test.com', '$2y$10$ohRiUHYkM1aKPgLfndQDQuyxe66kcRpI3ZO4gLTo9xw1Q03VOvgxa', 'male', '', '', '1970-01-01', 2, '2016-11-21', 'Johnry_00003.png', '', '', 'active', '0000-00-00 00:00:00', NULL, NULL, '2016-12-20 05:39:17', '2016-12-20 05:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `employee_documents`
--

CREATE TABLE `employee_documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fileName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `itemName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchaseDate` date NOT NULL,
  `purchaseFrom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `bill` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `occassion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `date`, `occassion`, `created_at`, `updated_at`) VALUES
(1, '2016-12-25', 'Christmas Day', '2016-12-20 04:04:06', '2016-12-20 04:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `leavetypes`
--

CREATE TABLE `leavetypes` (
  `id` int(10) UNSIGNED NOT NULL,
  `leaveType` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `num_of_leave` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `leavetypes`
--

INSERT INTO `leavetypes` (`id`, `leaveType`, `num_of_leave`, `created_at`, `updated_at`) VALUES
(1, 'sick', 5, '2015-04-29 12:03:15', '2015-04-29 12:03:15'),
(2, 'casual', 5, '2015-04-29 12:03:15', '2015-04-29 12:03:15'),
(3, 'half day', 0, '2015-04-29 12:03:15', '2015-04-29 12:03:15'),
(4, 'maternity', 5, '2015-04-29 12:03:15', '2015-04-29 12:03:15'),
(5, 'others', 5, '2015-04-29 12:03:15', '2015-04-29 12:03:15');

-- --------------------------------------------------------

--
-- Table structure for table `noticeboards`
--

CREATE TABLE `noticeboards` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `id` int(10) UNSIGNED NOT NULL,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `time` double NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `overtime`
--

INSERT INTO `overtime` (`id`, `employeeID`, `time`, `reason`, `date`, `created_at`, `updated_at`) VALUES
(1, '00001', 2.5, 'busy kaayo', '2016-12-05', '2016-12-19 02:57:03', '2016-12-19 07:16:58'),
(2, '00001', 5, 'overtime lang ', '2016-12-08', '2016-12-20 02:54:38', '2016-12-20 02:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` int(10) UNSIGNED NOT NULL,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `employeeName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `daily_rate` double NOT NULL,
  `hour_rate` double NOT NULL,
  `overtime` double NOT NULL,
  `days_work` double NOT NULL,
  `salary` double NOT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`id`, `employeeID`, `employeeName`, `type`, `daily_rate`, `hour_rate`, `overtime`, `days_work`, `salary`, `remarks`, `created_at`, `updated_at`) VALUES
(1, '00001', 'Zaida Suarez', 'contractual', 1000, 125, 7.5, 8, 8937.5, '', '2016-12-19 02:50:57', '2016-12-19 02:50:57'),
(2, '00002', 'Rolly Parolan', 'contractual', 800, 100, 0, 8, 6400, '', '2016-12-20 01:49:35', '2016-12-20 01:49:35'),
(3, '00003', 'Johnry Flores', 'contractual', 450, 56.25, 0, 5, 2250, '', '2016-12-20 05:39:17', '2016-12-20 05:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `currency_icon` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `award_notification` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `attendance_notification` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `leave_notification` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `notice_notification` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `employee_add` enum('1','0') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `website`, `email`, `name`, `logo`, `currency`, `currency_icon`, `award_notification`, `attendance_notification`, `leave_notification`, `notice_notification`, `employee_add`, `created_at`, `updated_at`) VALUES
(1, 'Fresizeon', 'jack.ladrera@gmail.com', 'Administrator', 'logo.png', 'PHP', 'fa-rub', '1', '0', '1', '1', '1', '2015-04-29 12:03:15', '2016-12-19 02:49:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_employeeid_index` (`employeeID`),
  ADD KEY `attendance_leavetype_index` (`leaveType`),
  ADD KEY `attendance_updated_by_index` (`updated_by`),
  ADD KEY `attendance_halfdaytype_index` (`halfDayType`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `awards_employeeid_index` (`employeeID`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_details_employeeid_index` (`employeeID`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deductions_employeeid_index` (`employeeID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designation_deptid_foreign` (`deptID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employeeid_unique` (`employeeID`),
  ADD KEY `employees_designation_foreign` (`designation`);

--
-- Indexes for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_documents_employeeid_index` (`employeeID`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `holidays_date_unique` (`date`);

--
-- Indexes for table `leavetypes`
--
ALTER TABLE `leavetypes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leavetypes_leavetype_index` (`leaveType`);

--
-- Indexes for table `noticeboards`
--
ALTER TABLE `noticeboards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `overtime_employeeid_index` (`employeeID`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_employeeid_index` (`employeeID`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `employee_documents`
--
ALTER TABLE `employee_documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `leavetypes`
--
ALTER TABLE `leavetypes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `noticeboards`
--
ALTER TABLE `noticeboards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_halfdaytype_foreign` FOREIGN KEY (`halfDayType`) REFERENCES `leavetypes` (`leaveType`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_leavetype_foreign` FOREIGN KEY (`leaveType`) REFERENCES `leavetypes` (`leaveType`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD CONSTRAINT `bank_details_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deductions`
--
ALTER TABLE `deductions`
  ADD CONSTRAINT `deductions_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `designation`
--
ALTER TABLE `designation`
  ADD CONSTRAINT `designation_deptid_foreign` FOREIGN KEY (`deptID`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_designation_foreign` FOREIGN KEY (`designation`) REFERENCES `designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD CONSTRAINT `employee_documents_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `overtime`
--
ALTER TABLE `overtime`
  ADD CONSTRAINT `overtime_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
