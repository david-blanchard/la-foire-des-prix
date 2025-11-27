FROM postgres:16-alpine

# Les valeurs par défaut - seront écrasées par les variables d'environnement du compose.yaml
ENV POSTGRES_DB=demo
ENV POSTGRES_USER=mrdemo
ENV POSTGRES_PASSWORD=demo

# PostgreSQL crée automatiquement la base de données et l'utilisateur via les variables d'environnement
# On ajoute seulement les privilèges supplémentaires si nécessaire
RUN echo "GRANT ALL PRIVILEGES ON SCHEMA public TO ${POSTGRES_USER};" >> /docker-entrypoint-initdb.d/01_grant_privileges.sql

RUN chown -R postgres:postgres /docker-entrypoint-initdb.d/
