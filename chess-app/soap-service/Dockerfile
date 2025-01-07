FROM php:8.0-apache

RUN apt-get update && apt-get install -y \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql soap

COPY soap-server.php /var/www/html/