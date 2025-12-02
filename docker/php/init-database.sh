#!/bin/bash
# Script d'initialisation de la base de données
# Exécuté après le démarrage de PHP-FPM

set -e

echo "🔄 Starting database initialization script..."

# Attendre que PostgreSQL soit vraiment prêt
echo "⏳ Waiting for PostgreSQL to be fully ready..."
MAX_RETRIES=120  # 240 seconds (4 minutes)
RETRY_COUNT=0

until php bin/console dbal:run-sql "SELECT 1" --no-interaction > /dev/null 2>&1; do
    RETRY_COUNT=$((RETRY_COUNT + 1))
    if [ $RETRY_COUNT -ge $MAX_RETRIES ]; then
        echo "❌ Database not ready after $MAX_RETRIES attempts ($(($MAX_RETRIES * 2))s)"
        echo "Container healthcheck will continue to fail"
        exit 1
    fi
    if [ $((RETRY_COUNT % 15)) -eq 0 ]; then
        echo "⏳ Still waiting for database... ($RETRY_COUNT/$MAX_RETRIES) - $(($RETRY_COUNT * 2))s elapsed"
    fi
    sleep 2
done

echo "✅ Database is accessible!"

# Ensure database exists
echo "📦 Ensuring database exists..."
php bin/console doctrine:database:create --if-not-exists || echo "Database already exists"

# Check if database already has data (products table exists and has data)
# First check if the table exists using information_schema to avoid errors
echo "📊 Checking if products table exists..."
TABLE_EXISTS=$(php bin/console dbal:run-sql "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'public' AND table_name = 'products'" --no-interaction 2>/dev/null | grep -oE "[0-9]+" | head -1 || echo "0")

if [ "$TABLE_EXISTS" = "0" ]; then
    echo "📊 Products table doesn't exist yet - proceeding with full initialization..."
    PRODUCT_COUNT=0
else
    # Table exists, now get the count
    echo "📊 Products table exists, checking row count..."
    PRODUCT_COUNT=$(php bin/console dbal:run-sql 'SELECT COUNT(*) FROM products' --no-interaction 2>/dev/null | grep -oE "[0-9]+" | head -1 || echo "0")
    echo "📊 Current product count: $PRODUCT_COUNT"
fi

# If count is greater than 0, database is already initialized
if [ ! -z "$PRODUCT_COUNT" ] && [ "$PRODUCT_COUNT" -gt 0 ] 2>/dev/null; then
    echo "✅ Database already initialized with $PRODUCT_COUNT products"
    echo "⏭️  Skipping migrations and fixtures (database already has data)"

    # Create flag file immediately since database is ready
    echo "Database initialization complete" > /tmp/.db-ready
    echo "✅ Database is ready!"
    exit 0
fi

# If we reach here, database is empty - proceed with initialization
echo "📊 Database is empty (count: $PRODUCT_COUNT) - proceeding with full initialization..."

# Check if tables exist
TABLE_COUNT=$(php bin/console doctrine:query:sql 'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = current_database()' --no-interaction 2>/dev/null | tail -1 || echo "0")
echo "📊 Found $TABLE_COUNT tables in database"

# Run migrations
echo "🔄 Running database migrations..."
if php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration; then
    echo "✅ Migrations completed successfully"
else
    echo "❌ ERROR: Migrations failed!"
    exit 1
fi

# Load fixtures
echo "🌱 Loading fixtures..."
if php bin/console doctrine:fixtures:load --no-interaction; then
    echo "✅ Fixtures loaded successfully"
    # Verify fixtures were actually loaded
    NEW_PRODUCT_COUNT=$(php bin/console dbal:run-sql 'SELECT COUNT(*) FROM products' --no-interaction 2>/dev/null | tail -1 || echo "0")
    echo "📊 After loading fixtures: $NEW_PRODUCT_COUNT products"
else
    echo "❌ ERROR: Fixtures loading failed!"
    exit 1
fi

# Create flag file to indicate database is ready
echo "Database initialization complete" > /tmp/.db-ready
echo "✅ Database is fully initialized and ready!"

exit 0

