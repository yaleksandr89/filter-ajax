# Arquitectura

## Elegir idioma

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../architecture.md) | [English](architecture_en.md) | **Seleccionado** | [中文](architecture_zh.md) | [Français](architecture_fr.md) | [Deutsch](architecture_de.md) |

La aplicación sigue siendo pequeña, pero sus principales límites de responsabilidad son explícitos: el punto de entrada construye las dependencias, los controladores coordinan el flujo HTTP, el filtro gestiona los criterios y la sesión, el repositorio lee los datos y las plantillas se ocupan únicamente de la presentación.

## Flujo de solicitud

```text
solicitud HTTP
    ↓
Nginx
    ↓
public/index.php
    ↓
controlador
    ↓
ProductFilter / ProductRepository / ViewRenderer
    ↓
respuesta HTML
```

`/` devuelve la página completa del catálogo. `/ajax-filter` renderiza únicamente la lista de productos y el navegador reemplaza con ella el bloque actual de resultados.

## Componentes y responsabilidades

| Área | Componentes | Responsabilidad |
|---|---|---|
| Punto de entrada y composition root | [`public/index.php`](../../public/index.php) | Carga bootstrap, inicia la sesión, resuelve la ruta y crea [`DatabaseConfig`](../../app/Database/DatabaseConfig.php), PDO, [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php), [`ProductRepository`](../../app/Database/ProductRepository.php), [`ProductFilter`](../../app/Filter/ProductFilter.php), [`ViewRenderer`](../../app/View/ViewRenderer.php) y los controladores. |
| Autoload | [`app/bootstrap.php`](../../app/bootstrap.php) | Registra el autoloader nativo para `App\`, permite únicamente segmentos válidos de nombres de clase y los asigna a archivos dentro de `app/`. No se usa Composer. |
| Página principal | [`HomeController::index()`](../../app/Controller/HomeController.php) | Lee los criterios activos de la sesión, obtiene productos y valores de filtros y renderiza `products`, `home` y `layout`. |
| Filtrado AJAX | [`FilterController::filter()`](../../app/Controller/FilterController.php) | Normaliza los query parameters, actualiza el estado de los filtros y devuelve únicamente el fragmento HTML `products`. |
| Estado de filtros | [`ProductFilter`](../../app/Filter/ProductFilter.php) | Acepta solo `category`, `color` y `weight`, guarda los criterios activos en la sesión y trata `all` como eliminación de un filtro concreto. |
| Acceso a datos | [`ProductRepository`](../../app/Database/ProductRepository.php) | Obtiene productos, categorías, colores y pesos mediante PDO. |
| Construcción de SQL | [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) | Forma condiciones únicamente para los identificadores permitidos `category`, `color` y `weight`; los valores se pasan por separado al prepared statement. |
| Conexión a la base | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php), [`ConnectionFactory`](../../app/Database/ConnectionFactory.php) | Construye la configuración con prioridad defaults → archivo local → `DB_*`, valida los valores y crea PDO con excepciones, associative fetch mode y emulación de prepare desactivada. |
| Presentación | [`ViewRenderer`](../../app/View/ViewRenderer.php), [`templates/`](../../templates/) | Permite solo las plantillas registradas `layout`, `home` y `products`; los valores scalar dinámicos se escapan con `htmlspecialchars` en UTF-8. |
| AJAX en el cliente | [`public/assets/js/ajax-filter.js`](../../public/assets/js/ajax-filter.js) | Observa los filtros, cancela la solicitud anterior aún no terminada mediante `AbortController`, llama a `/ajax-filter` y reemplaza el HTML de resultados. |
| UI en el cliente | [`public/assets/js/ui.js`](../../public/assets/js/ui.js) | Gestiona el tema y el idioma de la interfaz, guarda preferencias en `localStorage` y actualiza los textos tras una respuesta AJAX. |
| Errores | [`templates/error/404.php`](../../templates/error/404.php), manejo global de excepciones | Una ruta desconocida devuelve `404`; una excepción no controlada se registra en el servidor y el cliente recibe `500` sin detalles internos. |

## Rutas

| Ruta | Manejador | Respuesta |
|---|---|---|
| `/` | [`HomeController::index()`](../../app/Controller/HomeController.php) | Página HTML completa del catálogo. |
| `/ajax-filter` | [`FilterController::filter()`](../../app/Controller/FilterController.php) | Solo el fragmento HTML de la lista de productos. |

La aplicación no maneja otras rutas de negocio.

## Flujo del filtrado AJAX

1. El usuario cambia la categoría, el color o el peso.
2. [`ajax-filter.js`](../../public/assets/js/ajax-filter.js) cancela la solicitud anterior no terminada si sigue ejecutándose.
3. El navegador envía el criterio modificado a `/ajax-filter`.
4. [`ProductFilter`](../../app/Filter/ProductFilter.php) acepta únicamente parámetros permitidos y actualiza su estado en la sesión PHP.
5. [`ProductRepository`](../../app/Database/ProductRepository.php) obtiene el resultado mediante [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) y PDO.
6. [`FilterController`](../../app/Controller/FilterController.php) renderiza `products` y el navegador reemplaza únicamente el bloque de resultados.

Los filtros no enviados permanecen activos. El valor `all` limpia únicamente su criterio correspondiente; el botón de restablecimiento envía `all` para los tres campos.

## Límites clave

| Límite | Decisión | Resultado |
|---|---|---|
| Construcción de dependencias | Todas las concrete dependencies se crean en [`public/index.php`](../../public/index.php). | Los controladores no ocultan la creación de PDO, repositorios o renderer en su interior. |
| Filtros de entrada | [`ProductFilter`](../../app/Filter/ProductFilter.php) trabaja solo con `category`, `color` y `weight`; se ignoran valores vacíos y no escalares. | Los parámetros HTTP no se convierten directamente en criterios arbitrarios de consulta. |
| SQL | Los identificadores de filtro se eligen desde un allowlist y los valores se pasan a native prepared statements. | Los valores del usuario no se concatenan en SQL. |
| Configuración de base | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php) valida claves, strings obligatorios, puerto y `charset` antes de conectar. | Una configuración local incorrecta falla de forma predecible antes de ejecutar una consulta. |
| Plantillas | [`ViewRenderer`](../../app/View/ViewRenderer.php) permite solo plantillas conocidas y escapa los valores scalar dinámicos. | Una solicitud no puede proporcionar un nombre arbitrario de plantilla y los datos no se escriben en HTML sin escaping contextual. |
| Errores | Los detalles de las excepciones permanecen en el log del servidor; el cliente HTTP recibe un `500` breve. | Los detalles internos de la aplicación no se exponen al usuario. |

Los fragmentos HTML internos ya renderizados, como `$content` y la lista de productos, se pasan entre plantillas como trusted rendered HTML.

## Lo que no se añade intencionadamente

- clase router separada;
- contenedor DI;
- ORM;
- framework PHP;
- dependencias Composer;
- framework frontend;
- capa API separada.

La construcción de dependencias permanece explícita en el entry point para que todo el flujo de demostración pueda seguirse directamente en el código sin infraestructura adicional.
