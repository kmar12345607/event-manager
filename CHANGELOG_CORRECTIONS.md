# Corrections apportées au projet Event Manager

## Bugs critiques corrigés

1. **Routes admin sans préfixe `admin.`**
   - Tous les `route('events.*')` → `route('admin.events.*')`
   - Tous les `route('participants.*')` → `route('admin.participants.*')`
   - `route('profile.*')` → `route('admin.profile.*')` (contexte admin)
   - Fichiers touchés : EventController, ParticipantController, ProfileController,
     toutes les vues events/*, participants/*, dashboard.blade.php, profile/*

2. **Layout admin corrompu** (`resources/views/layouts/app.blade.php`)
   - Contenait par erreur le contenu de la page "participants" au lieu du vrai layout
   - Reconstruit : sidebar navy + topbar + styles, avec `@yield('content')`,
     `@yield('page-title')`, `@yield('page-sub')`, `@yield('page-actions')`
   - `dashboard.blade.php` migré de page HTML autonome vers `@extends('layouts.app')`
   - `profile/edit.blade.php` migré de `<x-app-layout>` (cassé) vers le même layout

3. **Vues manquantes créées**
   - `resources/views/participant/dashboard.blade.php` (liste des inscriptions)
   - `resources/views/participant/profile.blade.php` (fiche profil participant)

4. **Redirections cachées vers `route('dashboard')` (route inexistante)**
   - Corrigées dans : EmailVerificationNotificationController, VerifyEmailController,
     EmailVerificationPromptController, ConfirmablePasswordController
   - Redirection désormais conditionnelle : `admin.dashboard` ou `participant.dashboard`
     selon `auth()->user()->isAdmin()`

5. **Liens "Admin/Dashboard" dans le site public**
   - `layouts/public.blade.php` et `public/home.blade.php` redirigent maintenant
     vers le bon espace selon le rôle de l'utilisateur connecté

6. Suppression de `layouts/navigation.blade.php` (fichier Breeze orphelin, non utilisé,
   contenait aussi des routes cassées)

7. Cache de vues compilées (`storage/framework/views/*.php`) vidé

## À faire après réception de ces fichiers

```bash
php artisan view:clear
php artisan config:clear
php artisan migrate:fresh --seed   # si tu veux repartir sur les seeders
php artisan serve
```

Puis teste : connexion admin → dashboard → créer événement → inscrire participant →
gérer présence → export CSV → déconnexion → inscription participant public → connexion
participant → mon-espace / mon-profil.
