# Host: 127.0.0.1  (Version 5.5.5-10.4.32-MariaDB)
# Date: 2026-05-10 11:27:58
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "doctor_availabilities"
#

DROP TABLE IF EXISTS `doctor_availabilities`;
CREATE TABLE `doctor_availabilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `available_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `slot_duration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_availabilities_doctor_id_available_date_index` (`doctor_id`,`available_date`),
  CONSTRAINT `doctor_availabilities_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "doctor_availabilities"
#

INSERT INTO `doctor_availabilities` VALUES (3,5,'2026-05-29','10:00:00','13:00:00',30,'2026-05-10 05:42:20','2026-05-10 05:42:20');

#
# Structure for table "doctors"
#

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE `doctors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctors_mobile_no_unique` (`mobile_no`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "doctors"
#

INSERT INTO `doctors` VALUES (4,'Dr. Rohit Sharma','9876543210',NULL,'Dentist','2026-05-10 05:38:05','2026-05-10 05:38:05'),(5,'Dr. Sunil Sharma','8411077371','raj@gmail.com','Dentist','2026-05-10 05:38:29','2026-05-10 05:41:50'),(6,'Dr. Rajesh Chavan','8400160606','rajesh@gmail.com','Dentist','2026-05-10 05:40:08','2026-05-10 05:40:08');

#
# Structure for table "appointments"
#

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patient_email` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `booking_reference` varchar(255) NOT NULL,
  `status` enum('booked','cancelled') NOT NULL DEFAULT 'booked',
  `cancellation_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `appointments_doctor_id_appointment_date_start_time_unique` (`doctor_id`,`appointment_date`,`start_time`),
  UNIQUE KEY `appointments_booking_reference_unique` (`booking_reference`),
  CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "appointments"
#

INSERT INTO `appointments` VALUES (9,5,'Rahul Sharma','rahul@gmail.com','2026-05-15','10:00:00','10:30:00','OKE89K2X7Z','booked',NULL,'2026-05-10 05:44:26','2026-05-10 05:44:26'),(10,5,'Rahul Sharma','rahul@gmail.com','2026-05-26','10:00:00','10:30:00','08H3BCVYJF','booked',NULL,'2026-05-10 05:48:26','2026-05-10 05:48:26');

#
# Structure for table "failed_jobs"
#

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "failed_jobs"
#


#
# Structure for table "jobs"
#

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "jobs"
#


#
# Structure for table "migrations"
#

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "migrations"
#

INSERT INTO `migrations` VALUES (31,'2014_10_12_000000_create_users_table',1),(32,'2014_10_12_100000_create_password_reset_tokens_table',1),(33,'2019_08_19_000000_create_failed_jobs_table',1),(34,'2019_12_14_000001_create_personal_access_tokens_table',1),(35,'2026_05_09_064352_create_doctors_table',1),(36,'2026_05_09_100843_create_appointments_table',2),(37,'2026_05_09_101041_create_notifications_table',2),(38,'2026_05_09_102000_create_doctor_availabilities_table',3),(39,'2026_05_10_052111_add_email_to_doctors_table',4),(40,'2026_05_10_054625_create_jobs_table',5);

#
# Structure for table "notifications"
#

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "notifications"
#

INSERT INTO `notifications` VALUES ('15776644-a6bf-4e97-bb90-c48b163743ec','App\\Notifications\\AppointmentBookedNotification','App\\Models\\Doctor',5,'{\"message\":\"Your Appointment booked successfully\",\"booking_reference\":\"08H3BCVYJF\",\"appointment_date\":\"2026-05-26\",\"start_time\":\"10:00:00\"}',NULL,'2026-05-10 05:48:30','2026-05-10 05:48:30');

#
# Structure for table "password_reset_tokens"
#

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "password_reset_tokens"
#


#
# Structure for table "personal_access_tokens"
#

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "personal_access_tokens"
#


#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "users"
#

