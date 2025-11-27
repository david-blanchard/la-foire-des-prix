FROM postgres:16-alpine

# Les valeurs par défaut - seront écrasées par les variables d'environnement du compose.yaml
ENV POSTGRES_DB=demo
ENV POSTGRES_USER=mrdemo
ENV POSTGRES_PASSWORD=demo

# Fix pour macOS : définir explicitement PGDATA pour éviter les problèmes de permissions
ENV PGDATA=/var/lib/postgresql/data/pgdata

# PostgreSQL crée automatiquement la base de données et l'utilisateur via les variables d'environnement
# On ajoute seulement les privilèges supplémentaires si nécessaire
RUN mkdir -p /docker-entrypoint-initdb.d && \
    echo "GRANT ALL PRIVILEGES ON SCHEMA public TO ${POSTGRES_USER};" > /docker-entrypoint-initdb.d/01_grant_privileges.sql && \
    chown -R postgres:postgres /docker-entrypoint-initdb.d/

# Créer le répertoire pgdata avec les bonnes permissions
RUN mkdir -p /var/lib/postgresql/data/pgdata && \
    chown -R postgres:postgres /var/lib/postgresql/data && \
    chmod 700 /var/lib/postgresql/data/pgdata
