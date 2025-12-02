# 🚀 Guide de Démarrage Rapide - La Foire des Prix

## ✅ Prérequis

- Docker Desktop installé et en cours d'exécution
- Ports disponibles : 5173, 5432, 8027, 8081

## 🎯 Démarrage Complet

### Option 1 : Démarrage Normal (avec données existantes)

```bash
docker compose up -d
```

**Temps:** ~20 secondes  
**Résultat:** Tous les services démarrent avec les données existantes

### Option 2 : Réinitialisation Complète (fresh install)

```bash
# Arrêter et supprimer tout
docker compose down -v

# Reconstruire les images
docker compose build

# Démarrer
docker compose up -d
```

**Temps:** ~75 secondes  
**Résultat:** Base de données vierge → migrations → fixtures → tous les services healthy

## 📊 Vérifier l'État

```bash
# Voir l'état de tous les services
docker compose ps

# Suivre les logs PHP (initialisation DB)
docker compose logs -f php
```

**Services attendus :**

- ✅ `pgsql` - healthy
- ✅ `php` - healthy (après ~60s lors du premier démarrage)
- ✅ `nginx` - up
- ✅ `vite` - up
- ✅ `memcached` - up
- ✅ `mailer` - healthy

## 🌐 Accès aux Services

| Service | URL | Description |
|---------|-----|-------------|
| **Application Web** | http://localhost:8081 | Site principal |
| **Vite HMR** | http://localhost:5173 | Hot Module Reload |
| **Mailpit** | http://localhost:8027 | Interface email de dev |
| **PostgreSQL** | localhost:5432 | Base de données |

## 🔍 Diagnostic

### Le service PHP est "unhealthy" ?

C'est normal pendant les 60 premières secondes ! Le script d'initialisation est en cours.

**Suivre la progression :**

```bash
docker compose logs -f php | grep -E "🔄|✅|📊"
```

**Messages attendus :**
```
🔄 Starting database initialization script...
⏳ Waiting for PostgreSQL to be fully ready...
✅ Database is accessible!
📦 Ensuring database exists...
🔄 Running database migrations...
✅ Migrations completed successfully
📊 Found 0 products in database
🌱 Loading fixtures...
✅ Fixtures loaded successfully
📊 After loading fixtures: 3 products
✅ Database is fully initialized and ready!
```

### Vérifier le healthcheck

```bash
docker compose exec php sh -c "cd /var/www/html && sh ./docker/php/healthcheck.sh"
```

**Résultat attendu :**
```
Healthcheck passed: PHP-FPM running, database ready with 3 products
```

### Tester la connexion DB

```bash
docker compose exec php php bin/console dbal:run-sql "SELECT 1"
```

### Compter les produits

```bash
docker compose exec php php bin/console dbal:run-sql "SELECT COUNT(*) FROM products"
```

## 🛠️ Commandes Utiles

### Arrêter les services

```bash
docker compose down
```

### Redémarrer un service spécifique

```bash
docker compose restart php
```

### Voir les logs d'un service

```bash
docker compose logs -f php
docker compose logs -f pgsql
docker compose logs -f nginx
```

### Exécuter des commandes dans le container PHP

```bash
# Ouvrir un shell
docker compose exec php bash

# Exécuter une commande Symfony
docker compose exec php php bin/console cache:clear

# Exécuter les tests
docker compose exec php php bin/phpunit
```

### Reconstruire une image

```bash
docker compose build php
docker compose build pgsql
```

## ⚠️ Problèmes Courants

### "Database not ready" pendant 2-3 minutes

**Normal sur macOS !** PostgreSQL prend du temps à s'initialiser complètement.  
Le script attend jusqu'à 4 minutes. Soyez patient lors du premier démarrage.

### "Port already in use"

```bash
# Vérifier quel processus utilise le port
lsof -i :8081
lsof -i :5432

# Tuer le processus ou changer le port dans compose.yaml
```

### Les fixtures ne se chargent pas

```bash
# Vérifier les logs
docker compose logs php | grep fixtures

# Charger manuellement
docker compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

### Le healthcheck ne passe jamais

```bash
# Vérifier le fichier flag
docker compose exec php ls -la /tmp/.db-ready

# Si absent, relancer le script d'init
docker compose exec php bash /usr/local/bin/init-database.sh
```

## 🔄 Réinitialiser Complètement

Si quelque chose ne va pas, réinitialisez tout :

```bash
# Arrêter et supprimer TOUT (volumes, réseaux, containers)
docker compose down -v

# Optionnel : supprimer les images
docker compose down -v --rmi local

# Nettoyer le cache Docker (optionnel)
docker system prune -a

# Redémarrer depuis zéro
docker compose build
docker compose up -d
```

## 📱 Accès Rapide

### Se connecter à la base de données

```bash
docker compose exec pgsql psql -U mrdemo -d lafoire
```

### Vider le cache Symfony

```bash
docker compose exec php php bin/console cache:clear
```

### Créer une migration

```bash
docker compose exec php php bin/console make:migration
```

### Jouer les migrations

```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

## 📈 Timeline de Démarrage (Premier Lancement)

```
T+0s    : docker compose up -d
T+6s    : PostgreSQL healthy ✅
T+6s    : PHP-FPM démarre ✅
T+10s   : Script init-database.sh démarre en arrière-plan
T+15s   : DB accessible depuis PHP
T+16s   : Migrations exécutées
T+45s   : Fixtures chargées
T+45s   : Flag /tmp/.db-ready créé
T+60s   : Healthcheck PHP passe ✅
T+60s   : Nginx démarre ✅
T+75s   : Tous les services sont healthy ✅
```

## 🎓 Références

- Documentation complète : `DOCKER_REPAIR_FINAL.md`
- Dépannage Docker : `DOCKER_TROUBLESHOOTING.md`
- Configuration : `compose.yaml`

## ✅ Checklist de Démarrage Réussi

- [ ] `docker compose ps` montre tous les services "up"
- [ ] `pgsql` est "healthy"
- [ ] `php` est "healthy" (après ~60s)
- [ ] `mailer` est "healthy"
- [ ] http://localhost:8081 répond (HTTP 302)
- [ ] Healthcheck passe : `docker compose exec php sh -c "cd /var/www/html && sh ./docker/php/healthcheck.sh"`
- [ ] 3 produits en base : `docker compose exec php php bin/console dbal:run-sql "SELECT COUNT(*) FROM products"`

**Si tous les points sont ✅, votre environnement est prêt ! 🎉**

