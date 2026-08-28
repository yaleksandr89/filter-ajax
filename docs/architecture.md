# Архитектура

Приложение остаётся небольшим, но основные границы ответственности сделаны явными: точка входа собирает зависимости, контроллеры ведут HTTP-сценарий, фильтр отвечает за критерии и сессию, репозиторий — за чтение данных, а шаблоны — только за представление.

## Поток запроса

```text
HTTP-запрос
    ↓
Nginx
    ↓
public/index.php
    ↓
контроллер
    ↓
ProductFilter / ProductRepository / ViewRenderer
    ↓
HTML-ответ
```

Для `/` возвращается полная страница каталога. Для `/ajax-filter` сервер рендерит только список товаров, а браузер заменяет им текущий блок результатов.

## Компоненты и ответственность

| Зона | Компоненты | Ответственность |
|---|---|---|
| Точка входа и composition root | [`public/index.php`](../public/index.php) | Подключает bootstrap, запускает сессию, разрешает маршрут, создаёт [`DatabaseConfig`](../app/Database/DatabaseConfig.php), PDO, [`ProductQueryBuilder`](../app/Database/ProductQueryBuilder.php), [`ProductRepository`](../app/Database/ProductRepository.php), [`ProductFilter`](../app/Filter/ProductFilter.php), [`ViewRenderer`](../app/View/ViewRenderer.php) и контроллеры. |
| Autoload | [`app/bootstrap.php`](../app/bootstrap.php) | Регистрирует нативный autoloader для `App\`, допускает только корректные сегменты имён классов и сопоставляет их с файлами внутри `app/`. Composer не используется. |
| Главная страница | [`HomeController::index()`](../app/Controller/HomeController.php) | Читает активные критерии из сессии, получает товары и значения для фильтров, затем рендерит `products`, `home` и `layout`. |
| AJAX-фильтрация | [`FilterController::filter()`](../app/Controller/FilterController.php) | Нормализует query-параметры, обновляет состояние фильтра и возвращает только HTML-фрагмент `products`. |
| Состояние фильтра | [`ProductFilter`](../app/Filter/ProductFilter.php) | Принимает только `category`, `color` и `weight`, хранит активные критерии в сессии и обрабатывает значение `all` как очистку конкретного фильтра. |
| Доступ к данным | [`ProductRepository`](../app/Database/ProductRepository.php) | Получает товары, категории, цвета и веса через PDO. |
| Построение SQL | [`ProductQueryBuilder`](../app/Database/ProductQueryBuilder.php) | Формирует условия только для разрешённых идентификаторов `category`, `color`, `weight`; значения передаются отдельно в prepared statement. |
| Подключение к БД | [`DatabaseConfig`](../app/Database/DatabaseConfig.php), [`ConnectionFactory`](../app/Database/ConnectionFactory.php) | Собирает конфигурацию с приоритетом defaults → локальный файл → `DB_*`, валидирует значения и создаёт PDO с исключениями, associative fetch mode и отключённой эмуляцией prepare. |
| Представление | [`ViewRenderer`](../app/View/ViewRenderer.php), [`templates/`](../templates/) | Разрешает только зарегистрированные шаблоны `layout`, `home`, `products`; динамические scalar-значения экранируются через `htmlspecialchars` в UTF-8. |
| AJAX на клиенте | [`public/assets/js/ajax-filter.js`](../public/assets/js/ajax-filter.js) | Следит за фильтрами, отменяет предыдущий незавершённый запрос через `AbortController`, вызывает `/ajax-filter` и заменяет HTML результатов. |
| UI на клиенте | [`public/assets/js/ui.js`](../public/assets/js/ui.js) | Управляет темой и языком интерфейса, хранит предпочтения в `localStorage` и обновляет подписи после AJAX-ответа. |
| Ошибки | [`templates/error/404.php`](../templates/error/404.php), глобальная обработка исключений | Неизвестный маршрут возвращает `404`; необработанное исключение логируется на сервере, а клиент получает `500` без деталей исключения. |

## Маршруты

| Путь | Обработчик | Ответ |
|---|---|---|
| `/` | [`HomeController::index()`](../app/Controller/HomeController.php) | Полная HTML-страница каталога. |
| `/ajax-filter` | [`FilterController::filter()`](../app/Controller/FilterController.php) | Только HTML-фрагмент списка товаров. |

Других прикладных маршрутов приложение не обрабатывает.

## Как проходит AJAX-фильтрация

1. Пользователь меняет категорию, цвет или вес.
2. [`ajax-filter.js`](../public/assets/js/ajax-filter.js) отменяет предыдущий незавершённый запрос, если он ещё выполняется.
3. Браузер отправляет изменённый критерий на `/ajax-filter`.
4. [`ProductFilter`](../app/Filter/ProductFilter.php) принимает только разрешённые параметры и обновляет их состояние в PHP-сессии.
5. [`ProductRepository`](../app/Database/ProductRepository.php) получает выборку через [`ProductQueryBuilder`](../app/Database/ProductQueryBuilder.php) и PDO.
6. [`FilterController`](../app/Controller/FilterController.php) рендерит `products`, после чего браузер заменяет только блок результатов.

Непереданные фильтры остаются активными. Значение `all` очищает только соответствующий критерий; кнопка сброса отправляет `all` для всех трёх полей.

## Ключевые границы

| Граница | Решение | Что это даёт |
|---|---|---|
| Сборка зависимостей | Все concrete dependencies создаются в [`public/index.php`](../public/index.php). | Контроллеры не скрывают создание PDO, репозитория или renderer внутри себя. |
| Входные фильтры | [`ProductFilter`](../app/Filter/ProductFilter.php) работает только с `category`, `color`, `weight`; пустые и не-скалярные значения игнорируются. | HTTP-параметры не превращаются напрямую в произвольные критерии запроса. |
| SQL | Идентификаторы фильтров выбираются из allowlist, значения передаются в native prepared statement. | Пользовательские значения не конкатенируются в SQL. |
| Конфигурация БД | [`DatabaseConfig`](../app/Database/DatabaseConfig.php) проверяет ключи, обязательные строки, порт и `charset` до подключения. | Ошибочная локальная конфигурация завершается предсказуемо до выполнения запроса. |
| Шаблоны | [`ViewRenderer`](../app/View/ViewRenderer.php) разрешает только известные шаблоны и экранирует динамические scalar-значения. | Имя шаблона нельзя подставить из запроса, а данные не выводятся в HTML без контекстного escaping. |
| Ошибки | Детали исключений остаются в server log; HTTP-клиент получает короткий `500`. | Внутренние детали приложения не раскрываются пользователю. |

Уже отрендеренные внутренние HTML-фрагменты, например `$content` и список товаров, передаются между шаблонами как trusted rendered HTML.

## Что намеренно не добавлено

- отдельный router-класс;
- DI-контейнер;
- ORM;
- PHP-фреймворк;
- Composer-зависимости;
- frontend-фреймворк;
- отдельный API-слой.

Сборка зависимостей остаётся явной в entrypoint, чтобы весь демонстрационный поток можно было проследить по коду без дополнительной инфраструктуры.
