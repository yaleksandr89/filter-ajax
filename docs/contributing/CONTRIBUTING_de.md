# Mitwirken

## Sprache wählen

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/CONTRIBUTING.md) | [English](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_en.md) | [Español](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_es.md) | [中文](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_zh.md) | [Français](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/contributing/CONTRIBUTING_fr.md) | **Deutsch** |

Vielen Dank für das Interesse an AJAX Filter. Das Projekt ist klein, daher sollten Änderungen klar begrenzt, reproduzierbar und leicht zu prüfen sein.

## Vor dem Start

- Reproduzierbare Fehler bitte über [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues) melden.
- Fragen und allgemeine Ideen sollten zuerst in [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions) besprochen werden.
- Keine Passwörter, Tokens, Produktionskonfiguration, personenbezogenen Daten oder andere sensible Informationen veröffentlichen.
- Vor einer größeren Änderung sicherstellen, dass sie zum Zweck des Projekts passt und keine Infrastruktur oder Abhängigkeiten ohne klaren Bedarf hinzufügt.

## Projektvertrag

- AJAX Filter ist eine kleine PHP-Webanwendung ohne PHP-Framework, ORM oder Composer-Abhängigkeiten.
- Die Client-Seite verwendet natives JavaScript ohne Frontend-Frameworks oder JavaScript-Abhängigkeiten von Drittanbietern.
- Die Anwendung verarbeitet zwei Anwendungsrouten: `/` und `/ajax-filter`.
- Die Filterung verwendet `category`, `color` und `weight`; aktive Kriterien werden in der PHP-Session gespeichert.
- Der Datenzugriff erfolgt über PDO; Filterwerte werden an native Prepared Statements übergeben, SQL-Bezeichner werden nur aus der erlaubten Menge gewählt.
- `public/index.php` bleibt der Composition Root und baut die Anwendungsabhängigkeiten explizit zusammen.
- Der primäre lokale Workflow basiert auf Docker Compose und dem Makefile.
- Die Modi `schema` und `demo` werden nur bei der Initialisierung eines neuen MariaDB-Volumes angewendet.
- Änderungen dürfen ohne separate Entscheidung keine Framework-Schicht, kein ORM, keinen DI-Container, keine separate API, keine automatischen Retry/Cache/Fallback-Mechanismen oder andere neue Subsysteme hinzufügen.

Die Anwendungsstruktur ist im [Architekturleitfaden](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/architecture_de.md) beschrieben; lokaler Start und Prüfungen stehen im [Entwicklungsleitfaden](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_de.md).

## Branches

Verwenden Sie einen kurzen Namen, der den Zweck der Änderung widerspiegelt, zum Beispiel:

```text
fix/filter-validation
docs/update-development-guide
chore/update-ci
```

## Commits

Conventional Commits werden bevorzugt. Beispiele:

```text
fix: Filterverarbeitung korrigieren
docs: lokalen Start präzisieren
test: Filterregression abdecken
chore: CI-Konfiguration aktualisieren
```

## Lokale Prüfung

Führen Sie vor einem Pull Request die für Ihre Änderung relevanten Prüfungen aus:

| Geänderter Bereich | Prüfung |
|---|---|
| Docker Compose oder Container-Konfiguration | `make config` |
| PHP-Anwendungsverhalten | `make php CMD="tests/run.php"` |
| HTTP/runtime-Verhalten des laufenden Stacks | `make smoke` |

Für den Projektstart und die vollständige Liste der Make-Befehle verwenden Sie den [Entwicklungsleitfaden](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/langs/development_de.md).

Wenn eine Änderung den Datenbankmodus oder die Datenbankinitialisierung betrifft, prüfen Sie sie mit einem neuen Volume. `make db-reinit` entfernt Daten nur aus dem Datenbank-Volume des aktuellen Compose-Projekts und muss bewusst verwendet werden.

## Pull Request

Geben Sie in der Pull-Request-Beschreibung an:

- Problem oder Ziel der Änderung;
- was genau geändert wurde;
- ausgeführte Prüfungen;
- hinzugefügte oder aktualisierte Tests bei Verhaltensänderungen;
- Auswirkungen auf Docker, Datenbank, Sicherheit, UI oder Dokumentation, falls zutreffend.

Vor dem Absenden sicherstellen, dass:

- die Änderung auf eine zusammenhängende Aufgabe begrenzt ist;
- kein unabhängiges Refactoring oder Formatieren enthalten ist;
- keine Secrets, lokale Konfiguration oder sensiblen Daten im Commit enthalten sind;
- Tests und Runtime-Prüfungen dem betroffenen Verhalten entsprechen;
- die Dokumentation aktualisiert wurde, wenn sich Befehle, Verträge oder beobachtbares Verhalten geändert haben;
- übersetzte Dokumentation synchron bleibt, wenn ein bereits übersetztes Dokument geändert wurde.
