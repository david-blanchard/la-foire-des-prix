#!/bin/bash
set -e

# Ce script s'exécute avec les variables d'environnement du runtime
# PostgreSQL crée automatiquement la base et l'utilisateur, on donne juste les privilèges

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    -- Donner tous les privilèges sur le schéma public
    GRANT ALL PRIVILEGES ON SCHEMA public TO $POSTGRES_USER;

    -- Donner les privilèges sur toutes les tables (pour celles qui existent déjà)
    GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO $POSTGRES_USER;
    GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO $POSTGRES_USER;

    -- Définir les privilèges par défaut pour les futures tables
    ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO $POSTGRES_USER;
    ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO $POSTGRES_USER;
EOSQL

echo "PostgreSQL initialization completed for database: $POSTGRES_DB"

