-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 21, 2011 at 01:21 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `social`
--
CREATE DATABASE `social` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `social`;

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 86),
(2, 1, NULL, NULL, 'Pages', 2, 15),
(3, 2, NULL, NULL, 'display', 3, 4),
(4, 2, NULL, NULL, 'add', 5, 6),
(5, 2, NULL, NULL, 'edit', 7, 8),
(6, 2, NULL, NULL, 'index', 9, 10),
(7, 2, NULL, NULL, 'view', 11, 12),
(8, 2, NULL, NULL, 'delete', 13, 14),
(9, 1, NULL, NULL, 'Albums', 16, 37),
(10, 9, NULL, NULL, 'index', 17, 18),
(11, 9, NULL, NULL, 'view', 19, 20),
(12, 9, NULL, NULL, 'add', 21, 22),
(13, 9, NULL, NULL, 'edit', 23, 24),
(14, 9, NULL, NULL, 'delete', 25, 26),
(15, 9, NULL, NULL, 'admin_index', 27, 28),
(16, 9, NULL, NULL, 'admin_view', 29, 30),
(17, 9, NULL, NULL, 'admin_add', 31, 32),
(18, 9, NULL, NULL, 'admin_edit', 33, 34),
(19, 9, NULL, NULL, 'admin_delete', 35, 36),
(20, 1, NULL, NULL, 'Groups', 38, 59),
(21, 20, NULL, NULL, 'index', 39, 40),
(22, 20, NULL, NULL, 'view', 41, 42),
(23, 20, NULL, NULL, 'add', 43, 44),
(24, 20, NULL, NULL, 'edit', 45, 46),
(25, 20, NULL, NULL, 'delete', 47, 48),
(26, 20, NULL, NULL, 'admin_index', 49, 50),
(27, 20, NULL, NULL, 'admin_view', 51, 52),
(28, 20, NULL, NULL, 'admin_add', 53, 54),
(29, 20, NULL, NULL, 'admin_edit', 55, 56),
(30, 20, NULL, NULL, 'admin_delete', 57, 58),
(31, 1, NULL, NULL, 'Users', 60, 85),
(32, 31, NULL, NULL, 'login', 61, 62),
(33, 31, NULL, NULL, 'logout', 63, 64),
(34, 31, NULL, NULL, 'index', 65, 66),
(35, 31, NULL, NULL, 'view', 67, 68),
(36, 31, NULL, NULL, 'add', 69, 70),
(37, 31, NULL, NULL, 'edit', 71, 72),
(38, 31, NULL, NULL, 'delete', 73, 74),
(39, 31, NULL, NULL, 'admin_index', 75, 76),
(40, 31, NULL, NULL, 'admin_view', 77, 78),
(41, 31, NULL, NULL, 'admin_add', 79, 80),
(42, 31, NULL, NULL, 'admin_edit', 81, 82),
(43, 31, NULL, NULL, 'admin_delete', 83, 84);

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `name`, `description`, `user_id`, `status`, `created`, `modified`) VALUES
(5, 'albumC', '', 1, 2, '2011-04-09 21:22:21', '2011-04-29 15:55:53'),
(2, 'profile pic', '', 1, 0, '2011-04-06 23:30:31', '2011-04-06 23:30:31'),
(3, 'albumA', 'test album', 1, 1, '2011-04-09 20:16:04', '2011-04-09 20:16:04'),
(4, 'albumB', 'testing', 1, 0, '2011-04-09 20:25:10', '2011-04-09 20:25:10'),
(6, '', '', 0, 1, '2011-04-29 14:55:28', '2011-04-29 14:55:28'),
(7, '', '', 0, 1, '2011-04-29 14:56:29', '2011-04-29 14:56:29');

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Group', 1, NULL, 1, 4),
(2, NULL, 'Group', 2, NULL, 5, 40),
(3, NULL, 'Group', 3, NULL, 41, 48),
(4, 1, 'User', 1, NULL, 2, 3),
(5, 2, 'User', 2, NULL, 6, 7),
(6, 2, 'User', 3, NULL, 8, 9),
(7, 3, 'User', 4, NULL, 46, 47),
(8, 2, 'User', 5, NULL, 10, 11),
(9, 2, 'User', 6, NULL, 12, 13),
(10, 2, 'User', 7, NULL, 14, 15),
(11, 2, 'User', 8, NULL, 16, 17),
(12, 2, 'User', 9, NULL, 18, 19),
(13, 2, 'User', 10, NULL, 20, 21),
(14, 2, 'User', 11, NULL, 22, 23),
(15, 2, 'User', 12, NULL, 24, 25),
(16, 2, 'User', 13, NULL, 26, 27),
(17, 2, 'User', 14, NULL, 28, 29),
(18, 2, 'User', 15, NULL, 30, 31),
(19, 2, 'User', 16, NULL, 32, 33),
(20, 2, 'User', 17, NULL, 34, 35),
(21, 2, 'User', 18, NULL, 36, 37),
(22, 2, 'User', 19, NULL, 38, 39),
(23, 3, 'User', 20, NULL, 42, 43),
(24, NULL, 'User', 21, NULL, 49, 50),
(25, 3, 'User', 22, NULL, 44, 45);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 2, 1, '1', '1', '1', '1'),
(3, 3, 1, '-1', '-1', '-1', '-1'),
(4, 3, 37, '1', '1', '1', '1'),
(5, 3, 9, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `text`, `user_id`, `type`, `parent_id`, `status`, `created`, `modified`) VALUES
(1, 'How''s everyone?', 1, '100', 36, 2, '2011-04-26 22:26:48', '2011-04-26 22:26:48'),
(2, 'is there anyone online??', 1, '101', 5, 2, '2011-04-26 22:42:03', '2011-04-26 22:42:03'),
(4, 'hi me back', 1, '101', 4, 2, '2011-04-27 00:31:43', '2011-04-27 00:31:43'),
(5, 'blank?', 1, '101', 3, 1, '2011-04-27 21:56:15', '2011-04-27 21:56:15'),
(6, 'Lionel Messi is the best soccer player', 1, '100', 36, 1, '2011-04-27 23:02:26', '2011-04-27 23:02:26'),
(7, 'thank you adding as friend', 20, '101', 2, 1, '2011-05-11 23:54:49', '2011-05-11 23:54:49'),
(8, 'hmph', 1, '101', 5, 1, '2011-05-21 12:48:44', '2011-05-21 12:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modifed` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user1_id`, `user2_id`, `created`, `modifed`) VALUES
(1, 1, 20, '2011-05-09 22:11:37', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'administrators', '2011-03-19 15:41:44', '2011-03-19 15:41:44'),
(2, 'managers', '2011-03-19 15:42:09', '2011-03-19 15:42:09'),
(3, 'users', '2011-03-19 15:42:15', '2011-03-19 15:42:15');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` text NOT NULL,
  `path` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `name`, `album_id`, `user_id`, `filename`, `path`, `status`, `created`, `modified`) VALUES
(1, '', 2, 1, 'img/users/1/2011-04-06-234735cake.icon.gif', 'img/users/1/', 0, '2011-04-06 23:47:35', '2011-04-06 23:47:35'),
(2, '', 2, 1, 'img/users/1/cake.power.gif', 'img/users/1/', 0, '2011-04-06 23:53:34', '2011-04-06 23:53:34'),
(3, '', 2, 1, 'img/users/1/2011-04-06-235401cake.power.gif', 'img/users/1/', 0, '2011-04-06 23:54:01', '2011-04-06 23:54:01'),
(4, '', 2, 1, 'img/users/1/2011-04-06-235741cake.power.gif', 'img/users/1/', 0, '2011-04-06 23:57:41', '2011-04-06 23:57:41'),
(5, '', 2, 1, 'img/users/1/IMG_20110313_125308.jpg', 'img/users/1/', 0, '2011-04-07 23:16:49', '2011-04-07 23:16:49'),
(6, '', 2, 1, 'img/users/1/IMG_20110313_125455.jpg', 'img/users/1/', 0, '2011-04-07 23:17:57', '2011-04-07 23:17:57'),
(7, '', 2, 1, 'img/users/1/2011-04-07-232159IMG_20110313_125455.jpg', 'img/users/1/', 0, '2011-04-07 23:21:59', '2011-04-07 23:21:59'),
(8, '', 2, 1, 'img/users/1/IMG_20110313_125455.jpg', 'img/users/1/', 0, '2011-04-07 23:35:03', '2011-04-07 23:35:03'),
(9, '', 2, 1, 'img/users/1/IMG_20110313_125308.jpg', 'img/users/1/', 0, '2011-04-07 23:37:53', '2011-04-07 23:37:53'),
(10, '', 2, 1, 'img/users/1/2011-04-07-233812IMG_20110313_125308.jpg', 'img/users/1/', 0, '2011-04-07 23:38:12', '2011-04-07 23:38:12'),
(11, '', 2, 1, 'img/users/1/2011-04-07-234021IMG_20110313_125308.jpg', 'img/users/1/', 0, '2011-04-07 23:40:22', '2011-04-07 23:40:22'),
(12, '', 2, 1, 'img/users/1/2011-04-07-234424IMG_20110313_125308.jpg', 'img/users/1/', 0, '2011-04-07 23:44:24', '2011-04-07 23:44:24'),
(13, '', 2, 1, 'img/users/1/Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-04-07 23:49:16', '2011-04-07 23:49:16'),
(14, '', 2, 1, 'img/users/1/2011-04-07-235012Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-04-07 23:50:12', '2011-04-07 23:50:12'),
(15, '', 2, 1, 'img/users/1/2011-04-07-235046Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-04-07 23:50:46', '2011-04-07 23:50:46'),
(16, '', 2, 1, 'img/users/1/2011-04-07-235505Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-04-07 23:55:05', '2011-04-07 23:55:05'),
(17, '', 2, 1, 'img/users/1/2011-04-07-235520Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-04-07 23:55:20', '2011-04-07 23:55:20'),
(18, '', 2, 1, 'img/users/1/IMG_20110313_125433.jpg', 'img/users/1/', 0, '2011-04-07 23:55:31', '2011-04-07 23:55:31'),
(19, '', 2, 1, 'img/users/1/IMG_20110313_125455.jpg', 'img/users/1/', 0, '2011-04-07 23:57:45', '2011-04-07 23:57:45'),
(20, '', 2, 1, 'img/users/1/IMG_20110313_125308.jpg', 'img/users/1/', 0, '2011-04-08 00:00:18', '2011-04-08 00:00:18'),
(21, '', 2, 1, 'img/users/1/2011-04-08-000026Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-04-08 00:00:26', '2011-04-08 00:00:26'),
(22, '', 2, 1, 'img/users/1/2011-04-08-000108IMG_20110313_125308.jpg', 'img/users/1/', 0, '2011-04-08 00:01:08', '2011-04-08 00:01:08'),
(23, '', 2, 1, 'img/users/1/2011-04-08-000114Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-04-08 00:01:15', '2011-04-08 00:01:15'),
(24, '', 2, 1, 'img/users/1/Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-04-08 00:01:36', '2011-04-08 00:01:36'),
(25, '', 2, 1, 'img/users/1/2011-04-09-162634Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-04-09 16:26:34', '2011-04-09 16:26:34'),
(26, '', 5, 1, 'img/albums/5/IMG_20110313_125308.jpg', 'img/albums/5/', 0, '2011-04-10 11:01:04', '2011-04-10 11:01:04'),
(27, '', 5, 1, 'img/albums/5/IMG_20110313_125308.jpg', 'img/albums/5/', 0, '2011-04-10 11:02:41', '2011-04-10 11:02:41'),
(28, '', 5, 1, 'img/albums/5/2011-04-10-110346IMG_20110313_125308.jpg', 'img/albums/5/', 0, '2011-04-10 11:03:46', '2011-04-10 11:03:46'),
(29, '', 5, 1, 'img/albums/5/IMG_20110313_125308.jpg', 'img/albums/5/', 0, '2011-04-10 11:04:11', '2011-04-10 11:04:11'),
(30, '', 5, 1, 'img/albums/5/IMG_20110313_125308.jpg', 'img/albums/5/', 0, '2011-04-10 11:05:01', '2011-04-10 11:05:01'),
(31, '', 5, 1, 'img/albums/5/2011-04-10-110615IMG_20110313_125308.jpg', 'img/albums/5/', 0, '2011-04-10 11:06:15', '2011-04-10 11:06:15'),
(32, '', 5, 1, 'img/albums/5/IMG_20110313_125308.jpg', 'img/albums/5/', 0, '2011-04-10 11:09:30', '2011-04-10 11:09:30'),
(33, '', 2, 1, 'img/albums/2/banner_1.jpg', 'img/albums/2/', 1, '2011-04-16 00:18:30', '2011-04-16 00:18:30'),
(34, '', 2, 1, 'img/albums/2/dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/albums/2/', 1, '2011-04-16 00:18:30', '2011-04-16 00:18:30'),
(35, '', 2, 1, 'img/albums/2/howe_n8w00s9_006_ptblk-1.jpg', 'img/albums/2/', 2, '2011-04-16 00:20:15', '2011-05-08 13:09:38'),
(36, '', 2, 1, 'img/albums/2/Lionel-Messi-Biography.jpg', 'img/albums/2/', 1, '2011-04-16 00:51:20', '2011-04-16 00:51:20'),
(37, '', 2, 1, 'img/albums/2/howe_n8d015w_490_artv-1.jpeg', 'img/albums/2/', 1, '2011-04-16 00:51:20', '2011-04-16 00:51:20'),
(38, '', 2, 1, 'img/albums/2/2011-04-16-005120howe_n8w00s9_006_ptblk-1.jpg', 'img/albums/2/', 1, '2011-04-16 00:51:20', '2011-04-29 15:44:53'),
(39, '', 2, 1, 'img/users/1/dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-17 10:16:58', '2011-04-17 10:16:58'),
(40, '', 2, 1, 'img/users/1/2011-04-17-101743dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-17 10:17:43', '2011-04-17 10:17:43'),
(41, '', 2, 1, 'img/users/1/2011-04-17-101800dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-17 10:18:00', '2011-04-17 10:18:00'),
(42, '', 2, 1, 'img/users/1/2011-04-17-101843dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-17 10:18:43', '2011-04-17 10:18:43'),
(43, '', 2, 1, 'img/users/1/2011-04-25-215030dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-25 21:50:31', '2011-04-25 21:50:31'),
(44, '', 2, 1, 'img/users/1/2011-04-25-215100dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-25 21:51:00', '2011-04-25 21:51:00'),
(45, '', 2, 1, 'img/users/1/2011-04-25-215602dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-25 21:56:02', '2011-04-25 21:56:02'),
(46, '', 2, 1, 'img/users/1/2011-04-25-215700dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-25 21:57:00', '2011-04-25 21:57:00'),
(47, '', 2, 1, 'img/users/1/2011-04-25-215906dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-25 21:59:07', '2011-04-25 21:59:07'),
(48, '', 3, 1, 'img/albums/3/objects-book-object_~u12105742.jpg', 'img/albums/3/', 2, '2011-04-29 12:31:23', '2011-04-29 14:51:23'),
(49, '', 2, 1, 'img/users/1/2011-04-30-234120dc_dcgtl_200w_ss11_rgpld-1.jpg', 'img/users/1/', 0, '2011-04-30 23:41:20', '2011-04-30 23:41:20'),
(50, '', 3, 1, 'img/albums/3/tc.jpeg', 'img/albums/3/', 1, '2011-05-08 12:57:23', '2011-05-08 12:57:23'),
(51, '', 2, 1, 'img/users/1/2011-05-21-124615Lionel-Messi-Biography.jpg', 'img/users/1/', 0, '2011-05-21 12:46:15', '2011-05-21 12:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `master_id` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `text`, `user_id`, `status`, `created`, `modified`) VALUES
(1, 'adfasf', 1, 2, '2011-04-23 11:21:05', '2011-04-23 11:21:05'),
(2, 'Hi Everyone', 1, 1, '2011-04-23 11:21:20', '2011-04-23 11:21:20'),
(3, '', 1, 2, '2011-04-23 11:21:28', '2011-04-23 11:21:28'),
(4, 'hi', 1, 1, '2011-04-26 21:34:44', '2011-04-26 21:34:44'),
(5, 'says hi to everyone', 1, 1, '2011-04-26 21:37:26', '2011-04-26 21:37:26'),
(6, 'Hi everyone', 20, 1, '2011-05-11 23:54:19', '2011-05-11 23:54:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `dob` date NOT NULL,
  `avatar_id` int(11) NOT NULL,
  `country` varchar(2) NOT NULL,
  `relationship_status_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `last_login_ip` varchar(24) NOT NULL,
  `last_login_time` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `name`, `sex`, `dob`, `avatar_id`, `country`, `relationship_status_id`, `group_id`, `last_login_ip`, `last_login_time`, `status`, `hits`, `created`, `modified`) VALUES
(1, 'acidru5h@gmail.com', 'admin', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'System Admin', 0, '1991-03-19', 51, 'SG', 3, 1, '127.0.0.1', '2011-05-21 12:36:04', 11, 381, '2011-03-19 15:45:56', '2011-05-21 12:46:15'),
(2, 'user1@test.com', 'userone', 'fb764566b907064ed3e9fc238a1cd94d8786c721', 'user one', 0, '2011-03-24', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-24 23:49:36', '2011-03-24 23:49:36'),
(3, 'user2@test.com', 'user2', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 2', 1, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:14:36', '2011-03-25 21:14:36'),
(4, 'user3@test.com', 'user3', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 3', 1, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:15:46', '2011-05-11 23:52:11'),
(5, 'user4@test.com', 'user 4', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 4', 1, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:19:11', '2011-03-25 21:19:11'),
(6, 'user5@test.com', 'user 5', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 5', 1, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:21:03', '2011-03-25 21:21:03'),
(7, 'user6@test.com', 'user 6', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 6', 1, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:22:38', '2011-03-25 21:22:38'),
(8, 'user7@test.com', 'user 7', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 7', 1, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:25:41', '2011-03-25 21:25:41'),
(9, 'user8@test.com', 'user 8', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 8', 1, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:27:18', '2011-03-25 21:27:18'),
(10, 'user9@test.com', 'user 9', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 9', 0, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:32:07', '2011-03-25 21:32:07'),
(11, 'user10@test.com', 'user 10', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 10', 0, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:35:08', '2011-03-25 21:35:08'),
(12, 'user11@test.com', 'user 11', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 11', 0, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 21:41:28', '2011-03-25 21:41:28'),
(13, 'user12@test.com', 'user 12', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 12', 1, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-03-25 22:16:00', '2011-03-25 22:16:00'),
(14, 'mytester2010@gmail.com', 'testaccount1', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'test account', 0, '2011-03-25', 0, '', 0, 3, '127.0.0.1', '2011-04-30 17:33:07', 11, 11, '2011-03-25 23:14:55', '2011-04-30 17:33:07'),
(15, 'user13@test.com', 'user13', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user 13', 0, '2011-04-30', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-04-30 17:53:36', '2011-04-30 17:53:36'),
(16, 'user14@test.com', 'user14', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user14', 1, '2011-04-30', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-04-30 17:58:24', '2011-04-30 17:58:24'),
(17, 'user15@test.com', 'user15', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user15', 0, '2011-04-30', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-04-30 18:00:13', '2011-04-30 18:00:13'),
(18, 'user16@test.com', 'user16', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user16', 0, '2011-04-30', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-04-30 18:04:34', '2011-04-30 18:04:34'),
(19, 'user17@test.com', 'user17', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user17', 0, '2011-04-30', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-04-30 18:07:43', '2011-04-30 18:07:43'),
(20, 'user18@test.com', 'user18', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user18', 0, '1988-07-06', 0, 'SG', 0, 3, '127.0.0.1', '2011-05-11 23:52:39', 11, 104, '2011-04-30 18:20:21', '2011-05-11 23:52:39'),
(21, 'user18@test.com', '', '', 'user18', 0, '1988-07-03', 0, '', 0, 3, '', '0000-00-00 00:00:00', 0, 0, '2011-04-30 21:20:17', '2011-04-30 21:20:17'),
(22, 'user19@test.com', 'user19', '6f627d94044303eddea05b47fd7bfe250ae2f9c3', 'user19', 1, '2011-05-01', 0, '', 0, 3, '127.0.0.1', '0000-00-00 00:00:00', 10, 0, '2011-05-01 00:17:08', '2011-05-01 00:17:08');
