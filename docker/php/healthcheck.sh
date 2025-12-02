#!/bin/sh
# Healthcheck script optimisé pour macOS
# Vérifie que :
# 1. PHP-FPM est prêt
# 2. La base de données est accessible
# 3. Les migrations sont jouées et les données sont chargées

set -e

# Vérifier que PHP-FPM écoute sur le socket/port
if ! pgrep php-fpm > /dev/null; then
    echo "PHP-FPM is not running"
    exit 1
fi

# Vérifier que le fichier flag d'initialisation existe
if [ ! -f /tmp/.db-ready ]; then
    echo "Database not fully initialized yet (waiting for migrations and fixtures)"
    exit 1
fi

# Vérifier que la base de données est accessible
if ! php bin/console dbal:run-sql "SELECT 1" > /dev/null 2>&1; then
    echo "Database not accessible"
    exit 1
fi

# Vérifier que la table products existe et contient des données
PRODUCT_COUNT=$(php bin/console dbal:run-sql "SELECT COUNT(*) FROM products" 2>/dev/null | grep -E "^\s*[0-9]+\s*$" | tr -d ' ' || echo "0")

if [ -z "$PRODUCT_COUNT" ] || [ "$PRODUCT_COUNT" -eq 0 ]; then
    echo "Table products is empty - fixtures not loaded"
    exit 1
fi

echo "Healthcheck passed: PHP-FPM running, database ready with $PRODUCT_COUNT products"
exit 0
