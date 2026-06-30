#!/bin/sh
set -e

echo "→ Optimizando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "→ Corriendo migraciones..."
php artisan migrate --force

echo "→ Iniciando PHP-FPM..."
exec "$@"
