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
    alt="AJAX Filter — Produktkatalog mit AJAX-Filterung in reinem PHP"
    width="100%"
  >
</p>

## Sprache wählen

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | [English](README_en.md) | [Español](README_es.md) | [中文](README_zh.md) | [Français](README_fr.md) | **Ausgewählt** |

`AJAX Filter` ist ein kleiner PHP-Katalog, in dem Produkte nach Kategorie, Farbe und Gewicht gefiltert werden, ohne die Seite neu zu laden. Das Projekt zeigt kompakt das Zusammenspiel von PHP, PDO, MariaDB und nativem JavaScript, ohne Composer oder Frontend-Bibliotheken.

## Funktionen

- Produktfilterung nach Kategorie, Farbe und Gewicht über `fetch()` ohne Neuladen der Seite.
- Ausgewählte Filter werden in der PHP-Session gespeichert.
- Asynchrones Zurücksetzen aller aktiven Filter.
- Zwei Datenbankmodi: leeres Schema und Demodaten.
- Lokaler Docker-Stack mit Nginx, PHP-FPM, MariaDB und Xdebug.

## Schnellstart

Benötigt werden Git, Docker mit Compose v2 und `make`.

| Schritt | Befehl | Zweck |
|---|---|---|
| 1 | `git clone https://github.com/yaleksandr89/filter-ajax.git` | Repository klonen. |
| 2 | `cd filter-ajax` | In das Projektverzeichnis wechseln. |
| 3 | `make build` | Lokale Docker-Images bauen. |
| 4 | `make up` | Stack starten und auf die Bereitschaft der Services warten. |

Öffnen Sie [http://127.0.0.1:8080](http://127.0.0.1:8080). Standardmäßig wird `DB_MODE=demo` verwendet; für ein leeres Schema führen Sie `make up DB_MODE=schema` mit einem neuen Volume aus. Details zu Volumes, Konfiguration und Diagnose stehen im [Entwicklungsleitfaden](development_de.md).

## Architektur und Projektstruktur

Anwendungsstruktur, Request-Flow, Filter, Session, PDO und Templates werden im separaten [Architekturleitfaden](architecture_de.md) beschrieben.

## Prüfungen

Die wichtigsten Prüfungen stehen über das Makefile zur Verfügung:

| Prüfung | Befehl |
|---|---|
| Aufgelöste Compose-Konfiguration | `make config` |
| PHP-Regressionstests | `make php CMD="tests/run.php"` |
| Runtime-Smoke-Test für einen bereits laufenden Stack | `make smoke` |

CI für Pushes und Pull Requests nach `master` prüft PHP und JavaScript, Regressionstests, Docker-Konfiguration und beide Datenbankmodi.

## Bewusst einfach gehalten

- Kein PHP-Framework und kein ORM.
- Keine Composer-Pakete.
- Keine JavaScript-Abhängigkeiten und kein Frontend-Framework.
- Keine separate API-Schicht.

Ziel des Projekts ist es, einen kleinen vollständigen Filterablauf mit den grundlegenden Möglichkeiten von PHP, PDO und nativem JavaScript zu zeigen.

## Feedback

- Reproduzierbare Fehler: [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues).
- Fragen und Ideen: [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).

---

<p align="center">
  Wenn das Projekt hilfreich war, geben Sie ihm einen Stern auf GitHub, damit andere Entwickler es leichter finden können.<br>
  🤘
</p>
