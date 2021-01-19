FROM php:8.0-fpm

# replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

RUN apt-get update \
    && apt-get -y install \
            ssh git curl \
            libpq-dev \
        --no-install-recommends

# Install required extensions
RUN docker-php-ext-install bcmath mbstring

# Install postgres extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Install redis
RUN pecl install redis \
    && docker-php-ext-enable redis

WORKDIR /app