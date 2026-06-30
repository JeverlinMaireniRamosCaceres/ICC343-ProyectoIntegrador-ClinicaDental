#!/bin/sh
set -e

echo "→ Sincronizando public..."
cp -r /var/www/html/public-source/. /var/www/html/public/

echo "→ Optimizando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "→ Corriendo migraciones..."
php artisan migrate --force

echo "→ Iniciando PHP-FPM..."
exec "$@"
