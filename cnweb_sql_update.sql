-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 06, 2013 at 11:41 AM
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
  `pid` int(11) DEFAULT NULL,
  `comment` varchar(100) CHARACTER SET utf8 NOT NULL,
  `uid` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`cid`, `pid`, `comment`, `uid`, `date_created`) VALUES
(6, 156, 'Thường thôi :)', 3, '2013-05-02 23:46:54'),
(7, 156, 'Thường thôi :)', 3, '2013-05-02 23:48:01'),
(8, 156, 'some thing happen here', 3, '2013-05-02 23:50:29'),
(9, 156, 'hello bạn nhé :)', 3, '2013-05-03 06:46:29'),
(10, 145, 'Một cảm giác rất yomost', 3, '2013-05-03 23:42:58'),
(11, 156, 'Lại comment linh tinh', 3, '2013-05-04 23:54:14'),
(12, 156, 'Xin chào nhé :)', 3, '2013-05-05 00:16:13'),
(13, 156, 'Thử lần lữa xem thế nào ..........', 3, '2013-05-05 00:18:44'),
(14, 156, 'Hello ou lll', 3, '2013-05-05 11:27:10'),
(15, 144, 'Xin chào bạn nhé :)', 3, '2013-05-05 12:06:04'),
(16, 144, 'Xin chào bạn nhé :)', 3, '2013-05-05 12:08:23'),
(17, 144, 'Biết rồi .......', 3, '2013-05-05 12:23:09'),
(18, 157, 'Comment thử tí', 3, '2013-05-05 12:25:31'),
(19, 156, 'Bài này hot :)', 3, '2013-05-05 12:31:53'),
(20, 155, 'Bài này hay quá đi mất .....', 3, '2013-05-05 16:30:17'),
(21, 155, 'dfsfjsf àlas', 3, '2013-05-05 19:36:00'),
(22, 155, 'ssssssssssssssssssssssssss', 3, '2013-05-05 19:36:03'),
(23, 91, 'jflsadfa', 3, '2013-05-05 21:18:43'),
(24, 158, 'MacOs đẹp quá', 3, '2013-05-05 22:43:25');

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE IF NOT EXISTS `like` (
  `uid` int(11) NOT NULL,
  `targetId` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`uid`,`targetId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `like`
--

INSERT INTO `like` (`uid`, `targetId`, `type`) VALUES
(3, 132, 'photo'),
(3, 155, 'photo'),
(3, 158, 'photo'),
(10, 157, 'photo');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid_parent` int(11) DEFAULT '0',
  `uid_from` int(11) NOT NULL,
  `uid_to` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `message` varchar(500) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`mid`, `mid_parent`, `uid_from`, `uid_to`, `title`, `message`, `date_created`, `read`) VALUES
(2, 2, 3, 3, 'newvalue', 'something in the air', '0000-00-00 00:00:00', 1),
(3, 2, 3, 3, 'newvalue', 'something in the air', '0000-00-00 00:00:00', 1),
(4, 2, 3, 3, '', 'fajskfalsfjaslkfjasf', '2013-05-03 11:47:09', 1),
(5, 2, 3, 3, '', 'hello you', '2013-05-03 11:47:16', 1),
(6, 6, 10, 3, 'hello you', 'Xin chào bạn. Rất vui được làm quen với bạn', '0000-00-00 00:00:00', 1),
(7, 2, 3, 3, '', 'i love you', '2013-05-03 11:57:49', 1),
(8, 2, 3, 3, '', 'Cảm ơn bạn nhiều nhé :)))))', '2013-05-03 11:58:03', 1),
(9, 2, 3, 3, '', 'Oh my god tự kỉ thế này là cùng :)))', '2013-05-03 11:58:39', 1),
(10, 2, 3, 3, '', 'fjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj jafjasfjakljflajfakjflajflasjlfasjfajfla', '2013-05-03 11:58:50', 1),
(11, 11, 10, 3, 'Thư làm quen', 'xin chào bạn nhé :D', '2013-05-03 12:27:08', 1),
(12, 12, 10, 3, 'Làm quen', 'Xin chào tuấn dđ', '2013-05-03 12:28:18', 1),
(13, 13, 10, 3, 'Làm quen', 'Xin chào tuấn dđ', '2013-05-03 12:29:07', 1),
(14, 14, 10, 3, 'Làm quen', 'Xin chào tuấn nhé :D', '2013-05-03 12:29:54', 1),
(15, 14, 3, 10, '', 'Ừ. hi :)', '2013-05-04 15:57:41', 1),
(16, 0, 3, 10, '', 'Uk. Hi :)', '2013-05-04 15:59:38', 0),
(17, 0, 3, 10, '', 'Uk. Hi :)', '2013-05-04 16:00:58', 0),
(18, 0, 3, 10, '', 'Uk. Hi :)', '2013-05-04 16:01:36', 0),
(19, 0, 3, 10, '', 'Uk. Hi :)', '2013-05-04 16:01:52', 0),
(20, 14, 3, 10, '', 'ok.baybe', '2013-05-04 16:04:16', 1),
(21, 14, 3, 10, '', 'chém gió hoài. Tự kỷ vậy mày :))))', '2013-05-04 16:04:34', 1),
(22, 14, 3, 10, '', 'no comment. jfkasjfkasjklfjas fasjfkajslfkjaklsjflkasjfkljasklfasfjlasjflasjf', '2013-05-04 16:04:47', 1),
(23, 14, 10, 3, '', 'Ax. Spam hả cu', '2013-05-04 16:05:50', 1),
(24, 14, 10, 3, '', 'Ax. Spam hả cu', '2013-05-04 16:05:56', 1),
(25, 14, 10, 3, '', 'no comment. jfkasjfkasjklfjas fasjfkajslfkjaklsjflkasjfkljasklfasfjlasjflasjf', '2013-05-04 16:05:59', 1),
(26, 14, 10, 3, '', 'Không có gì :)', '2013-05-04 16:06:13', 1),
(27, 14, 10, 3, '', 'Ax. Spam hả cu', '2013-05-04 16:06:17', 1),
(28, 14, 10, 3, '', 'Stop ở đây nhé :)', '2013-05-04 16:06:33', 1),
(29, 14, 10, 3, '', 'no comment. jfkasjfkasjklfjas fasjfkajslfkjaklsjflkasjfkljasklfasfjlasjflasjf', '2013-05-04 16:06:42', 1),
(30, 14, 10, 3, '', 'Hi bạn. comment tử tế đi chứ :)', '2013-05-04 16:09:09', 1),
(31, 14, 3, 10, '', 'Ax. Toàn tự kỷ .....', '2013-05-04 16:09:31', 1),
(32, 14, 10, 3, '', 'Hi bạn. comment tử tế đi chứ :)', '2013-05-04 16:11:53', 1),
(33, 14, 3, 10, '', 'Ax. Toàn tự kỷ .....', '2013-05-04 16:12:22', 1),
(34, 14, 10, 3, '', 'thêm thư spam nè :)', '2013-05-04 16:32:39', 1),
(35, 14, 3, 10, '', 'xin chào spammer ', '2013-05-04 16:34:27', 1),
(36, 14, 3, 10, '', 'hello oufdfs', '2013-05-04 16:34:43', 1),
(37, 14, 10, 3, '', 'Xấu như con gấu :D', '2013-05-04 16:35:04', 1),
(38, 14, 3, 10, '', 'Hello chú. Tin nhắn mới đây :D', '2013-05-04 17:04:54', 1),
(39, 14, 3, 10, '', 'Hi hi. Tin nhắn tiếp đây', '2013-05-04 17:05:53', 1),
(40, 12, 3, 10, '', 'ừ. chào bạn nhé :)', '2013-05-05 09:20:20', 1),
(41, 11, 3, 10, '', 'Ừ hì :))', '2013-05-05 10:39:22', 1),
(42, 6, 10, 3, '', 'gdskgls;dg sd', '2013-05-05 19:30:14', 1),
(43, 43, 10, 3, 'Hi you', 'No thing in your eye', '2013-05-05 19:30:52', 1),
(44, 43, 3, 10, '', 'sòmd fjslfj', '2013-05-05 19:31:23', 1),
(45, 43, 10, 3, '', 'gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', '2013-05-05 19:33:07', 1),
(46, 43, 10, 3, '', 'hhhhhhhhhhhhh', '2013-05-05 19:33:13', 1),
(47, 43, 10, 3, '', 'fdsfsfsgsgs', '2013-05-05 19:34:18', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `content`, `date_created`, `title`) VALUES
(4, 'Hiện tại chúng tôi đang thêm', '0000-00-00 00:00:00', 'Tuy?n thành viên ban qu?n tr?'),
(5, 'test thôi nào', '0000-00-00 00:00:00', 'không có gì'),
(6, 'Không có gì ?âu :)', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp'),
(10, 'Không có gì ?âu :)', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp'),
(13, '<p>Ch&uacute;ng t&ocirc;i ?ang c?n t&igrave;m th&ecirc;m th&agrave;nh vi&ecirc;n ban qu?n tr? m?i</p>\r\n', '0000-00-00 00:00:00', 'Tuy?n thành viên ban qu?n tr?'),
(14, '<p>Tuy?n th&agrave;nh vi&ecirc;n ban qu?n tr?</p>\r\n', '0000-00-00 00:00:00', 'Tuy?n thành viên ban qu?n tr?'),
(15, '<p>KH&ocirc;ng c&oacute; g&igrave; test ti?g vi?t th&ocirc;i</p>\r\n', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp'),
(16, '<p>Test ti?ng vi?t th&ocirc;i</p>\r\n', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp'),
(17, 'Tuy?n thành viên ban qu?n tr?', '0000-00-00 00:00:00', 'Tuy?n thành viên ban qu?n tr?'),
(18, 'Mau ??ng ký thành viên ?? tr? thành ', '0000-00-00 00:00:00', 'Tuy?n thành viên ban qu?n tr?'),
(19, 'Không có n?i dung nào', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp'),
(20, '<p>jsfasjflasjfklasj</p>\r\n', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp'),
(21, '<p>fajskfjaskljdfsksjfklasjflajslfjaslfasjfla</p>\r\n', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp'),
(22, '<p>fsjfkljsadfkasj</p>\r\n', '0000-00-00 00:00:00', 'C?m ?n các b?n ?ã ?óng góp'),
(23, '<p>Update th? ti?ng vi?t xem c&oacute; ?n kh&ocirc;ng</p>\r\n', '0000-00-00 00:00:00', 'fsdfa'),
(24, '<p>fjskfjsakfa</p>\r\n', '0000-00-00 00:00:00', 'ti?ng vi?t'),
(25, '<p>fjskfjsakfa</p>\r\n', '0000-00-00 00:00:00', 'tiếng việt'),
(26, '<h2><strong>Thử t&iacute; ti&ecirc;ng việt th&ocirc;i</strong></h2>\r\n', '0000-00-00 00:00:00', 'Cảm ơn các bạn đã đóng góp'),
(27, '<p>Kh&ocirc;ng c&oacute; g&igrave; đ&acirc;u :)</p>\r\n', '0000-00-00 00:00:00', 'Lại cảm ơn nữa'),
(29, '<p>Cảm ơn rất nhiều nh&eacute;</p>\r\n', '0000-00-00 00:00:00', 'Cảm ơn các bạn đã đóng góp'),
(30, '<p>Kh&ocirc;ng c&oacute; g&igrave; phải cảm ơn đ&acirc;u :)</p>\r\n', '2013-04-24 22:54:56', 'Cảm ơn các bạn đã đóng góp'),
(31, '<p>Ch&agrave;o mừng bạn đ&atilde; đến với cab.vn</p>\r\n', '2013-04-24 22:56:59', 'Xin chào cab.vn'),
(32, '<p>fajskfjaskljdfsksjfklasjflajslfjaslfasjfla</p>\r\n', '2013-04-24 23:06:42', 'Cảm ơn các bạn đã đóng góp');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date-created` datetime DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=159 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`pid`, `uid`, `title`, `type`, `name`, `date-created`) VALUES
(143, 3, 'Maroon 5 - Sunday Morning ', 'video', 'S2Cti12XBw4', '2013-04-29 16:40:19'),
(144, 3, 'Thế này sao mà học được :)', 'photo', 'M18xMzY3MjI4NDQ2.jpg', '2013-04-29 16:40:46'),
(145, 3, 'Một cảm giác rất yomost !', 'photo', 'M18xMzY3MjI4NDgy.jpg', '2013-04-29 16:41:22'),
(146, 3, 'Chuẩn cmnr', 'photo', 'M18xMzY3MjI4NDk4.jpg', '2013-04-29 16:41:38'),
(147, 3, 'Ai đồng ý giơ tay nào', 'photo', 'M18xMzY3MjI4NTE2.jpg', '2013-04-29 16:41:56'),
(148, 3, 'Sáng kiến', 'photo', 'M18xMzY3MjI4NTMx.jpg', '2013-04-29 16:42:11'),
(149, 3, 'Truyện vui', 'photo', 'M18xMzY3MjI4NTQ1.jpg', '2013-04-29 16:42:25'),
(150, 3, 'Just the way you are ....', 'video', 'GhFSgnvKqm4', '2013-04-29 16:43:07'),
(151, 3, ' Payphone - Maroon 5 (Jayesslee Cover) ', 'video', 'qraPm7OwtVA', '2013-04-29 16:45:33'),
(152, 3, 'Payphone lysic - funny', 'video', '5FlQSQuv_mg', '2013-04-29 16:47:25'),
(153, 3, 'when you\\''re gone :)', 'video', '0G3_kG5FFfQ', '2013-04-29 16:48:53'),
(154, 3, 'someone like you - adele', 'video', 'qemWRToNYJY', '2013-04-29 16:56:44'),
(155, 3, 'Just the way you are :)', 'video', 'LjhCEhWiKXk', '2013-04-29 16:57:22'),
(156, 3, 'Pattern', 'photo', 'M18xMzY3MzA1OTM1.jpg', '2013-04-30 14:12:15'),
(157, 10, 'I\\''m yours', 'video', 'LYhrYHmUPn0', '2013-04-30 22:53:51'),
(158, 3, 'Giao diện macos cực đẹp', 'photo', 'M18xMzY3NzYxNDQ4.jpg', '2013-05-05 20:44:08');

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
  `avatar` varchar(100) DEFAULT 'no-avatar.jpg',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `password`, `email`, `info`, `username`, `active`, `admin`, `ban_reason`, `date_created`, `avatar`) VALUES
(3, 'icloud', 'newvalue92@gmail.com', 'Tôi là tuấn :)', 'newvalue', 1, 1, NULL, '2013-04-09', 'M19hdmF0YXJfMTM2NzMwNzEzNw==.jpg'),
(5, 'nothing', 'kho@gmail.com', 'jfksf', 'testuser', 1, 0, NULL, '0000-00-00', 'no-avatar.jpg'),
(6, 'icloud', 'khongcoai@gmail.com', 'thong tin tài kho?n', 'something', 1, 0, NULL, '0000-00-00', 'no-avatar.jpg'),
(7, 'fsdfsf', 'ffsfsf@gmail.com', 'fsfas', 'fdfsfs', 1, 0, NULL, '0000-00-00', 'no-avatar.jpg'),
(8, 'ductuan', 'something@gmail.com', NULL, 'tuannguyen', 0, 0, NULL, NULL, 'no-avatar.jpg'),
(9, 'ductuan', 'new@gmail.com', NULL, 'tìdffdkjfsk', 0, 0, NULL, NULL, 'no-avatar.jpg'),
(10, 'tuanbk', 'newd@gmail.com', NULL, 'test', 0, 0, NULL, NULL, 'no-avatar.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
