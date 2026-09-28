#!/bin/sh
set -e

cd /var/www/html

# Copy .env.example to .env if .env doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
fi

# Ensure all needed storage and database directories exist
mkdir -p database \
         storage/app/public \
         storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         bootstrap/cache

# Create SQLite database file if it doesn't exist
touch database/database.sqlite

# Fix permissions for Apache www-data user
chown -R www-data:www-data storage bootstrap/cache database public .env
chmod -R 775 storage bootstrap/cache database
chmod -R 755 public
chmod 664 database/database.sqlite .env

# Generate APP_KEY if not already set
if ! grep -q "^APP_KEY=base64:" .env && [ -z "$APP_KEY" ]; then
    echo "Generating Application Key..."
    php artisan key:generate --force
fi

# Run database migrations and seeders
echo "Running migrations and database seeders..."
php artisan migrate --force --seed || true

# Clear any cached config so environment variables are respected
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Application setup complete. Starting Apache..."

exec "$@"