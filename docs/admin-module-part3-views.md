# Module Admin – Partie 3 : Vues Blade, variables et comportements

Cette partie décrit en détail les vues du module admin: quelles variables leur sont passées, le rôle de chaque bloc, à quoi servent les boutons et ce que déclenche chaque action (route/méthode). Elle signale aussi les écarts entre vues et contrôleurs afin d’éviter les surprises pendant la démo.

---

## 0) Layout de base

- Fichier: `resources/views/layouts/app.blade.php`
- Rôle: squelette HTML commun (Bootstrap + Icons), inclusion de `layouts.navigation`, conteneur principal, `@yield('content')`, et pile `@stack('scripts')` pour JS additionnel.
- Implication: toutes les vues admin héritent généralement de ce layout via `@extends('layouts.app')` et définissent `@section('content')`.

---

## 1) Dashboard Admin

- Fichier: `resources/views/admin/dashboard.blade.php`
- Contrôleur: `AdminController@dashboard`
- Variables fournies:
  - `$stats`: totaux (utilisateurs, véhicules, réservations, offres, etc.)
  - `$utilisateurs_par_role`: distribution par rôles
  - `$derniers_utilisateurs`: 5 récents
  - `$utilisateurs`: liste paginée
  - `$vehicules_en_attente`: pour l’onglet Validation
  - `$tous_vehicules`: catalogue complet (avec propriétaires)
  - `$dernieres_reservations`: 10 dernières
  - `$vehicules_par_statut`: comptage par statut
- Sections clés:
  - En-tête: affichage du nom/prénom de l’admin via `Auth::guard('admin')->user()`.
  - Flashs: `session('success')` et `session('error')` (alertes dismissibles).
  - Cartes Stats: 4 KPI (utilisateurs, véhicules, réservations, offres).
  - Onglets (Bootstrap pills): Vue d’ensemble, Utilisateurs, Véhicules, Réservations, Validation.
- Boutons/Actions:
  - `Dashboard Utilisateur` → `route('admin.preview.user-dashboard')` (lecture seule côté admin).
  - Onglet « Utilisateurs »: actions Voir/Editer/Supprimer via routes `admin.utilisateurs.*`.
  - Onglet « Véhicules »: boutons Approuver/Rejeter via formulaires `PATCH` sur `admin.vehicules.approve` et `admin.vehicules.reject`.
- Notes importantes:
  - Les actions véhicules utilisent des formulaires HTML avec `@csrf` et `@method('PATCH')`; les contrôleurs renvoient des redirections avec messages flash (pas de JSON), ce qui est cohérent ici.

---

## 2) Gestion des Véhicules (Admin)

- Fichier: `resources/views/admin/vehicules/index.blade.php`
- Contrôleur: `VehiculeController@adminIndex`
- Variables fournies: `$vehiculesEnAttente`, `$vehiculesValides`, `$vehiculesRejetes`, `$stats`.
- UI:
  - 3 onglets: En attente / Validés / Rejetés.
  - Listes avec infos véhicule + propriétaire, prix/jour, date, etc.
  - Modals détaillés (vue complète du véhicule), modal de rejet (saisie du motif).
- Boutons/Actions:
  - En attente: 
    - Voir (modal)
    - Valider: bouton JS `validerVehicule(id)` → `fetch('PATCH /admin/vehicules/{id}/approve')`
    - Rejeter: ouvre un modal; soumission `PATCH admin.vehicules.reject` avec `motif_rejet`.
  - Rejetés: bouton « remettre en attente » via JS `remettreEnAttente(id)` → `fetch('PATCH /admin/vehicules/{id}/resume')`.
- Attention (cohérence):
  - Le JS `fetch(...).then(response => response.json())` attend du JSON, alors que `VehiculeController@approve/adminResume` renvoient une redirection (HTML). Deux options:
    1) Remplacer ces boutons JS par de simples formulaires HTML (comme sur le dashboard) → aucune adaptation de contrôleur.
    2) Adapter les méthodes (`approve`, `adminResume`, `reject`) pour renvoyer `response()->json(['success'=>true])` si `request()->expectsJson()`.

---

## 3) Notifications Véhicules (Admin)

- Fichier: `resources/views/admin/notifications/vehicules.blade.php`
- Contrôleur: `AdminController@notificationVehicule`
- Variables attendues: la vue manipule `$vehiculesEnAttente` (affiche l’alerte avec le nombre et les cartes).
- Incohérences à connaître:
  - Contrôleur envoie `compact('vehicules')` (nom différent). À corriger pour: `['vehiculesEnAttente' => $vehicules]`.
  - Bouton « Valider »: `fetch('PATCH /admin/vehicules/{id}/approve')` + `response.json()` → même problème que plus haut (les contrôleurs renvoient des redirections). Appliquer la même solution A) formulaires HTML ou B) JSON conditionnel.
- Autres détails:
  - Modals « Détails » et « Rejet » par véhicule.
  - Mêmes champs affichés que la page Véhicules (marque, modèle, immatriculation, etc.).

---

## 4) Offres d’Agence

- Index: `resources/views/admin/offres/index.blade.php` → `OffreAgenceController@index`
  - Variables: `$offres` (paginées, avec `vehicule`).
  - Stats en cards: actif/inactif/expiré/total.
  - Tableau: véhicule, prix/jour, période, réduction, statut, date de création.
  - Actions: Voir (`admin.offres.show`), Modifier (`admin.offres.edit`), Toggle (`admin.offres.toggle-status` via `PATCH`), Supprimer (`DELETE`).
  - À noter: Les vues `show` et `edit` ne sont pas présentes dans le repo. Soit les créer, soit retirer les boutons.

- Create: `resources/views/admin/offres/create.blade.php` → `OffreAgenceController@create`/`store`
  - Formulaire: `vehicule_id` (liste des véhicules d’agence disponibles), `prix_par_jour`, `reduction_pourcentage`, `date_debut_offre`, `date_fin_offre`, `description_offre`, `conditions_speciales`.
  - Aperçu JS: calcule une économie supposée, met en avant prix d’origine vs prix d’offre, réduit 15% par défaut à la sélection du véhicule.
  - Validation côté contrôleur à l’enregistrement.

---

## 5) Utilisateurs (Admin)

- Index: `resources/views/admin/utilisateurs/index.blade.php` → `UtilisateurController@adminIndex`
  - Variables: `$utilisateurs` (paginés, avec `reservations_count` et `vehicules_count`), `$stats` (répartitions par rôle, etc.).
  - Tableau: nom complet, email, rôle (badge), compte de véhicules/réservations, date d’inscription.
  - Actions: Voir (`admin.utilisateurs.show`), Modifier (`utilisateurs.edit`), Supprimer (`utilisateurs.destroy`).
  - Note: Les routes d’édition/suppression pointent vers les routes « utilisateurs » génériques et pas vers un préfixe `admin`. C’est un choix acceptable mais à signaler (droits, cohérence d’URL).

- Show: `resources/views/admin/utilisateurs/show.blade.php` → `UtilisateurController@adminShow`
  - Variables: `$utilisateur` (avec counts), collections limitées des derniers véhicules et réservations.
  - Présente un résumé (KPI) et listes récentes.

- Edit: `resources/views/admin/utilisateurs/edit.blade.php` → `UtilisateurController@adminEdit/adminUpdate`
  - Formulaire: prénom, nom, email, téléphone; submit `PATCH admin.utilisateurs.update`.

- Partials: `resources/views/admin/partials/utilisateurs.blade.php`
  - Tableau réutilisable listant nom/prénom/email/rôle + actions (voir/modifier/supprimer) s’appuyant sur `admin.utilisateurs.show`, `utilisateurs.edit`, `utilisateurs.destroy`.

---

## 6) Variables et contrats par action (rappel)

- Actions véhicules (approve/reject/resume) → contrôleur redirige avec flash; privilégier des formulaires HTML dans les vues.
- Actions offres (toggle/destroy) → formulaires HTML, redirection back avec flash.
- Utilisateurs (update/destroy) → formulaires HTML vers routes correspondantes.

---

## 7) Écarts et quick-fixes proposés

- Notifications – variable: aligner `notificationVehicule()` pour fournir `vehiculesEnAttente`.
- Notifications/Véhicules – fetch JSON: 
  - Option A (recommandée pour la démo): remplacer les fetch par formulaires HTML (PATCH) pour rester aligné avec les contrôleurs actuels (moins de risques de surprises).
  - Option B: ajouter des réponses JSON conditionnelles côté contrôleurs (`if ($request->expectsJson()) return response()->json(['success'=>true]);`).
- Offres – vues manquantes `show`/`edit`: créer rapidement des vues minimalistes ou retirer les boutons si non nécessaires à l’exposé.

---

## 8) Conseils démo (clés de voûte à expliquer)

- Guard admin vs web (déjà expliqué en Partie 1) et effet sur `Auth::guard('admin')` dans les vues.
- Cohérence entre formulaires HTML et réponses de contrôleur (redirections + flash) — expliquer pourquoi on préfère les formulaires dans l’admin.
- Statuts de véhicules (en_attente/disponible/rejete) et circuit de validation.
- Offres d’agence: filtre des véhicules d’agence (propriétaire admin) et champs principaux.
- Droits sur utilisateurs: choix de routes génériques (edit/destroy) vs routes admin — cohérence à garder en tête.

---

## 9) Références

- Dashboard: `resources/views/admin/dashboard.blade.php`
- Véhicules: `resources/views/admin/vehicules/index.blade.php`
- Notifications: `resources/views/admin/notifications/vehicules.blade.php`
- Offres: `resources/views/admin/offres/index.blade.php`, `resources/views/admin/offres/create.blade.php`
- Utilisateurs: `resources/views/admin/utilisateurs/index|show|edit.blade.php`
- Partials: `resources/views/admin/partials/utilisateurs.blade.php`
- Layout: `resources/views/layouts/app.blade.php`

---

## 10) Export PDF

Pour exporter cette Partie 3 en PDF (comme les autres parties):
- VS Code (extension Markdown PDF): Ouvrir le fichier → clic droit → "Markdown PDF: Export (pdf)".
- Navigateur: Prévisualiser → Imprimer (Ctrl+P) → Destination: "Enregistrer au format PDF".
- Ligne de commande: `pandoc docs/admin-module-part3-views.md -o docs/admin-module-part3-views.pdf`
