-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 14 feb 2012 kl 15:56
-- Serverversion: 5.5.16
-- PHP-version: 5.2.9

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
  `commentId` int(11) NOT NULL AUTO_INCREMENT,
  `snippetId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `comment` varchar(300) CHARACTER SET latin1 NOT NULL,
  `comment_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`commentId`),
  KEY `snippetId` (`snippetId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `ratingId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `snippetId` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `rating_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ratingId`),
  KEY `userId` (`userId`),
  KEY `snippetId` (`snippetId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `snippet`
--

CREATE TABLE IF NOT EXISTS `snippet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `code` varchar(2500) CHARACTER SET latin1 NOT NULL,
  `title` varchar(50) CHARACTER SET latin1 NOT NULL,
  `description` varchar(500) CHARACTER SET latin1 NOT NULL,
  `languageId` int(11) NOT NULL,
  `date` date NOT NULL,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `languageId` (`languageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- Dumpning av Data i tabell `snippet`
--

INSERT INTO `snippet` (`id`, `userId`, `code`, `title`, `description`, `languageId`, `date`, `updated`) VALUES
(13, 1, '<?php \n# Start a session \nsession_start(); \n# Check if a user is logged in \nfunction isLogged(){ \n    if($_SESSION[''logged'']){ # When logged in this variable is set to TRUE \n        return TRUE; \n    }else{ \n        return FALSE; \n    } \n} \n\n# Log a user Out \nfunction logOut(){ \n    $_SESSION = array(); \n    if (isset($_COOKIE[session_name()])) { \n        setcookie(session_name(), '''', time()-42000, ''/''); \n    } \n    session_destroy(); \n} \n\n# Session Logout after in activity \nfunction sessionX(){ \n    $logLength = 1800; # time in seconds :: 1800 = 30 minutes \n    $ctime = strtotime("now"); # Create a time from a string \n    # If no session time is created, create one \n    if(!isset($_SESSION[''sessionX''])){  \n        # create session time \n        $_SESSION[''sessionX''] = $ctime;  \n    }else{ \n        # Check if they have exceded the time limit of inactivity \n        if(((strtotime("now") - $_SESSION[''sessionX'']) > $logLength) && isLogged()){ \n            # If exceded the time, log the user out \n            logOut(); \n            # Redirect to login page to log back in \n            header("Location: /login.php"); \n            exit; \n        }else{ \n            # If they have not exceded the time limit of inactivity, keep them logged in \n            $_SESSION[''sessionX''] = $ctime; \n        } \n    } \n} \n# Run Session logout check \nsessionX(); \n?>', 'php', 'en php snippet', 1, '2011-12-21', '0000-00-00 00:00:00'),
(14, 2, 'public class MyClass : IDisposable\n{\n   public event EventHandler Disposing;	 \n \n   public void Dispose()\n   {\n      // release any resources here\n      if (Disposing != null)\n      { \n         // someone is subscribed, throw event\n         Disposing (this, new EventArgs());\n      }\n   }\n \n   public static void Main( )\n   {\n      using (MyClass myClass = new MyClass ())\n      {\n         // subscribe to event with anonymous delegate\n         myClass.Disposing += delegate \n            { Console.WriteLine ("Disposing!"); };\n      }\n   }\n}', 'csharp', 'en csharp snippet', 2, '2011-12-20', '0000-00-00 00:00:00'),
(42, 5, 'sddsdsds', 'KissochBajs4', 'Dromedarpuckel56', 2, '2012-01-06', '0000-00-00 00:00:00'),
(44, 2, 'sddsdsds', 'Bajsa', 'p-tag', 2, '2012-01-16', '0000-00-00 00:00:00'),
(74, 2, 'sddsdsds', 'U', 'p-tag', 2, '0000-00-00', '0000-00-00 00:00:00'),
(76, 2, 'Yo! Yo! Yo! Pants is my favourite', 'Yo! I need new pants!', 'Cool blue Pants', 2, '2012-02-14', '2012-02-14 14:35:56');

-- --------------------------------------------------------

--
-- Tabellstruktur `snippettag`
--

CREATE TABLE IF NOT EXISTS `snippettag` (
  `snippetId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL,
  PRIMARY KEY (`snippetId`,`tagId`),
  KEY `tagId` (`tagId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `snippettag`
--

INSERT INTO `snippettag` (`snippetId`, `tagId`) VALUES
(14, 1),
(44, 1),
(44, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `snippet_language`
--

CREATE TABLE IF NOT EXISTS `snippet_language` (
  `snippet_languageid` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`snippet_languageid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `snippet_language`
--

INSERT INTO `snippet_language` (`snippet_languageid`, `language`) VALUES
(1, 'php'),
(2, 'csharp');

-- --------------------------------------------------------

--
-- Tabellstruktur `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tagId` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`tagId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `tag`
--

INSERT INTO `tag` (`tagId`, `tag`) VALUES
(1, 'Php'),
(2, 'Csharp');

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `email` varchar(70) CHARACTER SET latin1 NOT NULL,
  `apikey` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `apikey` (`apikey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`userId`, `username`, `email`, `apikey`) VALUES
(1, 'Soem name', 'mail@mail.com', '23434jdkfdjfkfdslfds'),
(2, 'username', 'dsds.@mail.com', '5435gdfhghdghdf'),
(5, 'DjCool', 'djcool@djcool.dj', 'awdkam235kmdam24');

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`snippetId`) REFERENCES `snippet` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restriktioner för tabell `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`snippetId`) REFERENCES `snippet` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restriktioner för tabell `snippet`
--
ALTER TABLE `snippet`
  ADD CONSTRAINT `snippet_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `snippet_ibfk_2` FOREIGN KEY (`languageId`) REFERENCES `snippet_language` (`snippet_languageid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restriktioner för tabell `snippettag`
--
ALTER TABLE `snippettag`
  ADD CONSTRAINT `snippettag_ibfk_1` FOREIGN KEY (`snippetId`) REFERENCES `snippet` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `snippettag_ibfk_2` FOREIGN KEY (`tagId`) REFERENCES `tag` (`tagId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
