-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 06 mars 2012 kl 12:33
-- Serverversion: 5.5.9
-- PHP-version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `projectX`
--

-- --------------------------------------------------------

--
-- Struktur för tabell `blogg`
--

CREATE TABLE `blogg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Data i tabell `blogg`
--


-- --------------------------------------------------------

--
-- Struktur för tabell `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `snippet_id` int(11) NOT NULL,
  `comment` varchar(1500) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Data i tabell `comment`
--

INSERT INTO `comment` VALUES(2, 33, 'Another Comment', 18);
INSERT INTO `comment` VALUES(3, 13, 'asdasdasd asd', 18);
INSERT INTO `comment` VALUES(4, 54, 'asdasdasdasd', 18);
INSERT INTO `comment` VALUES(5, 55, 'asdasdasdaaaaaaaaaaaaa', 24);
INSERT INTO `comment` VALUES(8, 56, 'asdasd', 25);

-- --------------------------------------------------------

--
-- Struktur för tabell `rating`
--

CREATE TABLE `rating` (
  `ratingId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `snippetId` int(11) NOT NULL,
  `rating` bit(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ratingId`),
  UNIQUE KEY `userId` (`userId`,`snippetId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Data i tabell `rating`
--

INSERT INTO `rating` VALUES(1, 6, 13, '', '2012-01-22 20:01:14');
INSERT INTO `rating` VALUES(36, 6, 33, '', '2012-01-25 14:05:59');
INSERT INTO `rating` VALUES(46, 6, 45, '', '2012-01-31 18:48:50');
INSERT INTO `rating` VALUES(47, 18, 14, '', '2012-01-31 19:16:50');
INSERT INTO `rating` VALUES(49, 18, 13, '', '2012-01-31 19:23:33');
INSERT INTO `rating` VALUES(50, 18, 51, '', '2012-01-31 20:44:32');
INSERT INTO `rating` VALUES(52, 24, 55, '', '2012-02-05 16:29:00');
INSERT INTO `rating` VALUES(53, 24, 13, '', '2012-02-05 16:29:09');
INSERT INTO `rating` VALUES(54, 25, 56, '', '2012-02-05 16:33:32');
INSERT INTO `rating` VALUES(55, 25, 33, '', '2012-02-05 16:33:44');
INSERT INTO `rating` VALUES(56, 18, 53, '', '2012-02-05 18:59:56');
INSERT INTO `rating` VALUES(57, 18, 33, '', '2012-02-05 19:00:04');

-- --------------------------------------------------------

--
-- Struktur för tabell `snippet`
--

CREATE TABLE `snippet` (
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
-- Data i tabell `snippet`
--

INSERT INTO `snippet` VALUES(13, 6, '<?php \r\n# Start a session \r\nsession_start(); \r\n# Check if a user is logged in \r\nfunction isLogged(){ \r\n    if($_SESSION[''logged'']){ # When logged in this variable is set to TRUE \r\n        return TRUE; \r\n    }else{ \r\n        return FALSE; \r\n    } \r\n} \r\n\r\n# Log a user Out \r\nfunction logOut(){ \r\n    $_SESSION = array(); \r\n    if (isset($_COOKIE[session_name()])) { \r\n        setcookie(session_name(), '''', time()-42000, ''/''); \r\n    } \r\n    session_destroy(); \r\n} \r\n\r\n# Session Logout after in activity \r\nfunction sessionX(){ \r\n    $logLength = 1800; # time in seconds :: 1800 = 30 minutes \r\n    $ctime = strtotime("now"); # Create a time from a string \r\n    # If no session time is created, create one \r\n    if(!isset($_SESSION[''sessionX''])){  \r\n        # create session time \r\n        $_SESSION[''sessionX''] = $ctime;  \r\n    }else{ \r\n        # Check if they have exceded the time limit of inactivity \r\n        if(((strtotime("now") - $_SESSION[''sessionX'']) > $logLength) && isLogged()){ \r\n            # If exceded the time, log the user out \r\n            logOut(); \r\n            # Redirect to login page to log back in \r\n            header("Location: /login.php"); \r\n            exit; \r\n        }else{ \r\n            # If they have not exceded the time limit of inactivity, keep them logged in \r\n            $_SESSION[''sessionX''] = $ctime; \r\n        } \r\n    } \r\n} \r\n# Run Session logout check \r\nsessionX(); \r\n?>', 'php snippetenenenenenene', 'en php snippet', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(14, 6, 'public class MyClass : IDisposable\r\n{\r\n   public event EventHandler Disposing;	 \r\n \r\n   public void Dispose()\r\n   {\r\n      // release any resources here\r\n      if (Disposing != null)\r\n      { \r\n         // someone is subscribed, throw event\r\n         Disposing (this, new EventArgs());\r\n      }\r\n   }\r\n \r\n   public static void Main( )\r\n   {\r\n      using (MyClass myClass = new MyClass ())\r\n      {\r\n         // subscribe to event with anonymous delegate\r\n         myClass.Disposing += delegate \r\n            { Console.WriteLine ("Disposing!"); };\r\n      }\r\n   }\r\n}', 'php a snippet', 'en csharp snippet', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(33, 6, 'sss', 'sss', 'sss', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(35, 6, 'public class MyClass : IDisposable\r\n{\r\n   public event EventHandler Disposing;	 \r\n \r\n   public void Dispose()\r\n   {\r\n      // release any resources here\r\n      if (Disposing != null)\r\n      { \r\n         // someone is subscribed, throw event\r\n         Disposing (this, new EventArgs());\r\n      }\r\n   }\r\n \r\n   public static void Main( )\r\n   {\r\n      using (MyClass myClass = new MyClass ())\r\n      {\r\n         // subscribe to event with anonymous delegate\r\n         myClass.Disposing += delegate \r\n            { Console.WriteLine ("Disposing!"); };\r\n      }\r\n   }\r\n}', 'test', 'testar', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(36, 6, 'public class MyClass : IDisposable\r\n{\r\n   public event EventHandler Disposing;	 \r\n \r\n   public void Dispose()\r\n   {\r\n      // release any resources here\r\n      if (Disposing != null)\r\n      { \r\n         // someone is subscribed, throw event\r\n         Disposing (this, new EventArgs());\r\n      }\r\n   }\r\n \r\n   public static void Main( )\r\n   {\r\n      using (MyClass myClass = new MyClass ())\r\n      {\r\n         // subscribe to event with anonymous delegate\r\n         myClass.Disposing += delegate \r\n            { Console.WriteLine ("Disposing!"); };\r\n      }\r\n   }\r\n}', 'as', 'dsa', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(38, 6, '<?php\r\nrequire_once dirname(__FILE__) . ''/simpletest/autorun.php'';\r\n\r\n/**\r\n * Runs all tests\r\n */\r\nclass AllTests extends TestSuite\r\n{\r\n    function __construct()\r\n    {\r\n        parent::__construct();\r\n        $this->addFile(dirname(__FILE__) . ''/SnippetHandlerTest.php'');\r\n        $this->addFile(dirname(__FILE__) . ''/CommentTest.php'');\r\n        $this->addFile(dirname(__FILE__) . ''/FunctionsTest.php'');\r\n        $this->addFile(dirname(__FILE__) . ''/SnippetTest.php'');\r\n    }\r\n\r\n}\r\n', 'asasd', 'asdasd', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(53, 18, 'jeh jherj hjkahr aer', 'en snippet', 'en snippet med snippets', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(52, 18, 'asdasd', 'asdasd', 'asd', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(51, 18, 'mah snippet', 'asdasdasd', 's dasd asd asd asd ', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(49, 6, 'whaaaaaat', 'phåp', 'daz description', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(54, 18, 'cshark', 'php igen', 'en desc', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(55, 24, 'asdasd', 'afasd', 'asdasd', '2', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(56, 25, '<?php\r\necho ''live account'';\r\n?>', 'hotmail snippet', 'testar på live account', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `snippet` VALUES(78, 18, 'asdasdasd', 'asd', 'lkj', '1', '2012-02-14 14:17:55', '2012-02-14 14:17:55');

-- --------------------------------------------------------

--
-- Struktur för tabell `snippet_language`
--

CREATE TABLE `snippet_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Data i tabell `snippet_language`
--

INSERT INTO `snippet_language` VALUES(1, 'php');
INSERT INTO `snippet_language` VALUES(2, 'csharp');

-- --------------------------------------------------------

--
-- Struktur för tabell `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(1500) NOT NULL,
  `username` varchar(50) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `api` (`api_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Data i tabell `user`
--

INSERT INTO `user` VALUES(18, 'Kim Åström', 'kim.astrom@gmail.com', '47aa5b43dbe963f4953aab6506370c33c2af73e1', 2);
INSERT INTO `user` VALUES(24, 'Kim Åström', 'null', 'b395f9aa932ee9a3e39b71eca3926138c75e464f', 1);
INSERT INTO `user` VALUES(25, 'Kim Åström', 'kim.90@hotmail.com', 'bafb4965aecff1f38b5bad68b1119cf1c3c21635', 3);

-- --------------------------------------------------------

--
-- Struktur för tabell `user_auth`
--

CREATE TABLE `user_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `provider` varchar(20) NOT NULL,
  `identifier` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `email` (`email`),
  KEY `identifier` (`identifier`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Data i tabell `user_auth`
--

INSERT INTO `user_auth` VALUES(12, 'kim.astrom@gmail.com', 'Google', 'https://www.google.com/profiles/114454620248657786834', 18);
INSERT INTO `user_auth` VALUES(18, 'null', 'Twitter', 'http://twitter.com/account/profile?user_id=226693886', 24);

-- --------------------------------------------------------

--
-- Struktur för tabell `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Data i tabell `user_role`
--

INSERT INTO `user_role` VALUES(1, 'member');
INSERT INTO `user_role` VALUES(2, 'admin');
INSERT INTO `user_role` VALUES(3, 'moderator');