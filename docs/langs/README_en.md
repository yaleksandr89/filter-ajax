# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4.svg?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![JavaScript](https://img.shields.io/badge/JavaScript-Native-F7DF1E.svg?style=flat-square&logo=javascript&logoColor=F7DF1E)](https://developer.mozilla.org/docs/Web/JavaScript)
[![MariaDB](https://img.shields.io/badge/MariaDB-12.3-003545.svg?style=flat-square&logo=mariadb&logoColor=white)](https://mariadb.org/)
[![Docker](https://img.shields.io/badge/Docker-Compose-2496ED.svg?style=flat-square&logo=docker&logoColor=white)](https://www.docker.com/)
[![CI](https://img.shields.io/github/actions/workflow/status/yaleksandr89/filter-ajax/ci.yml?style=flat-square&label=CI)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](../../LICENSE.md)

<p align="center">
  <img
    src="../img/filter-ajax-readme-cover.png"
    alt="AJAX Filter — product catalog with AJAX filtering in plain PHP"
    width="100%"
  >
</p>

## Choose language

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | **Selected** | [Español](README_es.md) | [中文](README_zh.md) | [Français](README_fr.md) | [Deutsch](README_de.md) |

`AJAX Filter` is a small PHP catalog where products are filtered by category, color, and weight without reloading the page. It is a compact example of PHP, PDO, MariaDB, and native JavaScript working together, without Composer or frontend libraries.

## Features

- Product filtering by category, color, and weight through `fetch()` without a page reload.
- Selected filters are stored in the PHP session.
- Asynchronous reset of all active filters.
- Two database modes: empty schema and demo data.
- Local Docker stack with Nginx, PHP-FPM, MariaDB, and Xdebug.

## Quick start

You need Git, Docker with Compose v2, and `make`.

| Step | Command | Purpose |
|---|---|---|
| 1 | `git clone https://github.com/yaleksandr89/filter-ajax.git` | Clone the repository. |
| 2 | `cd filter-ajax` | Enter the project directory. |
| 3 | `make build` | Build the local Docker images. |
| 4 | `make up` | Start the stack and wait for the services to become ready. |

Open [http://127.0.0.1:8080](http://127.0.0.1:8080). `DB_MODE=demo` is used by default; for an empty schema, run `make up DB_MODE=schema` with a new volume. Volume handling, configuration, and diagnostics are described in the [development guide](development_en.md).

## Architecture and project structure

The application structure, request flow, filters, session handling, PDO, and templates are described in the separate [architecture guide](architecture_en.md).

## Checks

The main checks are exposed through the Makefile:

| Check | Command |
|---|---|
| Resolved Compose configuration | `make config` |
| PHP regression tests | `make php CMD="tests/run.php"` |
| Runtime smoke check for an already running stack | `make smoke` |

CI for pushes and pull requests to `master` checks PHP and JavaScript, regression tests, Docker configuration, and both database modes.

## Intentionally kept simple

- No PHP framework or ORM.
- No Composer packages.
- No JavaScript dependencies or frontend framework.
- No separate API layer.

The goal of the project is to show a small complete filtering flow using the basic capabilities of PHP, PDO, and native JavaScript.

## Feedback

- Reproducible bugs: [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).
- Questions and ideas: [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).

---

<p align="center">
  If the project was useful, give it a star on GitHub so other developers can find it more easily.<br>
  🤘
</p>
