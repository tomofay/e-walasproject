FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    nodejs \
    npm \
    git \
    unzip \
    libzip-dev \
    oniguruma-dev \
    libpng-dev \
    libxml2-dev \
    sqlite-dev \
    linux-headers

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_sqlite \
    mbstring \
    zip \
    gd \
    xml

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# 1. Salin seluruh source code terlebih dahulu
COPY . .

# 2. Buat folder cache & storage jika belum ada
RUN mkdir -p bootstrap/cache storage/framework/cache storage/framework/sessions storage/framework/views storage/logs

# 3. Jalankan composer install (sekarang routes/web.php sudah ada)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 4. Build frontend assets
RUN npm install --no-audit --no-fund && npm run build

# 5. Atur permission
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# 6. Bersihkan file/cache tidak terpakai untuk memperkecil ukuran image
RUN rm -rf /var/www/node_modules /var/www/.npm /root/.npm /root/.composer

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]