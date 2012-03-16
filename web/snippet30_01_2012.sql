-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 30 jan 2012 kl 10:52
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
-- Tabellstruktur `snippet`
--

CREATE TABLE IF NOT EXISTS `snippet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `code` varchar(2500) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `language` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `description` (`description`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `full` (`code`,`title`,`description`),
  FULLTEXT KEY `desc_title` (`description`,`title`),
  FULLTEXT KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumpning av Data i tabell `snippet`
--

INSERT INTO `snippet` (`id`, `author`, `code`, `title`, `description`, `language`, `created`, `updated`) VALUES
(36, 'kimsan', 'public class MyClass : IDisposable\r\n{\r\n   public event EventHandler Disposing;	 \r\n \r\n   public void Dispose()\r\n   {\r\n      // release any resources here\r\n      if (Disposing != null)\r\n      { \r\n         // someone is subscribed, throw event\r\n         Disposing (this, new EventArgs());\r\n      }\r\n   }\r\n \r\n   public static void Main( )\r\n   {\r\n      using (MyClass myClass = new MyClass ())\r\n      {\r\n         // subscribe to event with anonymous delegate\r\n         myClass.Disposing += delegate \r\n            { Console.WriteLine ("Disposing!"); };\r\n      }\r\n   }\r\n}', 'as', 'dsa', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'kimsan', '<?php\r\nrequire_once dirname(__FILE__) . ''/simpletest/autorun.php'';\r\n\r\n/**\r\n * Runs all tests\r\n */\r\nclass AllTests extends TestSuite\r\n{\r\n    function __construct()\r\n    {\r\n        parent::__construct();\r\n        $this->addFile(dirname(__FILE__) . ''/SnippetHandlerTest.php'');\r\n        $this->addFile(dirname(__FILE__) . ''/CommentTest.php'');\r\n        $this->addFile(dirname(__FILE__) . ''/FunctionsTest.php'');\r\n        $this->addFile(dirname(__FILE__) . ''/SnippetTest.php'');\r\n    }\r\n\r\n}\r\n', 'asasd', 'asdasd', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'kimsan', 'public class MyClass : IDisposable\r\n{\r\n   public event EventHandler Disposing;	 \r\n \r\n   public void Dispose()\r\n   {\r\n      // release any resources here\r\n      if (Disposing != null)\r\n      { \r\n         // someone is subscribed, throw event\r\n         Disposing (this, new EventArgs());\r\n      }\r\n   }\r\n \r\n   public static void Main( )\r\n   {\r\n      using (MyClass myClass = new MyClass ())\r\n      {\r\n         // subscribe to event with anonymous delegate\r\n         myClass.Disposing += delegate \r\n            { Console.WriteLine ("Disposing!"); };\r\n      }\r\n   }\r\n}', 'test', 'testar', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'kimsan', '<?php \r\n# Start a session \r\nsession_start(); \r\n# Check if a user is logged in \r\nfunction isLogged(){ \r\n    if($_SESSION[''logged'']){ # When logged in this variable is set to TRUE \r\n        return TRUE; \r\n    }else{ \r\n        return FALSE; \r\n    } \r\n} \r\n\r\n# Log a user Out \r\nfunction logOut(){ \r\n    $_SESSION = array(); \r\n    if (isset($_COOKIE[session_name()])) { \r\n        setcookie(session_name(), '''', time()-42000, ''/''); \r\n    } \r\n    session_destroy(); \r\n} \r\n\r\n# Session Logout after in activity \r\nfunction sessionX(){ \r\n    $logLength = 1800; # time in seconds :: 1800 = 30 minutes \r\n    $ctime = strtotime("now"); # Create a time from a string \r\n    # If no session time is created, create one \r\n    if(!isset($_SESSION[''sessionX''])){  \r\n        # create session time \r\n        $_SESSION[''sessionX''] = $ctime;  \r\n    }else{ \r\n        # Check if they have exceded the time limit of inactivity \r\n        if(((strtotime("now") - $_SESSION[''sessionX'']) > $logLength) && isLogged()){ \r\n            # If exceded the time, log the user out \r\n            logOut(); \r\n            # Redirect to login page to log back in \r\n            header("Location: /login.php"); \r\n            exit; \r\n        }else{ \r\n            # If they have not exceded the time limit of inactivity, keep them logged in \r\n            $_SESSION[''sessionX''] = $ctime; \r\n        } \r\n    } \r\n} \r\n# Run Session logout check \r\nsessionX(); \r\n?>', 'php', 'en php snippet', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'kimsan', 'public class MyClass : IDisposable\r\n{\r\n   public event EventHandler Disposing;	 \r\n \r\n   public void Dispose()\r\n   {\r\n      // release any resources here\r\n      if (Disposing != null)\r\n      { \r\n         // someone is subscribed, throw event\r\n         Disposing (this, new EventArgs());\r\n      }\r\n   }\r\n \r\n   public static void Main( )\r\n   {\r\n      using (MyClass myClass = new MyClass ())\r\n      {\r\n         // subscribe to event with anonymous delegate\r\n         myClass.Disposing += delegate \r\n            { Console.WriteLine ("Disposing!"); };\r\n      }\r\n   }\r\n}', 'csharp', 'en csharp snippet', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'kimsan', 'fghnd', 'Moja mamma', 'a wlasnie ze moja mamma jest lepsza', 2, '2012-01-30 10:38:46', '2012-01-30 09:39:56');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
