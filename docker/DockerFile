FROM php:7.2-fpm

WORKDIR /var/www
COPY . /var/www

RUN apt-get update && apt-get install -y \
    curl \
    zip unzip

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER 1
