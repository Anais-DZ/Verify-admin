# Utilise l'image officielle PHP avec Apache
FROM php:7.4-apache

# Copie ton code source dans le conteneur
COPY . /var/www/html/

# Active les modules Apache nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Expose le port 80 pour que l'application soit accessible via HTTP
EXPOSE 80
