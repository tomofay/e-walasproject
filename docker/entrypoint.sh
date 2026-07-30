#!/bin/sh
set -e

if [ ! -f /var/www/.docker_initialized ]; then
    echo "==> First run: running migrations & seeding..."
    php artisan migrate --force
    php artisan db:seed --force
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    touch /var/www/.docker_initialized
fi

echo "==> Starting supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
