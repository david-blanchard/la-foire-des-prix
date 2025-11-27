#!/bin/sh
# Healthcheck script pour vérifier que :
# 1. Les migrations Doctrine sont passées
# 2. La table product existe et contient des données

set -e

# Vérifier que la base de données est accessible
php bin/console dbal:run-sql "SELECT 1" > /dev/null 2>&1 || exit 1

# Vérifier que la table product existe
php bin/console dbal:run-sql "SELECT COUNT(*) FROM product LIMIT 1" > /dev/null 2>&1 || exit 1

# Vérifier que la table product contient au moins 1 enregistrement
COUNT=$(php bin/console dbal:run-sql "SELECT COUNT(*) FROM product" --quiet 2>/dev/null | tail -n 1 | tr -d ' ')

if [ -z "$COUNT" ] || [ "$COUNT" -eq 0 ]; then
    echo "Table product is empty"
    exit 1
fi

echo "Healthcheck passed: database ready with $COUNT products"
exit 0
