#!/bin/sh
set -e

# Render bergan PORT ni Apache konfiguratsiyasiga runtime'da qo'yamiz
if [ -n "$PORT" ]; then
    sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf
fi

# Har ishga tushishda eskirgan keshlarni tozalab, keyin qayta yaratamiz
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache

php artisan migrate --force

exec apache2-foreground
