# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![CI](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml/badge.svg)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](../../LICENSE.md)

<p align="center">
  <img
    src="../img/filter-ajax-readme-cover.png"
    alt="AJAX Filter — filtrado dinámico y seguro para PHP con AJAX y listas basadas en base de datos"
    width="100%"
  >
</p>

## Elegir idioma

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | [English](README_en.md) | **Seleccionado** | [中文](README_zh.md) | [Français](README_fr.md) | [Deutsch](README_de.md) |

## Descripción

`AJAX Filter` es un pequeño proyecto de demostración en PHP que filtra productos por categoría, color y peso sin recargar la página. El cliente utiliza JavaScript nativo y `fetch()`, mientras que el servidor utiliza PHP y PDO.

El proyecto no utiliza Composer ni bibliotecas JavaScript de forma intencionada y mantiene una estructura sencilla para estudiar los fundamentos del filtrado AJAX.

## Stack

- PHP 8.5
- MySQL / MariaDB mediante PDO
- JavaScript nativo
- Bootstrap 5.3.3
- Nginx + PHP-FPM para el ejemplo de servidor incluido

## Inicio rápido

1. Crea una base de datos e importa [`docs/mysql-dump/ajax-filter.sql`](../mysql-dump/ajax-filter.sql).
2. Copia [`docs/examples/db-config.php.example`](../examples/db-config.php.example) a `app/models/database.php`.
3. Configura en `app/models/database.php` los parámetros locales de conexión a la base de datos.
4. Configura el document root del servidor web en el directorio `public/`. Hay un ejemplo de Nginx en [`docs/examples/nginx-configuration.conf`](../examples/nginx-configuration.conf).
5. Ajusta la ruta `fastcgi_pass` del ejemplo si tu socket PHP-FPM es diferente.
6. Abre la aplicación mediante el host local configurado.

`app/models/database.php` está excluido de Git y no debe contener credenciales de producción versionadas.

## Cómo funciona el filtrado

Cuando cambia un filtro, el navegador envía una solicitud a `/ajax-filter`. El servidor acepta únicamente los campos `category`, `color` y `weight`, guarda los filtros activos en la sesión y ejecuta una consulta PDO parametrizada.

<details>
  <summary>Demostración del filtrado</summary>

![AJAX Filter demo](../img/ajax-filter-main.gif)
</details>

## Cambio de tema

La interfaz admite temas claro, oscuro y del sistema mediante Bootstrap.

<details>
  <summary>Demostración del cambio de tema</summary>

![AJAX Filter theme demo](../img/ajax-filter-theme-color.gif)
</details>

## Comprobaciones

GitHub Actions valida:

- la sintaxis PHP;
- la sintaxis JavaScript;
- regression tests del filtrado, la parametrización SQL, la validación del controlador y el escape HTML.

## Licencia

El proyecto se distribuye bajo la licencia [MIT](../../LICENSE.md).
