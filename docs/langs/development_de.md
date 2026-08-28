# Entwicklung

## Sprache wählen

| Русский | English | Español | 中文 | Français | Deutsch |
|---|---|---|---|---|---|
| [Русский](../development.md) | [English](development_en.md) | [Español](development_es.md) | [中文](development_zh.md) | [Français](development_fr.md) | **Ausgewählt** |

## Anforderungen an den Host

Für den primären Docker-Workflow werden benötigt:

- Git;
- Docker Engine mit Compose v2;
- `make`.

PHP, MariaDB und Xdebug müssen auf dem Host nicht separat installiert werden. Der PHP-Container verwendet PHP 8.5.9-FPM mit `pdo_mysql` und Xdebug 3.5.3; außerdem gehören Nginx und MariaDB zum Stack.

## Ausführung ohne Docker

Das Projekt kann mit einer vorhandenen MariaDB-Instanz sowie PHP 8.5, der PDO-MySQL-Erweiterung und PHP-FPM betrieben werden. Erstellen Sie eine Datenbank, führen Sie [`docker/mariadb/schema.sql`](../../docker/mariadb/schema.sql) und bei Bedarf [`docker/mariadb/demo-data.sql`](../../docker/mariadb/demo-data.sql) aus und konfigurieren Sie anschließend `config/database.php` oder die `DB_*`-Umgebungsvariablen.

Das Document Root des Webservers muss auf `public/` zeigen. Für Nginx mit einem lokalen PHP-FPM-Unix-Socket kann die [Referenzkonfiguration](../examples/nginx-configuration.conf) angepasst werden: Sie leitet normale URIs an den Front Controller weiter und gibt keine direkten PHP-URIs frei.

## Erster Start mit Docker

| Befehl | Zweck |
|---|---|
| `make build` | Lokale Docker-Images bauen. |
| `make up` | Stack starten und auf die Bereitschaft der Services warten. |
| `make down` | Services stoppen und Datenbankdaten beibehalten. |

Sobald die Services bereit sind, ist die Anwendung unter [http://127.0.0.1:8080](http://127.0.0.1:8080) erreichbar.

> [!NOTE]
> Standardmäßig startet die Anwendung auf `127.0.0.1:8080`. Für einen anderen Port kann `HTTP_PORT` übergeben werden, zum Beispiel: `make up HTTP_PORT=18080`.
>
> Damit der Port in der aktuellen Shell-Session nicht bei jedem Make-Befehl erneut angegeben werden muss, führen Sie vorher `export HTTP_PORT=18080` aus. Danach verwenden normale `make up`-, `make smoke`- und andere Befehle diesen Wert.

## Wann ein Rebuild erforderlich ist

Bauen Sie die Images nach Änderungen an Dockerfiles oder der Image-Konfiguration unter `docker/php/`, `docker/mariadb/` oder `docker/nginx/` neu. Eine Änderung des Datenbankmodus für ein vorhandenes Volume initialisiert dessen Daten nicht erneut.

## Makefile-Befehle

| Befehl | Zweck |
|---|---|
| `make help` | Hilfe anzeigen. |
| `make config` | Aufgelöste Compose-Konfiguration ausgeben. |
| `make build` | Lokale Images bauen. |
| `make up [DB_MODE=schema\|demo] [HTTP_PORT=8080]` | Stack starten und auf Bereitschaft warten. |
| `make down` | Services stoppen und Datenbank-Volume beibehalten. |
| `make restart [SERVICE=php\|nginx\|db]` | Gesamten Stack oder einen Service neu starten. |
| `make ps` / `make log [SERVICE=…]` | Container oder Logs anzeigen. |
| `make in SERVICE=php\|nginx\|db` | Non-root-Shell in einem Service öffnen. |
| `make php CMD="…"` | PHP als `www-data` ausführen. |
| `make xdebug` | Xdebug-Informationen anzeigen. |
| `make db-check` | Tabellen und Anzahl der Datensätze anzeigen. |
| `make smoke` | Einen bereits laufenden Stack prüfen. |
| `make db-reinit CONFIRM=filter_ajax_db [DB_MODE=schema\|demo]` | Datenbank-Volume dieses Projekts neu initialisieren. |

## Schema- und Demo-Datenbankmodi

`DB_MODE=schema` erstellt nur die Tabellen. `DB_MODE=demo` erstellt zuerst das Schema und lädt anschließend Demodaten. Standardwert ist `demo`.

Der Modus wird nur bei der Initialisierung eines neuen MariaDB-Volumes gelesen. Existiert das Volume bereits, ändert ein anderer `DB_MODE` dessen Inhalt nicht. Verwenden Sie `db-reinit`, wenn bewusst eine neue Datenbank benötigt wird.

## Sichere Neuinitialisierung der Datenbank

`make db-reinit` stoppt den Stack, entfernt nur das Datenbank-Volume des aktuellen Compose-Projekts, startet die Services neu und führt `db-check` aus. Die Daten in diesem Volume werden dabei dauerhaft gelöscht.

Der Befehl erfordert die exakte Bestätigung `CONFIRM=filter_ajax_db`, akzeptiert nur `schema` oder `demo` und prüft vor dem Löschen die Compose-Labels eines vorhandenen Volumes. Beispiel: `make db-reinit CONFIRM=filter_ajax_db DB_MODE=demo`.

Verwenden Sie den Befehl nicht für einen normalen Neustart: `make down` behält das Volume bei und `make up` verwendet es erneut.

## Xdebug

Das PHP-Image enthält bereits Xdebug 3.5.3. Die Einstellungen lauten `xdebug.mode=debug`, `xdebug.start_with_request=trigger`, `xdebug.client_host=host.docker.internal` und `xdebug.client_port=9003`.

Mit `make xdebug` lässt sich die tatsächlich wirksame Konfiguration anzeigen.

## Prüfungen

Ohne laufende Services prüft `make config` die aufgelöste Compose-Konfiguration.

Für einen bereits laufenden Stack:

| Prüfung | Befehl |
|---|---|
| PHP-Regressionstests | `make php CMD="tests/run.php"` |
| Runtime-Smoke-Test | `make smoke` |

`make smoke` prüft die wichtigsten HTTP-Routen und ein statisches Asset, das Vorhandensein von `pdo_mysql`, die Xdebug-Version und den Datenbankzustand. CI läuft bei Pushes und Pull Requests nach `master` und prüft PHP- und JavaScript-Syntax, Regressionstests, Docker-Konfiguration sowie Smoke-Szenarien in den Modi `schema` und `demo`.

## Datenbankkonfiguration und Priorität

Für einen Start ohne Docker kopieren Sie [`config/database.php.example`](../../config/database.php.example) nach `config/database.php`. Diese lokale Datei wird von Git ignoriert. Befehl: `cp config/database.php.example config/database.php`.

Für `host`, `port` und `charset` sind bereits Basiswerte gesetzt: `127.0.0.1`, `3306` und `utf8mb4`. Datenbankname, Benutzer und Passwort müssen über `config/database.php` oder Umgebungsvariablen angegeben werden.

Wenn derselbe Parameter an mehreren Stellen definiert ist, gilt die Quelle mit der höheren Priorität:

1. `DB_*`-Umgebungsvariablen;
2. `config/database.php`, falls die Datei existiert;
3. Basiswerte für `host`, `port` und `charset`.

Umgebungsvariablen haben die höchste Priorität:

- `DB_HOST`;
- `DB_PORT`;
- `DB_NAME`;
- `DB_USER`;
- `DB_PASSWORD`;
- `DB_CHARSET`.

Vor der Verbindung werden die wichtigsten Werte validiert:

- `host`, `name`, `user` und `charset` müssen nicht leere Strings sein;
- `password` muss ein String sein;
- `port` muss eine ganze Zahl zwischen 1 und 65535 sein;
- `charset` darf nur Buchstaben, Ziffern und `_` enthalten.
