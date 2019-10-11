-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 11 2019 г., 23:28
-- Версия сервера: 10.4.8-MariaDB
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ajax-filter`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id_category`, `category`) VALUES
(3, 'Laptop'),
(2, 'Monoblock'),
(1, 'System unit');

-- --------------------------------------------------------

--
-- Структура таблицы `colors`
--

CREATE TABLE `colors` (
  `id_color` int(11) NOT NULL,
  `color` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id_color`, `color`) VALUES
(3, 'Black'),
(6, 'Blue'),
(5, 'Green'),
(1, 'Metallic'),
(4, 'Red'),
(2, 'White');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `color` varchar(30) NOT NULL,
  `weight` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id_product`, `category`, `title`, `color`, `weight`) VALUES
(14, 'System unit', '№1', 'Metallic', '5kg'),
(15, 'Monoblock', '№2', 'Black', '5kg'),
(16, 'Laptop', '№3', 'Metallic', '1kg'),
(17, 'System unit', '№4', 'Black', '5kg'),
(18, 'Monoblock', '№5', 'Blue', '3kg'),
(19, 'Monoblock', '№6', 'Blue', '5kg'),
(20, 'Laptop', '№7', 'White', '3kg'),
(21, 'Monoblock', '№8', 'Green', '7kg'),
(22, 'Laptop', '№9', 'White', '5kg'),
(23, 'System unit', '№10', 'Metallic', '9kg');

-- --------------------------------------------------------

--
-- Структура таблицы `weights`
--

CREATE TABLE `weights` (
  `id_weight` int(11) NOT NULL,
  `weight` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `weights`
--

INSERT INTO `weights` (`id_weight`, `weight`) VALUES
(1, '1kg'),
(2, '3kg'),
(3, '5kg'),
(4, '7kg'),
(5, '9kg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`),
  ADD UNIQUE KEY `categories_category_uindex` (`category`);

--
-- Индексы таблицы `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id_color`),
  ADD UNIQUE KEY `colors_color_uindex` (`color`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `products___fk__categories` (`category`),
  ADD KEY `products___fk__colors` (`color`),
  ADD KEY `products___fk__weights` (`weight`);

--
-- Индексы таблицы `weights`
--
ALTER TABLE `weights`
  ADD PRIMARY KEY (`id_weight`),
  ADD UNIQUE KEY `weights_weight_uindex` (`weight`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `colors`
--
ALTER TABLE `colors`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `weights`
--
ALTER TABLE `weights`
  MODIFY `id_weight` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products___fk__categories` FOREIGN KEY (`category`) REFERENCES `categories` (`category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products___fk__colors` FOREIGN KEY (`color`) REFERENCES `colors` (`color`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products___fk__weights` FOREIGN KEY (`weight`) REFERENCES `weights` (`weight`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
