-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Янв 15 2017 г., 02:59
-- Версия сервера: 5.5.53-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `opcash`
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
  `items` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `bad_procent` int(11) NOT NULL DEFAULT '70',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'money',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'money',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `case`
--

INSERT INTO `case` (`id`, `price_min`, `price_max`, `price`, `x10`, `x20`, `x30`, `img`, `items`, `bad_procent`, `type`, `name`) VALUES
(0, 1, 10, 0, 0, 0, 0, '/uploads/coin-10.png', '1,2,3,4,5,6,7,8,9,10', 30, 'money', 'money'),
(1, 1, 50, 20, 2, 4, 6, '/uploads/coin-50.png', '1,5,10,15,20,25,30,35,40,45,50', 70, 'money', 'money'),
(2, 10, 100, 50, 5, 10, 15, '/uploads/coin-100.png', '10,15,20,30,40,50,60,70,80,90,100', 77, 'money', 'money'),
(3, 20, 250, 70, 7, 14, 19, '/uploads/coin-250.png', '20,25,30,40,50,60,70,80,90,100,150,250', 79, 'money', 'money'),
(4, 30, 500, 100, 10, 20, 30, '/uploads/coin-500.png', '30,40,50,60,70,80,90,100,150,200,250,300,350,400,500', 90, 'money', 'money'),
(5, 50, 700, 250, 25, 50, 75, '/uploads/coin-700.png', '50,100,150,200,250,300,350,400,500,600', 77, 'money', 'money'),
(6, 70, 1000, 400, 40, 80, 120, '/uploads/coin-1000.png', '70,100,150,200,250,300,350,400,500,600', 77, 'money', 'money'),
(7, 100, 1500, 500, 50, 100, 150, '/uploads/coin-1500.png', '100,150,200,250,300,350,400,500,600,700,1000,1500', 77, 'money', 'money'),
(8, 100, 2500, 700, 70, 140, 210, '/uploads/coin-2500.png', '100,200,250,300,400,500,700,1000,1500,2000,2500', 77, 'money', 'money'),
(9, 150, 3500, 1000, 100, 200, 300, '/uploads/coin-3500.png', '150,200,350,500,700,1000,2000,3500', 77, 'money', 'money'),
(10, 200, 6000, 1500, 150, 300, 450, '/uploads/coin-6000.png', '200,300,400,500,700,1000,2000,4000,6000', 79, 'money', 'money'),
(11, 500, 15000, 3000, 300, 600, 900, '/uploads/coin-15000.png', '500,600,700,800,900,1000,2500,5000,10000,15000', 85, 'money', 'money'),
(12, 1000, 30000, 7000, 700, 1400, 2100, '/uploads/coin-30000.png', '1000,2000,3000,4000,5000,10000,15000,30000', 85, 'money', 'money'),
(13, 1, 1000, 200, 20, 40, 60, '/uploads/gift-steam-g.png', '1,5,10,50,100,200,300,500,700,gift-steam-g', 78, 'gift', 'Кейс «Steam»'),
(14, 1, 1000, 200, 20, 41, 60, '/uploads/gift-g2a-g.png', '1,5,10,50,100,200,300,500,700,psn-g', 78, 'gift', 'Кейс «G2A»'),
(15, 1, 1000, 200, 20, 40, 60, '/uploads/gift-itunes-g.png', '1,5,10,50,100,200,300,500,700,itunes-g', 78, 'gift', 'Кейс «iTunes»'),
(16, 1, 1000, 200, 20, 40, 67, '/uploads/gift-google-g.png', '1,5,10,50,100,200,300,500,700,google-g', 78, 'gift', 'Кейс «Google play»'),
(17, 1, 2000, 300, 30, 60, 90, '/uploads/Yalinka.png', '1,5,10,50,100,200,300,500,700,Yalinka.png', 75, 'gift', 'Кейс «Елочка»');

-- --------------------------------------------------------

--
-- Структура таблицы `contestants`
--

CREATE TABLE IF NOT EXISTS `contestants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `boxes_opened` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `hour`
--

CREATE TABLE IF NOT EXISTS `hour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `number`) VALUES
(3, 1),
(4, 2),
(5, 3),
(6, 4),
(7, 5),
(8, 6),
(9, 7),
(10, 8),
(11, 9),
(12, 10),
(13, 15),
(14, 20),
(15, 25),
(16, 30),
(17, 35),
(18, 40),
(19, 45),
(20, 50),
(21, 55),
(22, 60),
(23, 65),
(24, 70),
(25, 75),
(26, 80),
(27, 85),
(28, 90),
(29, 95),
(30, 100),
(31, 150),
(32, 200),
(33, 250),
(34, 300),
(35, 350),
(36, 400),
(37, 450),
(38, 500),
(39, 550),
(40, 600),
(41, 650),
(42, 700),
(43, 750),
(44, 800),
(45, 850),
(46, 900),
(47, 950),
(48, 1000),
(49, 1500),
(50, 2000),
(51, 2500),
(52, 3000),
(53, 3500),
(54, 4000),
(55, 4500),
(56, 5000),
(57, 5500),
(58, 6000),
(59, 6500),
(60, 7000),
(61, 7500),
(62, 8000),
(63, 8500),
(64, 9000),
(65, 9500),
(66, 10000),
(67, 15000),
(68, 20000),
(69, 25000),
(70, 30000);

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(256) NOT NULL,
  `price` int(11) NOT NULL,
  `cases_id` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=605 ;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `img`, `price`, `cases_id`) VALUES
(404, '/uploads/coin-1.png', 1, '1'),
(405, '/uploads/coin-5.png', 5, '1'),
(406, '/uploads/coin-10.png', 10, '1'),
(407, '/uploads/coin-15.png', 15, '1'),
(408, '/uploads/coin-20.png', 20, '1'),
(409, '/uploads/coin-25.png', 25, '1'),
(410, '/uploads/coin-30.png', 30, '1'),
(411, '/uploads/coin-35.png', 35, '1'),
(412, '/uploads/coin-40.png', 40, '1'),
(413, '/uploads/coin-45.png', 45, '1'),
(414, '/uploads/coin-50.png', 50, '1'),
(415, '/uploads/coin-10.png', 10, '2'),
(416, '/uploads/coin-15.png', 15, '2'),
(417, '/uploads/coin-20.png', 20, '2'),
(418, '/uploads/coin-30.png', 30, '2'),
(419, '/uploads/coin-40.png', 40, '2'),
(420, '/uploads/coin-50.png', 50, '2'),
(421, '/uploads/coin-60.png', 60, '2'),
(422, '/uploads/coin-70.png', 70, '2'),
(423, '/uploads/coin-80.png', 80, '2'),
(424, '/uploads/coin-90.png', 90, '2'),
(425, '/uploads/coin-100.png', 100, '2'),
(426, '/uploads/coin-20.png', 20, '3'),
(427, '/uploads/coin-25.png', 25, '3'),
(428, '/uploads/coin-30.png', 30, '3'),
(429, '/uploads/coin-40.png', 40, '3'),
(430, '/uploads/coin-50.png', 50, '3'),
(431, '/uploads/coin-60.png', 60, '3'),
(432, '/uploads/coin-70.png', 70, '3'),
(433, '/uploads/coin-80.png', 80, '3'),
(434, '/uploads/coin-90.png', 90, '3'),
(435, '/uploads/coin-100.png', 100, '3'),
(436, '/uploads/coin-150.png', 150, '3'),
(437, '/uploads/coin-250.png', 250, '3'),
(438, '/uploads/coin-30.png', 30, '4'),
(439, '/uploads/coin-40.png', 40, '4'),
(440, '/uploads/coin-50.png', 50, '4'),
(441, '/uploads/coin-60.png', 60, '4'),
(442, '/uploads/coin-70.png', 70, '4'),
(443, '/uploads/coin-80.png', 80, '4'),
(444, '/uploads/coin-90.png', 90, '4'),
(445, '/uploads/coin-100.png', 100, '4'),
(446, '/uploads/coin-150.png', 150, '4'),
(447, '/uploads/coin-200.png', 200, '4'),
(448, '/uploads/coin-250.png', 250, '4'),
(449, '/uploads/coin-300.png', 300, '4'),
(450, '/uploads/coin-350.png', 350, '4'),
(451, '/uploads/coin-400.png', 400, '4'),
(452, '/uploads/coin-500.png', 500, '4'),
(454, '/uploads/coin-50.png', 50, '5'),
(455, '/uploads/coin-100.png', 100, '5'),
(456, '/uploads/coin-150.png', 150, '5'),
(457, '/uploads/coin-200.png', 200, '5'),
(458, '/uploads/coin-250.png', 250, '5'),
(459, '/uploads/coin-300.png', 300, '5'),
(460, '/uploads/coin-350.png', 350, '5'),
(461, '/uploads/coin-400.png', 400, '5'),
(462, '/uploads/coin-500.png', 500, '5'),
(463, '/uploads/coin-600.png', 600, '5'),
(464, '/uploads/coin-70.png', 70, '6'),
(465, '/uploads/coin-100.png', 100, '6'),
(466, '/uploads/coin-150.png', 150, '6'),
(467, '/uploads/coin-200.png', 200, '6'),
(468, '/uploads/coin-250.png', 250, '6'),
(469, '/uploads/coin-300.png', 300, '6'),
(470, '/uploads/coin-350.png', 350, '6'),
(471, '/uploads/coin-400.png', 400, '6'),
(472, '/uploads/coin-500.png', 500, '6'),
(473, '/uploads/coin-600.png', 600, '6'),
(474, '/uploads/coin-100.png', 100, '7'),
(475, '/uploads/coin-150.png', 150, '7'),
(476, '/uploads/coin-200.png', 200, '7'),
(477, '/uploads/coin-250.png', 250, '7'),
(478, '/uploads/coin-300.png', 300, '7'),
(479, '/uploads/coin-350.png', 350, '7'),
(480, '/uploads/coin-400.png', 400, '7'),
(481, '/uploads/coin-500.png', 500, '7'),
(482, '/uploads/coin-600.png', 600, '7'),
(483, '/uploads/coin-700.png', 700, '7'),
(484, '/uploads/coin-1000.png', 1000, '7'),
(485, '/uploads/coin-1500.png', 1500, '7'),
(486, '/uploads/coin-100.png', 100, '8'),
(487, '/uploads/coin-200.png', 200, '8'),
(488, '/uploads/coin-250.png', 250, '8'),
(489, '/uploads/coin-300.png', 300, '8'),
(490, '/uploads/coin-400.png', 400, '8'),
(491, '/uploads/coin-500.png', 500, '8'),
(492, '/uploads/coin-700.png', 700, '8'),
(493, '/uploads/coin-1000.png', 1000, '8'),
(494, '/uploads/coin-1500.png', 1500, '8'),
(495, '/uploads/coin-2000.png', 2000, '8'),
(496, '/uploads/coin-2500.png', 2500, '8'),
(497, '/uploads/coin-150.png', 150, '9'),
(498, '/uploads/coin-200.png', 200, '9'),
(499, '/uploads/coin-350.png', 350, '9'),
(500, '/uploads/coin-500.png', 500, '9'),
(501, '/uploads/coin-700.png', 700, '9'),
(502, '/uploads/coin-1000.png', 1000, '9'),
(503, '/uploads/coin-2000.png', 2000, '9'),
(504, '/uploads/coin-3500.png', 3500, '9'),
(505, '/uploads/coin-200.png', 200, '10'),
(506, '/uploads/coin-300.png', 300, '10'),
(507, '/uploads/coin-400.png', 400, '10'),
(508, '/uploads/coin-500.png', 500, '10'),
(509, '/uploads/coin-700.png', 700, '10'),
(510, '/uploads/coin-1000.png', 1000, '10'),
(511, '/uploads/coin-2000.png', 2000, '10'),
(512, '/uploads/coin-4000.png', 4000, '10'),
(513, '/uploads/coin-6000.png', 6000, '10'),
(514, '/uploads/coin-500.png', 500, '11'),
(515, '/uploads/coin-600.png', 600, '11'),
(516, '/uploads/coin-700.png', 700, '11'),
(517, '/uploads/coin-800.png', 800, '11'),
(518, '/uploads/coin-900.png', 900, '11'),
(519, '/uploads/coin-1000.png', 1000, '11'),
(520, '/uploads/coin-2500.png', 2500, '11'),
(521, '/uploads/coin-5000.png', 5000, '11'),
(522, '/uploads/coin-10000.png', 10000, '11'),
(523, '/uploads/coin-15000.png', 15000, '11'),
(524, '/uploads/coin-1000.png', 1000, '12'),
(525, '/uploads/coin-2000.png', 2000, '12'),
(527, '/uploads/coin-4000.png', 4000, '12'),
(528, '/uploads/coin-5000.png', 5000, '12'),
(529, '/uploads/coin-10000.png', 10000, '12'),
(530, '/uploads/coin-15000.png', 15000, '12'),
(531, '/uploads/coin-30000.png', 30000, '12'),
(533, '/uploads/coin-01.png', 1, '0'),
(534, '/uploads/coin-2.png', 2, '0'),
(535, '/uploads/coin-3.png', 3, '0'),
(536, '/uploads/coin-4.png', 4, '0'),
(537, '/uploads/coin-05.png', 5, '0'),
(538, '/uploads/coin-6.png', 6, '0'),
(539, '/uploads/coin-7.png', 7, '0'),
(540, '/uploads/coin-8.png', 8, '0'),
(541, '/uploads/coin-9.png', 9, '0'),
(542, '/uploads/coin-10.png', 10, '0'),
(553, '/uploads/coin-1.png', 1, '13'),
(554, '/uploads/coin-5.png', 5, '13'),
(555, '/uploads/coin-10.png', 10, '13'),
(556, '/uploads/coin-50.png', 50, '13'),
(557, '/uploads/coin-100.png', 100, '13'),
(558, '/uploads/coin-200.png', 200, '13'),
(559, '/uploads/coin-300.png', 300, '13'),
(560, '/uploads/coin-500.png', 500, '13'),
(561, '/uploads/coin-700.png', 700, '13'),
(562, '/uploads/gift-steam-g.png', 12345, '13'),
(563, '/uploads/coin-1.png', 1, '14'),
(564, '/uploads/coin-5.png', 5, '14'),
(565, '/uploads/coin-10.png', 10, '14'),
(566, '/uploads/coin-50.png', 50, '14'),
(567, '/uploads/coin-100.png', 100, '14'),
(568, '/uploads/coin-200.png', 200, '14'),
(569, '/uploads/coin-300.png', 300, '14'),
(570, '/uploads/coin-500.png', 500, '14'),
(571, '/uploads/coin-700.png', 700, '14'),
(572, '/uploads/gift-g2a-g.png', 12345, '14'),
(573, '/uploads/coin-1.png', 1, '15'),
(574, '/uploads/coin-5.png', 5, '15'),
(575, '/uploads/coin-10.png', 10, '15'),
(576, '/uploads/coin-50.png', 50, '15'),
(577, '/uploads/coin-100.png', 100, '15'),
(578, '/uploads/coin-200.png', 200, '15'),
(579, '/uploads/coin-300.png', 300, '15'),
(580, '/uploads/coin-500.png', 500, '15'),
(581, '/uploads/coin-700.png', 700, '15'),
(582, '/uploads/gift-itunes-g.png', 12345, '15'),
(583, '/uploads/coin-1.png', 1, '16'),
(584, '/uploads/coin-5.png', 5, '16'),
(585, '/uploads/coin-10.png', 10, '16'),
(586, '/uploads/coin-50.png', 50, '16'),
(587, '/uploads/coin-100.png', 100, '16'),
(588, '/uploads/coin-200.png', 200, '16'),
(589, '/uploads/coin-300.png', 300, '16'),
(590, '/uploads/coin-500.png', 500, '16'),
(591, '/uploads/coin-700.png', 700, '16'),
(592, '/uploads/gift-google-g.png', 12345, '16'),
(593, '/uploads/coin-3000.png', 3000, '12'),
(594, '/uploads/coin-1.png', 1, '17'),
(595, '/uploads/coin-5.png', 5, '17'),
(596, '/uploads/coin-10.png', 10, '17'),
(597, '/uploads/coin-50.png', 50, '17'),
(598, '/uploads/coin-100.png', 100, '17'),
(599, '/uploads/coin-200.png', 200, '17'),
(600, '/uploads/coin-300.png', 300, '17'),
(601, '/uploads/coin-500.png', 500, '17'),
(602, '/uploads/coin-700.png', 700, '17'),
(603, '/uploads/Yalinka.png', 12345, '17'),
(604, '/uploads/coin-1000.png', 1000, '17');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `last_gifts`
--

CREATE TABLE IF NOT EXISTS `last_gifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Gift',
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `last_vvod`
--

CREATE TABLE IF NOT EXISTS `last_vvod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` int(255) NOT NULL,
  `user` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `site_settings`
--

CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_profit` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_profit`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `places` int(11) NOT NULL,
  `jackpot` int(11) NOT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `ticket`
--

INSERT INTO `ticket` (`id`, `name`, `price`, `places`, `jackpot`, `created_at`, `updated_at`) VALUES
(1, 'Новичок', 20, 300, 1500, '', '2016-12-27 15:01:33'),
(2, 'Блатной ', 30, 275, 3000, '', '2016-12-22 18:16:29'),
(3, 'Мажор', 50, 240, 5000, '', '2016-12-22 18:18:14');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket_places`
--

CREATE TABLE IF NOT EXISTS `ticket_places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket` int(11) NOT NULL,
  `place` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `user_avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ticket_users`
--

CREATE TABLE IF NOT EXISTS `ticket_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `created_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ticket_winner`
--

CREATE TABLE IF NOT EXISTS `ticket_winner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `winning_ticket` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `refferal_money` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deposit` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `winner`
--

CREATE TABLE IF NOT EXISTS `winner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
