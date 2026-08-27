FROM php:8.5.9-fpm-trixie AS xdebug-builder

ARG PIE_VERSION=1.4.10
ARG PIE_SHA256=b88792235c8e80be568436d4cb043b49fd1869c89b64e83d23e2882ae19d70a8

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        libtool \
        unzip \
        $PHPIZE_DEPS; \
    rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    curl --fail --location --silent --show-error \
        --output /tmp/pie.phar \
        "https://github.com/php/pie/releases/download/${PIE_VERSION}/pie.phar"; \
    echo "${PIE_SHA256}  /tmp/pie.phar" | sha256sum --check; \
    php /tmp/pie.phar install --no-interaction xdebug/xdebug:3.5.3; \
    cp "$(php-config --extension-dir)/xdebug.so" /tmp/xdebug.so; \
    rm -f /tmp/pie.phar


FROM php:8.5.9-fpm-trixie

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html

COPY --from=xdebug-builder /tmp/xdebug.so /usr/local/lib/php/extensions/xdebug.so
COPY docker/php/conf.d/zz-xdebug.ini /usr/local/etc/php/conf.d/zz-xdebug.ini

COPY app/ ./app/
COPY public/ ./public/
COPY templates/ ./templates/
