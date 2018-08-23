-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 25 2016 г., 07:50
-- Версия сервера: 5.5.53-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `Unioncash`
--

-- --------------------------------------------------------

--
-- Структура таблицы `case`
--

CREATE TABLE IF NOT EXISTS `case` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price_min` int(255) NOT NULL,
  `price_max` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `x10` int(255) NOT NULL,
  `x20` int(255) NOT NULL,
  `x30` int(255) NOT NULL,
  `img` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `case`
--

INSERT INTO `case` (`id`, `price_min`, `price_max`, `price`, `x10`, `x20`, `x30`, `img`) VALUES
(1, 15, 50, 20, 2, 4, 6, '/uploads/coin-50.svg'),
(2, 30, 100, 50, 5, 7, 10, '/uploads/coin-100.svg'),
(3, 40, 250, 80, 10, 15, 20, '/uploads/coin-250.svg'),
(4, 50, 500, 100, 10, 20, 30, '/uploads/coin-500.svg'),
(5, 70, 1000, 300, 30, 40, 50, '/uploads/coin-1000.svg');

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(256) NOT NULL,
  `price` int(255) NOT NULL,
  `cases_id` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `img`, `price`, `cases_id`) VALUES
(1, '/uploads/coin-1.svg', 1, '0'),
(2, '/uploads/coin-5.svg', 5, '0'),
(3, '/uploads/coin-10.svg', 10, '1'),
(4, '/uploads/coin-15.svg', 15, '1'),
(5, '/uploads/coin-20.svg', 20, '1'),
(6, '/uploads/coin-25.svg', 25, '1'),
(7, '/uploads/coin-30.svg', 30, '1'),
(8, '/uploads/coin-35.svg', 35, '1'),
(9, '/uploads/coin-40.svg', 40, '1'),
(10, '/uploads/coin-45.svg', 45, '1'),
(11, '/uploads/coin-50.svg', 50, '1'),
(15, '/uploads/coin-50.svg', 50, '4'),
(16, '/uploads/coin-60.svg', 60, '4'),
(17, '/uploads/coin-70.svg', 70, '4'),
(18, '/uploads/coin-80.svg', 80, '4'),
(19, '/uploads/coin-90.svg', 90, '4'),
(20, '/uploads/coin-100.svg', 100, '4'),
(21, '/uploads/coin-150.svg', 150, '4'),
(22, '/uploads/coin-200.svg', 200, '4'),
(23, '/uploads/coin-250.svg', 250, '4'),
(24, '/uploads/coin-300.svg', 300, '4'),
(25, '/uploads/coin-350.svg', 350, '4'),
(26, '/uploads/coin-400.svg', 400, '4'),
(27, '/uploads/coin-500.svg', 500, '4'),
(28, '/uploads/coin-30.svg', 30, '2'),
(29, '/uploads/coin-35.svg', 35, '2'),
(30, '/uploads/coin-40.svg', 40, '2'),
(31, '/uploads/coin-45.svg', 45, '2'),
(32, '/uploads/coin-50.svg', 50, '2'),
(33, '/uploads/coin-60.svg', 60, '2'),
(34, '/uploads/coin-70.svg', 70, '2'),
(35, '/uploads/coin-80.svg', 80, '2'),
(36, '/uploads/coin-90.svg', 90, '2'),
(37, '/uploads/coin-100.svg', 100, '2'),
(38, '/uploads/coin-60.svg', 60, '3'),
(39, '/uploads/coin-70.svg', 70, '3'),
(40, '/uploads/coin-80.svg', 80, '3'),
(41, '/uploads/coin-90.svg', 90, '3'),
(42, '/uploads/coin-100.svg', 100, '3'),
(43, '/uploads/coin-150.svg', 150, '3'),
(44, '/uploads/coin-200.svg', 200, '3'),
(45, '/uploads/coin-250.svg', 250, '3'),
(46, '/uploads/coin-40.svg', 40, '3'),
(47, '/uploads/coin-50.svg', 50, '3'),
(48, '/uploads/coin-70.svg', 70, '5'),
(49, '/uploads/coin-80.svg', 80, '5'),
(50, '/uploads/coin-90.svg', 90, '5'),
(51, '/uploads/coin-100.svg', 100, '5'),
(53, '/uploads/coin-200.svg', 200, '5'),
(55, '/uploads/coin-300.svg', 300, '5'),
(56, '/uploads/coin-400.svg', 400, '5'),
(57, '/uploads/coin-500.svg', 500, '5'),
(58, '/uploads/coin-600.svg', 600, '5'),
(61, '/uploads/coin-900.svg', 900, '5'),
(62, '/uploads/coin-1000.svg', 1000, '5'),
(63, '/uploads/coin-1.svg', 1, '7'),
(64, '/uploads/coin-2.svg', 2, '7'),
(65, '/uploads/coin-3.svg', 3, '7'),
(66, '/uploads/coin-4.svg', 4, '7'),
(67, '/uploads/coin-5.svg', 5, '7'),
(68, '/uploads/coin-6.svg', 6, '7'),
(69, '/uploads/coin-7.svg', 7, '7'),
(70, '/uploads/coin-8.svg', 8, '7'),
(71, '/uploads/coin-9.svg', 9, '7'),
(72, '/uploads/coin-10.svg', 10, '7');

-- --------------------------------------------------------

--
-- Структура таблицы `last_drops`
--

CREATE TABLE IF NOT EXISTS `last_drops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(255) NOT NULL,
  `case_id` int(255) NOT NULL,
  `items` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=309 ;

-- --------------------------------------------------------

--
-- Структура таблицы `last_vvod`
--

CREATE TABLE IF NOT EXISTS `last_vvod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` int(255) NOT NULL,
  `user` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `avatar` varchar(256) NOT NULL,
  `login` varchar(256) NOT NULL,
  `money` int(255) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `ref_code` varchar(256) NOT NULL,
  `ref_use` varchar(256) DEFAULT NULL,
  `open_box` int(255) NOT NULL,
  `win` int(255) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '2016-11-08 21:32:40',
  `is_yt` int(11) NOT NULL,
  `login2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bonus_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '2016-11-08 19:43:23',
  `bonus_time_drop` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '2016-11-11 18:13:23',
  `free_cases_left` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Структура таблицы `vivod`
--

CREATE TABLE IF NOT EXISTS `vivod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `koshel` varchar(256) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `vivod`
--

INSERT INTO `vivod` (`id`, `user`, `price`, `koshel`, `status`) VALUES
(16, 14, 100, '37100000000', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
