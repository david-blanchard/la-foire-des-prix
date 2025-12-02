FROM postgres:16-alpine

# Les valeurs par défaut - seront écrasées par les variables d'environnement du compose.yaml
ENV POSTGRES_DB=demo
ENV POSTGRES_USER=mrdemo
ENV POSTGRES_PASSWORD=demo

# Fix pour macOS : définir explicitement PGDATA pour éviter les problèmes de permissions
ENV PGDATA=/var/lib/postgresql/data/pgdata

# Créer le script d'initialisation qui utilisera les variables d'environnement réelles
RUN mkdir -p /docker-entrypoint-initdb.d

# Le script sera exécuté avec les variables d'environnement du runtime
COPY docker/postgres/init.sh /docker-entrypoint-initdb.d/01_init.sh
RUN chmod +x /docker-entrypoint-initdb.d/01_init.sh && \
    chown -R postgres:postgres /docker-entrypoint-initdb.d/

# Créer le répertoire pgdata avec les bonnes permissions
RUN mkdir -p /var/lib/postgresql/data/pgdata && \
    chown -R postgres:postgres /var/lib/postgresql/data && \
    chmod 700 /var/lib/postgresql/data/pgdata
