-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2024 at 05:21 AM
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
(1, 'AdminUser', 'AdminPass', 'Nelwin Rosales');

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
(2, 'ClerkUser', 'ClerkPass', 'Clerk. Aileen Gonzaga', 'doc4.jpeg');

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
(72, 'DocUser', 'DocPass', 'Dr. Victoria Rodriguez', 'profile.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `patient_info`
--

CREATE TABLE `patient_info` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
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
  `heartrate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_info`
--

INSERT INTO `patient_info` (`id`, `username`, `password`, `name`, `guardian`, `address`, `contactnum`, `age`, `sex`, `civil_status`, `dob`, `weight`, `height`, `bloodpressure`, `heartrate`) VALUES
(1, 'wawe', '123456', 'Nelwin Rosales_ officials', 'nanay', 'byab', '+639508449785', '21', 'male', 'single', '09/0802', '67', 'hs', 'bsh', 'bahh'),
(2, 'gaimar', '', 'Gaimar Mendoza ', 'nanay', 'binubusan', '+639508449785', '21', 'male', 'single', '090802', '64 kg ', '5\'6 ', '150/100', '67'),
(3, 'nelwin', 'wawe', 'Nelwin Rosales_ officials', 'nanay', 'gsgs', '44', '9494948', 'bsbs', 'vsvs', 'baba', 'bzbz', 'bsb', 'bsv', 'bsvs'),
(4, ' s ', 'bsb', 'bzb', 'bzbz', 'bzbz', '97', '9494', 'bsb', 'bzbs', 'bzbb', 'bav', 'bzbs', 'bsbs', 'bsbs'),
(5, 'bdh', 'jdb', 'bxb', 'bxbd', 'ncb', '98', '659', 'bc ', 'bcb', 'bxb', 'nxb', 'nxb', 'ncb', 'nxb'),
(6, 'nelwin', 'wawe', 'nelwinrosales', 'nanay', 'bayabasan', '0905', '25', 'male', 'hege', 'bava', 'bah', 'bsb', 'bsb', 'bzb'),
(7, 'nelwin', 'wawe', 'nelwinrosales', 'nanay', 'bayabasan', '0905', '25', 'male', 'hege', 'bava', 'bah', 'bsb', 'bsb', 'bzb'),
(8, 'nelwin', 'wawe', 'nelwinrosales', 'nanay', 'bayabasan', '0905', '25', 'male', 'hege', 'bava', 'bah', 'bsb', 'bsb', 'bzb'),
(9, 'nelwin', 'wawe', 'nelwinrosales', 'nanay', 'bayabasan', '0905', '25', 'male', 'hege', 'bava', 'bah', 'bsb', 'bsb', 'bzb'),
(10, 'nelwin', 'wawe', 'nelwinrosales', 'nanay', 'bayabasan', '0905', '25', 'male', 'hege', 'bava', 'bah', 'bsb', 'bsb', 'bzb'),
(11, 'nelwin', 'wawe', 'nelwinrosales', 'nanay', 'bayabasan', '0905', '25', 'male', 'hege', 'bava', 'bah', 'bsb', 'bsb', 'bzb'),
(12, 'nelwin', 'wawe', 'Nelwin', 'nanay', 'babayah', '9494', '21', 'male', 'civil', 'babn', 'bab', 'hsb', 'babb', 'baba'),
(13, 'hehe', 'nab', 'Nelwin Rosales_ officials', 'hshs', 'bah', '97', '979', 'bzb', 'bzb', 'bzvs', 'bsb', 'bsb', 'bsbbsb', 'jsj'),
(14, 'baba', 'bab', 'Nelwin Rosales_ officials', 'nsbs', 'nsbbsgzgz', '99', '9794', 'bsba', 'bB', 'bzb', '979', '9794', 'bsbs', 'nbzbz'),
(15, 'gah', 'nsn', 'Nelwin Rosales_ officials', 'bsbb', 'bxb', '979', '9494', 'bsbs', 'bzbs', 'bzbz', '979', '9494', 'bsbs', '9494'),
(16, 'hsh', 'nzbs', 'Nelwin Rosales_ officials', 'bxbs', 'bxbdbhsgshh', '97', '979', 'bzv', 'bV', 'vzvz', '21', '56', 'vzv', '979'),
(17, 'nelwin', 'wawe', 'nelwin rosales', 'nanay', 'bayabasan', '+639508449785', '123459', 'c', 'vV', 'bzb', '949', '979', 'cavn', 'vVa'),
(18, 'hello', '123', 'Nelwin Rosales_ officials', 'hsh', 'nsbhsh', '949', '949', 'bB', 'bav', 'bB', '94', '9848', 'hah', 'bab'),
(19, 'nelwin', 'wawe', 'Nelwin Rosales_ officials', 'nanay', 'bayabasan', '+639508449785', '21', 'male', 'single', '090802', '52', '888', 'cca', 'vV'),
(20, 'nelwin', 'wawe', 'Nelwin Rosales_ officials', 'nanay', 'hzhah', '979', '9794', 'bzvs', 'bava', '9787', 'hdh', 'bsbb', 'sbshsh', 'bavahs'),
(50, 'patient', 'patient123', 'Nelwin Rosales', 'Celia Rosales', 'Bayabasan', '09508449785', '21', 'Male', 'Single', '09/08/02', '56', '5\'6', '100', '24'),
(51, 'ewaw', 'wawe123', 'Nelwin', 'nanay', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'Male', 'single', '2024-07-15', '45', '5\'6', '100', '50'),
(57, 'root', '', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'Male', 'Single', '2024-07-17', '45', '', '100', '50'),
(59, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'Male', 'Single', '2024-07-24', '45', '0', '100', '50'),
(60, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', 'dsd', '21', 'Male', 'single', '2024-07-16', '45', '55', '100', '50'),
(61, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', 'dsd', '21', 'Male', 'single', '2024-07-16', '45', '55', '100', '50'),
(62, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', 'dsd', '21', 'Male', 'single', '2024-07-16', '45', '55', '100', '50'),
(63, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', 'dsd', '21', 'Male', 'single', '2024-07-02', '45', '55', '100', '50'),
(64, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', 'dsd', '21', 'Male', 'single', '2024-07-02', '45', '55', '100', '50'),
(65, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', 'dsd', '21', 'Male', 'single', '2024-07-02', '45', '55', '100', '50'),
(66, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', 'dsd', '21', 'Male', 'single', '2024-07-16', '45', '55', '100', '50'),
(67, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'Male', 'Single', '2024-07-16', '45', '5\'6', '100', '50'),
(68, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'Male', 'Single', '2024-07-16', '45', '5\'6', '100', '50'),
(69, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'bayabasan', '0986', '21', 'Male', 'single', '2024-07-16', '45', '233', '100', '50'),
(70, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'bff', 'rr', '21', 'Male', 'single', '2024-07-16', '45', '233', 'we', '10'),
(71, 'nelwin2', '123456', 'ROSALES, NELWIN', 'nanay', 'bff', 'rr', '21', 'Male', 'single', '2024-07-16', '45', '233', 'we', '10'),
(72, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'fd', 'sss', '21', 'Male', 'single', '2024-07-17', '45', '233', '100', '122'),
(73, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'bshhbs', '09508449785', '21', 'Male', 'single', '2024-07-16', '45', '233', '100', '122'),
(74, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'bshhbs', '09508449785', '21', 'Male', 'single', '2024-07-16', '45', '233', '100', '122'),
(75, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'eehdd', '09508449785', '21', 'Male', 'single', '2024-07-17', '45', '56', '100', '50'),
(76, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'baba', '09508449785', '21', 'Male', 'single', '2024-07-24', '45', '56', '100', '50'),
(77, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'baba', '09508449785', '21', 'Male', 'single', '2024-07-24', '45', '56', '100', '50'),
(78, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'baba', '09508449785', '21', 'Male', 'single', '2024-07-24', '45', '56', '100', '50'),
(79, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'baba', '09508449785', '21', 'Male', 'single', '2024-07-24', '45', '56', '100', '50'),
(80, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'bayabasan', '09508449785', '21', 'Male', 'single', '2024-07-24', '45', '56', '100', '50'),
(81, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'bayabasan', '09508449785', '21', 'Male', 'single', '2024-07-24', '45', '56', '100', '50'),
(82, 'wawe', '123456', 'ROSALES, NELWIN', 'nanay', 'bayabasan', '09508449785', '21', 'Male', 'single', '2024-07-24', '45', '56', '100', '50'),
(83, 'clerk', 'clerk123', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-17', '45', '67', '100', '50'),
(84, 'clerk', 'clerk123', 'ROSALES, NELWIN', 'nanay', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-17', '45', '67', '100', '50'),
(85, 'johnpaul', '123456', 'John Paul Bautista', 'floyd', 'bayabasan', '+639508449785', '21', 'male', 'single', '090802', '56', '5\'6', '56', '100'),
(86, 'karen', 'karen18', 'Karen Hernandez', 'mingky', 'banilad', '+639508449785', '12', 'female', 'single', '06-18-02', '36', '5\'', '80/100', 'normal'),
(87, 'admin', '123456', 'ROSALES, NELWIN', 'nanay', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '21', 'male', 'single', '2024-07-18', '45', '5\'6', '100', '50'),
(88, 'admin', '123456', 'ROSALES, NELWIN', 'nanay', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '21', 'male', 'single', '2024-07-18', '45', '5\'6', '100', '50'),
(89, 'admin', '123456', 'ROSALES, NELWIN', 'nanay', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '21', 'male', 'single', '2024-07-18', '45', '5\'6', '100', '50'),
(90, 'admin', '123456', 'ROSALES, NELWIN', 'nanay', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '21', 'male', 'single', '2024-07-18', '45', '5\'6', '100', '50'),
(91, 'admin', '123456', 'ROSALES, NELWIN', 'nanay', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '5\'6', '100', '50'),
(92, 'admin', '123456', 'ROSALES, NELWIN', 'nanay', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '5\'6', '100', '50'),
(93, 'admin', '123456', 'ROSALES, NELWIN', 'nanay', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '5\'6', '100', '50'),
(94, 'admin', '123456', 'ROSALES, NELWIN', 'nanay', '0097, 0087 SITIO BAYABASAN, NASUGBU, BATANGAS', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '5\'6', '100', '50'),
(95, 'patient16', 'nsjnsd', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(96, 'patient17', 'patient17', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-18', '45', '56', '100', '50'),
(97, 'patient19', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(98, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(99, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(100, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(101, 'clerk1', 'clerk123', 'ddd', 'ddd', 'Bayabasan, Nasugbu, Batangas', '095021', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(102, 'clerk1', 'clerk123', 'ddd', 'ddd', 'Bayabasan, Nasugbu, Batangas', '095021', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(103, 'clerk1', 'clerk123', 'ddd', 'ddd', 'Bayabasan, Nasugbu, Batangas', '095021', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(104, 'clerk1', 'clerk123', 'ddd', 'ddd', 'Bayabasan, Nasugbu, Batangas', '095021', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(105, 'clerk1', 'clerk123', 'ddd', 'ddd', 'Bayabasan, Nasugbu, Batangas', '095021', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(106, 'clerk1', 'clerk123', 'ddd', 'ddd', 'Bayabasan, Nasugbu, Batangas', '095021', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(107, 'clerk1', 'clerk123', 'jose', 'ddd', 'Bayabasan, Nasugbu, Batangas', '095021', '21', 'male', 'single', '2024-07-17', '45', '56', '100', '50'),
(108, 'clerk1', 'clerk123', 'ddd', 'ddd', 'Bayabasan, Nasugbu, Batangas', '095021', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(109, 'clerk1', 'clerk123', 'ddd', 'ddd', 'Bayabasan, Nasugbu, Batangas', '095021', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(110, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(111, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(112, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(113, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(114, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(115, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-25', '45', '56', '100', '50'),
(116, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-24', '45', '56', '100', '50'),
(117, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(118, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-01', '45', '56', '100', '50'),
(119, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(120, 'nhorgie', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-19', '45', '56', '100', '50'),
(121, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-18', '45', '5\'6', '100', '50'),
(122, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'jose', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-17', '45', '5\'6', '100', '50'),
(123, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-02', '45', '5\'6', '100', '50'),
(124, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'married', '2024-07-17', '45', '5\'6', '100', '50'),
(125, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-17', '45', '5\'6', '100', '50'),
(126, 'clerk1', 'clerk123', 'NELWIN Digma ROSALES', 'ddd', 'Bayabasan, Nasugbu, Batangas', '09508449785', '21', 'male', 'single', '2024-07-20', '45', '5\'6', '100', '50');

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_log`
--
ALTER TABLE `admin_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clerk_log`
--
ALTER TABLE `clerk_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_log`
--
ALTER TABLE `doctor_log`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_log`
--
ALTER TABLE `admin_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clerk_log`
--
ALTER TABLE `clerk_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctor_log`
--
ALTER TABLE `doctor_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `patient_info`
--
ALTER TABLE `patient_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `patient_log`
--
ALTER TABLE `patient_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
