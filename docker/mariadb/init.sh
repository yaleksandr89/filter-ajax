#!/usr/bin/env bash

set -Eeuo pipefail

mode="${FILTER_AJAX_DB_MODE:-demo}"

case "${mode}" in
    schema|demo)
        ;;
    *)
        printf '%s\n' 'FILTER_AJAX_DB_MODE must be either "schema" or "demo".' >&2
        exit 64
        ;;
esac

run_sql() {
    MYSQL_PWD="${MARIADB_PASSWORD:?MARIADB_PASSWORD must be set}" \
        mariadb \
            --protocol=socket \
            --user="${MARIADB_USER:?MARIADB_USER must be set}" \
            --database="${MARIADB_DATABASE:?MARIADB_DATABASE must be set}" \
            < "$1"
}

run_sql /opt/filter-ajax-db/schema.sql

if [[ "${mode}" == 'demo' ]]; then
    run_sql /opt/filter-ajax-db/demo-data.sql
fi
