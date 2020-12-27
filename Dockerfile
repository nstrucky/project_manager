FROM php:7.1-apache

ENV APACHE_DOCUMENT_ROOT /app/public

COPY . /app

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update \
 && apt-get install -y git zlib1g-dev vim \
 && docker-php-ext-install pdo pdo_mysql zip \
 && a2enmod rewrite \
 && a2enmod ssl \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 80
EXPOSE 443