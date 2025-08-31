FROM php:8.2-fpm-bookworm

COPY php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y \
        default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*


COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www
