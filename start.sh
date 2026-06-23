#!/usr/bin/env bash
set -e

cd /var/www

export PORT="${PORT:-8080}"

if [ ! -f public/build/manifest.json ]; then
    echo "Vite manifest not found at public/build/manifest.json"
    exit 1
fi

php artisan optimize:clear
php artisan storage:link || true
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan serve --host=0.0.0.0 --port="${PORT}"
