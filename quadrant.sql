-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2017 at 03:03 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quadrant`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_info`
--

CREATE TABLE `client_info` (
  `id` int(11) NOT NULL,
  `name_` varchar(200) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `sex` varchar(8) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password_` varchar(200) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_name` varchar(200) DEFAULT NULL,
  `account_no` varchar(15) DEFAULT NULL,
  `nok_name` varchar(200) DEFAULT NULL,
  `nok_email` varchar(200) DEFAULT NULL,
  `nok_phone` varchar(15) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `nok_sex` varchar(8) DEFAULT NULL,
  `nok_dob` date DEFAULT NULL,
  `nok_address` varchar(300) DEFAULT NULL,
  `new_application` varchar(5) DEFAULT NULL,
  `investment_type` varchar(100) DEFAULT NULL,
  `verification_code` varchar(100) NOT NULL,
  `verified` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_info`
--

INSERT INTO `client_info` (`id`, `name_`, `phone`, `sex`, `dob`, `address`, `email`, `password_`, `bank_name`, `account_name`, `account_no`, `nok_name`, `nok_email`, `nok_phone`, `relationship`, `nok_sex`, `nok_dob`, `nok_address`, `new_application`, `investment_type`, `verification_code`, `verified`) VALUES
(8, 'Dauda Musideen Ayinde', '07084702950', 'Male', '2017-08-18', '30 abeje street', 'muziyindojava@gmail.com', 'PCRokFJ/oc5xPZOVgP6Je1MFvd5zDgKq8uwjqUpP1TpsGqzBn5KrUPDFjGFUat24IgvyF05To+SC28IvUDF3Gw==', 'First Bank', 'dauda musideen ayinde', '3022096737', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', 'Binary option', 'weXu5', 'yes'),
(11, 'Dauda Jamal', '09023333088', 'Male', '2009-07-15', '64b Nosamu street,ajegunle apapa lagos', 'musideendauda@gmail.com', 'XPeI5/R2a0fwogCbel/WuqMtZ0M1CcVggwb6G0UU/Bbn1XJhaLuytcB8wm+OXH+CJDdLyHb7KUotWTdHq4j4Vg==', 'Fidelity', 'Dauda  Jamal', '3010201219', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', 'Binary option', 'yrd7p', 'no'),
(10, 'victor maxw', '09077555996', 'Male', '1994-07-28', '12 ojora  street, ajegunle, apapa,lagos', 'victormaxwellmind@gmail.com', 'UPh2tMZ5QW7+vm7BQ0qpJcQ9jdpsM0ypruEPPWLV79QyBV0Ln6AbYq+CNRLDtKZtAjsewn7pmloDdEz77Svbag==', 'Zenith Bank', 'Victor Maxwell', '1010202030', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', 'Binary option', 'Q54jL', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `investment`
--

CREATE TABLE `investment` (
  `id` int(11) NOT NULL,
  `type_` varchar(100) DEFAULT NULL,
  `amount` varchar(200) DEFAULT NULL,
  `duration` varchar(200) DEFAULT NULL,
  `maturity_amount` varchar(200) DEFAULT NULL,
  `investment_return_paid` varchar(8) DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `proposed_starting_date` date DEFAULT NULL,
  `actual_starting_date` date DEFAULT NULL,
  `made_payment` varchar(8) DEFAULT NULL,
  `approved` varchar(8) DEFAULT NULL,
  `date_approved` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_info`
--
ALTER TABLE `client_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment`
--
ALTER TABLE `investment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_info`
--
ALTER TABLE `client_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `investment`
--
ALTER TABLE `investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
