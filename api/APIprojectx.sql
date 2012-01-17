-- phpMyAdmin SQL Dump
-- version 3.3.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 17, 2012 at 05:29 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `projectx`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
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

--
-- Dumping data for table `comment`
--


-- --------------------------------------------------------

--
-- Table structure for table `rating`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`ratingId`, `userId`, `snippetId`, `rating`, `rating_created_date`) VALUES
(10, 2, 14, 4, '2012-01-12 11:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `snippet`
--

CREATE TABLE IF NOT EXISTS `snippet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `code` varchar(2500) CHARACTER SET latin1 NOT NULL,
  `title` varchar(50) CHARACTER SET latin1 NOT NULL,
  `description` varchar(500) CHARACTER SET latin1 NOT NULL,
  `languageId` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `languageId` (`languageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `snippet`
--

INSERT INTO `snippet` (`id`, `userId`, `code`, `title`, `description`, `languageId`, `date`) VALUES
(13, 1, '<?php \n# Start a session \nsession_start(); \n# Check if a user is logged in \nfunction isLogged(){ \n    if($_SESSION[''logged'']){ # When logged in this variable is set to TRUE \n        return TRUE; \n    }else{ \n        return FALSE; \n    } \n} \n\n# Log a user Out \nfunction logOut(){ \n    $_SESSION = array(); \n    if (isset($_COOKIE[session_name()])) { \n        setcookie(session_name(), '''', time()-42000, ''/''); \n    } \n    session_destroy(); \n} \n\n# Session Logout after in activity \nfunction sessionX(){ \n    $logLength = 1800; # time in seconds :: 1800 = 30 minutes \n    $ctime = strtotime("now"); # Create a time from a string \n    # If no session time is created, create one \n    if(!isset($_SESSION[''sessionX''])){  \n        # create session time \n        $_SESSION[''sessionX''] = $ctime;  \n    }else{ \n        # Check if they have exceded the time limit of inactivity \n        if(((strtotime("now") - $_SESSION[''sessionX'']) > $logLength) && isLogged()){ \n            # If exceded the time, log the user out \n            logOut(); \n            # Redirect to login page to log back in \n            header("Location: /login.php"); \n            exit; \n        }else{ \n            # If they have not exceded the time limit of inactivity, keep them logged in \n            $_SESSION[''sessionX''] = $ctime; \n        } \n    } \n} \n# Run Session logout check \nsessionX(); \n?>', 'php', 'en php snippet', 1, '2011-12-21'),
(14, 2, 'public class MyClass : IDisposable\n{\n   public event EventHandler Disposing;	 \n \n   public void Dispose()\n   {\n      // release any resources here\n      if (Disposing != null)\n      { \n         // someone is subscribed, throw event\n         Disposing (this, new EventArgs());\n      }\n   }\n \n   public static void Main( )\n   {\n      using (MyClass myClass = new MyClass ())\n      {\n         // subscribe to event with anonymous delegate\n         myClass.Disposing += delegate \n            { Console.WriteLine ("Disposing!"); };\n      }\n   }\n}', 'csharp', 'en csharp snippet', 2, '2011-12-20'),
(39, 5, 'echo "DjCool";', 'php echo', 'This snippet echoes out the coolest name', 1, '2012-01-06'),
(42, 5, 'echo "DjCool is the best DJ!";', 'The best Dj-script', 'A cool echo-script', 1, '2012-01-06'),
(44, 2, 'TestCoder', 'CoderTest', 'TestererCoderer', 1, '2012-01-16');

-- --------------------------------------------------------

--
-- Table structure for table `snippettag`
--

CREATE TABLE IF NOT EXISTS `snippettag` (
  `snippetId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL,
  PRIMARY KEY (`snippetId`,`tagId`),
  KEY `tagId` (`tagId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `snippettag`
--

INSERT INTO `snippettag` (`snippetId`, `tagId`) VALUES
(14, 1),
(44, 1),
(44, 2);

-- --------------------------------------------------------

--
-- Table structure for table `snippet_language`
--

CREATE TABLE IF NOT EXISTS `snippet_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `snippet_language`
--

INSERT INTO `snippet_language` (`id`, `language`) VALUES
(1, 'php'),
(2, 'csharp');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tagId` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`tagId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tagId`, `tag`) VALUES
(1, 'Php'),
(2, 'Csharp');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `email` varchar(70) CHARACTER SET latin1 NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 NOT NULL,
  `apikey` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `username`, `email`, `password`, `apikey`) VALUES
(1, 'Soem name', 'mail@mail.com', 'msdmsksdm', '23434jdkfdjfkfdslfds'),
(2, 'username', 'dsds.@mail.com', 'dsdfdfsdfdf', '5435gdfhghdghdf'),
(5, 'DjCool', 'djcool@djcool.dj', 'cool', 'awdkam235kmdam24');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`snippetId`) REFERENCES `snippet` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`snippetId`) REFERENCES `snippet` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `snippet`
--
ALTER TABLE `snippet`
  ADD CONSTRAINT `snippet_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `snippet_ibfk_2` FOREIGN KEY (`languageId`) REFERENCES `snippet_language` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `snippettag`
--
ALTER TABLE `snippettag`
  ADD CONSTRAINT `snippettag_ibfk_1` FOREIGN KEY (`snippetId`) REFERENCES `snippet` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `snippettag_ibfk_2` FOREIGN KEY (`tagId`) REFERENCES `tag` (`tagId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
