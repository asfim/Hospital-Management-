-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: diagnostic
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admissions`
--

DROP TABLE IF EXISTS `admissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_no` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `referred_by` varchar(255) DEFAULT NULL,
  `ward_id` bigint(20) unsigned DEFAULT NULL,
  `bed_id` bigint(20) unsigned DEFAULT NULL,
  `admission_date` datetime NOT NULL,
  `discharge_date` datetime DEFAULT NULL,
  `admission_reason` varchar(255) DEFAULT NULL,
  `provisional_diagnosis` text DEFAULT NULL,
  `final_diagnosis` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'admitted',
  `total_deposit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_billed` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admissions_admission_no_unique` (`admission_no`),
  KEY `admissions_patient_id_foreign` (`patient_id`),
  KEY `admissions_doctor_id_foreign` (`doctor_id`),
  KEY `admissions_ward_id_foreign` (`ward_id`),
  KEY `admissions_bed_id_foreign` (`bed_id`),
  CONSTRAINT `admissions_bed_id_foreign` FOREIGN KEY (`bed_id`) REFERENCES `beds` (`id`) ON DELETE SET NULL,
  CONSTRAINT `admissions_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `admissions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `admissions_ward_id_foreign` FOREIGN KEY (`ward_id`) REFERENCES `wards` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admissions`
--

LOCK TABLES `admissions` WRITE;
/*!40000 ALTER TABLE `admissions` DISABLE KEYS */;
INSERT INTO `admissions` VALUES (1,'ADM-TEST-4984',1,1,NULL,1,2,'2026-11-17 00:00:00','2026-11-17 00:00:00',NULL,'Acute Respiratory Distress Syndrome (ARDS)',NULL,'discharged',15000.00,0.00,0.00,0.00,NULL,'2026-11-17 01:13:23','2026-11-17 01:13:23'),(2,'ADM-TEST-9213',1,1,NULL,1,2,'2026-11-17 00:00:00','2026-11-17 00:00:00',NULL,'Acute Respiratory Distress Syndrome (ARDS)',NULL,'discharged',15000.00,0.00,0.00,0.00,NULL,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(3,'ADM-TEST-6210',1,1,NULL,1,2,'2026-11-17 00:00:00','2026-11-17 00:00:00',NULL,'Acute Respiratory Distress Syndrome (ARDS)',NULL,'discharged',15000.00,0.00,0.00,0.00,NULL,'2026-11-17 01:14:24','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `admissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ambulance_requests`
--

DROP TABLE IF EXISTS `ambulance_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ambulance_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `request_no` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `ambulance_vehicle_id` bigint(20) unsigned DEFAULT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `distance_km` decimal(6,2) DEFAULT NULL,
  `fare_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `requested_at` datetime NOT NULL,
  `completed_at` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ambulance_requests_request_no_unique` (`request_no`),
  KEY `ambulance_requests_patient_id_foreign` (`patient_id`),
  KEY `ambulance_requests_ambulance_vehicle_id_foreign` (`ambulance_vehicle_id`),
  CONSTRAINT `ambulance_requests_ambulance_vehicle_id_foreign` FOREIGN KEY (`ambulance_vehicle_id`) REFERENCES `ambulance_vehicles` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ambulance_requests_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ambulance_requests`
--

LOCK TABLES `ambulance_requests` WRITE;
/*!40000 ALTER TABLE `ambulance_requests` DISABLE KEYS */;
INSERT INTO `ambulance_requests` VALUES (1,'AMB-TEST-4963',1,3,'Bashir Ahmed','01899887766','Uttara Sector 7, Dhaka','Main Hospital ER Gate',NULL,4500.00,4500.00,'completed','2026-11-17 07:14:12','2026-11-17 07:14:12',NULL,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(2,'AMB-TEST-2041',1,4,'Bashir Ahmed','01899887766','Uttara Sector 7, Dhaka','Main Hospital ER Gate',NULL,4500.00,4500.00,'completed','2026-11-17 07:14:25','2026-11-17 07:14:25',NULL,'2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `ambulance_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ambulance_vehicles`
--

DROP TABLE IF EXISTS `ambulance_vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ambulance_vehicles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_number` varchar(255) NOT NULL,
  `vehicle_model` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Basic',
  `driver_name` varchar(255) NOT NULL,
  `driver_phone` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `standard_fare` decimal(10,2) NOT NULL DEFAULT 0.00,
  `per_km_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ambulance_vehicles_vehicle_number_unique` (`vehicle_number`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ambulance_vehicles`
--

LOCK TABLES `ambulance_vehicles` WRITE;
/*!40000 ALTER TABLE `ambulance_vehicles` DISABLE KEYS */;
INSERT INTO `ambulance_vehicles` VALUES (1,'DHA-MET-CHA-11-2024','Toyota HiAce Ambulance','Advanced Life Support','Md. Rafiqul Islam','01712345678','available',2500.00,35.00,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(2,'DHA-MET-CHA-11-2025','Hyundai H1 Ambulance','Basic Life Support','Md. Jahangir Alam','01812345678','available',1500.00,25.00,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(3,'DHAKA-METRO-CHA-TEST-877','Toyota Hiace Ambulance','ICU / Cardiac Support','Md. Faruk Hossain','01712345678','available',3500.00,60.00,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(4,'DHAKA-METRO-CHA-TEST-485','Toyota Hiace Ambulance','ICU / Cardiac Support','Md. Faruk Hossain','01712345678','available',3500.00,60.00,'2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `ambulance_vehicles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `appointment_id` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `appointment_type` varchar(255) NOT NULL DEFAULT 'New',
  `consultation_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `due` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `appointments_appointment_id_unique` (`appointment_id`),
  KEY `appointments_patient_id_foreign` (`patient_id`),
  KEY `appointments_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` VALUES (1,'APT-260916-0001',1,1,'2026-09-16','10:00:00',NULL,'New',0.00,0.00,0.00,0.00,'Pending',NULL,'2026-09-16 00:57:18','2026-09-16 00:57:18'),(2,'APT-260916-0002',1,1,'2026-09-16','15:42:00','2','Follow-up',500.00,0.00,500.00,0.00,'Pending',NULL,'2026-09-16 03:42:55','2026-09-16 03:42:55'),(3,'APT-260917-0003',1,3,'2026-09-17','10:44:00','3','New',500.00,50.00,450.00,0.00,'Confirmed',NULL,'2026-09-16 22:44:25','2026-09-16 23:21:57');
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `record_id` bigint(20) unsigned DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bed_transfers`
--

DROP TABLE IF EXISTS `bed_transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bed_transfers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_id` bigint(20) unsigned NOT NULL,
  `from_bed_id` bigint(20) unsigned DEFAULT NULL,
  `to_bed_id` bigint(20) unsigned NOT NULL,
  `transferred_at` datetime NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `transferred_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bed_transfers_admission_id_foreign` (`admission_id`),
  KEY `bed_transfers_from_bed_id_foreign` (`from_bed_id`),
  KEY `bed_transfers_to_bed_id_foreign` (`to_bed_id`),
  CONSTRAINT `bed_transfers_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bed_transfers_from_bed_id_foreign` FOREIGN KEY (`from_bed_id`) REFERENCES `beds` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bed_transfers_to_bed_id_foreign` FOREIGN KEY (`to_bed_id`) REFERENCES `beds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bed_transfers`
--

LOCK TABLES `bed_transfers` WRITE;
/*!40000 ALTER TABLE `bed_transfers` DISABLE KEYS */;
INSERT INTO `bed_transfers` VALUES (1,1,1,2,'2026-11-17 07:13:23','Transferred from General Ward to ICU Step-Down',1,'2026-11-17 01:13:23','2026-11-17 01:13:23'),(2,2,1,2,'2026-11-17 07:14:12','Transferred from General Ward to ICU Step-Down',1,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(3,3,1,2,'2026-11-17 07:14:24','Transferred from General Ward to ICU Step-Down',1,'2026-11-17 01:14:24','2026-11-17 01:14:24');
/*!40000 ALTER TABLE `bed_transfers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beds`
--

DROP TABLE IF EXISTS `beds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ward_id` bigint(20) unsigned NOT NULL,
  `bed_number` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Standard',
  `daily_charge` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `current_admission_id` bigint(20) unsigned DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `beds_ward_id_foreign` (`ward_id`),
  CONSTRAINT `beds_ward_id_foreign` FOREIGN KEY (`ward_id`) REFERENCES `wards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beds`
--

LOCK TABLES `beds` WRITE;
/*!40000 ALTER TABLE `beds` DISABLE KEYS */;
INSERT INTO `beds` VALUES (1,1,'GWM-01-B01','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 01:14:24'),(2,1,'GWM-01-B02','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 01:14:25'),(3,1,'GWM-01-B03','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(4,1,'GWM-01-B04','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(5,1,'GWM-01-B05','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(6,1,'GWM-01-B06','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(7,1,'GWM-01-B07','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(8,1,'GWM-01-B08','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(9,1,'GWM-01-B09','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(10,1,'GWM-01-B10','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(11,2,'GWF-01-B01','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(12,2,'GWF-01-B02','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(13,2,'GWF-01-B03','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(14,2,'GWF-01-B04','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(15,2,'GWF-01-B05','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(16,2,'GWF-01-B06','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(17,2,'GWF-01-B07','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(18,2,'GWF-01-B08','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(19,2,'GWF-01-B09','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(20,2,'GWF-01-B10','Standard Hospital Bed',800.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(21,3,'ICU-01-B01','ICU Bed',5000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(22,3,'ICU-01-B02','ICU Bed',5000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(23,3,'ICU-01-B03','ICU Bed',5000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(24,3,'ICU-01-B04','ICU Bed',5000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(25,3,'ICU-01-B05','ICU Bed',5000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(26,3,'ICU-01-B06','ICU Bed',5000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(27,4,'CCU-01-B01','ICU Bed',4500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(28,4,'CCU-01-B02','ICU Bed',4500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(29,4,'CCU-01-B03','ICU Bed',4500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(30,4,'CCU-01-B04','ICU Bed',4500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(31,4,'CCU-01-B05','ICU Bed',4500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(32,4,'CCU-01-B06','ICU Bed',4500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(33,5,'CAB-VIP-B01','Standard Hospital Bed',3500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(34,5,'CAB-VIP-B02','Standard Hospital Bed',3500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(35,5,'CAB-VIP-B03','Standard Hospital Bed',3500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(36,5,'CAB-VIP-B04','Standard Hospital Bed',3500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(37,5,'CAB-VIP-B05','Standard Hospital Bed',3500.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(38,6,'NICU-01-B01','Standard Hospital Bed',4000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(39,6,'NICU-01-B02','Standard Hospital Bed',4000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(40,6,'NICU-01-B03','Standard Hospital Bed',4000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(41,6,'NICU-01-B04','Standard Hospital Bed',4000.00,'available',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34');
/*!40000 ALTER TABLE `beds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `birth_records`
--

DROP TABLE IF EXISTS `birth_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `birth_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `record_no` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `baby_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL DEFAULT 'Male',
  `birth_date` date NOT NULL,
  `birth_time` time DEFAULT NULL,
  `weight_kg` decimal(4,2) DEFAULT NULL,
  `mother_name` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `birth_records_record_no_unique` (`record_no`),
  KEY `birth_records_patient_id_foreign` (`patient_id`),
  KEY `birth_records_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `birth_records_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `birth_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `birth_records`
--

LOCK TABLES `birth_records` WRITE;
/*!40000 ALTER TABLE `birth_records` DISABLE KEYS */;
INSERT INTO `birth_records` VALUES (1,'BRT-TEST-6563',NULL,'Baby of Nusrat','Female','2026-11-17','06:45:00',3.25,'Nusrat Jahan','Tareq Mahmud',1,'Normal vaginal delivery, healthy APGAR score 9/10','2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `birth_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Health Tips',
  `excerpt` text NOT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `published_at` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blogs_published_at_index` (`published_at`),
  KEY `blogs_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (1,'Quia qui hic et moll','Pariatur Culpa rer','Excepteur est iste dolorem ipsam animi est at ipsam animi','Earum eiusmod qui co','blogs/XX2hM2JqQTfKlqYppGCO0rCZA9G30L9oHRTpm36i.jpg','1999-05-02',1,'2026-09-23 03:16:08','2026-09-23 03:16:08'),(2,'Tempor vel amet ven','Quia odio sed aliqua','Corporis quaerat sit eum ipsam sapiente deserunt hic ratione enim rerum voluptas laborum Ea','Sint Nam ipsam exce','blogs/nQkF7tm6a5PnUdveALBuIStrzYLiJf78u9hlsuRG.webp','2001-08-14',1,'2026-09-23 03:16:21','2026-09-23 03:16:21'),(3,'Ut possimus proiden','Sapiente ut aliqua','Quasi elit ut ratione molestiae eos','Quibusdam commodo vo','blogs/CQb4CQxka7H3EO61y7ohobym7Q0QQxk6pLLO0gkv.jpg','2007-10-25',1,'2026-09-23 03:16:33','2026-09-23 03:16:33'),(4,'Laborum in odio nost','Aliquid nisi corpori','Praesentium sunt ipsum velit laboris','Rerum ut et facilis','blogs/uOaU1h2yTj4XupIXtxNvU2w4ByqiTbIVJo51oHuv.jpg','2020-09-11',1,'2026-09-23 03:16:43','2026-09-23 03:16:43');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blood_donors`
--

DROP TABLE IF EXISTS `blood_donors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blood_donors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `donor_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL DEFAULT 'Male',
  `age` int(11) DEFAULT NULL,
  `blood_group` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `last_donated_at` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Eligible',
  `medical_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blood_donors_donor_code_unique` (`donor_code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blood_donors`
--

LOCK TABLES `blood_donors` WRITE;
/*!40000 ALTER TABLE `blood_donors` DISABLE KEYS */;
INSERT INTO `blood_donors` VALUES (1,'BD-0001','Kamal Hossain','Male',28,'O+','01700112233',NULL,'Mirpur-10, Dhaka',NULL,'Eligible',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(2,'BD-0002','Tanvir Ahmed','Male',32,'A+','01811223344',NULL,'Uttara, Dhaka',NULL,'Eligible',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(3,'BD-0003','Shakil Mahmud','Male',25,'B+','01922334455',NULL,'Dhanmondi, Dhaka',NULL,'Eligible',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(4,'DNR-TEST-5918','MD. Shafiul Alam','Male',26,'O+','01799887766',NULL,NULL,NULL,'Eligible',NULL,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(5,'DNR-TEST-1073','MD. Shafiul Alam','Male',26,'O+','01799887766',NULL,NULL,NULL,'Eligible',NULL,'2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `blood_donors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blood_inventories`
--

DROP TABLE IF EXISTS `blood_inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blood_inventories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bag_number` varchar(255) NOT NULL,
  `blood_group` varchar(255) NOT NULL,
  `component_type` varchar(255) NOT NULL DEFAULT 'Whole Blood',
  `donor_id` bigint(20) unsigned DEFAULT NULL,
  `collected_at` date NOT NULL,
  `expiry_date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `storage_location` varchar(255) DEFAULT NULL,
  `issued_to_patient_id` bigint(20) unsigned DEFAULT NULL,
  `issued_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blood_inventories_bag_number_unique` (`bag_number`),
  KEY `blood_inventories_donor_id_foreign` (`donor_id`),
  CONSTRAINT `blood_inventories_donor_id_foreign` FOREIGN KEY (`donor_id`) REFERENCES `blood_donors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blood_inventories`
--

LOCK TABLES `blood_inventories` WRITE;
/*!40000 ALTER TABLE `blood_inventories` DISABLE KEYS */;
INSERT INTO `blood_inventories` VALUES (1,'BAG-2026-44932','O+','Whole Blood',1,'2026-11-12','2026-12-17','available','Blood Bank Refrigerator #1',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(2,'BAG-2026-58127','A+','Whole Blood',2,'2026-11-12','2026-12-17','available','Blood Bank Refrigerator #1',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(3,'BAG-2026-45325','B+','Whole Blood',3,'2026-11-12','2026-12-17','available','Blood Bank Refrigerator #1',NULL,NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(4,'BAG-TEST-5057','O+','Whole Blood',4,'2026-11-17','2026-12-22','issued','Blood Refrigerator 1, Shelf A',1,'2026-11-17 07:14:12','2026-11-17 01:14:12','2026-11-17 01:14:12'),(5,'BAG-TEST-2330','O+','Whole Blood',5,'2026-11-17','2026-12-22','issued','Blood Refrigerator 1, Shelf A',1,'2026-11-17 07:14:25','2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `blood_inventories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `opening_hours` varchar(255) DEFAULT NULL,
  `map_link` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_upcoming` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,'Dhaka Main Center','123 Health Avenue, Dhanmondi, Dhaka 1205','+880 2 1234 5678','dhaka@medidiag.com','https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=600&q=80','Headquarters','Open 24/7','https://maps.google.com',1,0,NULL,1,'2026-09-23 03:54:49','2026-09-23 03:54:49'),(2,'Chattogram Branch','45 GEC Circle, CDA Avenue, Chattogram','+880 31 9876 5432','ctg@medidiag.com','https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=600&q=80','Regional Center','8:00 AM - 10:00 PM','https://maps.google.com',1,0,NULL,2,'2026-09-23 03:54:49','2026-09-23 03:54:49'),(3,'Sylhet Branch','78 Zindabazar, Sylhet City Center','+880 821 5555 6666','sylhet@medidiag.com','https://images.unsplash.com/photo-1538108149393-fbbd81895907?auto=format&fit=crop&w=600&q=80','New Center','9:00 AM - 9:00 PM','https://maps.google.com',1,0,NULL,3,'2026-09-23 03:54:49','2026-09-23 03:54:49'),(4,'Rajshahi Branch','Greater Road, Rajshahi','+880 721 1122 3344','rajshahi@medidiag.com',NULL,'Coming Soon','Opening Soon',NULL,1,1,'Opening soon in early 2027 to serve the northern region!',4,'2026-09-23 03:54:49','2026-09-23 03:54:49');
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('clinic-erp-cache-admin@1.com|127.0.0.1','i:1;',1789900323),('clinic-erp-cache-admin@1.com|127.0.0.1:timer','i:1789900323;',1789900323),('clinic-erp-cache-site_settings','a:8:{s:9:\"site_name\";s:8:\"MediDiag\";s:12:\"site_tagline\";s:19:\"Diagnostic & Clinic\";s:10:\"site_phone\";s:17:\"+880 1711 000 000\";s:10:\"site_email\";s:17:\"info@medidiag.com\";s:12:\"site_address\";s:40:\"123 Health Avenue, Dhanmondi, Dhaka-1205\";s:9:\"site_logo\";s:53:\"settings/YfPUul1pVpZLvQ0cqc3zaMD2CXWS7YbunWpa4tza.png\";s:12:\"site_favicon\";s:0:\"\";s:13:\"site_whatsapp\";N;}',2105586741);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_charges`
--

DROP TABLE IF EXISTS `daily_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_charges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_id` bigint(20) unsigned NOT NULL,
  `charge_date` date NOT NULL,
  `charge_type` varchar(255) NOT NULL DEFAULT 'bed',
  `description` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daily_charges_admission_id_foreign` (`admission_id`),
  CONSTRAINT `daily_charges_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_charges`
--

LOCK TABLES `daily_charges` WRITE;
/*!40000 ALTER TABLE `daily_charges` DISABLE KEYS */;
INSERT INTO `daily_charges` VALUES (1,1,'2026-11-17','Bed Charge','Cabin AC Daily Room Rent',2500.00,1,'2026-11-17 01:13:23','2026-11-17 01:13:23'),(2,2,'2026-11-17','Bed Charge','Cabin AC Daily Room Rent',2500.00,1,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(3,3,'2026-11-17','Bed Charge','Cabin AC Daily Room Rent',2500.00,1,'2026-11-17 01:14:24','2026-11-17 01:14:24');
/*!40000 ALTER TABLE `daily_charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `death_records`
--

DROP TABLE IF EXISTS `death_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `death_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `record_no` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `admission_id` bigint(20) unsigned DEFAULT NULL,
  `death_date` date NOT NULL,
  `death_time` time DEFAULT NULL,
  `cause_of_death` text NOT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `death_records_record_no_unique` (`record_no`),
  KEY `death_records_patient_id_foreign` (`patient_id`),
  KEY `death_records_admission_id_foreign` (`admission_id`),
  KEY `death_records_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `death_records_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `death_records_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `death_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `death_records`
--

LOCK TABLES `death_records` WRITE;
/*!40000 ALTER TABLE `death_records` DISABLE KEYS */;
INSERT INTO `death_records` VALUES (1,'DTH-TEST-3497',1,NULL,'2026-11-17','14:20:00','Septic Shock secondary to perforated appendicitis',1,'Resuscitation attempted for 45 mins, no response. Pronounced dead at 14:20.','2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `death_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_name_unique` (`name`),
  UNIQUE KEY `departments_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Pathology','pathology','Pathology Department',NULL,NULL,1,'2026-09-16 00:57:18','2026-09-16 00:57:18'),(2,'Radiology','radiology',NULL,NULL,NULL,1,'2026-09-20 02:53:06','2026-09-20 02:53:06'),(3,'Cardiology','cardiology',NULL,NULL,NULL,1,'2026-09-20 02:53:06','2026-09-20 02:53:06');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnoses`
--

DROP TABLE IF EXISTS `diagnoses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diagnoses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnoses`
--

LOCK TABLES `diagnoses` WRITE;
/*!40000 ALTER TABLE `diagnoses` DISABLE KEYS */;
/*!40000 ALTER TABLE `diagnoses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostic_order_items`
--

DROP TABLE IF EXISTS `diagnostic_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diagnostic_order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `diagnostic_order_id` bigint(20) unsigned NOT NULL,
  `test_id` bigint(20) unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `diagnostic_order_items_diagnostic_order_id_foreign` (`diagnostic_order_id`),
  KEY `diagnostic_order_items_test_id_foreign` (`test_id`),
  CONSTRAINT `diagnostic_order_items_diagnostic_order_id_foreign` FOREIGN KEY (`diagnostic_order_id`) REFERENCES `diagnostic_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `diagnostic_order_items_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostic_order_items`
--

LOCK TABLES `diagnostic_order_items` WRITE;
/*!40000 ALTER TABLE `diagnostic_order_items` DISABLE KEYS */;
INSERT INTO `diagnostic_order_items` VALUES (9,1,1,500.00,'Pending','2026-09-22 23:34:39','2026-09-22 23:34:39'),(11,2,1,500.00,'Pending','2026-09-22 23:35:20','2026-09-22 23:35:20');
/*!40000 ALTER TABLE `diagnostic_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostic_orders`
--

DROP TABLE IF EXISTS `diagnostic_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diagnostic_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `order_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `due_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(255) NOT NULL DEFAULT 'Unpaid',
  `order_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `diagnostic_orders_order_id_unique` (`order_id`),
  KEY `diagnostic_orders_patient_id_foreign` (`patient_id`),
  KEY `diagnostic_orders_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `diagnostic_orders_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `diagnostic_orders_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostic_orders`
--

LOCK TABLES `diagnostic_orders` WRITE;
/*!40000 ALTER TABLE `diagnostic_orders` DISABLE KEYS */;
INSERT INTO `diagnostic_orders` VALUES (1,'ORD-260916-0001',2,NULL,'2026-09-16',500.00,100.00,400.00,0.00,'Paid','Completed','2026-09-16 00:57:18','2026-09-22 23:36:02'),(2,'ORD-260923-0002',4,NULL,'2026-09-23',500.00,100.00,400.00,0.00,'Paid','Pending','2026-09-22 23:09:15','2026-09-22 23:35:20');
/*!40000 ALTER TABLE `diagnostic_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discharge_summaries`
--

DROP TABLE IF EXISTS `discharge_summaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discharge_summaries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_id` bigint(20) unsigned NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `discharge_date` datetime NOT NULL,
  `final_diagnosis` text DEFAULT NULL,
  `condition_on_discharge` varchar(255) NOT NULL DEFAULT 'Improved',
  `treatment_given` text DEFAULT NULL,
  `discharge_medications` text DEFAULT NULL,
  `dietary_advice` text DEFAULT NULL,
  `activity_advice` text DEFAULT NULL,
  `follow_up_instructions` text DEFAULT NULL,
  `follow_up_date` date DEFAULT NULL,
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discharge_summaries_admission_id_foreign` (`admission_id`),
  KEY `discharge_summaries_patient_id_foreign` (`patient_id`),
  KEY `discharge_summaries_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `discharge_summaries_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `discharge_summaries_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `discharge_summaries_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discharge_summaries`
--

LOCK TABLES `discharge_summaries` WRITE;
/*!40000 ALTER TABLE `discharge_summaries` DISABLE KEYS */;
INSERT INTO `discharge_summaries` VALUES (1,1,1,1,'2026-11-17 00:00:00','Resolved Acute Respiratory Distress Syndrome','Clinically stable and afebrile','Supplemental O2 therapy, IV steroids, nebulization completed','Tab Azithromycin 500mg, Inhaler Salbutamol','Adequate hydration, warm fluid intake','Avoid heavy exertion for 7 days','Follow up in OPD after 7 days','2026-11-24',NULL,NULL,'2026-11-17 01:13:23','2026-11-17 01:13:23'),(2,2,1,1,'2026-11-17 00:00:00','Resolved Acute Respiratory Distress Syndrome','Clinically stable and afebrile','Supplemental O2 therapy, IV steroids, nebulization completed','Tab Azithromycin 500mg, Inhaler Salbutamol','Adequate hydration, warm fluid intake','Avoid heavy exertion for 7 days','Follow up in OPD after 7 days','2026-11-24',NULL,NULL,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(3,3,1,1,'2026-11-17 00:00:00','Resolved Acute Respiratory Distress Syndrome','Clinically stable and afebrile','Supplemental O2 therapy, IV steroids, nebulization completed','Tab Azithromycin 500mg, Inhaler Salbutamol','Adequate hydration, warm fluid intake','Avoid heavy exertion for 7 days','Follow up in OPD after 7 days','2026-11-24',NULL,NULL,'2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `discharge_summaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_commissions`
--

DROP TABLE IF EXISTS `doctor_commissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctor_commissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_commissions`
--

LOCK TABLES `doctor_commissions` WRITE;
/*!40000 ALTER TABLE `doctor_commissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `doctor_commissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_schedules`
--

DROP TABLE IF EXISTS `doctor_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctor_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `day` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `patient_limit` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `room` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_schedules_doctor_id_foreign` (`doctor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_schedules`
--

LOCK TABLES `doctor_schedules` WRITE;
/*!40000 ALTER TABLE `doctor_schedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `doctor_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `doctor_id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `room_no` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `bmdc_reg` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `consultation_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ipd_round_charge` decimal(10,2) NOT NULL DEFAULT 500.00,
  `emergency_charge` decimal(10,2) NOT NULL DEFAULT 1000.00,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doctors_doctor_id_unique` (`doctor_id`),
  KEY `doctors_department_id_foreign` (`department_id`),
  CONSTRAINT `doctors_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctors`
--

LOCK TABLES `doctors` WRITE;
/*!40000 ALTER TABLE `doctors` DISABLE KEYS */;
INSERT INTO `doctors` VALUES (1,NULL,'DR-0001',NULL,'Dr. Abul Hasan','doctors/3FgEqkOCMNfFkae9W7dWZHMLaiTOXDmySP8OA0fi.jpg','Medicine',NULL,NULL,'MBBS, FCPS (Medicine)',NULL,'01711122233','abul@example.com',NULL,1000.00,500.00,1000.00,1,'2026-09-16 00:57:18','2026-09-23 02:27:17'),(2,NULL,'DR-0002',NULL,'Dr. Sadia Islam','doctors/yESvYfEUcZGvf4Z8WsnuYQfeZqcDsduzfemTBRNg.jpg','Gynaecology',NULL,NULL,'MBBS, DGO, MCPS',NULL,'01822233344','sadia@example.com',NULL,1200.00,500.00,1000.00,1,'2026-09-16 00:57:18','2026-09-23 02:27:26'),(3,NULL,'DR-0003',2,'Hasan Parvez','doctors/lco8Hn3YmoHYR6WG7bhS1baR58kRQotJJfw5sC8k.jpg','sex',NULL,NULL,NULL,NULL,'01866700048','admin@example.com',NULL,5000.00,500.00,1000.00,1,'2026-09-16 22:42:35','2026-09-23 22:46:44');
/*!40000 ALTER TABLE `doctors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emergency_cases`
--

DROP TABLE IF EXISTS `emergency_cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emergency_cases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `case_no` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `nurse_id` bigint(20) unsigned DEFAULT NULL,
  `triage_priority` varchar(255) NOT NULL DEFAULT 'yellow',
  `arrival_mode` varchar(255) NOT NULL DEFAULT 'Walk-in',
  `arrival_time` datetime NOT NULL,
  `presenting_complaints` text DEFAULT NULL,
  `treatment_given` text DEFAULT NULL,
  `admission_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'triaged',
  `treatment_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `discharged_at` datetime DEFAULT NULL,
  `discharge_notes` text DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emergency_cases_case_no_unique` (`case_no`),
  KEY `emergency_cases_patient_id_foreign` (`patient_id`),
  KEY `emergency_cases_doctor_id_foreign` (`doctor_id`),
  KEY `emergency_cases_admission_id_foreign` (`admission_id`),
  CONSTRAINT `emergency_cases_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `emergency_cases_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `emergency_cases_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emergency_cases`
--

LOCK TABLES `emergency_cases` WRITE;
/*!40000 ALTER TABLE `emergency_cases` DISABLE KEYS */;
INSERT INTO `emergency_cases` VALUES (1,'EMG-TEST-2440',1,NULL,NULL,'red','Ambulance','2026-11-17 07:08:59','RTA road accident with multiple limb fractures and hypovolemia','IV access established, crystalloid fluid started, splinting applied',NULL,'under_treatment',1500.00,'Pending',NULL,NULL,1,'2026-11-17 01:08:59','2026-11-17 01:08:59'),(2,'EMG-TEST-9079',1,NULL,NULL,'red','Ambulance','2026-11-17 07:13:23','RTA road accident with multiple limb fractures and hypovolemia','IV access established, crystalloid fluid started, splinting applied',NULL,'under_treatment',1500.00,'Pending',NULL,NULL,1,'2026-11-17 01:13:23','2026-11-17 01:13:23'),(3,'EMG-TEST-6070',1,NULL,NULL,'red','Ambulance','2026-11-17 07:14:12','RTA road accident with multiple limb fractures and hypovolemia','IV access established, crystalloid fluid started, splinting applied',NULL,'under_treatment',1500.00,'Pending',NULL,NULL,1,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(4,'EMG-TEST-1605',1,NULL,NULL,'red','Ambulance','2026-11-17 07:14:24','RTA road accident with multiple limb fractures and hypovolemia','IV access established, crystalloid fluid started, splinting applied',NULL,'under_treatment',1500.00,'Pending',NULL,NULL,1,'2026-11-17 01:14:24','2026-11-17 01:14:24');
/*!40000 ALTER TABLE `emergency_cases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_categories`
--

DROP TABLE IF EXISTS `expense_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expense_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_categories`
--

LOCK TABLES `expense_categories` WRITE;
/*!40000 ALTER TABLE `expense_categories` DISABLE KEYS */;
INSERT INTO `expense_categories` VALUES (1,'Hospital Utilities & Bills','Electricity, Water, Gas, Internet bills',1,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(2,'Medical Consumables & Supplies','Gloves, Syringes, Bandages, Disinfectants',1,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(3,'Equipment Maintenance & Repair','Biomedical engineering, MRI/CT servicing',1,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(4,'Staff Salaries & Overtime','Monthly payroll and staff allowances',1,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(5,'Office Stationery & Printing','Prescription pads, admission files, receipts',1,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(6,'Hospital Utilities & Power','Electricity, Generator Diesel & Gas',1,'2026-11-17 01:14:12','2026-11-17 01:14:12');
/*!40000 ALTER TABLE `expense_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `expense_category_id` bigint(20) unsigned DEFAULT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `date` date NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'Cash',
  `reference_no` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (1,6,NULL,'Generator Fuel Refill (200L Diesel)',22000.00,'2026-11-17','Cash','FUEL-8902',NULL,1,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(2,6,NULL,'Generator Fuel Refill (200L Diesel)',22000.00,'2026-11-17','Cash','FUEL-8902',NULL,1,'2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follow_ups`
--

DROP TABLE IF EXISTS `follow_ups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follow_ups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follow_ups`
--

LOCK TABLES `follow_ups` WRITE;
/*!40000 ALTER TABLE `follow_ups` DISABLE KEYS */;
/*!40000 ALTER TABLE `follow_ups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heroes`
--

DROP TABLE IF EXISTS `heroes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `heroes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bg_image` varchar(255) DEFAULT NULL,
  `overlay_color` varchar(255) NOT NULL DEFAULT 'rgba(11, 94, 215, 0.85)',
  `button_text` varchar(255) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heroes`
--

LOCK TABLES `heroes` WRITE;
/*!40000 ALTER TABLE `heroes` DISABLE KEYS */;
INSERT INTO `heroes` VALUES (1,'Advanced Diagnostic Care You Can Trust','Accurate results, expert consultations, and modern facilities to keep you and your family healthy.',NULL,NULL,'rgba(11, 94, 215, 0.85)','Book Appointment','/appointment',1,'2026-09-20 04:40:40','2026-09-20 05:15:57');
/*!40000 ALTER TABLE `heroes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_collection_requests`
--

DROP TABLE IF EXISTS `home_collection_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `home_collection_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(30) NOT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `tests_required` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `home_collection_requests_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_collection_requests`
--

LOCK TABLES `home_collection_requests` WRITE;
/*!40000 ALTER TABLE `home_collection_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `home_collection_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_settings`
--

DROP TABLE IF EXISTS `home_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `home_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `home_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_settings`
--

LOCK TABLES `home_settings` WRITE;
/*!40000 ALTER TABLE `home_settings` DISABLE KEYS */;
INSERT INTO `home_settings` VALUES (1,'stats_section','{\"doctors\":\"50+\",\"tests\":\"500+\",\"patients\":\"100k+\",\"support\":\"24\\/7\"}','2026-09-20 04:40:40','2026-09-20 04:40:40'),(2,'about_section','{\"years_number\":\"15+\",\"years_text\":\"Years of\\r\\nExcellence\",\"label\":\"About MediDiag\",\"title\":\"Leading the Way in Medical Diagnostics\",\"description\":\"We provide comprehensive diagnostic services with a commitment to accuracy, reliability, and patient comfort. Our state-of-the-art facility is equipped with the latest medical technology.\",\"features\":[\"Advanced Equipment\",\"Expert Pathologists\",\"Accurate Reports\",\"Fast Turnaround\"],\"button_text\":\"Learn More\",\"button_link\":\"http:\\/\\/127.0.0.1:8000\\/about\",\"image\":\"cms\\/ZrjUOCnrPbxzgKvSCkPn8fOQMSkGKXLW0MGqrDkH.webp\"}','2026-09-23 00:22:12','2026-09-23 00:22:12'),(3,'home_collection_section','{\"label\":\"Convenience First\",\"title\":\"Diagnostics at Your Doorstep\",\"description\":\"aa\",\"features\":[{\"title\":\"Safe & Hygienic\",\"description\":\"aaaaa\",\"icon\":\"bi-shield-check\"},{\"title\":\"On-Time Collection\",\"description\":\"aaaaaaaaaaaaaaaaaaaaa\",\"icon\":\"bi-clock\"}],\"image\":\"home-collection\\/CiWFOCXYyTVVkKuSagPE9ZLCCjTEYcp0v1GHg3RJ.jpg\"}','2026-09-23 04:04:11','2026-09-23 04:04:11');
/*!40000 ALTER TABLE `home_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insurance_companies`
--

DROP TABLE IF EXISTS `insurance_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insurance_companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `insurance_companies_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insurance_companies`
--

LOCK TABLES `insurance_companies` WRITE;
/*!40000 ALTER TABLE `insurance_companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `insurance_companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `intake_output_charts`
--

DROP TABLE IF EXISTS `intake_output_charts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `intake_output_charts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_id` bigint(20) unsigned NOT NULL,
  `recorded_at` datetime NOT NULL,
  `intake_type` varchar(255) DEFAULT NULL,
  `intake_amount_ml` decimal(8,2) NOT NULL DEFAULT 0.00,
  `output_type` varchar(255) DEFAULT NULL,
  `output_amount_ml` decimal(8,2) NOT NULL DEFAULT 0.00,
  `recorded_by` bigint(20) unsigned DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `intake_output_charts_admission_id_foreign` (`admission_id`),
  CONSTRAINT `intake_output_charts_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intake_output_charts`
--

LOCK TABLES `intake_output_charts` WRITE;
/*!40000 ALTER TABLE `intake_output_charts` DISABLE KEYS */;
/*!40000 ALTER TABLE `intake_output_charts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_categories`
--

DROP TABLE IF EXISTS `inventory_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_categories`
--

LOCK TABLES `inventory_categories` WRITE;
/*!40000 ALTER TABLE `inventory_categories` DISABLE KEYS */;
INSERT INTO `inventory_categories` VALUES (1,'Medical Disposables','Single use medical items','2026-11-17 00:17:34','2026-11-17 00:17:34');
/*!40000 ALTER TABLE `inventory_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_items`
--

DROP TABLE IF EXISTS `inventory_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `unit` varchar(255) NOT NULL DEFAULT 'pcs',
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) NOT NULL DEFAULT 10,
  `unit_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_items`
--

LOCK TABLES `inventory_items` WRITE;
/*!40000 ALTER TABLE `inventory_items` DISABLE KEYS */;
INSERT INTO `inventory_items` VALUES (1,'Disposable Syringes 5ml',1,'box',120,20,250.00,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(2,'Latex Examination Gloves (M)',1,'box',80,15,380.00,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(3,'Sterile Gauze Bandages',1,'roll',200,30,45.00,'2026-11-17 00:17:34','2026-11-17 00:17:34');
/*!40000 ALTER TABLE `inventory_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(255) NOT NULL,
  `invoice_type` varchar(255) NOT NULL DEFAULT 'general',
  `patient_id` bigint(20) unsigned NOT NULL,
  `admission_id` bigint(20) unsigned DEFAULT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `due` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(255) NOT NULL DEFAULT 'Unpaid',
  `payment_method` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_no_unique` (`invoice_no`),
  KEY `invoices_patient_id_foreign` (`patient_id`),
  CONSTRAINT `invoices_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'INV-260916-0001','general',1,NULL,NULL,'2026-09-16',1000.00,100.00,900.00,900.00,0.00,'Paid','Cash',NULL,'2026-09-16 00:57:18','2026-09-16 00:57:18');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_certificates`
--

DROP TABLE IF EXISTS `medical_certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical_certificates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `certificate_no` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Medical Fitness',
  `diagnosis` varchar(255) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `recommendations` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medical_certificates_certificate_no_unique` (`certificate_no`),
  KEY `medical_certificates_patient_id_foreign` (`patient_id`),
  KEY `medical_certificates_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `medical_certificates_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medical_certificates_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_certificates`
--

LOCK TABLES `medical_certificates` WRITE;
/*!40000 ALTER TABLE `medical_certificates` DISABLE KEYS */;
INSERT INTO `medical_certificates` VALUES (1,'MED-TEST-1315',1,1,'Medical Fitness','Physical & systemic examination reveals no clinical abnormality','2026-11-17','2026-12-17','The patient is evaluated and certified medically fit for active duties.','2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `medical_certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medication_administrations`
--

DROP TABLE IF EXISTS `medication_administrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medication_administrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `medication_chart_id` bigint(20) unsigned NOT NULL,
  `scheduled_time` datetime NOT NULL,
  `administered_at` datetime DEFAULT NULL,
  `administered_by` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'given',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medication_administrations_medication_chart_id_foreign` (`medication_chart_id`),
  CONSTRAINT `medication_administrations_medication_chart_id_foreign` FOREIGN KEY (`medication_chart_id`) REFERENCES `medication_charts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medication_administrations`
--

LOCK TABLES `medication_administrations` WRITE;
/*!40000 ALTER TABLE `medication_administrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `medication_administrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medication_charts`
--

DROP TABLE IF EXISTS `medication_charts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medication_charts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_id` bigint(20) unsigned NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `dosage` varchar(255) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL DEFAULT 'Oral',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `prescribed_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medication_charts_admission_id_foreign` (`admission_id`),
  CONSTRAINT `medication_charts_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medication_charts`
--

LOCK TABLES `medication_charts` WRITE;
/*!40000 ALTER TABLE `medication_charts` DISABLE KEYS */;
/*!40000 ALTER TABLE `medication_charts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicine_batches`
--

DROP TABLE IF EXISTS `medicine_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicine_batches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `medicine_id` bigint(20) unsigned NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `quantity_in` int(11) NOT NULL DEFAULT 0,
  `quantity_available` int(11) NOT NULL DEFAULT 0,
  `purchase_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sale_rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medicine_batches_medicine_id_foreign` (`medicine_id`),
  CONSTRAINT `medicine_batches_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `pharmacy_medicines` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicine_batches`
--

LOCK TABLES `medicine_batches` WRITE;
/*!40000 ALTER TABLE `medicine_batches` DISABLE KEYS */;
INSERT INTO `medicine_batches` VALUES (1,1,'BCH-2026-4627','2028-02-17',500,490,2.20,3.00,'2026-11-17 00:17:34','2026-11-17 01:14:25'),(2,2,'BCH-2026-6773','2027-11-17',500,500,4.50,6.00,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(3,3,'BCH-2026-4702','2028-01-17',500,500,6.00,8.00,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(4,4,'BCH-2026-5426','2028-03-17',500,500,140.00,180.00,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(5,5,'BCH-2026-1877','2028-05-17',500,500,70.00,95.00,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(6,6,'BCH-2026-5404','2028-05-17',500,500,11.50,15.00,'2026-11-17 00:17:34','2026-11-17 00:17:34');
/*!40000 ALTER TABLE `medicine_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicine_returns`
--

DROP TABLE IF EXISTS `medicine_returns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicine_returns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pharmacy_sale_id` bigint(20) unsigned NOT NULL,
  `medicine_id` bigint(20) unsigned NOT NULL,
  `medicine_batch_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `refund_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reason` varchar(255) DEFAULT NULL,
  `returned_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medicine_returns_pharmacy_sale_id_foreign` (`pharmacy_sale_id`),
  KEY `medicine_returns_medicine_id_foreign` (`medicine_id`),
  KEY `medicine_returns_medicine_batch_id_foreign` (`medicine_batch_id`),
  CONSTRAINT `medicine_returns_medicine_batch_id_foreign` FOREIGN KEY (`medicine_batch_id`) REFERENCES `medicine_batches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `medicine_returns_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `pharmacy_medicines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medicine_returns_pharmacy_sale_id_foreign` FOREIGN KEY (`pharmacy_sale_id`) REFERENCES `pharmacy_sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicine_returns`
--

LOCK TABLES `medicine_returns` WRITE;
/*!40000 ALTER TABLE `medicine_returns` DISABLE KEYS */;
/*!40000 ALTER TABLE `medicine_returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_16_055045_create_permission_tables',1),(5,'2026_09_16_055704_create_branches_table',1),(6,'2026_09_16_055705_create_audit_logs_table',1),(7,'2026_09_16_055705_create_settings_table',1),(8,'2026_09_16_055706_create_patient_documents_table',1),(9,'2026_09_16_055706_create_patients_table',1),(10,'2026_09_16_055707_create_doctors_table',1),(11,'2026_09_16_055708_create_doctor_commissions_table',1),(12,'2026_09_16_055708_create_doctor_schedules_table',1),(13,'2026_09_16_055709_create_appointments_table',1),(14,'2026_09_16_055709_create_visits_table',1),(15,'2026_09_16_055710_create_diagnoses_table',1),(16,'2026_09_16_055710_create_prescriptions_table',1),(17,'2026_09_16_055711_create_follow_ups_table',1),(18,'2026_09_16_055711_create_prescription_items_table',1),(19,'2026_09_16_055712_create_departments_table',1),(20,'2026_09_16_055712_create_test_categories_table',1),(21,'2026_09_16_055713_create_test_parameters_table',1),(22,'2026_09_16_055713_create_tests_table',1),(23,'2026_09_16_055714_create_test_packages_table',1),(24,'2026_09_16_055714_create_test_parameter_ranges_table',1),(25,'2026_09_16_055715_create_services_table',1),(26,'2026_09_16_055715_create_test_package_items_table',1),(27,'2026_09_16_055716_create_diagnostic_orders_table',1),(28,'2026_09_16_055717_create_samples_table',1),(29,'2026_09_16_055717_create_test_results_table',1),(30,'2026_09_16_055718_create_reports_table',1),(31,'2026_09_16_055718_create_test_result_values_table',1),(32,'2026_09_16_055719_create_radiology_orders_table',1),(33,'2026_09_16_055719_create_report_versions_table',1),(34,'2026_09_16_055720_create_invoices_table',1),(35,'2026_09_16_055720_create_radiology_reports_table',1),(36,'2026_09_16_055721_create_invoice_items_table',1),(37,'2026_09_16_055721_create_payments_table',1),(38,'2026_09_16_055722_create_expense_categories_table',1),(39,'2026_09_16_055722_create_refunds_table',1),(40,'2026_09_16_055723_create_expenses_table',1),(41,'2026_09_16_055723_create_suppliers_table',1),(42,'2026_09_16_055724_create_inventory_categories_table',1),(43,'2026_09_16_055724_create_inventory_items_table',1),(44,'2026_09_16_055725_create_purchase_items_table',1),(45,'2026_09_16_055725_create_purchases_table',1),(46,'2026_09_16_055726_create_salary_payments_table',1),(47,'2026_09_16_055726_create_staff_attendances_table',1),(48,'2026_09_16_055726_create_staff_table',1),(49,'2026_09_16_055727_create_home_collection_requests_table',1),(50,'2026_09_16_055800_create_diagnostic_order_items_table',1),(51,'2026_09_16_090853_add_columns_to_staff_table',2),(52,'2026_09_20_084759_add_department_id_to_doctors_table',3),(53,'2026_09_20_084906_add_columns_to_departments_table',4),(54,'2026_09_20_085523_add_columns_to_test_packages_table',5),(55,'2026_09_20_085913_add_columns_to_test_package_items_table',6),(56,'2026_09_20_103928_create_heroes_table',7),(57,'2026_09_20_103940_create_home_settings_table',7),(58,'2026_09_20_104707_add_bg_image_and_overlay_to_heroes_table',8),(59,'2026_09_23_044939_add_columns_to_test_parameters_and_values',9),(60,'2026_09_23_064005_make_doctor_id_nullable_in_appointments_table',10),(61,'2026_09_23_083349_add_columns_to_doctor_schedules_table',11),(62,'2026_09_23_000000_create_testimonials_table',12),(63,'2026_09_23_010000_create_blogs_table',13),(64,'2026_09_23_120000_add_home_collection_request_fields',14),(65,'2026_09_23_160000_add_columns_to_branches_table',15),(66,'2026_09_23_130000_create_faqs_table',16),(67,'2026_09_23_140000_create_contact_messages_table',17),(68,'2026_11_17_000001_create_hospital_wards_and_beds_tables',18),(69,'2026_11_17_000002_create_hospital_emergency_tables',18),(70,'2026_11_17_000003_create_hospital_nursing_and_clinical_charting_tables',18),(71,'2026_11_17_000004_create_hospital_operation_theatre_tables',18),(72,'2026_11_17_000005_create_hospital_pharmacy_and_medicines_tables',18),(73,'2026_11_17_000006_create_hospital_additional_services_tables',18),(74,'2026_11_17_000007_upgrade_existing_skeleton_tables',18);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(3,'App\\Models\\User',3),(5,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nursing_assignments`
--

DROP TABLE IF EXISTS `nursing_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nursing_assignments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_id` bigint(20) unsigned NOT NULL,
  `nurse_id` bigint(20) unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `shift` varchar(255) NOT NULL DEFAULT 'Morning',
  `status` varchar(255) NOT NULL DEFAULT 'Assigned',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nursing_assignments_admission_id_foreign` (`admission_id`),
  KEY `nursing_assignments_nurse_id_foreign` (`nurse_id`),
  CONSTRAINT `nursing_assignments_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nursing_assignments_nurse_id_foreign` FOREIGN KEY (`nurse_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nursing_assignments`
--

LOCK TABLES `nursing_assignments` WRITE;
/*!40000 ALTER TABLE `nursing_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `nursing_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nursing_notes`
--

DROP TABLE IF EXISTS `nursing_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nursing_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_id` bigint(20) unsigned NOT NULL,
  `nurse_id` bigint(20) unsigned DEFAULT NULL,
  `shift` varchar(255) NOT NULL DEFAULT 'Morning',
  `note_type` varchar(255) NOT NULL DEFAULT 'Routine',
  `content` text NOT NULL,
  `recorded_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nursing_notes_admission_id_foreign` (`admission_id`),
  CONSTRAINT `nursing_notes_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nursing_notes`
--

LOCK TABLES `nursing_notes` WRITE;
/*!40000 ALTER TABLE `nursing_notes` DISABLE KEYS */;
INSERT INTO `nursing_notes` VALUES (1,2,1,'Morning','routine','Patient resting comfortably. Vitals stable. IV infusion ongoing without phlebitis.','2026-11-17 07:14:12','2026-11-17 01:14:12','2026-11-17 01:14:12'),(2,3,1,'Morning','routine','Patient resting comfortably. Vitals stable. IV infusion ongoing without phlebitis.','2026-11-17 07:14:25','2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `nursing_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ot_rooms`
--

DROP TABLE IF EXISTS `ot_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ot_rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'General',
  `daily_charge` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hourly_rate` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `equipment_details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ot_rooms_room_number_unique` (`room_number`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ot_rooms`
--

LOCK TABLES `ot_rooms` WRITE;
/*!40000 ALTER TABLE `ot_rooms` DISABLE KEYS */;
INSERT INTO `ot_rooms` VALUES (1,'OT-01','Main Surgery Theatre','General',10000.00,2000.00,'available',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(2,'OT-02','Laparoscopic Theatre','Laparoscopic',12000.00,2500.00,'available',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(3,'OT-03','Orthopedic Theatre','Orthopedic',15000.00,3000.00,'available',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34');
/*!40000 ALTER TABLE `ot_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_documents`
--

DROP TABLE IF EXISTS `patient_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_documents`
--

LOCK TABLES `patient_documents` WRITE;
/*!40000 ALTER TABLE `patient_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `patient_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_insurances`
--

DROP TABLE IF EXISTS `patient_insurances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_insurances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `insurance_company_id` bigint(20) unsigned NOT NULL,
  `policy_number` varchar(255) NOT NULL,
  `coverage_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `expiry_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_insurances_patient_id_foreign` (`patient_id`),
  KEY `patient_insurances_insurance_company_id_foreign` (`insurance_company_id`),
  CONSTRAINT `patient_insurances_insurance_company_id_foreign` FOREIGN KEY (`insurance_company_id`) REFERENCES `insurance_companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `patient_insurances_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_insurances`
--

LOCK TABLES `patient_insurances` WRITE;
/*!40000 ALTER TABLE `patient_insurances` DISABLE KEYS */;
/*!40000 ALTER TABLE `patient_insurances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_vitals`
--

DROP TABLE IF EXISTS `patient_vitals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_vitals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `admission_id` bigint(20) unsigned DEFAULT NULL,
  `emergency_case_id` bigint(20) unsigned DEFAULT NULL,
  `visit_id` bigint(20) unsigned DEFAULT NULL,
  `systolic_bp` varchar(255) DEFAULT NULL,
  `diastolic_bp` varchar(255) DEFAULT NULL,
  `pulse_rate` varchar(255) DEFAULT NULL,
  `temperature` varchar(255) DEFAULT NULL,
  `respiratory_rate` varchar(255) DEFAULT NULL,
  `spo2` varchar(255) DEFAULT NULL,
  `blood_sugar` varchar(255) DEFAULT NULL,
  `weight` decimal(6,2) DEFAULT NULL,
  `height` decimal(6,2) DEFAULT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `recorded_at` datetime NOT NULL,
  `recorded_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_vitals_patient_id_foreign` (`patient_id`),
  KEY `patient_vitals_admission_id_foreign` (`admission_id`),
  KEY `patient_vitals_emergency_case_id_foreign` (`emergency_case_id`),
  CONSTRAINT `patient_vitals_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `patient_vitals_emergency_case_id_foreign` FOREIGN KEY (`emergency_case_id`) REFERENCES `emergency_cases` (`id`) ON DELETE SET NULL,
  CONSTRAINT `patient_vitals_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_vitals`
--

LOCK TABLES `patient_vitals` WRITE;
/*!40000 ALTER TABLE `patient_vitals` DISABLE KEYS */;
INSERT INTO `patient_vitals` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,'76','98.4','18',NULL,NULL,NULL,NULL,NULL,NULL,'2026-11-17 07:06:53',NULL,'2026-11-17 01:06:53','2026-11-17 01:06:53'),(2,1,NULL,NULL,NULL,NULL,NULL,'76','98.4','18',NULL,NULL,NULL,NULL,NULL,NULL,'2026-11-17 07:08:59',NULL,'2026-11-17 01:08:59','2026-11-17 01:08:59'),(3,1,NULL,NULL,NULL,NULL,NULL,'76','98.4','18',NULL,NULL,NULL,NULL,NULL,NULL,'2026-11-17 07:13:23',NULL,'2026-11-17 01:13:23','2026-11-17 01:13:23'),(4,1,NULL,NULL,NULL,NULL,NULL,'76','98.4','18',NULL,NULL,NULL,NULL,NULL,NULL,'2026-11-17 07:14:12',NULL,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(5,1,NULL,NULL,NULL,NULL,NULL,'76','98.4','18',NULL,NULL,NULL,NULL,NULL,NULL,'2026-11-17 07:14:24',NULL,'2026-11-17 01:14:24','2026-11-17 01:14:24');
/*!40000 ALTER TABLE `patient_vitals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nid` varchar(255) DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_mobile` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `emergency_contact_relation` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `allergies` text DEFAULT NULL,
  `medical_history` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patients_patient_id_unique` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,'PT-260916-0001','Rahim Uddin',NULL,'male',NULL,NULL,NULL,45,'O+','01511112222',NULL,NULL,NULL,NULL,'Mirpur, Dhaka',NULL,NULL,NULL,NULL,NULL,'2026-09-16 00:57:18','2026-09-16 00:57:18'),(2,'PT-260916-0002','Fatema Begum',NULL,'female',NULL,NULL,NULL,32,'A+','01622223333',NULL,NULL,NULL,NULL,'Dhanmondi, Dhaka',NULL,NULL,NULL,NULL,NULL,'2026-09-16 00:57:18','2026-09-16 00:57:18'),(3,'P-2026-000003','AMINA KHATUN',NULL,'Male',NULL,NULL,NULL,100,'A-','01917345362',NULL,NULL,NULL,NULL,'VILL-SONARCHAR, PO-GOBINDAPUR, MEGHNA',NULL,NULL,NULL,NULL,NULL,'2026-09-17 00:39:07','2026-09-17 00:39:07'),(4,'P-2026-000004','AMINA KHATUN',NULL,'Male',NULL,NULL,NULL,20,'A-','01917345362',NULL,NULL,NULL,NULL,'VILL-SONARCHAR, PO-GOBINDAPUR, MEGHNA',NULL,NULL,NULL,NULL,NULL,'2026-09-22 23:08:33','2026-09-22 23:08:33');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date` date NOT NULL,
  `method` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view dashboard','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(2,'create dashboard','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(3,'edit dashboard','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(4,'delete dashboard','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(5,'view patients','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(6,'create patients','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(7,'edit patients','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(8,'delete patients','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(9,'view doctors','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(10,'create doctors','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(11,'edit doctors','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(12,'delete doctors','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(13,'view appointments','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(14,'create appointments','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(15,'edit appointments','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(16,'delete appointments','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(17,'view consultations','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(18,'create consultations','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(19,'edit consultations','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(20,'delete consultations','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(21,'view tests','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(22,'create tests','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(23,'edit tests','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(24,'delete tests','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(25,'view lab orders','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(26,'create lab orders','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(27,'edit lab orders','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(28,'delete lab orders','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(29,'view lab results','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(30,'create lab results','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(31,'edit lab results','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(32,'delete lab results','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(33,'view billing','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(34,'create billing','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(35,'edit billing','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(36,'delete billing','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(37,'view accounts','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(38,'create accounts','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(39,'edit accounts','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(40,'delete accounts','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(41,'view reports','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(42,'create reports','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(43,'edit reports','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(44,'delete reports','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(45,'view staff','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(46,'create staff','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(47,'edit staff','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(48,'delete staff','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(49,'view settings','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(50,'create settings','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(51,'edit settings','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(52,'delete settings','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(53,'view roles','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(54,'create roles','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(55,'edit roles','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(56,'delete roles','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(57,'approve dashboard','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(58,'print dashboard','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(59,'approve patients','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(60,'print patients','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(61,'approve doctors','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(62,'print doctors','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(63,'approve appointments','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(64,'print appointments','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(65,'approve consultations','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(66,'print consultations','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(67,'view prescriptions','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(68,'create prescriptions','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(69,'edit prescriptions','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(70,'delete prescriptions','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(71,'approve prescriptions','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(72,'print prescriptions','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(73,'approve tests','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(74,'print tests','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(75,'approve lab orders','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(76,'print lab orders','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(77,'approve lab results','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(78,'print lab results','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(79,'view radiology','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(80,'create radiology','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(81,'edit radiology','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(82,'delete radiology','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(83,'approve radiology','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(84,'print radiology','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(85,'approve billing','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(86,'print billing','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(87,'approve accounts','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(88,'print accounts','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(89,'approve reports','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(90,'print reports','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(91,'approve staff','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(92,'print staff','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(93,'approve settings','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(94,'print settings','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(95,'approve roles','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(96,'print roles','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(97,'view ipd','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(98,'create ipd','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(99,'edit ipd','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(100,'delete ipd','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(101,'approve ipd','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(102,'print ipd','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(103,'view wards','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(104,'create wards','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(105,'edit wards','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(106,'delete wards','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(107,'approve wards','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(108,'print wards','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(109,'view beds','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(110,'create beds','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(111,'edit beds','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(112,'delete beds','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(113,'approve beds','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(114,'print beds','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(115,'view emergency','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(116,'create emergency','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(117,'edit emergency','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(118,'delete emergency','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(119,'approve emergency','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(120,'print emergency','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(121,'view nursing','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(122,'create nursing','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(123,'edit nursing','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(124,'delete nursing','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(125,'approve nursing','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(126,'print nursing','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(127,'view ot','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(128,'create ot','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(129,'edit ot','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(130,'delete ot','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(131,'approve ot','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(132,'print ot','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(133,'view pharmacy','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(134,'create pharmacy','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(135,'edit pharmacy','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(136,'delete pharmacy','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(137,'approve pharmacy','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(138,'print pharmacy','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(139,'view inventory','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(140,'create inventory','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(141,'edit inventory','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(142,'delete inventory','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(143,'approve inventory','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(144,'print inventory','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(145,'view blood bank','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(146,'create blood bank','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(147,'edit blood bank','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(148,'delete blood bank','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(149,'approve blood bank','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(150,'print blood bank','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(151,'view ambulance','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(152,'create ambulance','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(153,'edit ambulance','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(154,'delete ambulance','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(155,'approve ambulance','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(156,'print ambulance','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(157,'view certificates','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(158,'create certificates','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(159,'edit certificates','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(160,'delete certificates','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(161,'approve certificates','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(162,'print certificates','web','2026-11-17 00:06:20','2026-11-17 00:06:20');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pharmacy_medicines`
--

DROP TABLE IF EXISTS `pharmacy_medicines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pharmacy_medicines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `generic_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'General',
  `dosage_form` varchar(255) NOT NULL DEFAULT 'Tablet',
  `strength` varchar(255) DEFAULT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `purchase_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reorder_level` int(11) NOT NULL DEFAULT 20,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pharmacy_medicines`
--

LOCK TABLES `pharmacy_medicines` WRITE;
/*!40000 ALTER TABLE `pharmacy_medicines` DISABLE KEYS */;
INSERT INTO `pharmacy_medicines` VALUES (1,'Napa Extra 500mg/65mg','Paracetamol + Caffeine','Analgesics','Tablet','500mg/65mg','Beximco Pharmaceuticals',3.00,2.20,50,'active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(2,'Seclo 20mg','Omeprazole','Gastrointestinal','Capsule','20mg','Square Pharmaceuticals',6.00,4.50,40,'active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(3,'Moxacil 500mg','Amoxicillin','Antibiotics','Capsule','500mg','Square Pharmaceuticals',8.00,6.00,30,'active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(4,'Ceftron 1g IV/IM','Ceftriaxone','Antibiotics','Injection','1g','Square Pharmaceuticals',180.00,140.00,20,'active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(5,'Normal Saline 0.9% 1000ml','Sodium Chloride','IV Fluid','IV Fluid','0.9%','Orion Infusion',95.00,70.00,25,'active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(6,'Compath 500mg','Ciprofloxacin','Antibiotics','Tablet','500mg','Incepta Pharmaceuticals',15.00,11.50,30,'active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34');
/*!40000 ALTER TABLE `pharmacy_medicines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pharmacy_sale_items`
--

DROP TABLE IF EXISTS `pharmacy_sale_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pharmacy_sale_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pharmacy_sale_id` bigint(20) unsigned NOT NULL,
  `medicine_id` bigint(20) unsigned NOT NULL,
  `medicine_batch_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pharmacy_sale_items_pharmacy_sale_id_foreign` (`pharmacy_sale_id`),
  KEY `pharmacy_sale_items_medicine_id_foreign` (`medicine_id`),
  KEY `pharmacy_sale_items_medicine_batch_id_foreign` (`medicine_batch_id`),
  CONSTRAINT `pharmacy_sale_items_medicine_batch_id_foreign` FOREIGN KEY (`medicine_batch_id`) REFERENCES `medicine_batches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pharmacy_sale_items_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `pharmacy_medicines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pharmacy_sale_items_pharmacy_sale_id_foreign` FOREIGN KEY (`pharmacy_sale_id`) REFERENCES `pharmacy_sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pharmacy_sale_items`
--

LOCK TABLES `pharmacy_sale_items` WRITE;
/*!40000 ALTER TABLE `pharmacy_sale_items` DISABLE KEYS */;
INSERT INTO `pharmacy_sale_items` VALUES (1,1,1,1,5,3.00,15.00,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(2,2,1,1,5,3.00,15.00,'2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `pharmacy_sale_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pharmacy_sales`
--

DROP TABLE IF EXISTS `pharmacy_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pharmacy_sales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bill_no` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `admission_id` bigint(20) unsigned DEFAULT NULL,
  `prescription_id` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) NOT NULL DEFAULT 'Cash',
  `payment_status` varchar(255) NOT NULL DEFAULT 'Paid',
  `sold_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pharmacy_sales_bill_no_unique` (`bill_no`),
  KEY `pharmacy_sales_patient_id_foreign` (`patient_id`),
  KEY `pharmacy_sales_admission_id_foreign` (`admission_id`),
  CONSTRAINT `pharmacy_sales_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pharmacy_sales_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pharmacy_sales`
--

LOCK TABLES `pharmacy_sales` WRITE;
/*!40000 ALTER TABLE `pharmacy_sales` DISABLE KEYS */;
INSERT INTO `pharmacy_sales` VALUES (1,'PHM-TEST-8452',1,NULL,NULL,NULL,NULL,15.00,0.00,0.00,15.00,15.00,0.00,'Cash','Paid',1,'2026-11-17 01:14:12','2026-11-17 01:14:12'),(2,'PHM-TEST-6626',1,NULL,NULL,NULL,NULL,15.00,0.00,0.00,15.00,15.00,0.00,'Cash','Paid',1,'2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `pharmacy_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescription_items`
--

DROP TABLE IF EXISTS `prescription_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescription_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prescription_id` bigint(20) unsigned NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `dosage` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `instruction` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prescription_items_prescription_id_foreign` (`prescription_id`),
  CONSTRAINT `prescription_items_prescription_id_foreign` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescription_items`
--

LOCK TABLES `prescription_items` WRITE;
/*!40000 ALTER TABLE `prescription_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `prescription_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescriptions`
--

DROP TABLE IF EXISTS `prescriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prescription_id` varchar(255) NOT NULL,
  `visit_id` bigint(20) unsigned NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `advice` text DEFAULT NULL,
  `next_visit_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prescriptions_prescription_id_unique` (`prescription_id`),
  KEY `prescriptions_visit_id_foreign` (`visit_id`),
  KEY `prescriptions_patient_id_foreign` (`patient_id`),
  KEY `prescriptions_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `prescriptions_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prescriptions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prescriptions_visit_id_foreign` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescriptions`
--

LOCK TABLES `prescriptions` WRITE;
/*!40000 ALTER TABLE `prescriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `prescriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_items`
--

DROP TABLE IF EXISTS `purchase_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_items`
--

LOCK TABLES `purchase_items` WRITE;
/*!40000 ALTER TABLE `purchase_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `radiology_orders`
--

DROP TABLE IF EXISTS `radiology_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radiology_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) DEFAULT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `doctor_id` bigint(20) unsigned DEFAULT NULL,
  `admission_id` bigint(20) unsigned DEFAULT NULL,
  `test_name` varchar(255) NOT NULL DEFAULT 'X-Ray',
  `modality` varchar(255) NOT NULL DEFAULT 'X-Ray',
  `clinical_indication` text DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `radiology_orders`
--

LOCK TABLES `radiology_orders` WRITE;
/*!40000 ALTER TABLE `radiology_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `radiology_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `radiology_reports`
--

DROP TABLE IF EXISTS `radiology_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radiology_reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `radiology_order_id` bigint(20) unsigned DEFAULT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `radiologist_id` bigint(20) unsigned DEFAULT NULL,
  `findings` longtext DEFAULT NULL,
  `impression` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Final',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `radiology_reports`
--

LOCK TABLES `radiology_reports` WRITE;
/*!40000 ALTER TABLE `radiology_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `radiology_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refunds`
--

DROP TABLE IF EXISTS `refunds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refunds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refunds`
--

LOCK TABLES `refunds` WRITE;
/*!40000 ALTER TABLE `refunds` DISABLE KEYS */;
/*!40000 ALTER TABLE `refunds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_versions`
--

DROP TABLE IF EXISTS `report_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_versions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_versions`
--

LOCK TABLES `report_versions` WRITE;
/*!40000 ALTER TABLE `report_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `report_id` varchar(255) NOT NULL,
  `diagnostic_order_id` bigint(20) unsigned NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `report_status` varchar(255) NOT NULL DEFAULT 'Draft',
  `summary` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reports_report_id_unique` (`report_id`),
  KEY `reports_diagnostic_order_id_foreign` (`diagnostic_order_id`),
  KEY `reports_patient_id_foreign` (`patient_id`),
  CONSTRAINT `reports_diagnostic_order_id_foreign` FOREIGN KEY (`diagnostic_order_id`) REFERENCES `diagnostic_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(2,1),(2,5),(2,6),(3,1),(3,5),(3,6),(4,1),(4,5),(4,6),(5,1),(5,2),(5,3),(5,5),(5,6),(5,7),(5,10),(5,14),(6,1),(6,2),(6,3),(6,5),(6,6),(7,1),(7,2),(7,3),(7,5),(7,6),(8,1),(8,5),(8,6),(9,1),(9,3),(9,5),(9,6),(9,14),(10,1),(10,5),(10,6),(11,1),(11,5),(11,6),(12,1),(12,5),(12,6),(13,1),(13,2),(13,3),(13,5),(13,6),(13,16),(14,1),(14,2),(14,3),(14,5),(14,6),(14,16),(15,1),(15,2),(15,3),(15,5),(15,6),(16,1),(16,3),(16,5),(16,6),(17,1),(17,2),(17,5),(17,6),(17,7),(18,1),(18,2),(18,5),(18,6),(19,1),(19,2),(19,5),(19,6),(20,1),(20,5),(20,6),(21,1),(21,4),(21,5),(21,6),(21,9),(22,1),(22,5),(22,6),(23,1),(23,5),(23,6),(23,9),(24,1),(24,5),(24,6),(25,1),(25,2),(25,4),(25,5),(25,6),(25,7),(25,9),(26,1),(26,2),(26,4),(26,5),(26,6),(27,1),(27,4),(27,5),(27,6),(28,1),(28,5),(28,6),(29,1),(29,2),(29,4),(29,5),(29,6),(29,7),(29,9),(29,16),(30,1),(30,4),(30,5),(30,6),(30,9),(31,1),(31,4),(31,5),(31,6),(31,9),(32,1),(32,5),(32,6),(33,1),(33,3),(33,5),(33,6),(33,8),(33,11),(33,16),(34,1),(34,3),(34,5),(34,6),(34,8),(34,11),(35,1),(35,3),(35,5),(35,6),(35,11),(36,1),(36,5),(36,6),(36,11),(37,1),(37,5),(37,6),(37,11),(38,1),(38,5),(38,6),(38,11),(39,1),(39,5),(39,6),(39,11),(40,1),(40,5),(40,6),(41,1),(41,5),(41,6),(41,11),(41,12),(42,1),(42,5),(42,6),(43,1),(43,5),(43,6),(44,1),(44,5),(44,6),(45,1),(45,5),(45,6),(45,12),(46,1),(46,5),(46,6),(46,12),(47,1),(47,5),(47,6),(47,12),(48,1),(48,5),(48,6),(48,12),(49,1),(49,5),(49,6),(50,1),(50,5),(50,6),(51,1),(51,5),(51,6),(52,1),(52,5),(52,6),(53,1),(53,5),(53,6),(54,1),(54,5),(54,6),(55,1),(55,5),(55,6),(56,1),(56,5),(56,6),(57,1),(57,5),(57,6),(58,1),(58,5),(58,6),(59,1),(59,5),(59,6),(60,1),(60,3),(60,5),(60,6),(61,1),(61,5),(61,6),(62,1),(62,5),(62,6),(63,1),(63,5),(63,6),(64,1),(64,5),(64,6),(65,1),(65,5),(65,6),(66,1),(66,2),(66,5),(66,6),(67,1),(67,2),(67,5),(67,6),(67,7),(67,8),(67,16),(68,1),(68,2),(68,5),(68,6),(69,1),(69,2),(69,5),(69,6),(70,1),(70,5),(70,6),(71,1),(71,5),(71,6),(72,1),(72,2),(72,5),(72,6),(72,16),(73,1),(73,5),(73,6),(74,1),(74,5),(74,6),(75,1),(75,5),(75,6),(76,1),(76,5),(76,6),(77,1),(77,5),(77,6),(77,9),(78,1),(78,2),(78,4),(78,5),(78,6),(78,9),(78,16),(79,1),(79,2),(79,5),(79,6),(79,10),(80,1),(80,2),(80,5),(80,6),(80,10),(81,1),(81,5),(81,6),(81,10),(82,1),(82,5),(82,6),(83,1),(83,5),(83,6),(83,10),(84,1),(84,5),(84,6),(84,10),(85,1),(85,5),(85,6),(86,1),(86,3),(86,5),(86,6),(86,8),(86,11),(86,16),(87,1),(87,5),(87,6),(88,1),(88,5),(88,6),(88,11),(89,1),(89,5),(89,6),(90,1),(90,5),(90,6),(90,11),(91,1),(91,5),(91,6),(92,1),(92,5),(92,6),(92,12),(93,1),(93,5),(93,6),(94,1),(94,5),(94,6),(95,1),(95,5),(95,6),(96,1),(96,5),(96,6),(97,1),(97,2),(97,3),(97,5),(97,6),(97,7),(97,11),(97,15),(98,1),(98,3),(98,5),(98,6),(99,1),(99,2),(99,5),(99,6),(99,7),(100,1),(100,5),(100,6),(101,1),(101,5),(101,6),(102,1),(102,5),(102,6),(103,1),(103,2),(103,3),(103,5),(103,6),(103,7),(103,15),(104,1),(104,5),(104,6),(104,15),(105,1),(105,5),(105,6),(105,15),(106,1),(106,5),(106,6),(107,1),(107,5),(107,6),(108,1),(108,5),(108,6),(109,1),(109,2),(109,3),(109,5),(109,6),(109,7),(109,15),(110,1),(110,5),(110,6),(110,15),(111,1),(111,5),(111,6),(111,7),(111,15),(112,1),(112,5),(112,6),(112,15),(113,1),(113,5),(113,6),(114,1),(114,5),(114,6),(115,1),(115,2),(115,3),(115,5),(115,6),(115,7),(116,1),(116,3),(116,5),(116,6),(117,1),(117,2),(117,5),(117,6),(117,7),(118,1),(118,5),(118,6),(119,1),(119,5),(119,6),(120,1),(120,5),(120,6),(121,1),(121,5),(121,6),(121,7),(122,1),(122,5),(122,6),(122,7),(123,1),(123,5),(123,6),(123,7),(124,1),(124,5),(124,6),(125,1),(125,5),(125,6),(126,1),(126,5),(126,6),(126,7),(127,1),(127,2),(127,5),(127,6),(127,14),(128,1),(128,5),(128,6),(128,14),(129,1),(129,2),(129,5),(129,6),(129,14),(130,1),(130,5),(130,6),(130,14),(131,1),(131,5),(131,6),(132,1),(132,5),(132,6),(132,14),(133,1),(133,5),(133,6),(133,8),(133,11),(133,13),(134,1),(134,5),(134,6),(134,8),(135,1),(135,5),(135,6),(135,8),(136,1),(136,5),(136,6),(136,8),(137,1),(137,5),(137,6),(138,1),(138,5),(138,6),(138,8),(139,1),(139,5),(139,6),(139,8),(139,13),(140,1),(140,5),(140,6),(140,13),(141,1),(141,5),(141,6),(141,13),(142,1),(142,5),(142,6),(142,13),(143,1),(143,5),(143,6),(144,1),(144,5),(144,6),(144,13),(145,1),(145,5),(145,6),(146,1),(146,5),(146,6),(147,1),(147,5),(147,6),(148,1),(148,5),(148,6),(149,1),(149,5),(149,6),(150,1),(150,5),(150,6),(151,1),(151,3),(151,5),(151,6),(152,1),(152,3),(152,5),(152,6),(153,1),(153,5),(153,6),(154,1),(154,5),(154,6),(155,1),(155,5),(155,6),(156,1),(156,5),(156,6),(157,1),(157,2),(157,5),(157,6),(158,1),(158,2),(158,5),(158,6),(159,1),(159,5),(159,6),(160,1),(160,5),(160,6),(161,1),(161,5),(161,6),(162,1),(162,2),(162,5),(162,6);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(2,'Doctor','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(3,'Receptionist','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(4,'Lab Technician','web','2026-09-16 03:29:38','2026-09-16 03:29:38'),(5,'Super Admin','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(6,'Hospital Admin','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(7,'Nurse','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(8,'Pharmacist','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(9,'Pathologist','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(10,'Radiologist','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(11,'Accountant','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(12,'HR Manager','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(13,'Store Manager','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(14,'OT Manager','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(15,'Ward Manager','web','2026-11-17 00:06:20','2026-11-17 00:06:20'),(16,'Patient','web','2026-11-17 00:06:20','2026-11-17 00:06:20');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_payments`
--

DROP TABLE IF EXISTS `salary_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` bigint(20) unsigned DEFAULT NULL,
  `month_year` varchar(255) NOT NULL,
  `basic_salary` decimal(12,2) NOT NULL DEFAULT 0.00,
  `allowances` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deductions` decimal(12,2) NOT NULL DEFAULT 0.00,
  `net_salary` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_date` date NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'Bank Transfer',
  `status` varchar(255) NOT NULL DEFAULT 'Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_payments`
--

LOCK TABLES `salary_payments` WRITE;
/*!40000 ALTER TABLE `salary_payments` DISABLE KEYS */;
INSERT INTO `salary_payments` VALUES (1,2,'2026-11',30000.00,5000.00,1200.00,33800.00,'2026-11-17','Bank Transfer','Paid','2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `salary_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `samples`
--

DROP TABLE IF EXISTS `samples`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `samples` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `test_id` bigint(20) unsigned DEFAULT NULL,
  `sample_code` varchar(255) DEFAULT NULL,
  `specimen_type` varchar(255) NOT NULL DEFAULT 'Blood',
  `barcode` varchar(255) DEFAULT NULL,
  `collected_by` bigint(20) unsigned DEFAULT NULL,
  `collected_at` datetime DEFAULT NULL,
  `received_by` bigint(20) unsigned DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `samples`
--

LOCK TABLES `samples` WRITE;
/*!40000 ALTER TABLE `samples` DISABLE KEYS */;
/*!40000 ALTER TABLE `samples` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('5rtAzb1B3xUNFNu4KPnpaawjpNTVY2LNKwl1EWwL',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidmgwbFZ6MExOVHdYanRjbkh0b2RvTU1YVGpIbTk3ZGFlZW1ERFVDVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1790226864),('lvuzbBrqHBmzf2ADbRJvePww0W4nKTnYrQmLoXTH',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaTlXSEJVYW1wMUlSbXpLV3FoeHNKRTAwems5dlUza0I5ajhzVHhPcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1794893890),('pIVHptiVuAsCKNmWAG2I7mCYG6tATwkkWaHKzQ76',NULL,'127.0.0.1','Symfony','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMnlFMWJhT1ZENXQ2OVluM1l4NlB0c3ZZV21GNzlJczgyQ3VUU0NkaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1794895385),('ZN2Sd2Xr14DUyYGXMY86yNJM7JuHxPhpTBgPUnfS',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.139.0 Chrome/150.0.7871.250 Electron/43.6.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGNBQXVsaUlKbVFRNnBoQ2puNUJnbXBoN1djZXF6STNJTlE4NG5vbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1790224273);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site_name','MediDiag','2026-09-20 04:04:47','2026-09-20 04:04:47'),(2,'site_tagline','Diagnostic & Clinic','2026-09-20 04:04:47','2026-09-20 04:04:47'),(3,'site_phone','+880 1711 000 000','2026-09-20 04:04:47','2026-09-20 04:04:47'),(4,'site_email','info@medidiag.com','2026-09-20 04:04:47','2026-09-20 04:04:47'),(5,'site_address','123 Health Avenue, Dhanmondi, Dhaka-1205','2026-09-20 04:04:47','2026-09-20 04:04:47'),(6,'site_logo','settings/YfPUul1pVpZLvQ0cqc3zaMD2CXWS7YbunWpa4tza.png','2026-09-20 04:04:47','2026-09-23 23:12:21'),(7,'site_favicon','','2026-09-20 04:04:47','2026-09-20 04:04:47'),(8,'site_whatsapp',NULL,'2026-09-23 00:54:05','2026-09-23 00:54:05');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`),
  KEY `staff_user_id_foreign` (`user_id`),
  CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'2026-09-16 23:41:46','2026-09-16 23:41:46',3,'Hasan Parvez','Event Planner','01866700048','Active'),(2,'2026-11-17 01:14:25','2026-11-17 01:14:25',NULL,'Nasreen Sultana','Senior Staff Nurse','01711002233','active');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_attendances`
--

DROP TABLE IF EXISTS `staff_attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` bigint(20) unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `sign_in` time DEFAULT NULL,
  `sign_out` time DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Present',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_attendances`
--

LOCK TABLES `staff_attendances` WRITE;
/*!40000 ALTER TABLE `staff_attendances` DISABLE KEYS */;
INSERT INTO `staff_attendances` VALUES (1,2,'2026-11-17','07:55:00','16:05:00','Present','2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `staff_attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Popular Diagnostic & Medical Suppliers Ltd.','Md. Enamul Haque','01711223399','sales@popularmed.com','Motijheel C/A, Dhaka','2026-11-17 00:17:34','2026-11-17 00:17:34');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surgeries`
--

DROP TABLE IF EXISTS `surgeries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surgeries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `surgery_no` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `admission_id` bigint(20) unsigned DEFAULT NULL,
  `ot_room_id` bigint(20) unsigned DEFAULT NULL,
  `lead_surgeon_id` bigint(20) unsigned NOT NULL,
  `anesthesiologist_id` bigint(20) unsigned DEFAULT NULL,
  `surgery_name` varchar(255) NOT NULL,
  `surgery_type` varchar(255) NOT NULL DEFAULT 'Major',
  `scheduled_start` datetime NOT NULL,
  `scheduled_end` datetime NOT NULL,
  `actual_start` datetime DEFAULT NULL,
  `actual_end` datetime DEFAULT NULL,
  `anesthesia_type` varchar(255) NOT NULL DEFAULT 'General Anesthesia',
  `pre_op_notes` text DEFAULT NULL,
  `op_notes` text DEFAULT NULL,
  `post_op_notes` text DEFAULT NULL,
  `surgeon_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `anesthesia_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ot_room_charge` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_charge` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'scheduled',
  `payment_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surgeries_surgery_no_unique` (`surgery_no`),
  KEY `surgeries_patient_id_foreign` (`patient_id`),
  KEY `surgeries_admission_id_foreign` (`admission_id`),
  KEY `surgeries_ot_room_id_foreign` (`ot_room_id`),
  KEY `surgeries_lead_surgeon_id_foreign` (`lead_surgeon_id`),
  KEY `surgeries_anesthesiologist_id_foreign` (`anesthesiologist_id`),
  CONSTRAINT `surgeries_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `surgeries_anesthesiologist_id_foreign` FOREIGN KEY (`anesthesiologist_id`) REFERENCES `doctors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `surgeries_lead_surgeon_id_foreign` FOREIGN KEY (`lead_surgeon_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `surgeries_ot_room_id_foreign` FOREIGN KEY (`ot_room_id`) REFERENCES `ot_rooms` (`id`) ON DELETE SET NULL,
  CONSTRAINT `surgeries_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surgeries`
--

LOCK TABLES `surgeries` WRITE;
/*!40000 ALTER TABLE `surgeries` DISABLE KEYS */;
INSERT INTO `surgeries` VALUES (1,'SURG-TEST-3928',1,NULL,1,1,NULL,'Laparoscopic Cholecystectomy','Elective','2026-11-18 09:00:00','2026-11-18 11:30:00',NULL,NULL,'General Anesthesia',NULL,NULL,NULL,0.00,0.00,0.00,0.00,'scheduled','Pending','2026-11-17 01:14:12','2026-11-17 01:14:12'),(2,'SURG-TEST-5360',1,NULL,1,1,NULL,'Laparoscopic Cholecystectomy','Elective','2026-11-18 09:00:00','2026-11-18 11:30:00',NULL,NULL,'General Anesthesia',NULL,NULL,NULL,0.00,0.00,0.00,0.00,'scheduled','Pending','2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `surgeries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surgery_staff`
--

DROP TABLE IF EXISTS `surgery_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surgery_staff` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `surgery_id` bigint(20) unsigned NOT NULL,
  `staff_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'Assistant Surgeon',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `surgery_staff_surgery_id_foreign` (`surgery_id`),
  KEY `surgery_staff_staff_id_foreign` (`staff_id`),
  KEY `surgery_staff_user_id_foreign` (`user_id`),
  CONSTRAINT `surgery_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE SET NULL,
  CONSTRAINT `surgery_staff_surgery_id_foreign` FOREIGN KEY (`surgery_id`) REFERENCES `surgeries` (`id`) ON DELETE CASCADE,
  CONSTRAINT `surgery_staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surgery_staff`
--

LOCK TABLES `surgery_staff` WRITE;
/*!40000 ALTER TABLE `surgery_staff` DISABLE KEYS */;
INSERT INTO `surgery_staff` VALUES (1,1,NULL,1,'Lead Surgeon','2026-11-17 01:14:12','2026-11-17 01:14:12'),(2,2,NULL,1,'Lead Surgeon','2026-11-17 01:14:25','2026-11-17 01:14:25');
/*!40000 ALTER TABLE `surgery_staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_categories`
--

DROP TABLE IF EXISTS `test_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_categories_department_id_foreign` (`department_id`),
  CONSTRAINT `test_categories_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_categories`
--

LOCK TABLES `test_categories` WRITE;
/*!40000 ALTER TABLE `test_categories` DISABLE KEYS */;
INSERT INTO `test_categories` VALUES (1,1,'Hematology',1,'2026-09-16 00:57:18','2026-09-16 00:57:18');
/*!40000 ALTER TABLE `test_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_package_items`
--

DROP TABLE IF EXISTS `test_package_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_package_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `test_package_id` bigint(20) unsigned NOT NULL,
  `test_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_package_items_test_package_id_foreign` (`test_package_id`),
  KEY `test_package_items_test_id_foreign` (`test_id`),
  CONSTRAINT `test_package_items_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `test_package_items_test_package_id_foreign` FOREIGN KEY (`test_package_id`) REFERENCES `test_packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_package_items`
--

LOCK TABLES `test_package_items` WRITE;
/*!40000 ALTER TABLE `test_package_items` DISABLE KEYS */;
INSERT INTO `test_package_items` VALUES (1,2,2,NULL,NULL),(2,2,1,NULL,NULL),(3,2,3,NULL,NULL);
/*!40000 ALTER TABLE `test_package_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_packages`
--

DROP TABLE IF EXISTS `test_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `test_packages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_packages`
--

LOCK TABLES `test_packages` WRITE;
/*!40000 ALTER TABLE `test_packages` DISABLE KEYS */;
INSERT INTO `test_packages` VALUES (1,'Master Health Checkup','master-health-checkup','Comprehensive body checkup including 60+ tests.',5000.00,4500.00,NULL,'active',1,'2026-09-20 02:57:51','2026-09-20 02:57:51'),(2,'Dustin Mcleod','dustin-mcleod','Ab expedita et debit',680.00,600.00,NULL,'active',75,'2026-09-23 03:38:25','2026-09-23 03:38:25');
/*!40000 ALTER TABLE `test_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_parameter_ranges`
--

DROP TABLE IF EXISTS `test_parameter_ranges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_parameter_ranges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_parameter_ranges`
--

LOCK TABLES `test_parameter_ranges` WRITE;
/*!40000 ALTER TABLE `test_parameter_ranges` DISABLE KEYS */;
/*!40000 ALTER TABLE `test_parameter_ranges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_parameters`
--

DROP TABLE IF EXISTS `test_parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_parameters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `test_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `reference_range` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `test_parameters_test_id_foreign` (`test_id`),
  CONSTRAINT `test_parameters_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_parameters`
--

LOCK TABLES `test_parameters` WRITE;
/*!40000 ALTER TABLE `test_parameters` DISABLE KEYS */;
INSERT INTO `test_parameters` VALUES (1,NULL,NULL,1,'Hemoglobin (Hb)','g/dL','Male: 13.8-17.2, Female: 12.1-15.1',1),(2,NULL,NULL,1,'Total RBC count','millions/cumm','4.5 - 5.5',2),(3,NULL,NULL,1,'Total WBC count','cells/cumm','4000 - 11000',3),(4,NULL,NULL,1,'Platelet count','lakhs/cumm','1.5 - 4.5',4),(5,NULL,NULL,1,'Neutrophils','%','40 - 75',5),(6,NULL,NULL,1,'Lymphocytes','%','20 - 45',6),(7,NULL,NULL,1,'Monocytes','%','2 - 10',7),(8,NULL,NULL,1,'Eosinophils','%','1 - 6',8),(9,NULL,NULL,2,'Blood Glucose (Random)','mg/dL','< 140',1);
/*!40000 ALTER TABLE `test_parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_result_values`
--

DROP TABLE IF EXISTS `test_result_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_result_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `test_result_id` bigint(20) unsigned NOT NULL,
  `test_parameter_id` bigint(20) unsigned NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_result_values_test_result_id_foreign` (`test_result_id`),
  KEY `test_result_values_test_parameter_id_foreign` (`test_parameter_id`),
  CONSTRAINT `test_result_values_test_parameter_id_foreign` FOREIGN KEY (`test_parameter_id`) REFERENCES `test_parameters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `test_result_values_test_result_id_foreign` FOREIGN KEY (`test_result_id`) REFERENCES `test_results` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_result_values`
--

LOCK TABLES `test_result_values` WRITE;
/*!40000 ALTER TABLE `test_result_values` DISABLE KEYS */;
INSERT INTO `test_result_values` VALUES (1,'2026-09-22 23:36:02','2026-09-22 23:36:02',3,1,'10',NULL),(2,'2026-09-22 23:36:02','2026-09-22 23:36:02',3,2,'2',NULL),(3,'2026-09-22 23:36:02','2026-09-22 23:36:02',3,3,'3',NULL),(4,'2026-09-22 23:36:02','2026-09-22 23:36:02',3,4,'1',NULL),(5,'2026-09-22 23:36:02','2026-09-22 23:36:02',3,5,'30',NULL),(6,'2026-09-22 23:36:02','2026-09-22 23:36:02',3,6,'10',NULL),(7,'2026-09-22 23:36:02','2026-09-22 23:36:02',3,7,'2',NULL),(8,'2026-09-22 23:36:02','2026-09-22 23:36:02',3,8,'3',NULL);
/*!40000 ALTER TABLE `test_result_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_results`
--

DROP TABLE IF EXISTS `test_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `diagnostic_order_id` bigint(20) unsigned NOT NULL,
  `test_id` bigint(20) unsigned NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `result_value` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_results_diagnostic_order_id_foreign` (`diagnostic_order_id`),
  KEY `test_results_test_id_foreign` (`test_id`),
  KEY `test_results_patient_id_foreign` (`patient_id`),
  CONSTRAINT `test_results_diagnostic_order_id_foreign` FOREIGN KEY (`diagnostic_order_id`) REFERENCES `diagnostic_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `test_results_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `test_results_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_results`
--

LOCK TABLES `test_results` WRITE;
/*!40000 ALTER TABLE `test_results` DISABLE KEYS */;
INSERT INTO `test_results` VALUES (3,1,1,2,'Detailed Report',NULL,'Completed','2026-09-22 23:36:02','2026-09-22 23:36:02');
/*!40000 ALTER TABLE `test_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `review` text NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT 5,
  `photo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,'laptop','Gulshan, Dhaka','kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk',5,'testimonials/9ZACug9wWqyB5xXJg0rK1vohbZFE6hk58X3uMbsf.jpg',1,'2026-09-23 03:05:44','2026-09-23 03:05:44'),(2,'panjabi short mens','Mohakhali, Dhaka','jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjkdgjhPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient Reviews',5,'testimonials/tkunwhxjLPMsnikuwZhkPsX8lyivXLOCNu6YgWa9.webp',1,'2026-09-23 03:06:06','2026-09-23 03:06:06'),(3,'Nadia Islam','Gulshan, Dhaka','gPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient Reviews',5,'testimonials/AwjcnLo2eqhtm0Umhl1VrZih20Q0jpOb6n4KfYqI.jpg',1,'2026-09-23 03:06:28','2026-09-23 03:06:28'),(4,'panjabi short mens','Gulshan, Dhaka','Patient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient Reviews',5,'testimonials/kPeP3GtG5ZKHgZElhWkKGUe4cybYWX46KzJ1blvY.jpg',1,'2026-09-23 03:06:48','2026-09-23 03:06:48'),(5,'Nadia Islam','Mohakhali, Dhaka','Patient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient ReviewsPatient Reviews',5,'testimonials/VmvWNQPFcZSLVst006RtK0FpTS1NazRakGZr74XF.jpg',1,'2026-09-23 03:07:06','2026-09-23 03:07:06');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `test_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  `test_category_id` bigint(20) unsigned DEFAULT NULL,
  `specimen_type` varchar(255) DEFAULT NULL,
  `container` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `turnaround_time` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tests_test_code_unique` (`test_code`),
  KEY `tests_department_id_foreign` (`department_id`),
  KEY `tests_test_category_id_foreign` (`test_category_id`),
  CONSTRAINT `tests_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tests_test_category_id_foreign` FOREIGN KEY (`test_category_id`) REFERENCES `test_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
INSERT INTO `tests` VALUES (1,'CBC-01','Complete Blood Count (CBC)',1,1,NULL,NULL,500.00,200.00,NULL,1,'2026-09-16 00:57:18','2026-09-16 00:57:18'),(2,'RBS-01','Random Blood Sugar (RBS)',1,1,NULL,NULL,150.00,50.00,NULL,1,'2026-09-16 00:57:18','2026-09-16 00:57:18'),(3,'TST-0003','ECG',3,NULL,NULL,NULL,1000.00,0.00,24,1,'2026-09-22 23:01:48','2026-09-22 23:01:48');
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@example.com','2026-09-16 00:57:18','$2y$12$gOmwLaL.FtLzxUGIDxuNh.CfEBW/rTUr0/CR3/BlIsxhbs1pIsn06','dksiWb4bXPLulkNdkhzkt85jdPLdlfr30wIYYsc0SBmOSpcJtoegKh0f8GvQ',NULL,1,'2026-09-16 00:57:18','2026-09-16 00:57:18'),(2,'Hasan Parvez','admin@dc.com',NULL,'$2y$12$Ca1ezLO.47hQmSv3hrVR9eWR3EmY.J.XUW.TVgqrEaypDDKha42yu',NULL,NULL,1,'2026-09-16 22:42:35','2026-09-16 22:42:35'),(3,'Hasan Parvez','admin@10.com',NULL,'$2y$12$iekFnK1mRENT7z.f3wOM0OdCVpA2EzXgku6eGjQPK5MfDT5NETtmq',NULL,NULL,1,'2026-09-16 23:41:46','2026-09-16 23:41:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `visit_id` varchar(255) NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `appointment_id` bigint(20) unsigned DEFAULT NULL,
  `visit_date` date NOT NULL,
  `symptoms` varchar(255) DEFAULT NULL,
  `blood_pressure` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `temperature` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `visits_visit_id_unique` (`visit_id`),
  KEY `visits_patient_id_foreign` (`patient_id`),
  KEY `visits_doctor_id_foreign` (`doctor_id`),
  KEY `visits_appointment_id_foreign` (`appointment_id`),
  CONSTRAINT `visits_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `visits_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `visits_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
INSERT INTO `visits` VALUES (2,'VST-260917-0001',1,3,3,'2026-09-17','d','120/80','80','98.0','gggg','Pending','2026-09-16 23:21:57','2026-09-16 23:23:58');
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wards`
--

DROP TABLE IF EXISTS `wards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'General',
  `floor` varchar(255) DEFAULT NULL,
  `gender_type` varchar(255) NOT NULL DEFAULT 'Mixed',
  `capacity` int(11) NOT NULL DEFAULT 0,
  `daily_charge` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wards_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wards`
--

LOCK TABLES `wards` WRITE;
/*!40000 ALTER TABLE `wards` DISABLE KEYS */;
INSERT INTO `wards` VALUES (1,'General Ward (Male)','GWM-01','Male','2nd Floor','Male',10,800.00,'Active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(2,'General Ward (Female)','GWF-01','Female','2nd Floor','Female',10,800.00,'Active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(3,'Intensive Care Unit (ICU)','ICU-01','ICU','3rd Floor','Mixed',6,5000.00,'Active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(4,'Coronary Care Unit (CCU)','CCU-01','CCU','3rd Floor','Mixed',6,4500.00,'Active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(5,'VIP Cabin Block','CAB-VIP','VIP','4th Floor','Mixed',5,3500.00,'Active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34'),(6,'Pediatric / NICU','NICU-01','NICU','3rd Floor','Pediatric',4,4000.00,'Active',NULL,'2026-11-17 00:17:34','2026-11-17 00:17:34');
/*!40000 ALTER TABLE `wards` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-17 13:18:43
