# 🚗 LocationVoiture - Application Web de Location de Véhicules

Une application web moderne développée avec **Laravel** pour la gestion de location de véhicules entre particuliers et professionnels.

## 📋 Description du Projet

**LocationVoiture** est une plateforme complète permettant aux utilisateurs de :
- 🔍 Rechercher et réserver des véhicules disponibles
- 🏠 Proposer leurs propres véhicules à la location
- 👤 Gérer leur profil et leurs réservations
- 💼 Administrer la plateforme (pour les admins)

## 🌟 Fonctionnalités Principales

### 🔐 Système d'Authentification
- **Inscription/Connexion** avec interface moderne et responsive
- **Gestion de profil** complète (informations personnelles, mot de passe)
- **Rôles utilisateurs** : Admin, Client, Particulier
- **Validation sécurisée** des mots de passe et emails

### 🚙 Gestion des Véhicules
- **Catalogue de véhicules** avec filtres et recherche
- **Ajout de véhicules** par les propriétaires
- **Système d'offres** avec packs et options personnalisables
- **Images et descriptions** détaillées

### 📅 Système de Réservation
- **Calendrier de disponibilité** en temps réel
- **Géolocalisation** avec autocomplétion d'adresses
- **Gestion des lieux** de récupération et retour
- **Suivi des réservations** et statuts

### 💎 Interface Utilisateur
- **Design moderne** avec Bootstrap 5 et animations CSS
- **Dashboard interactif** avec onglets et navigation fluide
- **Responsive design** adapté mobile/tablet/desktop
- **Autocomplétion géographique** via OpenStreetMap

## 🛠️ Technologies Utilisées

- **Backend** : Laravel 11, PHP 8.3
- **Frontend** : Bootstrap 5, JavaScript ES6, CSS3
- **Base de données** : SQLite (développement)
- **APIs** : OpenStreetMap Nominatim (géolocalisation)
- **Outils** : Composer, NPM, Git

## 📂 Structure du Projet

```
locationVoiture/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/           # Contrôleurs d'authentification
│   │   ├── DashboardController.php
│   │   ├── VehiculeController.php
│   │   ├── ReservationController.php
│   │   ├── OffreVehiculeController.php
│   │   └── AvisController.php
│   ├── Models/
│   │   ├── Utilisateur.php # Modèle utilisateur personnalisé
│   │   ├── Vehicule.php
│   │   ├── Reservation.php
│   │   ├── OffreVehicule.php
│   │   └── Avis.php
│   └── Http/Requests/      # Validation des formulaires
├── database/
│   ├── migrations/         # Migrations de base de données
│   └── seeders/           # Données de test
├── resources/
│   ├── views/
│   │   ├── auth/          # Vues d'authentification stylisées
│   │   ├── dashboard.blade.php
│   │   ├── profile/       # Gestion du profil utilisateur
│   │   └── layouts/       # Templates de base
│   ├── css/
│   └── js/
└── routes/
    ├── web.php            # Routes principales
    └── auth.php           # Routes d'authentification
```

## 🚀 Améliorations et Nouveautés Récentes

### ✨ Système d'Authentification Complet
- **Formulaires stylisés** : Login et inscription avec design moderne cohérent
- **Standardisation** : Migration de `mot_de_passe` vers `password` (standard Laravel)
- **Page de profil** : Interface complète pour la gestion des informations utilisateur
- **Sécurité renforcée** : Hashage moderne et validation robuste

### 🎨 Interface Utilisateur Modernisée
- **Design cohérent** : Palette de couleurs harmonisée (bleu #007bff/#00c6ff)
- **Dashboard interactif** : Navigation par onglets avec animations fluides
- **Responsive design** : Adaptation parfaite mobile/desktop
- **Effets visuels** : Glassmorphism, transitions CSS, hover effects

### 🌍 Fonctionnalités Géographiques
- **Autocomplétion d'adresses** : Intégration OpenStreetMap Nominatim
- **Géolocalisation** : Sauvegarde des coordonnées GPS
- **Interface intuitive** : Navigation clavier dans les suggestions
- **Debouncing** : Optimisation des requêtes API

### 🚗 Système d'Offres Avancé
- **Modèle OffreVehicule** : Gestion complète des offres avec packs et options
- **API REST** : Endpoint pour récupération dynamique des données
- **Affichage dynamique** : Cartes de véhicules générées en JavaScript
- **Filtres avancés** : Recherche par critères multiples

### 🔧 Améliorations Techniques
- **Contrôleurs optimisés** : Code refactorisé et standardisé
- **Migrations complètes** : Structure de base de données cohérente
- **Validation moderne** : Requests Laravel avec règles personnalisées
- **JavaScript modulaire** : Code organisé et réutilisable

## 📊 Base de Données

### Tables Principales
- **utilisateurs** : Gestion des comptes utilisateurs
- **vehicules** : Catalogue des véhicules disponibles
- **reservations** : Système de réservation et booking
- **offre_vehicules** : Offres avec packs et options
- **avis** : Système de notation et commentaires
- **paiements** : Gestion des transactions
- **commissions** : Calcul des commissions plateforme

🔗 **Diagramme de base de données** : [Voir sur dbdiagram.io](https://dbdiagram.io/d/locationVoiture-68d0fcd37c85fb9961c37aa0)

## 🚀 Installation et Configuration

### Prérequis
- PHP 8.3+
- Composer
- SQLite ou MySQL
- Node.js (pour la compilation des assets)

### Installation
```bash
# Cloner le projet
git clone https://github.com/Godwin85pc/locationVoiture.git
cd locationVoiture

# Installer les dépendances
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate
php artisan db:seed

# Lancer le serveur
php artisan serve
```

## 🎯 Prochaines Étapes

- [ ] Système de paiement intégré
- [ ] Chat en temps réel entre utilisateurs
- [ ] Application mobile (API REST)
- [ ] Géolocalisation avancée avec cartes interactives
- [ ] Système de notation et avis détaillé
- [ ] Notifications push et emails automatiques

## 👥 Équipe de Développement

- **Développeur Principal** : Godwin85pc
- **Framework** : Laravel 11
- **Design** : Bootstrap 5 + CSS personnalisé

## 📄 Licence

Ce projet est développé dans le cadre d'un projet éducatif.

---

**✨ Dernière mise à jour** : Octobre 2025  
**🔄 Version** : 2.0 - Système d'authentification complet et interface modernisée
