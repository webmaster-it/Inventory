-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 08:43 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_master`
--

CREATE TABLE `category_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `adddatetimess` varchar(225) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_master`
--

INSERT INTO `category_master` (`id`, `code`, `name`, `description`, `status`, `adddatetimess`, `updated_at`) VALUES
(1, '10', 'ACL ELITE', 'PT APTT', 'Active', '', '2025-04-17 12:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `department_master`
--

CREATE TABLE `department_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department_master`
--

INSERT INTO `department_master` (`id`, `code`, `name`, `description`, `status`, `updated_at`) VALUES
(1, '10', 'Hematology', 'ACL ELITE', 'Active', '2025-04-16 18:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `grnn`
--

CREATE TABLE `grnn` (
  `id` int(11) NOT NULL,
  `grn_number` varchar(20) DEFAULT NULL,
  `po_id` varchar(45) DEFAULT NULL,
  `vendorname` varchar(225) NOT NULL,
  `received_by` varchar(225) DEFAULT NULL,
  `invoice_number` varchar(50) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `freeze` varchar(225) NOT NULL,
  `freezer` varchar(225) NOT NULL,
  `rooms` varchar(225) NOT NULL,
  `grn_datetime` datetime DEFAULT current_timestamp(),
  `grndatetimesin` varchar(225) NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('Accepted','Pending Authorization') DEFAULT 'Accepted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grnn`
--

INSERT INTO `grnn` (`id`, `grn_number`, `po_id`, `vendorname`, `received_by`, `invoice_number`, `invoice_date`, `freeze`, `freezer`, `rooms`, `grn_datetime`, `grndatetimesin`, `remarks`, `status`) VALUES
(1, 'GRN1745654999', 'PO1745654887', 'Biocell Medicare', 'rahnuma', 'abc123', '2025-04-26', '2-4', '4-5', '20-21', '2025-04-26 13:39:59', '2025-04-26 13:38:41', NULL, 'Accepted'),
(2, 'GRN1745788402', 'PO1745654887', 'Biocell Medicare', 'rahnuma', '7828', '2025-04-28', '6', '', '', '2025-04-28 02:43:22', '2025-04-26 13:38:41', NULL, 'Accepted'),
(3, 'GRN1745788546', 'PO1745788472', 'Biocell Medicare', 'rahnuma', 'hh', '2025-04-28', '', '', '', '2025-04-28 02:45:46', '2025-04-28 02:45:14', NULL, 'Accepted'),
(4, 'GRN1747807633', '', '', 'rahnuma', '', '0000-00-00', '', '', '', '2025-05-21 11:37:13', '', NULL, 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `grn_item`
--

CREATE TABLE `grn_item` (
  `id` int(11) NOT NULL,
  `grn_id` int(11) DEFAULT NULL,
  `purchaseorderitem` varchar(45) NOT NULL,
  `item_code` varchar(45) DEFAULT NULL,
  `batch_no` varchar(50) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `expiryday` varchar(225) NOT NULL,
  `received_qty` int(11) DEFAULT NULL,
  `temperature_logged` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grn_item`
--

INSERT INTO `grn_item` (`id`, `grn_id`, `purchaseorderitem`, `item_code`, `batch_no`, `expiry_date`, `expiryday`, `received_qty`, `temperature_logged`) VALUES
(1, 1, '1', 'ITM250417', '', '0000-00-00', '', 2, NULL),
(2, 1, '2', 'ITM1745048310', '', '0000-00-00', '', 3, NULL),
(3, 2, '1', 'ITM250417', '', '0000-00-00', '', 1, NULL),
(4, 3, '3', 'ITM1745048310', '', '0000-00-00', '', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `indent`
--

CREATE TABLE `indent` (
  `id` int(11) NOT NULL,
  `indent_number` varchar(20) NOT NULL,
  `indent_type` enum('Self','On Behalf') DEFAULT 'Self',
  `indentor_code` varchar(10) NOT NULL,
  `requested_for_code` varchar(10) DEFAULT NULL,
  `indent_date` datetime DEFAULT current_timestamp(),
  `status` enum('Requested','Issued','Cancelled') DEFAULT 'Requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `indent_item`
--

CREATE TABLE `indent_item` (
  `id` int(11) NOT NULL,
  `indent_id` int(11) NOT NULL,
  `item_code` varchar(10) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `id` int(11) NOT NULL,
  `issue_number` varchar(20) DEFAULT NULL,
  `indent_id` int(11) DEFAULT NULL,
  `issued_by` varchar(10) DEFAULT NULL,
  `issued_to` varchar(10) DEFAULT NULL,
  `issue_date` datetime DEFAULT current_timestamp(),
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `issue_item`
--

CREATE TABLE `issue_item` (
  `id` int(11) NOT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `item_code` varchar(10) DEFAULT NULL,
  `batch_no` varchar(50) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item_master`
--

CREATE TABLE `item_master` (
  `id` int(11) NOT NULL,
  `code` varchar(225) NOT NULL,
  `name` varchar(150) NOT NULL,
  `category_code` varchar(10) DEFAULT NULL,
  `subcategory_code` varchar(10) DEFAULT NULL,
  `unit_code` varchar(10) DEFAULT NULL,
  `department_codes` text DEFAULT NULL,
  `vendor_codes` text DEFAULT NULL,
  `manufacturer` varchar(225) NOT NULL,
  `manufacturer_code` varchar(10) DEFAULT NULL,
  `temperature_code` varchar(10) DEFAULT NULL,
  `reorder_level` int(11) DEFAULT 0,
  `batch_tracking` tinyint(1) DEFAULT 0,
  `min_expiry_days` int(11) DEFAULT 0,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `purchase_unit` varchar(50) DEFAULT NULL,
  `issue_unit` varchar(50) DEFAULT NULL,
  `conversion_factor` decimal(10,2) DEFAULT 1.00,
  `pack_size` varchar(50) DEFAULT NULL,
  `default_vendor` varchar(225) DEFAULT NULL,
  `default_rate` decimal(10,2) DEFAULT 0.00,
  `opening_stock` decimal(10,2) DEFAULT 0.00,
  `min_order_qty` decimal(10,2) DEFAULT 0.00,
  `storage_location` varchar(50) DEFAULT NULL,
  `storage_temp` varchar(50) DEFAULT NULL,
  `expiry_applicable` tinyint(1) DEFAULT 0,
  `purchase_lead_time` int(11) DEFAULT 0,
  `tax` decimal(5,2) DEFAULT 0.00,
  `amcc` varchar(225) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `secondary_vendors` text DEFAULT NULL,
  `secondary_vendorsrates` text NOT NULL,
  `testname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`id`, `code`, `name`, `category_code`, `subcategory_code`, `unit_code`, `department_codes`, `vendor_codes`, `manufacturer`, `manufacturer_code`, `temperature_code`, `reorder_level`, `batch_tracking`, `min_expiry_days`, `status`, `updated_at`, `purchase_unit`, `issue_unit`, `conversion_factor`, `pack_size`, `default_vendor`, `default_rate`, `opening_stock`, `min_order_qty`, `storage_location`, `storage_temp`, `expiry_applicable`, `purchase_lead_time`, `tax`, `amcc`, `photo`, `secondary_vendors`, `secondary_vendorsrates`, `testname`) VALUES
(2, 'ITM250417', 'Hemosil RecombiPlasTin 2G(5x8mL) PT', '10', '1010', NULL, '10', NULL, 'Werfen', '20002950', NULL, 5, 0, 0, 'Active', '2025-04-21 14:22:58', 'UNIT004', 'Set.', '5.00', '1', 'Biocell Medicare', '6500.00', '2.00', '5.00', 'Fridge', '2°C to 8°C', 0, 5, '5.00', '', '', 'Select Vendor,Select Vendor,Select Vendor,Select Vendor,Select Vendor', ',,,,', 'PT , APTT.'),
(4, 'ITM250418', 'Hemosil Calibration plasma(10x1ml)', '10', '1011', NULL, '10', NULL, 'Werfen', '20003700', NULL, 4, 0, 0, 'Active', '2025-04-19 12:55:42', 'UNIT004', 'Bottle', '10.00', '1', 'Biocell Medicare', '7000.00', '2.00', '1.00', 'Fridge', '2°C to 8°C', 0, 5, '12.00', '', '', 'Select Vendor,Select Vendor,Select Vendor,Select Vendor,Select Vendor', ',,,,', ''),
(30, 'ITM1745048310', 'ROTORS 20 POS, 100PK, ACL', '10', '1012', NULL, '10', NULL, 'Werfen', '6800000', NULL, 0, 0, 0, 'Active', '2025-04-19 13:08:30', 'UNIT005', 'Set.', '4.00', '1', 'Biocell Medicare', '18000.00', '0.00', '0.00', '', '', 0, 0, '0.00', '', '', 'Select Vendor,Select Vendor,Select Vendor,Select Vendor,Select Vendor', ',,,,', ''),
(31, 'ITM1745048759', 'Hemosil Cleaning Solutions (Clean A) 500ml', '10', '1012', NULL, '10', NULL, 'Werfen', '9831700', NULL, 1, 0, 0, 'Active', '2025-04-19 13:15:59', 'UNIT006', 'Bottle', '1.00', '1', 'Biocell Medicare', '2000.00', '1.00', '1.00', 'Fridge', '2°C to 8°C', 0, 5, '18.00', '', '', 'Select Vendor,Select Vendor,Select Vendor,Select Vendor,Select Vendor', ',,,,', ''),
(32, 'ITM1745048883', 'Hemosil Cleaning Agent (Clean B) 80ml', '10', '1012', NULL, '10', NULL, 'Werfen', '9832700', NULL, 1, 0, 0, 'Active', '2025-04-19 13:18:03', 'UNIT006', 'Bottle', '1.00', '1', 'Biocell Medicare', '2000.00', '1.00', '1.00', 'Fridge', '2°C to 8°C', 0, 5, '18.00', '', '', 'Select Vendor,Select Vendor,Select Vendor,Select Vendor,Select Vendor', ',,,,', ''),
(33, 'ITM1745049001', 'Hemosil Wash-R 1000ml', '10', '1012', NULL, '10', NULL, 'Werfen', '20002400', NULL, 4, 0, 0, 'Active', '2025-04-19 13:20:01', 'UNIT006', 'Bottle', '1.00', '1', 'Biocell Medicare', '3000.00', '2.00', '2.00', 'Fridge', '2°C to 8°C', 0, 5, '18.00', '', '', 'Select Vendor,Select Vendor,Select Vendor,Select Vendor,Select Vendor', ',,,,', ''),
(34, 'ITM1745049117', 'Hemosil SynthASil (APTT) 5x10ml', '10', '1010', NULL, '10', NULL, 'Werfen', '20006800', NULL, 2, 0, 0, 'Active', '2025-04-19 13:21:57', 'UNIT004', 'Set.', '5.00', '1', 'Biocell Medicare', '16000.00', '4.00', '2.00', 'Fridge', '2°C to 8°C', 0, 5, '12.00', '', '', 'Select Vendor,Select Vendor,Select Vendor,Select Vendor,Select Vendor', ',,,,', ''),
(35, 'ITM1745049230', 'Hemosil Sample Cups 0.5 ml', '10', '1012', NULL, '10', NULL, '', '', NULL, 0, 0, 0, 'Active', '2025-04-19 13:23:50', 'UNIT005', 'Pcs.', '1000.00', '1', 'Select Vendor', '0.00', '0.00', '0.00', '', '', 0, 0, '0.00', '', '', 'Select Vendor,Select Vendor,Select Vendor,Select Vendor,Select Vendor', ',,,,', '');

-- --------------------------------------------------------

--
-- Table structure for table `location_master`
--

CREATE TABLE `location_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `temperature_code` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location_master`
--

INSERT INTO `location_master` (`id`, `code`, `name`, `temperature_code`, `description`, `status`, `updated_at`) VALUES
(1, 'LOC001', 'Store 1 - Fridge', 'Fridge', '', 'Active', '2025-04-16 18:39:05'),
(2, 'LOC002', 'Main Store Rack (Right Side)', 'Room', '', 'Active', '2025-04-16 18:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer_master`
--

CREATE TABLE `manufacturer_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `senior_manager` varchar(100) DEFAULT NULL,
  `senior_email` varchar(100) DEFAULT NULL,
  `senior_phone` varchar(20) DEFAULT NULL,
  `account_manager` varchar(100) DEFAULT NULL,
  `account_email` varchar(100) DEFAULT NULL,
  `account_phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manufacturer_master`
--

INSERT INTO `manufacturer_master` (`id`, `code`, `name`, `senior_manager`, `senior_email`, `senior_phone`, `account_manager`, `account_email`, `account_phone`, `address`, `status`, `updated_at`) VALUES
(1, 'MFR001', 'Werfen', '', '', '', '', '', '', '', 'Active', '2025-04-17 13:12:46');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL,
  `po_number` varchar(45) DEFAULT NULL,
  `vendor_code` text DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('Draft','Pending Authorization','Authorized','Closed') DEFAULT 'Draft',
  `grnupdate` varchar(45) NOT NULL,
  `grndatetimess` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id`, `po_number`, `vendor_code`, `created_by`, `created_at`, `status`, `grnupdate`, `grndatetimess`) VALUES
(1, 'PO1745654887', 'Biocell Medicare', 'admin', '2025-04-26 13:38:07', 'Closed', 'GRN', '2025-04-26 13:38:41'),
(2, 'PO1745788472', 'Biocell Medicare', 'admin', '2025-04-28 02:44:32', 'Closed', 'GRN', '2025-04-28 02:45:14'),
(3, 'PO1745836072', 'Biocell Medicare', 'admin', '2025-04-28 15:57:52', 'Closed', 'GRN', '2025-04-28 15:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_item`
--

CREATE TABLE `purchase_order_item` (
  `id` int(11) NOT NULL,
  `po_id` int(45) DEFAULT NULL,
  `item_code` varchar(45) DEFAULT NULL,
  `manufacturer_code` varchar(225) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `tax` decimal(5,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `current_stock` varchar(225) NOT NULL,
  `deleteitem` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_order_item`
--

INSERT INTO `purchase_order_item` (`id`, `po_id`, `item_code`, `manufacturer_code`, `qty`, `rate`, `tax`, `status`, `current_stock`, `deleteitem`) VALUES
(1, 1, 'ITM250417', '20002950', 2, '6500.00', '5.00', 0, '0', 0),
(2, 1, 'ITM1745048310', '6800000', 5, '18000.00', '0.00', 0, '0', 0),
(3, 2, 'ITM1745048310', '6800000', 2, '18000.00', '0.00', 0, '0', 0),
(4, 3, 'ITM250418', '20003700', 2, '7000.00', '12.00', 0, '0', 0),
(5, 3, 'ITM1745048883', '9832700', 3, '2000.00', '18.00', 0, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reason_master`
--

CREATE TABLE `reason_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staff_master`
--

CREATE TABLE `staff_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `departments` text DEFAULT NULL,
  `linked_user_code` varchar(10) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_master`
--

INSERT INTO `staff_master` (`id`, `code`, `name`, `role`, `contact`, `departments`, `linked_user_code`, `status`, `updated_at`) VALUES
(1, 'STF001', 'KANAK LATA', 'Technician', 'NA', 'Hematology', '', 'Active', '2025-04-17 13:14:36');

-- --------------------------------------------------------

--
-- Table structure for table `stock_ledger`
--

CREATE TABLE `stock_ledger` (
  `id` int(11) NOT NULL,
  `item_code` varchar(10) DEFAULT NULL,
  `batch_no` varchar(50) DEFAULT NULL,
  `txn_type` enum('GRN','Issue','Adjustment') DEFAULT NULL,
  `txn_id` int(11) DEFAULT NULL,
  `txn_date` datetime DEFAULT NULL,
  `qty_in` int(11) DEFAULT 0,
  `qty_out` int(11) DEFAULT 0,
  `balance` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_ledger`
--

INSERT INTO `stock_ledger` (`id`, `item_code`, `batch_no`, `txn_type`, `txn_id`, `txn_date`, `qty_in`, `qty_out`, `balance`, `remarks`) VALUES
(3, 'ITM250417', '', NULL, NULL, NULL, 2, 0, NULL, NULL),
(4, 'ITM1745048', '', NULL, NULL, NULL, 3, 0, NULL, NULL),
(5, 'ITM250417', '', NULL, NULL, NULL, 1, 0, NULL, NULL),
(6, 'ITM1745048', '', NULL, NULL, NULL, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory_master`
--

CREATE TABLE `subcategory_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `category_code` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategory_master`
--

INSERT INTO `subcategory_master` (`id`, `code`, `name`, `category_code`, `description`, `status`, `updated_at`) VALUES
(1, '1010', 'ACL REAGENT', '10', '', 'Active', '2025-04-17 13:10:12'),
(2, '1011', 'ACL CALIBRATOR & CONTROL', '10', '', 'Active', '2025-04-17 13:11:40'),
(3, '1012', 'ACL CONSUMABLE', '10', '', 'Active', '2025-04-17 13:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployee`
--

CREATE TABLE `tblemployee` (
  `empid` int(11) NOT NULL,
  `empname` varchar(100) NOT NULL,
  `empmobile` varchar(100) NOT NULL,
  `empemail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `enterdate` date NOT NULL,
  `loginaccess` varchar(225) NOT NULL,
  `usertype` varchar(225) NOT NULL,
  `experience` int(11) NOT NULL DEFAULT 5,
  `image` varchar(225) NOT NULL,
  `paymentqr` varchar(225) NOT NULL,
  `createdby` varchar(225) NOT NULL,
  `location` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `systemippassword` varchar(225) NOT NULL,
  `passwordchangetime` varchar(225) NOT NULL,
  `addbysystem` varchar(225) NOT NULL,
  `paymentqrr` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblemployee`
--

INSERT INTO `tblemployee` (`empid`, `empname`, `empmobile`, `empemail`, `password`, `designation`, `type`, `enterdate`, `loginaccess`, `usertype`, `experience`, `image`, `paymentqr`, `createdby`, `location`, `status`, `systemippassword`, `passwordchangetime`, `addbysystem`, `paymentqrr`) VALUES
(1, 'Test', '8573929263', 'test', 'test', 'FIELD BOY', 'staff', '2022-02-23', '2025-04-08 11:55:08 am', '', 5, '', 'Q51843328@ybl', '', 'LatLng(lat: 0.0, lng: 0.0)', 1, '', '', '', 'Q51843328.pdf'),
(4, 'Dr. Vipul Bhasin', '9810637037', 'VIPUL', '21021991', 'Lab User', '', '2021-01-10', '2023-08-04 05:50:20am', 'Administrative', 0, '', '', '', '', 1, '', '', '', ''),
(8, 'AZEEM', '9911994840', 'AZEEM', 'AZEEM', 'PHLEBOTOMIST', 'staff', '2021-01-21', '2025-04-20 15:41 PM', '', 5, '', 'Q51843328@ybl', '', '', 1, '', '', '', 'Q51843328.pdf'),
(9, 'NITISH BHARDWAJ', '8851218026', 'NITISH', 'NITISH', 'PHLEBOTOMIST', 'staff', '2021-01-22', '2025-01-13 14:08 PM', '', 7, '', 'Q144215472@ybl', '', '', 0, '', '', '', 'Q144215472.pdf'),
(11, 'DHARMENDRA KUMAR', '9990703607', 'dharmendra', 'dharmendra', 'PHLEBOTOMIST', 'staff', '2021-01-22', '2025-04-22 08:49 AM', '', 7, '', 'Q51986393@ybl', '', '', 1, '', '', '', 'Q51986393.pdf'),
(12, 'IMRAN', '8130481502', 'imran', 'IM', 'PHLEBOTOMIST', 'staff', '2021-01-22', '2023-08-17 11:10 AM', '', 10, '', 'Q067876557@ybl', '', '', 0, '', '', '', 'Q067876557.pdf'),
(13, 'SHASHI BHUSHAN', '9315844775', 'shashi', 'shashi', 'PHLEBOTOMIST', 'staff', '2021-01-22', '2025-02-06 01:11:14 pm', '', 15, '', 'Q62657083@ybl', '', '', 1, '', '', '', 'Q62657083.pdf'),
(14, 'ZAID ', '7065682467', 'query@bhasinpathlabs.com', 'zaid', 'PHLEBOTOMIST', 'staff', '2021-01-22', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(17, 'AMIT GUPTA', '8527654050', 'amitgupta', 'amitgupta', 'PHLEBOTOMIST', 'staff', '2021-01-28', '2023-10-03 09:39:20 am', '', 4, '', 'Q00102443@ybl', '', '', 0, '', '', '', 'Q00102443.pdf'),
(18, 'O P SINGH', '9717370204', 'opsingh@bhasinpathlabs.com', 'opsingh', 'PHLEBOTOMIST', 'staff', '2021-01-28', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(20, 'NEERAJ', '8920162774', 'NEERAJ', '8920162774', 'PHLEBOTOMIST', 'staff', '2021-01-28', '2023-11-26 08:27:21 am', '', 4, '', 'Q51259605@ybl', '', '', 1, '', '', '', 'Q51259605.pdf'),
(21, 'YOGESH KUMAR', '9990726487', 'YOGESH', '9990726487', 'Left', 'staff', '2021-01-28', '2023-01-28 14:44 PM', '', 5, '', 'Q51843328@ybl', '', '', 0, '', '', '', 'Q51843328.pdf'),
(23, 'CANCEL', '9311193111', 'CANCEL', 'CANCEL', 'DATA ENTRY', 'staff', '2021-01-28', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(24, 'ABDUL REHMAN', '85880 36171', '031', '', 'PHLEBOTOMIST', 'staff', '2021-01-29', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(25, 'MARIA', '8287906213', 'MARIA', 'JUSTIN1977', 'PHLEBOTOMIST', 'staff', '2021-01-29', '2022-04-09 08:01:00am', '', 5, '', '', '', '', 1, '', '', '', ''),
(26, 'PANKAJ', '7678622302', 'PANKAJ', '7678622302', 'DATA ENTRY', 'staff', '2021-01-29', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(27, 'MEHJABEE', '9873505448', 'MEHJABEE', 'MEHJABEE', 'DATA ENTRY', 'staff', '2021-01-29', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(29, 'KAVITA', '9354700828', 'KAVITA', '16MANNAT', 'DATA ENTRY', 'staff', '2021-01-29', '2022-03-11 08:34:35pm', '', 6, 'team-2.jpg', '', '', '', 1, '', '', '', ''),
(30, 'SALIM', '9999910870', 'SALIM', '9654441851', 'ADMIN', 'staff', '2021-01-29', '2024-01-21 05:48:41 pm', '', 0, '', '', '', '', 1, '', '', '', ''),
(33, 'SAHIL', '8178876207', 'SAHIL', 'SAHIL', 'DATA ENTRY', 'staff', '2021-01-29', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(34, 'SHAHANA', '7838104597', 'SHAHANA', '987350', 'ADMIN', 'staff', '2021-01-29', '2022-06-15 04:02:55pm', '', 0, '', '', '', '', 1, 'SHAHANA', '2023-10-18 17:28 PM', '', ''),
(36, 'MITHLESH', '7982585437', 'MITHLESH', 'MITHLESH', 'DATA ENTRY', 'staff', '2021-01-30', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(37, 'SALMAN ALI', '9999043691', 'SALMANs', 'SALMAN', 'ADMIN', 'staff', '2021-01-30', '2022-07-13 05:04:12pm', '', 0, '', '', '', '', 0, '', '', '', ''),
(38, 'CHAMAN', '8368889024', 'CHAMAN', 'CHAMAN', 'DATA ENTRY', 'staff', '2021-01-31', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(40, 'YOGESH SAHWAL', '8285980498', 'YOGESH SAHWAL', 'YOGESH', 'administrator', 'staff', '2021-02-01', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(41, 'PRABHA', '9971971657', 'PRABHA', 'PRABHA', 'administrator', 'staff', '2021-02-01', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(42, 'MANISH KUMAR', '9650849830', 'MANISH', 'MANISH ', 'PHLEBOTOMIST', 'staff', '2021-02-02', '2022-12-16 20:46 PM', '', 4, '', 'Q42445696@ybl', '', '', 0, '', '', '', 'Q42445696.pdf'),
(44, 'SAMEER', '9320396105', '301', '123', 'PHELBOTOMIST', 'staff', '2021-02-06', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(46, 'RISHABH', '9953400504', 'RISHABH', '9953400504', 'FIELD BOY', 'staff', '2021-02-09', '2024-03-23 12:31:30 pm', '', 0, '', '', '', '', 1, '', '', '', ''),
(47, 'KANAK LATA', '9910240993', 'kanak', 'kanak', 'Lab User', 'staff', '2021-02-13', '', '', 17, '', '', '', '', 1, '', '', '', ''),
(48, 'AMARJEET', '8800539685', '258', '258', 'PHLEBOTOMIST', 'staff', '2021-02-13', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(49, 'VISHNU', '8700265653', '012', '302', 'PHELBOTOMIST', 'staff', '2021-02-17', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(50, 'NAUMAN ALI', '8130931834', '528', '528', 'PHELBOTOMIST', 'staff', '2021-02-17', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(51, 'MEENAKSHI', '7678378189', '888', '1234', 'DATA ENTRY', 'staff', '2021-02-21', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(52, 'PRAVEEN SINGH', '8317068596', 'praveen@bhasinpathlabs.com', 'praveen', 'PHLEBOTOMIST', 'staff', '2021-02-22', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(53, 'KHUSHAL SINGH RAWAT', '9718487865', 'khushal@bhasinpathlabs.com', 'khushal', 'PHLEBOTOMIST', 'staff', '2021-02-24', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(54, 'SUSHIL', '9717852423', 'SUSHIL', '9717852423', 'PHLEBOTOMIST', 'staff', '2021-02-26', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(55, 'MITESH ', '9643014806', 'mitesh@bhasinpathlabs.com', 'mitesh', 'PHLEBOTOMIST', 'staff', '2021-02-27', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(56, 'KARAM ALI', '8383036512', 'KARAM', 'KARAM', 'PHLEBOTOMIST', 'staff', '2021-03-11', '2022-11-30 13:56 PM', '', 6, '', 'Q42445696@ybl', '', '', 1, '', '', '', 'Q42445696.pdf'),
(57, 'RAKESH KUMAR', '8745984309', 'RAKESH', 'SALMAN', 'administrator', 'staff', '2021-03-21', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(60, 'ABHIMANYU', '9818165532', 'ABHIMANYU', 'ABHIMANYU', 'PHLEBOTOMIST', 'staff', '2021-04-01', '2024-01-23 05:55:00pm', '', 10, '', 'Q51259605@ybl', '', '', 1, '', '', '', 'Q51259605.pdf'),
(61, 'PANKAJKUMAR RANA ', '8126904490', 'PANKAJ RANA ', 'PANKAJRANA', 'PHLEBOTOMIST', 'staff', '2021-04-02', '2022-03-08 10:09:50am', '', 5, '', '', '', '', 0, '', '', '', ''),
(63, 'CENTER', '111', '111', '111', 'CENTER', 'staff', '2021-04-04', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(64, 'KAUSHAL KUMAR  MANDAL', '8851493481', '321', '321', 'PHLEBOTOMIST', 'staff', '2021-04-06', '', '', 5, '', 'Q51259605@ybl', '', '', 1, '', '', '', 'Q51259605.pdf'),
(65, 'SHAMS', '9625123351', 'shams@bhasinpathlabs.com', 'shams', 'PHLEBOTOMIST', 'staff', '2021-04-20', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(66, 'VIKAS KUMR', '8287435147', 'VIKAS', '234', 'PHLEBOTOMIST', 'staff', '2021-04-20', '2023-01-01 16:26 PM', '', 4, '', 'Q51259605@ybl', '', '', 0, '', '', '', 'Q51259605.pdf'),
(67, 'JYOSHNA', '8448420238', 'JYOSHNA', '1997', 'BACK OFFICE', 'staff', '2021-04-22', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(68, 'DEEPSHIKHA', '9380944965', 'DEEPSHIKHA', '2032', 'DATA ENTRY', 'staff', '2021-04-22', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(69, 'ABHISHEK CHAUHAN', '9717009238', 'abhishekrana', 'abhishekrana', 'PHLEBOTOMIST', 'staff', '2021-04-26', '2022-08-01 11:53 AM', '', 5, '', '', '', '', 0, '', '', '', ''),
(70, 'ARVIND', '7836099099', 'ARVIND', 'ARVIND', 'PHLEBOTOMIST', 'staff', '2021-05-02', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(71, 'SANJEET', '7982256085', 'SANJEET', '7982', 'TELLY CALLER', 'staff', '2021-05-06', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(72, 'DEV', '9654007396', 'DEV', '0001', 'TELLY CALLER', 'staff', '2021-05-06', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(73, 'PRIYANKA', '8447623749', 'PRIYANKA', '2025', 'DATA ENTRY', 'staff', '2021-05-13', '', '', 0, '', '', '', '', 1, 'UTI', '2024-09-23 15:32 PM', '', ''),
(74, 'ABHISHEK DALAL', '9716161111', 'ABHISHEKD', '9716161111', '', 'staff', '2021-05-13', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(75, 'FAHEEM', '9871758277', 'FAHEEM', 'FAHEEM', 'PHLEBOTOMIST', 'staff', '2021-06-06', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(76, 'VIPIN MEHRA', '7982243125', 'VIPINMEHRA', '7982243125', '', 'staff', '2021-06-10', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(77, 'GAURAV KUMAR', '9625408470', 'GAURAVKUMAR', '9625408470', 'DATA ENTRY', 'staff', '2021-06-10', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(78, 'AFSANA', '8700462722', 'AFSANA', '786786', 'DATA ENTRY', 'staff', '2021-06-12', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(79, 'YOGITA', '8595510580', 'YOGITA ', '013400', 'DATA ENTRY', 'staff', '2021-06-14', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(80, 'SHIJO', '9582907873', 'SHIJO', '491141', 'DATA ENTRY', 'staff', '2021-06-25', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(81, 'Sakshi pal', '9354780341', 'sakshipal', 'sakshipal', 'Lab User', 'staff', '2021-07-03', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(85, 'AVNISH', '7838107190', 'AVNISH', 'AVNISH', 'Administrator', 'staff', '2021-07-24', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(86, 'RAJEEV (COVID )', '9911121493', 'RAJEEV', 'RAJEEV', 'PHLEBOTOMIST', 'staff', '2021-07-26', '2025-02-09 07:24:56 am', '', 5, '', 'Q51259605@ybl', '', '', 0, '', '', '', 'Q51259605.pdf'),
(88, 'URVASHI', '7827601696', 'SONI', 'URVASHI07', 'DATA ENTRY', 'staff', '2021-07-26', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(89, 'SURAJ', '8527014090', 'SURAJ', 'SURAJ', 'PHLEBOTOMIST', 'staff', '2021-07-28', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(90, 'NAJIM', '9520943415', 'NAJIM', 'NAJIM', 'PHLEBOTOMIST', 'staff', '2021-07-29', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(91, 'ABDUL MUTTLIB', '8630561370', 'ABDUL ', 'ABDUL', 'Administrator', 'staff', '2021-08-02', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(92, 'NAZIM', '9717671665', 'NAZIM', 'NAZIM', 'Administrator', 'staff', '2021-08-02', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(93, 'SAKSHI', '9354780341', 'KAVITA@BHASINPATHLABS.COM', 'SAKSHI', 'LAB USER', 'staff', '2021-08-12', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(94, 'VISHAL', '7042366479', 'VISHAL', 'VISHAL', 'PHLEBOTOMIST', 'staff', '2021-08-14', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(96, 'Shahroz ', '9557609610', 'shahroz@bhasinpathlabs.com', 'shahroz', '', 'staff', '2021-08-28', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(97, 'Hisham', '7351475616', 'hisham@bhasinpathlabs.com', 'hisham', '', 'staff', '2021-08-28', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(98, 'DHANBIR', '7291848485', 'DHANBIR', 'DHANBIR', 'PHLEBOTOMIST', 'staff', '2021-09-06', '2023-05-26 11:15:11am', '', 6, '', 'Q51259605@ybl', '', '', 1, '', '', '', 'Q51259605.pdf'),
(99, 'xyzRAHUL', '8470949860', 'rahul@bhasinpathlabs.com', 'rahul', 'PHLEBOTOMIST', 'staff', '2021-09-07', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(101, 'NANDANI', '9650324179', 'nandanijaiswal714@gmail.com', '12345', 'DATA ENTRY', 'staff', '2021-09-09', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(102, 'ZAID ALI', '8218477817', 'ZAID ALI', 'ZAID ALI', 'Administrator', 'staff', '2021-09-11', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(104, 'SALMAN', '8433112639', 'SALMAN', '8433', 'PHLEBOTOMIST', 'staff', '2021-09-26', '2024-09-06 03:40:20 am', '', 4, '', '', '', '', 0, '', '', '', ''),
(105, 'NANDANI', '9650324179', 'NANDANI', 'NANDANI', '', 'staff', '2021-09-26', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(106, 'ANKITA', '8700004157', 'ANKITA', 'ANKITA', '', 'staff', '2021-09-26', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(107, 'BABITA', '9560579465', 'BABITA', 'BABITA', '', 'staff', '2021-09-26', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(108, 'SONALI', '9654732202', 'SONALI', 'SONALI', 'CUSTOMER CARE', 'staff', '2021-10-11', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(109, 'VIVEK MAAN ', '7310688054', 'VIVEK@BHASINLABS.COM', 'VIVEKMAAN', 'PHLEBOTOMIST', 'staff', '2021-11-22', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(111, 'KARAN', '7982855102', 'KARAN', 'KARAN', 'PHLEBOTOMIST', 'staff', '2021-12-17', '2022-04-19 10:41 AM', '', 6, '', '', '', '', 0, '', '', '', ''),
(112, 'PUSHPENDER', '7500445873', 'PUSHPENDRA', '7500445873', 'PHLEBOTOMIST', 'staff', '2022-01-06', '2023-03-20 21:33 PM', '', 5, '', 'Q51259605@ybl', '', '', 0, '', '', '', 'Q51259605.pdf'),
(113, 'SAHIB ', '9084005165', 'SAHIB', 'SAHIB', 'PHLEBOTOMIST', 'staff', '2022-01-06', '2022-03-01 05:11:37pm', '', 5, '', '', '', '', 0, '', '', '', ''),
(114, 'SIRAJUDDIN', '9315046874', 'SIRAJUDDIN', 'SIRAJUDDIN', 'PHLEBOTOMIST', 'staff', '2022-01-06', '2022-11-22 20:12 PM', '', 5, '', 'Q51843328@ybl', '', '', 0, '', '', '', 'Q51843328.pdf'),
(115, 'AFSHA', '8595713263', 'AFSHA', 'MANNU', 'DATA ENTRY', 'staff', '2022-01-07', '2022-07-13 06:09:25pm', '', 0, '', '', '', '', 0, '', '', '', ''),
(116, 'DIMPLE', '8376825154', 'DIMPLE', '8376825154', 'DATA ENTRY', 'staff', '2022-01-07', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(117, 'NEETU', '8076839546', 'NEETU', '8076839546', 'DATA ENTRY', 'staff', '2022-01-07', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(118, 'VIJAY', '8373928817', 'VIJAY', '8373928817', 'DATA ENTRY', 'staff', '2022-01-07', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(119, 'IFAT', '11111', 'IFAT', '1994', 'DATA ENTRY', 'staff', '2022-01-08', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(120, 'SHWETA ', '96599612475', 'SHWETA', 'SHRUTT', 'TELLY CALLER', 'staff', '2022-01-10', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(121, 'PREETY', '8092519665', 'PREETY', 'preety', 'DATA ENTRY', 'staff', '2022-01-14', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(122, 'YASMEEN', '7982907769', 'YASMEEN', '7982907769', 'DATA ENTRY', 'staff', '2022-01-14', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(123, 'GORAV', '7982307198', 'GORAV', 'GORAV', 'PHLEBOTOMIST', 'staff', '2022-01-16', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(124, 'TASLEEM ', '8800856468', 'TASLEEM_OLD', 'TASLEEM', 'PHLEBOTOMIST', 'staff', '2022-01-16', '2022-03-05 01:32:04pm', '', 5, '', '', '', '', 0, '', '', '', ''),
(127, 'TANYA ', '9650624941', 'taniya', '9650624941', 'PHLEBOTOMIST', 'staff', '2022-02-18', '2022-03-21 04:43:12pm', '', 5, '', 'Q42445696@ybl', '', '', 0, '', '', '', 'Q42445696.pdf'),
(128, 'NEERAJ MANDAL', '7011876467', 'neerajmandal', 'neerajmandal', 'PHLEBOTOMIST', 'staff', '2022-02-19', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(130, 'AJAY', '9871338490', 'AJAY', 'AJAY', 'PHLEBOTOMIST', 'staff', '2022-02-23', '2023-04-22 11:23:22am', '', 5, '', '', '', '', 0, '', '', '', ''),
(131, 'KAMAAL', '9810758436', 'kamal', 'kamal', 'FIELD BOY', 'staff', '2022-02-23', '2025-04-22 11:55 AM', '', 5, '', '', '', '', 1, '', '', '', ''),
(132, 'RAVI KASHYAP', '7289812623', 'ravi kashyap', 'ravikashyap', 'PHLEBOTOMIST', 'staff', '2022-02-23', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(133, 'GIRISH KUMAR', '9667867499', 'girish kumar', 'girishkumar', 'PHLEBOTOMIST', 'staff', '2022-02-23', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(134, 'DINESH POKHRAL', '8800595870', 'dinesh pokhral', 'dineshpokhral', 'PHLEBOTOMIST', 'staff', '2022-02-23', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(135, 'KHEM CHAND', '9953699384', 'khemchand', 'khemchand', 'FIELD BOY', 'staff', '2022-02-23', '2025-04-19 16:16 PM', '', 5, '', '', '', '', 1, '', '', '', ''),
(136, 'KISHAN', '7703844067', 'kishan', 'kishan', 'PHLEBOTOMIST', 'staff', '2022-02-23', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(137, 'SHIV KUMAR', '9643658494', 'shivkumar', 'shivkumar', 'FIELD BOY', 'staff', '2022-02-23', '2025-04-16 02:55 AM', '', 5, '', '', '', '', 1, '', '', '', ''),
(138, 'VIPIN KUMAR', '9045357383', 'vipinkumar', 'vipinkumar', 'FIELD BOY', 'staff', '2022-02-23', '2025-01-20 19:28 PM', '', 5, '', '', '', '', 1, '', '', '', ''),
(139, 'RAVINDER', '9873066942', 'ravinder', 'ravinder', 'PHLEBOTOMIST', 'staff', '2022-02-24', '2022-02-24 04:13:48pm', '', 5, '', '', '', '', 0, '', '', '', ''),
(140, 'SAMARTH', '7836843416', 'SAMARTH', 'SAMARTH', 'PHLEBOTOMIST', 'staff', '2022-02-24', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(141, 'SUDHIR', '8700689210', 'SUDHIR', '8700689210', 'ADMIN', 'staff', '2022-03-12', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(142, 'NEETA', '9873247497', 'NEETA', '9873247497', 'PHLEBOTOMIST', 'staff', '2022-03-22', '2022-03-22 03:28:09pm', '', 5, '', '', '', '', 1, '', '', '', ''),
(143, 'Keshav Bhardwaj', '9990839428', 'KESHAV1', '9990839428', 'DATA ENTRY', 'staff', '2022-03-26', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(144, 'HARI OM ', '8826103910', 'hariom', 'hariom', 'PHLEBOTOMIST', 'staff', '2022-03-30', '2022-07-11 15:42 PM', '', 5, '', '', '', '', 0, '', '', '', ''),
(145, 'SAKSHI ', '9354780341', 'SAKSHI ', 'SAKSHI ', 'PHLEBOTOMIST', 'staff', '2022-04-03', '', '', 5, '', 'Q42445696@ybl', '', '', 0, '', '', '', 'Q42445696.pdf'),
(146, 'NISHITA ', '9319323863', 'NISHITA ', 'NISHITA ', 'PHLEBOTOMIST', 'staff', '2022-04-07', '2022-04-07 09:19:50am', '', 5, '', '', '', '', 0, '', '', '', ''),
(147, 'RAVI SHANKAR ', '9818356861', 'RAVI SHANKAR ', '9818356861', 'PHLEBOTOMIST', 'staff', '2022-04-07', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(148, 'VIMAL ', '8826140791', 'VIMAL ', '8826140791', 'Lab User', 'staff', '2022-04-07', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(149, 'MOHSIN', '8433216763', 'MOHSIN', 'MOHSIN', 'PHLEBOTOMIST', 'staff', '2022-04-09', '2023-04-20 15:59 PM', '', 5, '', 'Q63355577@ybl', '', '', 0, '', '', '', 'Q63355577.pdf'),
(150, 'MEHBOOB ALI', '7466030714', 'mehboob', 'Husaini', 'PHLEBOTOMIST', 'staff', '2022-04-12', '2025-01-13 21:17 PM', '', 5, '', 'Q953067560@ybl', '', '', 0, '', '', '', 'Q953067560.pdf'),
(151, 'KAMNA', '8368006071', 'KAMNA', '8527004823', 'Lab User', 'staff', '2022-04-12', '', '', 0, '', '', '', '', 1, 'Dell790-PC', '2023-10-30 01:55 AM', '', ''),
(152, 'GOPAL KUMAR THAKUR', '8506920095', 'GOPAL', '8506920093', 'PHLEBOTOMIST', 'staff', '2022-04-12', '', '', 10, '', '', '', '', 0, '', '', '', ''),
(153, 'SANJEEV ', '8468817562', 'SANJEEV', '8468817562', 'ADMIN', 'staff', '2022-04-16', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(154, 'VISHU', '9810637037', 'VISHU', '240385', 'Lab User', 'staff', '2022-04-16', '2023-11-15 12:18:14 pm', '', 0, '', '', '', '', 1, 'Admin-PC', '2024-05-20 19:04 PM', '', ''),
(155, 'HINA JUYAL ', '8368673613', 'HINA JUYAL ', '8368673613', 'ADMIN', 'staff', '2022-04-19', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(156, 'DIVYA', '9368869899', 'DIVYA', '9368869899', 'DATA ENTRY', 'staff', '2022-04-22', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(157, 'DRISHTI', '9958917441', 'DRISHTI', '9958917441', 'PHLEBOTOMIST', 'staff', '2022-04-22', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(158, 'FAHAD', '7011449575', 'fahad', 'fahad', 'PHLEBOTOMIST', 'staff', '2022-04-26', '2022-04-27 16:20 PM', '', 5, '', '', '', '', 0, '', '', '', ''),
(159, 'AJAY RANA', '7536807558', 'AJAYRANA', '7536807558', 'PHLEBOTOMIST', 'staff', '2022-04-27', '2022-10-18 08:06 AM', '', 5, '', '', '', '', 0, '', '', '', ''),
(160, 'AJAY SONI', '9953333198', 'AJAYSONI', 'AJAYSONI', 'PHLEBOTOMIST', 'staff', '2022-04-27', '2022-05-25 17:04 PM', '', 5, '', '', '', '', 0, '', '', '', ''),
(161, 'KANIKA TANEJA ', '9315772524', 'KANIKA TANEJA ', '9315772524', 'DATA ENTRY', 'staff', '2022-04-28', '', '', 0, '', '', '', '', 0, '', '', '', ''),
(162, 'KOMAL', '9289238261', 'KOMAL', 'KOMAL', 'TELLY CALLER', 'staff', '2022-05-14', '', '', 0, '', '', '', '', 1, '', '', '', ''),
(163, 'GUNJAN ', '9999043691', 'MUDASSIR', 'MUDASSIR', 'PHLEBOTOMIST', 'staff', '2022-05-27', '2023-01-19 12:02:53pm', '', 4, '', 'Q93757124@ybl', '', '', 1, '', '', '', 'Q93757124.pdf'),
(164, 'MOAZZAM ', '9690148543', '1233', '123', 'PHLEBOTOMIST', 'staff', '2022-06-16', '', '', 5, '', 'Q42445696@ybl', '', '', 0, '', '', '', 'Q42445696.pdf'),
(165, 'ANANT YADAV', '9453532068', 'ANANT', 'ANANT', 'PHLEBOTOMIST', 'staff', '2022-06-24', '', '', 5, '', 'Q42445696@ybl', '', '', 1, '', '', '', 'Q42445696.pdf'),
(166, 'Rohit Pandey', '8920974719', 'ROHIT', 'ROHIT', 'ADMIN', 'staff', '2022-07-08', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(167, 'RAJEEV KUMAR ', '7210004748', 'rajeevkumar', 'rajeevkumar', 'FIELD BOY', 'staff', '2022-07-15', '2025-04-18 08:58:14 am', '', 5, '', '', '', '', 1, '', '', '', ''),
(168, 'Salman Ali ', '9999043691', 'salmanali', 'salmanali', 'PHLEBOTOMIST', 'staff', '2022-07-28', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(169, 'RITESH', '9695983021', 'RITESH', '9695983021', 'DATA ENTRY', 'staff', '2022-07-30', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(170, 'SUSHEEL (FIELD COVID)', '7830806847', 'SUSHEEL', '7830806847', 'PHLEBOTOMIST', 'staff', '2022-08-04', '2023-05-09 23:20 PM', '', 5, '', '', '', '', 1, '', '', '', ''),
(171, 'MONIKA', '9675720537', 'MONIKA_old', '9675720537', 'ADMIN', 'staff', '2022-08-08', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(172, 'MILIND BAUDH', '8800326884', 'MILIND', '8800326884', 'PHLEBOTOMIST', 'staff', '2022-08-10', '2022-11-20 18:43 PM', '', 5, '', '', '', '', 0, '', '', '', ''),
(173, 'Bhupesh chand', '8700136664', 'bhupesh', 'bhupesh', 'PHLEBOTOMIST', 'staff', '2022-08-17', '2023-03-27 04:13:47pm', '', 5, '', 'Q66799339@ybl', '', '', 0, '', '', '', ''),
(175, 'Rahnuma', '9625629229', 'RAHNUMA', '123456', 'Lab User', '', '2021-01-10', '2025-03-04 06:36:19 am', 'Administrative', 0, '', '', '', '', 1, 'AMAN-PC', '2024-06-15 10:06 AM', '', ''),
(176, 'VIVEK', '7531031254', 'VIVEK', 'VKT7531031254', 'DATA ENTRY', 'staff', '2022-08-18', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(177, 'Ravi Chaudhary', '9811005760', 'RAVI_NIGHT', '9811005760', 'Lab User', 'staff', '2022-08-19', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(178, 'Umerjan', '6396765776', 'umerjan', 'umerjan', 'PHLEBOTOMIST', 'staff', '2022-08-25', '2023-04-20 11:15:35am', '', 5, '', 'Q953067560@ybl', '', '', 0, '', '', '', ''),
(180, 'Ujjwal Sharma', '8851683848', 'UJJWAL', '8851683848', 'TELLY CALLER', 'staff', '2022-09-01', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(181, 'Dr Shashikant Singh', '9315431705', 'SHASHIKANT', '741852', 'Lab User', 'staff', '2022-09-03', '', '', 5, '', '', '', '', 1, '', '', '', ''),
(188, 'SHAHNAAZ ', '8448112404', 'SHAHNAAZ', '8448112404', 'TELLY CALLER', 'staff', '2022-09-14', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(189, 'Aman', '9773552558', 'AMAN', '9773552558', 'TELLY CALLER', 'staff', '2022-10-11', '2024-12-29 01:26:44 pm', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(190, 'PRATIKSHA ', '9717180537', '0399', 'PRATIKSHA', 'PHLEBOTOMIST', 'staff', '2022-10-18', '', '', 5, '', '', 'PANKAJ', '', 0, '', '', '', ''),
(191, 'SHEETAL SINGH', '7987752964', 'SHEETAL', '7987752964', 'TELLY CALLER', 'staff', '2022-10-19', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', '', ''),
(192, 'Raj Kumar', '7053144566', 'RAJKUMAR', '7053144566', 'TELLY CALLER', 'staff', '2022-10-29', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', '', ''),
(193, 'SHAIMA', '7291961815', 'SHAIMA', '7291961815', 'TELLY CALLER', 'staff', '2022-11-01', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', '', ''),
(194, 'NEERAJ YADAV ', '7503711127', 'neerajyadav', 'neerajyadav', 'FIELD BOY', 'staff', '2022-12-01', '2025-04-19 18:49 PM', '', 5, '', '', 'SALIM', '', 1, '', '', '', ''),
(195, 'Himanshu sharma', '9521718767', 'HIMANSHU', '9521718767', 'PHLEBOTOMIST', 'staff', '2022-12-03', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(196, 'Garvit sharma', '9643099694', 'garvit', 'garvit', 'PHLEBOTOMIST', 'staff', '2022-12-19', '', '', 5, '', '', 'SALIM', '', 1, '', '', '', ''),
(197, 'KARAN JHA', '7678489842', 'KARANJHA', 'K2022', 'PHLEBOTOMIST', 'staff', '0000-00-00', '', '', 5, '', '', '', '', 1, 'UTI', '2023-10-18 22:01 PM', '', ''),
(198, 'AJAY DAHIYA', '9971743211', 'ajaydahiya', 'ajaydahiya', 'PHLEBOTOMIST', 'staff', '2022-12-27', '', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(199, 'MUJAHID ', '9971420525', 'mujahid', 'mujahid', 'PHLEBOTOMIST', 'staff', '2023-01-20', '', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(200, 'MONIKA', '8375058868', 'MONIKA', '2580', 'ADMIN', 'staff', '2023-01-30', '', '', 5, '', '', 'Rahnuma', '', 0, '192.168.1.39', '2024-11-02 15:26 PM', '', ''),
(201, 'Ritu Mahalwal', '9871366002', 'RITU', '9871366002', 'TELLY CALLER', 'staff', '2023-02-01', '2024-08-14 06:40:17 pm', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(202, 'BALENDER  KUMAR ', '8588830381', 'BALENDER', '12345', 'PHLEBOTOMIST', 'staff', '2023-02-04', '', '', 5, '', '', '', '', 0, '', '', '', ''),
(203, 'PREETI KUMARI', '7973068661', 'PREETI_K', '7973068661', 'ADMIN', 'staff', '2023-02-06', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', '', ''),
(204, 'SUNIL YADAV ', '8851984084', 'SUNIL YADAV ', 'PRATHAM', 'PHLEBOTOMIST', 'staff', '2023-02-08', '', '', 2, '', '', 'CHAMAN', '', 0, '', '', '', ''),
(205, 'GHAYAS  ALAM', '9058860807', 'ghayas', 'ghayas', 'PHLEBOTOMIST', 'staff', '2023-02-13', '2025-04-22 11:06 AM', '', 5, '', '', 'SALIM', '', 1, '', '', '', ''),
(206, 'SAMA', '8851350854', 'SAMA', '8851350854', 'DATA ENTRY', 'staff', '2023-02-17', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(207, 'SHADAB ALI', '9756610656', 'shadab', '12345', 'PHLEBOTOMIST', 'staff', '2023-03-15', '2023-04-03 10:26 AM', '', 5, '', '', 'KAVITA', '', 1, '', '', '', ''),
(208, 'SALEEM JAVED', '9999910870', 'saleem', 'saleem', 'PHLEBOTOMIST', 'staff', '2023-03-17', '', '', 5, '', '', 'SALIM', '', 1, '', '', '', ''),
(209, 'Manoj kumar sharma', '8448140217', 'manojkumarsharma', 'mks', 'PHLEBOTOMIST', 'staff', '2023-03-21', '', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(210, 'JEETAN', '8439510205', 'JEETAN', 'JEETAN', 'PHLEBOTOMIST', 'staff', '2023-03-25', '', '', 5, '', '', 'SHAHANA', '', 1, '', '', '', ''),
(211, 'DINESH KUMAR', '9045452922', 'DINESH', 'DINESH', 'PHLEBOTOMIST', 'staff', '2023-03-27', '', '', 5, '', '', 'SHAHANA', '', 0, '', '', '', ''),
(212, 'ZAHID HUSSAIN', '7325024702', 'ZAHID', 'ZAHID', 'PHLEBOTOMIST', 'staff', '2023-03-27', '', '', 5, '', '', 'SHAHANA', '', 1, '', '', '', ''),
(213, 'Manav gupta', '9540729507', 'manav', 'manav', 'FIELD BOY', 'staff', '2023-04-06', '2024-01-24 08:48:25 am', '', 5, '', '', 'SALIM', '', 1, '', '', '', ''),
(214, 'Vishvender ', '8700965931', 'vish', 'vish', 'PHLEBOTOMIST', 'staff', '2023-04-15', '2025-04-17 09:52 AM', '', 5, '', 'Q93757124@ybl', 'SALIM', '', 1, '', '', '', 'Q93757124.pdf'),
(215, 'MOHIT', '9773568276', 'MOHIT', 'MOHIT', 'FIELD BOY', 'staff', '2023-04-27', '2025-04-03 19:58 PM', '', 5, '', '', 'SALMAN ALI', '', 1, '', '', '', ''),
(216, 'Farhan Ghazi', '9997503057', 'Farhan', 'Farhan', 'PHLEBOTOMIST', 'staff', '2023-05-03', '2023-07-25 09:27 AM', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(217, 'Ritesh Singh', '7302454308', 'RITESH_SINGH', '7302454308', 'TELLY CALLER', 'staff', '2023-05-04', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(218, 'ISHANT KUMAR ', '8448105797', 'ISHANT KUMAR 797', '8448105797', 'PHLEBOTOMIST', 'staff', '2023-05-05', '', '', 5, '', '', 'MARIA', '', 0, '', '', '', ''),
(219, 'PRITAM KUMAR ', '7645994474', 'covid19@bhasinpathlabs.com', '7645994474', 'PHLEBOTOMIST', 'staff', '2023-05-05', '', '', 5, '', '', 'MARIA', '', 0, '', '', '', ''),
(220, 'Manish Tamwar', '9540824582', 'tanwar', 'tanwar', 'PHLEBOTOMIST', 'staff', '2023-05-06', '', '', 5, '', '', 'SALIM', '', 1, '', '', '', ''),
(221, 'Bhavya Nivedita', '8376897302', 'BHAVYA', '9999563390', 'Lab User', 'staff', '2023-05-08', '', '', 5, '', '', 'Rahnuma', '', 1, 'DESKTOP-44UANNL', '2023-11-23 11:43 AM', '', ''),
(222, ' ANUP KUMAR', '9953602656', 'anujanup', 'anujanup', 'PHLEBOTOMIST', 'staff', '2023-05-11', '', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(223, 'Avinash Kumar', '7991188326', 'AVINASH', 'KUMAR', 'TELLY CALLER', 'staff', '2023-05-13', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(224, 'Lalit kundra ', '8851147983', 'lalit1', 'lalit', 'PHLEBOTOMIST', 'staff', '2023-05-19', '', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(225, 'RAHUL YADAV ', '7982835507', 'RAHUL', 'RAHUL', 'FIELD BOY', 'staff', '2023-05-30', '2024-01-16 02:41:20 am', '', 5, '', '', 'KAVITA', '', 0, '', '', '', ''),
(226, 'Mohammad Adil', '8439651278', 'adil', 'adil', 'PHLEBOTOMIST', 'staff', '2023-05-30', '', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(227, 'Md Kaif', '8810240044', 'KAIF', '8810240044', 'TELLY CALLER', 'staff', '2023-06-05', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(228, 'ARMAN', '7982043361', 'ARMAN', '7982043361', 'TELLY CALLER', 'staff', '2023-06-05', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(229, '**Akash Deep', '9311782086', 'akashdeep', '123456', 'PHLEBOTOMIST', 'staff', '2023-06-10', '2023-10-03 09:38:21 am', '', 5, '', '', 'Rahnuma', 'LatLng(lat: 0.0, lng: 0.0)', 1, '', '', '', ''),
(230, 'DEEPAK JOSHI', '9717320508', 'DEEPAK', 'JOSHI', 'FIELD BOY', 'staff', '2023-06-15', '2023-10-03 12:58:25 pm', '', 5, '', '', 'MARIA', '', 1, '', '', '', ''),
(231, 'RAHUL AHMED ', '9101691292', 'rahulahmed', 'rahulahmed', 'PHLEBOTOMIST', 'staff', '2023-06-18', '2024-10-15 14:31 PM', '', 5, '', '', 'DIMPLE', '', 1, '', '', '', ''),
(232, 'MS NEETU', '9810674320', 'MS_NEETU', '9810674320', 'TELLY CALLER', 'staff', '2023-06-19', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', '', ''),
(233, 'Ali Imam ', '8958833685', 'imam', 'imam', 'PHLEBOTOMIST', 'staff', '2023-06-19', '2023-09-30 10:25 AM', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(234, 'xyzRahul Ahmed ', '9101691292', 'rahulahmed', 'rahulahmed', 'PHLEBOTOMIST', 'staff', '2023-06-19', '2024-06-26 11:21:38 am', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(235, 'Waqar chaudhary', '9720573545', 'waqar', 'waqar', 'PHLEBOTOMIST', 'staff', '2023-06-19', '2025-04-21 22:37 PM', '', 5, '', '', 'SALIM', '', 1, '', '', '', ''),
(236, 'KOMAL GUPTA', '8929669972', 'komal', '8956650392', 'PHLEBOTOMIST', 'staff', '2023-06-28', '2023-08-18 00:04 AM', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(237, 'AMAN SHUKLA ', '8178408980', 'amanfb', 'amanfb', 'FIELD BOY', 'staff', '2023-07-13', '2025-04-08 23:00 PM', '', 5, '', '', 'ANKITA', '', 1, '', '', '', ''),
(238, 'Bhagya Laxmi', '9318341831', 'BHAGYA_LAXMI', '9318341831', 'TELLY CALLER', 'staff', '2023-07-15', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(239, 'Mohd Israr', '9310910700', 'ISRAR', 'ISRAR', 'PHLEBOTOMIST', 'staff', '2023-07-22', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(240, 'Rahnuma Call Center', '8882584202', 'RAHNUMA_C', '8882584202', 'TELLY CALLER', 'staff', '2023-07-29', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(241, 'Sufiyan', '9667952849', 'SUFIYAN', '9667952849', 'FIELD BOY', 'staff', '2023-08-01', '2024-01-31 04:04:00 pm', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(242, 'SUMIT', '8448010951', 'SUMIT', '997799', 'TELLY CALLER', 'staff', '2023-08-04', '', '', 5, '', '', 'Rahnuma', '', 1, '192.168.1.4', '2024-05-09 02:41 AM', '', ''),
(243, 'Mahender', '9625756762', 'MAHENDER', '9625756762', 'PHLEBOTOMIST', 'staff', '2023-08-05', '2025-04-22 12:59 PM', '', 5, '', 'Q00102443@ybl', 'Rahnuma', '', 1, '', '', '', 'Q00102443@pdf'),
(244, 'DEBU VISWAS', '87006 89210', 'DEBU VISWAS', 'DEBU VISWAS', 'PHLEBOTOMIST', 'staff', '2023-08-08', '', '', 5, '', '', 'SHAHANA', '', 0, '', '', '', ''),
(245, 'Amit', '7838499272', 'AMIT', '7838499272', 'PHLEBOTOMIST', 'staff', '2023-08-10', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(246, 'MUMTAJ', '8586807630', 'MUMTAJ', 'MUMTAJ', 'TELLY CALLER', 'staff', '2023-08-29', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(247, 'Sunil Chandane ', '08506877501', 'sunilchandane', 'sunilchandane', 'PHLEBOTOMIST', 'staff', '2023-09-12', '', '', 5, '', '', 'SALIM', '', 0, '', '', '', ''),
(248, 'Sunil Chandane', '8506877501', 'SUNIL', '8506877501', 'TELLY CALLER', 'staff', '2023-09-13', '2023-09-13 01:39:30pm', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(249, 'Lovely Singh', '7982544205', 'LOVELY', '7982544205', 'TELLY CALLER', 'staff', '2023-09-16', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(250, 'Mahesh', '9718609389', 'MAHESH', 'MAHESH', 'Lab User', 'staff', '2023-09-27', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(251, 'ROSHAN', '9899099775', 'ROSHAN', 'ROSHAN', 'Lab User', 'staff', '2023-09-27', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(252, 'MANOJ', '9990097423', 'MANOJ', 'MANOJ', 'FIELD BOY', 'staff', '2023-10-03', '2023-10-03 02:50:19 pm', '', 5, '', '', 'Rahnuma', '', 0, '', '', '', ''),
(253, 'Harinder kushwaha', '8700153177', 'harinder', 'harinder', 'PHLEBOTOMIST', 'staff', '2023-10-05', '', '', 5, '', '', 'SALIM', '', 1, '', '', '', ''),
(255, 'NOUMAN', '9354776550', 'NAUMAN', 'NAUMAN', 'FIELD BOY', 'staff', '2023-10-09', '2024-06-07 18:12 PM', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(256, 'MOHIT SHARMA', '9897124125', 'MOHIT_FD', '9897124', 'TELLY CALLER', 'staff', '2023-10-17', '', '', 5, '', '', 'Rahnuma', '', 0, 'admin-PC', '2023-10-19 10:10 AM', '', ''),
(257, 'RAHUL SINGH ', '7683011032', 'RAHULSINGH ', '7683011032', 'FIELD BOY', 'staff', '2023-10-18', '2024-05-25 21:15 PM', '', 5, '', '', 'Aman', '', 1, '', '', '', ''),
(258, 'HASIM', '9718229600', 'HASIM', 'HASIM', 'FIELD BOY', 'staff', '2023-10-19', '2023-10-25 09:15:27 am', '', 5, '', '', 'Rahnuma', '', 1, '', '', '', ''),
(259, 'ZANTU', '.', 'ZANTU', 'ZANTU', 'FIELD BOY', 'staff', '2023-10-23', '', '', 5, '', '', 'Ritu Mahalwal', '', 0, '', '', 'SRFSYSTEM-PC', ''),
(260, 'KHOKAN', '.', 'KHOKAN', 'KHOKAN', 'FIELD BOY', 'staff', '2023-10-23', '', '', 5, '', '', 'Ritu Mahalwal', '', 1, '', '', 'SRFSYSTEM-PC', ''),
(261, 'Ghantu maeri ', '8447257634', 'ghantu', 'ghantu', 'FIELD BOY', 'staff', '2023-10-25', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(262, 'KESHAV', '9871860499', 'KESHAV', 'KESHAV', 'FIELD BOY', 'staff', '2023-10-27', '2025-04-21 08:56 AM', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(263, 'HAREKRISHNA', '9808825243', 'KRISHNA', 'KRISHNA', 'FIELD BOY', 'staff', '2023-11-10', '2023-12-07 12:02 PM', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(265, 'PUSHPENDER', '9910474470', 'PUSHPENDER', '9910474470', 'PHLEBOTOMIST', 'staff', '2023-12-15', '2025-04-22 11:32 AM', '', 5, '', 'Q51259605@ybl', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', 'Q51259605.pdf'),
(266, 'ANIKET', '8076404852', 'ANIKET', 'ANIKET', 'TELLY CALLER', 'staff', '2023-12-15', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(267, 'Lalit Rana', '8586028891', 'LALIT', '8586028891', 'DATA ENTRY', 'staff', '2024-01-02', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(268, 'ANOOP', '9953602656', 'ANOOP', 'ANOOP', 'FIELD BOY', 'staff', '2024-01-04', '', '', 5, '', '', 'ARMAN', '', 1, '', '', 'System1-PC', ''),
(269, 'Md Dilnawaj', '7488136712', 'DILNAWAJ', '748813', 'Lab User', 'staff', '2024-01-04', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(270, 'Test1', '8573929263', 'test1', 'test1', 'PHLEBOTOMIST', 'staff', '2024-01-05', '2025-03-04 07:46:33 am', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', 'Q51843328.pdf'),
(271, 'Minakshi', '9761747636', 'MINAKSHI', '9761747636', 'Lab User', 'staff', '2024-01-06', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(272, 'AMRIT', '8448234277', 'AMRIT', '8448234277', 'FIELD BOY', 'staff', '2024-01-22', '', '', 5, '', '', 'ARMAN', '', 1, '', '', 'System1-PC', ''),
(273, 'SHAMMI ', '9625259814', 'SHAMMI', '9625259814', 'FIELD BOY', 'staff', '2024-01-24', '2024-03-22 17:19 PM', '', 5, '', '', 'ARMAN', '', 1, '', '', 'System1-PC', ''),
(274, 'NITIKA', '9878188189', 'NITIKA', '9878188189', 'Lab User', 'staff', '2024-01-27', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(275, 'AMAN AHMAD ', '7827865007', 'AMANAHMED', '7827865007', 'FIELD BOY', 'staff', '2024-01-30', '2025-04-21 19:59 PM', '', 5, '', '', 'ARMAN', '', 1, '', '', 'System1-PC', ''),
(276, 'SAMI AHMAD KHAN', '7520132030', 'samiahmad', 'samiahmad', 'PHLEBOTOMIST', 'staff', '2024-02-13', '2024-06-24 07:14:12 pm', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(277, 'ANMOL BABU ', '7701954915', 'anmol', 'anmol', 'PHLEBOTOMIST', 'staff', '2024-02-15', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(278, 'SUJATA ', '9552928353', 'sujata', 'sujata', 'PHLEBOTOMIST', 'staff', '2024-02-16', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(279, 'AKASH PAL', '7237013847', 'akashpal', 'akashpal', 'PHLEBOTOMIST', 'staff', '2024-02-21', '2024-04-29 16:02 PM', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(280, '**AAKASH ', '7428327374', 'AAKASH ', '7428327374', 'FIELD BOY', 'staff', '2024-02-23', '', '', 5, '', '', 'Ritu Mahalwal', '', 1, '', '', 'SRFSYSTEM-PC', ''),
(281, 'PRAKASH CHANDRA ', '8923431995', 'prakashchandra', 'prakash', 'PHLEBOTOMIST', 'staff', '2024-02-24', '2024-04-29 12:47 PM', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(282, 'NIPPU KUMAR ', '9102448411', 'nippu', 'nippu', 'PHLEBOTOMIST', 'staff', '2024-02-24', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(283, 'ASJAD ', '8766332544', 'asjad', 'asjad', 'PHLEBOTOMIST', 'staff', '2024-03-02', '', '', 5, '', '', 'ANKITA', '', 1, '', '', 'System2-PC', ''),
(284, 'Ashwani', '9870560365', 'ASHWANI', '9870560365', 'PHLEBOTOMIST', 'staff', '2024-03-07', '2025-03-07 18:49 PM', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(285, 'NAIYER AZAM', '8709502188', 'naiyerazam', 'naiyerazam', 'PHLEBOTOMIST', 'staff', '2024-03-12', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(286, 'DILNAWAZ', '7549752463', 'dilnawaz', 'dilnawaz ', 'PHLEBOTOMIST', 'staff', '2024-03-13', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(287, 'ROOPA ST', '9582878288', 'ROOPA_ST', '8288', 'Lab User', 'staff', '2024-03-20', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(288, 'NEELU', '9315244878', 'NEELU', '4878', 'Lab User', 'staff', '2024-03-20', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(289, 'ARSHAD', '9708515876', 'ARSHAD', '5876', 'Lab User', 'staff', '2024-03-20', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(290, 'TASLEEM', '9519760885', 'TASLEEM', '9519', 'Lab User', 'staff', '2024-03-20', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(291, 'ADARSH', '9198076808', 'adarsh', 'adarsh', 'PHLEBOTOMIST', 'staff', '2024-04-14', '2024-08-05 19:02 PM', '', 5, '', '', 'SALIM', '', 1, '', '', '110.235.239.251', ''),
(292, 'SANJAY KUMAR NAINWAL', '9548065597', 'sanjaykumar', 'sanjaykumar', 'PHLEBOTOMIST', 'staff', '2024-04-17', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(293, 'BEENA ', '9999123130', 'beena', 'beena', 'PHLEBOTOMIST', 'staff', '2024-04-17', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(294, '..', '8368492707', 'nikhil', 'nikhil', 'PHLEBOTOMIST', 'staff', '2024-04-18', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(295, 'NEERAJ BADGUJAR', '8368492707', 'NEERAJB', '8368492707', 'FIELD BOY', 'staff', '2024-04-19', '2024-05-31 12:52:48 pm', '', 5, '', '', 'Ritu Mahalwal', '', 1, '', '', 'SRFSYSTEM-PC', ''),
(296, 'SONU', '8076835662', 'SONU', '5662', 'TELLY CALLER', 'staff', '2024-04-20', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', 'RAHNUMA-PC', ''),
(297, 'DEEPA', '9667651577', 'DEEPA', '1577', 'TELLY CALLER', 'staff', '2024-04-22', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'RAHNUMA-PC', ''),
(298, 'AKASH KUMAR ', '9266802088', 'akashkumar', 'akashkumar', 'FIELD BOY', 'staff', '2024-04-23', '2025-02-02 15:05 PM', '', 5, '', '', 'Aman', '', 1, '', '', 'System2-PC', ''),
(299, 'DEEPAK SENGAR ', '8810428595', 'deepaksengar', 'deepaksengar', 'FIELD BOY', 'staff', '2024-04-23', '2025-04-19 21:39 PM', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(300, 'SALMAN CHAUDHARY', '8433112639', 'salman2', 'salman2', 'PHLEBOTOMIST', 'staff', '2024-05-01', '2025-01-01 03:12 AM', '', 5, '', '', 'SALIM', '', 1, '', '', 'System2-PC', ''),
(301, 'SONU SINGH', '8076835662', 'sonusingh', 'SONU5662', 'PHLEBOTOMIST', 'staff', '2024-05-07', '', '', 5, '', '', 'SALIM', '', 1, '', '', '192.168.1.6', ''),
(302, 'RASHIDA', '8287874791', 'RASHIDA', '4791', 'TELLY CALLER', 'staff', '2024-05-14', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(303, 'KAILASH', '9810375490', 'KAILASH', 'KAILASH', 'FIELD BOY', 'staff', '2024-05-14', '2025-04-20 16:54 PM', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(304, 'SUMIT SINGH CHAUHAN', '9821957370', 'SUMIT_S', '7370', 'PHLEBOTOMIST', 'staff', '2024-06-10', '2025-04-22 11:14 AM', '', 5, '', 'Q401633612@ybl', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', 'Q401633612.pdf'),
(305, 'MEERA', '8700058062', 'MEERA', 'BEBO2013', 'TELLY CALLER', 'staff', '2024-06-14', '', '', 5, '', '', 'Rahnuma', '', 1, 'ADMIN-PC', '2024-06-24 14:29 PM', 'DESKTOP-4S5E0R4', ''),
(306, 'AMANDEEP SINGH', '9870201957', 'AMANDEEP', '1957', 'Lab User', 'staff', '2024-06-21', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(307, 'VIKASH', '9205425942', 'VIKASH', '9205425942', 'FIELD BOY', 'staff', '2024-07-02', '2024-12-29 11:54:05 am', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(308, 'Aarish', '9315144233', 'AARISH', '4233', 'PHLEBOTOMIST', 'staff', '2024-07-24', '2025-04-22 11:10:31am', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'Rahnuma-PC', ''),
(309, 'Jyoti Marwah', '9821189006', 'JYOTI_M', '9006', 'Lab User', 'staff', '2024-07-30', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(310, 'FARDEEN', '9899415264', 'FARDEEN', '5264', 'PHLEBOTOMIST', 'staff', '2024-08-12', '2024-08-20 17:00 PM', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(311, 'NAMRITA YADAV', '8882358029', 'NAMRITA', '8029', 'TELLY CALLER', 'staff', '2024-08-22', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(312, 'APEX ', '9953795197', 'APEX', 'APEX', 'PHLEBOTOMIST', 'staff', '2024-08-29', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(313, 'MEHRAB ALAM', '9891952645', 'mehrabalam', 'mehrabalam', 'PHLEBOTOMIST', 'staff', '2024-09-07', '2025-04-21 15:17 PM', '', 5, '', 'Q63355577@ybl', 'SALIM', '', 1, '', '', 'reception2', 'Q63355577.pdf'),
(314, 'Vishal Sharma', '9899215382', 'VISHAL_SHARMA', '9899215382', 'TELLY CALLER', 'staff', '2024-09-09', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(315, 'SARTAJ', '9142276775', 'SARTAJ', 'SARTAJ', 'FIELD BOY', 'staff', '2024-09-09', '2025-04-04 15:34 PM', '', 5, '', '', 'SHAHANA', '', 1, '', '', 'DESKTOP-EBRK30C', ''),
(316, 'PORTER ', '9311193111', 'porter', 'porter', 'PHLEBOTOMIST', 'staff', '2024-09-12', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(317, 'MERAJ AHMAD ANSARI', '9650849413', 'meraj', 'meraj', 'PHLEBOTOMIST', 'staff', '2024-09-17', '2024-12-19 06:57 AM', '', 5, '', 'Q93757124@ybl', 'SALIM', '', 0, '', '', 'reception2', 'Q93757124.pdf'),
(318, 'SATYAM KUMAR', '8595422758', 'satyam', 'satyam', 'FIELD BOY', 'staff', '2024-09-17', '2025-04-17 09:57:39 am', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(319, 'Mashroor Khan', '9958430665', 'MASHROOR', '0665', 'TELLY CALLER', 'staff', '2024-09-18', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(320, 'JYOTI SAKYA', '9718879504', 'JYOTI_S', '9504', 'DATA ENTRY', 'staff', '2024-09-21', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(321, 'HASHMI REZA ', '7983739056', 'hashmi', 'hashmi', 'PHLEBOTOMIST', 'staff', '2024-09-26', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(322, 'RAVI PANDEY ', '9565438695', 'RAVIPANDEY', '8695', 'PHLEBOTOMIST', 'staff', '2024-10-01', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(323, 'SUMIT CHAUHAN ', '9821957370', 'SUMIT CHAUHAN ', '43969835', 'TELLY CALLER', 'staff', '2024-10-02', '', '', 5, '', '', 'SANJEET', '', 1, 'ANKITA', '2024-10-12 15:59 PM', 'admin-PC', ''),
(324, 'Sanket Kumar', '8287018061', 'SANKET', '8061', 'TELLY CALLER', 'staff', '2024-10-14', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(325, 'HARSHITA ', '8505916252', 'harshita', 'harshita', 'PHLEBOTOMIST', 'staff', '2024-10-14', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(326, 'MANISHA', '8383920803', 'MANISHA', '0803', 'TELLY CALLER', 'staff', '2024-10-15', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', 'DESKTOP-4S5E0R4', ''),
(327, 'MD. SHAQUIB ALAM', '8448558464', 'SHAQUIB', '8464', 'Lab User', 'staff', '2024-10-16', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(328, 'ARIF SAIFI', '8586873925', 'ARIF', '3925', 'DATA ENTRY', 'staff', '2024-10-16', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-4S5E0R4', ''),
(329, 'PRAKASH JHA', '9555108716', 'PRAKASH', '8716', 'TELLY CALLER', 'staff', '2024-10-19', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', 'DESKTOP-4S5E0R4', ''),
(330, 'Ashish Kumar', '8595462725', 'ASHISH', '2725', 'TELLY CALLER', 'staff', '2024-11-01', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', 'ServerHC-PC', ''),
(331, 'Boby', '7683083359', 'BOBY', '3359', 'TELLY CALLER', 'staff', '2024-11-01', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'ServerHC-PC', ''),
(332, 'SHAGUN', '9318474986', 'SHAGUN', '4986', 'Lab User', 'staff', '2024-11-12', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'ServerHC-PC', ''),
(333, 'MANOJ', '7088027875', 'MANOJ', '7875', 'Lab User', 'staff', '2024-11-12', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'ServerHC-PC', ''),
(334, 'ABHISHEK CHAUHAN', '9315036551', 'abhishekchauhan', 'abhishekchauhan', 'PHLEBOTOMIST', 'staff', '2024-11-19', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(335, 'GULREZ SULTAN', '9818247844', 'GULREZ', '6336661', 'TELLY CALLER', 'staff', '2024-11-26', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(336, 'MD WASEEM', '7065718317', 'mdwaseem', 'mdwaseem', 'PHLEBOTOMIST', 'staff', '2024-11-26', '2025-04-18 11:06 AM', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(337, 'MANISHA SHARMA', '7042308798', 'MANISHA_S', '8798', 'TELLY CALLER', 'staff', '2024-12-04', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(338, 'MEGHA', '8810356910', 'MEGHA', '6910', 'TELLY CALLER', 'staff', '2024-12-07', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(339, 'KANCHANA', '8650299233', 'KANCHANA', '9233', 'Lab User', 'staff', '2024-12-11', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(340, 'PANKAJ KUMAR', '8882490395', 'PANKAJ_K', '0395', 'TELLY CALLER', 'staff', '2024-12-18', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(341, 'FIROZ ', '7827967669', 'firoz', 'firoz', 'PHLEBOTOMIST', 'staff', '2024-12-26', '2025-04-22 11:34:15am', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(342, 'MD DANISH', '9899389109', 'DANISH', '9109', 'ADMIN', 'staff', '2025-01-23', '', '', 5, '', '', 'Rahnuma', '', 0, '', '', 'DESKTOP-II324K4', ''),
(343, 'PRERNA', '8826879686', 'PRERNA', '9686', 'Lab User', 'staff', '2025-02-06', '', '', 0, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(344, 'YUVRAJ SINGH', '9580095284', 'YUVRAJ', '5284', 'PHLEBOTOMIST', 'staff', '2025-02-11', '2025-02-14 13:30 PM', '', 5, '', 'Q938195141@ybl', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', 'Q938195141.pdf'),
(345, 'AKASH GARG ', '6395944969', 'akashgarg', 'akashgarg', 'PHLEBOTOMIST', 'staff', '2025-02-13', '2025-02-18 10:13:07 am', '', 5, '', 'Q146464144@ybl', 'SALIM', '', 1, '', '', 'reception2', 'Q146464144.pdf'),
(346, 'GIRDHAR SINGH', '9971381045', 'GIRDHAR', '1045', 'Lab User', 'staff', '2025-02-14', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(347, 'PUSTAM MAURYA', '8802137470', 'PUSTAM', '7470', 'PHLEBOTOMIST', 'staff', '2025-02-18', '2025-04-15 01:30:39 am', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(348, 'PRIYA', '8130206895', 'PRIYA', '6895', 'Lab User', 'staff', '2025-02-20', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(349, 'VIVEK SOLANKI ', '8595844976', 'viveksolanki', 'viveksolanki', 'FIELD BOY', 'staff', '2025-02-21', '2025-02-24 08:10:45 am', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(350, 'HIMANSHU', '8700840178', 'HIMANSHU_DE', '0178', 'DATA ENTRY', 'staff', '2025-02-22', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(351, 'TANNU', '8448972372', 'TANNU', '2372', 'TELLY CALLER', 'staff', '2025-02-22', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(352, 'ABDUL KADIR', '8586972616', 'KADIR', 'Abdul@123', 'PHLEBOTOMIST', 'staff', '2025-02-27', '2025-03-12 10:12:39 am', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(353, 'RAJEEV NS', '9015376907', 'RAJEEV_NS', '6907', 'TELLY CALLER', 'staff', '2025-02-28', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(354, 'RAVI SHANKAR', '8588033922', 'RAVI_S', '3922', 'TELLY CALLER', 'staff', '2025-02-28', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(355, 'ROHIT YADAV ', '9031124104', 'rohityadav', 'rohityadav', 'FIELD BOY', 'staff', '2025-02-28', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(356, 'HASAN', '9310937653', 'HASAN', '7653', 'PHLEBOTOMIST', 'staff', '2025-03-05', '2025-04-22 08:22:25am', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(357, 'LAKSHAY LOCUM ', '7764990549', 'lakshay', 'lakshay', 'FIELD BOY', 'staff', '2025-03-05', '', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(358, 'VIJAY SINGH RAWAT', '8851485941', 'VIJAY_S', '5941', 'PHLEBOTOMIST', 'staff', '2025-03-06', '2025-03-08 07:32:26 am', '', 5, '', '', 'Aarish', '', 1, '', '', 'MARIA', '');
INSERT INTO `tblemployee` (`empid`, `empname`, `empmobile`, `empemail`, `password`, `designation`, `type`, `enterdate`, `loginaccess`, `usertype`, `experience`, `image`, `paymentqr`, `createdby`, `location`, `status`, `systemippassword`, `passwordchangetime`, `addbysystem`, `paymentqrr`) VALUES
(359, 'SURENDER', '9354742592', 'SURENDER', '2592', 'FIELD BOY', 'staff', '2025-03-07', '2025-03-07 05:41:07 am', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(360, 'MAYUR', '9953292933', 'MAYUR', '2933', 'TELLY CALLER', 'staff', '2025-03-07', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(361, 'Devender Singh Rana', '9953808575', 'devender', '9953', 'FIELD BOY', 'staff', '2025-03-17', '2025-04-22 06:49:41 am', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(363, 'RAJU LAL BAIRWA', '9560971926', 'rajulal', 'rajulal', 'FIELD BOY', 'staff', '2025-03-20', '2025-03-22 07:25:03 am', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(364, 'GULAM NABI', '9899514859', 'GULAM', '4859', 'PHLEBOTOMIST', 'staff', '2025-03-22', '2025-03-28 06:32:39 pm', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(365, 'Rahul FB', '7701967897', 'RAHUL_FB', '7897', 'FIELD BOY', 'staff', '2025-03-26', '2025-03-27 07:46:14 am', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(366, 'AASHU KASHYAP', '6203999124', 'AASHU', '9124', 'ADMIN', 'staff', '2025-04-03', '', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(367, 'MUKESH', '7982506422', 'MUKESH', '6422', 'FIELD BOY', 'staff', '2025-04-14', '2025-04-22 11:26:47am', '', 5, '', '', 'Rahnuma', '', 1, '', '', 'DESKTOP-II324K4', ''),
(368, 'DIVESH KUMAR ', '8826737040', 'divesh', 'divesh', 'FIELD BOY', 'staff', '2025-04-14', '2025-04-15 08:43:05 am', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', ''),
(369, 'TAPAN ', '8587895957', 'tapan', 'tapan', 'FIELD BOY', 'staff', '2025-04-16', '2025-04-16 04:46:32 pm', '', 5, '', '', 'SALIM', '', 1, '', '', 'reception2', '');

-- --------------------------------------------------------

--
-- Table structure for table `temperature_master`
--

CREATE TABLE `temperature_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `min_celsius` int(11) DEFAULT NULL,
  `max_celsius` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `temperature_master`
--

INSERT INTO `temperature_master` (`id`, `code`, `name`, `min_celsius`, `max_celsius`, `status`, `updated_at`) VALUES
(1, 'TMP001', 'Fridge', 2, 8, 'Active', '2025-04-16 18:16:49'),
(2, 'TMP002', 'Room', 20, 35, 'Active', '2025-04-16 18:23:45'),
(3, 'TMP003', 'Freezer', -20, 0, 'Active', '2025-04-16 18:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `unit_master`
--

CREATE TABLE `unit_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit_master`
--

INSERT INTO `unit_master` (`id`, `code`, `name`, `description`, `status`, `updated_at`) VALUES
(1, 'UNIT001', 'Packet', '', 'Active', '2025-04-16 18:28:20'),
(2, 'UNIT002', 'Pcs.', '', 'Active', '2025-04-16 18:28:38'),
(3, 'UNIT003', 'Set.', '', 'Active', '2025-04-16 18:29:18'),
(4, 'UNIT004', 'Kit', '', 'Active', '2025-04-16 18:29:39'),
(5, 'UNIT005', 'Box', '', 'Active', '2025-04-16 18:29:48'),
(6, 'UNIT006', 'Bottle', '', 'Active', '2025-04-16 18:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `staff_code` varchar(10) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`id`, `code`, `staff_code`, `username`, `password`, `role`, `status`, `updated_at`) VALUES
(1, 'USR001', 'STF001', 'rahnuma', '123456', 'Admin', 'Active', '2025-04-22 12:27:32'),
(2, 'USR002', 'ARIF SAIFI', 'ARIF', 'Arif@123', 'Store Manager', 'Active', '2025-04-22 13:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_master`
--

CREATE TABLE `vendor_master` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `senior_manager` varchar(100) DEFAULT NULL,
  `senior_email` varchar(100) DEFAULT NULL,
  `senior_phone` varchar(20) DEFAULT NULL,
  `account_manager` varchar(100) DEFAULT NULL,
  `account_email` varchar(100) DEFAULT NULL,
  `account_phone` varchar(20) DEFAULT NULL,
  `pan` varchar(20) DEFAULT NULL,
  `gst` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor_master`
--

INSERT INTO `vendor_master` (`id`, `code`, `name`, `senior_manager`, `senior_email`, `senior_phone`, `account_manager`, `account_email`, `account_phone`, `pan`, `gst`, `address`, `status`, `updated_at`) VALUES
(1, 'VEN001', 'HealthSupplies Co', 'Dr Vipul Bhasin', 'vipul@bhasinpathlabs.com', '8851202391', 'Mohit', 'mohit@bhasinpathlabs.com', '7485968574', 'AYUS1234', 'GST234', 'test', 'Active', '2025-04-16 14:29:15'),
(2, 'VEN002', 'Biocell Medicare', 'Mr. Rajeev', 'rajivchandra@biocellmedicare.co.in,admin@biocellmedicare.co.in,servicesupport@biocellmedicare.co.in,', '9810145205', 'SAPNA', 'rajivchandra@biocellmedicare.co.in,admin@biocellmedicare.co.in,servicesupport@biocellmedicare.co.in,', '7834846654', 'AACFB9556G', '07AACFB9556G1ZC', 'Ansal Tower, 1001-1002 Nehru Place, New Delhi - 110019', 'Active', '2025-04-17 12:06:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_master`
--
ALTER TABLE `category_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `department_master`
--
ALTER TABLE `department_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `grnn`
--
ALTER TABLE `grnn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grn_item`
--
ALTER TABLE `grn_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grn_id` (`grn_id`);

--
-- Indexes for table `indent`
--
ALTER TABLE `indent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indent_item`
--
ALTER TABLE `indent_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indent_id` (`indent_id`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `issue_number` (`issue_number`),
  ADD KEY `indent_id` (`indent_id`);

--
-- Indexes for table `issue_item`
--
ALTER TABLE `issue_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_id` (`issue_id`);

--
-- Indexes for table `item_master`
--
ALTER TABLE `item_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_master`
--
ALTER TABLE `location_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `manufacturer_master`
--
ALTER TABLE `manufacturer_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_number` (`po_number`);

--
-- Indexes for table `purchase_order_item`
--
ALTER TABLE `purchase_order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_id` (`po_id`);

--
-- Indexes for table `reason_master`
--
ALTER TABLE `reason_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `staff_master`
--
ALTER TABLE `staff_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `stock_ledger`
--
ALTER TABLE `stock_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory_master`
--
ALTER TABLE `subcategory_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `tblemployee`
--
ALTER TABLE `tblemployee`
  ADD PRIMARY KEY (`empid`);

--
-- Indexes for table `temperature_master`
--
ALTER TABLE `temperature_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `unit_master`
--
ALTER TABLE `unit_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `vendor_master`
--
ALTER TABLE `vendor_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_master`
--
ALTER TABLE `category_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department_master`
--
ALTER TABLE `department_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grnn`
--
ALTER TABLE `grnn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grn_item`
--
ALTER TABLE `grn_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `indent`
--
ALTER TABLE `indent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indent_item`
--
ALTER TABLE `indent_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue`
--
ALTER TABLE `issue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_item`
--
ALTER TABLE `issue_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `location_master`
--
ALTER TABLE `location_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manufacturer_master`
--
ALTER TABLE `manufacturer_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_order_item`
--
ALTER TABLE `purchase_order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reason_master`
--
ALTER TABLE `reason_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_master`
--
ALTER TABLE `staff_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_ledger`
--
ALTER TABLE `stock_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subcategory_master`
--
ALTER TABLE `subcategory_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblemployee`
--
ALTER TABLE `tblemployee`
  MODIFY `empid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=370;

--
-- AUTO_INCREMENT for table `temperature_master`
--
ALTER TABLE `temperature_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `unit_master`
--
ALTER TABLE `unit_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor_master`
--
ALTER TABLE `vendor_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grn_item`
--
ALTER TABLE `grn_item`
  ADD CONSTRAINT `grn_item_ibfk_1` FOREIGN KEY (`grn_id`) REFERENCES `grnn` (`id`);

--
-- Constraints for table `indent_item`
--
ALTER TABLE `indent_item`
  ADD CONSTRAINT `indent_item_ibfk_1` FOREIGN KEY (`indent_id`) REFERENCES `indent` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `issue`
--
ALTER TABLE `issue`
  ADD CONSTRAINT `issue_ibfk_1` FOREIGN KEY (`indent_id`) REFERENCES `indent` (`id`);

--
-- Constraints for table `issue_item`
--
ALTER TABLE `issue_item`
  ADD CONSTRAINT `issue_item_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`);

--
-- Constraints for table `purchase_order_item`
--
ALTER TABLE `purchase_order_item`
  ADD CONSTRAINT `purchase_order_item_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_order` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
