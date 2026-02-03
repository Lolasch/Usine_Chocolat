# L'Usine à Chocolat 2026 - Routes principales

## Routes publiques (Visiteurs)
- **`/accueil`** - Page d'accueil pour les visiteurs

## Routes d'authentification (Superviseur & Opérateur)
- **`/`** - Redirection vers la page de login
- **`/login`** - Formulaire de connexion pour superviseur et opérateur
- **`/register`** - Formulaire d'inscription
- **`/logout`** - Déconnexion

## Routes protégées (Authentifiés)
- **`/liste`** - Liste des commandes (superviseur & opérateur)
- **`/stocks`** - Gestion des stocks (superviseur)
- **`/statistiques`** - Statistiques et analytics (superviseur)
- **`/admin`** - Panneau d'administration (superviseur)

## Niveaux d'accès

| Route | Visiteur | Superviseur | Opérateur |
|-------|----------|-------------|-----------|
| `/accueil` | ✅ | ❌ | ❌ |
| `/login` | ✅ | ✅ | ✅ |
| `/liste` | ❌ | ✅ | ✅ |
| `/stocks` | ❌ | ✅ | ❌ |
| `/statistiques` | ❌ | ✅ | ❌ |
| `/admin` | ❌ | ✅ | ❌ |
