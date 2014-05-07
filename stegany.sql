-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2014 at 08:21 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stegany`
--

-- --------------------------------------------------------

--
-- Table structure for table `stegany_configuration`
--

CREATE TABLE IF NOT EXISTS `stegany_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `stegany_configuration`
--

INSERT INTO `stegany_configuration` (`id`, `name`, `value`) VALUES
(1, 'website_name', 'Stegany'),
(2, 'website_url', 'localhost/'),
(3, 'email', 'noreply@stegany.com'),
(4, 'activation', 'false'),
(5, 'resend_activation_threshold', '0'),
(6, 'language', 'models/languages/en.php'),
(7, 'template', 'models/site-templates/default.css');

-- --------------------------------------------------------

--
-- Table structure for table `stegany_images`
--

CREATE TABLE IF NOT EXISTS `stegany_images` (
  `imageid` int(11) NOT NULL AUTO_INCREMENT,
  `publickey` varchar(1500) NOT NULL,
  `userid` int(11) NOT NULL,
  `imagename` varchar(512) NOT NULL,
  `passphrase` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`imageid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stegany_pages`
--

CREATE TABLE IF NOT EXISTS `stegany_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `stegany_pages`
--

INSERT INTO `stegany_pages` (`id`, `page`, `private`) VALUES
(1, 'account.php', 1),
(2, 'activate-account.php', 0),
(3, 'admin_configuration.php', 1),
(4, 'admin_page.php', 1),
(5, 'admin_pages.php', 1),
(6, 'admin_permission.php', 1),
(7, 'admin_permissions.php', 1),
(8, 'admin_user.php', 1),
(9, 'admin_users.php', 1),
(10, 'forgot-password.php', 0),
(11, 'index.php', 0),
(12, 'left-nav.php', 0),
(13, 'login.php', 0),
(14, 'logout.php', 1),
(15, 'register.php', 0),
(16, 'resend-activation.php', 0),
(17, 'user_settings.php', 1),
(18, 'Encrypt.php', 0),
(19, 'index (2).php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stegany_permissions`
--

CREATE TABLE IF NOT EXISTS `stegany_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `stegany_permissions`
--

INSERT INTO `stegany_permissions` (`id`, `name`) VALUES
(1, 'New Member'),
(2, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `stegany_permission_page_matches`
--

CREATE TABLE IF NOT EXISTS `stegany_permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `stegany_permission_page_matches`
--

INSERT INTO `stegany_permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
(1, 1, 1),
(2, 1, 14),
(3, 1, 17),
(4, 2, 1),
(5, 2, 3),
(6, 2, 4),
(7, 2, 5),
(8, 2, 6),
(9, 2, 7),
(10, 2, 8),
(11, 2, 9),
(12, 2, 14),
(13, 2, 17);

-- --------------------------------------------------------

--
-- Table structure for table `stegany_users`
--

CREATE TABLE IF NOT EXISTS `stegany_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(150) NOT NULL,
  `activation_token` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `lost_password_request` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sign_up_stamp` int(11) NOT NULL,
  `last_sign_in_stamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `stegany_users`
--

INSERT INTO `stegany_users` (`id`, `user_name`, `display_name`, `password`, `email`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `sign_up_stamp`, `last_sign_in_stamp`) VALUES
(1, 'admin', 'admin', '21e45988d60177524e9de3f584e5d8ecc34067e59c4fbf05096d980a25775b86d', 'admin@stegany.com', 'ee33d78274a323deabdfc9abc1f03098', 1398835674, 0, 1, 'Admin', 1398835674, 1399389284);

-- --------------------------------------------------------

--
-- Table structure for table `stegany_user_permission_matches`
--

CREATE TABLE IF NOT EXISTS `stegany_user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `stegany_user_permission_matches`
--

INSERT INTO `stegany_user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
(1, 1, 2),
(2, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
