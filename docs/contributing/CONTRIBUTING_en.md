# Contributing

## Choose a language

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/CONTRIBUTING.md) | **English** | [Español](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_es.md) | [中文](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_zh.md) | [Français](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_fr.md) | [Deutsch](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_de.md) |

Thank you for your interest in AJAX Filter. The project is small, so changes should stay bounded, reproducible, and easy to review.

## Before you start

- Report reproducible bugs through [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).
- Questions and broad ideas are better discussed first in [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).
- Do not publish passwords, tokens, production configuration, personal data, or other sensitive information.
- Before a large change, make sure it fits the purpose of the project and does not add infrastructure or dependencies without a clear need.

## Project contract

- AJAX Filter is a small PHP web application without a PHP framework, ORM, or Composer dependencies.
- The client side uses native JavaScript without frontend frameworks or third-party JavaScript dependencies.
- The application handles two application routes: `/` and `/ajax-filter`.
- Filtering uses `category`, `color`, and `weight`; active criteria are stored in the PHP session.
- Data access uses PDO; filter values are passed to native prepared statements, while SQL identifiers are selected only from the allowed set.
- `public/index.php` remains the composition root and explicitly assembles application dependencies.
- The main local workflow is built around Docker Compose and the Makefile.
- The `schema` and `demo` modes are applied only when a new MariaDB volume is initialized.
- Changes must not add a framework layer, ORM, DI container, separate API, automatic retry/cache/fallback behavior, or other new subsystems without a separate decision.

The application structure is described in the [architecture guide](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/architecture_en.md), while local startup and checks are covered by the [development guide](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_en.md).

## Branches

Use a short name that reflects the purpose of the change, for example:

```text
fix/filter-validation
docs/update-development-guide
chore/update-ci
```

## Commits

Conventional Commits are preferred. Examples:

```text
fix: correct filter handling
docs: clarify local startup
test: cover filtering regression
chore: update CI configuration
```

## Local checks

Before a Pull Request, run the checks relevant to your change:

| What changed | Check |
|---|---|
| Docker Compose or container configuration | `make config` |
| PHP application behavior | `make php CMD="tests/run.php"` |
| HTTP/runtime behavior of a running stack | `make smoke` |

For project startup and the full list of Make commands, use the [development guide](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_en.md).

If a change affects the database mode or database initialization, verify it with a new volume. `make db-reinit` removes data only from the current Compose project's database volume and must be used intentionally.

## Pull Request

In the Pull Request description, include:

- the problem or goal of the change;
- what exactly changed;
- checks that were run;
- tests added or updated when behavior changes;
- impact on Docker, the database, security, UI, or documentation when applicable.

Before submitting, make sure that:

- the change is limited to one coherent task;
- unrelated refactoring and formatting are not included;
- secrets, local configuration, and sensitive data are not included in the commit;
- tests and runtime checks match the affected behavior;
- documentation is updated when commands, contracts, or observable behavior change;
- translated documentation stays synchronized when an already translated document changes.
