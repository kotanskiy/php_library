-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 29 2018 г., 17:04
-- Версия сервера: 5.6.38
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `library`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Author`
--

CREATE TABLE `Author` (
  `id` int(11) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Authors_Books`
--

CREATE TABLE `Authors_Books` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Book`
--

CREATE TABLE `Book` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `number_pages` int(4) DEFAULT NULL,
  `genre_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Genre`
--

CREATE TABLE `Genre` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Author`
--
ALTER TABLE `Author`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Authors_Books`
--
ALTER TABLE `Authors_Books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Индексы таблицы `Book`
--
ALTER TABLE `Book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Индексы таблицы `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Author`
--
ALTER TABLE `Author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `Authors_Books`
--
ALTER TABLE `Authors_Books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `Book`
--
ALTER TABLE `Book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `Genre`
--
ALTER TABLE `Genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Authors_Books`
--
ALTER TABLE `Authors_Books`
  ADD CONSTRAINT `authors_books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `Author` (`id`),
  ADD CONSTRAINT `authors_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `Book` (`id`);

--
-- Ограничения внешнего ключа таблицы `Book`
--
ALTER TABLE `Book`
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `Genre` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
