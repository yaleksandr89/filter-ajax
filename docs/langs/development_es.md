# Desarrollo

## Elegir idioma

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../development.md) | [English](development_en.md) | **Seleccionado** | [中文](development_zh.md) | [Français](development_fr.md) | [Deutsch](development_de.md) |

## Requisitos del host

Para el flujo principal con Docker se necesitan:

- Git;
- Docker Engine con Compose v2;
- `make`.

No es necesario instalar PHP, MariaDB ni Xdebug por separado en el host. El contenedor PHP utiliza PHP 8.5.9-FPM con `pdo_mysql` y Xdebug 3.5.3; el stack también incluye Nginx y MariaDB.

## Ejecución sin Docker

El proyecto puede conectarse a una instancia disponible de MariaDB utilizando PHP 8.5, la extensión PDO MySQL y PHP-FPM. Crea una base de datos, ejecuta [`docker/mariadb/schema.sql`](../../docker/mariadb/schema.sql) y, si hace falta, [`docker/mariadb/demo-data.sql`](../../docker/mariadb/demo-data.sql); después configura `config/database.php` o las variables de entorno `DB_*`.

El document root del servidor web debe apuntar a `public/`. Para Nginx con un Unix socket local de PHP-FPM, adapta la [configuración de referencia](../examples/nginx-configuration.conf): dirige los URI normales al front controller y no expone URI PHP directos.

## Primer inicio con Docker

| Comando | Propósito |
|---|---|
| `make build` | Construir las imágenes Docker locales. |
| `make up` | Iniciar el stack y esperar a que los servicios estén listos. |
| `make down` | Detener los servicios conservando los datos de la base. |

Cuando los servicios estén listos, la aplicación estará disponible en [http://127.0.0.1:8080](http://127.0.0.1:8080).

> [!NOTE]
> De forma predeterminada la aplicación se inicia en `127.0.0.1:8080`. Para usar otro puerto, indica `HTTP_PORT`, por ejemplo: `make up HTTP_PORT=18080`.
>
> Para no pasar el puerto a cada comando Make durante la sesión actual del shell, ejecuta antes `export HTTP_PORT=18080`. A partir de entonces `make up`, `make smoke` y los demás comandos usarán ese valor.

## Cuándo es necesaria una reconstrucción

Vuelve a construir las imágenes después de modificar un Dockerfile o la configuración de imágenes en `docker/php/`, `docker/mariadb/` o `docker/nginx/`. Cambiar el modo de base de datos sobre un volumen existente no reinicializa sus datos.

## Comandos del Makefile

| Comando | Propósito |
|---|---|
| `make help` | Mostrar la ayuda. |
| `make config` | Mostrar la configuración Compose resultante. |
| `make build` | Construir las imágenes locales. |
| `make up [DB_MODE=schema\|demo] [HTTP_PORT=8080]` | Iniciar el stack y esperar a que esté listo. |
| `make down` | Detener los servicios conservando el volumen de la base. |
| `make restart [SERVICE=php\|nginx\|db]` | Reiniciar todo el stack o un servicio. |
| `make ps` / `make log [SERVICE=…]` | Mostrar contenedores o logs. |
| `make in SERVICE=php\|nginx\|db` | Abrir un shell non-root en un servicio. |
| `make php CMD="…"` | Ejecutar PHP como `www-data`. |
| `make xdebug` | Mostrar información de Xdebug. |
| `make db-check` | Mostrar tablas y cantidad de registros. |
| `make smoke` | Comprobar un stack ya iniciado. |
| `make db-reinit CONFIRM=filter_ajax_db [DB_MODE=schema\|demo]` | Reinicializar el volumen de base de datos de este proyecto. |

## Modos de esquema y base de demostración

`DB_MODE=schema` crea únicamente las tablas. `DB_MODE=demo` crea el esquema y después carga datos de demostración. El valor predeterminado es `demo`.

El modo se lee únicamente al inicializar un volumen nuevo de MariaDB. Si el volumen ya existe, cambiar `DB_MODE` no modifica su contenido. Usa `db-reinit` cuando necesites crear una base nueva de forma intencionada.

## Reinicialización segura de la base de datos

`make db-reinit` detiene el stack, elimina únicamente el volumen de base de datos del proyecto Compose actual, vuelve a iniciar los servicios y ejecuta `db-check`. Los datos de ese volumen se eliminan de forma irreversible.

El comando exige la confirmación exacta `CONFIRM=filter_ajax_db`, acepta únicamente `schema` o `demo` y comprueba las etiquetas Compose de un volumen existente antes de eliminarlo. Ejemplo: `make db-reinit CONFIRM=filter_ajax_db DB_MODE=demo`.

No lo uses para un reinicio normal: `make down` conserva el volumen y `make up` lo reutiliza.

## Xdebug

La imagen PHP ya incluye Xdebug 3.5.3. Sus ajustes son `xdebug.mode=debug`, `xdebug.start_with_request=trigger`, `xdebug.client_host=host.docker.internal` y `xdebug.client_port=9003`.

La configuración efectiva puede verse con `make xdebug`.

## Comprobaciones

Sin iniciar servicios, `make config` comprueba la configuración Compose resultante.

Para un stack ya iniciado:

| Comprobación | Comando |
|---|---|
| Pruebas de regresión PHP | `make php CMD="tests/run.php"` |
| Runtime smoke | `make smoke` |

`make smoke` comprueba las rutas HTTP principales y un asset estático, la presencia de `pdo_mysql`, la versión de Xdebug y el estado de la base. El CI se ejecuta para pushes y pull requests a `master`; comprueba la sintaxis PHP y JavaScript, las pruebas de regresión, la configuración Docker y los escenarios smoke en los modos `schema` y `demo`.

## Configuración de la base de datos y prioridades

Para ejecutar sin Docker, copia [`config/database.php.example`](../../config/database.php.example) a `config/database.php`. Este archivo local está ignorado por Git. Comando: `cp config/database.php.example config/database.php`.

Ya existen valores base para `host`, `port` y `charset`: `127.0.0.1`, `3306` y `utf8mb4`. El nombre de la base, el usuario y la contraseña deben indicarse en `config/database.php` o mediante variables de entorno.

Si un mismo parámetro está definido en varios sitios, se utiliza la fuente con mayor prioridad:

1. variables de entorno `DB_*`;
2. `config/database.php`, si el archivo existe;
3. valores base de `host`, `port` y `charset`.

Las variables de entorno tienen la prioridad más alta:

- `DB_HOST`;
- `DB_PORT`;
- `DB_NAME`;
- `DB_USER`;
- `DB_PASSWORD`;
- `DB_CHARSET`.

Antes de la conexión se validan los valores principales:

- `host`, `name`, `user` y `charset` deben ser strings no vacíos;
- `password` debe ser un string;
- `port` debe ser un entero entre 1 y 65535;
- `charset` solo puede contener letras, números y `_`.
