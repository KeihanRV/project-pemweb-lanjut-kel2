# ── Stage 1: Node — compile frontend assets ──────────────────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package*.json ./
RUN npm ci --ignore-scripts

COPY . .
RUN npm run build

# ── Stage 2: Base PHP-FPM image ───────────────────────────────────────────────
FROM php:8.3-fpm-alpine AS base

WORKDIR /var/www/html

# System deps
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    sqlite-dev \
    icu-dev \
    mariadb-client \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_sqlite \
        gd \
        zip \
        intl \
        bcmath \
        opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# ── Stage 3: Development ──────────────────────────────────────────────────────
FROM base AS development

ENV APP_ENV=local \
    APP_DEBUG=true

# Install composer deps (vendor will be overridden by volume mount in dev,
# but having it here speeds up cold starts when vendor isn't mounted)
COPY composer*.json ./
RUN composer install --no-scripts --no-interaction

COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]

# ── Stage 4: Production ───────────────────────────────────────────────────────
FROM base AS production

ENV APP_ENV=production \
    APP_DEBUG=false

COPY composer*.json ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

COPY . .
COPY --from=node-builder /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache \
    && php artisan storage:link \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
