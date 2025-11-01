ARG PHP_VERSION=8.4-fpm
FROM php:${PHP_VERSION}

ARG COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_HOME=/composer

RUN apt-get update \
  && apt-get install -y --no-install-recommends \
     git curl unzip libpq-dev libzip-dev libonig-dev libxml2-dev \
     libpng-dev libjpeg-dev libfreetype6-dev ca-certificates \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath zip xml
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/html

COPY safi_test_work/composer.json safi_test_work/composer.lock ./

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true


RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
  && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

EXPOSE 9000
CMD ["php-fpm"]