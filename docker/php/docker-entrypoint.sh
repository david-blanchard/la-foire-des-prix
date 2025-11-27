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

    # Run migrations intelligently - macOS optimized
    echo "Running database migrations..."
    
    # Wait for database to be ready
    echo "Waiting for database to be ready..."
    MAX_RETRIES=30
    RETRY_COUNT=0
    until su -s /bin/bash david -c "cd /var/www/html && php bin/console dbal:run-sql 'SELECT 1' --no-interaction" > /dev/null 2>&1; do
        RETRY_COUNT=$((RETRY_COUNT + 1))
        if [ $RETRY_COUNT -ge $MAX_RETRIES ]; then
            echo "Database not ready after $MAX_RETRIES attempts, continuing anyway..."
            break
        fi
        echo "Waiting for database... ($RETRY_COUNT/$MAX_RETRIES)"
        sleep 1
    done
    
    # Check if database exists and has tables
    DB_EXISTS=$(su -s /bin/bash david -c "cd /var/www/html && php bin/console doctrine:query:sql 'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = current_database()' --no-interaction 2>/dev/null | tail -1" || echo "0")
    
    if [ "$DB_EXISTS" = "0" ] || [ -z "$DB_EXISTS" ]; then
        echo "Database empty, running full setup..."
        su -s /bin/bash david -c "cd /var/www/html && composer refresh" || echo "Warning: composer refresh failed, continuing anyway..."
    else
        echo "Database exists with $DB_EXISTS tables, running migrations only..."
        su -s /bin/bash david -c "cd /var/www/html && php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration" || echo "Warning: migrations failed, continuing anyway..."
        
        # Load fixtures only if product table is empty
        PRODUCT_COUNT=$(su -s /bin/bash david -c "cd /var/www/html && php bin/console dbal:run-sql 'SELECT COUNT(*) FROM product' --no-interaction 2>/dev/null | tail -1" || echo "0")
        if [ "$PRODUCT_COUNT" = "0" ] || [ -z "$PRODUCT_COUNT" ]; then
            echo "Loading fixtures (product table is empty)..."
            su -s /bin/bash david -c "cd /var/www/html && php bin/console doctrine:fixtures:load --no-interaction --append" || echo "Warning: fixtures loading failed, continuing anyway..."
        else
            echo "Fixtures already loaded (product count: $PRODUCT_COUNT), skipping..."
        fi
    fi
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
