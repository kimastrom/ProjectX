-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2011 at 12:26 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `projectx`
--
CREATE DATABASE `projectx` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projectx`;

-- --------------------------------------------------------

--
-- Table structure for table `snippet`
--

CREATE TABLE IF NOT EXISTS `snippet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `code` varchar(2500) NOT NULL,
  `title` varchar(50) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `language` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `snippet`
--

INSERT INTO `snippet` (`id`, `author`, `code`, `title`, `desc`, `language`) VALUES
(1, 'Kim Åström', 'selector {   filter: alpha(opacity=60); /* MSIE/PC */   -moz-opacity: 0.6; /* Mozilla 1.6 and older */   opacity: 0.6; }', 'opacityHack', 'a hack for op', 'css');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
