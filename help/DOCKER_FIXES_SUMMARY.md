# Résumé des Corrections Docker Compose - Services PostgreSQL et PHP

## Date
27 novembre 2025

## Problèmes Identifiés

### 1. Service PostgreSQL
- ❌ Script SQL statique ne gérait pas les variables d'environnement runtime
- ❌ Healthcheck timeout trop court pour macOS (10s)

### 2. Service PHP  
- ❌ Healthcheck trop strict (vérifiait l'existence de données)
- ❌ Healthcheck timeout trop court (10s) et retries insuffisantes (5)
- ❌ Commande `pgrep -x` ne fonctionnait pas sur Alpine Linux
- ❌ Build Vite échouait avec erreur `@rollup/rollup-linux-arm64-musl` manquant
- ❌ Entrypoint essayait de builder Vite (devrait être géré par le service vite dédié)
- ❌ Timeout d'attente DB trop court (30s) pour macOS avec Docker Desktop

## Solutions Appliquées

### PostgreSQL

#### 1. Nouveau script d'initialisation dynamique
**Fichier**: `docker/postgres/init.sh`
- Utilise les variables d'environnement runtime (`$POSTGRES_USER`, `$POSTGRES_DB`)
- Donne tous les privilèges sur le schéma public
- Définit les privilèges par défaut pour les futures tables

#### 2. Dockerfile mis à jour
**Fichier**: `docker/postgres/Dockerfile`
- Copie le script `init.sh` au lieu de créer un SQL statique
- Le script est exécuté avec les bonnes variables d'environnement

#### 3. Healthcheck amélioré
**Fichier**: `compose.yaml` (service pgsql)
```yaml
healthcheck:
  timeout: 30s        # était 10s
  interval: 10s       # était 5s
  retries: 15         # était 10
  start_period: 180s  # était 120s
```

### PHP

#### 1. Healthcheck simplifié et corrigé
**Fichier**: `docker/php/healthcheck.sh`
- ✅ Supprimé `-x` de `pgrep` (ne fonctionne pas sur Alpine)
- ✅ Vérifie seulement PHP-FPM + connectivité DB (pas les données)
- ✅ Plus rapide et plus robuste

#### 2. Healthcheck Docker Compose optimisé
**Fichier**: `compose.yaml` (service php)
```yaml
healthcheck:
  timeout: 30s        # était 10s
  interval: 15s       # était 10s
  retries: 10         # était 5
  start_period: 300s  # était 180s
```

#### 3. Fix Rollup pour ARM64 Alpine
**Fichier**: `docker/php/Dockerfile`
- Ajout de `libstdc++` pour supporter les binaires natifs rollup

**Fichier**: `package.json`
- Ajout de `@rollup/rollup-linux-arm64-musl` dans les dependencies
- Script postinstall pour vérifier le chargement des binaires

#### 4. Entrypoint optimisé
**Fichier**: `docker/php/docker-entrypoint.sh`
- ✅ Timeout d'attente DB augmenté à 120s (60 retries × 2s)
- ✅ Messages de progression tous les 20s
- ✅ Gestion d'erreur améliorée avec flag `DB_READY`
- ✅ Skip du build Vite (géré par service vite dédié)
- ✅ Continue même si la DB n'est pas prête

## Résultats

### Avant
```
pgsql:    Up (healthy)
php:      Up (unhealthy) - timeout après 180s
nginx:    Created (waiting for php)
vite:     Up
```

### Après
```
✅ pgsql:      Up (healthy)
✅ php:        Up (healthy) - démarre en ~30s
✅ nginx:      Up
✅ vite:       Up
✅ memcached:  Up
✅ mailer:     Up (healthy)
```

## Commandes de Test

### Vérifier l'état des services
```bash
docker compose ps
```

### Tester le healthcheck PHP manuellement
```bash
docker compose exec php sh -c "cd /var/www/html && sh ./docker/php/healthcheck.sh"
```

### Vérifier la connectivité DB
```bash
docker compose exec php php bin/console dbal:run-sql "SELECT 1"
```

### Tester l'application web
```bash
curl -I http://localhost:8081
```

## Fichiers Modifiés

1. `docker/postgres/Dockerfile` - Script d'init dynamique
2. `docker/postgres/init.sh` - **NOUVEAU** - Script bash d'initialisation
3. `docker/php/Dockerfile` - Ajout libstdc++
4. `docker/php/healthcheck.sh` - Simplifié et corrigé pgrep
5. `docker/php/docker-entrypoint.sh` - Timeouts et gestion d'erreur
6. `compose.yaml` - Healthchecks optimisés pour macOS
7. `package.json` - Dépendance rollup ARM64

## Optimisations macOS Spécifiques

- Timeouts augmentés (Docker Desktop sur macOS est plus lent)
- Intervals de healthcheck espacés (réduit la charge CPU)
- Start period généreux (permet l'initialisation complète)
- Attente DB avec retry intelligent (gère la lenteur du réseau Docker)

## Notes Importantes

- La table s'appelle `products` (pluriel) pas `product`
- Le service Vite gère le build des assets frontend
- Le service PHP ne build plus Vite au démarrage
- Les fixtures sont chargées automatiquement si la DB est vide
- Les migrations sont appliquées automatiquement au démarrage

## Prochaines Étapes Recommandées

1. Vérifier que l'application fonctionne via http://localhost:8081
2. Tester Vite HMR via http://localhost:5173
3. Vérifier les logs si nécessaire : `docker compose logs -f php`
4. Commit les changements vers git

