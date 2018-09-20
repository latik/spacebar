FROM php:fpm-alpine

RUN set -eux; \
    apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        libpng-dev \
        libzip-dev \
        icu-dev \
        zlib-dev \
    ; \
    \
    docker-php-ext-configure zip --with-libzip; \
    docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        bcmath \
        gd \
        intl \
        zip \
    ; \
    pecl install \
        apcu \
    ; \
    pecl clear-cache; \
    docker-php-ext-enable \
        apcu \
        opcache \
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

COPY php.ini /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN set -eux; \
    composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative; \
    composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

COPY . /var/www/html