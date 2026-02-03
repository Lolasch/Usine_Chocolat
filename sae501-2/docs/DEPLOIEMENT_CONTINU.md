# Documentation - Intégration Continue et Déploiement Continu

## Table des matières
1. [Aperçu général](#aperçu-général)
2. [Architecture du système](#architecture-du-système)
3. [Configuration GitHub Actions](#configuration-github-actions)
4. [Configuration du serveur](#configuration-du-serveur)
5. [Processus de déploiement](#processus-de-déploiement)
6. [Maintenance et monitoring](#maintenance-et-monitoring)
7. [Troubleshooting](#troubleshooting)

---

## Aperçu général

### Objectif
Ce système met en place une **chaîne de tests continu simple** qui :
- **Exécute les tests automatiquement** à chaque push sur la branche `master`
- **Valide le code** avant le déploiement manuel
- **Vous informe si tout fonctionne** avant de déployer manuellement

Le déploiement lui-même reste **manuel et contrôlé** : vous décidez quand déployer.

### Bénéfices
✅ Tests automatisés = détection précoce des bugs  
✅ Déploiement simple et contrôlé manuellement  
✅ Pas de surprise en production  
✅ Rollback facile via Git  
✅ Historique complet des changements  

---

## Architecture du système

```
┌─────────────────────────────────────────────────────────────┐
│                     Votre ordinateur                         │
│                  (Code local - Git repo)                     │
└──────────────────────────┬──────────────────────────────────┘
                           │ git push origin master
                           │
┌──────────────────────────▼──────────────────────────────────┐
│                     GitHub (Remote)                          │
│            Webhook déclenche GitHub Actions                  │
└──────────────────────────┬──────────────────────────────────┘
                           │
                    ┌──────▼──────┐
                    │ Job: Tests  │
                    └──────┬──────┘
                           │
              ┌────────────┼────────────┐
              │            │            │
           PASS?         FAIL?        ERROR?
              │            │            │
              │         ❌ STOP      ❌ ARRÊT
              │      (Voir les logs)
              │            │
              ✅           └─ Correction du code
           VALIDE
              │
    ┌─────────▼──────────────────────────┐
    │ DÉPLOIEMENT MANUEL (vous décidez)  │
    │                                    │
    │ SSH vers le serveur:               │
    │ - git pull                         │
    │ - composer install                 │
    │ - php artisan migrate              │
    │ - php artisan cache:clear          │
    └────────────────────────────────────┘
              │
    ┌─────────▼──────────────┐
    │  Serveur de Production │
    │  Application mise à jour
    └────────────────────────┘
```

---

## Configuration GitHub Actions

### Fichier : `.github/workflows/deploy.yml`

Ce fichier YAML définit deux jobs (tâches) qui s'exécutent en séquence :

#### **Job 1 : Tests (Toujours d'abord)**

```yaml
jobs:
  tests:
    runs-on: ubuntu-latest
    strategy:
      matrix:
        php: [8.2]
```

**Explication des sections :**

| Paramètre | Valeur | Signification |
|-----------|--------|---------------|
| `runs-on` | `ubuntu-latest` | Machine virtuelle Linux sur laquelle les tests s'exécutent |
| `php: [8.2]` | `8.2` | Testé avec PHP 8.2 (vous pouvez ajouter `8.3`, `8.4`) |

**Étapes d'exécution :**

1. **Checkout code** : GitHub Actions clone votre repo
2. **Setup PHP** : Installe PHP 8.2 et les extensions nécessaires
3. **Install dependencies** : `composer install` (sans fichier lock pour plus de fiabilité)
4. **Generate .env** : Crée un fichier `.env` de test depuis `.env.example`
5. **Generate app key** : `php artisan key:generate` (clé unique pour chaque test)
6. **Execute tests** : Lance `php artisan test` (PHPUnit)

**Si échoue :** Le déploiement s'arrête immédiatement ❌

#### **Job 2 : Notification (Optionnel)**

```yaml
tests:
  runs-on: ubuntu-latest
  steps:
    # ... étapes précédentes ...
    - name: Notify success
      if: success()
      run: echo "✅ Tests réussis ! Vous pouvez déployer manuellement."
```

**Paramètres :**

| Paramètre | Signification |
|-----------|---------------|
| `if: success()` | Affiche le message seulement si les tests passent |

**Aucune action automatique ne se déclenche.** C'est vous qui décidez de déployer. ✋

---

## Configuration du serveur

### Prérequis système

Votre serveur de production doit avoir :

```
┌─────────────────────────────────────────────┐
│  Serveur Linux (Ubuntu 20.04+ recommandé)   │
├─────────────────────────────────────────────┤
│ • PHP 8.2+ avec extensions :                │
│   - curl, mbstring, zip, pdo, pdo_mysql    │
│   - xml, json (généralement inclus)         │
│ • Composer (package manager PHP)             │
│ • Git                                        │
│ • MySQL 5.7+ ou MariaDB 10.2+              │
│ • Nginx ou Apache (serveur web)              │
│ • Un utilisateur système : "deployer"       │
│ • Répertoire : /var/www/app (propriété)    │
└─────────────────────────────────────────────┘
```

### Étape 1 : Créer l'utilisateur de déploiement

```bash
# En tant que root/sudo
sudo useradd -m -s /bin/bash deployer
sudo passwd deployer  # Définir un mot de passe

# Créer le répertoire de l'app
sudo mkdir -p /var/www/app
sudo chown deployer:www-data /var/www/app
sudo chmod 755 /var/www/app
```

### Étape 2 : Générer les clés SSH

**Sur le serveur, en tant que `deployer` :**

```bash
# Générer une paire de clés SSH
ssh-keygen -t ed25519 -C "github-deploy" -N ""
# -t ed25519 : algorithme moderne et sécurisé
# -C : commentaire pour identifier la clé
# -N "" : pas de passphrase (nécessaire pour l'automatisation)

# Afficher la clé PRIVÉE (à copier dans GitHub)
cat ~/.ssh/id_ed25519

# Afficher la clé PUBLIQUE (à mettre sur le serveur)
cat ~/.ssh/id_ed25519.pub
```

**Configurer les permissions SSH :**

```bash
mkdir -p ~/.ssh
chmod 700 ~/.ssh

# Ajouter la clé publique à authorized_keys
cat ~/.ssh/id_ed25519.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

### Étape 3 : Cloner le repository initial

```bash
cd /var/www/app

# Cloner depuis GitHub (utiliser HTTPS si SSH n'est pas configuré)
git clone https://github.com/votre-username/votre-repo.git .

# Ou via SSH (si clés SSH configurées sur GitHub)
git clone git@github.com:votre-username/votre-repo.git .

# Vérifier le contenu
ls -la
```

### Étape 4 : Configuration Laravel

```bash
cd /var/www/app

# Créer le fichier .env production
cp .env.example .env

# Éditer les paramètres importants
nano .env
```

**Paramètres critiques à modifier dans `.env` :**

```env
APP_ENV=production
APP_DEBUG=false                    # JAMAIS true en production
APP_KEY=base64:...                 # Sera généré

DB_HOST=localhost                  # Ou votre serveur BD
DB_PORT=3306
DB_DATABASE=votre_base
DB_USERNAME=db_user
DB_PASSWORD=mot_de_passe_securise

REDIS_HOST=127.0.0.1              # Si vous utilisez Redis
REDIS_PASSWORD=null
REDIS_PORT=6379

LOG_CHANNEL=stack                  # Logs dans storage/logs/
```

### Étape 5 : Permissions des répertoires

```bash
# Storage et bootstrap/cache doivent être writable
sudo chown -R deployer:www-data /var/www/app/storage
sudo chown -R deployer:www-data /var/www/app/bootstrap/cache
sudo chmod -R 775 /var/www/app/storage
sudo chmod -R 775 /var/www/app/bootstrap/cache

# Le reste en lecture
sudo chown -R root:www-data /var/www/app
sudo chmod -R 755 /var/www/app
```

### Étape 6 : Initialisation de la base de données (première fois)

```bash
cd /var/www/app

# Générer une clé app unique
php artisan key:generate

# Exécuter les migrations
php artisan migrate --force

# (Optionnel) Remplir avec des données de test
php artisan db:seed
```

### Étape 7 : Configuration du serveur web

**Exemple pour Nginx :**

```nginx
server {
    listen 80;
    server_name votre-domaine.com;

    root /var/www/app/public;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

---

## Configuration GitHub Secrets

**ATTENTION :** Pour cette version simple, **vous n'avez pas besoin de secrets GitHub** puisque le déploiement est manuel.

Les secrets seraient nécessaires seulement si vous aviez un déploiement automatisé (ce n'est pas le cas ici).

---

## Processus de déploiement manuel

### Flux complet (étape par étape)

```
T=0 : Vous poussez vers master
  git push origin master

T+1 : GitHub Actions détecte le push
  ✓ Webhook GitHub Active → Déclenche les tests

T+2 : Téléchargement et préparation
  ✓ Clone du repository
  ✓ Installation de PHP 8.2 + extensions

T+3 : Exécution des tests
  ✓ composer install (dépendances)
  ✓ php artisan test (tests unitaires)
  
  SI ÉCHOUE → ❌ Arrêt complet, vous voyez l'erreur
  SI RÉUSSI → ✅ "Tests passés ! Prêt pour le déploiement"

T+4-T+9 : VOUS décidez du moment du déploiement
  
  Quand vous êtes prêt, vous faites manuellement sur le serveur :
  
  cd /var/www/app
  git fetch origin
  git pull origin master
  composer install
  php artisan migrate
  php artisan cache:clear
  php artisan config:clear
  php artisan view:clear
```

**La clé :** Vous avez le contrôle total ! Vous pouvez :
- Attendre le moment opportun pour déployer
- Tester manuellement avant de mettre en prod
- Eviter les déploiements accidentels
- Déployer depuis votre terminal à la main


### Monitoring en temps réel

1. **Voir l'exécution du test :**
   - Aller à votre repo GitHub
   - Cliquer sur l'onglet **Actions**
   - Cliquer sur le dernier workflow "Tests"
   - Voir si ✅ ou ❌

2. **Si ❌ (tests échouent) :**
   - Cliquer sur le job "tests"
   - Voir les erreurs détaillées
   - Corriger votre code en local
   - Faire un nouveau `git push`
   - Re-run les tests

3. **Si ✅ (tests passent) :**
   - C'est bon ! Vous pouvez déployer
   - Aller sur votre serveur
   - Lancer les commandes de déploiement manuel


---

## Maintenance et monitoring

### Vérifier que tout fonctionne

**Test de la connexion SSH :**

```bash
# Depuis votre local (ou n'importe où)
ssh -i ~/.ssh/id_ed25519 deployer@votre_serveur_ip

# Devrait vous connecter sans mot de passe
# Si échoue : vérifier les permissions et authorized_keys
```

**Vérifier les droits du répertoire :**

```bash
# Sur le serveur
ls -la /var/www/app/storage
# Doit avoir : drwxrwxr-x deployer www-data
```

**Consulter les logs de l'application :**

```bash
# Sur le serveur
tail -f /var/www/app/storage/logs/laravel.log

# Voir la dernière heure
tail -n 100 /var/www/app/storage/logs/laravel.log | grep "$(date +%Y-%m-%d)"
```

**Vérifier l'état de la base de données :**

```bash
cd /var/www/app

# Liste des migrations appliquées
php artisan migrate:status

# Revenir à une migration précédente (en cas de problème)
php artisan migrate:rollback
```

### Maintenance régulière

**Nettoyer les logs anciens :**

```bash
# Garder seulement 7 jours de logs
find /var/www/app/storage/logs -name "*.log" -mtime +7 -delete
```

**Optimiser l'autoloader Composer :**

```bash
cd /var/www/app
composer dump-autoload --optimize --no-dev
```

**Vérifier les permissions mensuellement :**

```bash
sudo chown -R deployer:www-data /var/www/app/storage
sudo chown -R deployer:www-data /var/www/app/bootstrap/cache
sudo chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache
```

---

## Troubleshooting

### 1. "Permission denied (publickey)"

**Cause :** Clé SSH non reconnue par le serveur

**Solutions :**

```bash
# Vérifier que la clé publique est bien importée
cat ~/.ssh/id_ed25519.pub
grep "$(cat ~/.ssh/id_ed25519.pub)" ~/.ssh/authorized_keys

# Si absent, l'ajouter
cat ~/.ssh/id_ed25519.pub >> ~/.ssh/authorized_keys

# Vérifier les permissions
chmod 600 ~/.ssh/authorized_keys
chmod 700 ~/.ssh
```

### 2. "composer: command not found"

**Cause :** Composer n'est pas installé ou pas dans le PATH

**Solution :**

```bash
# Installer Composer globalement
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# Vérifier
composer --version
```

### 3. "SQLSTATE[HY000]: General error: 1030"

**Cause :** Problème de permissions ou d'espace disque lors des migrations

**Solutions :**

```bash
# Vérifier l'espace disque
df -h

# Vérifier les permissions MySQL
sudo chown -R mysql:mysql /var/lib/mysql

# Relancer les migrations
cd /var/www/app
php artisan migrate --force
```

### 4. Les tests passent localement mais échouent sur GitHub

**Cause :** Versions PHP différentes ou manque d'extensions

**Solution :**

```yaml
# Dans .github/workflows/deploy.yml, vérifier :
extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite

# Ajouter les extensions manquantes pour MySQL
extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, mysql, pdo_mysql
```

### 5. Le déploiement démarre mais échoue à mi-chemin

**Cause :** Timeout, pas d'espace, ou processus worker qui lock

**Solutions :**

```bash
# Arrêter les processus Laravel en arrière-plan
sudo pkill -f "php artisan queue:work"
sudo pkill -f "php artisan schedule:run"

# Attendre 5 secondes
sleep 5

# Réessayer le déploiement (push vide)
git commit --allow-empty -m "Retry deployment"
git push origin master
```

### 6. Les vues Blade ne se mettent pas à jour

**Cause :** Cache des vues non vidé

**Solution :** Le déploiement inclut déjà `php artisan view:clear`, sinon :

```bash
cd /var/www/app
php artisan view:clear
php artisan cache:clear
```

---

## Checklist de déploiement

Avant votre premier déploiement en production :

- [ ] Serveur configuré avec PHP 8.2+, Composer, Git
- [ ] Utilisateur `deployer` créé sur le serveur
- [ ] Clés SSH générées et configurées
- [ ] Repository cloné dans `/var/www/app`
- [ ] Fichier `.env` créé et configuré
- [ ] Base de données créée et accessible
- [ ] Migrations exécutées une première fois
- [ ] Permissions des répertoires correctes
- [ ] Serveur web (Nginx/Apache) configuré
- [ ] Secrets GitHub ajoutés correctement
- [ ] Tests passent localement
- [ ] Connexion SSH testée manuellement
- [ ] Logs vérifiés après premier déploiement

---

## Logs et diagnostics

### Où trouver les logs

```
Machine locale (GitHub Actions)
├─ https://github.com/votre-repo/actions
└─ Cliquer sur le workflow pour voir les détails

Serveur de production
├─ Application : /var/www/app/storage/logs/laravel.log
├─ SSH : /var/log/auth.log
├─ MySQL : /var/log/mysql/error.log
└─ Nginx : /var/log/nginx/access.log, error.log
```

### Commandes utiles de diagnostic

```bash
# Sur le serveur - vérifier tout
cd /var/www/app

# État actuel du code
git status
git log --oneline -5

# Migrations
php artisan migrate:status

# Environnement
php artisan tinker
>>> env('APP_ENV')
>>> env('DB_DATABASE')
>>> exit

# Logs en temps réel
tail -f storage/logs/laravel.log

# Vérifier les permissions
ls -la storage/
ls -la bootstrap/cache/
```

---

## Conclusion

Ce système simple de tests continu vous permet de :
- **Tester automatiquement à chaque push** = détection des bugs tôt
- **Déployer quand vous êtes prêt** = contrôle total
- **Éviter les erreurs manuelles** = une checklist claire
- **Avoir une trace complète** = voir l'historique via Git et GitHub Actions

**C'est la bonne balance :** Automatisation des tests + Contrôle manuel du déploiement.

Pour toute question, consultez les logs GitHub Actions dans votre repo.
