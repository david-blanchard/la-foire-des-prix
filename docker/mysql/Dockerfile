FROM mysql:8.0

#COPY ./data/aydo_sandbox_2.sql /docker-entrypoint-initdb.d/01_aydo.sql
COPY ./docker/mysql/etc/my.cnf /etc/my.cnf

RUN chown -R mysql:mysql /docker-entrypoint-initdb.d/
