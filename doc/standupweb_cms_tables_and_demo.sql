-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2010 at 07:16 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `standupw_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `static_asset`
--

CREATE TABLE IF NOT EXISTS `static_asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `asset` varchar(50) DEFAULT NULL,
  `extension` varchar(50) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `current` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `static_asset`
--

INSERT INTO `static_asset` (`id`, `name`, `asset`, `extension`, `creation_date`, `current`) VALUES
(6, 'logo', 'logo.png', 'png', '2010-03-22 18:29:00', 0),
(7, 'logo', 'logo.png', 'png', '2010-03-22 18:57:34', 1),
(8, 'content-picture', 'tools-1.png', 'png', '2010-03-22 19:12:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `static_field`
--

CREATE TABLE IF NOT EXISTS `static_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `value` text CHARACTER SET utf8,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `current` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=143 ;

--
-- Dumping data for table `static_field`
--

INSERT INTO `static_field` (`id`, `name`, `value`, `creation_date`, `current`) VALUES
(132, 'title', 'Title+of+my+website', '2010-03-22 17:52:05', 0),
(133, 'listOfLinks', 'Here+is+an+updatable+list+of+links%3A', '2010-03-22 17:56:30', 1),
(134, 'listOfPictures', 'Here+is+an+updatable+list+of+pictures', '2010-03-22 17:59:24', 1),
(135, 'content-title', '%3CHeading+for+the+content+part%3E', '2010-03-22 18:00:25', 0),
(136, 'content-title', '-Heading+for+the+content+part-', '2010-03-22 18:00:48', 0),
(137, 'content-title', '%26lt%3BHeading+for+the+content+part%26gt%3B', '2010-03-22 18:03:11', 0),
(138, 'title', '%26lt%3Btitle+of+my+website%26gt%3B', '2010-03-22 18:03:24', 0),
(139, 'content-title', '%26lt%3Bheading+for+the+content+part%26gt%3B', '2010-03-22 18:03:36', 0),
(140, 'title', 'standupweb+CMS+sample+site', '2010-03-22 18:23:37', 1),
(141, 'content-title', 'Here+is+how+you+can+try+out+the+features%3A', '2010-03-22 18:24:08', 0),
(142, 'content-title', 'Try+it+out+now%21', '2010-03-22 19:15:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `structured_field`
--

CREATE TABLE IF NOT EXISTS `structured_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `structured_unit_id` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=145 ;

--
-- Dumping data for table `structured_field`
--

INSERT INTO `structured_field` (`id`, `structured_unit_id`, `rank`, `name`) VALUES
(135, 29, 1, 'janrain'),
(136, 29, 2, 'smashing+magazine'),
(137, 29, 3, 'dive+into+html5'),
(138, 29, 4, 'best+of+web+hosting'),
(139, 30, 1, 'bird'),
(140, 30, 2, 'paon'),
(141, 30, 3, 'balls'),
(142, 30, 4, 'colors'),
(143, 31, 1, 'content text'),
(144, 30, 5, 'notes');

-- --------------------------------------------------------

--
-- Table structure for table `structured_field_asset`
--

CREATE TABLE IF NOT EXISTS `structured_field_asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `asset` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `extension` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `structured_field_id` int(11) NOT NULL,
  `label` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `structured_field_asset`
--

INSERT INTO `structured_field_asset` (`id`, `name`, `asset`, `extension`, `structured_field_id`, `label`) VALUES
(43, 'bird', 'bird.jpg', 'jpg', 139, 'picture'),
(44, 'paon', 'paon.jpg', 'jpg', 140, 'picture'),
(45, 'balls', 'balls.jpg', 'jpg', 141, 'picture'),
(46, 'colors', 'colors.jpg', 'jpg', 142, 'picture'),
(47, 'notes', 'notes4.jpg', 'jpg', 144, 'picture');

-- --------------------------------------------------------

--
-- Table structure for table `structured_field_asset_label`
--

CREATE TABLE IF NOT EXISTS `structured_field_asset_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) DEFAULT NULL,
  `label` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `structured_field_asset_label`
--

INSERT INTO `structured_field_asset_label` (`id`, `unit_id`, `label`, `rank`) VALUES
(7, 30, 'picture', 1);

-- --------------------------------------------------------

--
-- Table structure for table `structured_field_value`
--

CREATE TABLE IF NOT EXISTS `structured_field_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `structured_field_id` int(11) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `value` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=195 ;

--
-- Dumping data for table `structured_field_value`
--

INSERT INTO `structured_field_value` (`id`, `structured_field_id`, `name`, `value`) VALUES
(186, 135, 'link url', 'http%3A%2F%2Fwww.janrain.com%2F'),
(187, 135, 'link label', 'janrain'),
(188, 136, 'link url', 'http%3A%2F%2Fwww.smashingmagazine.com'),
(189, 136, 'link label', 'smashing+magazine'),
(190, 137, 'link url', 'http%3A%2F%2Fdiveintohtml5.org%2F'),
(191, 137, 'link label', 'dive+into+html5'),
(192, 138, 'link url', 'http%3A%2F%2Fwww.web-hosting-top.com%2F'),
(193, 138, 'link label', 'best+of+web+hosting'),
(194, 143, 'piece of content', '-+Go+to+http%3A%2F%2Fstandupweb.net%2Fcms%2Fadmin%0D%3Cbr%2F%3E%0D%3Cbr%2F%3E-+Login+with+username+%26quot%3Btester%26quot%3B+and+password+%26quot%3Btester%26quot%3B%0D%3Cbr%2F%3E-+Then+click+on+the+%27edit%27+button%0D%3Cbr%2F%3E-+on+the+site%2C+a+couple+of+pens+appear%0D%3Cbr%2F%3E-+click+on+a+pen+to+edit+the+corresponding+section');

-- --------------------------------------------------------

--
-- Table structure for table `structured_field_value_label`
--

CREATE TABLE IF NOT EXISTS `structured_field_value_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) DEFAULT NULL,
  `label` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `structured_field_value_label`
--

INSERT INTO `structured_field_value_label` (`id`, `unit_id`, `label`, `type`, `rank`) VALUES
(36, 29, 'link url', 'text', 1),
(37, 29, 'link label', 'text', 2),
(38, 31, 'piece of content', 'textarea', 1),
(39, 32, 'footer link  URL', 'text', 1),
(40, 32, 'footer link label', 'text', 2);

-- --------------------------------------------------------

--
-- Table structure for table `structured_unit`
--

CREATE TABLE IF NOT EXISTS `structured_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `random` tinyint(1) DEFAULT NULL,
  `defaultFieldValue` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `structured_unit`
--

INSERT INTO `structured_unit` (`id`, `name`, `random`, `defaultFieldValue`) VALUES
(29, 'listOfLinks', 0, 'link'),
(30, 'listOfPictures', 0, 'picture'),
(31, 'listOfContents', 0, 'content text'),
(32, 'footerLinks', 0, 'footer link');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(3, 'stan', 'sw2007'),
(4, 'tester', 'tester');

-- --------------------------------------------------------

--
-- Table structure for table `view_url`
--

CREATE TABLE IF NOT EXISTS `view_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `url` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `view_url`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
