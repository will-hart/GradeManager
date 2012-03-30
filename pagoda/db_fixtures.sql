-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2012 at 08:02 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `grades`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `users_id`, `title`, `created_on`, `modified_on`) VALUES
(1, 1, 'My First Year Level', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `coursework`
--

DROP TABLE IF EXISTS `coursework`;
CREATE TABLE IF NOT EXISTS `coursework` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) NOT NULL,
  `subject_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `status_id` int(11) NOT NULL,
  `notes` text,
  `score` int(3) DEFAULT NULL,
  `weighting` int(3) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `coursework`
--

INSERT INTO `coursework` (`id`, `users_id`, `subject_id`, `title`, `due_date`, `status_id`, `notes`, `score`, `weighting`, `deleted`, `created_on`, `modified_on`) VALUES
(19, 1, 10, 'Test 1', '2011-11-07', 7, '', 100, 5, 0, '2012-03-30 02:32:49', '2012-03-30 03:11:12'),
(20, 1, 10, 'Test 2', '2011-12-05', 7, '', 94, 5, 0, '2012-03-30 02:32:53', '2012-03-30 02:34:04'),
(21, 1, 10, 'Test 3', '2012-03-09', 7, '', 100, 5, 0, '2012-03-30 02:32:56', '2012-03-30 02:34:59'),
(22, 1, 10, 'Test 4', '2012-04-02', 2, '', 0, 5, 0, '2012-03-30 02:33:00', '2012-03-30 04:03:46'),
(23, 1, 10, 'Mathcad', '2012-03-19', 5, '', 0, 10, 0, '2012-03-30 02:33:04', '2012-03-30 02:35:49'),
(24, 1, 10, 'Exam', '2012-05-16', 1, '', 0, 70, 0, '2012-03-30 02:33:09', '2012-03-30 03:04:31'),
(25, 1, 11, 'Lab: Losses', '2011-10-21', 7, '', 75, 10, 0, '2012-03-30 02:38:26', '2012-03-30 03:10:56'),
(26, 1, 11, 'Lab: Flow', '2012-03-09', 7, '', 80, 10, 0, '2012-03-30 02:38:34', '2012-03-30 02:39:45'),
(27, 1, 11, 'Xmas Coursework', '2012-01-30', 7, '', 100, 5, 0, '2012-03-30 02:38:41', '2012-03-30 02:40:19'),
(28, 1, 11, 'Matlab', '2012-03-23', 5, '', 0, 5, 0, '2012-03-30 02:38:46', '2012-03-30 02:40:54'),
(29, 1, 11, 'Exam', '2012-05-12', 1, '', 0, 70, 0, '2012-03-30 02:38:49', '2012-03-30 02:41:13'),
(30, 1, 12, 'Lab: Strain', '2011-10-21', 7, '', 71, 8, 0, '2012-03-30 02:44:12', '2012-03-30 03:11:23'),
(31, 1, 12, 'Lab: Stress', '2012-02-24', 7, '', 100, 5, 0, '2012-03-30 02:44:22', '2012-03-30 02:45:45'),
(32, 1, 12, 'Xmas Coursework', '2012-01-30', 7, '', 100, 9, 0, '2012-03-30 02:44:31', '2012-03-30 02:46:08'),
(33, 1, 12, 'Spud Gun', '2012-03-30', 5, '', 0, 9, 0, '2012-03-30 02:44:37', '2012-03-30 02:46:30'),
(34, 1, 12, 'Exam', '2012-05-10', 1, '', 0, 70, 0, '2012-03-30 02:44:40', '2012-03-30 02:46:46'),
(35, 1, 13, 'Autolab', '2011-12-16', 7, '', 90, 20, 0, '2012-03-30 02:47:18', '2012-03-30 03:11:34'),
(36, 1, 13, 'LCA', '2011-12-16', 7, '', 88, 10, 0, '2012-03-30 02:47:23', '2012-03-30 02:48:11'),
(37, 1, 13, 'EA1', '2012-03-30', 7, '', 87, 20, 0, '2012-03-30 02:47:29', '2012-03-30 02:48:30'),
(38, 1, 13, 'Exam', '2012-05-18', 1, '', 0, 50, 0, '2012-03-30 02:47:39', '2012-03-30 07:49:07'),
(39, 1, 14, 'Quiz 1', '2011-12-01', 7, '', 63, 30, 0, '2012-03-30 02:49:16', '2012-03-30 02:50:04'),
(40, 1, 14, 'Quiz 2', '2012-03-01', 7, '', 70, 30, 0, '2012-03-30 02:49:20', '2012-03-30 02:49:57'),
(41, 1, 14, 'Quiz 3', '2012-04-21', 1, '', 0, 40, 0, '2012-03-30 02:49:24', '2012-03-30 03:11:41'),
(42, 1, 15, 'Quiz 1', '2012-03-30', 7, '', 100, 8, 0, '2012-03-30 02:50:45', '2012-03-30 02:53:23'),
(43, 1, 15, 'Quiz 2', '2012-03-30', 7, '', 100, 7, 0, '2012-03-30 02:50:48', '2012-03-30 02:53:36'),
(44, 1, 15, 'Quiz 3', '2012-03-30', 7, '', 100, 7, 0, '2012-03-30 02:50:51', '2012-03-30 02:53:43'),
(45, 1, 15, 'Quiz 4', '2012-03-30', 7, '', 100, 7, 0, '2012-03-30 02:50:54', '2012-03-30 02:53:50'),
(46, 1, 15, 'Quiz 5', '2012-03-30', 7, '', 100, 7, 0, '2012-03-30 02:50:58', '2012-03-30 02:53:57'),
(47, 1, 15, 'Quiz 6', '2012-03-30', 7, '', 100, 7, 0, '2012-03-30 02:51:02', '2012-03-30 02:54:03'),
(48, 1, 15, 'Quiz 7', '2012-03-30', 1, '', 0, 4, 0, '2012-03-30 02:51:07', '2012-03-30 02:53:10'),
(49, 1, 15, 'Quiz 8', '2012-03-30', 1, '', 0, 8, 0, '2012-03-30 02:51:09', '2012-03-30 02:53:18'),
(50, 1, 15, 'Simulation', '2012-03-30', 7, '', 100, 6, 0, '2012-03-30 02:51:14', '2012-03-30 02:54:29'),
(51, 1, 15, 'Lab Book', '2012-03-30', 4, '', 0, 39, 0, '2012-03-30 02:51:17', '2012-03-30 05:46:06'),
(52, 1, 16, 'Assignment', '2012-03-30', 7, '', 83, 50, 0, '2012-03-30 02:54:48', '2012-03-30 03:12:18'),
(53, 1, 16, 'Exam', '2012-03-30', 7, '', 83, 50, 0, '2012-03-30 02:54:50', '2012-03-30 02:55:22');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `title`, `description`) VALUES
(1, 'Administrator', 'Admin Group - full priveleges');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `version` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(0);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `title`) VALUES
(1, 'None'),
(2, 'Started'),
(3, 'Drafted'),
(4, 'Completed'),
(5, 'Handed In'),
(6, 'Returned'),
(7, 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `users_id` int(10) NOT NULL,
  `course_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notes` text,
  `score` int(3) NOT NULL,
  `complete` int(3) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `users_id`, `course_id`, `code`, `title`, `notes`, `score`, `complete`, `deleted`, `created_on`, `modified_on`) VALUES
(11, 1, 0, 'U04501', 'Thermodynamics', '', 21, 30, 0, '2012-03-30 02:31:53', '2012-03-30 03:10:56'),
(10, 1, 0, 'U04500', 'Maths', '', 15, 25, 0, '2012-03-30 02:31:43', '2012-03-30 07:49:01'),
(12, 1, 0, 'U04502', 'Mechanics', '', 20, 31, 0, '2012-03-30 02:32:04', '2012-03-30 03:11:23'),
(13, 1, 0, 'U04507', 'Materials', '', 44, 50, 0, '2012-03-30 02:32:16', '2012-03-30 07:49:07'),
(14, 1, 0, 'U04560', 'Graphics', '', 40, 60, 0, '2012-03-30 02:32:24', '2012-03-30 04:56:54'),
(15, 1, 0, 'U04600', 'Electronics', '', 49, 88, 0, '2012-03-30 02:32:33', '2012-03-30 05:46:06'),
(16, 1, 0, 'U05800', 'Management', '', 83, 100, 0, '2012-03-30 02:32:43', '2012-03-30 03:12:18');

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

DROP TABLE IF EXISTS `template`;
CREATE TABLE IF NOT EXISTS `template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `year_level` int(11) NOT NULL,
  `template` text NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `users_id`, `school_name`, `course_name`, `title`, `year_level`, `template`, `created_on`, `modified_on`) VALUES
(3, 1, 'Oxford Brookes', 'Motorsport Engineering', 'Complete Course', 1, '{ "template" : { "type" : "course", "data" : [{ "code" : "U04501", "title" : "Thermodynamics", "notes" : "", "coursework" : [ { "title" : "Lab: Losses", "due_date" : "2011-10-21", "notes" : "", "weighting" : "10"},{ "title" : "Lab: Flow", "due_date" : "2012-03-09", "notes" : "", "weighting" : "10"},{ "title" : "Xmas Coursework", "due_date" : "2012-01-30", "notes" : "", "weighting" : "5"},{ "title" : "Matlab", "due_date" : "2012-03-23", "notes" : "", "weighting" : "5"},{ "title" : "Exam", "due_date" : "2012-05-12", "notes" : "", "weighting" : "70"}]},{ "code" : "U04500", "title" : "Maths", "notes" : "", "coursework" : [ { "title" : "Test 1", "due_date" : "2011-11-07", "notes" : "", "weighting" : "5"},{ "title" : "Test 2", "due_date" : "2011-12-05", "notes" : "", "weighting" : "5"},{ "title" : "Test 3", "due_date" : "2012-03-09", "notes" : "", "weighting" : "5"},{ "title" : "Test 4", "due_date" : "2012-04-02", "notes" : "", "weighting" : "5"},{ "title" : "Mathcad", "due_date" : "2012-03-19", "notes" : "", "weighting" : "10"},{ "title" : "Exam", "due_date" : "2012-05-16", "notes" : "", "weighting" : "70"}]},{ "code" : "U04502", "title" : "Mechanics", "notes" : "", "coursework" : [ { "title" : "Lab: Strain", "due_date" : "2011-10-21", "notes" : "", "weighting" : "8"},{ "title" : "Lab: Stress", "due_date" : "2012-02-24", "notes" : "", "weighting" : "5"},{ "title" : "Xmas Coursework", "due_date" : "2012-01-30", "notes" : "", "weighting" : "9"},{ "title" : "Spud Gun", "due_date" : "2012-03-30", "notes" : "", "weighting" : "9"},{ "title" : "Exam", "due_date" : "2012-05-10", "notes" : "", "weighting" : "70"}]},{ "code" : "U04507", "title" : "Materials", "notes" : "", "coursework" : [ { "title" : "Autolab", "due_date" : "2011-12-16", "notes" : "", "weighting" : "20"},{ "title" : "LCA", "due_date" : "2011-12-16", "notes" : "", "weighting" : "10"},{ "title" : "EA1", "due_date" : "2012-03-30", "notes" : "", "weighting" : "20"},{ "title" : "Exam", "due_date" : "2012-05-18", "notes" : "", "weighting" : "50"}]},{ "code" : "U04560", "title" : "Graphics", "notes" : "", "coursework" : [ { "title" : "Quiz 1", "due_date" : "2011-12-01", "notes" : "", "weighting" : "30"},{ "title" : "Quiz 2", "due_date" : "2012-03-01", "notes" : "", "weighting" : "30"},{ "title" : "Quiz 3", "due_date" : "2012-04-21", "notes" : "", "weighting" : "40"}]},{ "code" : "U04600", "title" : "Electronics", "notes" : "", "coursework" : [ { "title" : "Quiz 1", "due_date" : "2012-03-30", "notes" : "", "weighting" : "8"},{ "title" : "Quiz 2", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 3", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 4", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 5", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 6", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 7", "due_date" : "2012-03-30", "notes" : "", "weighting" : "4"},{ "title" : "Quiz 8", "due_date" : "2012-03-30", "notes" : "", "weighting" : "8"},{ "title" : "Simulation", "due_date" : "2012-03-30", "notes" : "", "weighting" : "6"},{ "title" : "Lab Book", "due_date" : "2012-03-30", "notes" : "", "weighting" : "39"}]},{ "code" : "U05800", "title" : "Management", "notes" : "", "coursework" : [ { "title" : "Assignment", "due_date" : "2012-03-30", "notes" : "", "weighting" : "50"},{ "title" : "Exam", "due_date" : "2012-03-30", "notes" : "", "weighting" : "50"}]}]}}', '2012-03-30 07:22:43', '0000-00-00 00:00:00'),
(4, 1, 'Oxford Brookes', 'Motorsport Engineering', 'U04501 Thermodynamics', 1, '{ "template" : { "type" : "subject", "data" : [{ "code" : "U04500", "title" : "Maths", "notes" : "", "coursework" : [ { "title" : "Test 1", "due_date" : "2011-11-07", "notes" : "", "weighting" : "5"},{ "title" : "Test 2", "due_date" : "2011-12-05", "notes" : "", "weighting" : "5"},{ "title" : "Test 3", "due_date" : "2012-03-09", "notes" : "", "weighting" : "5"},{ "title" : "Test 4", "due_date" : "2012-04-02", "notes" : "", "weighting" : "5"},{ "title" : "Mathcad", "due_date" : "2012-03-19", "notes" : "", "weighting" : "10"},{ "title" : "Exam", "due_date" : "2012-05-16", "notes" : "", "weighting" : "70"}]}]}}', '2012-03-30 07:22:51', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '100',
  `token` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `group_id`, `token`, `identifier`) VALUES
(1, 'WillHart', '11082131@brookes.ac.uk', '9a56d1a4a52b2eb3caee6bb5c811f202af7d8a08f3a7b5fb6f58ef4153e75201', 100, '', '');
