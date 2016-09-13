-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 13 2016 г., 18:42
-- Версия сервера: 5.6.26-log
-- Версия PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tasktable`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL DEFAULT '',
  `lesson` tinyint(2) NOT NULL DEFAULT '0',
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `message`, `lesson`, `start`, `end`, `date`, `status`) VALUES
(8, 0, 'сентябрь', 0, '2016-09-15 08:03:00', '2016-09-15 02:29:00', '2016-09-13 15:27:46', 1),
(9, 0, 'заметка', 0, '2016-09-05 22:00:00', '2016-09-05 23:00:00', '2016-09-13 15:30:59', 1),
(10, 0, '1111', 0, '2016-10-05 09:00:00', '2016-10-04 23:00:00', '2016-09-13 15:31:26', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(250) NOT NULL DEFAULT '',
  `lastname` varchar(250) NOT NULL DEFAULT '',
  `fathersname` varchar(255) NOT NULL DEFAULT '',
  `inn` varchar(100) NOT NULL DEFAULT '',
  `passport` varchar(255) NOT NULL DEFAULT '',
  `upass` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(250) NOT NULL DEFAULT '',
  `pin_code` varchar(20) NOT NULL,
  `country` int(11) DEFAULT NULL,
  `currency` tinyint(4) DEFAULT NULL,
  `email` varchar(250) NOT NULL DEFAULT '',
  `timezone` varchar(30) NOT NULL DEFAULT '',
  `phone_prefix` int(11) DEFAULT NULL,
  `phone_area` int(6) DEFAULT NULL,
  `phone` varchar(250) NOT NULL DEFAULT '',
  `verified_phone` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `birthday` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `level` tinyint(3) NOT NULL DEFAULT '0',
  `verified` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `demo_expire` timestamp NULL DEFAULT NULL,
  `subscribe` tinyint(4) NOT NULL DEFAULT '0',
  `bad_auth` tinyint(2) NOT NULL DEFAULT '0',
  `bad_auth_time` int(11) DEFAULT NULL,
  `bad_withdraw_answer` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(250) DEFAULT NULL,
  `partner` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL DEFAULT '0',
  `friend` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `afftrack` varchar(50) NOT NULL DEFAULT '',
  `offer_notification` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `close_offer_notification` tinyint(2) NOT NULL DEFAULT '0',
  `withdrawal_allow` tinyint(2) NOT NULL DEFAULT '1',
  `gid` int(10) NOT NULL DEFAULT '1',
  `crm_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `type_reg` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rule` varchar(255) NOT NULL DEFAULT '',
  `rule_status` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `utm` text,
  `mvc_card` varchar(20) NOT NULL DEFAULT '',
  `key` varchar(40) DEFAULT NULL,
  `robot` tinyint(4) NOT NULL DEFAULT '0',
  `robot_settings` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `x_session`
--

CREATE TABLE `x_session` (
  `id` int(11) NOT NULL,
  `session_id` varchar(45) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL DEFAULT '',
  `guest` tinyint(4) NOT NULL DEFAULT '1',
  `guest_key` varchar(50) NOT NULL DEFAULT '',
  `usertype` varchar(50) NOT NULL DEFAULT '',
  `status` int(2) DEFAULT '1',
  `remember` tinyint(4) NOT NULL DEFAULT '0',
  `gid` int(10) NOT NULL DEFAULT '1',
  `ip` varchar(20) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `x_session`
--

INSERT INTO `x_session` (`id`, `session_id`, `time`, `userid`, `username`, `guest`, `guest_key`, `usertype`, `status`, `remember`, `gid`, `ip`, `user_agent`) VALUES
(221936, 'jsp0tifpi6c5lp41nh3qrdhqr7', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221938, '8u4a3u3i01fhcpeqeflciqluo6', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221932, 'rklpnt2anua5klgg5dkonb76o5', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221928, '4s4776jfiseovp70m738r4pp52', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221924, 'l1j5i5oigkhrntvtti0eshncr3', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221927, 'q4l1vacg15msn44povhojul7a2', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221920, '87e178e6e3be373f84bb142227d3b047', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221967, 'v2be5rs79knl4peq738ski3b31', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221943, 'dharu2e1lhluqj090og026bbt6', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221953, '6r16u6nnumfqh7mrgg6noi8950', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221975, '6v91hjh86fk7181coa0hoaqmm2', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 30, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221973, '59sq5obcducs7rf78bimtsh1s2', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0'),
(221978, 'nsdhlnunqoe3ni8u02btelg6o0', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0'),
(221979, 'u88uuegk6pn8s463oop5ik7806', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0'),
(221986, '7793b391b26ba18dffc663b66fac3b93', 1473781157, 0, '', 1, '', '', 1, 0, 0, NULL, NULL),
(221982, 'v3i59u7ssffcvkhnobceojmsb1', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0'),
(221983, 'i6gushfqetklvogvoccc4fh4e4', NULL, 1, 'mofo', 0, '', 'admin', 1, 0, 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `phone` (`phone`);

--
-- Индексы таблицы `x_session`
--
ALTER TABLE `x_session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session` (`session_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `x_session`
--
ALTER TABLE `x_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221987;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
