#!/bin/sh
set -e

# Ensure permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# If SQLite is selected and file doesn't exist, create it
if [ "$DB_CONNECTION" = "sqlite" ] && [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
fi

# Run migrations and seeder automatically
php artisan migrate --force --seed || true

# Cache configurations for speed in production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"