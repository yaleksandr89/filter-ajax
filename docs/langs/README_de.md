# Projekt: Beispiel für die Implementierung von Filtern mit asynchroner Anfrage

## Sprache Auswählen:

| Русский | English | Español | 中文 | Français | Deutsch |
|---------|------------|------------|-----------|-------------|----------|
| [Русский](../../README.md) | [English](README_en.md) | [Español](README_es.md) | [中文](README_zh.md) | [Français](README_fr.md) | **Ausgewählt** |


## Verwendeter Technologie-Stack:
- PHP 8
- MySQL (PDO)
- Bootstrap 5.3

## Beschreibung:
Das Projekt implementiert die Filterung von Produkten nach Kategorie, Farbe und Gewicht unter Verwendung asynchroner Anfragen ohne zusätzliche Bibliotheken in nativem JavaScript. Das CSS-Framework Bootstrap 5.3 wird zur Gestaltung verwendet, wobei in der Vorlage ein Wechsel zwischen hellen und dunklen Designs implementiert ist. Im Verzeichnis `docs/examples/` finden Sie zwei Dateien:
1. `nginx-configuration.conf` - Ein Beispiel für die Konfiguration von Nginx.
2. `db-config.php.example` - ein Beispiel für eine Konfigurationsdatei zur Verbindung mit der Datenbank. Sie müssen seinen Namen in `db-config.php` ändern, ihn in `app/models/database.php` kopieren und die relevanten Daten für die Verbindung zur Datenbank angeben.

Das Projekt verwendet kein Composer und ist so einfach wie möglich ohne unnötige Abhängigkeiten geschrieben.

## Ausführen des Projekts:
1. Fügen Sie die Konfiguration Ihrem Server hinzu. Im Verzeichnis `docs/examples/` befindet sich eine Beispielkonfiguration für Nginx. Befolgen Sie dieses Beispiel, um Ihren Server zu konfigurieren.
2. Erstellen Sie eine Datenbank und importieren Sie den Inhalt der Datei `ajax-filter.sql`, die sich in `docs/mysql-dump/` befindet.
