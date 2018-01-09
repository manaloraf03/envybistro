-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2018 at 10:38 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `envybistro`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounting_period`
--

CREATE TABLE `accounting_period` (
  `accounting_period_id` bigint(20) NOT NULL,
  `period_start` date DEFAULT '0000-00-00',
  `period_end` date DEFAULT '0000-00-00',
  `closed_by_user` bigint(20) DEFAULT '0',
  `date_time_closed` datetime DEFAULT '0000-00-00 00:00:00',
  `remarks` varchar(1000) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_classes`
--

CREATE TABLE `account_classes` (
  `account_class_id` bigint(20) NOT NULL,
  `account_class` varchar(755) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  `account_type_id` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` date DEFAULT '0000-00-00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_classes`
--

INSERT INTO `account_classes` (`account_class_id`, `account_class`, `description`, `account_type_id`, `date_created`, `date_modified`, `date_deleted`, `created_by_user`, `modified_by_user`, `deleted_by_user`, `is_active`, `is_deleted`) VALUES
(1, 'Current Assets', '', 1, '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 0, 0, 0, b'1', b'0'),
(2, 'Non-Current Assets', '', 1, '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 0, 0, 0, b'1', b'0'),
(3, 'Current Liabilities', '', 2, '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 0, 0, 0, b'1', b'0'),
(4, 'Long-term Liabilities', '', 2, '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 0, 0, 0, b'1', b'0'),
(5, 'Owners Equity', '', 3, '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 0, 0, 0, b'1', b'0'),
(6, 'Operating Expense', '', 5, '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 0, 0, 0, b'1', b'0'),
(7, 'Income', '', 4, '0000-00-00 00:00:00', '0000-00-00', '0000-00-00 00:00:00', 0, 0, 0, b'1', b'0'),
(8, 'capital', 'capita;', NULL, '2017-09-07 13:58:04', '0000-00-00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'1'),
(9, 'Operating Expenses', '', NULL, '2017-09-07 15:46:05', '0000-00-00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'1'),
(10, '12', '12', NULL, '2017-12-05 09:43:47', '0000-00-00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `account_integration`
--

CREATE TABLE `account_integration` (
  `integration_id` int(11) NOT NULL,
  `input_tax_account_id` bigint(20) DEFAULT '0',
  `payable_account_id` bigint(20) DEFAULT '0',
  `payable_discount_account_id` bigint(20) DEFAULT '0',
  `payment_to_supplier_id` bigint(20) DEFAULT '0',
  `output_tax_account_id` bigint(20) DEFAULT '0',
  `receivable_account_id` bigint(20) DEFAULT '0',
  `receivable_discount_account_id` bigint(20) DEFAULT '0',
  `payment_from_customer_id` bigint(20) DEFAULT '0',
  `retained_earnings_id` bigint(20) DEFAULT '0',
  `petty_cash_account_id` int(11) DEFAULT '0',
  `sales_invoice_inventory` bit(1) DEFAULT NULL,
  `depreciation_expense_debit_id` bigint(20) DEFAULT '0',
  `depreciation_expense_credit_id` bigint(20) DEFAULT '0',
  `cash_invoice_debit_id` bigint(20) DEFAULT '0',
  `cash_invoice_credit_id` bigint(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_integration`
--

INSERT INTO `account_integration` (`integration_id`, `input_tax_account_id`, `payable_account_id`, `payable_discount_account_id`, `payment_to_supplier_id`, `output_tax_account_id`, `receivable_account_id`, `receivable_discount_account_id`, `payment_from_customer_id`, `retained_earnings_id`, `petty_cash_account_id`, `sales_invoice_inventory`, `depreciation_expense_debit_id`, `depreciation_expense_credit_id`, `cash_invoice_debit_id`, `cash_invoice_credit_id`) VALUES
(1, 65, 16, 31, 3, 34, 9, 31, 4, 3, 7, b'0', 52, 53, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_titles`
--

CREATE TABLE `account_titles` (
  `account_id` bigint(20) NOT NULL,
  `account_no` varchar(75) DEFAULT '',
  `account_title` varchar(755) DEFAULT '',
  `account_class_id` int(11) DEFAULT '0',
  `parent_account_id` int(11) DEFAULT '0',
  `grand_parent_id` int(11) DEFAULT '0',
  `description` varchar(1000) DEFAULT '',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_titles`
--

INSERT INTO `account_titles` (`account_id`, `account_no`, `account_title`, `account_class_id`, `parent_account_id`, `grand_parent_id`, `description`, `date_created`, `date_modified`, `date_deleted`, `created_by_user`, `modified_by_user`, `deleted_by_user`, `is_active`, `is_deleted`) VALUES
(1, '1000', 'Cash in Bank - Security Bank', 1, 0, 1, '', '2017-09-07 14:14:09', '0000-00-00 00:00:00', '2017-09-07 15:10:51', 1, 0, 1, b'1', b'1'),
(2, '2000', 'Short Term Loan', 3, 0, 2, '', '2017-09-07 14:14:52', '0000-00-00 00:00:00', '2017-09-07 15:10:47', 1, 0, 1, b'1', b'1'),
(3, '1', 'Cash in Bank', 1, 0, 3, '', '2017-09-07 15:13:03', '2017-09-07 15:18:24', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(4, '1000', 'Cash in Bank - Security Bank', 1, 3, 3, '', '2017-09-07 15:17:07', '2017-09-07 15:20:42', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(5, '1001', 'Cash in Bank - BDO', 1, 3, 3, '', '2017-09-07 15:21:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(6, '1002', 'Cash in Bank - Maybank', 1, 3, 3, '', '2017-09-07 15:23:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(7, '1003', 'Petty Cash', 1, 0, 7, '', '2017-09-07 15:24:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(8, '1004', 'Cash on Hand', 1, 0, 8, '', '2017-09-07 15:25:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(9, '1200', 'Account Receivables ', 1, 0, 9, '', '2017-09-07 15:26:11', '2017-09-07 15:29:39', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(10, '1201', 'Account Receivables and Others', 1, 0, 9, '', '2017-09-07 15:28:12', '2017-09-07 15:41:38', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(11, '1300', 'Furniture and Fixtures', 1, 0, 11, '', '2017-09-07 15:29:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(12, '1201', 'Account Receivables and Others', 1, 9, 9, '', '2017-09-07 15:30:43', '0000-00-00 00:00:00', '2017-09-07 15:30:57', 1, 0, 1, b'1', b'1'),
(13, '1310', 'Equipments', 1, 0, 13, '', '2017-09-07 15:40:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(14, '2000', 'Short Term Loan', 3, 0, 14, '', '2017-09-07 15:41:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(15, '2010', 'Long Term Loan', 3, 0, 15, '', '2017-09-07 15:42:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(16, '2020', 'Account Payable', 3, 0, 16, '', '2017-09-07 15:42:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(17, '3000', 'Sales', 7, 0, 17, '', '2017-09-07 15:43:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(18, '3010', 'Service Income', 7, 0, 18, '', '2017-09-07 15:43:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(19, '3020', 'Other Income', 7, 0, 19, '', '2017-09-07 15:44:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(20, '4000', 'Salaries and Wages - Admin', 9, 0, 20, '', '2017-09-07 15:46:08', '0000-00-00 00:00:00', '2017-09-07 15:48:20', 1, 0, 1, b'1', b'1'),
(21, '4000', 'Salaries and Wages - Admin', 9, 0, 21, '', '2017-09-07 15:47:08', '0000-00-00 00:00:00', '2017-09-07 15:48:30', 1, 0, 1, b'1', b'1'),
(22, '4000', 'Salaries and Wages', 9, 0, 22, '', '2017-09-07 15:49:17', '0000-00-00 00:00:00', '2017-09-07 16:13:58', 1, 0, 1, b'1', b'1'),
(23, '4010', 'Salaries and Wages - Admin', 6, 0, 23, '', '2017-09-07 15:58:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(24, '4010', 'Salaries and Wages - Programmer', 9, 0, 24, '', '2017-09-07 16:26:34', '0000-00-00 00:00:00', '2017-09-07 16:27:02', 1, 0, 1, b'1', b'1'),
(25, '4010', 'Salaries and Wages - Programmer', 6, 0, 25, '', '2017-09-07 16:28:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(26, '4020', 'Office Supplies', 6, 0, 26, '', '2017-09-07 16:28:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(27, '4030', 'Repair and Maintenance', 6, 0, 27, '', '2017-09-07 16:28:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(28, '4032', 'Gas and Oil', 6, 0, 28, '', '2017-09-07 16:29:23', '2017-09-07 16:29:58', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(29, '4035', 'Purchases', 6, 0, 29, '', '2017-09-07 16:30:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(30, '4040', 'Meal Allowances', 6, 0, 30, '', '2017-09-07 16:39:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(31, '4050', 'Discount', 6, 0, 31, '', '2017-09-07 16:40:24', '2017-12-05 14:20:40', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(32, '4060', 'Donation and Contribution', 6, 0, 32, '', '2017-09-07 16:40:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(33, '4060', 'With Holding Tax', 6, 0, 33, '', '2017-09-07 16:41:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(34, '4080', 'Tax and License', 6, 0, 34, '', '2017-09-07 16:42:04', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(35, '4090', 'Permit and Doc Stamp', 6, 0, 35, '', '2017-09-07 16:42:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(36, '4100', 'Garbage Fee', 6, 0, 36, '', '2017-09-07 16:43:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(37, '4120', 'Electric Consumption', 6, 0, 37, '', '2017-09-07 16:43:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(38, '4200', 'Water Consumption', 6, 0, 38, '', '2017-09-07 16:44:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(39, '4300', 'Cable and Internet', 6, 0, 39, '', '2017-09-07 16:44:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(40, '4400', 'Janitorial Services', 6, 0, 40, '', '2017-09-07 16:44:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(41, '4500', 'Construction and Improvements', 6, 0, 41, '', '2017-09-07 16:45:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(42, '4600', 'Labor', 6, 0, 42, '', '2017-09-07 16:45:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(43, '4700', 'Transportation Expense', 6, 0, 43, '', '2017-09-07 16:47:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(44, '4800', 'OJT - Allowance - Trainee', 6, 0, 44, '', '2017-09-07 16:48:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(45, '    ', '         ', 6, 0, 45, '', '2017-09-07 16:48:21', '0000-00-00 00:00:00', '2017-09-07 16:55:02', 1, 0, 1, b'1', b'1'),
(46, '         ', '            ', 6, 0, 46, '', '2017-09-07 16:48:48', '0000-00-00 00:00:00', '2017-09-07 16:55:11', 1, 0, 1, b'1', b'1'),
(47, '4810', 'Groceries and Snacks', 6, 0, 47, '', '2017-09-07 16:55:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(48, '4900', '13th Month ', 6, 0, 48, '', '2017-09-07 16:56:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(49, '4910', 'Christmas and Other Bonuses ', 6, 0, 49, '', '2017-09-07 16:56:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(50, '5000', 'Capital', 6, 0, 50, '', '2017-09-07 16:57:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(51, '9000', 'Retained Earmings', 2, 0, 51, '', '2017-09-14 11:45:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(52, '100005', 'Depreciation Expense', 6, 0, 52, '', '2017-09-27 11:20:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(53, '100006', 'Accumulative Depreciation', 1, 0, 53, '', '2017-09-27 11:20:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(54, '6000', 'Rental Fee', 6, 0, 54, '', '2017-10-04 17:23:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(55, '6001', 'Suspense Account', 6, 0, 55, '', '2017-11-09 10:29:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(56, '6001-1', 'Suspense Account A', 6, 55, 55, '', '2017-11-09 10:30:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(57, '3000-1', 'Sales A', 7, 17, 17, '', '2017-11-09 10:32:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(58, '12', '12', 10, 0, 58, '', '2017-12-05 09:43:50', '0000-00-00 00:00:00', '2017-12-13 13:36:27', 1, 0, 1, b'1', b'1'),
(59, '1231', 'Check Account1', 1, 0, 59, '', '2017-12-08 10:22:28', '2017-12-13 17:13:33', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(60, '121', 'Card Account', 1, 0, 60, '', '2017-12-08 10:22:39', '2017-12-15 13:27:37', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(61, '121', 'Bar Sales', 7, 0, 61, '', '2017-12-08 10:23:09', '2017-12-13 13:37:11', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(62, '23432', 'Room Sales', 7, 0, 62, '', '2017-12-08 10:23:20', '2017-12-13 12:02:31', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(63, 'ew', 'Other Sales', 7, 0, 63, '', '2017-12-08 10:24:06', '2017-12-13 13:35:23', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0'),
(64, '1100002', 'Inventory', 1, 0, 64, '', '2017-12-15 12:11:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0'),
(65, '1110212', 'Input Vat', 2, 0, 65, '', '2018-01-05 17:18:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `account_type_id` int(11) NOT NULL,
  `account_type` varchar(155) DEFAULT '',
  `description` varchar(1000) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`account_type_id`, `account_type`, `description`) VALUES
(1, 'Asset', ''),
(2, 'Liability', ''),
(3, 'Capital', ''),
(4, 'Income', ''),
(5, 'Expense', '');

-- --------------------------------------------------------

--
-- Table structure for table `account_year`
--

CREATE TABLE `account_year` (
  `account_year_id` bigint(20) NOT NULL,
  `account_year` varchar(100) DEFAULT '',
  `description` varchar(755) DEFAULT '',
  `status` varchar(100) DEFAULT NULL,
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `date_closed` datetime DEFAULT '0000-00-00 00:00:00',
  `closed_by_user` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `adjustment_info`
--

CREATE TABLE `adjustment_info` (
  `adjustment_id` bigint(20) NOT NULL,
  `adjustment_code` varchar(75) DEFAULT '',
  `department_id` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `adjustment_type` varchar(20) DEFAULT 'IN',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `date_adjusted` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT NULL,
  `posted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `pos_is_received` bit(1) DEFAULT b'0',
  `is_for_pos` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `adjustment_items`
--

CREATE TABLE `adjustment_items` (
  `adjustment_item_id` bigint(20) NOT NULL,
  `adjustment_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `adjust_qty` decimal(20,0) DEFAULT '0',
  `adjust_price` decimal(20,4) DEFAULT '0.0000',
  `adjust_discount` decimal(20,4) DEFAULT '0.0000',
  `adjust_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `adjust_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `adjust_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `adjust_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `adjust_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `approval_status`
--

CREATE TABLE `approval_status` (
  `approval_id` int(11) NOT NULL,
  `approval_status` varchar(100) DEFAULT '',
  `approval_description` varchar(555) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approval_status`
--

INSERT INTO `approval_status` (`approval_id`, `approval_status`, `approval_description`, `is_active`, `is_deleted`) VALUES
(1, 'Approved', '', b'1', b'0'),
(2, 'Pending', '', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `asset_property_status`
--

CREATE TABLE `asset_property_status` (
  `asset_status_id` int(11) NOT NULL,
  `asset_property_status` varchar(50) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `asset_property_status`
--

INSERT INTO `asset_property_status` (`asset_status_id`, `asset_property_status`, `is_active`, `is_deleted`) VALUES
(1, 'Active', 1, 0),
(2, 'Inactive', 1, 0),
(3, 'Obsolete', 1, 0),
(4, 'Lost', 1, 0),
(5, 'Damage', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bank_id` int(11) NOT NULL,
  `bank_code` varchar(20) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `account_type` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_reconciliation`
--

CREATE TABLE `bank_reconciliation` (
  `bank_recon_id` int(11) NOT NULL,
  `bank_id` int(11) DEFAULT '0',
  `date_reconciled` date DEFAULT '0000-00-00',
  `reconciled_by` int(11) DEFAULT '0',
  `account_id` int(11) DEFAULT '0',
  `account_balance` decimal(10,0) DEFAULT '0',
  `bank_service_charge` decimal(10,0) DEFAULT '0',
  `nsf_check` decimal(10,0) DEFAULT '0',
  `check_printing_charge` decimal(10,0) DEFAULT '0',
  `interest_earned` decimal(10,0) DEFAULT '0',
  `notes_receivable` decimal(10,0) DEFAULT '0',
  `actual_balance` decimal(10,0) DEFAULT '0',
  `outstanding_checks` decimal(10,0) DEFAULT '0',
  `deposit_in_transit` decimal(10,0) DEFAULT '0',
  `journal_adjusted_collection` decimal(10,0) DEFAULT '0',
  `bank_adjusted_collection` decimal(10,0) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_reconciliation_details`
--

CREATE TABLE `bank_reconciliation_details` (
  `bank_recon_item_id` int(11) NOT NULL,
  `bank_recon_id` int(11) DEFAULT '0',
  `journal_id` int(11) DEFAULT '0',
  `check_status` int(11) DEFAULT '0' COMMENT '0 = no selected\n1 = outstanding\n2 = good check'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `batch_info`
--

CREATE TABLE `batch_info` (
  `batch_id` bigint(20) NOT NULL,
  `batch_no` varchar(75) DEFAULT '',
  `date_replenished` datetime DEFAULT '0000-00-00 00:00:00',
  `replenished_by` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` bigint(20) NOT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `card_id` bigint(20) NOT NULL,
  `card_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cash_invoice`
--

CREATE TABLE `cash_invoice` (
  `cash_invoice_id` bigint(20) NOT NULL,
  `cash_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL,
  `email_address` varchar(75) DEFAULT NULL,
  `contact_no` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_invoice`
--

INSERT INTO `cash_invoice` (`cash_invoice_id`, `cash_inv_no`, `sales_order_id`, `sales_order_no`, `order_status_id`, `department_id`, `issue_to_department`, `customer_id`, `journal_id`, `terms`, `remarks`, `total_discount`, `total_overall_discount`, `total_overall_discount_amount`, `total_after_discount`, `total_before_tax`, `total_tax_amount`, `total_after_tax`, `date_due`, `date_invoice`, `date_created`, `date_deleted`, `date_modified`, `posted_by_user`, `deleted_by_user`, `modified_by_user`, `is_paid`, `is_active`, `is_deleted`, `is_journal_posted`, `ref_product_type_id`, `inv_type`, `salesperson_id`, `address`, `contact_person`, `email_address`, `contact_no`) VALUES
(5, 'CI-INV-20171109-5', 0, '', 1, 2, NULL, 2, 0, 0, '1', '75.0000', '10.0000', '67.5000', '607.5000', '750.0000', '0.0000', '675.0000', '1970-01-01', '2017-11-09', '2017-11-09 17:24:07', '2017-11-14 11:14:47', '2017-11-14 03:53:58', 1, 1, 1, b'0', b'1', b'1', b'1', 0, 1, NULL, 'ma', '1', NULL, NULL),
(6, 'CI-INV-20171110-6', 0, '', 1, 2, NULL, 2, 0, 0, '', '400.0000', '10.0000', '360.0000', '3240.0000', '4000.0000', '0.0000', '3600.0000', '1970-01-01', '2017-11-10', '2017-11-10 09:46:32', '2017-11-10 10:29:13', '2017-11-14 01:41:47', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'ma', '12', NULL, NULL),
(7, 'CI-INV-20171110-7', 0, '', 1, 3, NULL, 1, 141, 0, '12122111', '400.0000', '0.0000', '0.0000', '5400.0000', '5800.0000', '0.0000', '5400.0000', '1970-01-01', '2017-11-10', '2017-11-10 09:51:30', '0000-00-00 00:00:00', '2017-11-14 07:07:21', 1, 0, 1, b'0', b'1', b'0', b'1', 0, 1, NULL, 'Adress', '1qwqw', NULL, NULL),
(8, 'CI-INV-20171110-8', 0, '', 1, NULL, NULL, 1, 140, 0, '', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1970-01-01', '2017-11-10', '2017-11-10 14:59:22', '0000-00-00 00:00:00', '2017-11-14 07:07:02', 1, 0, 0, b'0', b'1', b'0', b'1', 0, 1, 0, '', '', NULL, NULL),
(9, 'CI-INV-20171110-9', 0, '', 1, NULL, NULL, 2, 139, 0, '', '0.0000', '0.0000', '0.0000', '750.0000', '750.0000', '0.0000', '750.0000', '1970-01-01', '2017-11-10', '2017-11-10 15:08:41', '0000-00-00 00:00:00', '2017-11-14 07:06:55', 1, 0, 1, b'0', b'1', b'0', b'1', 0, 1, NULL, 'asdas', '', NULL, NULL),
(10, 'CI-INV-20171110-10', 0, '', 1, NULL, NULL, 3, 138, 0, '', '108.0000', '5.0000', '1090.6000', '20721.4000', '21794.6500', '125.3500', '21812.0000', '1970-01-01', '2017-11-10', '2017-11-10 15:09:35', '0000-00-00 00:00:00', '2017-11-14 07:06:35', 1, 0, 1, b'0', b'1', b'0', b'1', 0, 1, NULL, 'Angeles City', 'Prescripto Corporation', '', ''),
(11, 'CI-INV-20171114-11', 0, '', 1, NULL, NULL, 2, 0, 0, 'Rafael Manalo', '108.0000', '10.0000', '97.2000', '874.8000', '964.2900', '115.7100', '972.0000', '1970-01-01', '2017-11-14', '2017-11-14 09:54:33', '2017-11-14 10:57:28', '2017-11-14 04:06:16', 1, 1, 1, b'0', b'1', b'1', b'0', 0, 1, NULL, 'Angeles City', '', NULL, NULL),
(12, 'CI-INV-20171114-12', 0, '', 1, NULL, NULL, 3, 0, 0, 'No Remarks', '0.0000', '0.0000', '0.0000', '20000.0000', '20000.0000', '0.0000', '20000.0000', '1970-01-01', '2017-11-14', '2017-11-14 09:58:50', '0000-00-00 00:00:00', '2017-11-14 03:54:30', 1, 0, 1, b'0', b'1', b'0', b'1', 0, 1, NULL, 'Angeles City', 'Rafael Manalo', 'prescriptophil@yahoo.com', '+632349820982'),
(13, 'CI-INV-20171114-13', 0, '', 1, NULL, NULL, 1, 142, 0, '', '0.0000', '0.0000', '0.0000', '240.0000', '230.3600', '9.6400', '240.0000', '1970-01-01', '2017-11-14', '2017-11-14 15:10:17', '0000-00-00 00:00:00', '2017-11-14 07:12:09', 1, 0, 0, b'0', b'1', b'0', b'1', 0, 1, 0, 'Angeles City', 'Rafael Manalo', 'manaloraf03@gmail.com', '09453158563');

-- --------------------------------------------------------

--
-- Table structure for table `cash_invoice_items`
--

CREATE TABLE `cash_invoice_items` (
  `cash_item_id` bigint(20) NOT NULL,
  `cash_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,0) DEFAULT '0',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_invoice_items`
--

INSERT INTO `cash_invoice_items` (`cash_item_id`, `cash_invoice_id`, `product_id`, `unit_id`, `inv_price`, `orig_so_price`, `inv_discount`, `inv_line_total_discount`, `inv_tax_rate`, `cost_upon_invoice`, `inv_qty`, `inv_gross`, `inv_line_total_price`, `inv_tax_amount`, `inv_non_tax_amount`, `inv_line_total_after_global`, `inv_notes`, `dr_invoice_id`, `exp_date`, `batch_no`) VALUES
(10, 6, 9, 1, '4000.0000', '0.0000', '10.0000', '400.0000', '0.0000', '0.0000', '1', '4000.0000', '3600.0000', '0.0000', '4000.0000', '3240.0000', NULL, NULL, '0000-00-00', ''),
(18, 7, 9, 1, '4000.0000', '0.0000', '10.0000', '400.0000', '0.0000', '0.0000', '1', '4000.0000', '3600.0000', '0.0000', '4000.0000', '3600.0000', NULL, NULL, '0000-00-00', ''),
(19, 7, 2, 1, '150.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '12', '1800.0000', '1800.0000', '0.0000', '1800.0000', '1800.0000', NULL, NULL, '0000-00-00', ''),
(23, 5, 3, 3, '750.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '1', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, NULL, '0000-00-00', ''),
(24, 9, 3, 3, '750.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1', '750.0000', '750.0000', '0.0000', '750.0000', '750.0000', NULL, NULL, '0000-00-00', ''),
(27, 11, 1, 2, '90.0000', '0.0000', '10.0000', '108.0000', '12.0000', '0.0000', '12', '1080.0000', '972.0000', '115.7143', '964.2857', '874.8000', NULL, NULL, '0000-00-00', ''),
(38, 12, 4, 4, '20000.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1', '20000.0000', '20000.0000', '0.0000', '20000.0000', '20000.0000', NULL, NULL, '0000-00-00', ''),
(45, 10, 1, 2, '90.0000', '0.0000', '10.0000', '108.0000', '12.0000', '0.0000', '12', '1080.0000', '972.0000', '115.7143', '964.2857', '923.4000', NULL, NULL, '0000-00-00', ''),
(46, 10, 1, 2, '90.0000', '0.0000', '0.0000', '0.0000', '12.0000', '0.0000', '1', '90.0000', '90.0000', '9.6400', '80.3600', '85.5000', NULL, NULL, '0000-00-00', ''),
(47, 10, 8, 4, '20000.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1', '20000.0000', '20000.0000', '0.0000', '20000.0000', '19000.0000', NULL, NULL, '0000-00-00', ''),
(48, 10, 3, 3, '750.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1', '750.0000', '750.0000', '0.0000', '750.0000', '712.5000', NULL, NULL, '0000-00-00', ''),
(49, 13, 1, 2, '90.0000', '0.0000', '0.0000', '0.0000', '12.0000', '0.0000', '1', '90.0000', '90.0000', '9.6400', '80.3600', '90.0000', NULL, NULL, '0000-00-00', ''),
(50, 13, 2, 1, '150.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1', '150.0000', '150.0000', '0.0000', '150.0000', '150.0000', NULL, NULL, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(20) NOT NULL,
  `category_code` bigint(20) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `category_desc` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_code`, `category_name`, `category_desc`, `date_created`, `date_modified`, `is_deleted`, `is_active`) VALUES
(1, NULL, 'Desserts', '', NULL, '0000-00-00 00:00:00', b'0', b'1'),
(2, NULL, 'Food', '', NULL, '0000-00-00 00:00:00', b'0', b'1'),
(3, NULL, 'Liquor', '', NULL, '0000-00-00 00:00:00', b'0', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` bigint(20) NOT NULL,
  `chat_code` varchar(150) DEFAULT '0',
  `message` varchar(160) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_deleted` datetime DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `check_layout`
--

CREATE TABLE `check_layout` (
  `check_layout_id` int(11) NOT NULL,
  `check_layout` varchar(755) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  `particular_pos_left` decimal(20,0) DEFAULT '0',
  `particular_pos_top` decimal(20,0) DEFAULT '0',
  `particular_font_family` varchar(555) DEFAULT 'Tahoma',
  `particular_font_size` varchar(20) DEFAULT '12pt',
  `particular_is_italic` varchar(55) DEFAULT 'normal',
  `particular_is_bold` varchar(55) DEFAULT 'bold',
  `words_pos_left` decimal(20,4) DEFAULT '0.0000',
  `words_pos_top` decimal(20,4) DEFAULT '0.0000',
  `words_font_family` varchar(555) DEFAULT 'Tahoma',
  `words_font_size` varchar(20) DEFAULT '12pt',
  `words_is_italic` varchar(55) DEFAULT 'normal',
  `words_is_bold` varchar(55) DEFAULT 'bold',
  `amount_pos_left` decimal(20,4) DEFAULT '0.0000',
  `amount_pos_top` decimal(20,4) DEFAULT '0.0000',
  `amount_font_family` varchar(555) DEFAULT '',
  `amount_font_size` varchar(20) DEFAULT '12pt',
  `amount_is_italic` varchar(55) DEFAULT 'normal',
  `amount_is_bold` varchar(20) DEFAULT 'bold',
  `date_pos_left` decimal(20,4) DEFAULT '0.0000',
  `date_pos_top` decimal(20,4) DEFAULT '0.0000',
  `date_font_family` varchar(555) DEFAULT '',
  `date_font_size` varchar(20) DEFAULT '12pt',
  `date_is_italic` varchar(55) DEFAULT 'normal',
  `date_is_bold` varchar(55) DEFAULT 'bold',
  `is_portrait` bit(1) DEFAULT b'1',
  `posted_by_user` bigint(20) DEFAULT '0',
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` bigint(20) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by_user` bigint(20) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `check_layout`
--

INSERT INTO `check_layout` (`check_layout_id`, `check_layout`, `description`, `particular_pos_left`, `particular_pos_top`, `particular_font_family`, `particular_font_size`, `particular_is_italic`, `particular_is_bold`, `words_pos_left`, `words_pos_top`, `words_font_family`, `words_font_size`, `words_is_italic`, `words_is_bold`, `amount_pos_left`, `amount_pos_top`, `amount_font_family`, `amount_font_size`, `amount_is_italic`, `amount_is_bold`, `date_pos_left`, `date_pos_top`, `date_font_family`, `date_font_size`, `date_is_italic`, `date_is_bold`, `is_portrait`, `posted_by_user`, `date_posted`, `modified_by_user`, `date_modified`, `deleted_by_user`, `date_deleted`, `is_active`, `is_deleted`) VALUES
(1, 'Security Bank', '', '46', '834', 'Tahoma', '16px', 'normal', 'bold', '27.7539', '863.7270', 'Tahoma', '16px', 'normal', 'bold', '527.6250', '828.6370', 'Segoe UI, Source Sans Pro, Calibri, Candara, Arial, sans-serif', '16px', 'normal', 'bold', '528.7110', '797.6520', 'Segoe UI, Source Sans Pro, Calibri, Candara, Arial, sans-serif', '16px', 'normal', 'bold', b'1', 1, '2017-09-13 11:47:30', 0, '2017-10-19 14:50:38', 0, '0000-00-00 00:00:00', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `commercial_invoice`
--

CREATE TABLE `commercial_invoice` (
  `commercial_invoice_id` bigint(20) NOT NULL,
  `commercial_inv_no` varchar(75) DEFAULT '',
  `bill_customer` varchar(175) DEFAULT NULL,
  `bill_address` varchar(255) DEFAULT NULL,
  `bill_email` varchar(75) DEFAULT NULL,
  `ship_customer` varchar(175) DEFAULT NULL,
  `ship_address` varchar(225) DEFAULT NULL,
  `ship_contact` varchar(75) DEFAULT NULL,
  `ship_number` varchar(75) DEFAULT NULL,
  `ship_city` varchar(75) DEFAULT NULL,
  `ship_zipcode` varchar(75) DEFAULT NULL,
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commercial_invoice`
--

INSERT INTO `commercial_invoice` (`commercial_invoice_id`, `commercial_inv_no`, `bill_customer`, `bill_address`, `bill_email`, `ship_customer`, `ship_address`, `ship_contact`, `ship_number`, `ship_city`, `ship_zipcode`, `sales_order_id`, `sales_order_no`, `order_status_id`, `department_id`, `issue_to_department`, `customer_id`, `journal_id`, `terms`, `remarks`, `total_discount`, `total_overall_discount`, `total_overall_discount_amount`, `total_after_discount`, `total_before_tax`, `total_tax_amount`, `total_after_tax`, `date_due`, `date_invoice`, `date_created`, `date_deleted`, `date_modified`, `posted_by_user`, `deleted_by_user`, `modified_by_user`, `is_paid`, `is_active`, `is_deleted`, `is_journal_posted`, `ref_product_type_id`, `inv_type`, `salesperson_id`, `address`, `contact_person`) VALUES
(5, 'PRO-INV-20171109-5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', 1, 2, NULL, 2, 0, 0, '1', '75.0000', '10.0000', '67.5000', '607.5000', '750.0000', '0.0000', '675.0000', '1970-01-01', '2017-11-09', '2017-11-09 17:24:07', '2017-11-10 14:23:38', '2017-11-10 06:23:38', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'ma', '1'),
(6, 'PRO-INV-20171110-6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', 1, 2, NULL, 2, 0, 0, '', '400.0000', '10.0000', '360.0000', '3240.0000', '4000.0000', '0.0000', '3600.0000', '1970-01-01', '2017-11-10', '2017-11-10 09:46:32', '2017-11-10 10:29:13', '2017-11-10 02:29:13', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'ma', '12'),
(7, 'PRO-INV-20171110-7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', 1, 3, NULL, 1, 0, 0, '12122111', '400.0000', '0.0000', '0.0000', '5400.0000', '5800.0000', '0.0000', '5400.0000', '1970-01-01', '2017-11-10', '2017-11-10 09:51:30', '2017-11-10 14:23:43', '2017-11-10 06:23:43', 1, 1, 1, b'0', b'1', b'1', b'0', 0, 1, NULL, 'Adress', '1qwqw'),
(8, 'COM-INV-20171110-8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', 1, 3, NULL, 3, 0, 0, '', '174.0000', '15.0000', '1472.4000', '8343.6000', '9883.9300', '106.0700', '9816.0000', '1970-01-01', '2017-11-10', '2017-11-10 14:23:51', '2017-11-10 16:13:45', '2017-11-10 08:13:45', 1, 1, 1, b'0', b'1', b'1', b'0', 0, 1, NULL, 'Angeles City', '1'),
(9, 'COM-INV-20171110-9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', 1, NULL, NULL, NULL, 0, 0, '', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1970-01-01', '2017-11-10', '2017-11-10 15:38:45', '2017-11-10 16:13:47', '2017-11-10 08:13:47', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, NULL, NULL),
(10, 'COM-INV-20171110-10', 'Bill To ', 'Bill Ass', 'Bill Em', 'Ship C', 'S A', 'SC ', 'SPN', 'SC', 'SZ', 0, '', 1, NULL, NULL, NULL, 0, 0, '', '75.0000', '10.0000', '67.5000', '607.5000', '750.0000', '0.0000', '675.0000', '1970-01-01', '2017-11-10', '2017-11-10 15:53:16', '2017-11-10 16:13:49', '2017-11-10 08:13:49', 1, 1, 1, b'0', b'1', b'1', b'0', 0, 1, 0, NULL, NULL),
(11, 'COM-INV-20171110-11', 'Sarah Jane Pabustan', 'Angeles City, Pampanga Phillippines 2009', 'sarahjane9@gmail.com', 'Jason Patawaran', 'Fields Avenue, Central Luzon 2009', '09385658510', '8886805', 'Angeles City (Near Salakot)', '2009', 0, '', 1, 0, 0, 0, 0, 0, 'Remarks', '400.0000', '5.0000', '1180.0000', '22420.0000', '24000.0000', '0.0000', '23600.0000', '0000-00-00', '2017-11-10', '2017-11-10 16:13:24', '0000-00-00 00:00:00', '2017-11-10 09:27:52', 1, 0, 1, b'0', b'1', b'0', b'0', 0, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `commercial_invoice_items`
--

CREATE TABLE `commercial_invoice_items` (
  `commercial_item_id` bigint(20) NOT NULL,
  `commercial_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,0) DEFAULT '0',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commercial_invoice_items`
--

INSERT INTO `commercial_invoice_items` (`commercial_item_id`, `commercial_invoice_id`, `product_id`, `unit_id`, `inv_price`, `orig_so_price`, `inv_discount`, `inv_line_total_discount`, `inv_tax_rate`, `cost_upon_invoice`, `inv_qty`, `inv_gross`, `inv_line_total_price`, `inv_tax_amount`, `inv_non_tax_amount`, `inv_line_total_after_global`, `inv_notes`, `dr_invoice_id`, `exp_date`, `batch_no`) VALUES
(9, 5, 3, 3, '750.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '1', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, NULL, '0000-00-00', ''),
(10, 6, 9, 1, '4000.0000', '0.0000', '10.0000', '400.0000', '0.0000', '0.0000', '1', '4000.0000', '3600.0000', '0.0000', '4000.0000', '3240.0000', NULL, NULL, '0000-00-00', ''),
(18, 7, 9, 1, '4000.0000', '0.0000', '10.0000', '400.0000', '0.0000', '0.0000', '1', '4000.0000', '3600.0000', '0.0000', '4000.0000', '3600.0000', NULL, NULL, '0000-00-00', ''),
(19, 7, 2, 1, '150.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '12', '1800.0000', '1800.0000', '0.0000', '1800.0000', '1800.0000', NULL, NULL, '0000-00-00', ''),
(22, 8, 3, 3, '750.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '1', '750.0000', '675.0000', '0.0000', '750.0000', '573.7500', NULL, NULL, '0000-00-00', ''),
(23, 8, 1, 2, '90.0000', '0.0000', '10.0000', '99.0000', '12.0000', '0.0000', '11', '990.0000', '891.0000', '106.0714', '883.9286', '757.3500', NULL, NULL, '0000-00-00', ''),
(24, 8, 3, 3, '750.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '11', '8250.0000', '8250.0000', '0.0000', '8250.0000', '7012.5000', NULL, NULL, '0000-00-00', ''),
(25, 10, 3, 3, '750.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '1', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, NULL, '0000-00-00', ''),
(27, 11, 9, 1, '4000.0000', '0.0000', '10.0000', '400.0000', '0.0000', '0.0000', '1', '4000.0000', '3600.0000', '0.0000', '4000.0000', '3420.0000', NULL, NULL, '0000-00-00', ''),
(28, 11, 4, 4, '20000.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1', '20000.0000', '20000.0000', '0.0000', '20000.0000', '19000.0000', NULL, NULL, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(555) DEFAULT '',
  `company_address` varchar(755) DEFAULT '',
  `email_address` varchar(155) DEFAULT '',
  `mobile_no` varchar(125) DEFAULT '',
  `landline` varchar(125) DEFAULT '',
  `tin_no` varchar(55) DEFAULT NULL,
  `tax_type_id` int(11) DEFAULT '0',
  `registered_to` varchar(555) DEFAULT '',
  `logo_path` varchar(555) DEFAULT '',
  `rdo_no` varchar(55) DEFAULT NULL,
  `nature_of_business` varchar(155) DEFAULT NULL,
  `business_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`company_id`, `company_name`, `company_address`, `email_address`, `mobile_no`, `landline`, `tin_no`, `tax_type_id`, `registered_to`, `logo_path`, `rdo_no`, `nature_of_business`, `business_type`) VALUES
(1, 'Envy Bistro Sports Suites Inc.', 'ABC Complex Corner of Fields Ave. & Raymond St. Angeles City', 'exampleemail@gmail.com', '0997-XXX-XXXX', '(045) XXX-XXXX', '', 2, '', 'assets/img/company/5a388261e9624.jpg', '', 'ICT', 3);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` bigint(20) NOT NULL,
  `pos_customer_id` bigint(20) DEFAULT NULL,
  `customer_code` varchar(255) DEFAULT '',
  `customer_name` varchar(255) DEFAULT '',
  `contact_name` varchar(255) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `email_address` varchar(255) DEFAULT '',
  `contact_no` varchar(100) DEFAULT '',
  `term` varchar(100) DEFAULT '',
  `department_id` bigint(20) DEFAULT '0',
  `link_department_id` int(11) DEFAULT '0',
  `refcustomertype_id` bigint(20) DEFAULT '0',
  `tin_no` varchar(100) DEFAULT '',
  `photo_path` varchar(500) DEFAULT '',
  `total_receivable_amount` decimal(19,2) DEFAULT '0.00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `credit_limit` decimal(20,4) DEFAULT '0.0000',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `pos_customer_id`, `customer_code`, `customer_name`, `contact_name`, `address`, `email_address`, `contact_no`, `term`, `department_id`, `link_department_id`, `refcustomertype_id`, `tin_no`, `photo_path`, `total_receivable_amount`, `date_created`, `date_modified`, `date_deleted`, `posted_by_user`, `credit_limit`, `modified_by_user`, `deleted_by_user`, `is_paid`, `is_deleted`, `is_active`) VALUES
(1, NULL, '', 'Various Customers', 'Various Customers', 'Various Customers', '', '', NULL, NULL, 0, NULL, '', 'assets/img/anonymous-icon.png', '0.00', '2018-01-08 08:51:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, 0, 0, b'0', b'0', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `customer_photos`
--

CREATE TABLE `customer_photos` (
  `photo_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT '0',
  `photo_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_photos`
--

INSERT INTO `customer_photos` (`photo_id`, `customer_id`, `photo_path`) VALUES
(1, 1, 'assets/img/anonymous-icon.png'),
(3, 3, 'assets/img/anonymous-icon.png'),
(5, 5, 'assets/img/anonymous-icon.png'),
(6, 4, 'assets/img/anonymous-icon.png'),
(7, 6, 'assets/img/anonymous-icon.png'),
(8, 7, 'assets/img/anonymous-icon.png'),
(9, 8, 'assets/img/anonymous-icon.png'),
(10, 9, 'assets/img/anonymous-icon.png'),
(11, 10, 'assets/img/anonymous-icon.png'),
(12, 11, 'assets/img/anonymous-icon.png'),
(13, 12, 'assets/img/anonymous-icon.png'),
(14, 13, 'assets/img/anonymous-icon.png'),
(15, 14, 'assets/img/anonymous-icon.png'),
(17, 16, 'assets/img/anonymous-icon.png'),
(18, 17, 'assets/img/anonymous-icon.png'),
(19, 18, 'assets/img/anonymous-icon.png'),
(20, 19, 'assets/img/anonymous-icon.png'),
(21, 20, 'assets/img/anonymous-icon.png'),
(22, 21, 'assets/img/anonymous-icon.png'),
(23, 2, 'assets/img/anonymous-icon.png'),
(24, 15, 'assets/img/anonymous-icon.png'),
(25, 28, 'assets/img/anonymous-icon.png'),
(26, 29, 'assets/img/anonymous-icon.png'),
(27, 30, 'assets/img/customer/5a30bd7b49101.jpg'),
(28, 32, 'assets/img/anonymous-icon.png'),
(29, 1, 'assets/img/anonymous-icon.png'),
(30, 2, 'assets/img/anonymous-icon.png'),
(31, 3, 'assets/img/anonymous-icon.png'),
(32, 1, 'assets/img/anonymous-icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_invoice`
--

CREATE TABLE `delivery_invoice` (
  `dr_invoice_id` bigint(20) NOT NULL,
  `dr_invoice_no` varchar(75) DEFAULT '',
  `purchase_order_id` int(11) DEFAULT '0',
  `external_ref_no` varchar(75) DEFAULT '',
  `contact_person` varchar(155) DEFAULT '',
  `terms` varchar(55) DEFAULT '',
  `duration` varchar(75) DEFAULT '',
  `supplier_id` int(11) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  `tax_type_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `remarks` varchar(555) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) NOT NULL,
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `date_due` date DEFAULT '0000-00-00',
  `date_delivered` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `batch_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_invoice`
--

INSERT INTO `delivery_invoice` (`dr_invoice_id`, `dr_invoice_no`, `purchase_order_id`, `external_ref_no`, `contact_person`, `terms`, `duration`, `supplier_id`, `department_id`, `tax_type_id`, `journal_id`, `remarks`, `total_discount`, `total_before_tax`, `total_tax_amount`, `total_after_tax`, `total_overall_discount`, `total_overall_discount_amount`, `total_after_discount`, `is_active`, `is_deleted`, `is_paid`, `is_journal_posted`, `date_due`, `date_delivered`, `date_created`, `date_modified`, `date_deleted`, `posted_by_user`, `modified_by_user`, `deleted_by_user`, `batch_no`) VALUES
(1, 'P-INV-20180105-1', 1, '', ' ', ' ', '', 1, 1, 1, 0, '', '0.0000', '3750.0000', '0.0000', '3750.0000', '0.0000', '0.0000', '3750.0000', b'1', b'0', b'0', b'0', '2018-01-05', '2017-12-11', '2018-01-05 17:01:29', '2018-01-09 03:59:46', '0000-00-00 00:00:00', 1, 1, 0, NULL),
(2, 'P-INV-20180105-2', 2, '', ' Keith', ' 30', '', 2, 2, NULL, 0, '', '0.0000', '3571.4300', '428.5700', '4000.0000', '0.0000', '0.0000', '4000.0000', b'1', b'0', b'0', b'0', '2018-01-05', '2018-01-05', '2018-01-05 17:06:00', '2018-01-05 09:06:00', '0000-00-00 00:00:00', 1, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_invoice_items`
--

CREATE TABLE `delivery_invoice_items` (
  `dr_invoice_item_id` bigint(20) NOT NULL,
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `dr_qty` decimal(20,0) DEFAULT '0',
  `dr_discount` decimal(20,4) DEFAULT '0.0000',
  `dr_price` decimal(20,4) DEFAULT '0.0000',
  `dr_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `dr_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `dr_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `dr_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `dr_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `dr_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_invoice_items`
--

INSERT INTO `delivery_invoice_items` (`dr_invoice_item_id`, `dr_invoice_id`, `product_id`, `unit_id`, `dr_qty`, `dr_discount`, `dr_price`, `dr_line_total_discount`, `dr_line_total_price`, `dr_tax_rate`, `dr_tax_amount`, `dr_non_tax_amount`, `dr_line_total_after_global`, `exp_date`, `batch_no`) VALUES
(2, 2, 4, 1, '200', '0.0000', '20.0000', '0.0000', '4000.0000', '12.0000', '428.5700', '3571.4300', '4000.0000', '1970-01-01', NULL),
(3, 1, 3, 2, '50', '0.0000', '75.0000', '0.0000', '3750.0000', '0.0000', '0.0000', '3750.0000', '3750.0000', '1970-01-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_receipt`
--

CREATE TABLE `delivery_receipt` (
  `delivery_receipt_id` bigint(20) NOT NULL,
  `delivery_inv_no` varchar(75) DEFAULT '',
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `sales_inv_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is for open 2 is for closed and 3 is for partial',
  `department_id` int(11) DEFAULT '0',
  `contact_person` varchar(175) NOT NULL,
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,2) NOT NULL,
  `total_overall_discount_amount` decimal(20,4) NOT NULL,
  `total_after_discount` decimal(20,4) NOT NULL,
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_receipt`
--

INSERT INTO `delivery_receipt` (`delivery_receipt_id`, `delivery_inv_no`, `sales_invoice_id`, `sales_inv_no`, `order_status_id`, `department_id`, `contact_person`, `issue_to_department`, `customer_id`, `journal_id`, `terms`, `remarks`, `total_discount`, `total_overall_discount`, `total_overall_discount_amount`, `total_after_discount`, `total_before_tax`, `total_tax_amount`, `total_after_tax`, `date_due`, `date_invoice`, `date_created`, `date_deleted`, `date_modified`, `posted_by_user`, `deleted_by_user`, `modified_by_user`, `is_paid`, `is_active`, `is_deleted`, `is_journal_posted`, `ref_product_type_id`, `inv_type`, `salesperson_id`, `address`) VALUES
(1, 'DR-20171109-1', 0, 'SAL-INV-20171109-1', 1, 2, '223', 0, 1, 0, 0, '', '0.0000', '0.00', '0.0000', '750.0000', '701.7900', '48.2100', '750.0000', '0000-00-00', '2017-11-09', '2017-11-09 09:16:14', '2017-11-09 13:27:30', '2017-11-09 05:27:30', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(2, 'DR-20171109-2', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '240.0000', '10.00', '216.0000', '1944.0000', '2303.5700', '96.4300', '2160.0000', '0000-00-00', '2017-11-09', '2017-11-09 12:19:53', '2017-11-09 12:21:37', '2017-11-09 04:21:37', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(3, 'DR-20171109-3', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '240.0000', '10.00', '216.0000', '1944.0000', '2303.5700', '96.4300', '2160.0000', '0000-00-00', '2017-11-09', '2017-11-09 12:20:10', '2017-11-09 12:21:40', '2017-11-09 04:21:40', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(4, 'DR-20171109-4', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '240.0000', '10.00', '216.0000', '1944.0000', '2303.5700', '96.4300', '2160.0000', '0000-00-00', '2017-11-09', '2017-11-09 12:20:16', '2017-11-09 12:21:41', '2017-11-09 04:21:41', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(5, 'DR-20171109-5', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '240.0000', '10.00', '216.0000', '1944.0000', '2303.5700', '96.4300', '2160.0000', '0000-00-00', '2017-11-09', '2017-11-09 12:20:23', '2017-11-09 12:21:43', '2017-11-09 04:21:43', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(6, 'DR-20171109-6', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '240.0000', '10.00', '216.0000', '1944.0000', '2303.5700', '96.4300', '2160.0000', '0000-00-00', '2017-11-09', '2017-11-09 12:20:48', '2017-11-09 12:57:10', '2017-11-09 04:57:10', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(7, 'DR-20171109-7', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '120.0000', '10.00', '108.0000', '972.0000', '1151.7900', '48.2100', '1080.0000', '0000-00-00', '2017-11-09', '2017-11-09 12:57:21', '2017-11-09 13:31:41', '2017-11-09 05:31:41', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(8, 'DR-20171109-8', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '120.0000', '10.00', '108.0000', '972.0000', '1151.7900', '48.2100', '1080.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:22:16', '2017-11-09 13:31:39', '2017-11-09 05:31:39', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(9, 'DR-20171109-9', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '120.0000', '10.00', '108.0000', '972.0000', '1151.7900', '48.2100', '1080.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:23:45', '2017-11-09 13:31:37', '2017-11-09 05:31:37', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(10, 'DR-20171109-10', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '120.0000', '10.00', '108.0000', '972.0000', '1151.7900', '48.2100', '1080.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:27:11', '2017-11-09 13:31:34', '2017-11-09 05:31:34', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(11, 'DR-20171109-11', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '195.0000', '10.00', '175.5000', '1579.5000', '1901.7900', '48.2100', '1755.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:31:53', '2017-11-09 13:34:50', '2017-11-09 05:34:50', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(12, 'DR-20171109-12', 0, '', 1, 2, '23', 0, 1, 0, 0, '', '18.0000', '0.00', '0.0000', '162.0000', '160.7100', '19.2900', '162.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:32:00', '2017-11-09 13:34:33', '2017-11-09 05:34:33', 1, 1, 1, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(13, 'DR-20171109-13', 0, '', 1, 2, '23', 0, 1, 0, 0, '', '93.0000', '10.00', '83.7000', '753.3000', '910.7100', '19.2900', '837.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:34:58', '2017-11-09 13:49:09', '2017-11-09 05:49:09', 1, 1, 1, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(14, 'DR-20171109-14', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '240.0000', '10.00', '216.0000', '1944.0000', '2303.5700', '96.4300', '2160.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:36:16', '2017-11-09 13:36:33', '2017-11-09 05:36:33', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(15, 'DR-20171109-15', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '213.0000', '10.00', '191.7000', '1725.3000', '2062.5000', '67.5000', '1917.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:36:45', '2017-11-09 13:46:47', '2017-11-09 05:46:47', 1, 1, 1, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(16, 'DR-20171109-16', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '45.0000', '10.00', '40.5000', '364.5000', '401.7900', '48.2100', '405.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:36:59', '2017-11-09 13:37:37', '2017-11-09 05:37:37', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(17, 'DR-20171109-17', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '27.0000', '10.00', '24.3000', '218.7000', '241.0700', '28.9300', '243.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:46:26', '2017-11-09 13:46:41', '2017-11-09 05:46:41', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(18, 'DR-20171109-18', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '120.0000', '0.00', '0.0000', '1080.0000', '1151.7900', '48.2100', '1080.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:46:52', '2017-11-09 13:49:07', '2017-11-09 05:49:07', 1, 1, 1, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(19, 'DR-20171109-19', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '240.0000', '10.00', '216.0000', '1944.0000', '2303.5700', '96.4300', '2160.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:49:18', '2017-11-09 13:49:59', '2017-11-09 05:49:59', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'Adress'),
(20, 'DR-20171109-20', 1, '', 1, 2, '23', 0, 1, 0, 0, '', '120.0000', '10.00', '108.0000', '972.0000', '1151.7900', '48.2100', '1080.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:50:08', '0000-00-00 00:00:00', '2017-11-09 05:50:20', 1, 0, 1, b'0', b'1', b'0', b'0', 0, 1, 0, 'Adress'),
(21, 'DR-20171109-21', 2, '', 1, 3, 'Contact Person', 0, 1, 0, 0, '', '2688.0000', '35.00', '403.2000', '748.8000', '3685.7100', '154.2900', '1152.0000', '0000-00-00', '2017-11-09', '2017-11-09 13:59:49', '2017-11-09 14:00:11', '2017-11-09 06:00:11', 1, 1, 1, b'0', b'1', b'1', b'0', 0, 1, 0, 'ma'),
(22, 'DR-20171109-22', 2, '', 1, 3, 'Contact Person', 0, 1, 0, 0, '', '1848.0000', '35.00', '277.2000', '514.8000', '2533.9300', '106.0700', '792.0000', '0000-00-00', '2017-11-09', '2017-11-09 14:01:23', '0000-00-00 00:00:00', '2017-11-09 06:01:42', 1, 0, 1, b'0', b'1', b'0', b'0', 0, 1, 0, 'ma'),
(23, 'DR-20171109-23', 2, '', 1, 3, 'Contact Person', 0, 1, 0, 0, '', '336.0000', '0.00', '0.0000', '144.0000', '460.7100', '19.2900', '144.0000', '0000-00-00', '2017-11-09', '2017-11-09 14:02:33', '0000-00-00 00:00:00', '2017-11-09 06:02:33', 1, 0, 0, b'0', b'1', b'0', b'0', 0, 1, 0, 'ma'),
(24, 'DR-20171109-24', 2, '', 1, 3, 'Contact Person', 0, 1, 0, 0, '', '0.0000', '0.00', '0.0000', '720.0000', '691.0700', '28.9300', '720.0000', '0000-00-00', '2017-11-09', '2017-11-09 14:02:59', '0000-00-00 00:00:00', '2017-11-09 06:02:59', 1, 0, 0, b'0', b'1', b'0', b'0', 0, 1, 0, 'ma');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_receipt_items`
--

CREATE TABLE `delivery_receipt_items` (
  `delivery_receipt_item_id` bigint(20) NOT NULL,
  `delivery_receipt_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,0) DEFAULT '0',
  `inv_gross` decimal(20,4) NOT NULL,
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) NOT NULL,
  `inv_notes` varchar(100) DEFAULT NULL,
  `sales_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_receipt_items`
--

INSERT INTO `delivery_receipt_items` (`delivery_receipt_item_id`, `delivery_receipt_id`, `product_id`, `unit_id`, `inv_price`, `orig_so_price`, `inv_discount`, `inv_line_total_discount`, `inv_tax_rate`, `cost_upon_invoice`, `inv_qty`, `inv_gross`, `inv_line_total_price`, `inv_tax_amount`, `inv_non_tax_amount`, `inv_line_total_after_global`, `inv_notes`, `sales_invoice_id`, `exp_date`, `batch_no`) VALUES
(1, 1, 1, 2, '90.0000', '0.0000', '0.0000', '0.0000', '12.0000', '0.0000', '5', '450.0000', '450.0000', '48.2143', '401.7857', '450.0000', NULL, NULL, '0000-00-00', ''),
(2, 1, 2, 1, '150.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '2', '300.0000', '300.0000', '0.0000', '300.0000', '300.0000', NULL, NULL, '0000-00-00', ''),
(3, 2, 1, 2, '90.0000', '0.0000', '10.0000', '90.0000', '12.0000', '0.0000', '10', '900.0000', '810.0000', '96.4300', '803.5700', '729.0000', NULL, 1, '0000-00-00', ''),
(4, 2, 2, 1, '150.0000', '0.0000', '10.0000', '150.0000', '0.0000', '0.0000', '10', '1500.0000', '1350.0000', '0.0000', '1500.0000', '1215.0000', NULL, 0, '0000-00-00', ''),
(5, 3, 1, 2, '90.0000', '0.0000', '10.0000', '90.0000', '12.0000', '0.0000', '10', '900.0000', '810.0000', '96.4300', '803.5700', '729.0000', NULL, 1, '0000-00-00', ''),
(6, 3, 2, 1, '150.0000', '0.0000', '10.0000', '150.0000', '0.0000', '0.0000', '10', '1500.0000', '1350.0000', '0.0000', '1500.0000', '1215.0000', NULL, 0, '0000-00-00', ''),
(7, 4, 1, 2, '90.0000', '0.0000', '10.0000', '90.0000', '12.0000', '0.0000', '10', '900.0000', '810.0000', '96.4300', '803.5700', '729.0000', NULL, 1, '0000-00-00', ''),
(8, 4, 2, 1, '150.0000', '0.0000', '10.0000', '150.0000', '0.0000', '0.0000', '10', '1500.0000', '1350.0000', '0.0000', '1500.0000', '1215.0000', NULL, 0, '0000-00-00', ''),
(9, 5, 1, 2, '90.0000', '0.0000', '10.0000', '90.0000', '12.0000', '0.0000', '10', '900.0000', '810.0000', '96.4300', '803.5700', '729.0000', NULL, 1, '0000-00-00', ''),
(10, 5, 2, 1, '150.0000', '0.0000', '10.0000', '150.0000', '0.0000', '0.0000', '10', '1500.0000', '1350.0000', '0.0000', '1500.0000', '1215.0000', NULL, 0, '0000-00-00', ''),
(11, 6, 1, 2, '90.0000', '0.0000', '10.0000', '90.0000', '12.0000', '0.0000', '10', '900.0000', '810.0000', '96.4300', '803.5700', '729.0000', NULL, 1, '0000-00-00', ''),
(12, 6, 2, 1, '150.0000', '0.0000', '10.0000', '150.0000', '0.0000', '0.0000', '10', '1500.0000', '1350.0000', '0.0000', '1500.0000', '1215.0000', NULL, 1, '0000-00-00', ''),
(13, 7, 1, 2, '90.0000', '0.0000', '10.0000', '45.0000', '12.0000', '0.0000', '5', '450.0000', '405.0000', '48.2143', '401.7857', '364.5000', NULL, 1, '0000-00-00', ''),
(14, 7, 2, 1, '150.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '5', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, 1, '0000-00-00', ''),
(15, 8, 1, 2, '90.0000', '0.0000', '10.0000', '45.0000', '12.0000', '0.0000', '5', '450.0000', '405.0000', '48.2100', '401.7900', '364.5000', NULL, 1, '0000-00-00', ''),
(16, 8, 2, 1, '150.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '5', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, 1, '0000-00-00', ''),
(17, 9, 1, 2, '90.0000', '0.0000', '10.0000', '45.0000', '12.0000', '0.0000', '5', '450.0000', '405.0000', '48.2100', '401.7900', '364.5000', NULL, 1, '0000-00-00', ''),
(18, 9, 2, 1, '150.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '5', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, 1, '0000-00-00', ''),
(19, 10, 1, 2, '90.0000', '0.0000', '10.0000', '45.0000', '12.0000', '0.0000', '5', '450.0000', '405.0000', '48.2100', '401.7900', '364.5000', NULL, 1, '0000-00-00', ''),
(20, 10, 2, 1, '150.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '5', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, 1, '0000-00-00', ''),
(21, 11, 1, 2, '90.0000', '0.0000', '10.0000', '45.0000', '12.0000', '0.0000', '5', '450.0000', '405.0000', '48.2143', '401.7857', '364.5000', NULL, 1, '0000-00-00', ''),
(22, 11, 2, 1, '150.0000', '0.0000', '10.0000', '150.0000', '0.0000', '0.0000', '10', '1500.0000', '1350.0000', '0.0000', '1500.0000', '1215.0000', NULL, 1, '0000-00-00', ''),
(26, 12, 1, 2, '90.0000', '0.0000', '10.0000', '18.0000', '12.0000', '0.0000', '2', '180.0000', '162.0000', '19.2857', '160.7143', '162.0000', NULL, NULL, '0000-00-00', ''),
(29, 13, 1, 2, '90.0000', '0.0000', '10.0000', '18.0000', '12.0000', '0.0000', '2', '180.0000', '162.0000', '19.2857', '160.7143', '145.8000', NULL, NULL, '0000-00-00', ''),
(30, 13, 2, 1, '150.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '5', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, NULL, '0000-00-00', ''),
(31, 14, 1, 2, '90.0000', '0.0000', '10.0000', '90.0000', '12.0000', '0.0000', '10', '900.0000', '810.0000', '96.4300', '803.5700', '729.0000', NULL, 1, '0000-00-00', ''),
(32, 14, 2, 1, '150.0000', '0.0000', '10.0000', '150.0000', '0.0000', '0.0000', '10', '1500.0000', '1350.0000', '0.0000', '1500.0000', '1215.0000', NULL, 1, '0000-00-00', ''),
(35, 16, 1, 2, '90.0000', '0.0000', '10.0000', '45.0000', '12.0000', '0.0000', '5', '450.0000', '405.0000', '48.2100', '401.7900', '364.5000', NULL, 1, '0000-00-00', ''),
(44, 15, 1, 2, '90.0000', '0.0000', '10.0000', '63.0000', '12.0000', '0.0000', '7', '630.0000', '567.0000', '67.5000', '562.5000', '510.3000', NULL, 1, '0000-00-00', ''),
(45, 15, 2, 1, '150.0000', '0.0000', '10.0000', '150.0000', '0.0000', '0.0000', '10', '1500.0000', '1350.0000', '0.0000', '1500.0000', '1215.0000', NULL, 1, '0000-00-00', ''),
(46, 17, 1, 2, '90.0000', '0.0000', '10.0000', '27.0000', '12.0000', '0.0000', '3', '270.0000', '243.0000', '28.9300', '241.0700', '218.7000', NULL, 1, '0000-00-00', ''),
(49, 18, 1, 2, '90.0000', '0.0000', '10.0000', '45.0000', '12.0000', '0.0000', '5', '450.0000', '405.0000', '48.2143', '401.7857', '405.0000', NULL, 1, '0000-00-00', ''),
(50, 18, 2, 1, '150.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '5', '750.0000', '675.0000', '0.0000', '750.0000', '675.0000', NULL, 1, '0000-00-00', ''),
(51, 19, 1, 2, '90.0000', '0.0000', '10.0000', '90.0000', '12.0000', '0.0000', '10', '900.0000', '810.0000', '96.4300', '803.5700', '729.0000', NULL, 1, '0000-00-00', ''),
(52, 19, 2, 1, '150.0000', '0.0000', '10.0000', '150.0000', '0.0000', '0.0000', '10', '1500.0000', '1350.0000', '0.0000', '1500.0000', '1215.0000', NULL, 1, '0000-00-00', ''),
(55, 20, 1, 2, '90.0000', '0.0000', '10.0000', '45.0000', '12.0000', '0.0000', '5', '450.0000', '405.0000', '48.2143', '401.7857', '364.5000', NULL, 1, '0000-00-00', ''),
(56, 20, 2, 1, '150.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '5', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, 1, '0000-00-00', ''),
(59, 21, 1, 2, '90.0000', '0.0000', '70.0000', '1008.0000', '12.0000', '0.0000', '16', '1440.0000', '432.0000', '154.2857', '1285.7143', '280.8000', NULL, 2, '0000-00-00', ''),
(60, 21, 2, 1, '150.0000', '0.0000', '70.0000', '1680.0000', '0.0000', '0.0000', '16', '2400.0000', '720.0000', '0.0000', '2400.0000', '468.0000', NULL, 2, '0000-00-00', ''),
(63, 22, 1, 2, '90.0000', '0.0000', '70.0000', '693.0000', '12.0000', '0.0000', '11', '990.0000', '297.0000', '106.0714', '883.9286', '193.0500', NULL, 2, '0000-00-00', ''),
(64, 22, 2, 1, '150.0000', '0.0000', '70.0000', '1155.0000', '0.0000', '0.0000', '11', '1650.0000', '495.0000', '0.0000', '1650.0000', '321.7500', NULL, 2, '0000-00-00', ''),
(65, 23, 1, 2, '90.0000', '0.0000', '70.0000', '126.0000', '12.0000', '0.0000', '2', '180.0000', '54.0000', '19.2857', '160.7143', '54.0000', NULL, 2, '0000-00-00', ''),
(66, 23, 2, 1, '150.0000', '0.0000', '70.0000', '210.0000', '0.0000', '0.0000', '2', '300.0000', '90.0000', '0.0000', '300.0000', '90.0000', NULL, 2, '0000-00-00', ''),
(67, 24, 1, 2, '90.0000', '0.0000', '0.0000', '0.0000', '12.0000', '0.0000', '3', '270.0000', '270.0000', '28.9286', '241.0714', '270.0000', NULL, 2, '0000-00-00', ''),
(68, 24, 2, 1, '150.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '3', '450.0000', '450.0000', '0.0000', '450.0000', '450.0000', NULL, 2, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` bigint(20) NOT NULL,
  `department_code` varchar(20) DEFAULT '',
  `department_name` varchar(255) DEFAULT '',
  `department_desc` varchar(255) DEFAULT '',
  `delivery_address` varchar(755) DEFAULT '',
  `default_cost` tinyint(4) DEFAULT '1' COMMENT '1=Purchase Cost 1, 2=Purchase Cost 2',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_code`, `department_name`, `department_desc`, `delivery_address`, `default_cost`, `date_created`, `date_modified`, `is_deleted`, `is_active`) VALUES
(1, '', 'Admin', '', '', 1, '2017-12-27 15:04:39', '0000-00-00 00:00:00', b'0', b'1'),
(2, '', 'Kitchen', '', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', b'0', b'1'),
(3, '', 'Bar', '', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', b'0', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `depreciation_expense`
--

CREATE TABLE `depreciation_expense` (
  `de_id` bigint(20) NOT NULL,
  `de_date` date NOT NULL,
  `de_expense_total` decimal(20,4) NOT NULL,
  `de_remarks` text NOT NULL,
  `de_ref_no` varchar(75) NOT NULL,
  `date_posted` date NOT NULL,
  `is_active` bit(1) NOT NULL DEFAULT b'1',
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `is_journal_posted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_id` bigint(100) NOT NULL,
  `discount_code` bigint(100) DEFAULT NULL,
  `discount_type` varchar(200) DEFAULT NULL,
  `discount_desc` varchar(200) DEFAULT NULL,
  `discount_percent` bigint(100) DEFAULT NULL,
  `discount_amount` bigint(100) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

CREATE TABLE `email_settings` (
  `email_id` int(11) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email_from` varchar(150) NOT NULL,
  `name_from` varchar(50) NOT NULL,
  `default_message` varchar(500) NOT NULL,
  `email_to` varchar(175) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_settings`
--

INSERT INTO `email_settings` (`email_id`, `email_address`, `password`, `email_from`, `name_from`, `default_message`, `email_to`) VALUES
(1, 'manaloraf03@gmail.com', 'xxseunghyunk216', '', 'ENVY BISTRO  SPORTS SUITES INC', 'Invoices', NULL),
(2, 'manaloraf03@gmail.com', 'xxseunghyunk216', '', 'ENVY BISTRO  SPORTS SUITES INC', 'This is a system generation report sent to you from the Accounting System of Envy Bistro Bar And Hotel.', 'manaloraf03@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `fixed_assets`
--

CREATE TABLE `fixed_assets` (
  `fixed_asset_id` bigint(20) NOT NULL,
  `asset_code` varchar(55) DEFAULT '',
  `asset_description` varchar(555) DEFAULT '',
  `serial_no` varchar(155) DEFAULT '',
  `location_id` int(11) DEFAULT '0',
  `department_id` int(11) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  `acquisition_cost` decimal(20,4) DEFAULT '0.0000',
  `salvage_value` decimal(20,4) DEFAULT '0.0000',
  `life_years` int(11) DEFAULT '0',
  `asset_status_id` int(11) DEFAULT '0',
  `date_acquired` date DEFAULT '0000-00-00',
  `remarks` varchar(1000) DEFAULT NULL,
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fixed_assets`
--

INSERT INTO `fixed_assets` (`fixed_asset_id`, `asset_code`, `asset_description`, `serial_no`, `location_id`, `department_id`, `category_id`, `acquisition_cost`, `salvage_value`, `life_years`, `asset_status_id`, `date_acquired`, `remarks`, `date_posted`, `posted_by_user`, `date_modified`, `modified_by_user`, `date_deleted`, `deleted_by_user`, `is_deleted`, `is_active`) VALUES
(1, '1', '1', '1', 1, 2, 1, '1000.0000', '0.0000', 1, 1, '2017-09-27', '', '2017-09-27 13:36:01', 1, '2017-09-27 13:43:12', 1, '2017-09-27 14:02:43', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `generics`
--

CREATE TABLE `generics` (
  `generic_id` bigint(20) NOT NULL,
  `generic_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `giftcards`
--

CREATE TABLE `giftcards` (
  `giftcard_id` bigint(20) NOT NULL,
  `giftcard_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_integration`
--

CREATE TABLE `hotel_integration` (
  `hotel_integration_id` int(11) NOT NULL,
  `income_rs` bigint(20) DEFAULT NULL COMMENT 'Income - Room Sales',
  `income_bs` bigint(20) DEFAULT NULL COMMENT 'Income - Bar Sales',
  `income_os` bigint(20) DEFAULT NULL COMMENT 'Income - Other Sales',
  `liability_apd` bigint(20) DEFAULT NULL COMMENT 'Liability - Advance Payment Deposit',
  `liability_sd` bigint(20) DEFAULT NULL COMMENT 'Liability -  Security Deposit',
  `liability_ud` bigint(20) DEFAULT NULL COMMENT 'Liability -  Utility Deposit',
  `asset_cash` bigint(20) DEFAULT NULL,
  `asset_check` bigint(20) DEFAULT NULL,
  `asset_card` bigint(20) DEFAULT NULL,
  `asset_charge` bigint(20) DEFAULT NULL,
  `withhold_tax` bigint(20) DEFAULT NULL,
  `department_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel_integration`
--

INSERT INTO `hotel_integration` (`hotel_integration_id`, `income_rs`, `income_bs`, `income_os`, `liability_apd`, `liability_sd`, `liability_ud`, `asset_cash`, `asset_check`, `asset_card`, `asset_charge`, `withhold_tax`, `department_id`) VALUES
(1, 62, 61, 63, NULL, NULL, NULL, 8, 59, 60, 9, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_integration_items`
--

CREATE TABLE `hotel_integration_items` (
  `hotel_integration_items_id` bigint(20) NOT NULL,
  `item_type` varchar(50) DEFAULT NULL,
  `guest_id` bigint(20) DEFAULT '0',
  `guest_name` varchar(175) DEFAULT NULL,
  `sales_date` datetime NOT NULL,
  `cash_amount` decimal(20,5) DEFAULT '0.00000',
  `check_amount` decimal(20,5) DEFAULT '0.00000',
  `card_amount` decimal(20,5) DEFAULT '0.00000',
  `charge_amount` decimal(20,5) DEFAULT '0.00000',
  `advance_amount` decimal(20,5) DEFAULT '0.00000',
  `security_amount` decimal(20,5) DEFAULT '0.00000',
  `room_sales` decimal(20,5) DEFAULT '0.00000',
  `bar_sales` decimal(20,5) DEFAULT '0.00000',
  `other_sales` decimal(20,5) DEFAULT '0.00000',
  `ref_no` varchar(175) DEFAULT NULL,
  `ar_guest_id` bigint(20) DEFAULT NULL,
  `ar_guest_name` varchar(255) DEFAULT NULL,
  `is_posted` bit(1) DEFAULT b'0',
  `posted_by` bigint(20) DEFAULT '0',
  `posted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_counter`
--

CREATE TABLE `invoice_counter` (
  `counter_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `counter_start` bigint(20) DEFAULT '0',
  `counter_end` bigint(20) DEFAULT '0',
  `last_invoice` bigint(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `issuance_info`
--

CREATE TABLE `issuance_info` (
  `issuance_id` bigint(20) NOT NULL,
  `slip_no` varchar(75) DEFAULT '',
  `issued_department_id` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `issued_to_person` varchar(155) DEFAULT '',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `date_issued` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `customer_id` int(11) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `terms` varchar(50) DEFAULT NULL,
  `is_for_pos` bit(1) DEFAULT b'0',
  `is_received` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issuance_info`
--

INSERT INTO `issuance_info` (`issuance_id`, `slip_no`, `issued_department_id`, `remarks`, `issued_to_person`, `total_discount`, `total_before_tax`, `total_tax_amount`, `total_after_tax`, `date_issued`, `date_created`, `date_modified`, `date_deleted`, `modified_by_user`, `posted_by_user`, `deleted_by_user`, `is_active`, `is_deleted`, `customer_id`, `address`, `terms`, `is_for_pos`, `is_received`) VALUES
(1, 'SLP-20180105-1', 1, '', '', '0.00', '0.00', '0.00', '0.00', '2018-01-05', '2018-01-05 16:29:51', '2018-01-05 08:30:33', '0000-00-00 00:00:00', 0, 1, 0, b'1', b'0', NULL, NULL, ' ', b'1', b'1'),
(2, 'SLP-20180105-2', 1, '', '', '0.00', '0.00', '0.00', '0.00', '2018-01-05', '2018-01-05 16:34:29', '2018-01-05 08:39:10', '0000-00-00 00:00:00', 0, 1, 0, b'1', b'0', NULL, NULL, '1', b'1', b'1'),
(3, 'SLP-20180105-3', 2, '', '', '0.00', '0.00', '0.00', '0.00', '2018-01-05', '2018-01-05 17:02:14', '2018-01-09 01:26:10', '0000-00-00 00:00:00', 0, 1, 0, b'1', b'0', NULL, NULL, ' ', b'1', b'1'),
(4, 'SLP-20180105-4', 3, '', '', '0.00', '0.00', '0.00', '0.00', '2018-01-05', '2018-01-05 17:06:42', '2018-01-05 09:07:57', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0', NULL, NULL, '  ', b'1', b'1'),
(5, 'SLP-20180109-5', 2, '', '', '0.00', '0.00', '0.00', '0.00', '2018-01-09', '2018-01-09 09:36:32', '2018-01-09 01:45:00', '0000-00-00 00:00:00', 0, 1, 0, b'1', b'0', NULL, NULL, '12', b'1', b'1'),
(6, 'SLP-20180109-6', 1, '', '', '0.00', '0.00', '0.00', '0.00', '2018-01-09', '2018-01-09 09:36:46', '2018-01-09 01:36:47', '0000-00-00 00:00:00', 0, 1, 0, b'1', b'0', NULL, NULL, '30', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `issuance_items`
--

CREATE TABLE `issuance_items` (
  `issuance_item_id` bigint(20) NOT NULL,
  `issuance_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `issue_qty` decimal(20,2) DEFAULT '0.00',
  `issue_price` decimal(20,2) DEFAULT '0.00',
  `issue_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_rate` decimal(11,2) DEFAULT '0.00',
  `issue_line_total_price` decimal(20,2) DEFAULT '0.00',
  `issue_line_total_discount` decimal(20,2) DEFAULT '0.00',
  `issue_tax_amount` decimal(20,2) DEFAULT '0.00',
  `issue_non_tax_amount` decimal(20,2) DEFAULT '0.00',
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issuance_items`
--

INSERT INTO `issuance_items` (`issuance_item_id`, `issuance_id`, `product_id`, `unit_id`, `issue_qty`, `issue_price`, `issue_discount`, `issue_tax_rate`, `issue_line_total_price`, `issue_line_total_discount`, `issue_tax_amount`, `issue_non_tax_amount`, `dr_invoice_id`, `exp_date`, `batch_no`) VALUES
(1, 1, 1, 1, '0.00', '100.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '0000-00-00', ''),
(2, 2, 2, 1, '0.00', '100.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '0000-00-00', ''),
(3, 3, 3, 2, '10.00', '75.00', '0.00', '0.00', '750.00', '0.00', '0.00', '750.00', 0, '0000-00-00', ''),
(4, 4, 4, 1, '100.00', '20.00', '0.00', '0.00', '2000.00', '0.00', '0.00', '2000.00', 0, '0000-00-00', ''),
(5, 5, 4, 1, '0.00', '100.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '0000-00-00', ''),
(6, 5, 1, 1, '0.00', '100.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '0000-00-00', ''),
(7, 6, 2, 1, '0.00', '100.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE `item_types` (
  `item_type_id` int(11) NOT NULL,
  `item_type_code` varchar(20) DEFAULT NULL,
  `item_type` varchar(255) DEFAULT '',
  `description` varchar(1000) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_types`
--

INSERT INTO `item_types` (`item_type_id`, `item_type_code`, `item_type`, `description`, `is_active`, `is_deleted`) VALUES
(1, 'IP', 'Inventory', '', b'1', b'0'),
(2, 'NP', 'Non-inventory', '', b'1', b'0'),
(3, 'CP', 'Consigned', '', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `journal_accounts`
--

CREATE TABLE `journal_accounts` (
  `journal_account_id` bigint(20) NOT NULL,
  `journal_id` bigint(20) DEFAULT '0',
  `account_id` int(11) DEFAULT '0',
  `memo` varchar(700) DEFAULT '',
  `dr_amount` decimal(25,2) DEFAULT '0.00',
  `cr_amount` decimal(25,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `journal_entry_templates`
--

CREATE TABLE `journal_entry_templates` (
  `entry_template_id` bigint(20) NOT NULL,
  `template_id` bigint(20) DEFAULT '0',
  `account_id` bigint(20) DEFAULT '0',
  `memo` varchar(1000) DEFAULT '',
  `dr_amount` decimal(20,4) DEFAULT '0.0000',
  `cr_amount` decimal(20,4) DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `journal_info`
--

CREATE TABLE `journal_info` (
  `journal_id` bigint(20) NOT NULL,
  `txn_no` varchar(55) DEFAULT '',
  `department_id` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `supplier_id` int(11) DEFAULT '0',
  `remarks` varchar(555) DEFAULT '',
  `book_type` varchar(20) DEFAULT '',
  `date_txn` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by_user` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_by_user` int(11) DEFAULT '0',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `cancelled_by_user` int(11) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `payment_method_id` int(11) DEFAULT '0',
  `bank` varchar(10) DEFAULT '',
  `check_no` varchar(20) DEFAULT '',
  `check_date` date DEFAULT '0000-00-00',
  `ref_type` varchar(4) DEFAULT '',
  `ref_no` varchar(25) DEFAULT '',
  `amount` decimal(10,2) DEFAULT '0.00',
  `or_no` varchar(50) DEFAULT '',
  `check_status` tinyint(4) DEFAULT '0',
  `accounting_period_id` bigint(20) DEFAULT '0',
  `is_replenished` tinyint(1) DEFAULT '0',
  `batch_id` int(11) DEFAULT '0',
  `bank_id` int(11) DEFAULT '0',
  `is_reconciled` tinyint(4) DEFAULT '0',
  `is_sales` tinyint(4) DEFAULT '0',
  `pos_integration_id` bigint(20) DEFAULT '0',
  `hotel_integration_id` bigint(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `journal_templates_info`
--

CREATE TABLE `journal_templates_info` (
  `template_id` bigint(20) NOT NULL,
  `template_code` varchar(155) DEFAULT '',
  `payee` varchar(1000) DEFAULT '',
  `template_description` varchar(1000) DEFAULT '',
  `supplier_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  `method_id` bigint(20) DEFAULT '0',
  `amount` decimal(20,4) DEFAULT '0.0000',
  `remarks` varchar(1000) DEFAULT '',
  `posted_by` int(11) DEFAULT NULL,
  `book_type` varchar(5) DEFAULT '',
  `is_active` tinyint(1) DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` bigint(20) NOT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` int(11) DEFAULT NULL,
  `date_posted` datetime DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `module_layout`
--

CREATE TABLE `module_layout` (
  `module_layout_id` int(11) NOT NULL,
  `layout_id` int(11) DEFAULT '0',
  `display_text` varchar(100) DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `pos_top` decimal(10,0) DEFAULT NULL,
  `pos_bottom` decimal(10,0) DEFAULT NULL,
  `pos_left` decimal(10,0) DEFAULT NULL,
  `pos_right` decimal(10,0) DEFAULT NULL,
  `font` varchar(100) DEFAULT NULL,
  `font_color` varchar(45) DEFAULT NULL,
  `font_size` decimal(10,0) DEFAULT NULL,
  `is_bold` varchar(120) DEFAULT '0',
  `is_italic` varchar(120) DEFAULT '0',
  `height` decimal(10,0) DEFAULT NULL,
  `width` decimal(10,0) DEFAULT NULL,
  `tag` varchar(45) DEFAULT NULL,
  `parent` varchar(50) DEFAULT 'header'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `order_status_id` int(11) NOT NULL,
  `order_status` varchar(75) DEFAULT '',
  `order_description` varchar(555) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`order_status_id`, `order_status`, `order_description`, `is_active`, `is_deleted`) VALUES
(1, 'Open', '', b'1', b'0'),
(2, 'Closed', '', b'1', b'0'),
(3, 'Partially received', '', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `other_sales_invoice`
--

CREATE TABLE `other_sales_invoice` (
  `sales_invoice_id` bigint(20) NOT NULL,
  `sales_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `department_id` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `other_sales_invoice_items`
--

CREATE TABLE `other_sales_invoice_items` (
  `sales_item_id` bigint(20) NOT NULL,
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `inv_price` decimal(20,2) DEFAULT '0.00',
  `inv_discount` decimal(20,2) DEFAULT '0.00',
  `inv_line_total_discount` decimal(20,2) DEFAULT '0.00',
  `inv_tax_rate` decimal(20,2) DEFAULT '0.00',
  `inv_qty` decimal(20,0) DEFAULT '0',
  `inv_line_total_price` decimal(20,2) DEFAULT '0.00',
  `inv_tax_amount` decimal(20,2) DEFAULT '0.00',
  `inv_non_tax_amount` decimal(20,2) DEFAULT '0.00',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payable_payments`
--

CREATE TABLE `payable_payments` (
  `payment_id` bigint(20) NOT NULL,
  `receipt_no` varchar(75) DEFAULT '',
  `supplier_id` bigint(20) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `receipt_type` varchar(55) DEFAULT '',
  `department_id` bigint(20) DEFAULT '0',
  `payment_method_id` int(11) DEFAULT '0',
  `check_date_type` tinyint(4) DEFAULT '1' COMMENT '1 is Date, 2 is PDC',
  `check_date` date DEFAULT '0000-00-00',
  `check_no` varchar(100) DEFAULT '',
  `remarks` varchar(755) DEFAULT '',
  `total_paid_amount` decimal(20,2) DEFAULT '0.00',
  `date_paid` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `cancelled_by_user` int(11) DEFAULT '0',
  `created_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_posted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payable_payments_list`
--

CREATE TABLE `payable_payments_list` (
  `payment_list_id` bigint(20) NOT NULL,
  `payment_id` bigint(20) DEFAULT '0',
  `dr_invoice_id` bigint(20) DEFAULT '0',
  `payable_amount` decimal(20,2) DEFAULT '0.00',
  `payment_amount` decimal(20,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `payment_method_id` int(11) NOT NULL,
  `payment_method` varchar(100) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`payment_method_id`, `payment_method`, `is_active`, `is_deleted`) VALUES
(1, 'Cash', b'1', b'0'),
(2, 'Check', b'1', b'0'),
(3, 'Card', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `pos_integration`
--

CREATE TABLE `pos_integration` (
  `pos_integration_id` bigint(20) NOT NULL,
  `asset_cash` bigint(20) DEFAULT '0',
  `asset_card` bigint(20) DEFAULT '0',
  `asset_check` bigint(20) DEFAULT '0',
  `asset_gc` bigint(20) DEFAULT '0',
  `income_sales` bigint(20) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  `customer_id` bigint(20) DEFAULT '0',
  `tax` bigint(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos_integration`
--

INSERT INTO `pos_integration` (`pos_integration_id`, `asset_cash`, `asset_card`, `asset_check`, `asset_gc`, `income_sales`, `department_id`, `customer_id`, `tax`) VALUES
(1, 3, 60, 59, 3, 17, 1, 1, 34);

-- --------------------------------------------------------

--
-- Table structure for table `pos_integration_items`
--

CREATE TABLE `pos_integration_items` (
  `pos_integration_items_id` bigint(20) NOT NULL,
  `sales_date` datetime DEFAULT NULL,
  `cashier` varchar(255) DEFAULT NULL,
  `cash_amount` decimal(20,5) DEFAULT '0.00000',
  `card_amount` decimal(20,5) DEFAULT '0.00000',
  `check_amount` decimal(20,5) DEFAULT '0.00000',
  `gc_amount` decimal(20,5) DEFAULT '0.00000',
  `tax_amount` decimal(20,5) DEFAULT '0.00000',
  `total` decimal(20,5) DEFAULT '0.00000',
  `ref_no` varchar(255) DEFAULT NULL,
  `is_posted` bit(1) DEFAULT b'0',
  `posted_by` bit(1) DEFAULT b'0',
  `posted_date` datetime DEFAULT NULL,
  `journal_id` bigint(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos_integration_items`
--

INSERT INTO `pos_integration_items` (`pos_integration_items_id`, `sales_date`, `cashier`, `cash_amount`, `card_amount`, `check_amount`, `gc_amount`, `tax_amount`, `total`, `ref_no`, `is_posted`, `posted_by`, `posted_date`, `journal_id`) VALUES
(1, '2017-12-19 12:02:17', 'Admin', '5510.00000', '0.00000', '0.00000', '0.00000', '590.35714', '5510.00000', '7', b'0', b'0', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `po_attachments`
--

CREATE TABLE `po_attachments` (
  `po_attachment_id` bigint(20) NOT NULL,
  `purchase_order_id` bigint(20) DEFAULT '0',
  `orig_file_name` varchar(255) DEFAULT '',
  `server_file_directory` varchar(800) DEFAULT '',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by_user` int(11) DEFAULT '0',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `po_messages`
--

CREATE TABLE `po_messages` (
  `po_message_id` bigint(20) NOT NULL,
  `purchase_order_id` bigint(20) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `message` text,
  `date_posted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `po_messages`
--

INSERT INTO `po_messages` (`po_message_id`, `purchase_order_id`, `user_id`, `message`, `date_posted`, `date_deleted`, `is_deleted`) VALUES
(1, 11, 1, 'raf', '2017-07-11 10:55:41', '0000-00-00 00:00:00', b'0'),
(2, 1, 1, 'asdsd', '2017-08-09 13:39:14', '0000-00-00 00:00:00', b'0'),
(3, 3, 1, 'hey', '2018-01-09 12:25:32', '0000-00-00 00:00:00', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `print_layout`
--

CREATE TABLE `print_layout` (
  `layout_id` int(11) NOT NULL,
  `layout_name` varchar(755) NOT NULL,
  `layout_description` varchar(1000) DEFAULT NULL,
  `is_portrait` bit(1) NOT NULL DEFAULT b'1',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint(20) NOT NULL,
  `product_code` varchar(255) DEFAULT '',
  `product_desc` varchar(255) DEFAULT '',
  `product_desc1` varchar(255) DEFAULT '',
  `unit` varchar(255) DEFAULT '',
  `size` varchar(255) DEFAULT '',
  `supplier_id` bigint(20) DEFAULT '0',
  `tax_type_id` bigint(20) DEFAULT '0',
  `refproduct_id` int(10) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  `department_id` int(11) DEFAULT '2' COMMENT '1 - Hotel , 2 -  POS',
  `unit_id` int(11) DEFAULT '0',
  `equivalent_points` decimal(20,2) DEFAULT '0.00',
  `product_warn` decimal(16,2) DEFAULT '0.00',
  `product_ideal` decimal(16,2) DEFAULT '0.00',
  `purchase_cost` decimal(20,4) DEFAULT '0.0000',
  `purchase_cost_2` decimal(20,4) DEFAULT '0.0000',
  `markup_percent` decimal(16,4) DEFAULT '0.0000',
  `sale_price` decimal(16,4) DEFAULT '0.0000',
  `whole_sale` decimal(16,4) DEFAULT '0.0000',
  `retailer_price` decimal(16,4) DEFAULT '0.0000',
  `special_disc` decimal(16,4) DEFAULT '0.0000',
  `discounted_price` decimal(16,4) DEFAULT '0.0000',
  `dealer_price` decimal(16,4) DEFAULT '0.0000',
  `distributor_price` decimal(16,4) DEFAULT '0.0000',
  `public_price` decimal(16,4) DEFAULT '0.0000',
  `valued_customer` decimal(16,4) DEFAULT '0.0000',
  `income_account_id` bigint(20) DEFAULT '0',
  `expense_account_id` bigint(20) DEFAULT '0',
  `on_hand` decimal(20,2) DEFAULT '0.00',
  `item_type_id` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_inventory` bit(1) DEFAULT b'1',
  `is_tax_exempt` bit(1) DEFAULT b'0',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `pos_item_cost` decimal(20,4) DEFAULT '0.0000',
  `pos_item_rate` decimal(20,4) DEFAULT '0.0000',
  `section_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `item_backcolor` varchar(100) DEFAULT '-1',
  `item_forecolor` varchar(100) DEFAULT '-16777216',
  `pos_is_manual_pricing` bit(1) DEFAULT b'0',
  `pos_is_salable` bit(1) DEFAULT b'0',
  `pos_is_vatable` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_code`, `product_desc`, `product_desc1`, `unit`, `size`, `supplier_id`, `tax_type_id`, `refproduct_id`, `category_id`, `department_id`, `unit_id`, `equivalent_points`, `product_warn`, `product_ideal`, `purchase_cost`, `purchase_cost_2`, `markup_percent`, `sale_price`, `whole_sale`, `retailer_price`, `special_disc`, `discounted_price`, `dealer_price`, `distributor_price`, `public_price`, `valued_customer`, `income_account_id`, `expense_account_id`, `on_hand`, `item_type_id`, `date_created`, `date_modified`, `date_deleted`, `created_by_user`, `modified_by_user`, `deleted_by_user`, `is_inventory`, `is_tax_exempt`, `is_deleted`, `is_active`, `pos_item_cost`, `pos_item_rate`, `section_id`, `menu_id`, `item_backcolor`, `item_forecolor`, `pos_is_manual_pricing`, `pos_is_salable`, `pos_is_vatable`) VALUES
(1, '12342342211', 'Apple Pie', 'Apple Pie', '', NULL, 1, 1, NULL, 1, 2, 1, '0.00', '15.00', '50.00', '100.0000', '0.0000', '0.0000', '100.0000', '0.0000', '0.0000', '0.0000', '100.0000', '100.0000', '0.0000', '0.0000', '0.0000', 17, 64, '0.00', 2, '2018-01-05 16:29:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0', b'0', b'1', '75.0000', '75.0000', 0, 2, '-1', '-16777216', b'0', b'1', b'1'),
(2, '2090', 'Cheesecake', 'Cheesecake', '', NULL, 1, 2, NULL, 1, 2, 1, '0.00', '15.00', '50.00', '100.0000', '0.0000', '0.0000', '100.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 17, 64, '0.00', 2, '2018-01-05 16:34:04', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0', b'0', b'1', '75.0000', '75.0000', 0, 28, '-1', '-16777216', b'0', b'1', b'1'),
(3, '120390 1', 'Thai Rice', 'Thai Rice', '', NULL, 1, 1, NULL, 2, 2, 2, '0.00', '50.00', '100.00', '50.0000', '0.0000', '0.0000', '50.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 17, 64, '40.00', 1, '2018-01-05 16:52:11', '2018-01-05 16:52:22', '0000-00-00 00:00:00', 1, 1, 0, b'1', b'0', b'0', b'1', '75.0000', '75.0000', 0, 2, '-1', '-16777216', b'0', b'0', b'0'),
(4, '21391829', 'SMB Beer', 'SMB Beer', '', NULL, 1, 2, NULL, 3, 2, 1, '0.00', '10.00', '100.00', '100.0000', '0.0000', '0.0000', '100.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 17, 64, '100.00', 1, '2018-01-05 17:04:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, b'1', b'0', b'0', b'1', '100.0000', '100.0000', 1, 2, '-1', '-16777216', b'0', b'1', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `product_batch_inventory`
--

CREATE TABLE `product_batch_inventory` (
  `product_key` varchar(100) NOT NULL,
  `product_id` bigint(20) DEFAULT '0',
  `batch_no` varchar(55) DEFAULT '',
  `exp_date` date DEFAULT '0000-00-00',
  `batch_exp_on_hand` decimal(20,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proforma_invoice`
--

CREATE TABLE `proforma_invoice` (
  `proforma_invoice_id` bigint(20) NOT NULL,
  `proforma_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `customer_name` varchar(175) NOT NULL,
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proforma_invoice`
--

INSERT INTO `proforma_invoice` (`proforma_invoice_id`, `proforma_inv_no`, `sales_order_id`, `sales_order_no`, `order_status_id`, `department_id`, `issue_to_department`, `customer_id`, `customer_name`, `journal_id`, `terms`, `remarks`, `total_discount`, `total_overall_discount`, `total_overall_discount_amount`, `total_after_discount`, `total_before_tax`, `total_tax_amount`, `total_after_tax`, `date_due`, `date_invoice`, `date_created`, `date_deleted`, `date_modified`, `posted_by_user`, `deleted_by_user`, `modified_by_user`, `is_paid`, `is_active`, `is_deleted`, `is_journal_posted`, `ref_product_type_id`, `inv_type`, `salesperson_id`, `address`, `contact_person`) VALUES
(5, 'PRO-INV-20171109-5', 0, '', 1, 2, NULL, 2, 'el', 0, 0, '1', '75.0000', '10.0000', '67.5000', '607.5000', '750.0000', '0.0000', '675.0000', '1970-01-01', '2017-11-09', '2017-11-09 17:24:07', '0000-00-00 00:00:00', '2017-11-10 07:15:01', 1, 0, 1, b'0', b'1', b'0', b'0', 0, 1, NULL, 'ma', '1'),
(6, 'PRO-INV-20171110-6', 0, '', 1, 2, NULL, 2, '', 0, 0, '', '400.0000', '10.0000', '360.0000', '3240.0000', '4000.0000', '0.0000', '3600.0000', '1970-01-01', '2017-11-10', '2017-11-10 09:46:32', '2017-11-10 10:29:13', '2017-11-10 02:29:13', 1, 1, 0, b'0', b'1', b'1', b'0', 0, 1, 0, 'ma', '12'),
(7, 'PRO-INV-20171110-7', 0, '', 1, 3, NULL, 1, '', 0, 0, '12122111', '400.0000', '0.0000', '0.0000', '5400.0000', '5800.0000', '0.0000', '5400.0000', '1970-01-01', '2017-11-10', '2017-11-10 09:51:30', '0000-00-00 00:00:00', '2017-11-10 02:50:35', 1, 0, 1, b'0', b'1', b'0', b'0', 0, 1, NULL, 'Adress', '1qwqw'),
(8, 'PRO-INV-20171110-8', 0, '', 1, NULL, NULL, NULL, '1', 0, 0, '', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1970-01-01', '2017-11-10', '2017-11-10 14:59:22', '0000-00-00 00:00:00', '2017-11-10 06:59:22', 1, 0, 0, b'0', b'1', b'0', b'0', 0, 1, 0, '', ''),
(9, 'PRO-INV-20171110-9', 0, '', 1, NULL, NULL, NULL, '1asdasdas', 0, 0, '', '0.0000', '0.0000', '0.0000', '750.0000', '750.0000', '0.0000', '750.0000', '1970-01-01', '2017-11-10', '2017-11-10 15:08:41', '0000-00-00 00:00:00', '2017-11-10 07:15:26', 1, 0, 1, b'0', b'1', b'0', b'0', 0, 1, NULL, 'asdas', ''),
(10, 'PRO-INV-20171110-10', 0, '', 1, NULL, NULL, NULL, 'Rafael Manalo', 0, 0, '', '0.0000', '0.0000', '0.0000', '90.0000', '80.3600', '9.6400', '90.0000', '1970-01-01', '2017-11-10', '2017-11-10 15:09:35', '0000-00-00 00:00:00', '2017-11-10 07:14:43', 1, 0, 1, b'0', b'1', b'0', b'0', 0, 1, NULL, 'Angeles City', '');

-- --------------------------------------------------------

--
-- Table structure for table `proforma_invoice_items`
--

CREATE TABLE `proforma_invoice_items` (
  `proforma_item_id` bigint(20) NOT NULL,
  `proforma_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,0) DEFAULT '0',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proforma_invoice_items`
--

INSERT INTO `proforma_invoice_items` (`proforma_item_id`, `proforma_invoice_id`, `product_id`, `unit_id`, `inv_price`, `orig_so_price`, `inv_discount`, `inv_line_total_discount`, `inv_tax_rate`, `cost_upon_invoice`, `inv_qty`, `inv_gross`, `inv_line_total_price`, `inv_tax_amount`, `inv_non_tax_amount`, `inv_line_total_after_global`, `inv_notes`, `dr_invoice_id`, `exp_date`, `batch_no`) VALUES
(10, 6, 9, 1, '4000.0000', '0.0000', '10.0000', '400.0000', '0.0000', '0.0000', '1', '4000.0000', '3600.0000', '0.0000', '4000.0000', '3240.0000', NULL, NULL, '0000-00-00', ''),
(18, 7, 9, 1, '4000.0000', '0.0000', '10.0000', '400.0000', '0.0000', '0.0000', '1', '4000.0000', '3600.0000', '0.0000', '4000.0000', '3600.0000', NULL, NULL, '0000-00-00', ''),
(19, 7, 2, 1, '150.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '12', '1800.0000', '1800.0000', '0.0000', '1800.0000', '1800.0000', NULL, NULL, '0000-00-00', ''),
(22, 10, 1, 2, '90.0000', '0.0000', '0.0000', '0.0000', '12.0000', '0.0000', '1', '90.0000', '90.0000', '9.6400', '80.3600', '90.0000', NULL, NULL, '0000-00-00', ''),
(23, 5, 3, 3, '750.0000', '0.0000', '10.0000', '75.0000', '0.0000', '0.0000', '1', '750.0000', '675.0000', '0.0000', '750.0000', '607.5000', NULL, NULL, '0000-00-00', ''),
(24, 9, 3, 3, '750.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '1', '750.0000', '750.0000', '0.0000', '750.0000', '750.0000', NULL, NULL, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `purchase_order_id` bigint(20) NOT NULL,
  `po_no` varchar(75) DEFAULT '',
  `terms` varchar(55) DEFAULT '',
  `duration` varchar(55) DEFAULT '',
  `deliver_to_address` varchar(755) DEFAULT '',
  `supplier_id` int(11) DEFAULT '0',
  `department_id` bigint(20) DEFAULT '0',
  `tax_type_id` int(11) DEFAULT '0',
  `contact_person` varchar(100) DEFAULT '',
  `remarks` varchar(155) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) NOT NULL,
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `approval_id` int(11) DEFAULT '2',
  `order_status_id` int(11) DEFAULT '1',
  `is_email_sent` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_approved` datetime DEFAULT '0000-00-00 00:00:00',
  `approved_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`purchase_order_id`, `po_no`, `terms`, `duration`, `deliver_to_address`, `supplier_id`, `department_id`, `tax_type_id`, `contact_person`, `remarks`, `total_discount`, `total_before_tax`, `total_tax_amount`, `total_after_tax`, `total_overall_discount`, `total_overall_discount_amount`, `total_after_discount`, `approval_id`, `order_status_id`, `is_email_sent`, `is_active`, `is_deleted`, `date_created`, `date_modified`, `date_deleted`, `date_approved`, `approved_by_user`, `posted_by_user`, `deleted_by_user`, `modified_by_user`) VALUES
(1, 'PO-20180105-1', ' ', NULL, 'Angeles City', 1, 1, 1, ' ', '', '0.0000', '3750.0000', '0.0000', '3750.0000', '0.0000', '0.0000', '3750.0000', 1, 2, b'1', b'1', b'0', '2018-01-05 17:00:41', '2018-01-09 04:38:28', '0000-00-00 00:00:00', '2018-01-05 17:01:02', 1, 1, 0, 1),
(2, 'PO-20180105-2', ' 30', NULL, ' Angeles City', 2, 2, 2, ' Keith', '', '0.0000', '3571.4300', '428.5700', '4000.0000', '0.0000', '0.0000', '4000.0000', 1, 2, b'1', b'1', b'0', '2018-01-05 17:05:34', '2018-01-09 04:32:45', '0000-00-00 00:00:00', '2018-01-05 17:05:38', 1, 1, 0, 0),
(3, 'PO-20180109-3', 'qwe', NULL, 'qw', 1, 1, 1, 'qwe', '', '0.0000', '100.0000', '0.0000', '100.0000', '0.0000', '0.0000', '100.0000', 1, 1, b'1', b'1', b'0', '2018-01-09 11:12:36', '2018-01-09 04:40:30', '0000-00-00 00:00:00', '2018-01-09 12:40:10', 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE `purchase_order_items` (
  `po_item_id` bigint(20) NOT NULL,
  `purchase_order_id` int(11) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `po_price` decimal(20,4) DEFAULT '0.0000',
  `po_discount` decimal(20,4) DEFAULT '0.0000',
  `po_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `po_tax_rate` decimal(11,4) DEFAULT '0.0000',
  `po_qty` decimal(20,0) DEFAULT '0',
  `po_line_total` decimal(20,4) DEFAULT '0.0000',
  `tax_amount` decimal(20,4) DEFAULT '0.0000',
  `non_tax_amount` decimal(20,4) DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`po_item_id`, `purchase_order_id`, `product_id`, `unit_id`, `po_price`, `po_discount`, `po_line_total_discount`, `po_tax_rate`, `po_qty`, `po_line_total`, `tax_amount`, `non_tax_amount`) VALUES
(2, 1, 3, 2, '75.0000', '0.0000', '0.0000', '0.0000', '50', '3750.0000', '0.0000', '3750.0000'),
(3, 2, 4, 1, '20.0000', '0.0000', '0.0000', '12.0000', '200', '4000.0000', '428.5714', '3571.4286'),
(4, 3, 1, 1, '100.0000', '0.0000', '0.0000', '0.0000', '1', '100.0000', '0.0000', '100.0000');

-- --------------------------------------------------------

--
-- Table structure for table `receivable_payments`
--

CREATE TABLE `receivable_payments` (
  `payment_id` bigint(20) NOT NULL,
  `receipt_no` varchar(20) DEFAULT '',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `receipt_type` varchar(55) DEFAULT 'AR',
  `department_id` int(11) DEFAULT '0',
  `payment_method_id` int(11) DEFAULT '0',
  `check_date_type` tinyint(4) DEFAULT '1' COMMENT '1 is Date, 2 is PDC',
  `check_date` date DEFAULT '0000-00-00',
  `check_no` varchar(100) DEFAULT '',
  `remarks` varchar(755) DEFAULT '',
  `total_paid_amount` decimal(20,2) DEFAULT '0.00',
  `date_paid` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_cancelled` datetime DEFAULT '0000-00-00 00:00:00',
  `cancelled_by_user` int(11) DEFAULT '0',
  `created_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `is_posted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `receivable_payments_list`
--

CREATE TABLE `receivable_payments_list` (
  `payment_list_id` bigint(20) NOT NULL,
  `payment_id` bigint(20) DEFAULT '0',
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `service_invoice_id` bigint(20) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `receivable_amount` decimal(20,2) DEFAULT '0.00',
  `payment_amount` decimal(20,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `refcustomertype`
--

CREATE TABLE `refcustomertype` (
  `refcustomertype_id` bigint(20) NOT NULL,
  `customer_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `modified_by_user_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `refmenu`
--

CREATE TABLE `refmenu` (
  `menu_id` int(11) NOT NULL,
  `menu_code` varchar(65) DEFAULT '',
  `menu_name` varchar(254) DEFAULT '',
  `menu_desc` varchar(500) DEFAULT '',
  `sort_key` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT '0',
  `modified_datetime` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT '0',
  `deleted_datetime` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `refmenu`
--

INSERT INTO `refmenu` (`menu_id`, `menu_code`, `menu_name`, `menu_desc`, `sort_key`, `created_by`, `created_datetime`, `modified_by`, `modified_datetime`, `deleted_by`, `deleted_datetime`, `is_deleted`) VALUES
(1, '000', 'Sample Menu', 'Sample Menu', -1, 1, '2017-08-08 12:08:35', 0, NULL, 1, '2017-08-08 12:08:45', 1),
(2, '000', 'Sample Menu 1', 'Sample Menu 1', 1, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(3, '000', 'Sample Menu 2', 'Sample Menu 2', 15, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(4, '000', 'Sample Menu 3', 'Sample Menu 3', 2, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(5, '000', 'Sample Menu 4', 'Sample Menu 4', 16, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(6, '000', 'Sample Menu 5', 'Sample Menu 5', 3, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(7, '000', 'Sample Menu 6', 'Sample Menu 6', 4, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(8, '000', 'Sample Menu 7', 'Sample Menu 7', 17, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(9, '000', 'Sample Menu 8', 'Sample Menu 8', 18, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(10, '000', 'Sample Menu 9', 'Sample Menu 9', 5, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(11, '000', 'Sample Menu 10', 'Sample Menu 10', 6, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(12, '000', 'Sample Menu 11', 'Sample Menu 11', 19, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(13, '000', 'Sample Menu 12', 'Sample Menu 12', 20, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(14, '000', 'Sample Menu 13', 'Sample Menu 13', 7, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(15, '000', 'Sample Menu 14', 'Sample Menu 14', 8, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(16, '000', 'Sample Menu 15', 'Sample Menu 15', 21, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(17, '000', 'Sample Menu 16', 'Sample Menu 16', 9, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(18, '000', 'Sample Menu 17', 'Sample Menu 17', 22, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(19, '000', 'Sample Menu 18', 'Sample Menu 18', 10, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(20, '000', 'Sample Menu 19', 'Sample Menu 19', 11, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(21, '000', 'Sample Menu 20', 'Sample Menu 20', 14, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(22, '000', 'Sample Menu 21', 'Sample Menu 21', 12, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(23, '000', 'Sample Menu 22', 'Sample Menu 22', 13, 1, '2017-08-08 12:08:58', 0, NULL, 0, NULL, 0),
(24, '001', 'Name 2', 'Desc2', 5, 0, NULL, 0, NULL, 0, NULL, 1),
(25, '1212', 'Raf', 'raf', 0, 0, NULL, 0, NULL, 0, NULL, 0),
(26, '123', 'Hahaha', 'well', 2, 0, NULL, 0, NULL, 0, NULL, 0),
(27, '121231', '123213123', '123123', 0, 0, NULL, 0, NULL, 0, NULL, 0),
(28, 'Dessert', 'Dessert', 'Dessert', 1, 0, NULL, 0, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `refproduct`
--

CREATE TABLE `refproduct` (
  `refproduct_id` int(10) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `modified_by_user_id` int(10) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `refproduct`
--

INSERT INTO `refproduct` (`refproduct_id`, `product_type`, `description`, `created_by_user_id`, `modified_by_user_id`, `date_created`, `date_modified`, `is_deleted`) VALUES
(1, 'Companion Animals', 'Common house pets', 0, 0, '2017-07-05 11:51:47', '0000-00-00 00:00:00', 0),
(2, 'Livestock Animals', 'Farm animals', 0, 0, '2017-07-05 11:51:47', '0000-00-00 00:00:00', 0),
(3, 'All Product type', '', 0, 0, '2017-07-05 11:51:47', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rights_links`
--

CREATE TABLE `rights_links` (
  `link_id` int(11) NOT NULL,
  `parent_code` varchar(100) DEFAULT '',
  `link_code` varchar(20) DEFAULT NULL,
  `link_name` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rights_links`
--

INSERT INTO `rights_links` (`link_id`, `parent_code`, `link_code`, `link_name`) VALUES
(1, '1', '1-1', 'General Journal'),
(2, '1', '1-2', 'Cash Disbursement'),
(3, '1', '1-3', 'Purchase Journal'),
(4, '1', '1-4', 'Sales Journal'),
(5, '1', '1-5', 'Cash Receipt'),
(6, '2', '2-1', 'Purchase Order'),
(7, '2', '2-2', 'Purchase Invoice'),
(8, '2', '2-3', 'Record Payment'),
(9, '2', '2-4', 'Item Issuance'),
(10, '2', '2-5', 'Item Adjustment (In)'),
(11, '3', '3-1', 'Sales Order'),
(12, '3', '3-2', 'Sales Invoice'),
(13, '3', '3-3', 'Record Payment'),
(14, '4', '4-2', 'Category Management'),
(15, '4', '4-3', 'Department Management'),
(16, '4', '4-4', 'Unit Management'),
(17, '5', '5-1', 'Product Management'),
(18, '5', '5-2', 'Supplier Management'),
(19, '5', '5-3', 'Customer Management'),
(20, '6', '6-1', 'Setup Tax'),
(21, '6', '6-2', 'Setup Chart of Accounts'),
(22, '6', '6-3', 'Account Integration'),
(23, '6', '6-4', 'Setup User Group'),
(24, '6', '6-5', 'Create User Account'),
(25, '6', '6-6', 'Setup Company Info'),
(26, '7', '7-1', 'Purchase Order for Approval'),
(27, '9', '9-1', 'Balance Sheet Report'),
(28, '9', '9-2', 'Income Statement'),
(29, '4', '4-1', 'Account Classification'),
(30, '8', '8-1', 'Sales Report'),
(31, '8', '8-2', 'Batch Inventory Report'),
(32, '5', '5-4', 'Salesperson Management'),
(33, '2', '2-6', 'Item Adjustment (Out)'),
(34, '8', '8-3', 'Export Sales Summary'),
(35, '9', '9-3', 'Export Trial Balance'),
(36, '6', '6-7', 'Setup Check Layout'),
(37, '9', '9-4', 'AR Schedule'),
(38, '9', '9-6', 'Customer Subsidiary'),
(39, '9', '9-8', 'Account Subsidiary'),
(40, '9', '9-7', 'Supplier Subsidiary'),
(41, '9', '9-5', 'AP Schedule'),
(42, '8', '8-4', 'Purchase Invoice Report'),
(43, '4', '4-5', 'Locations Management'),
(44, '10', '10-1', 'Fixed Asset Management'),
(45, '9', '9-9', 'Annual Income Statement'),
(46, '6', '6-8', 'Recurring Template'),
(47, '9', '9-10', 'VAT Relief Report'),
(48, '1', '1-6', 'Petty Cash Journal'),
(49, '9', '9-13', 'Replenishment Report'),
(50, '6', '6-9', 'Backup Database'),
(51, '9', '9-14', 'Book of Accounts'),
(52, '9', '9-16', 'Comparative Income'),
(53, '4', '4-6', 'Bank Reference Management'),
(54, '10', '10-2', 'Depreciation Expense Report'),
(55, '11', '11-1', 'Bank Reconciliation'),
(57, '12', '12-1', 'Voucher Registry Report'),
(58, '12', '12-2', 'Check Registry Report'),
(59, '12', '12-3', 'Collection List Report'),
(60, '12', '12-4', 'Open Purchase Report'),
(61, '12', '12-5', 'Open Sales Report'),
(62, '9', '9-11', 'Schedule of Expense'),
(63, '9', '9-15', 'AR Reports'),
(64, '9', '9-12', 'Cost of Goods'),
(65, '13', '13-1', 'Service Invoice'),
(66, '13', '13-2', 'Service Journal'),
(67, '13', '13-3', 'Service Unit Management'),
(68, '13', '13-4', 'Service Management'),
(69, '9', '9-17', 'Aging of Receivables'),
(70, '9', '9-18', 'Aging of Payables'),
(71, '9', '9-19', 'Statement of Account'),
(72, '6', '6-10', 'Email Settings'),
(73, '14', '14-1', 'Treasury'),
(74, '9', '9-20', 'Replenishment Batch Report'),
(75, '9', '9-21', 'General Ledger'),
(76, '6', '6-11', 'Email Report'),
(77, '15', '15-1', 'Hotel Control Panel'),
(78, '15', '15-2', 'Hotel Integration Settings'),
(79, '4', '4-7', 'Menu Management'),
(80, '16', '16-1', 'POS Integration Settings'),
(81, '16', '16-2', 'Pos Control Panel'),
(82, '8', '8-5', 'Bar Sales Report'),
(83, '12', '12-6', 'Product List Detailed'),
(84, '12', '12-7', 'Pick-list (Reorder)'),
(85, '2', '2-6', 'Purchase History');

-- --------------------------------------------------------

--
-- Table structure for table `salesperson`
--

CREATE TABLE `salesperson` (
  `salesperson_id` int(11) NOT NULL,
  `salesperson_code` varchar(55) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `acr_name` varchar(10) DEFAULT NULL,
  `contact_no` varchar(100) NOT NULL,
  `department_id` int(2) NOT NULL,
  `tin_no` varchar(100) NOT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice`
--

CREATE TABLE `sales_invoice` (
  `sales_invoice_id` bigint(20) NOT NULL,
  `sales_inv_no` varchar(75) DEFAULT '',
  `sales_order_id` bigint(20) DEFAULT '0',
  `sales_order_no` varchar(75) DEFAULT '',
  `order_status_id` int(11) DEFAULT '1' COMMENT '1 is open 2 is closed 3 is partially, used in delivery_receipt',
  `department_id` int(11) DEFAULT '0',
  `issue_to_department` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `journal_id` bigint(20) DEFAULT '0',
  `terms` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `total_after_tax` decimal(20,4) DEFAULT '0.0000',
  `date_due` date DEFAULT '0000-00-00',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_journal_posted` bit(1) DEFAULT b'0',
  `ref_product_type_id` int(11) DEFAULT '0',
  `inv_type` int(11) DEFAULT '1',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT '',
  `contact_person` varchar(175) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice_items`
--

CREATE TABLE `sales_invoice_items` (
  `sales_item_id` bigint(20) NOT NULL,
  `sales_invoice_id` bigint(20) DEFAULT '0',
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT '0',
  `inv_price` decimal(20,4) DEFAULT '0.0000',
  `orig_so_price` decimal(20,4) DEFAULT '0.0000',
  `inv_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `cost_upon_invoice` decimal(20,4) DEFAULT '0.0000',
  `inv_qty` decimal(20,0) DEFAULT '0',
  `inv_gross` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `inv_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `inv_line_total_after_global` decimal(20,4) DEFAULT '0.0000',
  `inv_notes` varchar(100) DEFAULT NULL,
  `dr_invoice_id` int(11) DEFAULT NULL,
  `exp_date` date DEFAULT '0000-00-00',
  `batch_no` varchar(55) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order`
--

CREATE TABLE `sales_order` (
  `sales_order_id` bigint(20) NOT NULL,
  `so_no` varchar(75) DEFAULT '',
  `customer_id` bigint(20) DEFAULT '0',
  `department_id` int(11) DEFAULT '0',
  `remarks` varchar(755) DEFAULT '',
  `total_discount` decimal(20,2) DEFAULT '0.00',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_before_tax` decimal(20,2) DEFAULT '0.00',
  `total_after_tax` decimal(20,2) DEFAULT '0.00',
  `total_after_discount` decimal(20,4) DEFAULT '0.0000',
  `total_tax_amount` decimal(20,2) DEFAULT '0.00',
  `order_status_id` int(11) DEFAULT '1',
  `date_order` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `salesperson_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_items`
--

CREATE TABLE `sales_order_items` (
  `sales_order_item_id` bigint(20) NOT NULL,
  `sales_order_id` bigint(20) DEFAULT NULL,
  `product_id` int(11) DEFAULT '0',
  `unit_id` int(11) DEFAULT NULL,
  `so_qty` decimal(20,0) DEFAULT '0',
  `so_price` decimal(20,4) DEFAULT '0.0000',
  `so_discount` decimal(20,4) DEFAULT '0.0000',
  `so_gross` decimal(20,4) DEFAULT '0.0000',
  `so_line_total_discount` decimal(20,4) DEFAULT '0.0000',
  `so_tax_rate` decimal(20,4) DEFAULT '0.0000',
  `so_line_total_price` decimal(20,4) DEFAULT '0.0000',
  `so_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `so_non_tax_amount` decimal(20,4) DEFAULT '0.0000',
  `exp_date` date DEFAULT '0000-00-00',
  `dr_invoice_id` int(11) DEFAULT NULL,
  `batch_no` varchar(55) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sched_expense_integration`
--

CREATE TABLE `sched_expense_integration` (
  `sched_expense_id` bigint(20) NOT NULL,
  `account_id` bigint(20) DEFAULT '0',
  `group_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` bigint(20) NOT NULL,
  `service_code` varchar(255) DEFAULT NULL,
  `service_desc` varchar(255) DEFAULT NULL,
  `service_unit` varchar(255) DEFAULT NULL,
  `income_account_id` bigint(20) DEFAULT '0',
  `expense_account_id` bigint(20) DEFAULT '0',
  `service_amount` decimal(25,2) DEFAULT '0.00',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `created_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_invoice`
--

CREATE TABLE `service_invoice` (
  `service_invoice_id` bigint(20) NOT NULL,
  `service_invoice_no` varchar(75) DEFAULT NULL,
  `department_id` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `salesperson_id` int(11) DEFAULT '0',
  `address` varchar(150) DEFAULT NULL,
  `total_amount` decimal(25,2) DEFAULT '0.00',
  `total_overall_discount` decimal(20,4) DEFAULT '0.0000',
  `total_overall_discount_amount` decimal(20,4) DEFAULT '0.0000',
  `total_amount_after_discount` decimal(20,4) DEFAULT '0.0000',
  `date_invoice` date DEFAULT '0000-00-00',
  `date_due` date DEFAULT '0000-00-00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `remarks` text,
  `is_journal_posted` bit(1) DEFAULT b'0',
  `journal_id` bigint(20) DEFAULT '0',
  `contact_person` varchar(175) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_invoice_items`
--

CREATE TABLE `service_invoice_items` (
  `service_item_id` bigint(25) NOT NULL,
  `service_invoice_id` bigint(25) DEFAULT '0',
  `service_id` int(11) DEFAULT '0',
  `service_unit` int(11) DEFAULT '0',
  `service_price` decimal(25,2) DEFAULT '0.00',
  `service_qty` int(11) DEFAULT '0',
  `service_line_total` decimal(25,2) DEFAULT '0.00',
  `service_line_total_after_global` decimal(25,4) DEFAULT '0.0000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_unit`
--

CREATE TABLE `service_unit` (
  `service_unit_id` int(11) NOT NULL,
  `service_unit_name` varchar(255) DEFAULT NULL,
  `service_unit_desc` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `is_active` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` bigint(20) NOT NULL,
  `supplier_code` varchar(125) DEFAULT '',
  `supplier_name` varchar(255) DEFAULT '',
  `contact_name` varchar(255) DEFAULT '',
  `contact_person` varchar(155) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `email_address` varchar(255) DEFAULT '',
  `contact_no` varchar(255) DEFAULT '',
  `tin_no` varchar(255) DEFAULT '',
  `term` varchar(255) DEFAULT '',
  `tax_type_id` int(11) DEFAULT '1',
  `photo_path` varchar(500) DEFAULT '',
  `total_payable_amount` decimal(19,2) DEFAULT '0.00',
  `posted_by_user` int(11) DEFAULT '0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `credit_limit` varchar(255) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1',
  `deleted_by_user` int(11) DEFAULT '0',
  `date_deleted` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_code`, `supplier_name`, `contact_name`, `contact_person`, `address`, `email_address`, `contact_no`, `tin_no`, `term`, `tax_type_id`, `photo_path`, `total_payable_amount`, `posted_by_user`, `date_created`, `date_modified`, `credit_limit`, `is_deleted`, `is_active`, `deleted_by_user`, `date_deleted`) VALUES
(1, 'N/A', 'N/A', 'el', '', ' ', 'manaloraf03@gmail.com', '', '', '', 1, 'assets/img/anonymous-icon.png', '3750.00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, b'0', b'1', 0, '0000-00-00 00:00:00'),
(2, '', 'San Miguel Corporation', 'Joey Ayala', '', 'San Fernando', 'manaloraf03@gmail.com', '', '14344', '', 2, 'assets/img/anonymous-icon.png', '4000.00', 1, '2018-01-05 17:05:01', '0000-00-00 00:00:00', NULL, b'0', b'1', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_photos`
--

CREATE TABLE `supplier_photos` (
  `photo_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT '0',
  `photo_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tax_types`
--

CREATE TABLE `tax_types` (
  `tax_type_id` int(11) NOT NULL,
  `tax_type` varchar(155) DEFAULT '',
  `tax_rate` decimal(11,2) DEFAULT '0.00',
  `description` varchar(555) DEFAULT '',
  `is_default` bit(1) DEFAULT b'0',
  `is_deleted` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax_types`
--

INSERT INTO `tax_types` (`tax_type_id`, `tax_type`, `tax_rate`, `description`, `is_default`, `is_deleted`) VALUES
(1, 'Non-vat', '0.00', '', b'0', b'0'),
(2, 'Vatted', '12.00', '', b'1', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `unit_id` bigint(20) NOT NULL,
  `unit_code` bigint(20) DEFAULT NULL,
  `unit_name` varchar(255) DEFAULT NULL,
  `unit_desc` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_deleted` bit(1) DEFAULT b'0',
  `is_active` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`unit_id`, `unit_code`, `unit_name`, `unit_desc`, `date_created`, `date_modified`, `is_deleted`, `is_active`) VALUES
(1, NULL, 'Piece', '', NULL, '0000-00-00 00:00:00', b'0', b'1'),
(2, NULL, 'Kilograms', '', NULL, '0000-00-00 00:00:00', b'0', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT '',
  `user_pword` varchar(500) DEFAULT '',
  `user_lname` varchar(100) DEFAULT '',
  `user_fname` varchar(100) DEFAULT '',
  `user_mname` varchar(100) DEFAULT '',
  `user_address` varchar(155) DEFAULT '',
  `user_email` varchar(100) DEFAULT '',
  `user_mobile` varchar(100) DEFAULT '',
  `user_telephone` varchar(100) DEFAULT '',
  `user_bdate` date DEFAULT '0000-00-00',
  `user_group_id` int(11) DEFAULT '0',
  `photo_path` varchar(555) DEFAULT '',
  `file_directory` varchar(666) DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` int(11) DEFAULT '0',
  `modified_by_user` int(11) DEFAULT '0',
  `posted_by_user` int(11) DEFAULT '0',
  `deleted_by_user` int(11) DEFAULT '0',
  `is_online` tinyint(4) DEFAULT '0',
  `last_seen` datetime DEFAULT NULL,
  `token_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`user_id`, `user_name`, `user_pword`, `user_lname`, `user_fname`, `user_mname`, `user_address`, `user_email`, `user_mobile`, `user_telephone`, `user_bdate`, `user_group_id`, `photo_path`, `file_directory`, `is_active`, `is_deleted`, `date_created`, `date_modified`, `date_deleted`, `modified_by_user`, `posted_by_user`, `deleted_by_user`, `is_online`, `last_seen`, `token_id`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Head', 'Administrator', '', 'Angeles City, Pampanga', 'administrator@gmail.com', '0945-315-8563', '', '1970-01-01', 1, 'assets/img/user/5a434887858fa.png', NULL, b'1', b'0', NULL, '2018-01-09 09:25:11', 0, 1, 0, 0, 1, '2018-01-09 17:25:11', '01bece074ddab6be38f751ff1fa9274a');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `user_group_id` int(11) NOT NULL,
  `user_group` varchar(135) DEFAULT '',
  `user_group_desc` varchar(500) DEFAULT '',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`user_group_id`, `user_group`, `user_group_desc`, `is_active`, `is_deleted`, `date_created`, `date_modified`) VALUES
(1, 'System Administrator', 'Can access all features.', b'1', b'0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_group_rights`
--

CREATE TABLE `user_group_rights` (
  `user_rights_id` bigint(20) NOT NULL,
  `user_group_id` int(11) DEFAULT '0',
  `link_code` varchar(20) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_group_rights`
--

INSERT INTO `user_group_rights` (`user_rights_id`, `user_group_id`, `link_code`) VALUES
(1, 1, '1-1'),
(2, 1, '1-2'),
(3, 1, '1-3'),
(4, 1, '1-4'),
(5, 1, '1-5'),
(6, 1, '2-1'),
(7, 1, '2-2'),
(8, 1, '2-3'),
(9, 1, '2-4'),
(10, 1, '2-5'),
(11, 1, '3-1'),
(12, 1, '3-2'),
(13, 1, '3-3'),
(14, 1, '4-2'),
(15, 1, '4-3'),
(16, 1, '4-4'),
(17, 1, '5-1'),
(18, 1, '5-2'),
(19, 1, '5-3'),
(20, 1, '6-1'),
(21, 1, '6-2'),
(22, 1, '6-3'),
(23, 1, '6-4'),
(24, 1, '6-5'),
(25, 1, '6-6'),
(26, 1, '7-1'),
(27, 1, '9-1'),
(28, 1, '9-2'),
(29, 1, '4-1'),
(30, 1, '8-1'),
(31, 1, '8-2'),
(32, 1, '5-4'),
(33, 1, '2-6'),
(34, 1, '8-3'),
(35, 1, '9-3'),
(36, 1, '6-7'),
(37, 1, '9-4'),
(38, 1, '9-6'),
(39, 1, '9-8'),
(40, 1, '9-7'),
(41, 1, '9-5'),
(42, 1, '8-4'),
(43, 1, '4-5'),
(44, 1, '10-1'),
(45, 1, '9-9'),
(46, 1, '6-8'),
(47, 1, '9-10'),
(48, 1, '1-6'),
(49, 1, '9-13'),
(50, 1, '6-9'),
(51, 1, '9-14'),
(52, 1, '9-16'),
(53, 1, '4-6'),
(54, 1, '10-2'),
(55, 1, '11-1'),
(57, 1, '12-1'),
(58, 1, '12-2'),
(59, 1, '12-3'),
(60, 1, '12-4'),
(61, 1, '12-5'),
(62, 1, '9-11'),
(63, 1, '9-15'),
(64, 1, '9-12'),
(65, 1, '13-1'),
(66, 1, '13-2'),
(67, 1, '13-3'),
(68, 1, '13-4'),
(69, 1, '9-17'),
(70, 1, '9-18'),
(71, 1, '9-19'),
(72, 1, '6-10'),
(73, 1, '14-1'),
(74, 1, '9-20'),
(75, 1, '9-21'),
(76, 1, '6-11'),
(77, 1, '15-1'),
(78, 1, '15-2'),
(79, 1, '4-7'),
(80, 1, '16-1'),
(81, 1, '16-2'),
(82, 1, '8-5'),
(83, 1, '12-6'),
(84, 1, '12-7'),
(85, 1, '2-6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounting_period`
--
ALTER TABLE `accounting_period`
  ADD PRIMARY KEY (`accounting_period_id`) USING BTREE;

--
-- Indexes for table `account_classes`
--
ALTER TABLE `account_classes`
  ADD PRIMARY KEY (`account_class_id`) USING BTREE;

--
-- Indexes for table `account_integration`
--
ALTER TABLE `account_integration`
  ADD PRIMARY KEY (`integration_id`) USING BTREE;

--
-- Indexes for table `account_titles`
--
ALTER TABLE `account_titles`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`account_type_id`) USING BTREE;

--
-- Indexes for table `account_year`
--
ALTER TABLE `account_year`
  ADD PRIMARY KEY (`account_year_id`) USING BTREE;

--
-- Indexes for table `adjustment_info`
--
ALTER TABLE `adjustment_info`
  ADD PRIMARY KEY (`adjustment_id`) USING BTREE;

--
-- Indexes for table `adjustment_items`
--
ALTER TABLE `adjustment_items`
  ADD PRIMARY KEY (`adjustment_item_id`) USING BTREE;

--
-- Indexes for table `approval_status`
--
ALTER TABLE `approval_status`
  ADD PRIMARY KEY (`approval_id`) USING BTREE;

--
-- Indexes for table `asset_property_status`
--
ALTER TABLE `asset_property_status`
  ADD PRIMARY KEY (`asset_status_id`) USING BTREE,
  ADD UNIQUE KEY `asset_property_id` (`asset_status_id`) USING BTREE;

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `bank_reconciliation`
--
ALTER TABLE `bank_reconciliation`
  ADD PRIMARY KEY (`bank_recon_id`);

--
-- Indexes for table `bank_reconciliation_details`
--
ALTER TABLE `bank_reconciliation_details`
  ADD PRIMARY KEY (`bank_recon_item_id`);

--
-- Indexes for table `batch_info`
--
ALTER TABLE `batch_info`
  ADD PRIMARY KEY (`batch_id`) USING BTREE,
  ADD UNIQUE KEY `batch_id` (`batch_id`) USING BTREE;

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`) USING BTREE;

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`card_id`) USING BTREE;

--
-- Indexes for table `cash_invoice`
--
ALTER TABLE `cash_invoice`
  ADD PRIMARY KEY (`cash_invoice_id`) USING BTREE,
  ADD UNIQUE KEY `cash_inv_no` (`cash_inv_no`) USING BTREE;

--
-- Indexes for table `cash_invoice_items`
--
ALTER TABLE `cash_invoice_items`
  ADD PRIMARY KEY (`cash_item_id`) USING BTREE;

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`) USING BTREE;

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`) USING BTREE;

--
-- Indexes for table `check_layout`
--
ALTER TABLE `check_layout`
  ADD PRIMARY KEY (`check_layout_id`) USING BTREE;

--
-- Indexes for table `commercial_invoice`
--
ALTER TABLE `commercial_invoice`
  ADD PRIMARY KEY (`commercial_invoice_id`) USING BTREE,
  ADD UNIQUE KEY `commercial_inv_no` (`commercial_inv_no`) USING BTREE;

--
-- Indexes for table `commercial_invoice_items`
--
ALTER TABLE `commercial_invoice_items`
  ADD PRIMARY KEY (`commercial_item_id`) USING BTREE;

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`company_id`) USING BTREE;

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`) USING BTREE;

--
-- Indexes for table `customer_photos`
--
ALTER TABLE `customer_photos`
  ADD PRIMARY KEY (`photo_id`) USING BTREE;

--
-- Indexes for table `delivery_invoice`
--
ALTER TABLE `delivery_invoice`
  ADD PRIMARY KEY (`dr_invoice_id`) USING BTREE,
  ADD UNIQUE KEY `dr_invoice_no` (`dr_invoice_no`) USING BTREE;

--
-- Indexes for table `delivery_invoice_items`
--
ALTER TABLE `delivery_invoice_items`
  ADD PRIMARY KEY (`dr_invoice_item_id`) USING BTREE;

--
-- Indexes for table `delivery_receipt`
--
ALTER TABLE `delivery_receipt`
  ADD PRIMARY KEY (`delivery_receipt_id`) USING BTREE,
  ADD UNIQUE KEY `sales_inv_no` (`delivery_inv_no`) USING BTREE;

--
-- Indexes for table `delivery_receipt_items`
--
ALTER TABLE `delivery_receipt_items`
  ADD PRIMARY KEY (`delivery_receipt_item_id`) USING BTREE;

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`) USING BTREE;

--
-- Indexes for table `depreciation_expense`
--
ALTER TABLE `depreciation_expense`
  ADD PRIMARY KEY (`de_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discount_id`) USING BTREE;

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `fixed_assets`
--
ALTER TABLE `fixed_assets`
  ADD PRIMARY KEY (`fixed_asset_id`) USING BTREE;

--
-- Indexes for table `generics`
--
ALTER TABLE `generics`
  ADD PRIMARY KEY (`generic_id`) USING BTREE;

--
-- Indexes for table `giftcards`
--
ALTER TABLE `giftcards`
  ADD PRIMARY KEY (`giftcard_id`) USING BTREE;

--
-- Indexes for table `hotel_integration`
--
ALTER TABLE `hotel_integration`
  ADD PRIMARY KEY (`hotel_integration_id`);

--
-- Indexes for table `hotel_integration_items`
--
ALTER TABLE `hotel_integration_items`
  ADD PRIMARY KEY (`hotel_integration_items_id`);

--
-- Indexes for table `invoice_counter`
--
ALTER TABLE `invoice_counter`
  ADD PRIMARY KEY (`counter_id`) USING BTREE,
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `issuance_info`
--
ALTER TABLE `issuance_info`
  ADD PRIMARY KEY (`issuance_id`) USING BTREE;

--
-- Indexes for table `issuance_items`
--
ALTER TABLE `issuance_items`
  ADD PRIMARY KEY (`issuance_item_id`) USING BTREE;

--
-- Indexes for table `item_types`
--
ALTER TABLE `item_types`
  ADD PRIMARY KEY (`item_type_id`) USING BTREE;

--
-- Indexes for table `journal_accounts`
--
ALTER TABLE `journal_accounts`
  ADD PRIMARY KEY (`journal_account_id`) USING BTREE;

--
-- Indexes for table `journal_entry_templates`
--
ALTER TABLE `journal_entry_templates`
  ADD PRIMARY KEY (`entry_template_id`) USING BTREE;

--
-- Indexes for table `journal_info`
--
ALTER TABLE `journal_info`
  ADD PRIMARY KEY (`journal_id`) USING BTREE;

--
-- Indexes for table `journal_templates_info`
--
ALTER TABLE `journal_templates_info`
  ADD PRIMARY KEY (`template_id`) USING BTREE;

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`) USING BTREE;

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`chat_id`) USING BTREE;

--
-- Indexes for table `module_layout`
--
ALTER TABLE `module_layout`
  ADD PRIMARY KEY (`module_layout_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`order_status_id`) USING BTREE;

--
-- Indexes for table `other_sales_invoice`
--
ALTER TABLE `other_sales_invoice`
  ADD PRIMARY KEY (`sales_invoice_id`) USING BTREE;

--
-- Indexes for table `other_sales_invoice_items`
--
ALTER TABLE `other_sales_invoice_items`
  ADD PRIMARY KEY (`sales_item_id`) USING BTREE;

--
-- Indexes for table `payable_payments`
--
ALTER TABLE `payable_payments`
  ADD PRIMARY KEY (`payment_id`) USING BTREE;

--
-- Indexes for table `payable_payments_list`
--
ALTER TABLE `payable_payments_list`
  ADD PRIMARY KEY (`payment_list_id`) USING BTREE;

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`payment_method_id`) USING BTREE;

--
-- Indexes for table `pos_integration`
--
ALTER TABLE `pos_integration`
  ADD PRIMARY KEY (`pos_integration_id`);

--
-- Indexes for table `pos_integration_items`
--
ALTER TABLE `pos_integration_items`
  ADD PRIMARY KEY (`pos_integration_items_id`);

--
-- Indexes for table `po_attachments`
--
ALTER TABLE `po_attachments`
  ADD PRIMARY KEY (`po_attachment_id`) USING BTREE;

--
-- Indexes for table `po_messages`
--
ALTER TABLE `po_messages`
  ADD PRIMARY KEY (`po_message_id`) USING BTREE;

--
-- Indexes for table `print_layout`
--
ALTER TABLE `print_layout`
  ADD PRIMARY KEY (`layout_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`) USING BTREE;

--
-- Indexes for table `product_batch_inventory`
--
ALTER TABLE `product_batch_inventory`
  ADD PRIMARY KEY (`product_key`) USING BTREE,
  ADD UNIQUE KEY `product_key` (`product_key`) USING BTREE;

--
-- Indexes for table `proforma_invoice`
--
ALTER TABLE `proforma_invoice`
  ADD PRIMARY KEY (`proforma_invoice_id`) USING BTREE,
  ADD UNIQUE KEY `proforma_inv_no` (`proforma_inv_no`) USING BTREE;

--
-- Indexes for table `proforma_invoice_items`
--
ALTER TABLE `proforma_invoice_items`
  ADD PRIMARY KEY (`proforma_item_id`) USING BTREE;

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`purchase_order_id`) USING BTREE,
  ADD UNIQUE KEY `po_no` (`po_no`) USING BTREE,
  ADD UNIQUE KEY `po_no_2` (`po_no`) USING BTREE;

--
-- Indexes for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  ADD PRIMARY KEY (`po_item_id`) USING BTREE;

--
-- Indexes for table `receivable_payments`
--
ALTER TABLE `receivable_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `receivable_payments_list`
--
ALTER TABLE `receivable_payments_list`
  ADD PRIMARY KEY (`payment_list_id`);

--
-- Indexes for table `refcustomertype`
--
ALTER TABLE `refcustomertype`
  ADD PRIMARY KEY (`refcustomertype_id`) USING BTREE;

--
-- Indexes for table `refmenu`
--
ALTER TABLE `refmenu`
  ADD PRIMARY KEY (`menu_id`) USING BTREE;

--
-- Indexes for table `refproduct`
--
ALTER TABLE `refproduct`
  ADD PRIMARY KEY (`refproduct_id`) USING BTREE;

--
-- Indexes for table `rights_links`
--
ALTER TABLE `rights_links`
  ADD PRIMARY KEY (`link_id`) USING BTREE;

--
-- Indexes for table `salesperson`
--
ALTER TABLE `salesperson`
  ADD PRIMARY KEY (`salesperson_id`) USING BTREE;

--
-- Indexes for table `sales_invoice`
--
ALTER TABLE `sales_invoice`
  ADD PRIMARY KEY (`sales_invoice_id`) USING BTREE,
  ADD UNIQUE KEY `sales_inv_no` (`sales_inv_no`) USING BTREE;

--
-- Indexes for table `sales_invoice_items`
--
ALTER TABLE `sales_invoice_items`
  ADD PRIMARY KEY (`sales_item_id`) USING BTREE;

--
-- Indexes for table `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`sales_order_id`) USING BTREE;

--
-- Indexes for table `sales_order_items`
--
ALTER TABLE `sales_order_items`
  ADD PRIMARY KEY (`sales_order_item_id`) USING BTREE;

--
-- Indexes for table `sched_expense_integration`
--
ALTER TABLE `sched_expense_integration`
  ADD PRIMARY KEY (`sched_expense_id`) USING BTREE,
  ADD UNIQUE KEY `account_id` (`account_id`) USING BTREE;

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_invoice`
--
ALTER TABLE `service_invoice`
  ADD PRIMARY KEY (`service_invoice_id`);

--
-- Indexes for table `service_invoice_items`
--
ALTER TABLE `service_invoice_items`
  ADD PRIMARY KEY (`service_item_id`);

--
-- Indexes for table `service_unit`
--
ALTER TABLE `service_unit`
  ADD PRIMARY KEY (`service_unit_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`) USING BTREE;

--
-- Indexes for table `supplier_photos`
--
ALTER TABLE `supplier_photos`
  ADD PRIMARY KEY (`photo_id`) USING BTREE;

--
-- Indexes for table `tax_types`
--
ALTER TABLE `tax_types`
  ADD PRIMARY KEY (`tax_type_id`) USING BTREE;

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`unit_id`) USING BTREE;

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`user_id`) USING BTREE;

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`user_group_id`) USING BTREE;

--
-- Indexes for table `user_group_rights`
--
ALTER TABLE `user_group_rights`
  ADD PRIMARY KEY (`user_rights_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounting_period`
--
ALTER TABLE `accounting_period`
  MODIFY `accounting_period_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `account_classes`
--
ALTER TABLE `account_classes`
  MODIFY `account_class_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `account_titles`
--
ALTER TABLE `account_titles`
  MODIFY `account_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `account_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `account_year`
--
ALTER TABLE `account_year`
  MODIFY `account_year_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `adjustment_info`
--
ALTER TABLE `adjustment_info`
  MODIFY `adjustment_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `adjustment_items`
--
ALTER TABLE `adjustment_items`
  MODIFY `adjustment_item_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `approval_status`
--
ALTER TABLE `approval_status`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `asset_property_status`
--
ALTER TABLE `asset_property_status`
  MODIFY `asset_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bank_reconciliation`
--
ALTER TABLE `bank_reconciliation`
  MODIFY `bank_recon_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bank_reconciliation_details`
--
ALTER TABLE `bank_reconciliation_details`
  MODIFY `bank_recon_item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `batch_info`
--
ALTER TABLE `batch_info`
  MODIFY `batch_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `card_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cash_invoice`
--
ALTER TABLE `cash_invoice`
  MODIFY `cash_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `cash_invoice_items`
--
ALTER TABLE `cash_invoice_items`
  MODIFY `cash_item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `check_layout`
--
ALTER TABLE `check_layout`
  MODIFY `check_layout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `commercial_invoice`
--
ALTER TABLE `commercial_invoice`
  MODIFY `commercial_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `commercial_invoice_items`
--
ALTER TABLE `commercial_invoice_items`
  MODIFY `commercial_item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `company_info`
--
ALTER TABLE `company_info`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_photos`
--
ALTER TABLE `customer_photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `delivery_invoice`
--
ALTER TABLE `delivery_invoice`
  MODIFY `dr_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `delivery_invoice_items`
--
ALTER TABLE `delivery_invoice_items`
  MODIFY `dr_invoice_item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `delivery_receipt`
--
ALTER TABLE `delivery_receipt`
  MODIFY `delivery_receipt_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `delivery_receipt_items`
--
ALTER TABLE `delivery_receipt_items`
  MODIFY `delivery_receipt_item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `depreciation_expense`
--
ALTER TABLE `depreciation_expense`
  MODIFY `de_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discount_id` bigint(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fixed_assets`
--
ALTER TABLE `fixed_assets`
  MODIFY `fixed_asset_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `generics`
--
ALTER TABLE `generics`
  MODIFY `generic_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `giftcards`
--
ALTER TABLE `giftcards`
  MODIFY `giftcard_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hotel_integration`
--
ALTER TABLE `hotel_integration`
  MODIFY `hotel_integration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hotel_integration_items`
--
ALTER TABLE `hotel_integration_items`
  MODIFY `hotel_integration_items_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice_counter`
--
ALTER TABLE `invoice_counter`
  MODIFY `counter_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `issuance_info`
--
ALTER TABLE `issuance_info`
  MODIFY `issuance_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `issuance_items`
--
ALTER TABLE `issuance_items`
  MODIFY `issuance_item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `item_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `journal_accounts`
--
ALTER TABLE `journal_accounts`
  MODIFY `journal_account_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `journal_entry_templates`
--
ALTER TABLE `journal_entry_templates`
  MODIFY `entry_template_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `journal_info`
--
ALTER TABLE `journal_info`
  MODIFY `journal_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `journal_templates_info`
--
ALTER TABLE `journal_templates_info`
  MODIFY `template_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `module_layout`
--
ALTER TABLE `module_layout`
  MODIFY `module_layout_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `other_sales_invoice`
--
ALTER TABLE `other_sales_invoice`
  MODIFY `sales_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `other_sales_invoice_items`
--
ALTER TABLE `other_sales_invoice_items`
  MODIFY `sales_item_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payable_payments`
--
ALTER TABLE `payable_payments`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payable_payments_list`
--
ALTER TABLE `payable_payments_list`
  MODIFY `payment_list_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pos_integration`
--
ALTER TABLE `pos_integration`
  MODIFY `pos_integration_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pos_integration_items`
--
ALTER TABLE `pos_integration_items`
  MODIFY `pos_integration_items_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `po_attachments`
--
ALTER TABLE `po_attachments`
  MODIFY `po_attachment_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `po_messages`
--
ALTER TABLE `po_messages`
  MODIFY `po_message_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `print_layout`
--
ALTER TABLE `print_layout`
  MODIFY `layout_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `proforma_invoice`
--
ALTER TABLE `proforma_invoice`
  MODIFY `proforma_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `proforma_invoice_items`
--
ALTER TABLE `proforma_invoice_items`
  MODIFY `proforma_item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `purchase_order_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `purchase_order_items`
--
ALTER TABLE `purchase_order_items`
  MODIFY `po_item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `receivable_payments`
--
ALTER TABLE `receivable_payments`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `receivable_payments_list`
--
ALTER TABLE `receivable_payments_list`
  MODIFY `payment_list_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `refcustomertype`
--
ALTER TABLE `refcustomertype`
  MODIFY `refcustomertype_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `refmenu`
--
ALTER TABLE `refmenu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `refproduct`
--
ALTER TABLE `refproduct`
  MODIFY `refproduct_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rights_links`
--
ALTER TABLE `rights_links`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `salesperson`
--
ALTER TABLE `salesperson`
  MODIFY `salesperson_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_invoice`
--
ALTER TABLE `sales_invoice`
  MODIFY `sales_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_invoice_items`
--
ALTER TABLE `sales_invoice_items`
  MODIFY `sales_item_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `sales_order_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_order_items`
--
ALTER TABLE `sales_order_items`
  MODIFY `sales_order_item_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sched_expense_integration`
--
ALTER TABLE `sched_expense_integration`
  MODIFY `sched_expense_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service_invoice`
--
ALTER TABLE `service_invoice`
  MODIFY `service_invoice_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service_invoice_items`
--
ALTER TABLE `service_invoice_items`
  MODIFY `service_item_id` bigint(25) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `service_unit`
--
ALTER TABLE `service_unit`
  MODIFY `service_unit_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `supplier_photos`
--
ALTER TABLE `supplier_photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tax_types`
--
ALTER TABLE `tax_types`
  MODIFY `tax_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `unit_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_group_rights`
--
ALTER TABLE `user_group_rights`
  MODIFY `user_rights_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
