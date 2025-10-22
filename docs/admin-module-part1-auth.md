# Module Admin – Partie 1 : Authentification et Contrôle d’accès

Cette première partie du rapport explique en détail comment l’authentification « administrateur » fonctionne dans votre projet, quels fichiers sont impliqués, le rôle de chaque variable/route/middleware, et comment les boutons et formulaires interagissent.

---

## Objectif de cette partie
- Permettre aux administrateurs de se connecter via un guard dédié (`admin`) sans interférer avec la session utilisateur classique (`web`).
- Protéger toutes les pages du module admin via un middleware d’autorisation (`admin`).
- Rediriger les comptes « admin » vers le dashboard d’administration.

## Vue d’ensemble (schéma logique)
1. L’admin arrive sur l’URL de login admin: `/admin/login`.
2. Il soumet son email/mot de passe.
3. Si ses identifiants sont valides et que son rôle est `admin`, on l’authentifie via le guard `admin`.
4. On le redirige vers `route('admin.dashboard')`.
5. Toutes les routes admin sont protégées par `['auth:admin', 'admin']`.

---

## Les composants clés et leurs rôles

### 1) Configuration d’authentification
- Fichier: `config/auth.php`
  - Guards:
    - `web`: guard par défaut pour les utilisateurs classiques (provider `users`).
    - `admin`: guard dédié aux administrateurs (provider `users` aussi) – permet d’avoir une session d’admin distincte.
  - Provider `users` → modèle: `App\Models\Utilisateur`.

Points importants:
- Avoir un guard `admin` distinct permet, par exemple, qu’un admin reste connecté en même temps qu’un utilisateur « web » dans le même navigateur (sessions séparées).

### 2) Middleware d’autorisation admin
- Fichier: `app/Http/Middleware/AdminMiddleware.php`
  - Vérifie d’abord qu’il y a bien une session active sur le guard `admin`:
    - `Auth::guard('admin')->check()` sinon redirection vers `route('admin.login')` avec un message d’erreur.
  - Vérifie que l’utilisateur authentifié a `role === 'admin'`.
  - Laisse passer la requête sinon déclenche un `abort(403)`.
- Déclaration de l’alias du middleware:
  - Fichier: `bootstrap/app.php`
  - Alias: `'admin' => \App\Http\Middleware\AdminMiddleware::class`.

Conséquence:
- On utilise à la fois `auth:admin` (authentification via le guard admin) et `admin` (autorisation par rôle) pour bien verrouiller toutes les routes admin.

### 3) Routes d’authentification
- Fichier: `routes/auth.php`

Routes « utilisateur classique » (guard `web`) sous `Route::middleware('guest')`:
- `GET /login` → `AuthenticatedSessionController@create` → vue `auth.login`.
- `POST /login` → `AuthenticatedSessionController@store`.

Routes « admin » (accessibles même si un utilisateur `web` est connecté):
- `GET /admin/login` → `AuthenticatedSessionController@createAdmin` → vue `auth.login` (avec variable `isAdmin`). Nom: `admin.login`.
- `POST /admin/login` → `AuthenticatedSessionController@storeAdmin`. Nom: `admin.login.store`.

Déconnexion admin:
- `POST /admin/logout` (protégée par `auth:admin`) → logout uniquement du guard `admin`. Nom: `admin.logout`.

### 4) Routes protégées du module Admin
- Fichier: `routes/web.php`

Routes:
- `GET /admin` → `AdminController@dashboard` → Nom `admin.dashboard` → Middleware `['auth:admin', 'admin']`.
- Groupes admin (préfixe `admin`, name `admin.`) protégés par `['auth:admin', 'admin']` pour toutes les pages internes (offres, réservations, utilisateurs, véhicules, etc.).

Note: Il existe une route `GET /redirect-after-login` protégée par `auth` (guard par défaut `web`) qui tente de rediriger selon `Auth::user()->role`. Cette route est utile pour les connexions « web ». Pour les admins, la redirection après login se fait déjà via `store`/`storeAdmin`.

### 5) Contrôleur d’authentification
- Fichier: `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

Actions:
- `create()` → montre la vue `auth.login` (login classique).
- `store(Request)` → logique de connexion:
  - Valide email/password.
  - Charge `Utilisateur` (par email) et vérifie le hash du mot de passe.
  - Si `role === 'admin'` → connexion via `Auth::guard('admin')->login($user, remember)` + `redirect()->intended(route('admin.dashboard'))`.
  - Sinon tentative standard via `Auth::guard('web')->attempt(...)` + `redirect()->intended(route('dashboard'))`.
- `createAdmin()` → montre la vue `auth.login` avec `['isAdmin' => true]`.
- `storeAdmin(Request)` → tente une connexion via `Auth::guard('admin')->attempt(...)` + redirection vers `admin.dashboard`.
- `destroy(Request)` → déconnexion du guard `web` seulement. Si une session `admin` existe, la session n’est pas invalidée entièrement (l’admin reste connecté).

Variables importantes:
- `$request->boolean('remember')` → gère l’option « Se souvenir de moi ».
- `$user->role` → détermine si on connecte via le guard `admin` (si `admin`) ou le guard `web`.

### 6) Vue de connexion (Blade)
- Fichier: `resources/views/auth/login.blade.php`

Boutons et comportements:
- Le formulaire choisit dynamiquement son action:
  - Si la vue reçoit `isAdmin = true`, le `action` est `route('admin.login.store')`.
  - Sinon, le `action` est `route('login')`.
- Champs:
  - `email` (avec gestion d’erreurs `@error('email') ... @enderror`).
  - `password` (avec gestion d’erreurs `@error('password') ... @enderror`).
  - Checkbox `remember` (lié à `$request->boolean('remember')`).
- Bouton « Se connecter » (soumission du formulaire).
- Liens d’aide:
  - « Mot de passe oublié ? » → `route('password.request')`.
  - « Créer un compte » → `route('register')` (pas utilisé pour les admins).

Astuce UI:
- Vous pouvez créer un bouton « Connexion Admin » sur la page d’accueil qui pointe vers `route('admin.login')` pour accéder directement au mode admin.

### 7) Vue Dashboard Admin (exemple d’usage du guard)
- Fichier: `resources/views/admin/dashboard.blade.php`
  - Affiche dans l’entête: `{{ optional(Auth::guard('admin')->user())->prenom }} {{ optional(Auth::guard('admin')->user())->nom }}`.
  - Cette récupération via `Auth::guard('admin')` garantit qu’on lit bien la session admin, pas la session web.

---

## Contrat fonctionnel et cas limites

Entrées/Sorties attendues:
- Entrée: email + mot de passe (formulaire de `auth.login`).
- Sortie: redirection vers `/admin` si `role=admin`, sinon vers `/dashboard`.

Cas limites:
- Identifiants invalides → message d’erreur affiché sous le champ `email`.
- Compte non-admin tentant d’aller sur `/admin` → bloqué par `auth:admin` puis `admin` → redirection vers `/admin/login` ou erreur 403 selon les cas.
- Utilisateur `web` déjà connecté qui ouvre `/admin/login` → possible (sessions séparées). Pas de conflit de session.
- Déconnexion « utilisateur web » ne doit pas déconnecter l’admin (géré dans `destroy`).

Vérifications rapides (manuel):
1. Aller sur `/admin/login`, se connecter avec un compte `role=admin` → on arrive sur `/admin`.
2. Aller directement sur `/admin` sans être admin → redirection vers `/admin/login` (ou 403 si connecté mais pas admin).
3. Se connecter en tant qu’utilisateur « web » classique → redirection `/dashboard`. Tenter `/admin` → refusé.

---

## Références précises de fichiers
- Config: `config/auth.php`
- Middleware alias: `bootstrap/app.php`
- Middleware: `app/Http/Middleware/AdminMiddleware.php`
- Routes d’auth: `routes/auth.php`
- Routes admin: `routes/web.php`
- Contrôleur d’auth: `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- Vue login: `resources/views/auth/login.blade.php`
- Vue dashboard admin: `resources/views/admin/dashboard.blade.php`

---

## Export en PDF (rapide)
Plusieurs options selon vos outils:
- VS Code (extension « Markdown PDF ») → Ouvrir ce fichier → clic droit → « Markdown PDF: Export (pdf) ».
- Navigateur → Ouvrir le Markdown avec une preview → Imprimer (Ctrl+P) → Destination: « Enregistrer au format PDF ».
- Ligne de commande (optionnel) avec Pandoc:
  - `pandoc docs/admin-module-part1-auth.md -o docs/admin-module-part1-auth.pdf`

---

## Conclusion
Cette mise en place sépare proprement l’authentification admin (guard `admin`) de l’authentification utilisateur (`web`) et verrouille l’accès via un middleware dédié. Dites-moi si cette partie est validée. Si oui, je passe à la Partie 2 (cartographie des routes admin et détail des contrôleurs/actions).