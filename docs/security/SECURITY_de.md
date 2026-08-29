# Sicherheitsrichtlinie

## Sprache wählen

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](https://github.com/yaleksandr89/filter-ajax/blob/master/.github/SECURITY.md) | [English](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_en.md) | [Español](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_es.md) | [中文](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_zh.md) | [Français](https://github.com/yaleksandr89/filter-ajax/blob/master/docs/security/SECURITY_fr.md) | **Deutsch** |

## Unterstützte Versionen

Sicherheitskorrekturen werden für den aktuellen Stand von `master` und für das zuletzt veröffentlichte Release betrachtet.

| Version | Unterstützt |
|---|---|
| `master` | Ja |
| Zuletzt veröffentlichtes Release | Ja |

## Was als Schwachstelle gilt

Zu Sicherheitsproblemen zählen insbesondere:

- SQL Injection oder eine Möglichkeit, die Filter-Allowlist zu umgehen;
- XSS oder Ausgabe von Benutzer-/dynamischen Daten ohne korrektes HTML Escaping;
- Umgehung erwarteter Routenbeschränkungen oder unsichere Behandlung des Request-Pfads;
- Möglichkeit, Template-Namen, Dateipfade oder andere interne Bezeichner über externe Eingaben zu ersetzen;
- Offenlegung von Datenbankpasswörtern, Cookies, Session-Daten oder lokaler/Produktionskonfiguration;
- Preisgabe interner Anwendungsdetails über Fehlermeldungen oder Logs;
- unsichere Änderungen an Docker/Nginx/PHP-Konfigurationen, durch die interne Dateien oder Services extern erreichbar werden.

Normale Fehler ohne Security-Auswirkung sollten über [GitHub Issues](https://github.com/yaleksandr89/filter-ajax/issues) gemeldet werden. Fragen und allgemeine Ideen gehören besser in [GitHub Discussions](https://github.com/yaleksandr89/filter-ajax/discussions).

## Eine Schwachstelle melden

Bevorzugt wird GitHub Private Vulnerability Reporting, sofern es für das Repository verfügbar ist:

1. Öffnen Sie den Tab **Security**.
2. Wechseln Sie zu **Advisories**.
3. Wählen Sie **Report a vulnerability**.
4. Senden Sie den Bericht, ohne sensible Details in einem normalen Issue oder einer Discussion zu veröffentlichen.

Falls Private Vulnerability Reporting nicht verfügbar ist, erstellen Sie ein minimales öffentliches Issue ohne technische Details der Schwachstelle und bitten Sie um einen privaten Kommunikationskanal.

Vor Veröffentlichung eines Fixes nicht veröffentlichen:

- echte Passwörter oder Tokens;
- Cookies oder Session-Daten;
- Produktionskonfiguration;
- echte personenbezogene Daten;
- vollständige Produktionslogs;
- einen funktionierenden Exploit oder Details, mit denen sich der Angriff ohne zusätzliche Analyse reproduzieren lässt.

## Inhalt des Berichts

Wenn möglich, geben Sie an:

- betroffenes Release, Branch oder Commit;
- Beschreibung der möglichen Auswirkungen;
- minimale Reproduktionsschritte;
- erwartetes und tatsächliches Verhalten;
- bereinigte Request/Response/Log-Fragmente, wenn sie bei der Diagnose helfen;
- einen möglichen Fix, falls bekannt.

Verwenden Sie nur synthetische oder anonymisierte Daten.

## Bearbeitung des Berichts

Berichte werden nach Verfügbarkeit geprüft; ein fester SLA wird nicht zugesagt.

Bitte koordinieren Sie die Offenlegung mit dem Projektmaintainer, bevor Details veröffentlicht werden. Nach Bestätigung einer Schwachstelle werden Fix und Informationen zu betroffenen Versionen im Rahmen einer Coordinated Disclosure veröffentlicht.

Das Projekt erklärt kein Bug-Bounty-Programm.
