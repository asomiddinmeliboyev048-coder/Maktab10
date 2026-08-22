FROM php:7.4-apache

# Kerakli tizim kutubxonalarini o'rnatish
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libpng-dev libxml2-dev libonig-dev git curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd xml bcmath

# Apache mod_rewrite (Laravel routing uchun shart)
RUN a2enmod rewrite

# Composer o'rnatish
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Apache DocumentRoot'ni public/ papkaga yo'naltirish
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf

RUN composer install --no-dev --optimize-autoloader

# Storage va cache papkalariga yozish huquqini berish
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Render beradigan PORT ni Apache tinglashi uchun sozlash
RUN sed -i "s/80/\${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]