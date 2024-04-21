# Проект: Пример реализации фильтров с применением асинхронного запроса

<details>
  <summary>Как работает фильтрация</summary>

![ajax filter is in operation](./docs/img/ajax-filter-main.gif)
</details>

## Выберите язык:

| Русский  | English                              | Español                              | 中文                              | Français                              | Deutsch                              |
|----------|--------------------------------------|--------------------------------------|---------------------------------|---------------------------------------|--------------------------------------|
| **Выбран** | [English](./docs/langs/README_en.md) | [Español](./docs/langs/README_es.md) | [中文](./docs/langs/README_zh.md) | [Français](./docs/langs/README_fr.md) | [Deutsch](./docs/langs/README_de.md) |

## Используемый стек:

- PHP 8
- Mysql (PDO)
- Bootstrap 5.3

## Описание:

Проект реализует фильтрацию товаров по категории, цвету и весу с применением асинхронных запросов без использования дополнительных библиотек на нативном JavaScript. CSS-фреймворк Bootstrap 5.3 используется для стилизации, с возможностью переключения между светлой и темной темами, реализованной в шаблоне. 

<details>
  <summary>Как работает переключение темы</summary>

![ajax filter is in operation](./docs/img/ajax-filter-theme-color.gif)
</details>

В каталоге `docs/examples/` вы найдете два файла:

1. `nginx-configuration.conf` - пример конфигурации для `nginx`.
2. `db-config.php.example` - пример файла конфигурации для подключения к базе данных. Вам необходимо изменить его имя на `db-config.php`, скопировать его в `app/models/database.php` и указать соответствующие данные для подключения к БД.

Проект не использует `composer` и написан максимально просто без излишних зависимостей.

## Запуск проекта:

1. Добавьте конфигурацию на ваш сервер. В каталоге `docs/examples/` есть пример конфигурации для Nginx. Следуйте этому примеру, чтобы настроить свой сервер.
2. Создайте базу данных и импортируйте содержимое файла `ajax-filter.sql`, который находится в `docs/mysql-dump/`.
