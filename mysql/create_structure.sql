-- phpMyAdmin SQL Dump
-- version 4.0.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2015 at 01:31 PM
-- Server version: 5.5.24-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `flohmarkt`
--
CREATE DATABASE IF NOT EXISTS `flohmarkt` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `flohmarkt`;

-- --------------------------------------------------------

--
-- Table structure for table `fm_events`
--

CREATE TABLE IF NOT EXISTS `fm_events` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `fm_transactions`
--

CREATE TABLE IF NOT EXISTS `fm_transactions` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `fm_transaction_details`
--

CREATE TABLE IF NOT EXISTS `fm_transaction_details` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_ID` int(10) unsigned NOT NULL,
  `seller` int(10) unsigned NOT NULL,
  `value` decimal(6,2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;
