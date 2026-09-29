# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4.svg?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![JavaScript](https://img.shields.io/badge/JavaScript-Native-F7DF1E.svg?style=flat-square&logo=javascript&logoColor=F7DF1E)](https://developer.mozilla.org/docs/Web/JavaScript)
[![MariaDB](https://img.shields.io/badge/MariaDB-12.3-003545.svg?style=flat-square&logo=mariadb&logoColor=white)](https://mariadb.org/)
[![Docker](https://img.shields.io/badge/Docker-Compose-2496ED.svg?style=flat-square&logo=docker&logoColor=white)](https://www.docker.com/)
[![CI](https://img.shields.io/github/actions/workflow/status/yaleksandr89/filter-ajax/ci.yml?style=flat-square&label=CI)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

<p align="center">
  <img
    src="docs/img/filter-ajax-readme-cover.png"
    alt="AJAX Filter — каталог товаров с AJAX-фильтрацией на чистом PHP"
    width="100%"
  >
</p>

## Выберите язык

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| **Выбран** | [English](docs/langs/README_en.md) | [Español](docs/langs/README_es.md) | [中文](docs/langs/README_zh.md) | [Français](docs/langs/README_fr.md) | [Deutsch](docs/langs/README_de.md) |

`AJAX Filter` — небольшой PHP-каталог, в котором товары фильтруются по категории, цвету и весу без перезагрузки страницы. Это компактный пример связки PHP, PDO, MariaDB и нативного JavaScript — без Composer и frontend-библиотек.

## Возможности

- Фильтрация товаров по категории, цвету и весу через `fetch()` без перезагрузки страницы.
- Сохранение выбранных фильтров в PHP-сессии.
- Асинхронный сброс всех активных фильтров.
- Два режима базы данных: пустая схема и демонстрационные данные.
- Локальный Docker-стек с Nginx, PHP-FPM, MariaDB и Xdebug.

## Быстрый старт

Нужны Git, Docker с Compose v2 и `make`.

| Шаг | Команда | Назначение |
|---|---|---|
| 1 | `git clone https://github.com/yaleksandr89/filter-ajax.git` | Клонировать репозиторий. |
| 2 | `cd filter-ajax` | Перейти в каталог проекта. |
| 3 | `make build` | Собрать локальные Docker-образы. |
| 4 | `make up` | Запустить стек и дождаться готовности сервисов. |

Откройте [http://127.0.0.1:8080](http://127.0.0.1:8080). По умолчанию запускается `DB_MODE=demo`; для пустой схемы используйте `make up DB_MODE=schema` на новом томе. Подробности о томах, настройке и диагностике — в [руководстве по разработке](docs/development.md).

## Архитектура и структура проекта

С устройством приложения, потоком запросов и работой с фильтрами, сессией, PDO и шаблонами можно познакомиться в отдельном [описании архитектуры](docs/architecture.md).

## Проверки

Основные проверки собраны в Makefile:

| Проверка | Команда |
|---|---|
| Итоговая Compose-конфигурация | `make config` |
| Регрессионные PHP-тесты | `make php CMD="tests/run.php"` |
| Runtime smoke уже запущенного стека | `make smoke` |

CI для push и pull request в `master` проверяет PHP и JavaScript, регрессионные тесты, Docker-конфигурацию и оба режима базы.

## Что намеренно оставлено простым

- Нет PHP-фреймворка и ORM.
- Нет Composer-пакетов.
- Нет JavaScript-зависимостей и frontend-фреймворка.
- Нет отдельного API-слоя.

Цель проекта — показать небольшой законченный поток фильтрации на базовых возможностях PHP, PDO и нативного JavaScript.

## Обратная связь

- Воспроизводимые ошибки — [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).
- Вопросы и идеи — [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).

---

<p align="center">
  Если проект оказался полезен, поставьте звезду на GitHub — так его будет проще найти другим разработчикам.<br>
  🤘
</p>
