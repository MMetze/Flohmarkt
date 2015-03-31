/* 	Flohmarkt Kasse - Manage sells and seller payouts
    Copyright (C) 2015  Metze, Matthias

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	
	Contact information
	eMail: m.metze@gmx.com
	GitHub: https://github.com/MMetze/Flohmarkt
 */

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fm_transactions`
--

CREATE TABLE IF NOT EXISTS `fm_transactions` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;
