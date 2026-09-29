# Contribuir

## Elegir idioma

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/CONTRIBUTING.md) | [English](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_en.md) | **Español** | [中文](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_zh.md) | [Français](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_fr.md) | [Deutsch](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_de.md) |

Gracias por tu interés en AJAX Filter. El proyecto es pequeño, por lo que los cambios deben mantenerse acotados, reproducibles y fáciles de revisar.

## Antes de empezar

- Informa de errores reproducibles mediante [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).
- Las preguntas y las ideas generales se discuten mejor primero en [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).
- No publiques contraseñas, tokens, configuración de producción, datos personales ni otra información sensible.
- Antes de un cambio grande, asegúrate de que encaja con el propósito del proyecto y no añade infraestructura o dependencias sin una necesidad clara.

## Contrato del proyecto

- AJAX Filter es una pequeña aplicación web PHP sin framework PHP, ORM ni dependencias Composer.
- El cliente utiliza JavaScript nativo sin frameworks frontend ni dependencias JavaScript de terceros.
- La aplicación gestiona dos rutas: `/` y `/ajax-filter`.
- El filtrado usa `category`, `color` y `weight`; los criterios activos se guardan en la sesión PHP.
- El acceso a datos utiliza PDO; los valores de filtros se pasan a native prepared statements y los identificadores SQL se eligen únicamente del conjunto permitido.
- `public/index.php` sigue siendo el composition root y construye explícitamente las dependencias de la aplicación.
- El flujo local principal se basa en Docker Compose y el Makefile.
- Los modos `schema` y `demo` se aplican únicamente al inicializar un volumen nuevo de MariaDB.
- Los cambios no deben añadir framework layer, ORM, contenedor DI, API separada, retry/cache/fallback automáticos ni otros subsistemas nuevos sin una decisión independiente.

La estructura de la aplicación se describe en la [guía de arquitectura](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/architecture_es.md), y el arranque local y las comprobaciones están en la [guía de desarrollo](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_es.md).

## Ramas

Usa un nombre corto que refleje el propósito del cambio, por ejemplo:

```text
fix/filter-validation
docs/update-development-guide
chore/update-ci
```

## Commits

Se prefiere el formato Conventional Commits. Ejemplos:

```text
fix: corregir el manejo del filtro
docs: aclarar el inicio local
test: cubrir una regresión del filtrado
chore: actualizar la configuración de CI
```

## Comprobación local

Antes de un Pull Request, ejecuta las comprobaciones relacionadas con tu cambio:

| Qué cambió | Comprobación |
|---|---|
| Docker Compose o configuración de contenedores | `make config` |
| Comportamiento PHP de la aplicación | `make php CMD="tests/run.php"` |
| Comportamiento HTTP/runtime del stack iniciado | `make smoke` |

Para iniciar el proyecto y consultar la lista completa de comandos Make, usa la [guía de desarrollo](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_es.md).

Si el cambio afecta al modo de base de datos o a su inicialización, compruébalo con un volumen nuevo. `make db-reinit` elimina datos únicamente del volumen de base de datos del proyecto Compose actual y debe utilizarse de forma consciente.

## Pull Request

En la descripción del Pull Request indica:

- el problema o el objetivo del cambio;
- qué se ha modificado exactamente;
- las comprobaciones ejecutadas;
- las pruebas añadidas o actualizadas si cambia el comportamiento;
- el impacto en Docker, base de datos, seguridad, interfaz o documentación cuando corresponda.

Antes de enviarlo, comprueba que:

- el cambio está limitado a una única tarea coherente;
- no se incluye refactoring ni formato no relacionado;
- no se incluyen secretos, configuración local ni datos sensibles;
- las pruebas y comprobaciones runtime corresponden al comportamiento afectado;
- la documentación se actualiza si cambian comandos, contratos o comportamiento observable;
- la documentación traducida se mantiene sincronizada cuando cambia un documento ya traducido.
