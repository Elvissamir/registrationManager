FROM php:8.0.3-fpm

WORKDIR /var/www

RUN apt-get update
RUN apt-get update && apt-get install -y \
zlib1g-dev \
libxml2-dev \
libzip-dev \
libonig-dev \
unzip

# PHP Extensions
RUN docker-php-ext-install bcmath zip pdo pdo_mysql opcache \
&& docker-php-ext-configure opcache --enable-opcache \
&& docker-php-source delete

COPY --from=composer:2.2.1 /usr/bin/composer /usr/bin/composer

EXPOSE 9000