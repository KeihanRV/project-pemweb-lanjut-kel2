#!/bin/bash
set -e

# Wait for MySQL TCP port to accept connections (no credentials needed)
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database at $DB_HOST:${DB_PORT:-3306}..."
    until (echo > /dev/tcp/"$DB_HOST"/"${DB_PORT:-3306}") >/dev/null 2>&1; do
        sleep 2
    done
    echo "Database is ready."
fi

# Generate app key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    php artisan key:generate --force
fi

# Ensure all required Laravel storage subdirectories exist and are writable
mkdir -p storage/framework/views \
         storage/framework/sessions \
         storage/framework/cache/data \
         storage/logs \
         bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Ensure the storage symlink exists (dev: code is volume-mounted so we must run this at runtime)
php artisan storage:link --force 2>/dev/null || true

# Run migrations
php artisan migrate --force

exec "$@"
