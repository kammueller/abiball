FROM php:7.0-apache

# PHP extensions and libraries
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        unzip \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        postgresql-client-common \
        libpq-dev \
        curl \
        git \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mysqli gd iconv \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install mcrypt

# Install composer
RUN  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# copy composer file
COPY composer.json /var/www/html

# Install app dependencies
RUN cd /var/www/html && \
    composer install --no-interaction

# The WebContent
COPY abiball/ /var/www/html/

RUN a2enmod rewrite

EXPOSE 80