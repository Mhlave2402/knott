#!/bin/bash
cd /home/forge/knott.co.za

# Enable maintenance mode
php artisan down --message="Updating Knott - We'll be back shortly!" --retry=60

# Pull latest changes
git pull origin main

# Install/Update dependencies
composer install --no-dev --optimize-autoloader

# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Run database migrations
php artisan migrate --force

# Cache everything for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize for production
php artisan optimize

# Restart queue workers
php artisan queue:restart

# Disable maintenance mode
php artisan up

# Send deployment notification
php artisan notify:deployment-complete