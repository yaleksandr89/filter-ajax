# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![CI](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml/badge.svg)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
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
- Русский и английский интерфейс с переключением без перезагрузки страницы.
- Светлая, системная и тёмная темы.
- Демо- и пустой `schema`-режимы базы данных.
- Локальный Docker-стек с Nginx, PHP-FPM, MariaDB и Xdebug.

## Быстрый старт

Нужны Git, Docker с Compose v2 и `make`.

```bash
git clone https://github.com/yaleksandr89/filter-ajax.git
cd filter-ajax
make build
make up
```

Откройте `http://127.0.0.1:8080`. По умолчанию запускается `DB_MODE=demo`; для пустой схемы используйте `make up DB_MODE=schema` на новом томе. Подробности о томах, настройке и диагностике — в [руководстве по разработке](docs/development.md).

## Как устроено

`public/index.php` собирает приложение и обрабатывает только `/` и `/ajax-filter`. Контроллеры используют `ProductFilter`, репозиторий на PDO и шаблоны; браузер обновляет только блок результатов. Краткая карта компонентов и границ — в [описании архитектуры](docs/architecture.md).

## Проверки

`make config` проверяет итоговую Compose-конфигурацию без запуска сервисов. Для уже запущенного стека используйте:

```bash
make php CMD="tests/run.php"
make smoke
```

CI для push и pull request в `master` проверяет PHP и JavaScript, регрессионные тесты, Docker-конфигурацию и оба режима базы.

## Что намеренно оставлено простым

Здесь нет фреймворка, ORM, Composer-пакетов, JavaScript-зависимостей и отдельного API-слоя. Цель проекта — показать небольшой законченный поток фильтрации, а не заменить полноценный каталог.

## Обратная связь

Вопросы и предложения можно оставить в [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).

Запустите проект локально, выберите несколько фильтров и посмотрите, как PHP-сессия и AJAX работают вместе.

## Лицензия

Проект распространяется по лицензии [MIT](LICENSE.md).
