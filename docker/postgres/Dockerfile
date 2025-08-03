FROM postgres:16-alpine

ENV POSTGRES_DB=demo
ENV POSTGRES_USER=mrdemo
ENV POSTGRES_PASSWORD=demo

#COPY docker/postgres/init.sql /docker-entrypoint-initdb.d/init.sql

RUN echo "create database $POSTGRES_DB;" >> /docker-entrypoint-initdb.d/01_init_db.sql \
    && echo "create user $POSTGRES_USER with encrypted password '$POSTGRES_PASSWORD';" >> /docker-entrypoint-initdb.d/02_init_user.sql \
    && echo "grant all privileges on database $POSTGRES_DB to $POSTGRES_USER;" >> /docker-entrypoint-initdb.d/02_init_user.sql \
    && echo "grant all privileges on schema public to $POSTGRES_USER;" >> /docker-entrypoint-initdb.d/02_init_user.sql

RUN chown -R postgres:postgres /docker-entrypoint-initdb.d/

COPY docker/postgres/init.sh /tmp/init.sh
RUN chmod 777 /tmp/init.sh
