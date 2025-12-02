# ✅ Configuration Xdebug - PHP 8.4

**Date:** 28 novembre 2025  
**Statut:** ✅ INSTALLÉ ET CONFIGURÉ

---

## 🎯 Résultat Final

### Versions Installées

```
PHP 8.4.15 (cli) (built: Nov 20 2025 20:00:12)
Xdebug v3.4.7
APCu (cache)
Memcached
```

### Extensions PHP Actives

✅ **xdebug** - Débogueur et profileur  
✅ **apcu** - Cache opcode  
✅ **memcached** - Cache distribué  
✅ **pdo_pgsql** - PostgreSQL  
✅ **pdo_mysql** - MySQL  
✅ **zip** - Archives ZIP  
✅ **bcmath** - Mathématiques précises  

---

## 🔧 Configuration Xdebug

### Fichier de Configuration
`/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini`

```ini
zend_extension=xdebug
xdebug.mode=debug,develop,coverage
xdebug.client_host=host.docker.internal
xdebug.client_port=9003
xdebug.start_with_request=yes
xdebug.log_level=0
xdebug.idekey=PHPSTORM
```

### Paramètres Détaillés

| Paramètre | Valeur | Description |
|-----------|--------|-------------|
| **mode** | `debug,develop,coverage` | Active le débogage, mode dev et couverture de code |
| **client_host** | `host.docker.internal` | Se connecte à l'hôte macOS depuis Docker |
| **client_port** | `9003` | Port standard Xdebug 3.x |
| **start_with_request** | `yes` | Démarre automatiquement avec chaque requête |
| **log_level** | `0` | Logs minimaux (pas de debug) |
| **idekey** | `PHPSTORM` | Clé IDE pour PHPStorm/IntelliJ |

---

## 🚀 Configuration IDE

### PHPStorm / IntelliJ IDEA

1. **Ouvrir les Préférences**
   - `Preferences` > `PHP` > `Debug`

2. **Configuration Xdebug**
   ```
   Debug port: 9003
   ☑ Can accept external connections
   ☑ Break at first line in PHP scripts
   ```

3. **Ajouter un Serveur**
   - `Preferences` > `PHP` > `Servers`
   - Nom: `Docker`
   - Host: `localhost`
   - Port: `8081`
   - Debugger: `Xdebug`
   - ☑ Use path mappings
   
4. **Path Mappings**
   ```
   Local: /Users/david/Sites/DavidBlanchard/SDK/php/la-foire-des-prix
   Remote: /var/www/html
   ```

5. **Démarrer l'Écoute**
   - Cliquer sur l'icône "Start Listening for PHP Debug Connections" (téléphone)
   - Ou utiliser le raccourci: `Cmd + Shift + F5`

### VS Code

1. **Installer l'Extension**
   - Installer "PHP Debug" par Xdebug

2. **Créer `.vscode/launch.json`**
   ```json
   {
     "version": "0.2.0",
     "configurations": [
       {
         "name": "Listen for Xdebug",
         "type": "php",
         "request": "launch",
         "port": 9003,
         "pathMappings": {
           "/var/www/html": "${workspaceFolder}"
         }
       }
     ]
   }
   ```

3. **Démarrer le Débogage**
   - Appuyer sur `F5` ou cliquer sur "Run > Start Debugging"

---

## 🧪 Tester Xdebug

### Test 1 : Vérifier que Xdebug est Chargé

```bash
docker compose exec php php -v
```

**Résultat attendu :**
```
PHP 8.4.15 (cli) (built: Nov 20 2025 20:00:12) (NTS)
...
    with Xdebug v3.4.7, Copyright (c) 2002-2025, by Derick Rethans
```

### Test 2 : Lister les Modules

```bash
docker compose exec php php -m | grep xdebug
```

**Résultat attendu :**
```
xdebug
```

### Test 3 : Voir la Configuration

```bash
docker compose exec php cat /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
```

### Test 4 : Créer un Point d'Arrêt

1. Ouvrir un fichier PHP (ex: `public/index.php`)
2. Ajouter un point d'arrêt (clic sur la marge gauche)
3. Démarrer l'écoute dans l'IDE
4. Accéder à http://localhost:8081
5. L'exécution doit s'arrêter au point d'arrêt

### Test 5 : Utiliser phpinfo()

Créer un fichier `public/phpinfo.php` :
```php
<?php
phpinfo();
```

Accéder à http://localhost:8081/phpinfo.php et chercher "xdebug"

---

## 🐛 Dépannage

### Xdebug ne Se Connecte Pas

#### 1. Vérifier que l'IDE Écoute sur le Port 9003

**macOS - Vérifier le port :**
```bash
lsof -i :9003
```

Si rien n'apparaît, l'IDE n'écoute pas.

#### 2. Vérifier la Connexion Réseau

```bash
docker compose exec php ping -c 3 host.docker.internal
```

Si le ping échoue, Docker Desktop ne peut pas contacter l'hôte macOS.

#### 3. Vérifier les Logs Xdebug

**Activer les logs dans le Dockerfile :**
```dockerfile
RUN echo "xdebug.log_level=10" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
```

**Voir les logs :**
```bash
docker compose exec php tail -f /tmp/xdebug.log
```

#### 4. Vérifier le Firewall macOS

Le firewall macOS peut bloquer les connexions entrantes :
- `Préférences Système` > `Sécurité et confidentialité` > `Pare-feu`
- Autoriser les connexions entrantes pour PHPStorm/VS Code

### Les Points d'Arrêt ne Fonctionnent Pas

1. **Vérifier le Path Mapping**
   - Le chemin local doit correspondre au chemin Docker
   - Local: `/Users/david/Sites/DavidBlanchard/SDK/php/la-foire-des-prix`
   - Docker: `/var/www/html`

2. **Vérifier l'IDEKey**
   - PHPStorm utilise `PHPSTORM` par défaut
   - VS Code peut nécessiter une configuration différente

3. **Redémarrer le Service PHP**
   ```bash
   docker compose restart php
   ```

### Performance Lente avec Xdebug

Xdebug ralentit l'exécution. Pour désactiver temporairement :

**Option 1 : Désactiver dans PHP**
```bash
docker compose exec php mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled
docker compose restart php
```

**Option 2 : Modifier le mode**
```ini
xdebug.mode=off
```

**Option 3 : Utiliser une Variable d'Environnement**

Ajouter dans `compose.yaml` :
```yaml
services:
  php:
    environment:
      XDEBUG_MODE: ${XDEBUG_MODE:-off}
```

Puis dans `.env` :
```bash
# Active xdebug
XDEBUG_MODE=debug,develop,coverage

# Désactive xdebug
# XDEBUG_MODE=off
```

---

## 📚 Ressources

- [Documentation Xdebug 3](https://xdebug.org/docs/)
- [Configuration PHPStorm](https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html)
- [Configuration VS Code](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug)
- [Xdebug avec Docker](https://xdebug.org/docs/docker)

---

## ✅ Checklist de Validation

- [x] PHP 8.4 installé
- [x] Xdebug 3.4.7 installé et activé
- [x] Configuration xdebug correcte
- [x] Port 9003 configuré
- [x] host.docker.internal accessible
- [x] Service PHP healthy
- [x] APCu et Memcached installés
- [x] Toutes les extensions PostgreSQL et MySQL installées

**Xdebug est maintenant complètement opérationnel avec PHP 8.4 ! 🎉**

---

**Dernière mise à jour :** 28 novembre 2025

