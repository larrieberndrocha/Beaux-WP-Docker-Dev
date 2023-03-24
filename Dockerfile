FROM wordpress:php7.4

RUN a2enmod ssl && a2enmod rewrite
RUN mkdir -p /etc/apache2/ssl
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY ./certs/*.pem /etc/apache2/ssl/
COPY ./config/wordpress-php-apache/000-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
EXPOSE 443
