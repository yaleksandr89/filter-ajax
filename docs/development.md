# Разработка

## Требования к хосту

Для основного Docker-сценария нужны:

- Git;
- Docker Engine с Compose v2;
- `make`.

PHP, MariaDB и Xdebug отдельно на хост устанавливать не требуется. PHP-контейнер использует PHP 8.5.9-FPM с `pdo_mysql` и Xdebug 3.5.3; в составе стека также работают Nginx и MariaDB. HTTP-порт по умолчанию — `127.0.0.1:8080`.

## Первый запуск

| Шаг | Команда | Назначение |
|---|---|---|
| 1 | `make build` | Собрать локальные Docker-образы. |
| 2 | `make up` | Запустить стек и дождаться готовности сервисов. |

После готовности сервисов приложение доступно по адресу [http://127.0.0.1:8080](http://127.0.0.1:8080). Значения по умолчанию: `PROJECT=filter-ajax`, `HTTP_PORT=8080`, `DB_MODE=demo`.

Для другого локального порта используйте `make up HTTP_PORT=18080`.

Остановка стека командой `make down` не удаляет данные базы.

## Изменения без пересборки

Корень проекта смонтирован в сервис `php` только для чтения, а `public/` — в `nginx` также только для чтения. Поэтому изменения PHP-кода, шаблонов и файлов из `public/` подхватываются работающим стеком без rebuild.

Пересоберите образы после изменений `docker/php/Dockerfile`, `docker/php/conf.d/zz-xdebug.ini`, Dockerfile/инициализации MariaDB или Dockerfile/конфигурации Nginx. Изменение режима базы на уже существующем томе не переинициализирует данные.

## Команды Makefile

| Команда | Назначение |
|---|---|
| `make help` | Показать справку. |
| `make config` | Вывести итоговую Compose-конфигурацию. |
| `make build` | Собрать локальные образы. |
| `make up [DB_MODE=schema\|demo] [HTTP_PORT=8080]` | Запустить стек и дождаться готовности. |
| `make down` | Остановить сервисы, сохранив том базы. |
| `make restart [SERVICE=php\|nginx\|db]` | Перезапустить весь стек или один сервис. |
| `make ps` / `make log [SERVICE=…]` | Посмотреть контейнеры или логи. |
| `make in SERVICE=php\|nginx\|db` | Открыть non-root shell в сервисе. |
| `make php CMD="…"` | Выполнить PHP от имени `www-data`. |
| `make xdebug` | Вывести сведения о Xdebug. |
| `make db-check` | Показать таблицы и количество записей. |
| `make smoke` | Проверить уже запущенный стек. |
| `make db-reinit CONFIRM=filter_ajax_db [DB_MODE=schema\|demo]` | Переинициализировать том базы этого проекта. |

## Режимы схемы и демо-базы

`DB_MODE=schema` создаёт только таблицы. `DB_MODE=demo` сначала создаёт схему, затем загружает демо-данные. Значение по умолчанию — `demo`.

Режим читается лишь при инициализации нового тома MariaDB. Если том уже существует, смена `DB_MODE` не изменит его содержимое. Для осознанного создания новой базы используйте `db-reinit`.

## Безопасная переинициализация базы

`make db-reinit` останавливает стек, удаляет только том базы текущего Compose-проекта, запускает сервисы заново и выполняет `db-check`. Это необратимо для данных в этом томе.

Команда требует точного подтверждения `CONFIRM=filter_ajax_db`, принимает только `schema` или `demo` и перед удалением проверяет Compose-метки существующего тома. Пример: `make db-reinit CONFIRM=filter_ajax_db DB_MODE=demo`.

Не запускайте её для обычной перезагрузки данных: `make down` сохраняет том, а `make up` использует его повторно.

## Xdebug

В PHP-образ уже включён Xdebug 3.5.3. Его настройки: `xdebug.mode=debug`, `xdebug.start_with_request=trigger`, `xdebug.client_host=host.docker.internal`, `xdebug.client_port=9003`.

Фактическую конфигурацию можно посмотреть командой `make xdebug`.

## Проверки

Без запуска сервисов итоговую Compose-конфигурацию проверяет `make config`.

Для уже работающего стека:

| Проверка | Команда |
|---|---|
| Регрессионные PHP-тесты | `make php CMD="tests/run.php"` |
| Runtime smoke | `make smoke` |

`make smoke` проверяет основные HTTP-маршруты и статический asset, наличие `pdo_mysql`, версию Xdebug и состояние базы. CI запускается для push и pull request в `master`; он проверяет синтаксис PHP и JavaScript, регрессионные тесты, Docker-конфигурацию и smoke-сценарии в режимах `schema` и `demo`.

## Конфигурация БД и приоритеты

Для не-Docker запуска скопируйте [`config/database.php.example`](../config/database.php.example) в `config/database.php`. Этот локальный файл исключён из Git. Команда: `cp config/database.php.example config/database.php`.

`DatabaseConfig` начинает с `host=127.0.0.1`, `port=3306` и `charset=utf8mb4`, затем применяет `config/database.php`, а после него переменные окружения. Последние имеют приоритет: `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_CHARSET`.

Значения `host`, `name`, `user` и `charset` должны быть непустыми строками; пароль должен быть строкой; порт — целым числом от 1 до 65535; `charset` допускает только буквы, цифры и `_`.

## Краткий запуск без Docker

Проект можно подключить к доступной MariaDB с PHP 8.5, расширением PDO MySQL и PHP-FPM. Создайте базу, выполните [`docker/mariadb/schema.sql`](../docker/mariadb/schema.sql) и при необходимости [`docker/mariadb/demo-data.sql`](../docker/mariadb/demo-data.sql), затем настройте `config/database.php` или переменные `DB_*`.

Веб-сервер должен указывать document root на `public/`. Для Nginx с локальным Unix socket PHP-FPM используйте и адаптируйте [справочный пример](examples/nginx-configuration.conf): он направляет обычные URI в front controller и не открывает прямые PHP-URI.
