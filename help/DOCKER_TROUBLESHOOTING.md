# Guide de dépannage Docker

## Problèmes courants et solutions

### 1. Service Nginx ne démarre pas

#### Vérifications à effectuer :

**a) Vérifier l'état des services :**
```bash
docker compose ps
```

**b) Consulter les logs Nginx :**
```bash
docker compose logs nginx
docker compose logs --tail=50 nginx  # Dernières 50 lignes
docker compose logs -f nginx          # Mode suivi en temps réel
```

**c) Tester la configuration Nginx :**
```bash
docker compose exec nginx nginx -t
```

**d) Redémarrer le service :**
```bash
docker compose restart nginx
```

**e) Reconstruire et redémarrer tous les services :**
```bash
docker compose down
docker compose up -d --build
```

#### Erreurs fréquentes :

1. **Port déjà utilisé** : Le port 8081 est peut-être déjà utilisé
   ```bash
   # Vérifier les ports en écoute
   lsof -i :8081
   # ou
   netstat -tulpn | grep 8081
   ```

2. **Fichier de configuration invalide** : Syntaxe incorrecte dans `docker/nginx/default.conf`
   ```bash
   # Valider la syntaxe
   docker compose exec nginx nginx -t
   ```

3. **Service PHP non disponible** : Nginx dépend de PHP-FPM
   ```bash
   docker compose logs php
   docker compose restart php
   ```

4. **Volumes mal montés** : Vérifier que les chemins existent
   ```bash
   ls -la docker/nginx/default.conf
   ls -la public/
   ```

### 2. Service PostgreSQL ne démarre pas

```bash
# Vérifier les logs
docker compose logs pgsql

# Vérifier le healthcheck
docker compose ps pgsql

# Réinitialiser les données (⚠️ ATTENTION : supprime les données)
docker compose down -v
docker compose up -d
```

### 3. Service PHP ne démarre pas

```bash
# Vérifier les logs
docker compose logs php

# Reconstruire l'image
docker compose build --no-cache php
docker compose up -d php
```

## Script de diagnostic

Un script de diagnostic automatique est disponible :

```bash
./scripts/check-services.sh
```

Ce script vérifie :
- L'état de tous les services
- Les logs récents
- La configuration Nginx
- Les ports exposés

## Commandes utiles

### Démarrer les services
```bash
docker compose up -d
```

### Arrêter les services
```bash
docker compose down
```

### Voir les logs de tous les services
```bash
docker compose logs -f
```

### Reconstruire un service spécifique
```bash
docker compose build nginx
docker compose up -d nginx
```

### Accéder au shell d'un conteneur
```bash
docker compose exec nginx sh
docker compose exec php bash
docker compose exec pgsql psql -U mrdemo -d lafoire
```

### Nettoyer complètement
```bash
# Arrêter et supprimer tous les conteneurs, réseaux et volumes
docker compose down -v

# Supprimer les images inutilisées
docker image prune -a
```

## URLs des services

- **Application** : http://localhost:8081
- **API Platform** : http://localhost:8081/api
- **GraphQL** : http://localhost:8081/api/graphql
- **Mailpit** : http://localhost:8027
- **Vite (dev server)** : http://localhost:5173

## Problème résolu

**⚠️ Important** : Le fichier `compose.ovverride.yaml` avait une faute de frappe (deux "v"). Il a été renommé en `compose.override.yaml`. Docker Compose reconnaît automatiquement ce fichier et le fusionne avec `compose.yaml`.

## Variables d'environnement

Les variables sont définies dans le fichier `.env` :
- `POSTGRES_DB=lafoire`
- `POSTGRES_USER=mrdemo`
- `POSTGRES_PASSWORD=demo`
- `POSTGRES_HOST=pgsql`
- `POSTGRES_PORT=5432`

Pour modifier ces valeurs, éditez le fichier `.env` et redémarrez les services :
```bash
docker compose down
docker compose up -d
```
