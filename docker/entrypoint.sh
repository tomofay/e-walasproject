#!/bin/sh

if [ ! -f /var/www/.docker_initialized ]; then
    echo "==> First run: running migrations & seeding..."
    php artisan migrate --force
    php artisan db:seed --force

    echo "==> Caching config & views..."
    php artisan config:cache

    # route:cache is skipped — some dev routes have name collisions
    # that are tolerated at runtime but fail during serialization.
    # php artisan route:cache

    php artisan view:cache
    touch /var/www/.docker_initialized
    echo "==> Initialization complete."
fi

echo "==> Starting supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
