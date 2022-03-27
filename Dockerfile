FROM php:7.4-fpm

WORKDIR /var/www

USER root

RUN apt-get update && apt-get install -y \
    libzip-dev \
    locales \
    zip \
    nano \
    unzip \
    git \
    curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql exif pcntl bcmath zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY symfony-task /var/www