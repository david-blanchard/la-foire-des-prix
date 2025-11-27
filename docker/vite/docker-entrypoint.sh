#!/bin/sh
set -e

echo "Building Vite assets..."
yarn build

# Sauvegarder le fichier entrypoints.json généré par le build
cp /var/www/html/public/build/.vite/entrypoints.json /tmp/entrypoints.prod.json

echo "Starting Vite dev server..."
yarn dev --host 0.0.0.0 &
VITE_PID=$!

# Attendre que Vite démarre et écrive son entrypoints.json
sleep 2

# Restaurer le fichier entrypoints.json de production
echo "Restoring production entrypoints.json..."
cp /tmp/entrypoints.prod.json /var/www/html/public/build/.vite/entrypoints.json

# Attendre le processus Vite
wait $VITE_PID
