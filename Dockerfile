# ─────────────────────────────────────────────
# Stage 1: Install PHP dependencies via Composer
# ─────────────────────────────────────────────
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

COPY . .
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

# ─────────────────────────────────────────────
# Stage 2: Build frontend assets (Vite)
# ─────────────────────────────────────────────
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

# ─────────────────────────────────────────────
# Stage 3: Final production image (PHP + Apache)
# ─────────────────────────────────────────────
FROM php:8.2-apache

# Install required PHP extensions and system deps
RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libwebp-dev \
        unzip \
        zip \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo_mysql zip gd \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Point Apache document root to Laravel's public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy application source
COPY . .

# Copy compiled vendor and frontend assets from earlier stages
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

# Bake a stable APP_KEY into the image at build time.
# docker-compose env vars override DB settings at runtime,
# but APP_KEY stays fixed so sessions survive restarts.
RUN cp .env.example .env && php artisan key:generate --force

# Store seed images separately so they survive the storage volume mount.
# On first boot, start-container.sh copies these into the mounted volume.
RUN mkdir -p /docker-seed-images && \
    cp -r storage/app/public/products/. /docker-seed-images/ 2>/dev/null || true

# Ensure required storage directories exist (volume will mount here)
RUN mkdir -p \
    storage/app/public/products \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R ug+rwx storage bootstrap/cache

# Copy startup script
COPY docker/app/start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

EXPOSE 80

ENTRYPOINT ["start-container"]
CMD ["apache2-foreground"]