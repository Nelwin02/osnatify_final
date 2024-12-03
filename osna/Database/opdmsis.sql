-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 04:16 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opdmsis`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_log`
--

CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_log`
--

INSERT INTO `admin_log` (`id`, `username`, `password`, `name`) VALUES
(1, 'Admin', 'Admin123', 'Victoria Rodriguez');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `message`, `date`) VALUES
(3, 'Announcement', 'We wish to inform you that, starting November 5, 2024, the Outpatient Department will implement new operating hours to better serve our community.\r\n\r\nNew OPD Hours:\r\n\r\nMonday to Friday: 8:00 AM to 5:00 PM\r\nSaturday: 9:00 AM to 1:00 PM\r\nSunday: Closed', '2024-08-26 01:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `guardian` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clerk_log`
--

CREATE TABLE `clerk_log` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `clerk_name` varchar(50) NOT NULL,
  `clerk_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clerk_log`
--

INSERT INTO `clerk_log` (`id`, `username`, `password`, `clerk_name`, `clerk_image`) VALUES
(2, 'Clerk', 'Clerk123', 'Clerk. Aileen Gonzaga', 'doc4.jpeg'),
(3, 'clerk1', 'clerk123', 'clerk3', 'mer.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_confirm`
--

CREATE TABLE `doctor_confirm` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `diagnosis` text NOT NULL,
  `prescription` text NOT NULL,
  `frequency` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `first_take` time DEFAULT NULL,
  `second_take` time DEFAULT NULL,
  `third_take` time DEFAULT NULL,
  `fourth_take` time DEFAULT NULL,
  `fifth_take` time DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_confirm`
--

INSERT INTO `doctor_confirm` (`id`, `username`, `diagnosis`, `prescription`, `frequency`, `duration`, `first_take`, `second_take`, `third_take`, `fourth_take`, `fifth_take`, `status`) VALUES
(62, '03 065', 'cold', 'Neozep', 2, 5, '19:42:00', '19:39:00', NULL, NULL, NULL, 'taken'),
(63, '02 097', 'gastritis', 'pain medication', 4, 0, '15:35:00', '15:39:00', '15:35:00', '15:38:00', NULL, 'taken'),
(160, '07 096', 'Urinary Tract Infection', 'Antibiotics', 3, 5, '01:00:00', '01:00:00', '01:00:00', NULL, NULL, 'pending'),
(161, '01 050', 'Influenza', 'Antivirals', 2, 4, '13:00:00', '17:00:00', NULL, NULL, NULL, 'pending'),
(162, '01 049', 'Anxiety', 'Anxiolytics', 2, 4, '13:00:00', '19:00:00', NULL, NULL, NULL, 'pending'),
(163, '08 007', 'Gastritis', 'Antacid medication', 2, 4, '13:00:00', '17:00:00', NULL, NULL, NULL, 'pending'),
(164, '04 054', 'Covid-19', 'Isolate and consult a doctor ', 2, 4, '13:00:00', '17:00:00', NULL, NULL, NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_log`
--

CREATE TABLE `doctor_log` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `doctor_name` varchar(50) NOT NULL,
  `doctor_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_log`
--

INSERT INTO `doctor_log` (`id`, `username`, `password`, `doctor_name`, `doctor_image`) VALUES
(72, 'Doctor', 'Doctor123', 'Dr. Victoria Rodriguez', 'profile.jpeg'),
(73, 'Doctor', 'doctor1234', 'dr  jp', 'doc5.jpg'),
(74, 'DocUser2', 'DocPass', 'dr  jp', 'mer.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `created_at`) VALUES
(1, 'New patient added: NELWIN Digma ROSALES (newwlll)', '2024-09-19 03:56:34'),
(2, 'New patient added:\nName: \nUsername: \nCreated Time: 2024-09-19 06:31:39', '2024-09-19 04:31:39'),
(3, 'New patient added:\nName: \nUsername: \nCreated Time: 2024-09-19 06:44:39', '2024-09-19 04:44:39');

-- --------------------------------------------------------

--
-- Table structure for table `old_patient`
--

CREATE TABLE `old_patient` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `predicted_disease` text DEFAULT NULL,
  `disease` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `medication` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_info`
--

CREATE TABLE `patient_info` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `guardian` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `contactnum` varchar(50) NOT NULL,
  `age` varchar(50) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `civil_status` varchar(50) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `height` varchar(50) NOT NULL,
  `bloodpressure` varchar(50) NOT NULL,
  `heartrate` varchar(50) NOT NULL,
  `symptoms` varchar(255) NOT NULL,
  `predicted_disease` varchar(255) NOT NULL,
  `predicted_prescription` varchar(255) NOT NULL,
  `predicted_treatment` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('pending','approved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_info`
--

INSERT INTO `patient_info` (`id`, `username`, `password`, `email`, `name`, `guardian`, `address`, `contactnum`, `age`, `sex`, `civil_status`, `dob`, `weight`, `height`, `bloodpressure`, `heartrate`, `symptoms`, `predicted_disease`, `predicted_prescription`, `predicted_treatment`, `date_created`, `status`) VALUES
(1, '01 001', '01 100', 'nelwinrosales08@gmail.com', 'Juan Dela Cruz', 'Jose Dela Cruz', 'Brgy. Wawa, Nasugbu, Batangas', '555-0001', '35', 'M', 'Single', '1988-05-14', '75', '180', '120/80', '72', 'Fever', 'Influenza', 'Antivirals', 'Rest and hydration', '2024-10-30 15:29:44', 'pending'),
(2, '01 002', '01 002', 'gaimarmendoza@gmail.com', 'Maria Clara', 'Ana Clara', 'Brgy. Calayo, Nasugbu, Batangas', '555-0002', '29', 'F', 'Married', '1994-08-23', '68', '165', '115/75', '70', 'sakit ng tyan ko', 'Diagnosis: Stomach flu, food poisoning, gastritis', 'Treatment: Avoiding solid foods, staying hydrated, taking prescribed medication', 'N/A', '2024-11-06 08:47:45', 'pending'),
(3, '01 003', '01 003', 'johnpaulbautista@gmail.com', 'Pedro Alcaraz', 'Luis Alcaraz', 'Brgy. Kaylaway, Nasugbu, Batangas', '555-0003', '42', 'M', 'Married', '1981-03-12', '82', '175', '130/85', '78', 'Headache', 'Migraine', 'Pain relievers', 'Rest in dark room', '2023-01-02 16:00:00', 'pending'),
(4, '01 004', '01 004', 'nelwinrosales08@gmail.com', 'Ana Reyes', 'Isabel Reyes', 'Brgy. Pantalan, Nasugbu, Batangas', '555-0004', '27', 'F', 'Single', '1996-11-30', '60', '160', '110/70', '68', 'Dizziness', 'Anemia', 'Iron supplements', 'Diet rich in iron', '2023-01-03 16:00:00', 'pending'),
(5, '01 005', '01 005', 'gaimarmendoza@gmail.com', 'Carlos Garcia', 'Ramon Garcia', 'Brgy. Looc, Nasugbu, Batangas', '555-0005', '50', 'M', 'Married', '1973-07-15', '85', '178', '140/90', '80', 'Back Pain', 'Muscle Strain', 'Painkillers', 'Physical therapy', '2023-01-04 16:00:00', 'pending'),
(6, '01 006', '01 006', 'johnpaulbautista@gmail.com', 'Elena Mendoza', 'Lucia Mendoza', 'Brgy. Bucana, Nasugbu, Batangas', '555-0006', '32', 'F', 'Single', '1991-06-01', '58', '162', '118/76', '74', 'Cough', 'Bronchitis', 'Cough suppressant', 'Avoid irritants', '2023-01-05 16:00:00', 'pending'),
(7, '01 007', '01 007', 'nelwinrosales08@gmail.com', 'Miguel Torres', 'Juan Torres', 'Brgy. Balaytigue, Nasugbu, Batangas', '555-0007', '45', 'M', 'Married', '1978-09-05', '78', '182', '135/90', '76', 'Fatigue', 'Hypertension', 'Beta-blockers', 'Exercise and diet', '2023-01-06 16:00:00', 'pending'),
(8, '01 008', '01 008', 'gaimarmendoza@gmail.com', 'Laura Santos', 'Rosa Santos', 'Brgy. Butucan, Nasugbu, Batangas', '555-0008', '37', 'F', 'Married', '1986-12-20', '65', '167', '122/80', '71', 'Headache', 'Tension Headache', 'Pain relievers', 'Relaxation techniques', '2023-01-07 16:00:00', 'pending'),
(9, '01 009', '01 009', 'johnpaulbautista@gmail.com', 'Rafael Castillo', 'Oscar Castillo', 'Brgy. Lumbangan, Nasugbu, Batangas', '555-0009', '52', 'M', 'Single', '1971-04-25', '90', '185', '145/95', '85', 'Chest Pain', 'Angina', 'Nitrates', 'Reduced physical exertion', '2023-01-08 16:00:00', 'pending'),
(10, '01 010', '01 010', 'nelwinrosales08@gmail.com', 'Grace Ramirez', 'Amelia Ramirez', 'Brgy. Cogunan, Nasugbu, Batangas', '555-0010', '28', 'F', 'Single', '1995-10-13', '55', '158', '118/75', '69', 'Abdominal Pain', 'Gastritis', 'Antacids', 'Diet modification', '2023-01-09 16:00:00', 'pending'),
(11, '01 011', '01 011', 'gaimarmendoza@gmail.com', 'Paolo Morales', 'Jorge Morales', 'Brgy. Malapad na Bato, Nasugbu, Batangas', '555-0011', '39', 'M', 'Married', '1984-07-21', '88', '176', '128/84', '80', 'Joint Pain', 'Arthritis', 'Anti-inflammatories', 'Physical therapy', '2023-01-10 16:00:00', 'pending'),
(12, '01 012', '01 012', 'johnpaulbautista@gmail.com', 'Carmen Tan', 'Rafael Tan', 'Brgy. Aga, Nasugbu, Batangas', '555-0012', '33', 'F', 'Single', '1990-11-08', '65', '159', '120/80', '72', 'Sore Throat', 'Pharyngitis', 'Lozenges', 'Avoid irritants', '2023-01-11 16:00:00', 'pending'),
(13, '01 013', '01 013', 'nelwinrosales08@gmail.com', 'Mario Lopez', 'Fernando Lopez', 'Brgy. Lumangbayan, Nasugbu, Batangas', '555-0013', '44', 'M', 'Married', '1979-02-14', '87', '174', '132/82', '77', 'Skin Rash', 'Allergic Reaction', 'Antihistamines', 'Avoid allergens', '2023-01-12 16:00:00', 'pending'),
(14, '01 014', '01 014', 'gaimarmendoza@gmail.com', 'Alfredo Cruz', 'Carlo Cruz', 'Brgy. Pook, Nasugbu, Batangas', '555-0014', '30', 'M', 'Single', '1993-09-22', '78', '181', '126/78', '74', 'Fatigue', 'Thyroid Issues', 'Thyroid medication', 'Regular check-ups', '2023-01-13 16:00:00', 'pending'),
(15, '01 015', '01 015', 'johnpaulbautista@gmail.com', 'Daisy Villanueva', 'Ruth Villanueva', 'Brgy. Alinigan, Nasugbu, Batangas', '555-0015', '29', 'F', 'Single', '1994-11-15', '50', '157', '115/72', '67', 'Migraines', 'Migraine', 'Prescription pain relievers', 'Rest in dark room', '2023-01-14 16:00:00', 'pending'),
(16, '01 016', '01 016', 'nelwinrosales08@gmail.com', 'Jorge Ortega', 'Luis Ortega', 'Brgy. Poblacion, Nasugbu, Batangas', '555-0016', '54', 'M', 'Married', '1969-05-30', '80', '179', '140/85', '82', 'Diabetes Symptoms', 'Diabetes', 'Insulin', 'Dietary management', '2023-01-15 16:00:00', 'pending'),
(17, '01 017', '01 017', 'gaimarmendoza@gmail.com', 'Liza Fernandez', 'Clara Fernandez', 'Brgy. Mahabang Parang, Nasugbu, Batangas', '555-0017', '41', 'F', 'Single', '1982-03-19', '70', '164', '121/80', '73', 'Nausea', 'Gastroenteritis', 'Antiemetics', 'Hydration', '2023-01-16 16:00:00', 'pending'),
(18, '01 018', '01 018', 'johnpaulbautista@gmail.com', 'Victor Reyes', 'Rodolfo Reyes', 'Brgy. Talisay, Nasugbu, Batangas', '555-0018', '38', 'M', 'Married', '1985-08-09', '79', '172', '125/80', '76', 'Shortness of Breath', 'Asthma', 'Bronchodilators', 'Avoid triggers', '2023-01-17 16:00:00', 'pending'),
(19, '01 019', '01 019', 'nelwinrosales08@gmail.com', 'Karen Bautista', 'Ana Bautista', 'Brgy. San Jose, Nasugbu, Batangas', '555-0019', '27', 'F', 'Single', '1996-06-11', '58', '160', '115/75', '69', 'Chest Tightness', 'Anxiety', 'Anxiolytics', 'Cognitive behavioral therapy', '2023-01-18 16:00:00', 'pending'),
(20, '01 020', '01 020', 'gaimarmendoza@gmail.com', 'Benito Castillo', 'Rafael Castillo', 'Brgy. Nasugbu, Nasugbu, Batangas', '555-0020', '48', 'M', 'Single', '1975-04-20', '86', '180', '142/92', '84', 'Fever', 'Malaria', 'Antimalarials', 'Rest and hydration', '2023-01-19 16:00:00', 'pending'),
(21, '01 021', '01 021', 'johnpaulbautista@gmail.com', 'Jessica Torres', 'Marta Torres', 'Brgy. Mangas, Nasugbu, Batangas', '555-0021', '30', 'F', 'Married', '1993-12-01', '62', '162', '119/77', '71', 'Cold Symptoms', 'Common Cold', 'Decongestants', 'Rest and fluids', '2023-01-20 16:00:00', 'pending'),
(22, '01 022', '01 022', 'nelwinrosales08@gmail.com', 'Mario Garcia', 'Carlos Garcia', 'Brgy. G. Araneta, Nasugbu, Batangas', '555-0022', '56', 'M', 'Single', '1967-09-15', '90', '176', '150/95', '88', 'Severe Headache', 'Migraines', 'Prescription pain relievers', 'Rest and hydration', '2023-01-21 16:00:00', 'pending'),
(23, '01 023', '01 023', 'gaimarmendoza@gmail.com', 'Sophia Lim', 'Anna Lim', 'Brgy. Luyos, Nasugbu, Batangas', '555-0023', '34', 'F', 'Married', '1989-03-27', '64', '164', '117/73', '70', 'Cough', 'Bronchitis', 'Antibiotics', 'Avoid irritants', '2023-01-22 16:00:00', 'pending'),
(24, '01 024', '01 024', 'johnpaulbautista@gmail.com', 'Felipe Cruz', 'Miguel Cruz', 'Brgy. Bignay, Nasugbu, Batangas', '555-0024', '47', 'M', 'Married', '1976-05-12', '84', '178', '135/85', '76', 'Stomach Pain', 'Peptic Ulcer', 'Proton pump inhibitors', 'Avoid spicy foods', '2023-01-23 16:00:00', 'pending'),
(25, '01 025', '01 025', 'nelwinrosales08@gmail.com', 'Ana Santos', 'Lucia Santos', 'Brgy. Olo-Olo, Nasugbu, Batangas', '555-0025', '29', 'F', 'Single', '1994-01-05', '53', '159', '110/70', '66', 'Sore Throat', 'Tonsillitis', 'Antibiotics', 'Rest and hydration', '2023-01-24 16:00:00', 'pending'),
(26, '01 026', '01 026', 'gaimarmendoza@gmail.com', 'Emilio Ramos', 'Jose Ramos', 'Brgy. Lumangbayan, Nasugbu, Batangas', '555-0026', '36', 'M', 'Single', '1987-10-22', '80', '175', '140/88', '83', 'Back Pain', 'Muscle Strain', 'Pain relief', 'Rest and hydration', '2023-01-25 16:00:00', 'pending'),
(27, '01 027', '01 027', 'johnpaulbautista@gmail.com', 'Clara Gonzalez', 'Ana Gonzalez', 'Brgy. Kabilang Baryo, Nasugbu, Batangas', '555-0027', '31', 'F', 'Married', '1992-06-18', '62', '161', '118/76', '72', 'Fatigue', 'Hypothyroidism', 'Thyroid medication', 'Regular check-ups', '2023-01-26 16:00:00', 'pending'),
(28, '01 028', '01 028', 'nelwinrosales08@gmail.com', 'Rico Garcia', 'Pablo Garcia', 'Brgy. Lumbangan, Nasugbu, Batangas', '555-0028', '50', 'M', 'Married', '1973-11-05', '89', '180', '145/90', '85', 'Diabetes Symptoms', 'Diabetes', 'Insulin', 'Dietary management', '2023-01-27 16:00:00', 'pending'),
(29, '01 029', '01 029', 'gaimarmendoza@gmail.com', 'Luisa Tan', 'Sara Tan', 'Brgy. G. Araneta, Nasugbu, Batangas', '555-0029', '42', 'F', 'Married', '1981-08-15', '65', '163', '125/80', '70', 'Skin Rash', 'Allergic Reaction', 'Antihistamines', 'Avoid allergens', '2023-01-28 16:00:00', 'pending'),
(30, '01 030', '01 030', 'johnpaulbautista@gmail.com', 'Mark Rivera', 'Antonio Rivera', 'Brgy. Nasugbu, Nasugbu, Batangas', '555-0030', '29', 'M', 'Single', '1994-12-30', '75', '177', '129/82', '72', 'Nausea', 'Gastroenteritis', 'Antiemetics', 'Hydration', '2023-01-29 16:00:00', 'pending'),
(31, '01 031', '01 031', 'nelwinrosales08@gmail.com', 'Jasmine Cruz', 'Elena Cruz', 'Brgy. Santisima, Nasugbu, Batangas', '555-0031', '38', 'F', 'Single', '1985-09-25', '62', '159', '118/76', '70', 'Cough', 'Allergies', 'Antihistamines', 'Avoid allergens', '2023-01-30 16:00:00', 'pending'),
(32, '01 032', '01 032', 'gaimarmendoza@gmail.com', 'Eugene Reyes', 'Manuel Reyes', 'Brgy. Talisay, Nasugbu, Batangas', '555-0032', '54', 'M', 'Married', '1969-01-14', '84', '180', '145/90', '80', 'Shortness of Breath', 'Asthma', 'Inhalers', 'Avoid triggers', '2023-01-31 16:00:00', 'pending'),
(33, '01 033', '01 033', 'johnpaulbautista@gmail.com', 'Viola Santos', 'Marta Santos', 'Brgy. Lumbangan, Nasugbu, Batangas', '555-0033', '33', 'F', 'Single', '1990-06-22', '65', '165', '120/80', '71', 'Fever', 'Influenza', 'Antivirals', 'Rest and hydration', '2023-02-01 16:00:00', 'pending'),
(34, '01 034', '01 034', 'nelwinrosales08@gmail.com', 'Pablo Jimenez', 'Luis Jimenez', 'Brgy. Kabilang Baryo, Nasugbu, Batangas', '555-0034', '45', 'M', 'Married', '1978-02-11', '80', '177', '134/84', '78', 'Abdominal Pain', 'Gastritis', 'Antacids', 'Diet modification', '2023-02-02 16:00:00', 'pending'),
(35, '01 035', '01 035', 'gaimarmendoza@gmail.com', 'Selena Cruz', 'Martha Cruz', 'Brgy. Poblacion, Nasugbu, Batangas', '555-0035', '26', 'F', 'Single', '1997-03-15', '54', '160', '118/75', '68', 'Chest Pain', 'Anxiety', 'Pain relief', 'Cognitive behavioral therapy', '2023-02-03 16:00:00', 'pending'),
(36, '01 036', '01 036', 'johnpaulbautista@gmail.com', 'Liam Reyes', 'Sofia Reyes', 'Brgy. Mangas, Nasugbu, Batangas', '555-0036', '37', 'M', 'Married', '1986-05-29', '70', '172', '130/85', '75', 'Nausea', 'Gastroenteritis', 'Antiemetics', 'Hydration', '2023-02-04 16:00:00', 'pending'),
(37, '01 037', '01 037', 'nelwinrosales08@gmail.com', 'Isabella Torres', 'Maria Torres', 'Brgy. Luyos, Nasugbu, Batangas', '555-0037', '44', 'F', 'Single', '1979-11-10', '66', '165', '120/75', '73', 'Fatigue', 'Hypothyroidism', 'Thyroid medication', 'Regular check-ups', '2023-02-05 16:00:00', 'pending'),
(38, '01 038', '01 038', 'gaimarmendoza@gmail.com', 'Daniel Mendoza', 'Roberto Mendoza', 'Brgy. Nasugbu, Nasugbu, Batangas', '555-0038', '31', 'M', 'Married', '1992-07-15', '80', '175', '140/90', '80', 'Shortness of Breath', 'Asthma', 'Inhalers', 'Avoid triggers', '2023-02-06 16:00:00', 'pending'),
(39, '01 039', '01 039', 'johnpaulbautista@gmail.com', 'Oliver Cruz', 'Natalia Cruz', 'Brgy. Poblacion, Nasugbu, Batangas', '555-0039', '28', 'M', 'Single', '1995-08-23', '72', '178', '123/82', '74', 'Cough', 'Bronchitis', 'Antibiotics', 'Avoid irritants', '2023-02-07 16:00:00', 'pending'),
(40, '01 040', '01 040', 'nelwinrosales08@gmail.com', 'Amelia Garcia', 'Lucas Garcia', 'Brgy. Santisima, Nasugbu, Batangas', '555-0040', '39', 'F', 'Single', '1984-12-12', '68', '160', '119/78', '69', 'laging sumasakit ang tyan at nag susuka', 'Diagnosis: stomach ache, nausea, vomiting', 'Prescription: antiemetic, pain reliever, antacid', 'Treatment: rest, hydrate, eat bland foods', '2024-11-06 14:46:16', 'pending'),
(41, '01 041', '01 041', 'gaimarmendoza@gmail.com', 'Evelyn Ramos', 'Julius Ramos', 'Brgy. Olo-Olo, Nasugbu, Batangas', '555-0041', '50', 'F', 'Married', '1973-05-17', '85', '170', '135/85', '76', 'Stomach Pain', 'Gastritis', 'Antacids', 'Diet modification', '2023-02-09 16:00:00', 'pending'),
(42, '01 042', '01 042', 'johnpaulbautista@gmail.com', 'Santiago Cruz', 'Ignacio Cruz', 'Brgy. G. Araneta, Nasugbu, Batangas', '555-0042', '35', 'M', 'Single', '1988-11-15', '70', '174', '130/80', '73', 'Fatigue', 'Hypothyroidism', 'Thyroid medication', 'Regular check-ups', '2023-02-10 16:00:00', 'pending'),
(43, '01 043', '01 043', 'nelwinrosales08@gmail.com', 'Lia Santos', 'Maria Santos', 'Brgy. Talisay, Nasugbu, Batangas', '555-0043', '29', 'F', 'Single', '1994-06-21', '55', '162', '115/75', '69', 'Cold Symptoms', 'Common Cold', 'Decongestants', 'Rest and fluids', '2023-02-11 16:00:00', 'pending'),
(44, '01 044', '01 044', 'gaimarmendoza@gmail.com', 'Felix Lim', 'Ana Lim', 'Brgy. Nasugbu, Nasugbu, Batangas', '555-0044', '48', 'M', 'Married', '1975-02-17', '82', '178', '140/85', '75', 'Fever', 'Malaria', 'Antimalarials', 'Rest and hydration', '2023-02-12 16:00:00', 'pending'),
(45, '01 045', '01 045', 'johnpaulbautista@gmail.com', 'Sophia Garcia', 'Martha Garcia', 'Brgy. Lumbangan, Nasugbu, Batangas', '555-0045', '37', 'F', 'Married', '1986-10-28', '64', '160', '120/80', '72', 'Nausea', 'Gastroenteritis', 'Antiemetics', 'Hydration', '2023-02-13 16:00:00', 'pending'),
(46, '01 046', '01 046', 'nelwinrosales08@gmail.com', 'Mark Rivera', 'Antonio Rivera', 'Brgy. G. Araneta, Nasugbu, Batangas', '555-0046', '45', 'M', 'Single', '1978-05-21', '75', '179', '135/90', '78', 'Cough', 'Bronchitis', 'Antibiotics', 'Avoid irritants', '2023-02-14 16:00:00', 'pending'),
(47, '01 047', '01 047', 'gaimarmendoza@gmail.com', 'Julia Torres', 'Laura Torres', 'Brgy. Santisima, Nasugbu, Batangas', '555-0047', '31', 'F', 'Married', '1992-11-08', '65', '162', '120/80', '71', 'Fatigue', 'Anemia', 'Iron supplements', 'Dietary adjustments', '2023-02-15 16:00:00', 'pending'),
(48, '01 048', '01 048', 'johnpaulbautista@gmail.com', 'Hugo Garcia', 'Mateo Garcia', 'Brgy. Olo-Olo, Nasugbu, Batangas', '555-0048', '29', 'M', 'Single', '1994-04-30', '78', '176', '128/79', '72', 'Shortness of Breath', 'Asthma', 'Inhalers', 'Avoid triggers', '2023-02-16 16:00:00', 'pending'),
(49, '01 049', '01 049', 'nelwinrosales08@gmail.com', 'Olivia Santos', 'Maria Santos', 'Brgy. Talisay, Nasugbu, Batangas', '555-0049', '35', 'F', 'Married', '1988-09-22', '70', '163', '121/81', '70', 'Chest Tightness', 'Anxiety', 'Anxiolytics', 'Cognitive behavioral therapy', '2024-10-30 15:14:02', 'approved'),
(50, '01 050', '01 050', 'gaimarmendoza@gmail.com', 'Carlos Mendoza', 'Isabel Mendoza', 'Brgy. Poblacion, Nasugbu, Batangas', '555-0050', '60', 'M', 'Married', '1963-02-01', '82', '175', '138/88', '80', 'Fever', 'Influenza', 'Antivirals', 'Rest and hydration', '2024-10-30 15:08:42', 'approved'),
(233, '08 007', '05 039', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '25', 'male', 'single', '1999-06-21', '80', '160', '120/80', '80', 'Masakit ang tyan ko, nasusuka pa ', 'Diagnosis: Gastritis', 'Prescription: Antacid medication', 'Treatment: Rest and avoid spicy or acidic foods', '2024-10-31 04:14:04', 'approved'),
(234, '07 018', '09 072', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '19', 'male', 'single', '2005-06-15', '80', '160', '120/80', '80', 'sumasakit ang mata', 'N/A', 'Not provided', 'N/A', '2024-10-31 05:16:51', 'pending'),
(235, '00 087', '04 055', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '18', 'male', 'single', '2006-06-15', '80', '160', '120/80', '80', '', '', '', '', '2024-10-31 05:29:04', 'pending'),
(236, '09 096', '01 040', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '16', 'male', 'single', '2008-07-15', '80', '160', '120/80', '80', '', '', '', '', '2024-10-31 05:30:46', 'pending'),
(237, '04 054', '08 008', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '25', 'male', 'single', '1999-06-15', '80', '160', '120/80', '80', 'mahirap huminga, walang panglasa, walang pang amoy, may lagnat', 'Diagnosis: Covid-19', 'Prescription: Isolate and consult a doctor for further evaluation', 'Treatment: Follow medical advice and rest at home', '2024-10-31 05:56:38', 'approved'),
(238, '05 002', '08 009', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'single', '2024-11-07', '', '', '', '', '', '', '', '', '2024-11-02 00:14:45', 'pending'),
(239, '00 031', '05 089', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '18', 'male', 'single', '2006-06-13', '', '', '', '', '', '', '', '', '2024-11-02 00:16:21', 'pending'),
(240, '02 032', '09 099', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'married', '2024-11-13', '', '', '', '', '', '', '', '', '2024-11-02 00:17:19', 'pending'),
(241, '01 081', '07 055', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'single', '2024-11-12', '', '', '', '', '', '', '', '', '2024-11-02 00:20:51', 'pending'),
(242, '03 004', '01 020', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '15', 'male', 'single', '2009-06-08', '', '', '', '', '', '', '', '', '2024-11-02 00:24:37', 'pending'),
(243, '02 048', '00 028', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'single', '2024-11-11', '', '', '', '', '', '', '', '', '2024-11-02 00:26:51', 'pending'),
(244, '00 079', '08 046', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '0', 'male', 'single', '2024-06-02', '', '', '', '', '', '', '', '', '2024-11-02 00:27:45', 'pending'),
(245, '00 015', '09 028', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'single', '2024-11-05', '', '', '', '', '', '', '', '', '2024-11-02 00:28:45', 'pending'),
(246, '03 022', '05 068', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'single', '2024-11-05', '', '', '', '', '', '', '', '', '2024-11-02 00:29:32', 'pending'),
(247, '03 045', '09 038', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'single', '2024-11-05', '', '', '', '', '', '', '', '', '2024-11-02 00:31:39', 'pending'),
(248, '06 035', '00 020', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'single', '2024-11-05', '', '', '', '', 'masakit ang tyan\r\n', 'Diagnosis: Gastritis, Ulcer, Irritable Bowel Syndrome', 'Prescription: Antacids, Proton pump inhibitors, H2 blockers', 'Treatment: Avoiding spicy foods, stress management, dietary changes', '2024-11-02 00:55:55', 'pending'),
(249, '04 012', '00 014', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'single', '2024-11-04', '46', '5\'6', '120/80', '50', '', '', '', '', '2024-11-02 02:36:02', 'pending'),
(253, '01 096', '08 008', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '-1', 'male', 'single', '2024-11-12', '', '', '', '', '', '', '', '', '2024-11-06 02:02:58', 'pending'),
(254, '09 092', '02 097', 'nelwinrosales08@gmail.com', 'Nelwin Rosales', 'Laura Moore', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '42', 'male', 'single', '1982-06-15', '', '', '', '', 'masakit ang ulo ', 'Diagnosis: headache, migraine, tension', 'Prescription: painkillers, rest, hydration', 'Treatment: massage, relaxation, meditation', '2024-11-06 15:09:24', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `patient_log`
--

CREATE TABLE `patient_log` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_log`
--

INSERT INTO `patient_log` (`id`, `username`, `password`) VALUES
(1, 'wawe', 'wawe02'),
(2, 'wawe', 'wawe02'),
(3, 'nelwin', 'nelwin02'),
(4, 'nelwinrosales', 'nelwin02'),
(5, 'nelwin02', 'nelwin08'),
(6, 'gaimar', 'gamimar2'),
(7, 'johnpaul', 'jp123'),
(8, 'wawe12', 'wawe123'),
(9, 'nelw', 'ndr'),
(10, 'karen', 'karen123'),
(11, 'hehe', 'nsns'),
(12, 'hshvjs', 'ndndj'),
(13, 'bsbz', 'nzjaj'),
(14, 'nshsb', 'nsjs'),
(15, 'hshsj', 'bshsh'),
(16, 'bzh', 'jsj'),
(17, 'bshhs', 'nsjah'),
(18, 'gahah', 'vsgs'),
(19, 'bahsb', 'msmkan'),
(20, 'bdjs', 'vdheh'),
(21, 'hegs', 'sbdgs'),
(22, 'bshav', 'bshwu'),
(23, 'bshsgg', 'bsgag'),
(24, 'vav', 'naba'),
(25, 'bG', 'gzgs'),
(26, 'bzvz', 'gG'),
(27, 'vv', 'gg'),
(28, 'h h h', 'h  h'),
(29, 'nabzg', 'nBsgsg'),
(30, ' sv', 'baba'),
(31, 'bsvgsg', 'bahsg'),
(87, 'vv', '123');

-- --------------------------------------------------------

--
-- Table structure for table `prediction`
--

CREATE TABLE `prediction` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `symptoms` text NOT NULL,
  `predicted_disease` text DEFAULT NULL,
  `predicted_prescription` text DEFAULT NULL,
  `predicted_treatment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prediction`
--

INSERT INTO `prediction` (`id`, `username`, `symptoms`, `predicted_disease`, `predicted_prescription`, `predicted_treatment`, `created_at`) VALUES
(87, '02 058', 'laging napapa utot', 'Possible disease: Irritable bowel syndrome (IBS)', 'Prescription: Antispasmodic medication', 'Treatment: Dietary changes, stress management techniques', '2024-09-23 03:51:06'),
(88, '08 074', 'laging nasusuka', 'Possible diseases: Gastroesophageal reflux disease (GERD), gastritis, peptic ulcer', 'Prescriptions: Antacids, proton pump inhibitors, H2 blockers', 'Treatments: Avoiding trigger foods, eating smaller meals, elevating the head of the bed, avoiding lying down after eating', '2024-09-23 04:42:28'),
(91, '07 091', 'fever', 'Possible diseases: Influenza, common cold, strep throat', 'Treatments: Rest, staying hydrated, over-the-counter cold and flu medications', 'N/A', '2024-09-23 22:55:05'),
(92, '06 078', 'fever', 'Disease: COVID-19', 'Prescription: None, but may require hospitalization in severe cases', 'Treatment: Symptomatic treatment, isolation, monitoring for complications', '2024-09-25 02:37:15'),
(93, '00 052', 'fever, cough', 'Possible diseases:', '3. Fever-reducing medication', 'Treatments:', '2024-09-25 11:01:24'),
(94, '04 035', 'cough, rash, cold', 'Possible diseases:', 'Prescriptions:', '3. Consult a doctor for measles treatment and management', '2024-09-30 05:56:58'),
(95, '07 095', 'cough, diziness', 'Possible disease: Upper respiratory infection', 'Prescription: Cough syrup, decongestants', 'Treatment: Rest, stay hydrated, avoid irritants like smoke', '2024-10-06 04:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `vitalsigns`
--

CREATE TABLE `vitalsigns` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `bloodpressure` varchar(10) DEFAULT NULL,
  `heartrate` varchar(50) DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vitalsigns`
--

INSERT INTO `vitalsigns` (`id`, `username`, `weight`, `height`, `bloodpressure`, `heartrate`, `date_added`) VALUES
(56, '01 001', '58', '4.6', '120', '50', '2024-11-06 02:51:37'),
(57, '01 001', '58', '4.6', '120', '50', '2024-11-06 02:58:41'),
(58, '01 001', '58', '4.6', '120', '50', '2024-11-06 08:25:28'),
(59, '09 092', '58', '4.6', '120', '50', '2024-11-06 13:24:08'),
(60, '09 092', '58', '4.6', '120', '50', '2024-11-06 13:33:25'),
(61, '01 096', '58', '4.6', '120', '50', '2024-11-06 14:37:45'),
(62, '04 012', '58', '4.6', '120', '50', '2024-11-06 14:40:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_log`
--
ALTER TABLE `admin_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clerk_log`
--
ALTER TABLE `clerk_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_confirm`
--
ALTER TABLE `doctor_confirm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_log`
--
ALTER TABLE `doctor_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `old_patient`
--
ALTER TABLE `old_patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_info`
--
ALTER TABLE `patient_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_log`
--
ALTER TABLE `patient_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `prediction`
--
ALTER TABLE `prediction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vitalsigns`
--
ALTER TABLE `vitalsigns`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clerk_log`
--
ALTER TABLE `clerk_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctor_confirm`
--
ALTER TABLE `doctor_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `doctor_log`
--
ALTER TABLE `doctor_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `old_patient`
--
ALTER TABLE `old_patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_info`
--
ALTER TABLE `patient_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `patient_log`
--
ALTER TABLE `patient_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `prediction`
--
ALTER TABLE `prediction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `vitalsigns`
--
ALTER TABLE `vitalsigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
