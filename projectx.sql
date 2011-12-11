-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Skapad: 11 dec 2011 kl 23:39
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=158 ;

--
-- Dumpning av Data i tabell `comment`
--

INSERT INTO `comment` (`snippetId`, `commentId`, `commentText`, `userId`) VALUES
(2, 140, 'yhjyu yjyj', 6),
(2, 141, 'och nu?', 6),
(2, 142, 'och nu?', 6),
(2, 143, 'vad gör vi nu då???,,', 6),
(8, 154, 'g', 6),
(8, 155, 'g', 6),
(33, 156, 'vcbvb', 6),
(33, 157, 'vcbvb', 6);

-- --------------------------------------------------------

--
-- Tabellstruktur `snippet`
--

CREATE TABLE IF NOT EXISTS `snippet` (
  `snippetId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `code` varchar(2500) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `desc` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `snippetLang` varchar(25) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`snippetId`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumpning av Data i tabell `snippet`
--

INSERT INTO `snippet` (`snippetId`, `userId`, `code`, `title`, `desc`, `snippetLang`) VALUES
(38, 6, 'kkl', 'Min snippet', 'snippet desc', 'snippet lang');

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
