# AJAX Filter

[![Source Code](https://img.shields.io/badge/source-yaleksandr89%2Ffilter--ajax-blue.svg?style=flat-square)](https://github.com/yaleksandr89/filter-ajax)
[![CI](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml/badge.svg)](https://github.com/yaleksandr89/filter-ajax/actions/workflows/ci.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](../../LICENSE.md)

<p align="center">
  <img
    src="../img/filter-ajax-readme-cover.png"
    alt="AJAX Filter — sichere dynamische Filterung für PHP mit AJAX und datenbankgestützten Listen"
    width="100%"
  >
</p>

## Sprache wählen

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../../README.md) | [English](README_en.md) | [Español](README_es.md) | [中文](README_zh.md) | [Français](README_fr.md) | **Ausgewählt** |

## Beschreibung

`AJAX Filter` ist ein kleines PHP-Demoprojekt, das Produkte nach Kategorie, Farbe und Gewicht filtert, ohne die Seite neu zu laden. Der Client verwendet natives JavaScript und `fetch()`, der Server PHP und PDO.

Das Projekt verwendet bewusst weder Composer noch JavaScript-Bibliotheken und behält eine einfache Struktur zum Erlernen grundlegender AJAX-Filterung bei.

## Stack

- PHP 8.5
- MySQL / MariaDB über PDO
- Natives JavaScript
- Natives CSS
- Nginx + PHP-FPM für das mitgelieferte Serverbeispiel

## Schnellstart

1. Erstellen Sie eine Datenbank und importieren Sie [`docs/mysql-dump/ajax-filter.sql`](../mysql-dump/ajax-filter.sql).
2. Kopieren Sie [`config/database.php.example`](../../config/database.php.example) nach `config/database.php`.
3. Ersetzen Sie die Platzhalter in `config/database.php` durch lokale Datenbankwerte. Diese Datei wird von Git ignoriert.
4. Alternativ können Sie `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` und `DB_CHARSET` setzen; Umgebungswerte überschreiben Dateiwerten.
5. Passen Sie sowohl das Document Root des Webservers als auch `fastcgi_pass` an Ihre lokale Umgebung an. Ein Nginx-Beispiel befindet sich in [`docs/examples/nginx-configuration.conf`](../examples/nginx-configuration.conf).
6. Öffnen Sie die Anwendung über den konfigurierten lokalen Host.

## Funktionsweise der Filterung

Wenn sich ein Filter ändert, sendet der Browser eine Anfrage an `/ajax-filter`. Der Server akzeptiert ausschließlich die Felder `category`, `color` und `weight`, speichert aktive Filter in der Session und führt eine parametrisierte PDO-Abfrage aus.

<details>
  <summary>Filter-Demo</summary>

![AJAX Filter demo](../img/ajax-filter-main.gif)
</details>

## Theme-Umschaltung

Die Oberfläche unterstützt helle, dunkle und systemabhängige Themes mit projektinternem CSS und nativem JavaScript; das System-Theme folgt der Betriebssystemeinstellung.

<details>
  <summary>Theme-Demo</summary>

![AJAX Filter theme demo](../img/ajax-filter-theme-color.gif)
</details>

## Prüfungen

GitHub Actions prüft:

- PHP-Syntax;
- JavaScript-Syntax;
- Eigene Regressionstests für Filternormalisierung und Session-Semantik, SQL-Allowlisting/-Parametrisierung und den deterministischen Query-Vertrag, Priorität/Validierung der Datenbankkonfiguration, HTML-Escaping und nativen Autoload.

## Lizenz

Das Projekt wird unter der [MIT](../../LICENSE.md)-Lizenz veröffentlicht.
