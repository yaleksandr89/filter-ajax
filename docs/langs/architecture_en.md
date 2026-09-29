# Architecture

## Choose language

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../architecture.md) | **Selected** | [Español](architecture_es.md) | [中文](architecture_zh.md) | [Français](architecture_fr.md) | [Deutsch](architecture_de.md) |

The application remains small, but its main responsibility boundaries are explicit: the entry point assembles dependencies, controllers coordinate the HTTP flow, the filter owns criteria and session state, the repository reads data, and templates are responsible only for presentation.

## Request flow

```text
HTTP request
    ↓
Nginx
    ↓
public/index.php
    ↓
controller
    ↓
ProductFilter / ProductRepository / ViewRenderer
    ↓
HTML response
```

`/` returns the full catalog page. `/ajax-filter` renders only the product list, which the browser uses to replace the current results block.

## Components and responsibilities

| Area | Components | Responsibility |
|---|---|---|
| Entry point and composition root | [`public/index.php`](../../public/index.php) | Loads bootstrap, starts the session, resolves the route, and creates [`DatabaseConfig`](../../app/Database/DatabaseConfig.php), PDO, [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php), [`ProductRepository`](../../app/Database/ProductRepository.php), [`ProductFilter`](../../app/Filter/ProductFilter.php), [`ViewRenderer`](../../app/View/ViewRenderer.php), and the controllers. |
| Autoload | [`app/bootstrap.php`](../../app/bootstrap.php) | Registers the native autoloader for `App\`, accepts only valid class-name segments, and maps them to files inside `app/`. Composer is not used. |
| Home page | [`HomeController::index()`](../../app/Controller/HomeController.php) | Reads active criteria from the session, loads products and filter values, then renders `products`, `home`, and `layout`. |
| AJAX filtering | [`FilterController::filter()`](../../app/Controller/FilterController.php) | Normalizes query parameters, updates filter state, and returns only the `products` HTML fragment. |
| Filter state | [`ProductFilter`](../../app/Filter/ProductFilter.php) | Accepts only `category`, `color`, and `weight`, stores active criteria in the session, and treats `all` as clearing one specific filter. |
| Data access | [`ProductRepository`](../../app/Database/ProductRepository.php) | Loads products, categories, colors, and weights through PDO. |
| SQL building | [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) | Builds conditions only for the allowed identifiers `category`, `color`, and `weight`; values are passed separately to a prepared statement. |
| Database connection | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php), [`ConnectionFactory`](../../app/Database/ConnectionFactory.php) | Builds configuration with precedence defaults → local file → `DB_*`, validates values, and creates PDO with exceptions, associative fetch mode, and emulated prepares disabled. |
| Presentation | [`ViewRenderer`](../../app/View/ViewRenderer.php), [`templates/`](../../templates/) | Allows only the registered `layout`, `home`, and `products` templates; dynamic scalar values are escaped with `htmlspecialchars` in UTF-8. |
| Client-side AJAX | [`public/assets/js/ajax-filter.js`](../../public/assets/js/ajax-filter.js) | Watches filters, aborts the previous unfinished request through `AbortController`, calls `/ajax-filter`, and replaces the results HTML. |
| Client-side UI | [`public/assets/js/ui.js`](../../public/assets/js/ui.js) | Manages interface theme and language, stores preferences in `localStorage`, and refreshes labels after an AJAX response. |
| Errors | [`templates/error/404.php`](../../templates/error/404.php), global exception handling | Unknown routes return `404`; an unhandled exception is logged on the server while the client receives `500` without exception details. |

## Routes

| Path | Handler | Response |
|---|---|---|
| `/` | [`HomeController::index()`](../../app/Controller/HomeController.php) | Full catalog HTML page. |
| `/ajax-filter` | [`FilterController::filter()`](../../app/Controller/FilterController.php) | Product-list HTML fragment only. |

The application handles no other application routes.

## AJAX filtering flow

1. The user changes category, color, or weight.
2. [`ajax-filter.js`](../../public/assets/js/ajax-filter.js) aborts the previous unfinished request if it is still running.
3. The browser sends the changed criterion to `/ajax-filter`.
4. [`ProductFilter`](../../app/Filter/ProductFilter.php) accepts only allowed parameters and updates their state in the PHP session.
5. [`ProductRepository`](../../app/Database/ProductRepository.php) loads the result through [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) and PDO.
6. [`FilterController`](../../app/Controller/FilterController.php) renders `products`, after which the browser replaces only the results block.

Filters that are not sent remain active. The `all` value clears only its corresponding criterion; the reset button sends `all` for all three fields.

## Key boundaries

| Boundary | Decision | Effect |
|---|---|---|
| Dependency assembly | All concrete dependencies are created in [`public/index.php`](../../public/index.php). | Controllers do not hide PDO, repository, or renderer construction inside themselves. |
| Filter input | [`ProductFilter`](../../app/Filter/ProductFilter.php) works only with `category`, `color`, and `weight`; empty and non-scalar values are ignored. | HTTP parameters do not directly become arbitrary query criteria. |
| SQL | Filter identifiers come from an allowlist and values are passed to native prepared statements. | User values are not concatenated into SQL. |
| Database configuration | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php) validates keys, required strings, port, and `charset` before connecting. | Invalid local configuration fails predictably before a query is executed. |
| Templates | [`ViewRenderer`](../../app/View/ViewRenderer.php) allows only known templates and escapes dynamic scalar values. | A request cannot provide an arbitrary template name, and data is not written to HTML without contextual escaping. |
| Errors | Exception details stay in the server log; the HTTP client receives a short `500` response. | Internal application details are not exposed to the user. |

Already rendered internal HTML fragments, such as `$content` and the product list, are passed between templates as trusted rendered HTML.

## Intentionally not added

- separate router class;
- DI container;
- ORM;
- PHP framework;
- Composer dependencies;
- frontend framework;
- separate API layer.

Dependency assembly remains explicit in the entry point so the entire demonstration flow can be followed directly through the code without extra infrastructure.
