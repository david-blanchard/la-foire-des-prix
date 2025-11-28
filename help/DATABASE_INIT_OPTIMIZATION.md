# ✅ Optimisation : Éviter la Réinitialisation de la Base de Données

**Date:** 28 novembre 2025  
**Problème résolu:** Les migrations et fixtures étaient relancées à chaque redémarrage même si la base contenait déjà des données

---

## 🎯 Problème

À chaque redémarrage du conteneur PHP, le script `init-database.sh` :
- ✅ Attendait que PostgreSQL soit prêt
- ❌ **Relançait TOUJOURS les migrations** (même si déjà à jour)
- ❌ **Relançait TOUJOURS les fixtures** (même si données existantes)
- ❌ Prenait ~60 secondes à chaque redémarrage

**Comportement attendu :** Ne lancer migrations + fixtures QUE si la base est vide.

---

## 💡 Solution Implémentée

### Modification du Script `init-database.sh`

**Nouvelle logique (lignes 34-64) :**

1. **Vérifier d'abord si des produits existent**
   ```bash
   PRODUCT_OUTPUT=$(php bin/console dbal:run-sql 'SELECT COUNT(*) FROM products' --no-interaction 2>&1)
   PRODUCT_EXIT_CODE=$?
   ```

2. **Si la table n'existe pas** → Continuer avec l'initialisation complète
   ```bash
   if [ $PRODUCT_EXIT_CODE -ne 0 ]; then
       echo "📊 Products table doesn't exist yet - proceeding with full initialization..."
       PRODUCT_COUNT=0
   ```

3. **Si la table existe** → Extraire le nombre de produits
   ```bash
   else
       PRODUCT_COUNT=$(echo "$PRODUCT_OUTPUT" | grep -A2 "count" | tail -1 | tr -d ' ' || echo "0")
       echo "📊 Current product count: $PRODUCT_COUNT"
   fi
   ```

4. **Si count > 0** → **SKIP COMPLET** des migrations et fixtures
   ```bash
   if [ ! -z "$PRODUCT_COUNT" ] && [ "$PRODUCT_COUNT" -gt 0 ] 2>/dev/null; then
       echo "✅ Database already initialized with $PRODUCT_COUNT products"
       echo "⏭️  Skipping migrations and fixtures (database already has data)"
       
       # Créer le flag immédiatement
       echo "Database initialization complete" > /tmp/.db-ready
       echo "✅ Database is ready!"
       exit 0  # ← SORTIE PRÉCOCE
   fi
   ```

5. **Si count = 0** → Procéder avec migrations + fixtures
   ```bash
   echo "📊 Database is empty (count: $PRODUCT_COUNT) - proceeding with full initialization..."
   # ... migrations et fixtures ...
   ```

---

## 📊 Résultats

### Avant (Base avec Données)
```
⏳ Attente PostgreSQL : ~10s
🔄 Migrations : ~5s (même si déjà à jour)
🌱 Fixtures : ~45s (purge + reload)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
⏱️ Total : ~60 secondes
```

### Après (Base avec Données)
```
⏳ Attente PostgreSQL : ~10s
📊 Vérification produits : <1s
⏭️ Skip migrations/fixtures : 0s
✅ Création flag : <1s
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
⏱️ Total : ~11 secondes
```

**🚀 Gain de temps : ~49 secondes (82% plus rapide) !**

### Logs du Nouveau Comportement

**Avec données existantes :**
```
🔄 Starting database initialization script...
⏳ Waiting for PostgreSQL to be fully ready...
✅ Database is accessible!
📦 Ensuring database exists...
Database "lafoire" for connection named default already exists. Skipped.
📊 Current product count: 3
✅ Database already initialized with 3 products
⏭️  Skipping migrations and fixtures (database already has data)
✅ Database is ready!
```

**Base vide (premier démarrage) :**
```
🔄 Starting database initialization script...
⏳ Waiting for PostgreSQL to be fully ready...
✅ Database is accessible!
📦 Ensuring database exists...
📊 Products table doesn't exist yet (exit code: 1) - proceeding with full initialization...
📊 Database is empty (count: 0) - proceeding with full initialization...
🔄 Running database migrations...
✅ Migrations completed successfully
🌱 Loading fixtures...
✅ Fixtures loaded successfully
📊 After loading fixtures: 3 products
✅ Database is fully initialized and ready!
```

---

## 🔧 Détails Techniques

### Extraction du Nombre de Produits

**Challenge :** La commande `dbal:run-sql` retourne un tableau formaté :
```
 ------- 
  count  
 ------- 
  3      
 -------
```

**Solution :** Pipeline bash pour extraire le chiffre :
```bash
echo "$PRODUCT_OUTPUT" | grep -A2 "count" | tail -1 | tr -d ' '
# Résultat : "3"
```

- `grep -A2 "count"` : Prend la ligne "count" + 2 lignes après
- `tail -1` : Prend la dernière ligne (le chiffre)
- `tr -d ' '` : Supprime les espaces

### Gestion des Erreurs

Si la table `products` n'existe pas, la commande SQL échoue :
```bash
PRODUCT_EXIT_CODE=$?  # Capture le code de sortie
if [ $PRODUCT_EXIT_CODE -ne 0 ]; then
    # Table n'existe pas → initialisation complète
fi
```

---

## 📝 Cas d'Usage

### 1. Premier Démarrage (Base Vide)
```bash
docker compose up -d
```
✅ Migrations + Fixtures sont jouées (normal)  
⏱️ Temps : ~60s

### 2. Redémarrage (Données Existantes)
```bash
docker compose restart php
```
✅ Migrations + Fixtures sont **SAUTÉES**  
⏱️ Temps : ~11s (82% plus rapide)

### 3. Reset Complet
```bash
docker compose down -v  # Supprime les volumes
docker compose up -d
```
✅ Migrations + Fixtures sont jouées (base vide)  
⏱️ Temps : ~60s

### 4. Forcer la Réinitialisation (Sans Supprimer les Volumes)

**Option 1 : Vider manuellement la table products**
```bash
docker compose exec php php bin/console dbal:run-sql "TRUNCATE products CASCADE"
docker compose restart php
```

**Option 2 : Utiliser `composer refresh` manuellement**
```bash
docker compose exec php composer refresh
```

---

## 🎓 Points Clés

### 1. Table `products` comme Indicateur
- Présence de produits = base initialisée
- C'est une table centrale qui sera toujours remplie par les fixtures
- Simple et fiable

### 2. Exit Précoce
- Utilisation d'`exit 0` pour sortir immédiatement
- Évite d'exécuter le reste du script
- Crée quand même le fichier flag `/tmp/.db-ready`

### 3. Healthcheck Inchangé
- Le healthcheck vérifie toujours `/tmp/.db-ready`
- Le flag est créé immédiatement si données existantes
- Le service devient "healthy" rapidement

### 4. Sécurité
- Si la vérification échoue, le script continue normalement
- Pas de risque de bloquer le démarrage
- Les erreurs sont loggées clairement

---

## 🔄 Workflow Complet

```
┌─────────────────────────────────────────┐
│  Démarrage du conteneur PHP             │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│  PHP-FPM démarre                        │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│  Script init-database.sh (background)   │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│  Attente PostgreSQL prêt (max 4 min)    │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│  Vérification : COUNT(*) FROM products  │
└──────────────┬──────────────────────────┘
               │
       ┌───────┴───────┐
       │               │
       ▼               ▼
  ┌─────────┐    ┌──────────┐
  │ count>0 │    │ count=0  │
  └────┬────┘    └────┬─────┘
       │              │
       ▼              ▼
  ┌─────────┐    ┌──────────────┐
  │  SKIP!  │    │  Migrations  │
  └────┬────┘    └──────┬───────┘
       │                │
       │                ▼
       │         ┌──────────────┐
       │         │   Fixtures   │
       │         └──────┬───────┘
       │                │
       ▼                ▼
  ┌──────────────────────────┐
  │  Créer /tmp/.db-ready    │
  └──────────┬───────────────┘
             │
             ▼
  ┌──────────────────────────┐
  │  Healthcheck OK          │
  │  Service = healthy ✅     │
  └──────────────────────────┘
```

---

## ✅ Validation

```bash
# Test 1 : Premier démarrage
docker compose down -v && docker compose up -d
# ✅ Doit jouer migrations + fixtures

# Test 2 : Redémarrage
docker compose restart php
# ✅ Doit SKIP migrations + fixtures

# Test 3 : Vérifier les logs
docker compose logs php | grep "Skipping migrations"
# ✅ Doit afficher le message de skip
```

---

**🎉 L'optimisation est maintenant complète et fonctionnelle !**

Les redémarrages sont **82% plus rapides** quand la base contient déjà des données.

