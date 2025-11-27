#!/bin/bash
set -e

echo "Starting PHP container initialization..."

# Ensure proper ownership of the working directory
chown -R david:david /var/www/html 2>/dev/null || echo "Could not change ownership, continuing..."

# Run yarn install if package.json exists and node_modules is empty or doesn't exist
if [ -f "package.json" ]; then
    if [ ! -d "node_modules" ] || [ -z "$(ls -A node_modules 2>/dev/null)" ]; then
        echo "Installing yarn dependencies..."
        su -s /bin/bash david -c "cd /var/www/html && yarn install --mode=skip-build" || echo "Warning: yarn install failed, continuing anyway..."
    else
        echo "Node modules already installed, skipping yarn install..."
    fi
fi

# Install/update composer dependencies if needed
if [ -f "composer.json" ]; then
    if [ ! -d "vendor" ] || [ -z "$(ls -A vendor 2>/dev/null)" ]; then
        echo "Installing composer dependencies..."
        su -s /bin/bash david -c "cd /var/www/html && composer install --no-interaction --optimize-autoloader" || echo "Warning: composer install failed, continuing anyway..."
    else
        echo "Composer dependencies already installed..."
    fi

    # Run migrations
    echo "Running database migrations..."
    su -s /bin/bash david -c "cd /var/www/html && composer refresh" || echo "Warning: composer refresh failed, continuing anyway..."    
fi

# Build Symfony assets
echo "Building Symfony assets..."
if [ -f "bin/console" ]; then
    echo "Installing Symfony assets..."
    su -s /bin/bash david -c "cd /var/www/html && php bin/console assets:install --symlink --relative" || echo "Warning: assets:install failed, continuing anyway..."
    
    echo "Building Tailwind CSS..."
    su -s /bin/bash david -c "cd /var/www/html && php bin/console tailwind:build --minify" || echo "Warning: tailwind:build failed, continuing anyway..."
fi

# Build Vite assets (production build)
if [ -f "vite.config.js" ]; then
    echo "Building Vite assets..."
    su -s /bin/bash david -c "cd /var/www/html && yarn build" || echo "Warning: vite build failed, continuing anyway..."
fi

echo "Starting PHP-FPM..."

# Execute the main command (php-fpm or whatever is passed)
exec "$@"
