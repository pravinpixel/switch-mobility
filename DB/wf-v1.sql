/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.25-MariaDB : Database - wf-v1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `authority_types` */

DROP TABLE IF EXISTS `authority_types`;

CREATE TABLE `authority_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `authority_types` */

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `delete_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `departments` */

insert  into `departments`(`id`,`name`,`description`,`is_active`,`created_at`,`updated_at`,`deleted_at`,`delete_flag`) values 
(1,'Development',NULL,0,'2023-02-17 11:59:48','2023-02-17 07:55:14','2023-02-17 07:55:14',1),
(2,'Manufacturing','Head of the Department',1,'2023-02-17 12:00:07','2023-02-19 13:44:52','2023-02-19 13:44:52',1),
(3,'Productions',NULL,1,'2023-02-17 12:00:16','2023-02-17 10:41:35',NULL,1),
(4,'Technology',NULL,1,'2023-02-17 12:00:31','2023-02-17 12:00:31',NULL,1),
(5,'Bussiness Division',NULL,1,'2023-02-17 12:00:42','2023-02-17 12:00:42',NULL,1),
(6,'Special Division',NULL,1,'2023-02-17 12:00:51','2023-02-17 12:00:51',NULL,1),
(7,'Tech Services',NULL,1,'2023-02-17 12:01:02','2023-02-17 12:01:02',NULL,1),
(8,'Industrial Direction',NULL,1,'2023-02-17 12:01:14','2023-02-17 12:01:14',NULL,1),
(9,'Maintenance',NULL,1,'2023-02-17 12:01:44','2023-02-17 12:01:44',NULL,1),
(10,'Design(UI/UX)',NULL,1,'2023-02-17 12:01:58','2023-02-17 12:01:58',NULL,1),
(11,'Testing & Review',NULL,1,'2023-02-17 12:02:10','2023-02-17 12:02:10',NULL,1),
(12,'Consultancy Firm',NULL,1,'2023-02-17 12:02:19','2023-02-17 12:02:19',NULL,1),
(13,'Executive Office',NULL,1,'2023-02-17 12:03:25','2023-02-17 12:03:25',NULL,1),
(14,'Professional Support',NULL,1,'2023-02-17 12:03:38','2023-02-17 12:03:38',NULL,1),
(15,'Technological Help',NULL,1,'2023-02-17 12:03:52','2023-02-17 12:03:52',NULL,1),
(16,'Sales & Marketing',NULL,1,'2023-02-17 12:04:35','2023-02-20 13:01:52',NULL,1),
(17,'Customer Services',NULL,1,'2023-02-17 12:04:45','2023-02-17 12:04:45',NULL,1),
(18,'Cloud Architect',NULL,1,'2023-02-17 12:04:55','2023-02-17 12:04:55',NULL,1),
(19,'Network Manager',NULL,1,'2023-02-17 12:05:09','2023-02-17 12:05:09',NULL,1),
(20,'Product Specialist',NULL,1,'2023-02-17 12:05:26','2023-02-17 12:05:26',NULL,1),
(21,'Database Administrator','he/ she is an databsae  administrator',1,'2023-02-17 12:05:37','2023-02-21 04:18:15',NULL,1),
(22,'Programm Manager',NULL,1,'2023-02-17 12:05:47','2023-02-17 12:05:47',NULL,1),
(23,'System Architect',NULL,1,'2023-02-17 12:05:57','2023-02-17 12:05:57',NULL,1),
(24,'Software Architect',NULL,1,'2023-02-17 12:06:09','2023-02-17 12:06:09',NULL,1),
(25,'Accountant',NULL,1,'2023-02-17 12:06:16','2023-02-17 12:06:16',NULL,1),
(26,'Financial Advisor',NULL,1,'2023-02-17 12:06:26','2023-02-17 12:06:26',NULL,1),
(27,'Media & Communication',NULL,1,'2023-02-17 12:06:43','2023-02-17 12:06:43',NULL,1),
(28,'HR/HRM',NULL,1,'2023-02-17 12:06:53','2023-02-17 12:06:53',NULL,1),
(29,'Service & Security',NULL,1,'2023-02-17 12:07:09','2023-02-17 12:07:09',NULL,1),
(30,'Quality Assurance tester',NULL,1,'2023-02-17 12:07:21','2023-02-21 04:17:33',NULL,1),
(31,'Development',NULL,1,'2023-02-17 15:25:31','2023-02-17 15:25:31',NULL,1),
(32,'hhhhhhhh',NULL,1,'2023-02-19 19:15:15','2023-02-21 04:23:16','2023-02-21 04:23:16',1),
(33,'Test Departments','test Description',1,'2023-02-20 18:29:22','2023-02-21 04:15:45',NULL,1),
(34,'tgfdcvbgfdsa',NULL,1,'2023-02-21 09:52:17','2023-02-21 04:22:26','2023-02-21 04:22:26',1),
(35,'kirruku',NULL,1,'2023-02-21 09:52:35','2023-02-21 09:52:35',NULL,1);

/*Table structure for table `designations` */

DROP TABLE IF EXISTS `designations`;

CREATE TABLE `designations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `delete_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `designations` */

insert  into `designations`(`id`,`name`,`description`,`is_active`,`created_at`,`updated_at`,`deleted_at`,`delete_flag`) values 
(1,'HR',NULL,1,'2023-02-17 12:28:02','2023-02-17 07:32:08','2023-02-17 07:32:08',1),
(2,'Engg',NULL,1,'2023-02-17 12:28:14','2023-02-17 07:32:13','2023-02-17 07:32:13',1),
(3,'comercial',NULL,1,'2023-02-17 12:28:34','2023-02-17 07:32:18','2023-02-17 07:32:18',1),
(4,'Floorshop',NULL,1,'2023-02-17 12:28:51','2023-02-19 13:42:55','2023-02-19 13:42:55',1),
(5,'Junior Developer',NULL,1,'2023-02-17 13:02:42','2023-02-20 13:08:03',NULL,1),
(6,'Senior Developer',NULL,1,'2023-02-17 13:03:07','2023-02-21 04:21:09',NULL,1),
(7,'Team Leader',NULL,1,'2023-02-17 13:03:20','2023-02-21 04:20:48',NULL,1),
(8,'Chief Technology officer',NULL,1,'2023-02-17 13:03:47','2023-02-21 04:20:41',NULL,1),
(9,'Chief executive officer',NULL,1,'2023-02-17 13:04:12','2023-02-17 10:30:36',NULL,1),
(10,'Chief Operations Officers',NULL,1,'2023-02-17 13:04:58','2023-02-19 13:42:29',NULL,1),
(11,'Production planner',NULL,1,'2023-02-17 13:05:10','2023-02-19 13:42:22',NULL,1),
(12,'Production Manager',NULL,1,'2023-02-17 13:05:34','2023-02-17 13:05:34',NULL,1),
(13,'Production Supervisor',NULL,1,'2023-02-17 13:05:46','2023-02-17 13:05:46',NULL,1),
(14,'Computer System Manager',NULL,1,'2023-02-17 13:05:57','2023-02-17 13:05:57',NULL,1),
(15,'IT Co-ordinator',NULL,1,'2023-02-17 13:06:23','2023-02-17 13:06:23',NULL,1),
(16,'Service Desk Analyst',NULL,1,'2023-02-17 13:06:37','2023-02-17 13:06:37',NULL,1),
(17,'Supervisor',NULL,1,'2023-02-17 13:06:45','2023-02-21 04:21:05',NULL,1),
(18,'Section Head',NULL,1,'2023-02-17 13:06:55','2023-02-17 13:06:55',NULL,1),
(19,'Assistant Manager',NULL,1,'2023-02-17 13:07:04','2023-02-17 13:07:04',NULL,1),
(20,'Catering',NULL,1,'2023-02-17 13:07:17','2023-02-20 13:05:12',NULL,1),
(21,'Employee Services',NULL,1,'2023-02-17 13:07:28','2023-02-17 13:07:28',NULL,1),
(22,'Boutique Management',NULL,1,'2023-02-17 13:07:42','2023-02-17 13:07:42',NULL,1),
(23,'Technical Support Executive',NULL,1,'2023-02-17 13:08:05','2023-02-17 13:08:05',NULL,1),
(24,'Technical Support Engineer',NULL,1,'2023-02-17 13:08:21','2023-02-17 13:08:21',NULL,1),
(25,'Technical Product Manager',NULL,1,'2023-02-17 13:08:38','2023-02-17 13:08:38',NULL,1),
(26,'First Level Management',NULL,1,'2023-02-17 13:08:54','2023-02-17 13:08:54',NULL,1),
(27,'Middle Level Management',NULL,1,'2023-02-17 13:09:05','2023-02-17 13:09:05',NULL,1),
(28,'Entry Level 1',NULL,0,'2023-02-17 13:09:13','2023-02-17 10:29:39',NULL,1),
(29,'Electrical/Electronics Technician',NULL,1,'2023-02-17 13:09:29','2023-02-17 13:09:29',NULL,1),
(30,'Pipe Fitter',NULL,1,'2023-02-17 13:09:37','2023-02-17 13:09:37',NULL,1),
(31,'Steam Fitter',NULL,0,'2023-02-17 13:09:47','2023-02-17 10:30:16',NULL,1),
(32,'Web Designer',NULL,1,'2023-02-17 13:10:02','2023-02-17 13:10:02',NULL,1),
(33,'Graphic/VSLI designer',NULL,1,'2023-02-17 13:10:16','2023-02-17 13:10:16',NULL,1),
(34,'Ux Designer',NULL,1,'2023-02-17 13:10:24','2023-02-17 13:10:24',NULL,1),
(35,'Junior Software Tester',NULL,1,'2023-02-17 13:10:37','2023-02-17 13:10:37',NULL,1),
(36,'Senior Software Tester',NULL,1,'2023-02-17 13:10:50','2023-02-17 13:10:50',NULL,1),
(37,'Test engineer',NULL,1,'2023-02-17 13:11:07','2023-02-17 13:11:07',NULL,1),
(38,'Strategy',NULL,1,'2023-02-17 13:11:16','2023-02-17 13:11:16',NULL,1),
(39,'Operations',NULL,1,'2023-02-17 13:11:24','2023-02-17 13:11:24',NULL,1),
(40,'Senior Consultant',NULL,1,'2023-02-17 13:11:34','2023-02-21 04:21:13',NULL,1),
(41,'Chief Marketing office',NULL,0,'2023-02-17 14:40:34','2023-02-17 10:29:51',NULL,1),
(42,'Chief Information officer',NULL,1,'2023-02-17 14:41:11','2023-02-17 14:41:11',NULL,1),
(43,'Chief Technical officer',NULL,1,'2023-02-17 14:41:26','2023-02-17 14:41:26',NULL,1),
(44,'customer Representative',NULL,1,'2023-02-17 14:41:43','2023-02-17 14:41:43',NULL,1),
(45,'Service Specialist',NULL,1,'2023-02-17 14:42:01','2023-02-17 14:42:01',NULL,1),
(46,'Customer Support Specialist',NULL,1,'2023-02-17 14:42:26','2023-02-17 14:42:26',NULL,1),
(47,'Help Desk Technician',NULL,1,'2023-02-17 14:42:47','2023-02-17 14:42:47',NULL,1),
(48,'NOC Specialist',NULL,1,'2023-02-17 14:43:04','2023-02-17 14:43:04',NULL,1),
(49,'Data Modelers',NULL,1,'2023-02-17 14:43:16','2023-02-17 14:43:16',NULL,1),
(50,'Sales Ebgineer',NULL,1,'2023-02-17 14:43:30','2023-02-17 14:43:30',NULL,1),
(51,'Marketing Support',NULL,1,'2023-02-17 14:43:47','2023-02-17 14:43:47',NULL,1),
(52,'Sales Management',NULL,1,'2023-02-17 14:44:07','2023-02-17 14:44:07',NULL,1),
(53,'Client Care',NULL,1,'2023-02-17 14:44:51','2023-02-17 14:44:51',NULL,1),
(54,'Customer Delight',NULL,1,'2023-02-17 14:45:08','2023-02-17 14:45:08',NULL,1),
(55,'Cloud Consultant',NULL,1,'2023-02-17 14:45:27','2023-02-17 14:45:27',NULL,1),
(56,'Cloud Reliability Engineer',NULL,1,'2023-02-17 14:45:49','2023-02-17 14:45:49',NULL,1),
(57,'Cloud Architect',NULL,1,'2023-02-17 14:46:06','2023-02-17 14:46:06',NULL,1),
(58,'Network Analyst',NULL,1,'2023-02-17 14:46:27','2023-02-17 14:46:27',NULL,1),
(59,'Wireless Network Engineer',NULL,1,'2023-02-17 14:46:53','2023-02-17 14:46:53',NULL,1),
(60,'Associate Product Manager',NULL,1,'2023-02-17 14:47:19','2023-02-17 14:47:19',NULL,1),
(61,'Chief Product officer',NULL,1,'2023-02-17 14:47:37','2023-02-17 14:47:37',NULL,1),
(62,'Senior Product Manager',NULL,1,'2023-02-17 14:48:44','2023-02-17 14:48:44',NULL,1),
(63,'Computer & Information Systems Manager',NULL,1,'2023-02-17 14:49:22','2023-02-17 14:49:22',NULL,1),
(64,'Computer Programmer',NULL,1,'2023-02-17 14:50:18','2023-02-17 14:50:18',NULL,1),
(65,'Computer Network Architect',NULL,1,'2023-02-17 14:51:24','2023-02-17 14:51:24',NULL,1),
(66,'Project Scheduler',NULL,1,'2023-02-17 14:51:40','2023-02-17 14:51:40',NULL,1),
(67,'Project Co-ordinator',NULL,1,'2023-02-17 14:51:59','2023-02-17 14:51:59',NULL,1),
(68,'Assistant Project Manager',NULL,1,'2023-02-17 14:52:17','2023-02-17 14:52:17',NULL,1),
(69,'Development new',NULL,1,'2023-02-20 18:50:28','2023-02-20 13:20:28',NULL,1);

/*Table structure for table `document_types` */

DROP TABLE IF EXISTS `document_types`;

CREATE TABLE `document_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `workflow_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_types_workflow_id_foreign` (`workflow_id`),
  CONSTRAINT `document_types_workflow_id_foreign` FOREIGN KEY (`workflow_id`) REFERENCES `workflows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `document_types` */

insert  into `document_types`(`id`,`name`,`description`,`is_active`,`workflow_id`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'sample',NULL,1,1,NULL,NULL,NULL);

/*Table structure for table `employee_types` */

DROP TABLE IF EXISTS `employee_types`;

CREATE TABLE `employee_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employee_types` */

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `sap_id` int(11) NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sign_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_flag` int(11) DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_department_id_foreign` (`department_id`),
  KEY `employees_designation_id_foreign` (`designation_id`),
  CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employees_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employees` */

insert  into `employees`(`id`,`first_name`,`middle_name`,`last_name`,`email`,`mobile`,`department_id`,`designation_id`,`sap_id`,`profile_image`,`sign_image`,`address`,`delete_flag`,`is_active`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Dhana',NULL,'raj','dhana@gmail.com','9698526374',8,8,7927,NULL,NULL,'trichy',0,1,NULL,NULL,NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2023_02_17_072913_create_authority_types_table',1),
(2,'2023_02_17_072938_create_departments_table',1),
(3,'2023_02_17_072954_create_designatios_table',1),
(4,'2023_02_17_073204_create_employee_types_table',1),
(5,'2023_02_17_073335_create_workflows_table',1),
(6,'2023_02_17_073350_create_workflow_levels_table',1),
(7,'2023_02_17_073391_create_workflow_level_details_table',1),
(8,'2023_02_17_073392_create_document_types_table',1),
(9,'2023_02_17_073624_create_employees_table',1),
(10,'2023_02_17_073840_create_projects_table',1),
(11,'2023_02_17_074009_create_project_documents_table',1),
(12,'2023_02_17_074142_create_project_document_details_table',1),
(13,'2023_02_17_074214_create_project_levels_table',1),
(14,'2023_02_17_074229_create_project_milestones_table',1),
(15,'2023_02_17_074344_create_user_authorities_table',1),
(16,'2023_02_17_074401_create_users_table',1),
(17,'2023_02_17_074536_create_project_approvers_table',1),
(18,'2019_12_14_000001_create_personal_access_tokens_table',2),
(19,'2023_02_20_061331_create_permission_tables',2);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `team_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`team_id`,`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  KEY `model_has_permissions_permission_id_foreign` (`permission_id`),
  KEY `model_has_permissions_team_foreign_key_index` (`team_id`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `team_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`team_id`,`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  KEY `model_has_roles_role_id_foreign` (`role_id`),
  KEY `model_has_roles_team_foreign_key_index` (`team_id`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

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

/*Table structure for table `project_approvers` */

DROP TABLE IF EXISTS `project_approvers`;

CREATE TABLE `project_approvers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `project_level_id` int(11) NOT NULL,
  `approver_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_approvers_project_id_foreign` (`project_id`),
  KEY `project_approvers_project_level_id_foreign` (`project_level_id`),
  KEY `project_approvers_designation_id_foreign` (`designation_id`),
  CONSTRAINT `project_approvers_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `project_approvers_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `project_approvers_project_level_id_foreign` FOREIGN KEY (`project_level_id`) REFERENCES `project_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project_approvers` */

/*Table structure for table `project_document_details` */

DROP TABLE IF EXISTS `project_document_details`;

CREATE TABLE `project_document_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) DEFAULT NULL,
  `project_doc_id` int(11) NOT NULL,
  `document_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_document_details_project_doc_id_foreign` (`project_doc_id`),
  CONSTRAINT `project_document_details_project_doc_id_foreign` FOREIGN KEY (`project_doc_id`) REFERENCES `project_documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project_document_details` */

/*Table structure for table `project_documents` */

DROP TABLE IF EXISTS `project_documents`;

CREATE TABLE `project_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `project_level` int(11) NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_latest` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_documents_project_id_foreign` (`project_id`),
  CONSTRAINT `project_documents_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project_documents` */

/*Table structure for table `project_levels` */

DROP TABLE IF EXISTS `project_levels`;

CREATE TABLE `project_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `project_level` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `staff` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_levels_project_id_foreign` (`project_id`),
  CONSTRAINT `project_levels_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project_levels` */

/*Table structure for table `project_milestones` */

DROP TABLE IF EXISTS `project_milestones`;

CREATE TABLE `project_milestones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `milestone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mile_start_date` date NOT NULL,
  `mile_end_date` date NOT NULL,
  `levels_to_be_crossed` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_milestones_project_id_foreign` (`project_id`),
  CONSTRAINT `project_milestones_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `project_milestones` */

/*Table structure for table `projects` */

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `initiator_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `workflow_id` int(11) NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_flag` int(11) DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_initiator_id_foreign` (`initiator_id`),
  KEY `projects_document_type_id_foreign` (`document_type_id`),
  KEY `projects_workflow_id_foreign` (`workflow_id`),
  CONSTRAINT `projects_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `projects_initiator_id_foreign` FOREIGN KEY (`initiator_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `projects_workflow_id_foreign` FOREIGN KEY (`workflow_id`) REFERENCES `workflows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_team_id_name_guard_name_unique` (`team_id`,`name`,`guard_name`),
  KEY `roles_team_foreign_key_index` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

/*Table structure for table `user_authorities` */

DROP TABLE IF EXISTS `user_authorities`;

CREATE TABLE `user_authorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth_type_id` int(11) NOT NULL,
  `employee_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_authorities_auth_type_id_foreign` (`auth_type_id`),
  KEY `user_authorities_employee_type_id_foreign` (`employee_type_id`),
  CONSTRAINT `user_authorities_auth_type_id_foreign` FOREIGN KEY (`auth_type_id`) REFERENCES `authority_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_authorities_employee_type_id_foreign` FOREIGN KEY (`employee_type_id`) REFERENCES `employee_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_authorities` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` date DEFAULT NULL,
  `is_admin` int(11) DEFAULT NULL,
  `is_super_admin` int(11) DEFAULT NULL,
  `auth_level` int(11) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `authority_type` int(11) DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`email`,`email_verified_at`,`is_admin`,`is_super_admin`,`auth_level`,`password`,`emp_id`,`authority_type`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Admin','admin','admin@gmail.com',NULL,1,1,9,'$2y$10$VPQf8hIEFxWpTgHGQXhSC.APvrYlbOCh77zH2PgQS4jhB.oX2P2Vu',NULL,NULL,NULL,'2023-02-21 10:30:01','2023-02-21 10:30:01',NULL);

/*Table structure for table `workflow_level_details` */

DROP TABLE IF EXISTS `workflow_level_details`;

CREATE TABLE `workflow_level_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workflow_id` int(11) NOT NULL,
  `workflow_level_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_level_details_workflow_id_foreign` (`workflow_id`),
  KEY `workflow_level_details_workflow_level_id_foreign` (`workflow_level_id`),
  KEY `workflow_level_details_designation_id_foreign` (`designation_id`),
  CONSTRAINT `workflow_level_details_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `workflow_level_details_workflow_id_foreign` FOREIGN KEY (`workflow_id`) REFERENCES `workflows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `workflow_level_details_workflow_level_id_foreign` FOREIGN KEY (`workflow_level_id`) REFERENCES `workflow_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `workflow_level_details` */

insert  into `workflow_level_details`(`id`,`workflow_id`,`workflow_level_id`,`designation_id`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,1,8,'2023-02-21 10:34:04','2023-02-21 10:34:04',NULL),
(2,1,1,9,'2023-02-21 10:34:04','2023-02-21 10:34:04',NULL),
(3,1,1,10,'2023-02-21 10:34:04','2023-02-21 10:34:04',NULL),
(4,1,2,8,'2023-02-21 10:34:04','2023-02-21 10:34:04',NULL),
(5,1,2,9,'2023-02-21 10:34:04','2023-02-21 10:34:04',NULL),
(6,1,2,10,'2023-02-21 10:34:04','2023-02-21 10:34:04',NULL);

/*Table structure for table `workflow_levels` */

DROP TABLE IF EXISTS `workflow_levels`;

CREATE TABLE `workflow_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workflow_id` int(11) NOT NULL,
  `levels` int(11) NOT NULL,
  `approver_designation` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_levels_workflow_id_foreign` (`workflow_id`),
  CONSTRAINT `workflow_levels_workflow_id_foreign` FOREIGN KEY (`workflow_id`) REFERENCES `workflows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `workflow_levels` */

insert  into `workflow_levels`(`id`,`workflow_id`,`levels`,`approver_designation`,`is_active`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,6,NULL,1,'2023-02-21 10:34:04','2023-02-21 10:34:04',NULL),
(2,1,10,NULL,1,'2023-02-21 10:34:04','2023-02-21 10:34:04',NULL);

/*Table structure for table `workflows` */

DROP TABLE IF EXISTS `workflows`;

CREATE TABLE `workflows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workflow_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workflow_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workflow_type` int(11) NOT NULL,
  `total_levels` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `workflows` */

insert  into `workflows`(`id`,`workflow_code`,`workflow_name`,`workflow_type`,`total_levels`,`is_active`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'1234','testwf',0,2,1,'2023-02-21 10:34:04','2023-02-21 10:34:04',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
