#!/bin/sh
set -e

# Ensure permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# If SQLite is selected, ensure Laravel can create and write the database file.
if [ "$DB_CONNECTION" = "sqlite" ]; then
    mkdir -p /var/www/html/database
    touch /var/www/html/database/database.sqlite
    chown -R www-data:www-data /var/www/html/database
fi

# Run migrations and seed data. Do not hide an error: Render must report it
# instead of starting an application that will return a generic 500 response.
php artisan migrate --force --seed --no-interaction

# Cache configurations for speed in production
php artisan config:cache
php artisan view:cache

exec "$@"
