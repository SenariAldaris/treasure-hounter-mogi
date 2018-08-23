-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Хост: p300974.mysql.ihc.ru
-- Время создания: Апр 04 2015 г., 01:08
-- Версия сервера: 5.5.41-37.0-log
-- Версия PHP: 5.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `p300974_testsh`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answerers`
--

CREATE TABLE IF NOT EXISTS `answerers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Дамп данных таблицы `answerers`
--



-- --------------------------------------------------------

--
-- Структура таблицы `money_shop`
--

CREATE TABLE IF NOT EXISTS `money_shop` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_pay` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cnt_goods` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_goods` text COLLATE utf8_unicode_ci NOT NULL,
  `id_goods` varchar(222) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

--
-- Дамп данных таблицы `money_shop`
--


-- --------------------------------------------------------

--
-- Структура таблицы `question_categories`
--

CREATE TABLE IF NOT EXISTS `question_categories` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `parent` smallint(6) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(40) NOT NULL,
  `shown` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `parent` (`parent`),
  KEY `shown` (`shown`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `question_categories`
--

INSERT INTO `question_categories` (`id`, `parent`, `title`, `alias`, `shown`) VALUES
(1, NULL, 'milspec', 'milspec', 1),
(2, NULL, 'restricted', 'restricted', 1),
(3, NULL, 'classified', 'classified', 1),
(4, NULL, 'covert', 'covert', 1),
(5, NULL, 'rare', 'rare', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` smallint(5) unsigned NOT NULL,
  `answerer` int(10) unsigned NOT NULL,
  `title` tinytext NOT NULL,
  `text` text NOT NULL,
  `answer` text NOT NULL,
  `created` varchar(55) NOT NULL,
  `changed` datetime NOT NULL,
  `answered` datetime DEFAULT NULL,
  `author` varchar(40) NOT NULL,
  `shown` tinyint(4) NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pastor` (`answerer`),
  KEY `created` (`created`),
  KEY `answered` (`answered`),
  KEY `shown` (`shown`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Дамп данных таблицы `questions`
--


-- --------------------------------------------------------

--
-- Структура таблицы `users_list`
--

CREATE TABLE IF NOT EXISTS `users_shop` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `money` int(10) NOT NULL DEFAULT '0',
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

--
-- Дамп данных таблицы `users_shop`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
