#!/bin/sh
set -eu

if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY must be configured before starting the production container." >&2
    exit 1
fi

echo "==> Ensuring public storage link..."
mkdir -p /var/www/storage/app/public
if [ -L /var/www/public/storage ]; then
    link_target=$(readlink /var/www/public/storage)
    if [ "$link_target" != "/var/www/storage/app/public" ]; then
        rm -f /var/www/public/storage
    fi
fi
if [ ! -e /var/www/public/storage ]; then
    ln -s /var/www/storage/app/public /var/www/public/storage
elif [ ! -L /var/www/public/storage ]; then
    echo "/var/www/public/storage exists but is not a symbolic link." >&2
    exit 1
fi

echo "==> Running pending database migrations..."
attempt=0
until php artisan migrate --force; do
    attempt=$((attempt + 1))
    if [ "$attempt" -ge 30 ]; then
        echo "Database migrations failed after 30 attempts." >&2
        exit 1
    fi
    echo "Database unavailable or migration failed — retrying in 2s..."
    sleep 2
done

echo "==> Caching config, routes & views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
