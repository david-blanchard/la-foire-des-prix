#!/bin/bash

# Script de diagnostic pour les services Docker
# Usage: ./scripts/check-services.sh

echo "=========================================="
echo "Diagnostic des services Docker Compose"
echo "=========================================="
echo ""

# Vérifier si Docker est disponible
if ! command -v docker &> /dev/null; then
    echo "❌ Docker n'est pas installé ou n'est pas accessible"
    exit 1
fi

echo "✅ Docker est disponible"
echo ""

# Vérifier l'état des services
echo "État des services:"
echo "------------------"
docker compose ps
echo ""

# Vérifier les logs Nginx
echo "Logs Nginx (dernières 20 lignes):"
echo "-----------------------------------"
docker compose logs --tail=20 nginx
echo ""

# Vérifier les logs PHP
echo "Logs PHP (dernières 20 lignes):"
echo "---------------------------------"
docker compose logs --tail=20 php
echo ""

# Vérifier les logs PostgreSQL
echo "Logs PostgreSQL (dernières 20 lignes):"
echo "----------------------------------------"
docker compose logs --tail=20 pgsql
echo ""

# Tester la configuration Nginx
echo "Test de la configuration Nginx:"
echo "--------------------------------"
docker compose exec nginx nginx -t 2>&1 || echo "❌ Impossible de tester la configuration Nginx"
echo ""

# Vérifier les ports en écoute
echo "Ports exposés:"
echo "---------------"
docker compose ps --format "table {{.Name}}\t{{.Ports}}"
echo ""

echo "=========================================="
echo "Fin du diagnostic"
echo "=========================================="
