FROM php:7.4-fpm-alpine


WORKDIR /var/www/html

RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
        && pecl install apcu \
        && docker-php-ext-enable apcu \
        && pecl clear-cache \
        && apk del .build-dependencies

RUN docker-php-ext-install pdo pdo_mysql


USER 1000:1000

EXPOSE 9000
