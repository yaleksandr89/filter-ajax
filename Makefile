PROJECT ?= filter-ajax
HTTP_PORT ?= 8080
DB_MODE ?= demo
CMD ?=
SERVICE ?=

COMPOSE = FILTER_AJAX_HTTP_PORT=$(HTTP_PORT) FILTER_AJAX_DB_MODE=$(DB_MODE) docker compose -p $(PROJECT)
SERVICES := php nginx db

.DEFAULT_GOAL := help
.PHONY: help config build up down restart ps log in php xdebug db-check db-reinit smoke

help:
	@printf '%s\n' 'Filter Ajax developer commands / Команды разработки:'
	@printf '%s\n' '  make config                            Print resolved Compose configuration / Вывести Compose-конфигурацию'
	@printf '%s\n' '  make build                             Build local images / Собрать локальные образы'
	@printf '%s\n' '  make up [DB_MODE=schema|demo] [HTTP_PORT=8080]  Start stack and wait / Запустить stack и дождаться готовности'
	@printf '%s\n' '  make down                              Stop stack and preserve DB data / Остановить stack, сохранить БД'
	@printf '%s\n' '  make restart [SERVICE=php|nginx|db]     Restart all or one service / Перезапустить все сервисы или один'
	@printf '%s\n' '  make ps                                Show project containers / Показать контейнеры проекта'
	@printf '%s\n' '  make log [SERVICE=php|nginx|db]         Follow all or one service log / Смотреть все логи или лог одного сервиса'
	@printf '%s\n' '  make in SERVICE=<php|nginx|db>          Open non-root service shell / Открыть shell без root'
	@printf '%s\n' '  make php CMD="..."                      Run PHP as www-data / Запустить PHP от www-data'
	@printf '%s\n' '  make xdebug                            Print Xdebug information / Показать информацию Xdebug'
	@printf '%s\n' '  make db-check                          Print database state / Показать состояние БД'
	@printf '%s\n' '  make smoke                             Run compact runtime smoke / Запустить краткий runtime smoke'
	@printf '%s\n' '  make db-reinit CONFIRM=filter_ajax_db [DB_MODE=schema|demo]  Recreate only this project DB volume / Пересоздать только DB volume проекта'
	@printf '%s\n' ''
	@printf '%s\n' 'Examples:'
	@printf '%s\n' '  make build'
	@printf '%s\n' '  make up'
	@printf '%s\n' '  make up DB_MODE=schema'
	@printf '%s\n' '  make up HTTP_PORT=18080'
	@printf '%s\n' '  make restart'
	@printf '%s\n' '  make restart SERVICE=php'
	@printf '%s\n' '  make log'
	@printf '%s\n' '  make log SERVICE=nginx'
	@printf '%s\n' '  make in SERVICE=php'
	@printf '%s\n' '  make php CMD="-v"'
	@printf '%s\n' '  make xdebug'
	@printf '%s\n' '  make db-check'
	@printf '%s\n' '  make smoke'
	@printf '%s\n' '  make db-reinit CONFIRM=filter_ajax_db DB_MODE=demo'
	@printf '%s\n' ''
	@printf '%s\n' 'Note: changing DB_MODE on an existing DB volume does not reinitialize data; use db-reinit / Смена DB_MODE не переинициализирует существующий volume; используйте db-reinit.'

config:
	@$(COMPOSE) config

build:
	@$(COMPOSE) build

up:
	@$(COMPOSE) up -d --wait

down:
	@$(COMPOSE) down --remove-orphans

restart:
	@case "$(SERVICE)" in ""|php|nginx|db) ;; *) printf '%s\n' 'Unknown SERVICE "$(SERVICE)". Allowed: php nginx db' >&2; exit 1;; esac
	@$(COMPOSE) restart $(SERVICE)

ps:
	@$(COMPOSE) ps

log:
	@case "$(SERVICE)" in ""|php|nginx|db) ;; *) printf '%s\n' 'Unknown SERVICE "$(SERVICE)". Allowed: php nginx db' >&2; exit 1;; esac
	@$(COMPOSE) logs -f --tail=100 $(SERVICE)

in:
	@case "$(SERVICE)" in \
		php) $(COMPOSE) exec --user www-data php bash ;; \
		nginx) $(COMPOSE) exec --user nginx nginx sh ;; \
		db) $(COMPOSE) exec --user mysql db bash ;; \
		"") printf '%s\n' 'Set SERVICE, e.g. make in SERVICE=php' >&2; exit 1 ;; \
		*) printf '%s\n' 'Unknown SERVICE "$(SERVICE)". Allowed: php nginx db' >&2; exit 1 ;; \
	esac

php:
	@test -n "$(strip $(CMD))" || (printf '%s\n' 'Set CMD, e.g. make php CMD="-v"' >&2; exit 1)
	@$(COMPOSE) exec --user www-data php php $(CMD)

xdebug:
	@$(COMPOSE) exec -T --user www-data php php --ri xdebug

db-check:
	@$(COMPOSE) exec -T --user mysql db sh -lc 'MYSQL_PWD="$$MARIADB_PASSWORD" mariadb --protocol=tcp --user="$$MARIADB_USER" --database="$$MARIADB_DATABASE" -Nse "SELECT CONCAT('\''database='\'', DATABASE()); SHOW TABLES; SELECT CONCAT('\''categories='\'', COUNT(*)) FROM categories; SELECT CONCAT('\''colors='\'', COUNT(*)) FROM colors; SELECT CONCAT('\''weights='\'', COUNT(*)) FROM weights; SELECT CONCAT('\''products='\'', COUNT(*)) FROM products;"'

db-reinit:
	@test "$(CONFIRM)" = filter_ajax_db || (printf '%s\n' 'Refusing to reinitialize the DB volume. Re-run with: make db-reinit CONFIRM=filter_ajax_db' >&2; exit 1)
	@case "$(DB_MODE)" in schema|demo) ;; *) printf '%s\n' 'DB_MODE must be schema or demo.' >&2; exit 1;; esac
	@volume="$(PROJECT)_filter_ajax_db"; \
	if docker volume inspect "$$volume" >/dev/null 2>&1; then \
		project_label=$$(docker volume inspect -f '{{ index .Labels "com.docker.compose.project" }}' "$$volume"); \
		volume_label=$$(docker volume inspect -f '{{ index .Labels "com.docker.compose.volume" }}' "$$volume"); \
		test "$$project_label" = "$(PROJECT)" && test "$$volume_label" = filter_ajax_db || { printf '%s\n' 'Refusing to remove a volume with unexpected Compose labels.' >&2; exit 1; }; \
	fi
	@$(COMPOSE) down --remove-orphans
	@volume="$(PROJECT)_filter_ajax_db"; \
	if docker volume inspect "$$volume" >/dev/null 2>&1; then \
		docker volume rm "$$volume"; \
	else \
		printf '%s\n' "DB volume $$volume does not exist; starting with a fresh volume"; \
	fi
	@$(COMPOSE) up -d --wait
	@$(MAKE) PROJECT="$(PROJECT)" HTTP_PORT="$(HTTP_PORT)" DB_MODE="$(DB_MODE)" db-check

smoke:
	@running="$$( $(COMPOSE) ps --status running --services )"; \
	for service in $(SERVICES); do \
		printf '%s\n' "$$running" | grep -Fx "$$service" >/dev/null || { printf '%s\n' "Stack is not fully running; missing $$service. Run: make up" >&2; exit 1; }; \
	done
	@test "$$(curl --silent --output /dev/null --write-out '%{http_code}' http://127.0.0.1:$(HTTP_PORT)/)" = 200
	@test "$$(curl --silent --output /dev/null --write-out '%{http_code}' http://127.0.0.1:$(HTTP_PORT)/assets/css/app.css)" = 200
	@test "$$(curl --silent --output /dev/null --write-out '%{http_code}' http://127.0.0.1:$(HTTP_PORT)/not-found)" = 404
	@test "$$(curl --silent --output /dev/null --write-out '%{http_code}' http://127.0.0.1:$(HTTP_PORT)/index.php)" = 404
	@test "$$(curl --silent --output /dev/null --write-out '%{http_code}' http://127.0.0.1:$(HTTP_PORT)/anything.php)" = 404
	@$(COMPOSE) exec -T --user www-data php php -m | grep -Fx pdo_mysql
	@test "$$($(COMPOSE) exec -T --user www-data php php -r 'echo phpversion("xdebug");')" = 3.5.3
	@$(MAKE) PROJECT="$(PROJECT)" HTTP_PORT="$(HTTP_PORT)" DB_MODE="$(DB_MODE)" db-check
	@printf '%s\n' 'Runtime smoke passed.'
