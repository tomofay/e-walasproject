#!/bin/sh

if [ ! -f /var/www/.docker_initialized ]; then
    echo "==> First run: generating app key, running migrations & seeding..."

    if [ -z "$APP_KEY" ]; then
        php artisan key:generate --force
    else
        echo "APP_KEY already set from environment."
    fi

    php artisan migrate --force
    php artisan db:seed --force

    echo "==> Caching config & views..."
    php artisan config:cache
    php artisan view:cache

    touch /var/www/.docker_initialized
    echo "==> Initialization complete."
fi

echo "==> Starting supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
