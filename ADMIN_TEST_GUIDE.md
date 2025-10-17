# 🔧 Guide de Test - Administration LocationVoiture

## 📋 **Comptes de Test Créés**

### 👨‍💼 **Administrateur de Test**
- **Email :** `admin.test@locationvoiture.com`
- **Mot de passe :** `password123`
- **Rôle :** Admin
- **Accès :** Dashboard administrateur complet

### 🚗 **Véhicules d'Agence Disponibles**
1. **BMW Série 3 Agence** (AG-001-CD) - 75,000 FCFA/jour
2. **Mercedes Classe C Agence** (AG-002-MB) - 85,000 FCFA/jour  
3. **Audi A4 Agence** (AG-003-AU) - 70,000 FCFA/jour

---

## 🎯 **Tests à Effectuer**

### 1. **Connexion Admin**
```
URL: http://127.0.0.1:8000/login
Email: admin.test@locationvoiture.com
Mot de passe: password123
```

### 2. **Dashboard Admin**
```
URL: http://127.0.0.1:8000/admin
✅ Vérifier les statistiques
✅ Naviguer entre les onglets
✅ Voir les utilisateurs récents
```

### 3. **Gestion des Offres**
```
URL: http://127.0.0.1:8000/admin/offres
✅ Créer une nouvelle offre
✅ Modifier une offre existante
✅ Activer/Désactiver une offre
✅ Supprimer une offre
```

### 4. **Création d'Offre Test**
```
URL: http://127.0.0.1:8000/admin/offres/create
✅ Sélectionner un véhicule d'agence
✅ Définir un prix promotionnel (ex: 60,000 FCFA au lieu de 75,000)
✅ Ajouter une réduction (ex: 20%)
✅ Définir une période d'offre
✅ Voir l'aperçu en temps réel
```

---

## 🛠 **Fonctionnalités Admin Testables**

### ✅ **Tableau de Bord**
- Statistiques utilisateurs par rôle
- Nombre de véhicules et réservations
- Vue d'ensemble des activités récentes

### ✅ **Gestion des Utilisateurs**
- Liste complète des utilisateurs
- Filtrage par rôle (admin, client, particulier)
- Actions de modération

### ✅ **Catalogue Véhicules**
- Vue des véhicules d'agence
- Statistiques par statut
- Lien vers la gestion des offres

### ✅ **Suivi des Réservations**
- Historique complet des réservations
- Actions de validation/annulation
- Détails des périodes de location

### ✅ **Validation de Véhicules**
- Section dédiée aux véhicules en attente
- Système d'approbation/rejet
- Notifications visuelles

### ✅ **Offres Promotionnelles**
- Création d'offres spéciales
- Gestion des réductions
- Aperçu client intégré
- Contrôle des statuts (Active/Inactive/Expirée)

---

## 🚀 **Scénarios de Test Complets**

### 📝 **Scénario 1 : Création d'Offre Promotionnelle**
1. Se connecter en tant qu'admin
2. Aller sur "Gérer les offres" depuis le dashboard
3. Cliquer "Nouvelle Offre"
4. Sélectionner la BMW Série 3 Agence
5. Définir prix 60,000 FCFA (au lieu de 75,000)
6. Ajouter réduction 20%
7. Période : du aujourd'hui au +30 jours
8. Sauvegarder et vérifier dans la liste

### 📝 **Scénario 2 : Gestion Multi-Offres**
1. Créer 3 offres différentes
2. Activer/désactiver certaines offres
3. Modifier les prix et périodes
4. Tester les filtres de statut

### 📝 **Scénario 3 : Validation Interface**
1. Explorer tous les onglets du dashboard
2. Vérifier les données statistiques
3. Tester la navigation entre sections
4. Valider les permissions d'accès

---

## ⚠️ **Notes Importantes**

- **Serveur** : Assurez-vous que `php artisan serve` est actif
- **Base de Données** : SQLite configurée avec les nouvelles migrations
- **Permissions** : Seuls les admins peuvent accéder aux routes `/admin/*`
- **Véhicules** : Seuls les véhicules appartenant à des admins apparaissent dans les offres

---

## 🔍 **Dépannage**

### Problème de Connexion
```bash
# Vérifier l'utilisateur admin
php artisan tinker
App\Models\Utilisateur::where('email', 'admin.test@locationvoiture.com')->first()
```

### Problème d'Affichage
```bash
# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Vérifier les Véhicules
```bash
# Compter les véhicules d'agence
php artisan tinker
App\Models\Vehicule::whereHas('proprietaire', function($q) { $q->where('role', 'admin'); })->count()
```

---

**🎉 Bon test de votre interface d'administration !**