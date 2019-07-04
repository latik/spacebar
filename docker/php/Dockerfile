FROM php:fpm-alpine

RUN set -eux; \
    apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        libpng-dev \
        libzip-dev \
        icu-dev \
        zlib-dev \
        rabbitmq-c-dev \
        postgresql-dev \
    ; \
    \
    docker-php-ext-configure zip --with-libzip; \
    docker-php-ext-install -j$(nproc) \
        pdo_pgsql \
        bcmath \
        gd \
        intl \
        zip \
    ; \
    pecl install \
        apcu \
        amqp \
        xdebug \
    ; \
    pecl clear-cache; \
    docker-php-ext-enable \
        apcu \
        opcache \
        amqp \
    ; \
    \
    runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )"; \
    apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
    \
    apk del .build-deps

# Iconv fix
RUN apk add --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

COPY php.ini /usr/local/etc/php/php.ini

COPY conf.d $PHP_INI_DIR/conf.d