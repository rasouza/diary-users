
FROM composer AS build

COPY composer.lock composer.json /var/www/
COPY database /var/www/database
COPY tests /var/www/tests

WORKDIR /var/www

RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --prefer-dist

COPY . .

FROM php:7.3-fpm-alpine AS app

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS curl-dev libtool libxml2-dev \
    && apk add --no-cache curl git libintl icu icu-dev libzip-dev libbson-dev \
    && pecl install mongodb-1.5.5 \
    && docker-php-ext-install bcmath curl iconv mbstring pdo pcntl tokenizer xml zip intl \
    && docker-php-ext-enable mongodb \
    && curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer \
    && apk del -f .build-deps

COPY --from=build /var/www/vendor /var/www/vendor

WORKDIR /var/www

COPY . .

RUN chown -R www-data:www-data /var/www
