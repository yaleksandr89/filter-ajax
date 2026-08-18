# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![CI](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml/badge.svg)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

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
- Native JavaScript
- Bootstrap 5.3.3
- Nginx + PHP-FPM для приведённого примера запуска

## Быстрый старт

1. Создайте базу данных и импортируйте [`docs/mysql-dump/ajax-filter.sql`](docs/mysql-dump/ajax-filter.sql).
2. Скопируйте [`docs/examples/db-config.php.example`](docs/examples/db-config.php.example) в `app/models/database.php`.
3. Укажите в `app/models/database.php` локальные параметры подключения к базе данных.
4. Настройте document root веб-сервера на каталог `public/`. Пример для Nginx находится в [`docs/examples/nginx-configuration.conf`](docs/examples/nginx-configuration.conf).
5. При необходимости измените путь `fastcgi_pass` в примере Nginx под установленный у вас PHP-FPM.
6. Откройте приложение через настроенный локальный host.

`app/models/database.php` исключён из Git и не должен содержать production credentials в репозитории.

## Как работает фильтрация

При изменении любого фильтра браузер отправляет запрос на `/ajax-filter`. Сервер принимает только поддерживаемые поля `category`, `color` и `weight`, сохраняет активные фильтры в сессии и выполняет параметризованный PDO-запрос.

<details>
  <summary>Демонстрация фильтрации</summary>

![AJAX Filter demo](docs/img/ajax-filter-main.gif)
</details>

## Переключение темы

Интерфейс поддерживает светлую, тёмную и системную темы средствами Bootstrap.

<details>
  <summary>Демонстрация переключения темы</summary>

![AJAX Filter theme demo](docs/img/ajax-filter-theme-color.gif)
</details>

## Проверки

GitHub Actions проверяет:

- синтаксис PHP;
- синтаксис JavaScript;
- regression tests для фильтров, SQL-параметризации, controller validation и HTML escaping.

## Лицензия

Проект распространяется по лицензии [MIT](LICENSE.md).
