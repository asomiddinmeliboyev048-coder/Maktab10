FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libpng-dev libxml2-dev libonig-dev git curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd xml bcmath

RUN a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Har ehtimolga qarshi — eskirgan keshlarni image ichidan butunlay o'chiramiz
RUN rm -f bootstrap/cache/config.php bootstrap/cache/routes-v7.php bootstrap/cache/services.php bootstrap/cache/packages.php

RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Runtime'da $PORT'ni to'g'ri qo'yadigan skript
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]