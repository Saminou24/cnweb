-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2013 at 08:00 AM
-- Server version: 5.5.29
-- PHP Version: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cnweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cid_parent` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) DEFAULT NULL,
  `comment` varchar(11) CHARACTER SET utf8 NOT NULL,
  `like` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid_parent` int(11) NOT NULL DEFAULT '0',
  `uid_from` int(11) NOT NULL,
  `uid_to` int(11) NOT NULL,
  `message` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
  `date_created` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `content`, `date_created`, `title`) VALUES
(2, '', '0000-00-00 00:00:00', 'Cảm ơn các bạn đã đóng góp'),
(4, '<p> hi?n t?i chúng tôi ?ang c?n tìm thêm m?t vài mod</p>\r\n', '0000-00-00 00:00:00', 'Tuy?n thành viên ban qu?n tr?'),
(5, 'test thôi nào', '0000-00-00 00:00:00', 'không có gì'),
(6, 'Không có gì ?âu :)', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp'),
(9, 'Không có gì ?âu :)jjjjjjjjjjjjjjjjjj', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `like` int(11) NOT NULL DEFAULT '0',
  `date-created` datetime DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=104 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`pid`, `uid`, `title`, `name`, `like`, `date-created`) VALUES
(91, 2, 'Tai siêu dài :)', 'Ml8xMzY1MDcwNjIw.jpg', 0, '0000-00-00 00:00:00'),
(92, 2, 'Tai siêu dài :)', 'Ml8xMzY1MDcwNzEx.jpg', 0, '0000-00-00 00:00:00'),
(93, 2, 'M? t? b?o...', 'Ml8xMzY1MDcwNzMw.jpg', 0, '0000-00-00 00:00:00'),
(94, 2, 'B?n có bi?t ?', 'Ml8xMzY1MDcwNzQx.jpg', 0, '0000-00-00 00:00:00'),
(95, 2, 'Em h?n ch? ', 'Ml8xMzY1MDcwNzU0.jpg', 0, '0000-00-00 00:00:00'),
(96, 2, 'Truy?n ng?n', 'Ml8xMzY1MDcwNzY4.jpg', 0, '0000-00-00 00:00:00'),
(97, 2, 'Truy?n ng?n', 'Ml8xMzY1MDcwOTk2.jpg', 0, '0000-00-00 00:00:00'),
(98, 2, 'fdf', 'Ml8xMzY1MjM3MDU5.jpg', 0, '0000-00-00 00:00:00'),
(99, 2, 'fdf', 'Ml8xMzY1MjM3ODQz.jpg', 0, '2013-04-08 00:00:00'),
(100, 2, 'B?n có bi?t ?i?u ?ó', 'Ml8xMzY1NTI0NzI2.jpg', 0, '0000-00-00 00:00:00'),
(101, 2, 'L?i nói linh tinh r?i ...............', 'Ml8xMzY1NTI0NzQz.jpg', 0, '0000-00-00 00:00:00'),
(102, 2, 'Bao nhiêu t?p r?i nh?', 'Ml8xMzY1NTI0NzYy.jpg', 0, '0000-00-00 00:00:00'),
(103, 2, 'dkfjdlfjs', 'Ml8xMzY1NTI0Nzcw.jpg', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` char(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `username` char(20) NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(100) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `password`, `email`, `info`, `username`, `active`, `admin`, `ban_reason`, `date_created`) VALUES
(3, 'icloud', 'newvalue92@gmail.com', 'Nguyễn Đức Tuấn', 'newvalue', 1, 1, NULL, '2013-04-09'),
(4, 'fjskfsj', NULL, '', 'jfsjfslkjflskjflk', 1, 0, NULL, '2013-04-13'),
(5, 'nothing', 'kho@gmail.com', 'jfksf', 'testuser', 1, 0, NULL, '0000-00-00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
