FROM php:fpm-alpine

# Installiere Abhängigkeiten für pgsql und pdo_pgsql
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# Installiere Composer
RUN apk add --no-cache composer

# Kopiere den PHP-Code in den Container
COPY . /usr/src/app

# Debugging: Überprüfe, ob composer.json existiert
RUN ls -l /usr/src/app/composer.json

# Debugging: Zeige den Inhalt von composer.json
RUN cat /usr/src/app/composer.json

# Installiere Abhängigkeiten und kopiere sie direkt nach /usr/share/nginx/vendor
RUN mkdir -p /usr/share/nginx/vendor \
    && composer install --no-dev --optimize-autoloader --working-dir=/usr/src/app \
    && ls -l /usr/src/app/vendor || echo "Vendor directory not created!" \
    && mv /usr/src/app/vendor/* /usr/share/nginx/vendor/

WORKDIR /usr/share/nginx