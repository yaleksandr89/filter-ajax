# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![CI](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml/badge.svg)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

<p align="center">
  <img
    src="docs/img/filter-ajax-readme-cover.png"
    alt="AJAX Filter — secure dynamic filtering for PHP with AJAX and database-backed lists"
    width="100%"
  >
</p>

## Выберите язык

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| **Выбран** | [English](docs/langs/README_en.md) | [Español](docs/langs/README_es.md) | [中文](docs/langs/README_zh.md) | [Français](docs/langs/README_fr.md) | [Deutsch](docs/langs/README_de.md) |

## Описание

`AJAX Filter` — небольшой демонстрационный PHP-проект с фильтрацией товаров по категории, цвету и весу без перезагрузки страницы. Клиентская часть использует нативный JavaScript и `fetch()`, серверная — PHP и PDO.

Проект намеренно не использует Composer или JavaScript-библиотеки и сохраняет простую структуру, подходящую для изучения базовой AJAX-фильтрации.

## Стек

- PHP 8.5
- MySQL / MariaDB через PDO
- Нативный JavaScript
- Нативный CSS
- Nginx + PHP-FPM для приведённого примера запуска

## Быстрый старт

1. Создайте базу данных и импортируйте [`docs/mysql-dump/ajax-filter.sql`](docs/mysql-dump/ajax-filter.sql).
2. Скопируйте [`config/database.php.example`](config/database.php.example) в `config/database.php`.
3. Укажите в `config/database.php` локальные параметры подключения к базе данных. Этот файл исключён из Git.
4. Либо задайте `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` и `DB_CHARSET`; значения окружения переопределяют значения из файла.
5. Настройте document root веб-сервера и `fastcgi_pass` под локальную среду. Пример для Nginx находится в [`docs/examples/nginx-configuration.conf`](docs/examples/nginx-configuration.conf).
6. Откройте приложение через настроенный локальный host.

## Как работает фильтрация

При изменении любого фильтра браузер отправляет запрос на `/ajax-filter`. Сервер принимает только поддерживаемые поля `category`, `color` и `weight`, сохраняет активные фильтры в сессии и выполняет параметризованный PDO-запрос.

<details>
  <summary>Демонстрация фильтрации</summary>

![AJAX Filter demo](docs/img/ajax-filter-main.gif)
</details>

## Переключение темы

Интерфейс поддерживает светлую, тёмную и системную темы средствами проектных CSS и нативного JavaScript; системная тема следует настройкам ОС.

<details>
  <summary>Демонстрация переключения темы</summary>

![AJAX Filter theme demo](docs/img/ajax-filter-theme-color.gif)
</details>

## Проверки

GitHub Actions проверяет:

- синтаксис PHP;
- синтаксис JavaScript;
- regression tests для нормализации фильтров и семантики сессии, SQL allowlisting/параметризации и детерминированного SQL-контракта, приоритета/валидации конфигурации БД, HTML escaping и нативного autoload.

## Лицензия

Проект распространяется по лицензии [MIT](LICENSE.md).
