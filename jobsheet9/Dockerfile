FROM php:8.2-apache

RUN docker-php-ext-install pdo_pgsql

RUN a2enmod rewrite

COPY . /var/www/html/

RUN echo '#!/bin/sh' > /usr/local/bin/start-apache.sh \
    && echo 'sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf' >> /usr/local/bin/start-apache.sh \
    && echo 'sed -i "s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf' >> /usr/local/bin/start-apache.sh \
    && echo 'exec apache2-foreground' >> /usr/local/bin/start-apache.sh \
    && chmod +x /usr/local/bin/start-apache.sh

CMD ["/usr/local/bin/start-apache.sh"]
