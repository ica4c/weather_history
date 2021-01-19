FROM php:8.0-fpm

# replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

RUN apt-get update \
    && apt-get -y install \
            ssh git curl \
            libpq-dev \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libev-dev \
            libgmp-dev re2c libmhash-dev libmcrypt-dev file \
            libmagickwand-dev \
        --no-install-recommends

# Install gd and freetype
RUN docker-php-ext-configure gd \
    --with-freetype-dir=/usr/lib/x86_64-linux-gnu/ \
    && docker-php-ext-install gd

# Install imagick
RUN pecl install imagick && \
    docker-php-ext-enable imagick

# Install required extensions
RUN docker-php-ext-install bcmath mbstring

# Install postgres extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Install redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install libuv
RUN pecl install ev \
    && docker-php-ext-enable ev

WORKDIR /app