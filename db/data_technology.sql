-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 13, 2013 at 12:20 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `data_technology`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `brandCode` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `brandName` varchar(32) NOT NULL,
  PRIMARY KEY (`brandCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brandCode`, `brandName`) VALUES
(1, 'Dell'),
(2, 'HP'),
(3, 'Western Digital'),
(4, 'Maxtor'),
(5, 'Apple'),
(6, 'Samsung');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customerCode` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `customerName` varchar(32) NOT NULL,
  `customerMobile` bigint(12) unsigned NOT NULL,
  `customerTelephone` bigint(12) unsigned DEFAULT NULL,
  `customerCompany` varchar(32) DEFAULT NULL,
  `customerAddress` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`customerCode`),
  UNIQUE KEY `customerMobile` (`customerMobile`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerCode`, `customerName`, `customerMobile`, `customerTelephone`, `customerCompany`, `customerAddress`) VALUES
(1, 'مجید ناصری', 9353184225, 7674354, 'فروغ فن', 'امامیه 7 پلاک 224'),
(2, 'مهناز خداجو', 9155163246, 7875465, 'عصرجدید', 'معلم 14 پلاک 24 طبقه 4'),
(3, 'نیما ایزدی', 9195263123, 2187653, NULL, 'عارف 8 پلاک 136'),
(4, 'کامران مرادی', 9364587895, NULL, 'دنیای دیجیتال', 'فردوسی 84 کوچه چهارم پلاک 285 صبقه 2 در سمت راست'),
(5, 'سحر خدادادی', 9352241565, NULL, NULL, NULL),
(6, 'محمد راستگو', 9363645868, 8765425, 'هوش مصنوعی', 'پیروزی 20 چهارراه 6 مجتمع نیلوفر بلوک 84 طبقه 1');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE IF NOT EXISTS `device` (
  `deviceCode` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `deviceType` tinyint(3) unsigned NOT NULL,
  `deviceBrand` tinyint(3) unsigned NOT NULL,
  `deviceModel` varchar(32) NOT NULL,
  `deviceSerial` varchar(32) NOT NULL,
  `deviceCapacity` mediumint(8) unsigned DEFAULT NULL,
  `deviceMore` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`deviceCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`deviceCode`, `deviceType`, `deviceBrand`, `deviceModel`, `deviceSerial`, `deviceCapacity`, `deviceMore`) VALUES
(1, 1, 1, 's2780', '455362661223124', 0, 'سیستم روشن نمی شود.'),
(2, 1, 2, 'n5680', '123141241525235', 0, 'سیستم عامل تعویض گردد. نصب آنتی ویروس و آفیس'),
(3, 1, 2, 'z5487', '123124124121412', 0, 'ویروس یابی'),
(4, 2, 3, 'h320', '121255251523', 600, 'در هنگام کار صدا می دهد'),
(5, 2, 4, '829', '4141412414', 250, 'بازیابی اصلاعات'),
(6, 1, 5, 'Mac Pro', '21414142414', 0, 'سرعت سیستم خیلی کم شده'),
(7, 1, 6, 'Slime', '3145126416', 0, 'یک چک کامل انجام شود'),
(8, 2, 5, '2650', '745646546462', 1000, 'در خواست بازیابی');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `employeeCode` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `employeeName` varchar(32) NOT NULL,
  `employeeUsername` varchar(32) NOT NULL,
  `employeePassword` char(32) NOT NULL,
  `employeeManager` tinyint(1) DEFAULT NULL,
  `employeeRepairman` tinyint(1) DEFAULT NULL,
  `employeeRegistrar` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`employeeCode`),
  UNIQUE KEY `employeeUsername` (`employeeUsername`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeCode`, `employeeName`, `employeeUsername`, `employeePassword`, `employeeManager`, `employeeRepairman`, `employeeRegistrar`) VALUES
(9, 'مجتبی احمدی', 'mojtaba', '202cb962ac59075b964b07152d234b70', 1, 1, 1),
(13, 'علی صفری', 'ali', '202cb962ac59075b964b07152d234b70', NULL, NULL, 1),
(14, 'جواد اسمتی', 'safari', '202cb962ac59075b964b07152d234b70', NULL, 1, 1),
(15, 'پیمان گولکار', 'peyman', '202cb962ac59075b964b07152d234b70', NULL, 1, NULL),
(16, 'میترا کاردان', 'mitra', '202cb962ac59075b964b07152d234b70', NULL, NULL, 1),
(17, 'میثم یاریان', 'meysam', '202cb962ac59075b964b07152d234b70', NULL, 1, 1),
(19, 'مریم اعتمادی', 'maryam', '202cb962ac59075b964b07152d234b70', 1, NULL, NULL),
(20, 'کاظم صابری', 'kazem', '202cb962ac59075b964b07152d234b70', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE IF NOT EXISTS `receipt` (
  `receiptCode` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `receiptCustomer` smallint(5) unsigned NOT NULL,
  `receiptDevice` mediumint(8) unsigned NOT NULL,
  `receiptStatus` tinyint(4) unsigned DEFAULT NULL,
  `receiptDate` date NOT NULL,
  `receiptDelivery` date DEFAULT NULL,
  `receiptCost` mediumint(8) unsigned DEFAULT '0',
  `receiptReceived` mediumint(8) unsigned DEFAULT '0',
  `receiptPeripherals` varchar(128) DEFAULT NULL,
  `receiptOpinion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`receiptCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`receiptCode`, `receiptCustomer`, `receiptDevice`, `receiptStatus`, `receiptDate`, `receiptDelivery`, `receiptCost`, `receiptReceived`, `receiptPeripherals`, `receiptOpinion`) VALUES
(1, 1, 1, 5, '2013-08-01', NULL, 0, 0, NULL, NULL),
(2, 2, 2, 1, '2013-08-03', NULL, 0, 0, NULL, NULL),
(3, 3, 3, NULL, '2013-08-02', NULL, 0, 0, NULL, NULL),
(4, 2, 4, NULL, '2013-08-06', NULL, 0, 0, NULL, NULL),
(5, 1, 6, 6, '2013-08-06', NULL, 0, 0, NULL, NULL),
(6, 3, 7, NULL, '2013-08-06', NULL, 0, 0, NULL, NULL),
(7, 4, 5, NULL, '2013-08-06', NULL, 0, 0, NULL, NULL),
(8, 4, 6, 0, '2013-08-07', NULL, 0, 0, NULL, NULL),
(9, 6, 8, 0, '2013-08-12', NULL, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `typeCode` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `typeName` varchar(32) NOT NULL,
  PRIMARY KEY (`typeCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`typeCode`, `typeName`) VALUES
(1, 'Laptop'),
(2, 'Hard Disk Drive');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
