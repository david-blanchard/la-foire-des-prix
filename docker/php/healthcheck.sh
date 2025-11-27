#!/bin/sh
# Healthcheck script pour vérifier que :
# 1. Les migrations Doctrine sont passées
# 2. La table products existe et contient des données

set -e

# Vérifier que la base de données est accessible
php bin/console dbal:run-sql "SELECT 1" > /dev/null 2>&1 || exit 1

# Vérifier que la table products existe
php bin/console dbal:run-sql "SELECT COUNT(*) FROM products LIMIT 1" > /dev/null 2>&1 || exit 1

# Vérifier que la table products contient au moins 1 enregistrement
COUNT=$(php bin/console dbal:run-sql "SELECT COUNT(*) FROM products" 2>/dev/null | grep -E "^\s+[0-9]+\s*$" | tr -d ' ')

if [ -z "$COUNT" ] || [ "$COUNT" -eq 0 ]; then
    echo "Table products is empty"
    exit 1
fi

echo "Healthcheck passed: database ready with $COUNT products"
exit 0
