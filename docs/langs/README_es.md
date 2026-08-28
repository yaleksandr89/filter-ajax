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
    alt="AJAX Filter — catálogo de productos con filtrado AJAX en PHP puro"
    width="100%"
  >
</p>

## Elegir idioma

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | [English](README_en.md) | **Seleccionado** | [中文](README_zh.md) | [Français](README_fr.md) | [Deutsch](README_de.md) |

`AJAX Filter` es un pequeño catálogo en PHP donde los productos se filtran por categoría, color y peso sin recargar la página. Es un ejemplo compacto de PHP, PDO, MariaDB y JavaScript nativo trabajando juntos, sin Composer ni bibliotecas frontend.

## Funcionalidades

- Filtrado de productos por categoría, color y peso mediante `fetch()` sin recargar la página.
- Los filtros seleccionados se guardan en la sesión de PHP.
- Restablecimiento asíncrono de todos los filtros activos.
- Dos modos de base de datos: esquema vacío y datos de demostración.
- Stack Docker local con Nginx, PHP-FPM, MariaDB y Xdebug.

## Inicio rápido

Se necesitan Git, Docker con Compose v2 y `make`.

| Paso | Comando | Propósito |
|---|---|---|
| 1 | `git clone https://github.com/yaleksandr89/filter-ajax.git` | Clonar el repositorio. |
| 2 | `cd filter-ajax` | Entrar en el directorio del proyecto. |
| 3 | `make build` | Construir las imágenes Docker locales. |
| 4 | `make up` | Iniciar el stack y esperar a que los servicios estén listos. |

Abre [http://127.0.0.1:8080](http://127.0.0.1:8080). De forma predeterminada se usa `DB_MODE=demo`; para un esquema vacío, ejecuta `make up DB_MODE=schema` con un volumen nuevo. El trabajo con volúmenes, la configuración y el diagnóstico se describen en la [guía de desarrollo](development_es.md).

## Arquitectura y estructura del proyecto

La estructura de la aplicación, el flujo de solicitudes, los filtros, la sesión, PDO y las plantillas se describen en la [guía de arquitectura](architecture_es.md).

## Comprobaciones

Las comprobaciones principales están disponibles mediante el Makefile:

| Comprobación | Comando |
|---|---|
| Configuración Compose resultante | `make config` |
| Pruebas de regresión PHP | `make php CMD="tests/run.php"` |
| Runtime smoke del stack ya iniciado | `make smoke` |

El CI para pushes y pull requests a `master` comprueba PHP y JavaScript, las pruebas de regresión, la configuración Docker y ambos modos de base de datos.

## Lo que se mantiene simple intencionadamente

- Sin framework PHP ni ORM.
- Sin paquetes Composer.
- Sin dependencias JavaScript ni framework frontend.
- Sin una capa API separada.

El objetivo del proyecto es mostrar un flujo de filtrado pequeño y completo utilizando las capacidades básicas de PHP, PDO y JavaScript nativo.

## Comentarios y soporte

- Errores reproducibles: [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).
- Preguntas e ideas: [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).

---

<p align="center">
  Si el proyecto te resultó útil, dale una estrella en GitHub para que otros desarrolladores puedan encontrarlo más fácilmente.<br>
  🤘
</p>
