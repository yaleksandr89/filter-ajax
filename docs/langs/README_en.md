# Project: Example Implementation of Filters with Asynchronous Request

<details>
  <summary>How Filtering Works</summary>

![ajax filter is in operation](../img/ajax-filter-main.gif)
</details>

## Choose Language:

| Русский                    | English | Español | 中文 | Français | Deutsch |
|----------------------------|------------|------------|-----------|-------------|----------|
| [Русский](../../README.md) | **Selected** | [Español](README_es.md) | [中文](README_zh.md) | [Français](README_fr.md) | [Deutsch](README_de.md) |

## Tech Stack Used:
- PHP 8
- MySQL (PDO)
- Bootstrap 5.3

## Description:
The project implements product filtering by category, color, and weight using asynchronous requests without additional libraries in native JavaScript. CSS framework Bootstrap 5.3 is used for styling, with a toggle between light and dark themes implemented in the template. 

<details>
  <summary>How theme switching works</summary>

![ajax filter is in operation](../img/ajax-filter-theme-color.gif)
</details>

In the `docs/examples/` directory, you will find two files:
1. `nginx-configuration.conf` - an example configuration for Nginx.
2. `db-config.php.example` - an example configuration file for connecting to the database. You need to change its name to `db-config.php`, copy it to `app/models/database.php`, and provide the relevant data for connecting to the DB.

The project does not use Composer and is written as simply as possible without unnecessary dependencies.

## Running the Project:
1. Add the configuration to your server. In the `docs/examples/` directory, there is an example configuration for Nginx. Follow this example to configure your server.
2. Create a database and import the contents of the `ajax-filter.sql` file located in `docs/mysql-dump/`.
