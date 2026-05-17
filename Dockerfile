FROM php:8.4-fpm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www