-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2012 at 06:15 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `grades`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_logs`
--

DROP TABLE IF EXISTS `api_logs`;
CREATE TABLE IF NOT EXISTS `api_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `time` int(11) NOT NULL,
  `authorized` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `api_logs`
--

INSERT INTO `api_logs` (`id`, `uri`, `method`, `params`, `api_key`, `ip_address`, `time`, `authorized`) VALUES
(1, 'api/coursework', 'get', NULL, '', '127.0.0.1', 1334931495, 0);

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

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('b48893a8372c6d138514ff6281156bb2', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.19', 1334931456, ''),
('09d655f22a9b24dcbfb50e29e858adc8', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.19', 1335201249, 'a:19:{s:9:"user_data";s:0:"";s:8:"username";s:8:"WillHart";s:5:"email";s:22:"11082131@brookes.ac.uk";s:8:"group_id";s:1:"1";s:5:"token";s:0:"";s:18:"registration_token";s:0:"";s:23:"registration_token_date";s:19:"0000-00-00 00:00:00";s:17:"forgot_pass_token";s:0:"";s:22:"forgot_pass_token_date";s:19:"0000-00-00 00:00:00";s:10:"identifier";s:0:"";s:7:"api_key";s:15:"wh-api-key-test";s:9:"api_level";s:1:"0";s:13:"ignore_limits";s:1:"0";s:18:"last_remote_update";s:19:"0000-00-00 00:00:00";s:10:"last_login";s:19:"2012-04-19 18:58:00";s:10:"created_on";s:19:"2012-04-15 00:00:00";s:7:"user_id";s:1:"1";s:9:"logged_in";b:1;s:14:"default_course";s:1:"1";}');

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
(1, 1, 'My First Year Level', '2012-04-12 05:09:13', '2012-04-12 05:09:13');

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
  `alert_sent` tinyint(4) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL,
  `notes` text,
  `score` int(3) DEFAULT NULL,
  `weighting` int(3) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `coursework`
--

INSERT INTO `coursework` (`id`, `users_id`, `subject_id`, `title`, `due_date`, `alert_sent`, `status_id`, `notes`, `score`, `weighting`, `deleted`, `created_on`, `modified_on`) VALUES
(1, 1, 1, 'Test 1', '2011-11-07', 0, 7, '', 100, 5, 0, '2012-03-30 02:32:49', '2012-03-30 03:11:12'),
(2, 1, 1, 'Test 2', '2011-12-05', 0, 7, '', 94, 5, 0, '2012-03-30 02:32:53', '2012-03-30 02:34:04'),
(3, 1, 1, 'Test 3', '2012-03-09', 0, 7, '', 100, 5, 0, '2012-03-30 02:32:56', '2012-03-30 02:34:59'),
(4, 1, 1, 'Test 4', '2012-04-02', 0, 7, '', 88, 5, 0, '2012-03-30 02:33:00', '2012-04-18 11:44:23'),
(5, 1, 1, 'Mathcad', '2012-03-19', 0, 7, '', 65, 10, 0, '2012-03-30 02:33:04', '2012-04-17 09:06:59'),
(6, 1, 1, 'Exam', '2012-05-16', 0, 1, '', 0, 70, 0, '2012-03-30 02:33:09', '2012-03-30 03:04:31'),
(7, 1, 2, 'Lab: Losses', '2011-10-21', 0, 7, '', 75, 10, 0, '2012-03-30 02:38:26', '2012-04-13 06:34:08'),
(8, 1, 2, 'Lab: Flow', '2012-03-09', 0, 7, '', 80, 10, 0, '2012-03-30 02:38:34', '2012-03-30 02:39:45'),
(9, 1, 2, 'Xmas Coursework', '2012-01-30', 0, 7, '', 100, 5, 0, '2012-03-30 02:38:41', '2012-03-30 02:40:19'),
(10, 1, 2, 'Matlab', '2012-03-23', 0, 7, '', 100, 5, 0, '2012-03-30 02:38:46', '2012-04-18 11:44:40'),
(11, 1, 2, 'Exam', '2012-05-12', 0, 1, '', 0, 70, 0, '2012-03-30 02:38:49', '2012-04-13 06:27:25'),
(12, 1, 4, 'Autolab', '2011-12-16', 0, 7, '', 90, 20, 0, '2012-03-30 02:47:18', '2012-03-30 03:11:34'),
(13, 1, 4, 'LCA', '2011-12-16', 0, 7, '', 88, 10, 0, '2012-03-30 02:47:23', '2012-03-30 02:48:11'),
(14, 1, 4, 'EA1', '2012-03-30', 0, 7, '', 87, 20, 0, '2012-03-30 02:47:29', '2012-03-30 02:48:30'),
(15, 1, 4, 'Exam', '2012-05-18', 0, 1, '', 0, 50, 0, '2012-03-30 02:47:39', '2012-03-30 07:49:07'),
(16, 1, 5, 'Quiz 1', '2011-12-01', 0, 7, '', 63, 30, 0, '2012-03-30 02:49:16', '2012-03-30 02:50:04'),
(17, 1, 5, 'Quiz 2', '2012-03-01', 0, 7, '', 70, 30, 0, '2012-03-30 02:49:20', '2012-03-30 02:49:57'),
(18, 1, 5, 'Quiz 3', '2012-04-21', 0, 5, '', 0, 40, 0, '2012-03-30 02:49:24', '2012-04-23 06:14:21'),
(19, 1, 6, 'Quiz 1', '2012-03-30', 0, 7, '', 100, 8, 0, '2012-03-30 02:50:45', '2012-03-30 02:53:23'),
(20, 1, 6, 'Quiz 2', '2012-03-30', 0, 7, '', 100, 7, 0, '2012-03-30 02:50:48', '2012-03-30 02:53:36'),
(21, 1, 6, 'Quiz 3', '2012-03-30', 0, 7, '', 100, 7, 0, '2012-03-30 02:50:51', '2012-03-30 02:53:43'),
(22, 1, 6, 'Quiz 4', '2012-03-30', 0, 7, '', 100, 7, 0, '2012-03-30 02:50:54', '2012-03-30 02:53:50'),
(23, 1, 6, 'Quiz 5', '2012-03-30', 0, 7, '', 100, 7, 0, '2012-03-30 02:50:58', '2012-03-30 02:53:57'),
(24, 1, 6, 'Quiz 6', '2012-03-30', 0, 7, '', 100, 7, 0, '2012-03-30 02:51:02', '2012-03-30 02:54:03'),
(25, 1, 6, 'Quiz 7', '2012-03-30', 0, 7, '', 100, 4, 0, '2012-03-30 02:51:07', '2012-04-23 06:15:19'),
(26, 1, 6, 'Quiz 8', '2012-03-30', 0, 1, '', 0, 8, 0, '2012-03-30 02:51:09', '2012-03-30 02:53:18'),
(27, 1, 6, 'Simulation', '2012-03-30', 0, 7, '', 100, 6, 0, '2012-03-30 02:51:14', '2012-03-30 02:54:29'),
(28, 1, 6, 'Lab Book', '2012-03-30', 0, 4, '', 0, 39, 0, '2012-03-30 02:51:17', '2012-03-30 05:46:06'),
(29, 1, 7, 'Assignment', '2012-03-30', 0, 7, '', 83, 50, 0, '2012-03-30 02:54:48', '2012-04-02 05:45:54'),
(30, 1, 7, 'Exam', '2012-03-30', 0, 7, '', 83, 50, 0, '2012-03-30 02:54:50', '2012-04-02 01:43:05'),
(31, 1, 3, 'Lab: Strain', '2011-10-21', 0, 7, '', 71, 8, 0, '2012-04-17 09:49:00', '2012-04-17 09:49:41'),
(32, 1, 3, 'Lab: Stress', '2012-02-24', 0, 7, '', 100, 5, 0, '2012-04-17 09:49:47', '2012-04-17 09:50:11'),
(33, 1, 3, 'Xmas Coursework', '2012-01-30', 0, 7, '', 100, 8, 0, '2012-04-17 09:50:19', '2012-04-17 09:51:54'),
(34, 1, 3, 'Spud Gun', '2012-03-30', 0, 7, '', 70, 9, 0, '2012-04-17 09:50:50', '2012-04-17 09:51:38'),
(35, 1, 3, 'Exam', '2012-05-16', 0, 1, '', 0, 70, 0, '2012-04-17 09:52:00', '2012-04-17 09:52:12');

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
(1, 'Administrator', 'Admin Group - full priveleges'),
(100, 'User', 'General User Level');

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
(12);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `default_course` int(11) NOT NULL,
  `first_login` int(1) NOT NULL,
  `emails_allowed` tinyint(4) NOT NULL DEFAULT '0',
  `unsubscribe_code` varchar(23) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `users_id`, `first_name`, `last_name`, `default_course`, `first_login`, `emails_allowed`, `unsubscribe_code`, `created_on`, `modified_on`) VALUES
(1, 1, 'Will', 'Hart', 1, 0, 1, '4f8758d15c44c9.55071820', '2012-04-12 05:05:01', '2012-04-15 05:46:56');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `users_id`, `course_id`, `code`, `title`, `notes`, `score`, `complete`, `deleted`, `created_on`, `modified_on`) VALUES
(2, 1, 1, 'U04501', 'Thermodynamics', '', 26, 30, 0, '2012-03-30 02:31:53', '2012-04-18 11:44:39'),
(1, 1, 1, 'U04500', 'Maths', '', 26, 30, 0, '2012-03-30 02:31:43', '2012-04-17 09:06:57'),
(4, 1, 1, 'U04507', 'Materials', '', 44, 50, 0, '2012-03-30 02:32:16', '2012-03-30 07:49:07'),
(5, 1, 1, 'U04560', 'Graphics', '', 40, 100, 0, '2012-03-30 02:32:24', '2012-04-23 06:14:21'),
(6, 1, 1, 'U04600', 'Electronics', '', 53, 92, 0, '2012-03-30 02:32:33', '2012-04-23 06:15:17'),
(7, 1, 1, 'U05800', 'Management', '', 83, 100, 0, '2012-03-30 02:32:43', '2012-04-12 08:18:55'),
(3, 1, 1, 'U04502', 'Mechanics', NULL, 25, 30, 0, '2012-04-17 09:48:23', '2012-04-17 09:52:12');

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
  `is_official` tinyint(4) NOT NULL,
  `is_course` tinyint(4) NOT NULL,
  `template` text NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id`, `users_id`, `school_name`, `course_name`, `title`, `year_level`, `is_official`, `is_course`, `template`, `created_on`, `modified_on`) VALUES
(1, 1, 'Oxford Brookes', 'Motorsport Engineering', 'Complete Course', 1, 0, 0, '{ "template" : { "type" : "course", "data" : [{ "code" : "U04501", "title" : "Thermodynamics", "notes" : "", "coursework" : [ { "title" : "Lab: Losses", "due_date" : "2011-10-21", "notes" : "", "weighting" : "10"},{ "title" : "Lab: Flow", "due_date" : "2012-03-09", "notes" : "", "weighting" : "10"},{ "title" : "Xmas Coursework", "due_date" : "2012-01-30", "notes" : "", "weighting" : "5"},{ "title" : "Matlab", "due_date" : "2012-03-23", "notes" : "", "weighting" : "5"},{ "title" : "Exam", "due_date" : "2012-05-12", "notes" : "", "weighting" : "70"}]},{ "code" : "U04500", "title" : "Maths", "notes" : "", "coursework" : [ { "title" : "Test 1", "due_date" : "2011-11-07", "notes" : "", "weighting" : "5"},{ "title" : "Test 2", "due_date" : "2011-12-05", "notes" : "", "weighting" : "5"},{ "title" : "Test 3", "due_date" : "2012-03-09", "notes" : "", "weighting" : "5"},{ "title" : "Test 4", "due_date" : "2012-04-02", "notes" : "", "weighting" : "5"},{ "title" : "Mathcad", "due_date" : "2012-03-19", "notes" : "", "weighting" : "10"},{ "title" : "Exam", "due_date" : "2012-05-16", "notes" : "", "weighting" : "70"}]},{ "code" : "U04502", "title" : "Mechanics", "notes" : "", "coursework" : [ { "title" : "Lab: Strain", "due_date" : "2011-10-21", "notes" : "", "weighting" : "8"},{ "title" : "Lab: Stress", "due_date" : "2012-02-24", "notes" : "", "weighting" : "5"},{ "title" : "Xmas Coursework", "due_date" : "2012-01-30", "notes" : "", "weighting" : "9"},{ "title" : "Spud Gun", "due_date" : "2012-03-30", "notes" : "", "weighting" : "9"},{ "title" : "Exam", "due_date" : "2012-05-10", "notes" : "", "weighting" : "70"}]},{ "code" : "U04507", "title" : "Materials", "notes" : "", "coursework" : [ { "title" : "Autolab", "due_date" : "2011-12-16", "notes" : "", "weighting" : "20"},{ "title" : "LCA", "due_date" : "2011-12-16", "notes" : "", "weighting" : "10"},{ "title" : "EA1", "due_date" : "2012-03-30", "notes" : "", "weighting" : "20"},{ "title" : "Exam", "due_date" : "2012-05-18", "notes" : "", "weighting" : "50"}]},{ "code" : "U04560", "title" : "Graphics", "notes" : "", "coursework" : [ { "title" : "Quiz 1", "due_date" : "2011-12-01", "notes" : "", "weighting" : "30"},{ "title" : "Quiz 2", "due_date" : "2012-03-01", "notes" : "", "weighting" : "30"},{ "title" : "Quiz 3", "due_date" : "2012-04-21", "notes" : "", "weighting" : "40"}]},{ "code" : "U04600", "title" : "Electronics", "notes" : "", "coursework" : [ { "title" : "Quiz 1", "due_date" : "2012-03-30", "notes" : "", "weighting" : "8"},{ "title" : "Quiz 2", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 3", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 4", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 5", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 6", "due_date" : "2012-03-30", "notes" : "", "weighting" : "7"},{ "title" : "Quiz 7", "due_date" : "2012-03-30", "notes" : "", "weighting" : "4"},{ "title" : "Quiz 8", "due_date" : "2012-03-30", "notes" : "", "weighting" : "8"},{ "title" : "Simulation", "due_date" : "2012-03-30", "notes" : "", "weighting" : "6"},{ "title" : "Lab Book", "due_date" : "2012-03-30", "notes" : "", "weighting" : "39"}]},{ "code" : "U05800", "title" : "Management", "notes" : "", "coursework" : [ { "title" : "Assignment", "due_date" : "2012-03-30", "notes" : "", "weighting" : "50"},{ "title" : "Exam", "due_date" : "2012-03-30", "notes" : "", "weighting" : "50"}]}]}}', '2012-03-30 07:22:43', '2012-04-19 07:09:29'),
(2, 1, 'Oxford Brookes', 'Motorsport Engineering', 'U04501 Thermodynamics', 1, 0, 0, '{ "template" : { "type" : "subject", "data" : [{ "code" : "U04500", "title" : "Maths", "notes" : "", "coursework" : [ { "title" : "Test 1", "due_date" : "2011-11-07", "notes" : "", "weighting" : "5"},{ "title" : "Test 2", "due_date" : "2011-12-05", "notes" : "", "weighting" : "5"},{ "title" : "Test 3", "due_date" : "2012-03-09", "notes" : "", "weighting" : "5"},{ "title" : "Test 4", "due_date" : "2012-04-02", "notes" : "", "weighting" : "5"},{ "title" : "Mathcad", "due_date" : "2012-03-19", "notes" : "", "weighting" : "10"},{ "title" : "Exam", "due_date" : "2012-05-16", "notes" : "", "weighting" : "70"}]}]}}', '2012-03-30 07:22:51', '0000-00-00 00:00:00');

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
  `registration_token` varchar(64) NOT NULL,
  `registration_token_date` datetime NOT NULL,
  `forgot_pass_token` varchar(64) NOT NULL,
  `forgot_pass_token_date` datetime NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `api_key` varchar(40) NOT NULL,
  `api_level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL,
  `last_remote_update` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `group_id`, `token`, `registration_token`, `registration_token_date`, `forgot_pass_token`, `forgot_pass_token_date`, `identifier`, `api_key`, `api_level`, `ignore_limits`, `last_remote_update`, `last_login`, `created_on`) VALUES
(1, 'WillHart', '11082131@brookes.ac.uk', '9a56d1a4a52b2eb3caee6bb5c811f202af7d8a08f3a7b5fb6f58ef4153e75201', 1, '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', 'wh-api-key-test', 0, 0, '0000-00-00 00:00:00', '2012-04-23 18:14:00', '2012-04-15 00:00:00');


--
-- Create user profile trigger
--
CREATE TRIGGER trigger_profile_SetCreatedOn BEFORE INSERT ON `profile` FOR EACH ROW SET NEW.created_on = NOW();
