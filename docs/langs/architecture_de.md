# Architektur

## Sprache wählen

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../architecture.md) | [English](architecture_en.md) | [Español](architecture_es.md) | [中文](architecture_zh.md) | [Français](architecture_fr.md) | **Ausgewählt** |

Die Anwendung bleibt klein, aber die wichtigsten Verantwortungsgrenzen sind explizit: Der Einstiegspunkt baut Abhängigkeiten zusammen, Controller koordinieren den HTTP-Ablauf, der Filter verwaltet Kriterien und Session-Zustand, das Repository liest Daten und Templates sind ausschließlich für die Darstellung zuständig.

## Request-Flow

```text
HTTP-Anfrage
    ↓
Nginx
    ↓
public/index.php
    ↓
Controller
    ↓
ProductFilter / ProductRepository / ViewRenderer
    ↓
HTML-Antwort
```

`/` liefert die vollständige Katalogseite. `/ajax-filter` rendert nur die Produktliste, mit der der Browser den aktuellen Ergebnisblock ersetzt.

## Komponenten und Verantwortlichkeiten

| Bereich | Komponenten | Verantwortung |
|---|---|---|
| Einstiegspunkt und Composition Root | [`public/index.php`](../../public/index.php) | Lädt Bootstrap, startet die Session, löst die Route auf und erstellt [`DatabaseConfig`](../../app/Database/DatabaseConfig.php), PDO, [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php), [`ProductRepository`](../../app/Database/ProductRepository.php), [`ProductFilter`](../../app/Filter/ProductFilter.php), [`ViewRenderer`](../../app/View/ViewRenderer.php) und die Controller. |
| Autoload | [`app/bootstrap.php`](../../app/bootstrap.php) | Registriert den nativen Autoloader für `App\`, akzeptiert nur gültige Klassennamensegmente und ordnet sie Dateien unter `app/` zu. Composer wird nicht verwendet. |
| Startseite | [`HomeController::index()`](../../app/Controller/HomeController.php) | Liest aktive Kriterien aus der Session, lädt Produkte und Filterwerte und rendert anschließend `products`, `home` und `layout`. |
| AJAX-Filterung | [`FilterController::filter()`](../../app/Controller/FilterController.php) | Normalisiert Query-Parameter, aktualisiert den Filterzustand und gibt nur das HTML-Fragment `products` zurück. |
| Filterzustand | [`ProductFilter`](../../app/Filter/ProductFilter.php) | Akzeptiert nur `category`, `color` und `weight`, speichert aktive Kriterien in der Session und behandelt `all` als Löschen genau eines Filters. |
| Datenzugriff | [`ProductRepository`](../../app/Database/ProductRepository.php) | Lädt Produkte, Kategorien, Farben und Gewichte über PDO. |
| SQL-Aufbau | [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) | Erstellt Bedingungen nur für die erlaubten Bezeichner `category`, `color` und `weight`; Werte werden separat an das Prepared Statement übergeben. |
| Datenbankverbindung | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php), [`ConnectionFactory`](../../app/Database/ConnectionFactory.php) | Baut die Konfiguration mit der Priorität defaults → lokale Datei → `DB_*` auf, validiert Werte und erstellt PDO mit Exceptions, associative fetch mode und deaktivierter Prepare-Emulation. |
| Darstellung | [`ViewRenderer`](../../app/View/ViewRenderer.php), [`templates/`](../../templates/) | Erlaubt nur die registrierten Templates `layout`, `home` und `products`; dynamische scalar-Werte werden mit `htmlspecialchars` in UTF-8 escaped. |
| AJAX im Client | [`public/assets/js/ajax-filter.js`](../../public/assets/js/ajax-filter.js) | Beobachtet Filter, bricht die vorherige noch laufende Anfrage über `AbortController` ab, ruft `/ajax-filter` auf und ersetzt das Ergebnis-HTML. |
| UI im Client | [`public/assets/js/ui.js`](../../public/assets/js/ui.js) | Verwaltet Theme und Sprache der Oberfläche, speichert Einstellungen in `localStorage` und aktualisiert Beschriftungen nach einer AJAX-Antwort. |
| Fehler | [`templates/error/404.php`](../../templates/error/404.php), globale Exception-Behandlung | Eine unbekannte Route liefert `404`; eine nicht behandelte Exception wird serverseitig protokolliert, während der Client `500` ohne interne Details erhält. |

## Routen

| Pfad | Handler | Antwort |
|---|---|---|
| `/` | [`HomeController::index()`](../../app/Controller/HomeController.php) | Vollständige HTML-Katalogseite. |
| `/ajax-filter` | [`FilterController::filter()`](../../app/Controller/FilterController.php) | Nur das HTML-Fragment der Produktliste. |

Weitere Anwendungsrouten werden nicht verarbeitet.

## Ablauf der AJAX-Filterung

1. Der Benutzer ändert Kategorie, Farbe oder Gewicht.
2. [`ajax-filter.js`](../../public/assets/js/ajax-filter.js) bricht die vorherige noch nicht abgeschlossene Anfrage ab, falls sie weiterhin läuft.
3. Der Browser sendet das geänderte Kriterium an `/ajax-filter`.
4. [`ProductFilter`](../../app/Filter/ProductFilter.php) akzeptiert nur erlaubte Parameter und aktualisiert deren Zustand in der PHP-Session.
5. [`ProductRepository`](../../app/Database/ProductRepository.php) lädt das Ergebnis über [`ProductQueryBuilder`](../../app/Database/ProductQueryBuilder.php) und PDO.
6. [`FilterController`](../../app/Controller/FilterController.php) rendert `products`; anschließend ersetzt der Browser nur den Ergebnisblock.

Nicht gesendete Filter bleiben aktiv. Der Wert `all` löscht nur das jeweilige Kriterium; der Reset-Button sendet `all` für alle drei Felder.

## Wichtige Grenzen

| Grenze | Entscheidung | Wirkung |
|---|---|---|
| Aufbau der Abhängigkeiten | Alle concrete dependencies werden in [`public/index.php`](../../public/index.php) erstellt. | Controller verstecken die Erstellung von PDO, Repository oder Renderer nicht in sich selbst. |
| Filtereingaben | [`ProductFilter`](../../app/Filter/ProductFilter.php) arbeitet nur mit `category`, `color` und `weight`; leere und nicht skalare Werte werden ignoriert. | HTTP-Parameter werden nicht direkt zu beliebigen Abfragekriterien. |
| SQL | Filterbezeichner stammen aus einer Allowlist, Werte werden an native Prepared Statements übergeben. | Benutzerwerte werden nicht in SQL konkateniert. |
| Datenbankkonfiguration | [`DatabaseConfig`](../../app/Database/DatabaseConfig.php) validiert Schlüssel, Pflichtstrings, Port und `charset` vor der Verbindung. | Eine fehlerhafte lokale Konfiguration schlägt vorhersehbar fehl, bevor eine Abfrage ausgeführt wird. |
| Templates | [`ViewRenderer`](../../app/View/ViewRenderer.php) erlaubt nur bekannte Templates und escaped dynamische scalar-Werte. | Eine Anfrage kann keinen beliebigen Template-Namen vorgeben und Daten werden nicht ohne kontextbezogenes Escaping in HTML geschrieben. |
| Fehler | Exception-Details bleiben im Server-Log; der HTTP-Client erhält eine kurze `500`-Antwort. | Interne Anwendungsdetails werden dem Benutzer nicht offengelegt. |

Bereits gerenderte interne HTML-Fragmente wie `$content` und die Produktliste werden zwischen Templates als trusted rendered HTML weitergegeben.

## Bewusst nicht hinzugefügt

- separate Router-Klasse;
- DI-Container;
- ORM;
- PHP-Framework;
- Composer-Abhängigkeiten;
- Frontend-Framework;
- separate API-Schicht.

Der Aufbau der Abhängigkeiten bleibt im Entry Point explizit, damit sich der gesamte Demonstrationsablauf ohne zusätzliche Infrastruktur direkt im Code nachvollziehen lässt.
