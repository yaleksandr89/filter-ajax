FROM mariadb:12.3.2-noble

COPY --chmod=0555 docker/mariadb/init.sh /docker-entrypoint-initdb.d/10-init.sh
COPY docker/mariadb/schema.sql /opt/filter-ajax-db/schema.sql
COPY docker/mariadb/demo-data.sql /opt/filter-ajax-db/demo-data.sql
