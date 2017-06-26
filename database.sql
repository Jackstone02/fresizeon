# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.16)
# Database: hrm
# Generation Time: 2015-04-29 11:33:36 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `last_login`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Jack Niño Ladrera','jack.ladrera@gmail.com','$2y$10$499kBcLs6nQDMJc4UaHiT.sfG3HnryUu0A7jZZO67cZjI3xmD.TXO','0000-00-00 00:00:00',NULL,'2015-04-29 06:03:15','2015-04-29 06:03:15');

/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table attendance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attendance`;

CREATE TABLE `attendance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` enum('absent','present') COLLATE utf8_unicode_ci NOT NULL,
  `leaveType` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `halfDayType` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `application_status` enum('approved','rejected','pending') COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` int(10) unsigned DEFAULT NULL,
  `time_in` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `time_out` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `work_hours` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `overtime` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `applied_on` date DEFAULT NULL,
  `updated_by` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  
  KEY `attendance_employeeid_index` (`employeeID`),
  KEY `attendance_leavetype_index` (`leaveType`),
  KEY `attendance_updated_by_index` (`updated_by`),
  KEY `attendance_halfdaytype_index` (`halfDayType`),
  CONSTRAINT `attendance_halfdaytype_foreign` FOREIGN KEY (`halfDayType`) REFERENCES `leavetypes` (`leaveType`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `attendance_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `attendance_leavetype_foreign` FOREIGN KEY (`leaveType`) REFERENCES `leavetypes` (`leaveType`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `attendance_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table awards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `awards`;

CREATE TABLE `awards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `awardName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gift` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cashPrice` double NOT NULL,
  /*`cashPrice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forMonth` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `forYear` varchar(4) COLLATE utf8_unicode_ci NOT NULL,*/
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `awards_employeeid_index` (`employeeID`),
  CONSTRAINT `awards_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


# Dump of table deductions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `deductions`;

CREATE TABLE `deductions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  /*`amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,*/
  `amount` double NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `deductions_employeeid_index` (`employeeID`),
  CONSTRAINT `deductions_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table bank_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bank_details`;

CREATE TABLE `bank_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `accountName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `accountNumber` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `bank` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pan` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `branch` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ifsc` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `bank_details_employeeid_index` (`employeeID`),
  CONSTRAINT `bank_details_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table department
# ------------------------------------------------------------

DROP TABLE IF EXISTS `department`;

CREATE TABLE `department` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deptName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `budget` double NOT NULL,
  `labor_percent` double NOT NULL,
  `labor` double NOT NULL,
  `materials_percent` double NOT NULL,
  `materials` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table designation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `designation`;

CREATE TABLE `designation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deptID` int(10) unsigned NOT NULL,
  `designation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `designation_deptid_foreign` (`deptID`),
  CONSTRAINT `designation_deptid_foreign` FOREIGN KEY (`deptID`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table employee_documents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employee_documents`;

CREATE TABLE `employee_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fileName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `employee_documents_employeeid_index` (`employeeID`),
  CONSTRAINT `employee_documents_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table employees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL,
  `fatherName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mobileNumber` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `department` int(10) unsigned DEFAULT NULL,
  `designation` int(10) unsigned DEFAULT NULL,
  `joiningDate` date DEFAULT NULL,
  `profileImage` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'default.jpg',
  `localAddress` text COLLATE utf8_unicode_ci NOT NULL,
  `permanentAddress` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exit_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  /*UNIQUE KEY `employees_email_unique` (`email`),*/
  UNIQUE KEY `employees_employeeid_unique` (`employeeID`),
  KEY `employees_designation_foreign` (`designation`),
  CONSTRAINT `employees_designation_foreign` FOREIGN KEY (`designation`) REFERENCES `designation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table expenses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `expenses`;

CREATE TABLE `expenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department` int(10) unsigned DEFAULT NULL,
  `itemName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(10) unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchaseDate` date NOT NULL,
  /*`purchaseFrom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,*/
  `price` double NOT NULL,
  `bill` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table holidays
# ------------------------------------------------------------

DROP TABLE IF EXISTS `holidays`;

CREATE TABLE `holidays` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `occassion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `holidays_date_unique` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table leavetypes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `leavetypes`;

CREATE TABLE `leavetypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `leaveType` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `num_of_leave` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `leavetypes_leavetype_index` (`leaveType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `leavetypes` WRITE;
/*!40000 ALTER TABLE `leavetypes` DISABLE KEYS */;

INSERT INTO `leavetypes` (`id`, `leaveType`, `num_of_leave`, `created_at`, `updated_at`)
VALUES
	(1,'sick',5,'2015-04-29 06:03:15','2015-04-29 06:03:15'),
	(2,'casual',5,'2015-04-29 06:03:15','2015-04-29 06:03:15'),
	(3,'half day',0,'2015-04-29 06:03:15','2015-04-29 06:03:15'),
	(4,'maternity',5,'2015-04-29 06:03:15','2015-04-29 06:03:15'),
	(5,'others',5,'2015-04-29 06:03:15','2015-04-29 06:03:15');

/*!40000 ALTER TABLE `leavetypes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table noticeboards
# ------------------------------------------------------------

DROP TABLE IF EXISTS `noticeboards`;

CREATE TABLE `noticeboards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


# Dump of table overtime
# ------------------------------------------------------------

DROP TABLE IF EXISTS `overtime`;

CREATE TABLE `overtime` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `time` double NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `overtime_employeeid_index` (`employeeID`),
  CONSTRAINT `overtime_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table salary
# ------------------------------------------------------------
/*
DROP TABLE IF EXISTS `salary`;

CREATE TABLE `salary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `salary` double NOT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `salary_employeeid_index` (`employeeID`),
  CONSTRAINT `salary_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/

DROP TABLE IF EXISTS `salary`;

CREATE TABLE `salary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `employeeName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  /*`type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,*/
  `department` int(10) unsigned DEFAULT NULL,
  `daily_rate` double NOT NULL,
  `hour_rate` double NOT NULL,
  `overtime` double NOT NULL,
  `days_work` double NOT NULL,
  /*`awards` double NOT NULL,*/
  `salary` double NOT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `salary_employeeid_index` (`employeeID`),
  CONSTRAINT `salary_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* removed not used -jack 12.15.2016
# Dump of table payslip
# ------------------------------------------------------------

DROP TABLE IF EXISTS `payslip`;

CREATE TABLE `payslip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employeeID` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `employeeName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `daily_rate` double NOT NULL,
  `hour_rate` double NOT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `payslip_employeeid_index` (`employeeID`),
  CONSTRAINT `payslip_employeeid_foreign` FOREIGN KEY (`employeeID`) REFERENCES `employees` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

*/

# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `website`, `email`, `name`, `logo`, `currency`, `currency_icon`, `award_notification`, `attendance_notification`, `leave_notification`, `notice_notification`,`employee_add`, `created_at`, `updated_at`)
VALUES
	(1,'FRESIZEON','jack.ladrera@gmail.com','Administrator','logo.png','INR','fa-inr','1','0','1','1','1','2015-04-29 06:03:15','2015-04-29 06:03:15');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
