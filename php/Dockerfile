FROM php:fpm-alpine

# Installiere Abhängigkeiten für pgsql, pdo_pgsql, gd und dom
RUN apk add --no-cache postgresql-dev libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev libxml2-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install pgsql pdo_pgsql gd dom

# Installiere Composer
RUN apk add --no-cache composer

# Kopiere den PHP-Code in den Container
COPY . /usr/src/app

# Debugging: Überprüfe, ob composer.json existiert
RUN ls -l /usr/src/app/composer.json

# Debugging: Zeige den Inhalt von composer.json
RUN cat /usr/src/app/composer.json

# Debugging: Teste die Internetverbindung
RUN ping -c 4 packagist.org || echo "Could not reach Packagist!"

# Installiere Abhängigkeiten und kopiere sie direkt nach /usr/share/nginx/vendor
RUN mkdir -p /usr/share/nginx/vendor \
    && composer install --no-dev --optimize-autoloader --working-dir=/usr/src/app --verbose \
    && ls -l /usr/src/app/vendor || echo "Vendor directory not created!" \
    && mv /usr/src/app/vendor/* /usr/share/nginx/vendor/

WORKDIR /usr/src/app