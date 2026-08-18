# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![CI](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml/badge.svg)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](../../LICENSE.md)

<p align="center">
  <img
    src="../img/filter-ajax-readme-cover.png"
    alt="AJAX Filter — secure dynamic filtering for PHP with AJAX and database-backed lists"
    width="100%"
  >
</p>

## Choose language

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | **Selected** | [Español](README_es.md) | [中文](README_zh.md) | [Français](README_fr.md) | [Deutsch](README_de.md) |

## Description

`AJAX Filter` is a small PHP demo project that filters products by category, color, and weight without reloading the page. The client uses native JavaScript and `fetch()`, while the server uses PHP and PDO.

The project intentionally uses neither Composer nor JavaScript libraries and keeps a simple structure suitable for learning basic AJAX filtering.

## Stack

- PHP 8.5
- MySQL / MariaDB through PDO
- Native JavaScript
- Bootstrap 5.3.3
- Nginx + PHP-FPM for the provided server example

## Quick start

1. Create a database and import [`docs/mysql-dump/ajax-filter.sql`](../mysql-dump/ajax-filter.sql).
2. Copy [`docs/examples/db-config.php.example`](../examples/db-config.php.example) to `app/models/database.php`.
3. Set your local database connection parameters in `app/models/database.php`.
4. Configure the web server document root to the `public/` directory. An Nginx example is available in [`docs/examples/nginx-configuration.conf`](../examples/nginx-configuration.conf).
5. Adjust the `fastcgi_pass` path in the Nginx example if your PHP-FPM socket is different.
6. Open the application through the configured local host.

`app/models/database.php` is ignored by Git and must not contain production credentials committed to the repository.

## How filtering works

When a filter changes, the browser sends a request to `/ajax-filter`. The server accepts only the supported `category`, `color`, and `weight` fields, stores active filters in the session, and executes a parameterized PDO query.

<details>
  <summary>Filtering demo</summary>

![AJAX Filter demo](../img/ajax-filter-main.gif)
</details>

## Theme switching

The interface supports light, dark, and system themes using Bootstrap.

<details>
  <summary>Theme switching demo</summary>

![AJAX Filter theme demo](../img/ajax-filter-theme-color.gif)
</details>

## Checks

GitHub Actions validates:

- PHP syntax;
- JavaScript syntax;
- regression tests for filtering, SQL parameterization, controller validation, and HTML escaping.

## License

The project is distributed under the [MIT](../../LICENSE.md) license.
