# Участие в разработке

## Выберите язык

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| **Русский** | [English](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_en.md) | [Español](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_es.md) | [中文](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_zh.md) | [Français](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_fr.md) | [Deutsch](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_de.md) |

Спасибо за интерес к AJAX Filter. Проект небольшой, поэтому изменения лучше держать ограниченными, воспроизводимыми и простыми для проверки.

## Перед началом

- О воспроизводимой ошибке сообщите через [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).
- Вопросы и общие идеи лучше сначала обсудить в [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).
- Не публикуйте пароли, токены, production-конфигурацию, персональные данные и другие чувствительные сведения.
- Перед крупным изменением убедитесь, что оно соответствует назначению проекта и не добавляет инфраструктуру или зависимости без явной необходимости.

## Контракт проекта

- AJAX Filter — небольшое PHP web-приложение без PHP-фреймворка, ORM и Composer-зависимостей.
- Клиентская часть использует нативный JavaScript без frontend-фреймворков и сторонних JS-зависимостей.
- Приложение обрабатывает два прикладных маршрута: `/` и `/ajax-filter`.
- Фильтрация выполняется по `category`, `color` и `weight`; активные критерии сохраняются в PHP-сессии.
- Доступ к данным выполняется через PDO; значения фильтров передаются в native prepared statements, а SQL-идентификаторы выбираются только из разрешённого набора.
- `public/index.php` остаётся composition root и явно собирает зависимости приложения.
- Основной локальный workflow построен вокруг Docker Compose и Makefile.
- Режимы `schema` и `demo` применяются только при инициализации нового тома MariaDB.
- Изменения не должны добавлять framework layer, ORM, DI-контейнер, отдельный API, автоматические retry/cache/fallback или другие новые подсистемы без отдельного решения.

Подробнее устройство приложения описано в [документе об архитектуре](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/architecture.md), а локальный запуск и проверки — в [руководстве по разработке](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/development.md).

## Ветки

Используйте короткое имя, отражающее назначение изменения, например:

```text
fix/filter-validation
docs/update-development-guide
chore/update-ci
```

## Коммиты

Предпочтителен формат Conventional Commits. Примеры:

```text
fix: исправить обработку фильтра
docs: уточнить локальный запуск
test: покрыть регрессию фильтрации
chore: обновить конфигурацию CI
```

## Локальная проверка

Перед Pull Request выполните проверки, относящиеся к вашему изменению:

| Что изменилось | Проверка |
|---|---|
| Docker Compose или контейнерная конфигурация | `make config` |
| PHP-поведение приложения | `make php CMD="tests/run.php"` |
| HTTP/runtime-поведение запущенного стека | `make smoke` |

Для запуска проекта и полного списка Make-команд используйте [руководство по разработке](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/development.md).

Если изменение затрагивает режим базы или её инициализацию, проверяйте его на новом томе. `make db-reinit` удаляет данные только из тома базы текущего Compose-проекта и должен использоваться осознанно.

## Pull Request

В описании Pull Request укажите:

- проблему или цель изменения;
- что именно изменено;
- выполненные проверки;
- добавленные или обновлённые тесты, если меняется поведение;
- влияние на Docker, базу данных, безопасность, интерфейс или документацию, если оно есть.

Перед отправкой убедитесь:

- изменение ограничено одной связной задачей;
- unrelated refactoring и форматирование не добавлены;
- секреты, локальные конфиги и чувствительные данные не попали в commit;
- тестовые и runtime-проверки соответствуют затронутому поведению;
- документация обновлена, если изменились команды, контракт или наблюдаемое поведение;
- языковые версии документации синхронизированы, если менялся уже переведённый документ.
