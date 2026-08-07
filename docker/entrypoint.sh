#!/bin/sh

if [ ! -f /var/www/.docker_initialized ]; then
    echo "==> First run: generating app key, running migrations & seeding..."

    if [ -z "$APP_KEY" ]; then
        php artisan key:generate --force
    else
        echo "APP_KEY already set from environment."
    fi

    echo "==> Waiting for database to be ready..."
    until php artisan migrate --force 2>/dev/null; do
        echo "  DB not ready — retrying in 2s..."
        sleep 2
    done

    php artisan db:seed --force

    echo "==> Caching config, routes & views..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    touch /var/www/.docker_initialized
    echo "==> Initialization complete."
fi

echo "==> Starting supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
