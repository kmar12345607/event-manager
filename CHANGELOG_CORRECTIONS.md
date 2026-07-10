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

## Deuxième passe de corrections (audit complet du 07/07/2026)

8. **Dashboard admin affichait la mauvaise page** (`resources/views/dashboard.blade.php`)
   - Le fichier contenait par erreur une copie de l'espace participant ("Mon espace",
     liste d'inscriptions) au lieu du vrai tableau de bord admin.
   - `DashboardController` calculait bien `$stats` (total événements, participants,
     taux de présence) et `$recentEvents`, mais rien n'utilisait ces variables.
   - Reconstruit avec `@extends('layouts.app')` et les cartes statistiques
     (`.stat-card`) déjà stylées dans le layout mais jamais utilisées, + tableau des
     événements récents.
   - Supprimé le contournement `->with('inscriptions', collect())` dans
     `DashboardController` (devenu inutile).

9. **Page admin "détail événement" affichait la page publique** (`resources/views/events/show.blade.php`)
   - Le fichier était une copie quasi identique de `public/show.blade.php` (formulaire
     d'inscription public, style hero, etc.), utilisant `$event->participants_count`.
   - Or `EventController::show()` fournit `$event` **et** `$participants` (liste
     paginée) pour permettre à l'admin de gérer les inscrits d'un événement — variable
     jamais utilisée par l'ancienne vue.
   - Reconstruite comme une vraie page admin (`@extends('layouts.app')`) : infos de
     l'événement, barre de progression du remplissage, tableau des participants avec
     changement rapide du statut de présence, boutons modifier/supprimer, lien
     "Inscrire un participant" et bouton d'export CSV.

10. **Changement de présence sans interface** — la route `admin.participants.attendance`
    et `ParticipantController::updateAttendance()` existaient déjà côté backend mais
    n'étaient appelées par aucune vue (le seul moyen de changer le statut était le
    formulaire d'édition complet). Ajout d'un sélecteur à mise à jour instantanée
    (`onchange="this.form.submit()"`) dans `participants/index.blade.php` et dans la
    nouvelle page `events/show.blade.php`.

11. **Fichiers morts supprimés**
    - `resources/views/layouts/navigation.blade.php` (résidu Breeze non inclus nulle
      part, contenait encore des `route('dashboard')` cassés — le changelog précédent
      annonçait sa suppression mais le fichier était resté dans l'archive).
    - `app/Http/Controllers/UserAccountController.php` (doublon plus ancien et non
      utilisé de `UserController`, référençait des vues `admin.users.*` inexistantes).

12. **Seeders non idempotents** (`EventSeeder`, `ParticipantSeeder`) — un simple
    `DB::table(...)->insert()` sans purge préalable créait des doublons à chaque
    nouveau `php artisan db:seed` (visible dans le dump SQL fourni : événements et
    participants dupliqués avec de nouveaux ID). Les deux seeders vident maintenant
    leur table avant d'insérer, pour rester rejouables sans `migrate:fresh`.

## Troisième passe — Guide interactif sur toute la front office (07/07/2026)

13. **Nouveau fichier** `resources/views/partials/tour-widget.blade.php` : bouton d'aide
    flottant + Intro.js, factorisé pour être inclus (`@include('partials.tour-widget')`)
    sur les pages qui n'utilisent pas `layouts/public.blade.php` (elles ont leur propre
    `<html>`).

14. **Guide ajouté sur** : accueil (déjà présent), détail événement + inscription,
    mon espace, mon profil, connexion, création de compte, mot de passe oublié,
    réinitialisation du mot de passe.

15. **Bug corrigé** dans `auth/login.blade.php` : balise `</body>` dupliquée en fin de
    fichier (invalide en HTML, sans conséquence visible mais corrigé).

16. **`auth/forgot-password.blade.php` et `auth/reset-password.blade.php` reconstruites**
    — elles étaient restées au design par défaut de Laravel Breeze (texte en anglais,
    Tailwind générique), en décalage complet avec le reste du site (français, Bootstrap,
    palette bleu marine). Reconstruites dans le même style que les pages
    connexion/inscription, avec guide intégré.

17. **`auth/confirm-password.blade.php` et `auth/verify-email.blade.php` non modifiées** —
    elles sont accessibles par URL directe mais **ne sont déclenchées par aucun flux réel**
    de l'application (aucune route n'utilise les middlewares `password.confirm` ou
    `verified`, et `User` n'implémente pas `MustVerifyEmail`). Elles restent au design
    Breeze par défaut ; à traiter uniquement si tu actives un jour la vérification d'email.

**Comportement du guide** : lancement automatique une seule fois par page (mémorisé dans
le navigateur), relançable à tout moment via le bouton rond "?" en bas à droite de chaque
page.

Le fichier `.env` fourni contient un vrai mot de passe d'application Gmail
(`MAIL_PASSWORD`) pour l'envoi des emails de réinitialisation. Il n'est pas suivi par
Git (`.gitignore` l'exclut bien), mais comme il a été partagé dans cette conversation,
il est recommandé de révoquer ce mot de passe d'application dans les paramètres du
compte Google et d'en régénérer un nouveau avant la soutenance.
