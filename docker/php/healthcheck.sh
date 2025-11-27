#!/bin/sh
# Healthcheck script optimisé pour macOS
# Vérifie que :
# 1. PHP-FPM est prêt
# 2. La base de données est accessible
# 3. La table product existe et contient des données

set -e

# Vérifier que PHP-FPM écoute sur le socket/port
if ! pgrep -x php-fpm > /dev/null; then
    echo "PHP-FPM is not running"
    exit 1
fi

# Vérifier que la base de données est accessible (avec timeout court)
timeout 5 php bin/console dbal:run-sql "SELECT 1" > /dev/null 2>&1 || {
    echo "Database not accessible"
    exit 1
}

# Vérifier que la table product existe
timeout 5 php bin/console dbal:run-sql "SELECT COUNT(*) FROM product LIMIT 1" > /dev/null 2>&1 || {
    echo "Table product does not exist yet"
    exit 1
}

# Vérifier que la table product contient au moins 1 enregistrement
COUNT=$(timeout 5 php bin/console dbal:run-sql "SELECT COUNT(*) FROM product" 2>/dev/null | grep -E "^\s*[0-9]+\s*$" | tr -d ' ' || echo "0")

if [ -z "$COUNT" ] || [ "$COUNT" -eq 0 ]; then
    echo "Table product is empty"
    exit 1
fi

echo "Healthcheck passed: database ready with $COUNT products"
exit 0
