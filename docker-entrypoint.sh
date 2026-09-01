#!/bin/sh
set -e

if [ -n "$PORT" ]; then
    sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf || true
fi

php artisan config:clear
php artisan cache:clear
php artisan route:clear || true
php artisan view:clear
php artisan storage:link || true

php artisan config:cache
php artisan route:clear || true
php artisan migrate --force
php artisan db:seed --force

exec apache2-foreground