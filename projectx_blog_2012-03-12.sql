-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 12 mars 2012 kl 12:21
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
-- Tabellstruktur `blogg`
--

CREATE TABLE IF NOT EXISTS `blogg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `content` varchar(4000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumpning av Data i tabell `blogg`
--

INSERT INTO `blogg` (`id`, `title`, `content`, `date`, `user_id`) VALUES
(35, 'En title', '<p><span style="font-size: small;"><strong>En rubrik</strong></span></p>\r\n<p><span style="font-size: small;"><span style="font-size: x-small;">Skriver lite vanlig text utan stilning med storlek 10 ist&auml;llet f&ouml;r 12.</span></span></p>', '2012-03-12 11:20:27', 26);

-- --------------------------------------------------------

--
-- Tabellstruktur `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `snippet_id` int(11) NOT NULL,
  `comment` varchar(1500) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumpning av Data i tabell `comment`
--

INSERT INTO `comment` (`id`, `snippet_id`, `comment`, `user_id`) VALUES
(2, 33, 'Another Comment', 18),
(3, 13, 'asdasdasd asd', 18),
(4, 54, 'asdasdasdasd', 18),
(5, 55, 'asdasdasdaaaaaaaaaaaaa', 24),
(8, 56, 'asdasd', 25);

-- --------------------------------------------------------

--
-- Tabellstruktur `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `ratingId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `snippetId` int(11) NOT NULL,
  `rating` bit(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ratingId`),
  UNIQUE KEY `userId` (`userId`,`snippetId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumpning av Data i tabell `rating`
--

INSERT INTO `rating` (`ratingId`, `userId`, `snippetId`, `rating`, `date`) VALUES
(1, 6, 13, b'1', '2012-01-22 19:01:14'),
(36, 6, 33, b'1', '2012-01-25 13:05:59'),
(46, 6, 45, b'1', '2012-01-31 17:48:50'),
(47, 18, 14, b'1', '2012-01-31 18:16:50'),
(49, 18, 13, b'1', '2012-01-31 18:23:33'),
(50, 18, 51, b'1', '2012-01-31 19:44:32'),
(52, 24, 55, b'1', '2012-02-05 15:29:00'),
(53, 24, 13, b'1', '2012-02-05 15:29:09'),
(54, 25, 56, b'1', '2012-02-05 15:33:32'),
(55, 25, 33, b'1', '2012-02-05 15:33:44'),
(56, 18, 53, b'1', '2012-02-05 17:59:56'),
(57, 18, 33, b'1', '2012-02-05 18:00:04');

-- --------------------------------------------------------

--
-- Tabellstruktur `snippet`
--

CREATE TABLE IF NOT EXISTS `snippet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) NOT NULL,
  `code` varchar(2500) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `language` varchar(25) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `description` (`description`),
  FULLTEXT KEY `language` (`language`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumpning av Data i tabell `snippet`
--

INSERT INTO `snippet` (`id`, `user_id`, `code`, `title`, `description`, `language`, `created`, `updated`) VALUES
(13, 6, '<?php \r\n# Start a session \r\nsession_start(); \r\n# Check if a user is logged in \r\nfunction isLogged(){ \r\n    if($_SESSION[''logged'']){ # When logged in this variable is set to TRUE \r\n        return TRUE; \r\n    }else{ \r\n        return FALSE; \r\n    } \r\n} \r\n\r\n# Log a user Out \r\nfunction logOut(){ \r\n    $_SESSION = array(); \r\n    if (isset($_COOKIE[session_name()])) { \r\n        setcookie(session_name(), '''', time()-42000, ''/''); \r\n    } \r\n    session_destroy(); \r\n} \r\n\r\n# Session Logout after in activity \r\nfunction sessionX(){ \r\n    $logLength = 1800; # time in seconds :: 1800 = 30 minutes \r\n    $ctime = strtotime("now"); # Create a time from a string \r\n    # If no session time is created, create one \r\n    if(!isset($_SESSION[''sessionX''])){  \r\n        # create session time \r\n        $_SESSION[''sessionX''] = $ctime;  \r\n    }else{ \r\n        # Check if they have exceded the time limit of inactivity \r\n        if(((strtotime("now") - $_SESSION[''sessionX'']) > $logLength) && isLogged()){ \r\n            # If exceded the time, log the user out \r\n            logOut(); \r\n            # Redirect to login page to log back in \r\n            header("Location: /login.php"); \r\n            exit; \r\n        }else{ \r\n            # If they have not exceded the time limit of inactivity, keep them logged in \r\n            $_SESSION[''sessionX''] = $ctime; \r\n        } \r\n    } \r\n} \r\n# Run Session logout check \r\nsessionX(); \r\n?>', 'php snippetenenenenenene', 'en php snippet', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 6, 'public class MyClass : IDisposable\r\n{\r\n   public event EventHandler Disposing;	 \r\n \r\n   public void Dispose()\r\n   {\r\n      // release any resources here\r\n      if (Disposing != null)\r\n      { \r\n         // someone is subscribed, throw event\r\n         Disposing (this, new EventArgs());\r\n      }\r\n   }\r\n \r\n   public static void Main( )\r\n   {\r\n      using (MyClass myClass = new MyClass ())\r\n      {\r\n         // subscribe to event with anonymous delegate\r\n         myClass.Disposing += delegate \r\n            { Console.WriteLine ("Disposing!"); };\r\n      }\r\n   }\r\n}', 'php a snippet', 'en csharp snippet', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 6, 'sss', 'sss', 'sss', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 6, 'public class MyClass : IDisposable\r\n{\r\n   public event EventHandler Disposing;	 \r\n \r\n   public void Dispose()\r\n   {\r\n      // release any resources here\r\n      if (Disposing != null)\r\n      { \r\n         // someone is subscribed, throw event\r\n         Disposing (this, new EventArgs());\r\n      }\r\n   }\r\n \r\n   public static void Main( )\r\n   {\r\n      using (MyClass myClass = new MyClass ())\r\n      {\r\n         // subscribe to event with anonymous delegate\r\n         myClass.Disposing += delegate \r\n            { Console.WriteLine ("Disposing!"); };\r\n      }\r\n   }\r\n}', 'test', 'testar', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 6, 'public class MyClass : IDisposable\r\n{\r\n   public event EventHandler Disposing;	 \r\n \r\n   public void Dispose()\r\n   {\r\n      // release any resources here\r\n      if (Disposing != null)\r\n      { \r\n         // someone is subscribed, throw event\r\n         Disposing (this, new EventArgs());\r\n      }\r\n   }\r\n \r\n   public static void Main( )\r\n   {\r\n      using (MyClass myClass = new MyClass ())\r\n      {\r\n         // subscribe to event with anonymous delegate\r\n         myClass.Disposing += delegate \r\n            { Console.WriteLine ("Disposing!"); };\r\n      }\r\n   }\r\n}', 'as', 'dsa', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 6, '<?php\r\nrequire_once dirname(__FILE__) . ''/simpletest/autorun.php'';\r\n\r\n/**\r\n * Runs all tests\r\n */\r\nclass AllTests extends TestSuite\r\n{\r\n    function __construct()\r\n    {\r\n        parent::__construct();\r\n        $this->addFile(dirname(__FILE__) . ''/SnippetHandlerTest.php'');\r\n        $this->addFile(dirname(__FILE__) . ''/CommentTest.php'');\r\n        $this->addFile(dirname(__FILE__) . ''/FunctionsTest.php'');\r\n        $this->addFile(dirname(__FILE__) . ''/SnippetTest.php'');\r\n    }\r\n\r\n}\r\n', 'asasd', 'asdasd', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 18, 'jeh jherj hjkahr aer', 'en snippet', 'en snippet med snippets', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 18, 'asdasd', 'asdasd', 'asd', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 18, 'mah snippet', 'asdasdasd', 's dasd asd asd asd ', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 6, 'whaaaaaat', 'phåp', 'daz description', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 18, 'cshark', 'php igen', 'en desc', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 24, 'asdasd', 'afasd', 'asdasd', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 25, '<?php\r\necho ''live account'';\r\n?>', 'hotmail snippet', 'testar på live account', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, 18, 'asdasdasd', 'asd', 'lkj', '1', '2012-02-14 14:17:55', '2012-02-14 13:17:55');

-- --------------------------------------------------------

--
-- Tabellstruktur `snippet_language`
--

CREATE TABLE IF NOT EXISTS `snippet_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumpning av Data i tabell `snippet_language`
--

INSERT INTO `snippet_language` (`id`, `language`) VALUES
(1, 'php'),
(2, 'csharp');

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1500) NOT NULL,
  `username` varchar(50) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `api` (`api_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `api_key`, `role_id`) VALUES
(18, 'Kim Åström', 'kim.astrom@gmail.com', '47aa5b43dbe963f4953aab6506370c33c2af73e1', 2),
(24, 'Kim Åström', 'null', 'b395f9aa932ee9a3e39b71eca3926138c75e464f', 1),
(25, 'Kim Åström', 'kim.90@hotmail.com', 'bafb4965aecff1f38b5bad68b1119cf1c3c21635', 3),
(26, 'Sebastian Lundin', 'selundin88@gmail.com', '0', 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `provider` varchar(20) NOT NULL,
  `identifier` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `email` (`email`),
  KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumpning av Data i tabell `user_auth`
--

INSERT INTO `user_auth` (`id`, `email`, `provider`, `identifier`, `user_id`) VALUES
(12, 'kim.astrom@gmail.com', 'Google', 'https://www.google.com/profiles/114454620248657786834', 18),
(18, 'null', 'Twitter', 'http://twitter.com/account/profile?user_id=226693886', 24),
(19, 'kim.90@hotmail.com', 'Windows Live', 'http://cid-aa4ae54b5aca67c3.spaces.live.com/', 25),
(20, 'selundin88@gmail.com', 'Google', 'https://www.google.com/profiles/113543705764680021668', 26);

-- --------------------------------------------------------

--
-- Tabellstruktur `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumpning av Data i tabell `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'member'),
(2, 'admin'),
(3, 'moderator');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
