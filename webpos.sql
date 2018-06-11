-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2017 at 11:10 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webpos`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_details`
--

CREATE TABLE `category_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(120) NOT NULL,
  `category_description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_details`
--

INSERT INTO `category_details` (`id`, `category_name`, `category_description`) VALUES
(1, 'Foods', 'Foods');

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_address` varchar(500) NOT NULL,
  `customer_contact1` varchar(100) NOT NULL,
  `balance` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'active',
  `Date_Created` datetime DEFAULT CURRENT_TIMESTAMP,
  `Created_BY` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`id`, `customer_name`, `customer_address`, `customer_contact1`, `balance`, `status`, `Date_Created`, `Created_BY`) VALUES
(1, 'Takunda', '11 Watermeyer Drive Belvedere', '0773629282', 0, 'active', '2017-03-15 12:17:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prod_audit`
--

CREATE TABLE `prod_audit` (
  `audit_id` int(11) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `DoneDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `DoneBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prod_audit`
--

INSERT INTO `prod_audit` (`audit_id`, `Description`, `prod_id`, `DoneDate`, `DoneBy`) VALUES
(1, 'Sale of 1 units for Fish Capenta', 1, '2017-03-15 12:17:58', 1),
(2, 'Sale of 10 units for Fish Capenta', 1, '2017-03-21 09:54:01', 1),
(3, 'Sale of 10 units for Fish Capenta', 1, '2017-03-21 09:57:54', 1),
(4, 'Sale of 1 units for Fish Capenta', 1, '2017-03-21 09:59:44', 1),
(5, 'Sale of 2 units for Fish Capenta', 1, '2017-03-21 10:00:26', 1),
(6, 'Sale of 1 units for Fish Capenta', 1, '2017-03-21 10:03:38', 1),
(7, 'Sale of 2 units for Fish Capenta', 1, '2017-03-21 10:11:14', 1),
(8, 'Sale of 2 units for Fish Capenta', 1, '2017-03-21 10:11:37', 1),
(9, 'Sale of 2 units for Fish Capenta', 1, '2017-03-21 10:12:08', 1),
(10, 'Sale of 1 units for Fish Capenta', 1, '2017-03-21 11:16:06', 1),
(11, 'Sale of 1 units for Fish Capenta', 1, '2017-03-21 11:16:37', 1),
(12, 'Sale of 1 units for Fish Capenta', 1, '2017-03-21 11:17:59', 1),
(13, 'Sale of 2 units for Fish Capenta', 1, '2017-03-21 11:20:51', 1),
(14, 'Sale of 1 units for Fish Capenta', 1, '2017-03-21 11:26:33', 1),
(15, 'Sale of 2 units for Fish Capenta', 1, '2017-03-21 11:35:10', 1),
(16, 'Sale of 2 units for Fish Capenta', 1, '2017-03-21 11:39:55', 1),
(17, 'Sale of 1 units for Fish Capenta', 1, '2017-03-21 11:58:25', 1),
(18, 'Sale of 1 units for Fish Capenta', 1, '2017-03-21 11:58:58', 1),
(19, 'Sale of 3 units for Fish Capenta', 1, '2017-03-21 12:00:04', 1),
(20, 'Sale of 1 units for Fish Capenta', 1, '2017-03-21 12:03:45', 2);

-- --------------------------------------------------------

--
-- Table structure for table `receipt_header_info`
--

CREATE TABLE `receipt_header_info` (
  `id` int(11) NOT NULL,
  `Receipt_no` varchar(200) DEFAULT NULL,
  `Customer` varchar(200) DEFAULT NULL,
  `NetValue` decimal(10,2) DEFAULT NULL,
  `TotalDiscount` decimal(10,4) DEFAULT NULL,
  `Payable_amount` decimal(10,2) DEFAULT NULL,
  `Actual_Payment` decimal(10,2) DEFAULT NULL,
  `Outstanding_balance` decimal(10,2) DEFAULT NULL,
  `payment_mode` varchar(20) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` int(11) DEFAULT NULL,
  `LastUpdatedReason` varchar(300) DEFAULT NULL,
  `LastUpdateDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `LastUpdateBy` int(11) DEFAULT NULL,
  `fiscal_signature` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receipt_header_info`
--

INSERT INTO `receipt_header_info` (`id`, `Receipt_no`, `Customer`, `NetValue`, `TotalDiscount`, `Payable_amount`, `Actual_Payment`, `Outstanding_balance`, `payment_mode`, `Status`, `CreatedDate`, `CreatedBy`, `LastUpdatedReason`, `LastUpdateDate`, `LastUpdateBy`, `fiscal_signature`) VALUES
(1, 'Mad20170315111758', 'Takunda', '30.00', '9.0000', '21.00', '30.00', '0.00', 'cash', 'Sold', '2017-03-15 12:17:58', 1, NULL, NULL, NULL, NULL),
(2, 'Tre20170321085401', 'Takunda', '300.00', '12.0000', '288.00', '300.00', '0.00', 'cash', 'Sold', '2017-03-21 09:54:01', 1, NULL, NULL, NULL, NULL),
(3, 'Tre20170321085753', 'Takunda', '300.00', '60.0000', '240.00', '400.00', '0.00', 'cash', 'Sold', '2017-03-21 09:57:54', 1, NULL, NULL, NULL, NULL),
(4, 'Tre20170321085944', 'Takunda', '30.00', '0.0000', '30.00', '50.00', '0.00', 'cash', 'Sold', '2017-03-21 09:59:45', 1, NULL, NULL, NULL, NULL),
(5, 'Tre20170321090026', 'Takunda', '60.00', '0.0000', '60.00', '60.00', '0.00', 'cash', 'Sold', '2017-03-21 10:00:26', 1, NULL, NULL, NULL, NULL),
(6, 'Tre20170321090337', 'Takunda', '30.00', '0.0000', '30.00', '50.00', '0.00', 'cash', 'Sold', '2017-03-21 10:03:38', 1, NULL, NULL, NULL, NULL),
(7, 'Tre20170321091114', 'Takunda', '60.00', '2.4000', '57.60', '70.00', '0.00', 'cash', 'Sold', '2017-03-21 10:11:14', 1, NULL, NULL, NULL, NULL),
(8, 'Tre20170321091137', 'Takunda', '60.00', '2.4000', '57.60', '70.00', '0.00', 'cash', 'Sold', '2017-03-21 10:11:37', 1, NULL, NULL, NULL, NULL),
(9, 'Tre20170321091208', 'Takunda', '60.00', '2.4000', '57.60', '70.00', '0.00', 'cash', 'Sold', '2017-03-21 10:12:08', 1, NULL, NULL, NULL, NULL),
(10, 'Tre20170321101606', 'Takunda', '34.50', '1.3800', '33.12', '60.00', '0.00', 'cash', 'Sold', '2017-03-21 11:16:06', 1, NULL, NULL, NULL, NULL),
(11, 'Tre20170321101637', 'Takunda', '34.50', '1.0400', '33.47', '40.00', '0.00', 'cash', 'Sold', '2017-03-21 11:16:37', 1, NULL, NULL, NULL, NULL),
(12, 'Tre20170321101758', 'Takunda', '34.50', '1.0400', '33.47', '50.00', '0.00', 'cash', 'Sold', '2017-03-21 11:17:59', 1, NULL, NULL, NULL, NULL),
(13, 'Tre20170321102051', 'Takunda', '69.00', '0.0000', '69.00', '70.00', '0.00', 'cash', 'Sold', '2017-03-21 11:20:51', 1, NULL, NULL, NULL, NULL),
(14, 'Tre20170321102633', 'Takunda', '34.50', '0.0000', '34.50', '40.00', '0.00', 'cash', 'Sold', '2017-03-21 11:26:33', 1, NULL, NULL, NULL, NULL),
(15, 'Tre20170321103509', 'Takunda', '69.00', '0.0000', '69.00', '70.00', '0.00', 'cash', 'Sold', '2017-03-21 11:35:10', 1, NULL, NULL, NULL, NULL),
(16, 'Tre20170321103955', 'Takunda', '69.00', '10.3500', '58.65', '58.65', '0.00', 'cash', 'Sold', '2017-03-21 11:39:55', 1, NULL, NULL, NULL, NULL),
(17, 'Tre20170321105824', 'Takunda', '34.50', '0.6900', '33.81', '33.81', '0.00', 'cash', 'Sold', '2017-03-21 11:58:25', 1, NULL, NULL, NULL, NULL),
(18, 'Tre20170321105857', 'Takunda', '34.50', '3.4500', '31.05', '36.00', '0.00', 'cash', 'Sold', '2017-03-21 11:58:58', 1, NULL, NULL, NULL, NULL),
(19, 'Tre20170321110004', 'Takunda', '103.50', '4.1400', '99.36', '150.00', '0.00', 'cash', 'Sold', '2017-03-21 12:00:04', 1, NULL, NULL, NULL, NULL),
(20, 'Tre20170321110344', 'Takunda', '34.50', '6.9000', '27.60', '30.00', '0.00', 'cash', 'Sold', '2017-03-21 12:03:45', 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_details`
--

CREATE TABLE `stock_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_id` varchar(120) DEFAULT NULL,
  `stock_name` varchar(120) DEFAULT NULL,
  `stock_quatity` int(11) DEFAULT NULL,
  `Tax_Code` varchar(10) DEFAULT NULL,
  `company_price` decimal(10,4) DEFAULT NULL,
  `selling_price` decimal(10,4) DEFAULT NULL,
  `category` varchar(120) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreatedBy` int(11) DEFAULT NULL,
  `expire_date` datetime NOT NULL,
  `uom` varchar(120) NOT NULL,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_details`
--

INSERT INTO `stock_details` (`id`, `stock_id`, `stock_name`, `stock_quatity`, `Tax_Code`, `company_price`, `selling_price`, `category`, `date`, `CreatedBy`, `expire_date`, `uom`, `status`) VALUES
(1, 'Fish3kg', 'Fish Capenta', 953, 'A', '20.0000', '30.0000', 'Foods', '2017-03-21 10:03:45', 1, '2017-03-15 00:00:00', 'Kg', 'active'),
(2, '89900', 'Matemba', 100, 'A', '0.0500', '1.0000', 'Foods', '2017-03-21 10:02:26', 1, '2017-03-21 00:00:00', 'Kg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `stock_entries`
--

CREATE TABLE `stock_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `transID` varchar(120) DEFAULT NULL,
  `stock_id` varchar(120) NOT NULL,
  `stock_name` varchar(260) NOT NULL,
  `stock_supplier_name` varchar(200) NOT NULL,
  `category` varchar(120) NOT NULL,
  `quantity` decimal(10,4) DEFAULT NULL,
  `Opening_Stock` decimal(10,4) DEFAULT NULL,
  `Closing_Stock` decimal(10,4) DEFAULT NULL,
  `company_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `mode` varchar(150) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `due_date` datetime DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `status` varchar(500) DEFAULT NULL,
  `Date_Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DoneBy` int(11) DEFAULT NULL,
  `notes_to_status` varchar(300) DEFAULT NULL,
  `date_to_status` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `DoneBy_to_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_movement`
--

CREATE TABLE `stock_movement` (
  `id` int(11) NOT NULL,
  `ProductCode` varchar(200) DEFAULT NULL,
  `Quantity` decimal(10,4) DEFAULT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `DateCreated` datetime DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_movement`
--

INSERT INTO `stock_movement` (`id`, `ProductCode`, `Quantity`, `Type`, `DateCreated`, `CreatedBy`) VALUES
(1, 'Fish3kg', '1.0000', 'Sale', '2017-03-15 12:17:58', 1),
(2, 'Fish3kg', '10.0000', 'Sale', '2017-03-21 09:54:01', 1),
(3, 'Fish3kg', '10.0000', 'Sale', '2017-03-21 09:57:54', 1),
(4, 'Fish3kg', '1.0000', 'Sale', '2017-03-21 09:59:44', 1),
(5, 'Fish3kg', '2.0000', 'Sale', '2017-03-21 10:00:26', 1),
(6, 'Fish3kg', '1.0000', 'Sale', '2017-03-21 10:03:37', 1),
(7, 'Fish3kg', '2.0000', 'Sale', '2017-03-21 10:11:14', 1),
(8, 'Fish3kg', '2.0000', 'Sale', '2017-03-21 10:11:37', 1),
(9, 'Fish3kg', '2.0000', 'Sale', '2017-03-21 10:12:08', 1),
(10, 'Fish3kg', '1.0000', 'Sale', '2017-03-21 11:16:06', 1),
(11, 'Fish3kg', '1.0000', 'Sale', '2017-03-21 11:16:37', 1),
(12, 'Fish3kg', '1.0000', 'Sale', '2017-03-21 11:17:58', 1),
(13, 'Fish3kg', '2.0000', 'Sale', '2017-03-21 11:20:51', 1),
(14, 'Fish3kg', '1.0000', 'Sale', '2017-03-21 11:26:33', 1),
(15, 'Fish3kg', '2.0000', 'Sale', '2017-03-21 11:35:09', 1),
(16, 'Fish3kg', '2.0000', 'Sale', '2017-03-21 11:39:55', 1),
(17, 'Fish3kg', '1.0000', 'Sale', '2017-03-21 11:58:24', 1),
(18, 'Fish3kg', '1.0000', 'Sale', '2017-03-21 11:58:58', 1),
(19, 'Fish3kg', '3.0000', 'Sale', '2017-03-21 12:00:04', 1),
(20, 'Fish3kg', '1.0000', 'Sale', '2017-03-21 12:03:44', 2);

-- --------------------------------------------------------

--
-- Table structure for table `stock_sales`
--

CREATE TABLE `stock_sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `rec_no` varchar(120) NOT NULL,
  `customer` varchar(120) NOT NULL,
  `stock_id` varchar(100) DEFAULT NULL,
  `stock_name` varchar(200) NOT NULL,
  `category` varchar(120) NOT NULL,
  `Tax_Code` varchar(10) DEFAULT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,4) NOT NULL,
  `dis_amount` decimal(10,2) NOT NULL,
  `payable_amount` decimal(10,4) DEFAULT NULL,
  `payment` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `due_date` datetime DEFAULT NULL,
  `payment_mode` varchar(250) NOT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(25) DEFAULT NULL,
  `date_to_status` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `Who_to_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_sales`
--

INSERT INTO `stock_sales` (`id`, `rec_no`, `customer`, `stock_id`, `stock_name`, `category`, `Tax_Code`, `selling_price`, `quantity`, `subtotal`, `grand_total`, `dis_amount`, `payable_amount`, `payment`, `balance`, `due_date`, `payment_mode`, `CreatedBy`, `CreatedDate`, `status`, `date_to_status`, `Who_to_status`) VALUES
(1, 'Mad20170315111758', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '30.0000', '9.00', '21.0000', '30.00', '0.00', '2017-03-15 00:00:00', 'cash', 1, '2017-03-15 12:17:58', 'Sold', '0000-00-00 00:00:00', NULL),
(2, 'Tre20170321085401', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '10.00', '300.00', '300.0000', '12.00', '288.0000', '300.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 09:54:01', 'Sold', '0000-00-00 00:00:00', NULL),
(3, 'Tre20170321085753', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '10.00', '300.00', '300.0000', '60.00', '240.0000', '400.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 09:57:53', 'Sold', '0000-00-00 00:00:00', NULL),
(4, 'Tre20170321085944', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '30.0000', '0.00', '30.0000', '50.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 09:59:44', 'Sold', '0000-00-00 00:00:00', NULL),
(5, 'Tre20170321090026', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '2.00', '60.00', '60.0000', '0.00', '60.0000', '60.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 10:00:26', 'Sold', '0000-00-00 00:00:00', NULL),
(6, 'Tre20170321090337', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '30.0000', '0.00', '30.0000', '50.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 10:03:37', 'Sold', '0000-00-00 00:00:00', NULL),
(7, 'Tre20170321091114', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '2.00', '60.00', '60.0000', '2.00', '57.6000', '70.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 10:11:14', 'Sold', '0000-00-00 00:00:00', NULL),
(8, 'Tre20170321091137', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '2.00', '60.00', '60.0000', '2.00', '57.6000', '70.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 10:11:37', 'Sold', '0000-00-00 00:00:00', NULL),
(9, 'Tre20170321091208', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '2.00', '60.00', '60.0000', '2.00', '57.6000', '70.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 10:12:08', 'Sold', '0000-00-00 00:00:00', NULL),
(10, 'Tre20170321101606', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '34.5000', '1.00', '33.1200', '60.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 11:16:06', 'Sold', '0000-00-00 00:00:00', NULL),
(11, 'Tre20170321101637', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '34.5000', '1.00', '33.4650', '40.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 11:16:37', 'Sold', '0000-00-00 00:00:00', NULL),
(12, 'Tre20170321101758', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '34.5000', '1.00', '33.4650', '50.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 11:17:58', 'Sold', '0000-00-00 00:00:00', NULL),
(13, 'Tre20170321102051', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '2.00', '60.00', '69.0000', '0.00', '69.0000', '70.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 11:20:51', 'Sold', '0000-00-00 00:00:00', NULL),
(14, 'Tre20170321102633', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '34.5000', '0.00', '34.5000', '40.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 11:26:33', 'Sold', '0000-00-00 00:00:00', NULL),
(15, 'Tre20170321103509', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '2.00', '60.00', '69.0000', '0.00', '69.0000', '70.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 11:35:09', 'Sold', '0000-00-00 00:00:00', NULL),
(16, 'Tre20170321103955', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '2.00', '60.00', '69.0000', '10.35', '58.6500', '58.65', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 11:39:55', 'Sold', '2017-03-21 11:47:46', NULL),
(17, 'Tre20170321105824', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '34.5000', '0.69', '33.8100', '33.81', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 11:58:24', 'Sold', '0000-00-00 00:00:00', NULL),
(18, 'Tre20170321105857', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '34.5000', '3.45', '31.0500', '36.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 11:58:57', 'Sold', '0000-00-00 00:00:00', NULL),
(19, 'Tre20170321110004', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '3.00', '90.00', '103.5000', '4.14', '99.3600', '150.00', '0.00', '2017-03-21 00:00:00', 'cash', 1, '2017-03-21 12:00:04', 'Sold', '0000-00-00 00:00:00', NULL),
(20, 'Tre20170321110344', 'Takunda', 'Fish3kg', 'Fish Capenta', 'Foods', 'A', '30.00', '1.00', '30.00', '34.5000', '6.90', '27.6000', '30.00', '0.00', '2017-03-21 00:00:00', 'cash', 2, '2017-03-21 12:03:44', 'Sold', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_user`
--

CREATE TABLE `stock_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_user`
--

INSERT INTO `stock_user` (`id`, `username`, `password`, `user_type`, `answer`, `CreatedBy`, `CreatedDate`) VALUES
(1, 'admin', '12345', 'admin', 'mycat', NULL, '2017-03-15 12:11:13'),
(2, 'Test', '12345', 'user', 'user', 1, '2017-03-21 12:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `store_details`
--

CREATE TABLE `store_details` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `log` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tax_condition` varchar(100) NOT NULL,
  `vat` varchar(100) NOT NULL,
  `bpn` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_details`
--

INSERT INTO `store_details` (`id`, `name`, `log`, `type`, `address`, `city`, `phone`, `email`, `tax_condition`, `vat`, `bpn`) VALUES
(2, 'Trey', 'colcom-logo.jpg', '', '11 Watermeyer Drive', 'Harare', '07736278282', 'takunda@gmail.com', 'VAT_REGISTERED', '11000099211', 7);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_details`
--

CREATE TABLE `supplier_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_name` varchar(200) NOT NULL,
  `supplier_address` varchar(500) NOT NULL,
  `supplier_contact1` varchar(100) NOT NULL,
  `supplier_contact2` varchar(100) NOT NULL,
  `balance` int(11) NOT NULL,
  `Date_Created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_uom`
--

CREATE TABLE `tbl_uom` (
  `uom_id` int(11) NOT NULL,
  `UOM_DESC` varchar(200) DEFAULT NULL,
  `UOM_Detail` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_uom`
--

INSERT INTO `tbl_uom` (`uom_id`, `UOM_DESC`, `UOM_Detail`) VALUES
(1, 'Kg', 'Kilograms'),
(2, 'Lt', 'Litres');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `customer` varchar(250) NOT NULL,
  `supplier` varchar(250) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `due` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rid` varchar(120) NOT NULL,
  `receiptid` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_list_age_data`
--

CREATE TABLE `transaction_list_age_data` (
  `id` int(11) NOT NULL,
  `Supp_Cust_Name` varchar(70) DEFAULT NULL,
  `transID` varchar(20) DEFAULT NULL,
  `Trans_Type` varchar(50) DEFAULT NULL,
  `Transaction_Date` datetime DEFAULT NULL,
  `Trans_Amount` decimal(10,4) DEFAULT NULL,
  `Trans_Class` varchar(60) DEFAULT NULL,
  `Date_Created` datetime DEFAULT CURRENT_TIMESTAMP,
  `Created_By` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_list_debtorage_data`
--

CREATE TABLE `transaction_list_debtorage_data` (
  `Age_ID` int(11) NOT NULL,
  `CustomerName` varchar(200) DEFAULT NULL,
  `TransID` varchar(100) DEFAULT NULL,
  `TransType` varchar(20) DEFAULT NULL,
  `TransDate` datetime DEFAULT NULL,
  `TransAmnt` decimal(10,4) DEFAULT NULL,
  `TransactionClass` varchar(30) DEFAULT NULL,
  `Created_Date` datetime DEFAULT CURRENT_TIMESTAMP,
  `Logged_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_list_debtorage_data`
--

INSERT INTO `transaction_list_debtorage_data` (`Age_ID`, `CustomerName`, `TransID`, `TransType`, `TransDate`, `TransAmnt`, `TransactionClass`, `Created_Date`, `Logged_by`) VALUES
(1, 'Takunda', 'Mad20170315111758', 'Payment', '2017-03-15 11:17:58', '21.0000', 'Sale', '2017-03-15 12:17:58', 1),
(2, 'Takunda', 'Mad20170315111758', 'Receipt', '2017-03-15 11:17:58', '21.0000', 'Sale', '2017-03-15 12:17:58', 1),
(3, 'Takunda', 'Tre20170321085401', 'Payment', '2017-03-21 08:54:01', '288.0000', 'Sale', '2017-03-21 09:54:01', 1),
(4, 'Takunda', 'Tre20170321085401', 'Receipt', '2017-03-21 08:54:01', '288.0000', 'Sale', '2017-03-21 09:54:01', 1),
(5, 'Takunda', 'Tre20170321085753', 'Payment', '2017-03-21 08:57:53', '240.0000', 'Sale', '2017-03-21 09:57:54', 1),
(6, 'Takunda', 'Tre20170321085753', 'Receipt', '2017-03-21 08:57:53', '240.0000', 'Sale', '2017-03-21 09:57:54', 1),
(7, 'Takunda', 'Tre20170321085944', 'Payment', '2017-03-21 08:59:44', '30.0000', 'Sale', '2017-03-21 09:59:44', 1),
(8, 'Takunda', 'Tre20170321085944', 'Receipt', '2017-03-21 08:59:44', '30.0000', 'Sale', '2017-03-21 09:59:44', 1),
(9, 'Takunda', 'Tre20170321090026', 'Payment', '2017-03-21 09:00:26', '60.0000', 'Sale', '2017-03-21 10:00:26', 1),
(10, 'Takunda', 'Tre20170321090026', 'Receipt', '2017-03-21 09:00:26', '60.0000', 'Sale', '2017-03-21 10:00:26', 1),
(11, 'Takunda', 'Tre20170321090337', 'Payment', '2017-03-21 09:03:37', '30.0000', 'Sale', '2017-03-21 10:03:38', 1),
(12, 'Takunda', 'Tre20170321090337', 'Receipt', '2017-03-21 09:03:37', '30.0000', 'Sale', '2017-03-21 10:03:38', 1),
(13, 'Takunda', 'Tre20170321091114', 'Payment', '2017-03-21 09:11:14', '57.6000', 'Sale', '2017-03-21 10:11:14', 1),
(14, 'Takunda', 'Tre20170321091114', 'Receipt', '2017-03-21 09:11:14', '57.6000', 'Sale', '2017-03-21 10:11:14', 1),
(15, 'Takunda', 'Tre20170321091137', 'Payment', '2017-03-21 09:11:37', '57.6000', 'Sale', '2017-03-21 10:11:37', 1),
(16, 'Takunda', 'Tre20170321091137', 'Receipt', '2017-03-21 09:11:37', '57.6000', 'Sale', '2017-03-21 10:11:37', 1),
(17, 'Takunda', 'Tre20170321091208', 'Payment', '2017-03-21 09:12:08', '57.6000', 'Sale', '2017-03-21 10:12:08', 1),
(18, 'Takunda', 'Tre20170321091208', 'Receipt', '2017-03-21 09:12:08', '57.6000', 'Sale', '2017-03-21 10:12:08', 1),
(19, 'Takunda', 'Tre20170321101606', 'Payment', '2017-03-21 10:16:06', '33.1200', 'Sale', '2017-03-21 11:16:06', 1),
(20, 'Takunda', 'Tre20170321101606', 'Receipt', '2017-03-21 10:16:06', '33.1200', 'Sale', '2017-03-21 11:16:06', 1),
(21, 'Takunda', 'Tre20170321101637', 'Payment', '2017-03-21 10:16:37', '33.4650', 'Sale', '2017-03-21 11:16:37', 1),
(22, 'Takunda', 'Tre20170321101637', 'Receipt', '2017-03-21 10:16:37', '33.4650', 'Sale', '2017-03-21 11:16:37', 1),
(23, 'Takunda', 'Tre20170321101758', 'Payment', '2017-03-21 10:17:58', '33.4650', 'Sale', '2017-03-21 11:17:59', 1),
(24, 'Takunda', 'Tre20170321101758', 'Receipt', '2017-03-21 10:17:58', '33.4650', 'Sale', '2017-03-21 11:17:59', 1),
(25, 'Takunda', 'Tre20170321102051', 'Payment', '2017-03-21 10:20:51', '69.0000', 'Sale', '2017-03-21 11:20:51', 1),
(26, 'Takunda', 'Tre20170321102051', 'Receipt', '2017-03-21 10:20:51', '69.0000', 'Sale', '2017-03-21 11:20:51', 1),
(27, 'Takunda', 'Tre20170321102633', 'Payment', '2017-03-21 10:26:33', '34.5000', 'Sale', '2017-03-21 11:26:33', 1),
(28, 'Takunda', 'Tre20170321102633', 'Receipt', '2017-03-21 10:26:33', '34.5000', 'Sale', '2017-03-21 11:26:33', 1),
(29, 'Takunda', 'Tre20170321103509', 'Payment', '2017-03-21 10:35:09', '69.0000', 'Sale', '2017-03-21 11:35:10', 1),
(30, 'Takunda', 'Tre20170321103509', 'Receipt', '2017-03-21 10:35:09', '69.0000', 'Sale', '2017-03-21 11:35:10', 1),
(31, 'Takunda', 'Tre20170321103955', 'Payment', '2017-03-21 10:39:55', '58.6500', 'Sale', '2017-03-21 11:39:55', 1),
(32, 'Takunda', 'Tre20170321103955', 'Receipt', '2017-03-21 10:39:55', '58.6500', 'Sale', '2017-03-21 11:39:55', 1),
(33, 'Takunda', 'Tre20170321105824', 'Payment', '2017-03-21 10:58:24', '33.8100', 'Sale', '2017-03-21 11:58:25', 1),
(34, 'Takunda', 'Tre20170321105824', 'Receipt', '2017-03-21 10:58:24', '33.8100', 'Sale', '2017-03-21 11:58:25', 1),
(35, 'Takunda', 'Tre20170321105857', 'Payment', '2017-03-21 10:58:57', '31.0500', 'Sale', '2017-03-21 11:58:58', 1),
(36, 'Takunda', 'Tre20170321105857', 'Receipt', '2017-03-21 10:58:57', '31.0500', 'Sale', '2017-03-21 11:58:58', 1),
(37, 'Takunda', 'Tre20170321110004', 'Payment', '2017-03-21 11:00:04', '99.3600', 'Sale', '2017-03-21 12:00:04', 1),
(38, 'Takunda', 'Tre20170321110004', 'Receipt', '2017-03-21 11:00:04', '99.3600', 'Sale', '2017-03-21 12:00:04', 1),
(39, 'Takunda', 'Tre20170321110344', 'Payment', '2017-03-21 11:03:44', '27.6000', 'Sale', '2017-03-21 12:03:45', 2),
(40, 'Takunda', 'Tre20170321110344', 'Receipt', '2017-03-21 11:03:44', '27.6000', 'Sale', '2017-03-21 12:03:45', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_details`
--
ALTER TABLE `category_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prod_audit`
--
ALTER TABLE `prod_audit`
  ADD PRIMARY KEY (`audit_id`),
  ADD UNIQUE KEY `audit_id` (`audit_id`);

--
-- Indexes for table `receipt_header_info`
--
ALTER TABLE `receipt_header_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_details`
--
ALTER TABLE `stock_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_entries`
--
ALTER TABLE `stock_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_movement`
--
ALTER TABLE `stock_movement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_sales`
--
ALTER TABLE `stock_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_user`
--
ALTER TABLE `stock_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_details`
--
ALTER TABLE `store_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_details`
--
ALTER TABLE `supplier_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_uom`
--
ALTER TABLE `tbl_uom`
  ADD PRIMARY KEY (`uom_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_list_age_data`
--
ALTER TABLE `transaction_list_age_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_list_debtorage_data`
--
ALTER TABLE `transaction_list_debtorage_data`
  ADD PRIMARY KEY (`Age_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_details`
--
ALTER TABLE `category_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `prod_audit`
--
ALTER TABLE `prod_audit`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `receipt_header_info`
--
ALTER TABLE `receipt_header_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `stock_details`
--
ALTER TABLE `stock_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `stock_entries`
--
ALTER TABLE `stock_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_movement`
--
ALTER TABLE `stock_movement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `stock_sales`
--
ALTER TABLE `stock_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `stock_user`
--
ALTER TABLE `stock_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `store_details`
--
ALTER TABLE `store_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `supplier_details`
--
ALTER TABLE `supplier_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_uom`
--
ALTER TABLE `tbl_uom`
  MODIFY `uom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction_list_age_data`
--
ALTER TABLE `transaction_list_age_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction_list_debtorage_data`
--
ALTER TABLE `transaction_list_debtorage_data`
  MODIFY `Age_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
