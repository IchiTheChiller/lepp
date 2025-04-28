FROM php:fpm-alpine

# Installiere Abhängigkeiten für pgsql und pdo_pgsql
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pgsql pdo_pgsql