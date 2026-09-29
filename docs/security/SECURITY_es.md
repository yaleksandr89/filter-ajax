# Política de seguridad

## Elegir idioma

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/SECURITY.md) | [English](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_en.md) | **Español** | [中文](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_zh.md) | [Français](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_fr.md) | [Deutsch](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_de.md) |

## Versiones compatibles

Las correcciones de seguridad se consideran para el estado actual de `master` y para la última versión publicada.

| Versión | Compatibilidad |
|---|---|
| `master` | Sí |
| Última versión publicada | Sí |

## Qué se considera una vulnerabilidad

Los problemas de seguridad incluyen, entre otros:

- SQL injection o posibilidad de eludir el allowlist de filtros;
- XSS o salida de datos de usuario/dinámicos sin un HTML escaping correcto;
- elusión de las restricciones esperadas de rutas o tratamiento inseguro del path de la solicitud;
- posibilidad de sustituir un nombre de plantilla, ruta de archivo u otro identificador interno mediante entrada externa;
- exposición de contraseñas de base de datos, cookies, session data o configuración local/production;
- fuga de detalles internos de la aplicación mediante mensajes de error o logs;
- cambios inseguros en la configuración Docker/Nginx/PHP que expongan archivos o servicios internos al exterior.

Los errores normales sin impacto de seguridad deben publicarse mediante [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues). Las preguntas e ideas generales se discuten mejor en [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).

## Cómo informar de una vulnerabilidad

El método preferido es GitHub Private Vulnerability Reporting cuando esté disponible para el repositorio:

1. Abre la pestaña **Security**.
2. Ve a **Advisories**.
3. Selecciona **Report a vulnerability**.
4. Envía el informe sin publicar detalles sensibles en un Issue o Discussion normal.

Si Private Vulnerability Reporting no está disponible, crea un Issue público mínimo sin detalles técnicos de la vulnerabilidad y solicita un canal privado de comunicación.

No publiques antes de que exista una corrección:

- contraseñas o tokens reales;
- cookies o session data;
- configuración de production;
- datos personales reales;
- logs completos de production;
- un exploit funcional o detalles que permitan reproducir el ataque sin análisis adicional.

## Qué incluir en el informe

Cuando sea posible, incluye:

- release, branch o commit afectados;
- descripción del impacto posible;
- pasos mínimos de reproducción;
- comportamiento esperado y real;
- fragmentos de request/response/log saneados cuando ayuden al diagnóstico;
- una posible solución, si se conoce.

Utiliza únicamente datos sintéticos o anonimizados.

## Tratamiento del informe

Los informes se revisan según la disponibilidad; no se promete un SLA fijo.

Antes de publicar detalles, coordina la divulgación con el mantenedor del proyecto. Tras confirmar una vulnerabilidad, la corrección y la información sobre las versiones afectadas se publican como parte de una divulgación coordinada.

El proyecto no declara un programa de recompensas por vulnerabilidades.
