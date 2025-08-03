#!/usr/bin/env bash

function accept_connections() {
  return "$(pg_isready -U root -d postgres | grep 'accepting connections' )"
}

function is_ready() {
    IS_READY=$(accept_connections);
    while [ -z "$IS_READY" ];
    do
        IS_READY=$(accept_connections)
    done
}

is_ready;

pg_isready -U root -d postgres;

echo "psql -U root -d postgres -c 'create database $POSTGRES_DB';"
psql -U root -d postgres -c "create database $POSTGRES_DB";

echo "psql -U root -d postgres -c \"create user $POSTGRES_USER with encrypted password '$POSTGRES_PASSWORD'\";"
psql -U root -d postgres -c "create user $POSTGRES_USER with encrypted password '$POSTGRES_PASSWORD'";

echo "psql -U root -d postgres -c 'grant all privileges on database $POSTGRES_DB to $POSTGRES_USER';"
psql -U root -d postgres -c "grant all privileges on database $POSTGRES_DB to $POSTGRES_USER";
