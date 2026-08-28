# Development

## Choose language

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../development.md) | **Selected** | [Español](development_es.md) | [中文](development_zh.md) | [Français](development_fr.md) | [Deutsch](development_de.md) |

## Host requirements

For the main Docker workflow you need:

- Git;
- Docker Engine with Compose v2;
- `make`.

PHP, MariaDB, and Xdebug do not need to be installed separately on the host. The PHP container uses PHP 8.5.9-FPM with `pdo_mysql` and Xdebug 3.5.3; Nginx and MariaDB are also part of the stack.

## Running without Docker

The project can use an available MariaDB instance together with PHP 8.5, the PDO MySQL extension, and PHP-FPM. Create a database, apply [`docker/mariadb/schema.sql`](../../docker/mariadb/schema.sql) and, if needed, [`docker/mariadb/demo-data.sql`](../../docker/mariadb/demo-data.sql), then configure `config/database.php` or the `DB_*` environment variables.

The web server document root must point to `public/`. For Nginx with a local PHP-FPM Unix socket, adapt the [reference configuration](../examples/nginx-configuration.conf): it routes regular URIs through the front controller and does not expose direct PHP URIs.

## First Docker start

| Command | Purpose |
|---|---|
| `make build` | Build the local Docker images. |
| `make up` | Start the stack and wait until the services are ready. |
| `make down` | Stop the services while preserving database data. |

Once the services are ready, the application is available at [http://127.0.0.1:8080](http://127.0.0.1:8080).

> [!NOTE]
> By default the application starts on `127.0.0.1:8080`. To use a different port, pass `HTTP_PORT`, for example: `make up HTTP_PORT=18080`.
>
> To avoid passing the port to every Make command in the current shell session, run `export HTTP_PORT=18080` first. Regular `make up`, `make smoke`, and other commands will then use that value.

## When a rebuild is required

Rebuild the images after changing a Dockerfile or image configuration under `docker/php/`, `docker/mariadb/`, or `docker/nginx/`. Changing the database mode for an existing volume does not reinitialize its data.

## Makefile commands

| Command | Purpose |
|---|---|
| `make help` | Show help. |
| `make config` | Print the resolved Compose configuration. |
| `make build` | Build the local images. |
| `make up [DB_MODE=schema\|demo] [HTTP_PORT=8080]` | Start the stack and wait until it is ready. |
| `make down` | Stop services while preserving the database volume. |
| `make restart [SERVICE=php\|nginx\|db]` | Restart the whole stack or one service. |
| `make ps` / `make log [SERVICE=…]` | Show containers or logs. |
| `make in SERVICE=php\|nginx\|db` | Open a non-root shell in a service. |
| `make php CMD="…"` | Run PHP as `www-data`. |
| `make xdebug` | Print Xdebug information. |
| `make db-check` | Show tables and record counts. |
| `make smoke` | Check an already running stack. |
| `make db-reinit CONFIRM=filter_ajax_db [DB_MODE=schema\|demo]` | Reinitialize this project's database volume. |

## Schema and demo database modes

`DB_MODE=schema` creates only the tables. `DB_MODE=demo` creates the schema and then loads demo data. The default value is `demo`.

The mode is read only when a new MariaDB volume is initialized. If the volume already exists, changing `DB_MODE` does not change its contents. Use `db-reinit` when you intentionally need a fresh database.

## Safe database reinitialization

`make db-reinit` stops the stack, removes only the current Compose project's database volume, starts the services again, and runs `db-check`. Data in that volume is permanently removed.

The command requires the exact confirmation `CONFIRM=filter_ajax_db`, accepts only `schema` or `demo`, and checks the Compose labels of an existing volume before deletion. Example: `make db-reinit CONFIRM=filter_ajax_db DB_MODE=demo`.

Do not use it for a regular restart: `make down` preserves the volume and `make up` reuses it.

## Xdebug

The PHP image already includes Xdebug 3.5.3. Its settings are `xdebug.mode=debug`, `xdebug.start_with_request=trigger`, `xdebug.client_host=host.docker.internal`, and `xdebug.client_port=9003`.

Use `make xdebug` to inspect the effective configuration.

## Checks

Without starting services, `make config` validates the resolved Compose configuration.

For an already running stack:

| Check | Command |
|---|---|
| PHP regression tests | `make php CMD="tests/run.php"` |
| Runtime smoke | `make smoke` |

`make smoke` checks the main HTTP routes and a static asset, the presence of `pdo_mysql`, the Xdebug version, and database state. CI runs for pushes and pull requests to `master`; it checks PHP and JavaScript syntax, regression tests, Docker configuration, and smoke scenarios in both `schema` and `demo` modes.

## Database configuration and precedence

For a non-Docker run, copy [`config/database.php.example`](../../config/database.php.example) to `config/database.php`. This local file is ignored by Git. Command: `cp config/database.php.example config/database.php`.

Base values are already defined for `host`, `port`, and `charset`: `127.0.0.1`, `3306`, and `utf8mb4`. Database name, user, and password must be provided through `config/database.php` or environment variables.

When the same setting is defined in more than one place, the source with higher precedence is used:

1. `DB_*` environment variables;
2. `config/database.php`, when the file exists;
3. base values for `host`, `port`, and `charset`.

Environment variables have the highest precedence:

- `DB_HOST`;
- `DB_PORT`;
- `DB_NAME`;
- `DB_USER`;
- `DB_PASSWORD`;
- `DB_CHARSET`.

The main values are validated before connecting:

- `host`, `name`, `user`, and `charset` must be non-empty strings;
- `password` must be a string;
- `port` must be an integer from 1 to 65535;
- `charset` may contain only letters, digits, and `_`.
