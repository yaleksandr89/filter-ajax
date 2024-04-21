# Proyecto: Ejemplo de Implementación de Filtros con Solicitud Asincrónica

<details>
  <summary>Cómo funciona la filtración</summary>

![ajax filter is in operation](../img/ajax-filter-main.gif)
</details>

## Elija Idioma:

| Русский | English | Español | 中文 | Français | Deutsch |
|---------|------------|------------|-----------|-------------|----------|
| [Русский](../../README.md) | [English](README_en.md) | **Seleccionado** | [中文](README_zh.md) | [Français](README_fr.md) | [Deutsch](README_de.md) |

## Tecnologías Utilizadas:
- PHP 8
- MySQL (PDO)
- Bootstrap 5.3

## Descripción:
El proyecto implementa la filtración de productos por categoría, color y peso utilizando solicitudes asíncronas sin bibliotecas adicionales en JavaScript nativo. El framework CSS Bootstrap 5.3 se utiliza para el estilo, con un interruptor entre temas claro y oscuro implementado en la plantilla. 

<details>
  <summary>Cómo funciona el cambio de tema</summary>

![ajax filter is in operation](../img/ajax-filter-theme-color.gif)
</details>

En el directorio `docs/examples/` encontrarás dos archivos:
1. `nginx-configuration.conf` - un ejemplo de configuración para Nginx.
2. `db-config.php.example` - un ejemplo de archivo de configuración para conectar a la base de datos. Debes cambiar su nombre a `db-config.php`, copiarlo en `app/models/database.php` y proporcionar los datos pertinentes para conectarte a la base de datos.

El proyecto no utiliza Composer y está escrito de la manera más simple posible sin dependencias innecesarias.

## Ejecución del Proyecto:
1. Agrega la configuración a tu servidor. En el directorio `docs/examples/`, hay un ejemplo de configuración para Nginx. Sigue este ejemplo para configurar tu servidor.
2. Crea una base de datos e importa el contenido del archivo `ajax-filter.sql` ubicado en `docs/mysql-dump/`.
