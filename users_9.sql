-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 30 2020 г., 21:45
-- Версия сервера: 10.4.14-MariaDB
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `users`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brand`
--

CREATE TABLE `brand` (
  `id_brand` int(10) UNSIGNED NOT NULL,
  `brand` varchar(64) NOT NULL,
  `average_score` float DEFAULT NULL COMMENT 'средний балл',
  `wheel_drive` int(1) UNSIGNED DEFAULT 0,
  `number_of_passengers` int(3) UNSIGNED DEFAULT 0,
  `trunk_volume` int(5) DEFAULT -1,
  `img_path` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `brand`
--

INSERT INTO `brand` (`id_brand`, `brand`, `average_score`, `wheel_drive`, `number_of_passengers`, `trunk_volume`, `img_path`) VALUES
(1, 'Niva', 3.33333, 3, 5, 150, 'uploads/niva.jpg'),
(2, 'Matiz', 4, 2, 4, 100, 'uploads/matiz.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `car`
--

CREATE TABLE `car` (
  `id_car` int(11) NOT NULL,
  `id_brand` int(10) UNSIGNED NOT NULL,
  `id_configuration` int(11) NOT NULL,
  `id_salon` int(11) DEFAULT NULL,
  `release_date` varchar(10) NOT NULL,
  `car_cost` bigint(12) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `car`
--

INSERT INTO `car` (`id_car`, `id_brand`, `id_configuration`, `id_salon`, `release_date`, `car_cost`) VALUES
(1, 1, 2, 1, '12.10.2002', 1200000),
(2, 1, 1, 1, '12.12.2012', 600000),
(3, 2, 3, 1, '20.12.2012', 300000),
(4, 2, 4, 1, '09.08.2008', 250000),
(5, 2, 3, 2, '06.05.2014', 350000);

-- --------------------------------------------------------

--
-- Структура таблицы `configuration`
--

CREATE TABLE `configuration` (
  `id_configuration` int(11) NOT NULL COMMENT 'комплектация',
  `id_brand` int(11) NOT NULL,
  `title` varchar(20) NOT NULL COMMENT 'название',
  `description` varchar(100) NOT NULL COMMENT 'описание'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `configuration`
--

INSERT INTO `configuration` (`id_configuration`, `id_brand`, `title`, `description`) VALUES
(1, 1, 'Classic', 'bla-bla-bla\r\nbla-bla'),
(2, 1, 'Luxe', 'super bla-bla-bla'),
(3, 2, 'блек идишен', 'Вообще классная тема'),
(4, 2, 'Gold идишен', 'va-a-a-au');

-- --------------------------------------------------------

--
-- Структура таблицы `engine`
--

CREATE TABLE `engine` (
  `id_engine` int(11) NOT NULL,
  `id_configuration` int(11) NOT NULL,
  `id_factory` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `power` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `engine`
--

INSERT INTO `engine` (`id_engine`, `id_configuration`, `id_factory`, `title`, `power`) VALUES
(1, 1, 1, 'Ваз-2106', 80),
(2, 2, 1, 'Ваз-2130', 82),
(3, 3, 1, 'Ваз-наш', 90),
(4, 4, 2, 'Не-наш', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `factory`
--

CREATE TABLE `factory` (
  `id_factory` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `address` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `factory`
--

INSERT INTO `factory` (`id_factory`, `title`, `address`) VALUES
(1, 'ВАЗ', 'ул Арама 100'),
(2, 'БЕЗАЛ', 'ул. Братько 212');

-- --------------------------------------------------------

--
-- Структура таблицы `review`
--

CREATE TABLE `review` (
  `id_review` int(11) NOT NULL,
  `id_brand` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `score` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `review`
--

INSERT INTO `review` (`id_review`, `id_brand`, `id_user`, `text`, `score`) VALUES
(1, 2, 2, 'Ну такое себе', 3),
(2, 2, 2, '123', 3),
(3, 1, 2, '123', 1),
(4, 1, 2, '123', 1),
(5, 1, 2, '123', 1),
(6, 1, 2, '2123', 1),
(7, 1, 2, '12', 1),
(8, 1, 2, '12', 1),
(9, 1, 2, '12', 1),
(10, 1, 1, 'W', 4),
(11, 2, 1, 'Yjhv', 4),
(12, 1, 10, 'good', 5),
(13, 2, 10, 'asd', 5),
(14, 2, 10, '12', 5),
(15, 2, 10, '123as', 5),
(16, 2, 10, 'sa', 5),
(17, 2, 10, '200000', 5),
(18, 2, 10, '1', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `salon`
--

CREATE TABLE `salon` (
  `id_salon` int(11) NOT NULL,
  `address` varchar(64) NOT NULL,
  `work_schedule` varchar(20) NOT NULL COMMENT 'график работы'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `salon`
--

INSERT INTO `salon` (`id_salon`, `address`, `work_schedule`) VALUES
(1, 'ул. Гурама 52', '8.00 - 22.00'),
(2, 'ул.Тараканья 59', '9.00 - 21.00');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_vk` int(10) UNSIGNED DEFAULT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `id_vk`, `login`, `password`) VALUES
(1, 223270242, 'Admin', '81dc9bdb52d04dc20036dbd8313ed055'),
(2, NULL, 'klara', 'd93591bdf7860e1e4ee2fca799911215'),
(5, NULL, 'Walera', '3a1200279b514ca4409dd8136527046a'),
(7, NULL, 'Adam', '3a1200279b514ca4409dd8136527046a'),
(8, NULL, 'Ivan', '3a1200279b514ca4409dd8136527046a'),
(9, NULL, 'Ivann', '3a1200279b514ca4409dd8136527046a'),
(10, NULL, 'as', '3a1200279b514ca4409dd8136527046a');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id_brand`),
  ADD UNIQUE KEY `brand` (`brand`);

--
-- Индексы таблицы `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id_car`);

--
-- Индексы таблицы `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id_configuration`);

--
-- Индексы таблицы `engine`
--
ALTER TABLE `engine`
  ADD PRIMARY KEY (`id_engine`);

--
-- Индексы таблицы `factory`
--
ALTER TABLE `factory`
  ADD PRIMARY KEY (`id_factory`);

--
-- Индексы таблицы `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`);

--
-- Индексы таблицы `salon`
--
ALTER TABLE `salon`
  ADD PRIMARY KEY (`id_salon`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brand`
--
ALTER TABLE `brand`
  MODIFY `id_brand` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `car`
--
ALTER TABLE `car`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id_configuration` int(11) NOT NULL AUTO_INCREMENT COMMENT 'комплектация', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `engine`
--
ALTER TABLE `engine`
  MODIFY `id_engine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `factory`
--
ALTER TABLE `factory`
  MODIFY `id_factory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `salon`
--
ALTER TABLE `salon`
  MODIFY `id_salon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
