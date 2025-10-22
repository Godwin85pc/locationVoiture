# Module Admin – Partie 2 : Routes, Contrôleurs et Comportements

Cette partie cartographie toutes les routes du module admin, détaille les contrôleurs et explique le rôle des variables, des boutons et des comportements associés. Elle signale aussi les incohérences à corriger pour la démo.

---

## 1) Vue d’ensemble des routes Admin

- Fichier: `routes/web.php`
- Accès au dashboard: `GET /admin` → `AdminController@dashboard` → `name('admin.dashboard')`
- Groupe admin:
  - Prefix: `admin/`
  - Name: `admin.`
  - Middlewares: `['auth:admin', 'admin']`

À l’intérieur du groupe:
- Aperçu dashboard utilisateur: `GET /admin/preview/user-dashboard` → `DashboardController@adminPreview` → `admin.preview.user-dashboard`
- Notifications véhicules: `GET /admin/notification` → `AdminController@notificationVehicule` → `admin.notification`
- Validation véhicule (ancienne voie): `POST /admin/vehicule/valider/{id}` → `AdminController@validerVehicule` → `admin.valider_vehicule`
- Offres d’agence: `Route::resource('offres', OffreAgenceController::class)` → CRUD complet sous `admin.offres.*`
- Toggle offre: `PATCH /admin/offres/{offre}/toggle-status` → `OffreAgenceController@toggleStatus` → `admin.offres.toggle-status`
- Réservations (admin):
  - `GET /admin/reservations` → `ReservationController@adminIndex` → `admin.reservations.index`
  - `PATCH /admin/reservations/{reservation}/validate` → `ReservationController@validateReservation` → `admin.reservations.validate`
  - `PATCH /admin/reservations/{reservation}/reject` → `ReservationController@reject` → `admin.reservations.reject`
- Utilisateurs (admin):
  - Index: `GET /admin/utilisateurs` → `UtilisateurController@adminIndex` → `admin.utilisateurs.index`
  - Show/Edit/Update/Destroy/Toggle: routes `admin.utilisateurs.show|edit|update|destroy|toggle-status`
- Véhicules (admin):
  - Index: `GET /admin/vehicules` → `VehiculeController@adminIndex` → `admin.vehicules.index`
  - Approve: `PATCH /admin/vehicules/{vehicule}/approve` → `VehiculeController@approve` → `admin.vehicules.approve`
  - Reject: `PATCH /admin/vehicules/{vehicule}/reject` → `VehiculeController@reject` → `admin.vehicules.reject`
  - Resume (remettre en attente): `PATCH /admin/vehicules/{vehicule}/resume` → `VehiculeController@adminResume` → `admin.vehicules.resume`
- Notifications (alias): `GET /admin/notifications/vehicules` → `AdminController@notificationVehicule` → `admin.notifications.vehicules`

Middlewares:
- `auth:admin` → exige une session sur le guard `admin`.
- `admin` → `AdminMiddleware` vérifie `Auth::guard('admin')->user()->role === 'admin'`.

---

## 2) Contrôleurs Admin et actions

### 2.1 AdminController (`app/Http/Controllers/Admin/AdminController.php`)

- `dashboard()`
  - Calcule des statistiques: `total_utilisateurs`, `total_vehicules`, `total_reservations`, `total_offres`, etc.
  - Construit des collections: `$derniers_utilisateurs`, `$utilisateurs` (paginés), `$vehicules_en_attente`, `$tous_vehicules`, `$dernieres_reservations`, `$vehicules_par_statut`.
  - Vue: `resources/views/admin/dashboard.blade.php`
  - Variables utilisées dans la vue: `$stats`, `$utilisateurs_par_role`, `$derniers_utilisateurs`, `$utilisateurs`, `$vehicules_en_attente`, `$dernieres_reservations`, `$vehicules_par_statut`, `$tous_vehicules`.

- `notificationVehicule()`
  - Récupère les véhicules `statut = 'en_attente'` avec propriétaire.
  - Vue attendue: `resources/views/admin/notifications/vehicules.blade.php`
  - INCOHÉRENCE: le contrôleur passe `compact('vehicules')`, mais la vue lit `$vehiculesEnAttente`. À corriger (renommer la variable côté contrôleur ou côté vue).

- `validerVehicule($id)`
  - Met `statut = 'disponible'` sur le véhicule, envoie un email `VehiculeValideMail` au propriétaire.
  - Redirige `back()` avec un flash `success`. (Pas de JSON).

- `rejeterVehicule(Request $request, $id)`
  - Met `statut = 'rejete'` avec `motif_rejet`.
  - Redirige `back()` avec un flash `success`.

- Méthodes utilitaires `utilisateurs()`, `vehicules()`, `reservations()` renvoyant des vues `admin.*` (non utilisées par les routes actuelles du groupe qui s’appuient sur d’autres contrôleurs).

Contrat rapide – Validation/Rejet véhicule
- Entrée: `id` de véhicule; optionnel `motif_rejet` pour rejet.
- Sortie: redirection avec message flash; mise à jour du champ `statut`.
- Cas limites: véhicule inexistant, envoi mail qui échoue (message adapté).


### 2.2 OffreAgenceController (`app/Http/Controllers/Admin/OffreAgenceController.php`)

- `index()`
  - Liste paginée des `OffreVehicule` avec `vehicule` → vue `admin.offres.index`.
  - La vue affiche compte par statut et actions (voir/éditer/toggle/détruire).

- `create()`
  - Charge les véhicules appartenant à des admins et `disponible = true`.
  - Vue: `admin.offres.create` (formulaire avec aperçu côté client JS).

- `store(Request)`
  - Validation: véhicule, prix, dates, réduction, conditions.
  - Vérifie que le véhicule appartient bien à un admin.
  - Crée l’offre, `statut = active`, `created_by = Auth::id()`.
  - Redirige `admin.offres.index` avec flash success.

- `show(OffreVehicule $offre)` → vue `admin.offres.show` (non présente dans `resources/views/admin/offres/` actuellement; à ajouter si utilisée).

- `edit(OffreVehicule $offre)` → vue `admin.offres.edit` (non présente; à ajouter).

- `update(Request, OffreVehicule $offre)` → met à jour champs, redirige index.

- `destroy(OffreVehicule $offre)` → supprime et redirige index.

- `toggleStatus(OffreVehicule $offre)` → alterne `active/inactive`, redirige back avec flash.

Contrat rapide – Store/Update Offre
- Entrée: `vehicule_id`, `prix_par_jour`, `date_debut_offre`, `date_fin_offre`, etc.
- Sortie: redirection avec message; côté vue, pas de JSON.
- Cas limites: véhicule non admin, dates invalides, réduction hors bornes.


### 2.3 UtilisateurController (partie admin) (`app/Http/Controllers/UtilisateurController.php`)

- `adminIndex()`
  - Liste paginée avec `withCount(['reservations','vehicules'])`, stats agrégées.
  - Vue: `admin.utilisateurs.index` (utilise `$stats` et `$utilisateurs`).

- `adminShow(Utilisateur $utilisateur)`
  - Charge compte et listes limitées (5) de `vehicules` et `reservations`.
  - Vue: `admin.utilisateurs.show`.

- `adminEdit(Utilisateur $utilisateur)` → vue `admin.utilisateurs.edit`.

- `adminUpdate(Request, Utilisateur $utilisateur)`
  - Validation, hash conditionnel du password, `role` obligatoire.
  - Redirige index avec flash.

- `adminDestroy(Utilisateur $utilisateur)`
  - Supprime et redirige index.

- `toggleStatus($id)` (hors préfixe admin dans `web.php`, mais mappé en `admin.utilisateurs.toggle-status`)
  - Flip booléen `is_active` et redirige back.

Contrat rapide – Update user
- Entrée: `nom`, `prenom`, `email (unique)`, `telephone`, `role`, `password (optionnel)`.
- Sortie: redirection avec message.
- Cas limites: email dupliqué, rôle invalide, policy si nécessaire (non utilisée ici).


### 2.4 VehiculeController (partie admin) (`app/Http/Controllers/VehiculeController.php`)

- `adminIndex()`
  - Prépare 3 listes: `$vehiculesEnAttente`, `$vehiculesValides`, `$vehiculesRejetes` + `$stats`.
  - Vue: `admin.vehicules.index` qui affiche des onglets (en attente/validés/rejetés) et des modals.
  - Boutons d’action:
    - Approuver → `PATCH admin.vehicules.approve` (form `<form method="POST"> @method('PATCH')`)
    - Rejeter → `PATCH admin.vehicules.reject` (form)
    - Remettre en attente → `PATCH admin.vehicules.resume` (via JS sur la vue, route REST prête).

- `approve(Request, $id)`
  - Met `statut = 'disponible'` puis redirige `admin.dashboard` avec flash.

- `reject(Request, $id)`
  - Valide optionnel `motif_rejet`, met `statut = 'rejete'` + `motif_rejet`, redirige `admin.dashboard`.

- `adminResume(Request, $id)`
  - Remet `statut='en_attente'`, `motif_rejet = null`, redirige `admin.dashboard`.

Contrat rapide – Approve/Reject/Resume
- Entrée: id de véhicule, (motif_rejet).
- Sortie: redirection avec message; pas de JSON.
- Cas limites: véhicule inexistant, statut déjà identique (idempotence ok, pas d’erreur).


### 2.5 ReservationController – INCOHÉRENCE (`app/Http/Controllers/ReservationController.php`)

Les routes admin attendues dans `web.php` :
- `adminIndex`, `validateReservation`, `reject` (admin context)

Mais le contrôleur présent ne définit que les actions « utilisateur » standard: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`. Il n’y a pas d’implémentation de:
- `adminIndex()`
- `validateReservation(Reservation $reservation)`
- `reject(Reservation $reservation)` (attention: conflit de nom avec `VehiculeController@reject` mais namespaces/paths différents; au niveau `Route` c’est OK, au niveau code c’est une autre méthode à créer ici.)

Recommandation d’implémentation (contrat proposé):
- `adminIndex()` → lister toutes les réservations (avec `with(['vehicule','utilisateur'])`), tri desc, pagination; vue dédiée `admin.reservations.index` (à créer), ou réutiliser un onglet dans `admin.dashboard`.
- `validateReservation(Reservation $reservation)` → passer `statut='confirmee'` si éligible; rediriger back avec flash.
- `reject(Reservation $reservation)` → passer `statut='rejete'` et optionnel `motif` via `$request`; rediriger back.

---

## 3) Détails des vues et boutons côté Admin

### 3.1 Dashboard Admin (`resources/views/admin/dashboard.blade.php`)
- Utilise les variables du `AdminController@dashboard`.
- Onglets: Overview, Utilisateurs, Véhicules, Réservations, Validation.
- Boutons d’action Véhicules (dans onglets « Véhicules » et « Validation »):
  - Approuver → form `PATCH admin.vehicules.approve`
  - Rejeter → form `PATCH admin.vehicules.reject` (avec champ `motif_rejet` modal dans certaines vues)
- Important: ces actions renvoient des redirections avec flash (pas JSON).

### 3.2 Notifications véhicules (`resources/views/admin/notifications/vehicules.blade.php`)
- Utilise la variable `$vehiculesEnAttente` (incohérente avec le contrôleur qui fournit `$vehicules`).
- Bouton "Valider" utilise un `fetch PATCH /admin/vehicules/{id}/approve` et attend une réponse JSON `{ success: true }` → INCOHÉRENCE: les contrôleurs renvoient des redirections HTML.

Solution: deux options
- A) Harmoniser vue → utiliser des `<form method="POST"> @method('PATCH')` comme dans le dashboard (et supprimer le JS fetch).
- B) Harmoniser contrôleurs → détecter `expectsJson()` et renvoyer `return response()->json(['success'=>true])` en cas de requête AJAX.

### 3.3 Offres d’agence
- `resources/views/admin/offres/index.blade.php`
  - Affiche stats par statut et liste des offres.
  - Actions: Voir (`admin.offres.show`), Modifier (`admin.offres.edit`), Toggle (`admin.offres.toggle-status` via `PATCH`), Supprimer (`DELETE`).
  - INCOHÉRENCE: vues `show` et `edit` ne sont pas présentes dans le repo → si utilisées, à créer; sinon, retirer les liens ou les ajouter.

- `resources/views/admin/offres/create.blade.php`
  - Formulaire complet avec aperçu JS.
  - Champs: `vehicule_id`, `prix_par_jour`, `reduction_pourcentage`, `date_debut_offre`, `date_fin_offre`, `description_offre`, `conditions_speciales`.

### 3.4 Utilisateurs
- `resources/views/admin/utilisateurs/index|show|edit.blade.php`
  - Index: badge stats + tableau paginé, actions Voir/Editer/Supprimer (selon rôle).
  - Show: résumé + derniers véhicules/réservations.
  - Edit: formulaire basique, méthode `PATCH` vers `admin.utilisateurs.update`.

### 3.5 Véhicules (catalogue admin)
- `resources/views/admin/vehicules/index.blade.php`
  - 3 onglets (en attente, validés, rejetés).
  - Boutons d’action via formulaires ou JS (remettre en attente en PATCH `/admin/vehicules/{id}/resume`).
  - Idem : contrôleurs renvoient redirections; le JS attend parfois JSON.

---

## 4) Incohérences et correctifs rapides recommandés

1) Notifications véhicules – variable
- Contrôleur envoie `$vehicules` mais la vue lit `$vehiculesEnAttente`.
- Corriger le contrôleur pour `return view('admin.notifications.vehicules', ['vehiculesEnAttente' => $vehicules]);`

2) Notifications véhicules – réponse JSON
- La vue appelle `fetch(… PATCH …)` et `.then(response => response.json())`, mais `VehiculeController@approve` renvoie une redirection.
- Solutions:
  - Adapter contrôleur pour renvoyer JSON si `request()->expectsJson()`.
  - Ou remplacer le `fetch` par un formulaire standard (comme dans le dashboard).

3) ReservationController – méthodes admin manquantes
- Implémenter `adminIndex`, `validateReservation`, `reject` pour correspondre aux routes admin.
- Ajouter la vue `resources/views/admin/reservations/index.blade.php` si affichage dédié.

4) Offres – vues `show` et `edit` manquantes
- Créer `resources/views/admin/offres/show.blade.php` et `edit.blade.php` ou retirer les liens depuis l’index.

---

## 5) Contrats (inputs/outputs) – résumé

- Approver véhicule (PATCH `/admin/vehicules/{id}/approve`)
  - Entrée: id, CSRF token.
  - Sortie: redirection `admin.dashboard` + flash success.
  - Erreurs: id inexistant → 404; autres exceptions → message flash.

- Rejeter véhicule (PATCH `/admin/vehicules/{id}/reject`)
  - Entrée: id, `motif_rejet` (optionnel).
  - Sortie: redirection + flash.

- Toggle offre (PATCH `/admin/offres/{offre}/toggle-status`)
  - Entrée: id offre.
  - Sortie: redirection back + flash (active/inactive).

- Editer utilisateur (PATCH `/admin/utilisateurs/{utilisateur}`)
  - Entrée: nom, prénom, email unique, rôle, password optionnel.
  - Sortie: redirection index + flash.

- Réservations (admin) – à implémenter
  - `validateReservation`: statut `confirmee`.
  - `reject`: statut `rejete`, message optionnel.
  - Sorties: redirection + flash.

---

## 6) Références rapides

- Routes: `routes/web.php`
- Admin middleware alias: `bootstrap/app.php`
- Middleware: `app/Http/Middleware/AdminMiddleware.php`
- Contrôleurs admin:
  - `app/Http/Controllers/Admin/AdminController.php`
  - `app/Http/Controllers/Admin/OffreAgenceController.php`
  - `app/Http/Controllers/UtilisateurController.php` (méthodes admin*)
  - `app/Http/Controllers/VehiculeController.php` (méthodes admin*)
  - `app/Http/Controllers/ReservationController.php` (méthodes admin à ajouter)
- Vues admin:
  - `resources/views/admin/dashboard.blade.php`
  - `resources/views/admin/notifications/vehicules.blade.php`
  - `resources/views/admin/offres/*.blade.php`
  - `resources/views/admin/utilisateurs/*.blade.php`
  - `resources/views/admin/vehicules/index.blade.php`

---

## 7) Prochaines étapes

- Si tu valides cette partie, je passe à la Partie 3 (Vues Admin détaillées: champs, boutons, variables passées, comportements JS, et corrections ciblées des incohérences avec propositions de patch minimal).
- Si tu veux, je peux aussi directement proposer les patchs pour:
  1. Corriger la variable des notifications (`$vehicules` → `$vehiculesEnAttente`).
  2. Harmoniser les réponses JSON/redirects.
  3. Ajouter les méthodes admin manquantes dans `ReservationController` + la vue index admin des réservations.
