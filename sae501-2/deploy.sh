#!/bin/bash

# Script de déploiement sur Plesk

set -e

echo "Déploiement en cours..."

# 1. Installer les dépendances Composer
echo "Installation des dépendances Composer..."
composer install --no-dev --optimize-autoloader

# 2. Créer le fichier .env s'il n'existe pas
if [ ! -f .env ]; then
    echo "Création du fichier .env..."
    cp .env.example .env
fi

# 3. Générer la clé APP
echo "Génération de la clé application..."
php artisan key:generate --force

# 4. Installation des dépendances npm
echo "Installation des dépendances npm..."
npm install
npm run build

# 5. Exécuter les migrations
echo "Exécution des migrations..."
php artisan migrate --force

# 6. Nettoyer les caches
echo "Nettoyage des caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 7. Définir les permissions
echo "Définition des permissions..."
chmod -R 755 storage bootstrap/cache

echo "Déploiement terminé avec succès !"
