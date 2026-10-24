FROM composer:2 AS composer

FROM php:8.5.12-fpm-bookworm

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY etc/docker/fpm/99-runtime-security.ini /usr/local/etc/php/conf.d/99-runtime-security.ini

RUN apt-get update \
    && apt-get install --no-install-recommends --yes git libicu-dev unzip \
    && docker-php-ext-install intl \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app
