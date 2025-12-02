#!/bin/sh
set -e

# NOTE:
# - During image build we run `yarn install` which installs dependencies into
#   the image's /var/www/html/node_modules. When using a host bind-mount for
#   the project directory (."/:/var/www/html) this directory would be hidden
#   and the installed node_modules lost at container start. To avoid that we
#   mount a named volume on /var/www/html/node_modules in docker-compose so
#   the modules installed in the image remain available at runtime.
#
# - This script runs `yarn build` (which calls the local `vite` binary)
#   and then starts the vite dev server (`yarn dev`). Ensure `yarn install`
#   has run during image build or run `docker compose run --rm vite yarn install`
#   if you rebuild volumes manually.

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
