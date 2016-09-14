-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 14 2016 г., 18:41
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
-- Структура таблицы `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lessons`
--

INSERT INTO `lessons` (`id`, `user_id`, `name`, `date`) VALUES
(1, 0, 'test', '2016-09-14 08:58:22'),
(2, 0, 'english', '2016-09-14 08:59:10'),
(3, 0, 'english', '2016-09-14 13:24:30'),
(4, 0, 'english', '2016-09-14 13:25:28'),
(5, 1, 'english', '2016-09-14 13:28:46');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL DEFAULT '',
  `lastname` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `user_id`, `firstname`, `lastname`, `status`, `date`) VALUES
(1, 1, 'Slawik', '', 1, '2016-09-14 13:54:35'),
(2, 1, 'Slawik', 'Sivinyuk', 1, '2016-09-14 13:58:50');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL DEFAULT '',
  `lesson` tinyint(2) NOT NULL DEFAULT '0',
  `permanent` tinyint(2) NOT NULL DEFAULT '0',
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `permanent_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `message`, `lesson`, `permanent`, `start`, `end`, `date`, `permanent_update`, `status`) VALUES
(8, 0, 'сентябрь', 0, 0, '2016-09-15 08:03:00', '2016-09-15 02:29:00', '2016-09-13 15:27:46', '0000-00-00 00:00:00', 1),
(9, 0, 'заметка', 0, 0, '2016-09-05 22:00:00', '2016-09-05 23:00:00', '2016-09-13 15:30:59', '0000-00-00 00:00:00', 1),
(10, 0, '1111', 0, 0, '2016-10-05 09:00:00', '2016-10-04 23:00:00', '2016-09-13 15:31:26', '0000-00-00 00:00:00', 1),
(11, 1, 'заметка у цу', 0, 0, '2016-09-08 09:10:00', '2016-09-08 17:00:00', '2016-09-14 13:37:50', '0000-00-00 00:00:00', 1),
(12, 1, 'Постоянно в понедельник', 0, 1, '2016-08-17 08:05:00', '2016-08-17 09:05:00', '2016-08-17 14:21:26', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(250) NOT NULL DEFAULT '',
  `lastname` varchar(250) NOT NULL DEFAULT '',
  `password` varchar(250) NOT NULL DEFAULT '',
  `country` int(11) DEFAULT NULL,
  `email` varchar(250) NOT NULL DEFAULT '',
  `phone` varchar(250) NOT NULL DEFAULT '',
  `birthday` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `bad_auth` tinyint(2) NOT NULL DEFAULT '0',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(250) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `password`, `country`, `email`, `phone`, `birthday`, `status`, `bad_auth`, `last_login`, `last_modified`, `last_ip`, `date`) VALUES
(1, 'Slawik', 'Sivinyuk', '25a276e8f671957cbff0b4b973e2bc30:PzIU1dpJ79txE7j5', NULL, '279229931@qip.ru', '', '0000-00-00 00:00:00', 1, 0, '2016-09-14 13:27:46', '0000-00-00 00:00:00', '127.0.0.1', '2016-09-14 12:16:52');

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
(3, 'f17240fae9c1af61a180aa1d91f63a0a', 1473867424, 1, '279229931@qip.ru', 0, '', 'user', 1, 0, 0, '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT для таблицы `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `x_session`
--
ALTER TABLE `x_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
