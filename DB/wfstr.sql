/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.25-MariaDB : Database - workflow
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flag` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `departments` */

insert  into `departments`(`id`,`name`,`description`,`is_active`,`created_at`,`updated_at`,`delete_flag`) values 
(1,'Computer science','computer science   department',0,'2023-01-20 12:41:31','2023-01-20 07:12:57',1),
(2,'PWDS','test',1,'2023-01-20 12:49:00','2023-01-20 12:49:00',1),
(3,'PWD','sample',1,'2023-01-21 11:34:16','2023-01-21 11:34:16',1),
(4,'sample','welcome',1,'2023-01-24 21:23:22','2023-01-24 21:23:22',1),
(5,'BTECH',NULL,1,'2023-01-25 10:29:06','2023-01-25 10:29:06',1);

/*Table structure for table `designations` */

DROP TABLE IF EXISTS `designations`;

CREATE TABLE `designations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flag` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `designations` */

insert  into `designations`(`id`,`name`,`description`,`is_active`,`created_at`,`updated_at`,`delete_flag`) values 
(1,'dhanaraj1','sample',1,'2023-01-20 12:51:51','2023-01-20 07:32:45',1),
(2,'CS Hod','cd',1,'2023-01-20 13:01:17','2023-01-20 13:01:17',1),
(3,'Guest Lecurer','GLR',1,'2023-01-20 13:02:12','2023-01-20 13:02:12',1);

/*Table structure for table `document_types` */

DROP TABLE IF EXISTS `document_types`;

CREATE TABLE `document_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `workflow_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flag` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `document_types` */

insert  into `document_types`(`id`,`name`,`workflow_id`,`is_active`,`created_at`,`updated_at`,`delete_flag`) values 
(1,'A document  12',1,1,'2023-01-20 13:23:29','2023-01-20 07:56:09',0);

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL DEFAULT 0,
  `sap_id` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `sign_image` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `delete_flag` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `employees` */

insert  into `employees`(`id`,`first_name`,`last_name`,`email`,`mobile`,`department_id`,`designation_id`,`sap_id`,`profile_image`,`sign_image`,`address`,`is_active`,`created_at`,`updated_at`,`deleted_at`,`delete_flag`) values 
(1,'Rajesh','Kennady','rajesh@gmail.com','9698638388',1,2,'7927','p1674216027.jfif','s1674216027.jpg','trichy',1,'2023-01-20 17:30:27','2023-01-20 17:30:27','2023-01-20 17:30:27',1),
(2,'Raja','rajan','raja@gmail.com','6374112691',1,2,'1997',NULL,NULL,'trichy',1,'2023-01-20 18:16:28','2023-01-20 18:16:28','2023-01-20 18:16:28',1),
(3,'kavin','raja','kavin@gmail.com','9597402134',1,2,'2007',NULL,NULL,NULL,1,'2023-01-20 18:19:44','2023-01-20 18:19:44','2023-01-20 18:19:44',1),
(4,'selvam','sri','selvam@gmail.com','6363741236',2,3,'1995','p1674219029.jfif',NULL,NULL,1,'2023-01-20 18:20:29','2023-01-20 18:20:29','2023-01-20 18:20:29',1),
(5,'raman','k','raman@gmail.com','7373170110',1,2,'2001','p1674220514.jfif','s1674220514.jpg','trichy',1,'2023-01-20 18:45:14','2023-01-20 18:45:14','2023-01-20 18:45:14',1),
(6,'sekar','s','sekar@gmail.com','9940745883',2,3,'2008','p1674220561.jfif','s1674220561.jfif','chennai',1,'2023-01-20 18:46:01','2023-01-20 18:46:01','2023-01-20 18:46:01',1),
(7,'martin','thamas','martin@gmail','6363636363',1,3,'Abcd@123','p1674535699.jfif',NULL,NULL,1,'2023-01-24 10:18:19','2023-01-24 10:18:19','2023-01-24 10:18:19',1),
(8,'rakesh','raj','rakesh1@gmail.com','7373170112',2,1,'79271',NULL,NULL,NULL,1,'2023-01-25 10:41:55','2023-01-25 10:41:55','2023-01-25 10:41:55',1);

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2023_01_19_070953_create_permission_tables',2);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_type`,`model_id`) values 
(26,'App\\Models\\User',19),
(28,'App\\Models\\User',20),
(30,'App\\Models\\User',1),
(30,'App\\Models\\User',21);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values 
(1,'department-view','web',NULL,NULL),
(2,'designation-view','web',NULL,NULL),
(3,'document-type-view','web',NULL,NULL),
(4,'employee-view','web',NULL,NULL),
(5,'workflow-view','web',NULL,NULL),
(6,'project-view','web',NULL,NULL),
(7,'role-view','web',NULL,NULL),
(8,'user-view','web',NULL,NULL),
(10,'department-create','web',NULL,NULL),
(11,'department-edit','web',NULL,NULL),
(12,'department-delete','web',NULL,NULL),
(13,'designation-create','web',NULL,NULL),
(14,'designation-edit','web',NULL,NULL),
(15,'designation-delete','web',NULL,NULL),
(16,'document-type-create','web',NULL,NULL),
(17,'document-type-edit','web',NULL,NULL),
(18,'document-type-delete','web',NULL,NULL),
(19,'employee-create','web',NULL,NULL),
(20,'employee-edit','web',NULL,NULL),
(21,'employee-delete','web',NULL,NULL),
(22,'project-create','web',NULL,NULL),
(23,'project-edit','web',NULL,NULL),
(24,'project-delete','web',NULL,NULL),
(25,'workflow-create','web',NULL,NULL),
(26,'workflow-edit','web',NULL,NULL),
(27,'workflow-delete','web',NULL,NULL),
(28,'role-create','web',NULL,NULL),
(29,'role-edit','web',NULL,NULL),
(30,'role-delete','web',NULL,NULL),
(31,'user-create','web',NULL,NULL),
(32,'user-edit','web',NULL,NULL),
(33,'user-delete','web',NULL,NULL),
(34,'department-upload','web',NULL,NULL),
(35,'designation-upload','web',NULL,NULL),
(36,'document-type-upload','web',NULL,NULL),
(37,'employee-upload','web',NULL,NULL),
(38,'workflow-upload','web',NULL,NULL),
(39,'project-upload','web',NULL,NULL),
(40,'role-upload','web',NULL,NULL),
(41,'user-upload','web',NULL,NULL),
(42,'department-download','web',NULL,NULL),
(43,'designation-download','web',NULL,NULL),
(44,'document-type-download','web',NULL,NULL),
(45,'employee-download','web',NULL,NULL),
(46,'workflow-download','web',NULL,NULL),
(47,'project-download','web',NULL,NULL),
(48,'role-download','web',NULL,NULL),
(49,'user-download','web',NULL,NULL);

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `project_document` */

DROP TABLE IF EXISTS `project_document`;

CREATE TABLE `project_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_level` int(11) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `is_latest` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `project_document` */

/*Table structure for table `project_levels` */

DROP TABLE IF EXISTS `project_levels`;

CREATE TABLE `project_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `due_date` varchar(255) DEFAULT NULL,
  `project_level` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `staff` text DEFAULT NULL,
  `hod` text DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `project_levels` */

/*Table structure for table `project_milestone` */

DROP TABLE IF EXISTS `project_milestone`;

CREATE TABLE `project_milestone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `milestone` varchar(255) DEFAULT NULL,
  `planned_date` varchar(255) DEFAULT NULL,
  `levels_to_be_crossed` varchar(255) DEFAULT NULL,
  `is_active` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `project_milestone` */

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) DEFAULT NULL,
  `project_code` varchar(255) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `initiator_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `workflow_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `projects` */

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_has_permissions` */

insert  into `role_has_permissions`(`permission_id`,`role_id`) values 
(1,26),
(1,27),
(1,28),
(1,29),
(1,30),
(2,26),
(2,28),
(2,30),
(3,28),
(3,30),
(4,28),
(4,30),
(5,28),
(5,30),
(6,28),
(6,30),
(7,28),
(7,30),
(8,27),
(8,28),
(8,29),
(8,30),
(10,27),
(10,29),
(10,30),
(11,27),
(11,29),
(11,30),
(12,27),
(12,29),
(12,30),
(13,29),
(13,30),
(14,27),
(14,29),
(15,27),
(15,29),
(15,30),
(16,28),
(16,30),
(17,27),
(17,29),
(17,30),
(18,27),
(18,29),
(18,30),
(19,28),
(19,30),
(20,27),
(20,28),
(20,29),
(20,30),
(21,27),
(21,29),
(21,30),
(22,28),
(22,30),
(23,27),
(23,28),
(23,29),
(23,30),
(24,27),
(24,28),
(24,29),
(24,30),
(25,28),
(25,30),
(26,27),
(26,29),
(26,30),
(27,27),
(27,29),
(27,30),
(28,29),
(28,30),
(29,27),
(29,29),
(29,30),
(30,27),
(30,29),
(30,30),
(31,27),
(31,29),
(31,30),
(32,27),
(32,29),
(32,30),
(33,27),
(33,29),
(33,30),
(34,27),
(34,29),
(34,30),
(35,29),
(35,30),
(36,29),
(36,30),
(37,29),
(37,30),
(38,29),
(38,30),
(39,29),
(39,30),
(40,29),
(40,30),
(41,27),
(41,29),
(41,30),
(42,27),
(42,29),
(42,30),
(43,29),
(43,30),
(44,29),
(44,30),
(45,29),
(45,30),
(46,29),
(46,30),
(47,29),
(47,30),
(48,29),
(48,30),
(49,27),
(49,29),
(49,30);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_flag` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`guard_name`,`delete_flag`,`created_at`,`updated_at`) values 
(26,'Manager','web',1,'2023-01-20 13:12:57','2023-01-20 13:12:57'),
(27,'Super Visor','web',1,'2023-01-20 13:14:12','2023-01-20 13:14:12'),
(28,'executive','web',1,'2023-01-21 07:16:16','2023-01-21 07:16:16'),
(29,'Sri Rangam','web',1,'2023-01-21 12:02:05','2023-01-24 10:29:01'),
(30,'SuperAdmin','web',1,NULL,'2023-01-24 04:44:38');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `is_super_admin` int(11) DEFAULT NULL,
  `auth_level` tinyint(1) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`email`,`email_verified_at`,`is_admin`,`is_super_admin`,`auth_level`,`password`,`emp_id`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Admin','admin','admin@gmail.com',NULL,1,1,9,'$2y$10$OvbOTQ4LNMwd.jb/BGO/bOf2a1HBRwWOr2H31rpfFj2h55r/.9iky',0,NULL,'2023-01-04 08:09:00','2023-01-23 11:09:23'),
(16,'Raja','raja@gmail.com','raja@gmail.com',NULL,1,NULL,NULL,'$2y$10$y6eRIM6vjOI.10QXt4fgpuL.0ETYNKV7soPisRPJSZ6LvLYHv58t6',2,NULL,'2023-01-20 12:47:12','2023-01-20 12:47:12'),
(17,'kavin','kavin@gmail.com','kavin@gmail.com',NULL,1,NULL,NULL,'$2y$10$mc9VS5mMnAYPs28FeBboE.eaBpTOdW.qywE4NRw6ErrpyDH5cga9G',3,NULL,'2023-01-20 12:50:55','2023-01-20 12:50:55'),
(18,'selvam','selvam@gmail.com','selvam@gmail.com',NULL,1,NULL,NULL,'$2y$10$9mDqF2XP3RSvurfH/1Dt7e75HdPD6Jo6H9fb5Tdt7q7AGwNLYNEI2',4,NULL,'2023-01-20 12:51:22','2023-01-20 12:51:22'),
(19,'raman','raman@gmail.com','raman@gmail.com',NULL,1,NULL,NULL,'$2y$10$.GEj4mejtQIsqu0VICOpbePsDTxNZ9dKMj7XmCbvX6bdzTzhFjSMa',5,NULL,'2023-01-20 13:17:05','2023-01-20 13:17:05'),
(20,'sekar','sekar@gmail.com','sekar@gmail.com',NULL,1,NULL,NULL,'$2y$10$.GEj4mejtQIsqu0VICOpbePsDTxNZ9dKMj7XmCbvX6bdzTzhFjSMa',6,NULL,'2023-01-20 13:18:30','2023-01-21 12:16:51'),
(21,'martin','Abcd@123','martin@gmail',NULL,1,NULL,NULL,'$2y$10$fbXQiq8mFY9yDeXN1KVgB.uP3xWKa491kca77nKOIOdnxgLt6uooW',7,NULL,'2023-01-24 05:03:29','2023-01-24 05:03:29'),
(22,'superAdmin','superAdmin','superadmin@gmail.com',NULL,NULL,1,NULL,'$2y$10$OvbOTQ4LNMwd.jb/BGO/bOf2a1HBRwWOr2H31rpfFj2h55r/.9iky',NULL,NULL,NULL,NULL),
(23,'admin1','admin1','admin1@gmail.com',NULL,NULL,1,NULL,'$2y$10$OvbOTQ4LNMwd.jb/BGO/bOf2a1HBRwWOr2H31rpfFj2h55r/.9iky',NULL,NULL,NULL,NULL);

/*Table structure for table `workflow_levels` */

DROP TABLE IF EXISTS `workflow_levels`;

CREATE TABLE `workflow_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workflow_id` int(11) NOT NULL,
  `levels` int(11) NOT NULL,
  `approver_designation` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `workflow_levels` */

insert  into `workflow_levels`(`id`,`workflow_id`,`levels`,`approver_designation`,`is_active`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,1,2,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(2,1,2,3,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(3,1,3,3,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(4,1,4,2,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(5,1,5,2,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(6,1,6,3,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(7,1,7,3,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(8,1,8,3,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(9,1,9,2,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(10,1,10,2,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28'),
(11,1,11,2,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28');

/*Table structure for table `workflows` */

DROP TABLE IF EXISTS `workflows`;

CREATE TABLE `workflows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workflow_code` varchar(255) DEFAULT NULL,
  `workflow_name` varchar(255) NOT NULL,
  `workflow_type` int(11) NOT NULL DEFAULT 1,
  `total_levels` int(11) NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `delete_flag` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `workflows` */

insert  into `workflows`(`id`,`workflow_code`,`workflow_name`,`workflow_type`,`total_levels`,`is_active`,`created_at`,`updated_at`,`deleted_at`,`delete_flag`) values 
(1,'FF001','First Flow',0,11,1,'2023-01-24 11:36:28','2023-01-24 11:36:28','2023-01-24 17:06:28',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
