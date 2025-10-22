# Middlewares – locationVoiture

Ce document recense et explique tous les middlewares utilisés dans l’application, comment ils sont câblés et où ils s’appliquent.

## carte rapide

- Personnalisé
  - `admin` → App\Http\Middleware\AdminMiddleware
- Fournis par Laravel (utilisés dans les routes)
  - `auth` (guard web)
  - `auth:admin` (guard admin)
  - `guest`, `guest:admin`
  - `signed`
  - `throttle:6,1`
  - (Confirm password via contrôleurs d’auth Laravel)
- Groupe implicite `web` (sessions, CSRF, etc.)

---

## middleware personnalisé: `admin`

- Fichier: `app/Http/Middleware/AdminMiddleware.php`
- Alias (déclaration): `bootstrap/app.php`
  ```php
  $middleware->alias([
      'admin' => \App\Http\Middleware\AdminMiddleware::class,
  ]);
  ```
- Rôle:
  - Vérifie `Auth::guard('admin')->check()` sinon redirige vers `route('admin.login')` avec un flash d’erreur
  - Vérifie `user()->role === 'admin'` sinon `abort(403)`
- Usage:
  - Toutes les routes admin combinent `['auth:admin', 'admin']`

---

## middlewares Laravel utilisés dans les routes

- `auth`
  - Protège les routes utilisateur (guard web)
  - Redirige vers login si non authentifié
- `auth:admin`
  - Protège les routes admin (guard admin)
  - Utilisé conjointement avec `admin`
- `guest` / `guest:admin`
  - Empêchent l’accès aux pages de login/inscription si déjà connecté (respectivement sur guard web ou admin)
- `signed`
  - Exige une URL signée (vérification d’email)
- `throttle:6,1`
  - Limite de débit (6 requêtes/minute) sur les endpoints d’email verification
- Confirmation mot de passe
  - Géré par les contrôleurs d’auth (`ConfirmablePasswordController`) sur `confirm-password`

Références principales: `routes/web.php`, `routes/auth.php`.

---

## groupe `web` (implicite) et implications

Les routes Web (y compris admin) utilisent la pile `web` standard de Laravel (sessions, cookies, CSRF, etc.):
- Sessions et flash messages (ex. `with('success', ...)`)
- Protection CSRF via `VerifyCsrfToken`
- Partage des erreurs de validation et old input
- Route Model Binding (`SubstituteBindings`)

Implications pratiques:
- Formulaires POST/PUT/PATCH/DELETE doivent inclure `@csrf` et `@method('...')` si besoin
- Requêtes AJAX doivent inclure l’en-tête `X-CSRF-TOKEN` (valeur issue de `<meta name="csrf-token">`)

---

## erreurs courantes et correctifs

- 419 "Page Expired"
  - Causes: absence de `@csrf`, méthode HTTP non spoofée (`@method('DELETE'|'PATCH')`), fetch/AJAX sans `X-CSRF-TOKEN`
  - Correctif: utiliser des formulaires Blade avec `@csrf` + `@method(...)` ou ajouter l’en-tête `X-CSRF-TOKEN` côté JS

---

## mapping routes → middlewares

- Utilisateur (non-admin)
  - Groupes `Route::middleware(['auth'])->group(...)` → guard web + pile `web`
  - Vérification email → `auth` + `signed` + `throttle`
- Admin
  - `/admin` et `/admin/...` → `auth:admin` + `admin` + pile `web`
- Authentification
  - User: `guest` pour register/login
  - Admin: `guest:admin` pour `/admin/login` et POST `/admin/login`
  - Logout admin dédié: `Route::middleware('auth:admin')->post('admin/logout', ...)`

---

## ajouter un nouveau middleware: étapes

1) Créer la classe: `app/Http/Middleware/MonMiddleware.php`
2) Déclarer l’alias: `bootstrap/app.php`
   ```php
   $middleware->alias([
       'mon-middleware' => \App\Http\Middleware\MonMiddleware::class,
   ]);
   ```
3) L’appliquer
   - Sur une route: `->middleware('mon-middleware')`
   - Sur un groupe: `Route::middleware(['mon-middleware'])->group(...)`

---

## extraits utiles

- Exemple route admin protégée:
  ```php
  Route::middleware(['auth:admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {
      Route::get('/vehicules', [VehiculeController::class, 'adminIndex'])->name('vehicules.index');
  });
  ```

- Exemple formulaire DELETE (évite 419):
  ```blade
  <form action="{{ route('admin.vehicules.destroy', $vehicule) }}" method="POST">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">Supprimer</button>
  </form>
  ```
