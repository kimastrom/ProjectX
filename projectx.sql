-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Skapad: 27 nov 2011 kl 01:03
-- Serverversion: 5.5.16
-- PHP-version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `projectx`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `snippetId` int(11) NOT NULL,
  `commentId` int(11) NOT NULL AUTO_INCREMENT,
  `commentText` varchar(1500) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`commentId`),
  KEY `snippetId` (`snippetId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=135 ;

--
-- Dumpning av Data i tabell `comment`
--

INSERT INTO `comment` (`snippetId`, `commentId`, `commentText`, `userId`) VALUES
(1, 129, 'detta är min första kommentar till opacityHack:-)', 6),
(1, 130, 'detta är min andra kommentar till opacityHack', 6),
(2, 132, 'detta är min första kommentar till test snippet2', 6),
(2, 133, 'detta är min andra kommentar till test snippet 2', 6);

-- --------------------------------------------------------

--
-- Tabellstruktur `snippet`
--

CREATE TABLE IF NOT EXISTS `snippet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `code` varchar(2500) NOT NULL,
  `title` varchar(50) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `language` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `snippet`
--

INSERT INTO `snippet` (`id`, `author`, `code`, `title`, `desc`, `language`) VALUES
(1, 'Kim Åström', 'selector {   filter: alpha(opacity=60); /* MSIE/PC */   -moz-opacity: 0.6; /* Mozilla 1.6 and older */   opacity: 0.6; }', 'opacityHack', 'a hack for op', 'css'),
(2, 'Marta', 'selector { code }', 'test snippet 2', 'test snippet 2', 'css');

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(1500) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`userId`, `userName`) VALUES
(6, 'mania'),
(7, 'Marta');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
