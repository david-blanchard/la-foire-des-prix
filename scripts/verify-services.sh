#!/bin/bash

# Script de vérification de la séparation des services
# Usage: ./scripts/verify-services.sh

echo "=========================================="
echo "Vérification de la séparation des services"
echo "=========================================="
echo ""

echo "🐘 Service PHP:"
echo "----------------"
docker compose exec php php --version | head -1
echo ""

echo "📦 Service Vite (Node.js):"
echo "---------------------------"
docker compose exec vite node --version
docker compose exec vite yarn --version
echo ""

echo "🐘 Service PostgreSQL:"
echo "----------------------"
docker compose exec pgsql psql --version
echo ""

echo "🌐 Service Nginx:"
echo "-----------------"
docker compose exec nginx nginx -v 2>&1
echo ""

echo "📊 État des services:"
echo "---------------------"
docker compose ps --format "table {{.Name}}\t{{.Image}}\t{{.Status}}"
echo ""

echo "✅ Vérification terminée"
echo "=========================================="
