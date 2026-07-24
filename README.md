# Event Registration & Participant Management Platform

Plateforme web de gestion des inscriptions aux événements et du suivi des participants.

## Table des matières

- [À propos du projet](#à-propos-du-projet)
- [Contexte et périmètre](#contexte-et-périmètre)
- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Architecture du projet](#architecture-du-projet)
- [Modèle de données](#modèle-de-données)
- [Installation](#installation)
- [Configuration](#configuration)
- [Jeu de données fictif](#jeu-de-données-fictif)
- [Utilisation](#utilisation)
- [Captures d'écran](#captures-décran)
- [Planning du projet](#planning-du-projet)
- [Livrables](#livrables)
- [Informations sur le stage](#informations-sur-le-stage)

## À propos du projet

Event Registration & Participant Management Platform est une application web développée dans le but de simplifier la gestion des événements et le suivi de leurs participants.

L'application permet à un administrateur de :

- Créer et gérer des événements
- Inscrire des participants à ces événements
- Suivre leur présence
- Visualiser des statistiques globales depuis un tableau de bord

Le projet a été conçu comme une solution simple, claire et facilement maintenable, destinée à des organisations souhaitant gérer leurs événements sans dépendre d'outils complexes ou payants.

## Contexte et périmètre

Ce projet est développé dans un cadre académique, avec un objectif de prototype fonctionnel. Le périmètre a été volontairement limité.

Inclus dans le projet :

- Gestion complète des événements (création, modification, suppression, listing)
- Gestion complète des participants (création, modification, suppression, listing)
- Suivi de présence
- Statistiques de base sur le tableau de bord
- Export CSV des participants
- Données fictives générées via seeders

Hors périmètre :

- Connexion à un système de paiement réel
- Intégration à des plateformes d'événements externes
- Notifications push ou SMS

> **Note d'évolution du périmètre** : le cahier des charges initial excluait l'envoi d'emails réels et une authentification multi-rôles avancée. En cours de développement, ces deux points ont finalement été implémentés (authentification Laravel Breeze avec rôles admin/participant, vérification d'email, et envoi de vrais emails de confirmation via SMTP Gmail) afin de rendre le prototype de check-in par QR code réellement testable de bout en bout. Voir la section [Fonctionnalités avancées](#fonctionnalités-avancées-ajoutées-hors-cahier-des-charges-initial) ci-dessous.

## Fonctionnalités

### Gestion des événements

- Formulaire de création d'un événement
- Page de listing de tous les événements
- Modification et suppression d'un événement
- Gestion du statut de l'événement (actif / annulé / terminé)

### Gestion des participants

- Formulaire d'inscription d'un participant à un événement
- Listing des participants avec recherche (par nom, email)
- Modification et suppression d'un participant
- Vérification du nombre maximum de places disponibles

### Suivi de présence

- Gestion du statut de présence : inscrit / présent / absent
- Mise à jour rapide du statut depuis la liste des participants
- Vue filtrée par événement

### Tableau de bord

- Nombre total d'événements créés
- Nombre total de participants inscrits
- Taux de présence global
- Export de la liste des participants au format CSV (optionnel)

## Fonctionnalités avancées ajoutées (hors cahier des charges initial)

En plus des exigences du cahier des charges, les fonctionnalités suivantes ont été ajoutées pour renforcer le prototype :

- **Authentification et rôles** : inscription/connexion (Laravel Breeze), deux rôles (`admin`, `participant`), middleware d'accès dédié au back-office
- **Vérification d'email** : obligatoire à l'inscription (`MustVerifyEmail`)
- **Billetterie QR code** : génération d'un `ticket_code` unique par participant, scanner de check-in (`html5-qrcode`) côté admin, horodatage `checked_in_at`
- **Emails réels** : confirmation d'inscription et de check-in envoyés via SMTP Gmail
- **Espace participant** : tableau de bord et profil dédiés aux participants connectés
- **API JSON interne** : endpoints `admin/api/*` pour événements, participants et statistiques
- **Visites guidées** : tours interactifs Intro.js sur les interfaces front-office et back-office

## Stack technique

| Couche | Technologies |
|---|---|
| Frontend | HTML5, CSS3, JavaScript, Bootstrap (optionnel), Blade |
| Backend | Laravel (PHP), Eloquent ORM |
| Base de données | MySQL ou SQLite |
| Export | CSV |
| Outils | Git, GitHub, Composer, npm |

## Architecture du projet

```
projet/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── EventController.php
│   │   │   └── ParticipantController.php
│   │   └── Requests/
│   └── Models/
│       ├── Event.php
│       └── Participant.php
├── database/
│   ├── migrations/
│   │   ├── create_events_table.php
│   │   └── create_participants_table.php
│   └── seeders/
│       ├── EventSeeder.php
│       └── ParticipantSeeder.php
├── resources/
│   └── views/
│       ├── events/
│       ├── participants/
│       └── dashboard/
├── routes/
│   └── web.php
├── .env.example
└── README.md
```

## Modèle de données

### Table events

| Champ | Type | Description |
|---|---|---|
| id | bigint (PK) | Identifiant unique |
| name | string | Nom de l'événement |
| date | date | Date de l'événement |
| location | string | Lieu de l'événement |
| description | text | Description détaillée |
| max_participants | integer | Nombre maximum de participants autorisés |
| status | enum | Statut : actif / annulé / terminé |
| created_at / updated_at | timestamp | Horodatage Laravel |

### Table participants

| Champ | Type | Description |
|---|---|---|
| id | bigint (PK) | Identifiant unique |
| ticket_code | string (nullable, unique) | Code unique du billet QR (ajouté avec la billetterie) |
| event_id | bigint (FK) | Référence vers l'événement (events.id) |
| full_name | string | Nom complet du participant |
| email | string | Adresse email |
| phone | string (nullable) | Numéro de téléphone |
| registration_date | date | Date d'inscription |
| attendance_status | enum | registered / present / absent |
| checked_in_at | timestamp (nullable) | Horodatage du scan du billet (check-in QR) |
| notes | text (nullable) | Notes complémentaires |
| created_at / updated_at | timestamp | Horodatage Laravel |

### Table users

| Champ | Type | Description |
|---|---|---|
| id | bigint (PK) | Identifiant unique |
| name | string | Nom de l'utilisateur |
| email | string (unique) | Adresse email |
| role | enum | admin / participant |
| email_verified_at | timestamp (nullable) | Date de vérification de l'email |
| password | string | Mot de passe haché |
| remember_token | string (nullable) | Jeton "se souvenir de moi" |
| created_at / updated_at | timestamp | Horodatage Laravel |

Relations : un événement peut avoir plusieurs participants (un-à-plusieurs). La table `users` est indépendante de `participants` (l'inscription à un événement ne crée pas nécessairement de compte utilisateur).

```php
// Event.php
public function participants()
{
    return $this->hasMany(Participant::class);
}

// Participant.php
public function event()
{
    return $this->belongsTo(Event::class);
}
```

## Installation

### Prérequis

- PHP >= 8.1
- Composer
- MySQL ou SQLite
- Node.js et npm (si utilisation de Bootstrap/JS via npm)

### Étapes

```bash
# Cloner le repository
git clone <url-du-repo>
cd <nom-du-dossier>

# Installer les dépendances PHP
composer install

# Copier le fichier d'environnement
cp .env.example .env
php artisan key:generate

# Installer les dépendances front-end (optionnel)
npm install
npm run dev

# Lancer le serveur de développement
php artisan serve
```

L'application est ensuite accessible à l'adresse : http://localhost:8000

## Configuration

Configurer la connexion à la base de données dans le fichier .env :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=
```

Pour utiliser SQLite à la place : définir DB_CONNECTION=sqlite et créer le fichier database/database.sqlite.

> Note : le seeder `EventSeeder` utilise une commande `SET FOREIGN_KEY_CHECKS` spécifique à MySQL/MariaDB. En environnement SQLite, ces lignes doivent être retirées avant de lancer `db:seed`. L'usage de MySQL/MariaDB reste recommandé (c'est l'environnement utilisé pendant tout le développement).

Pour l'envoi d'emails réels (confirmation d'inscription, check-in par QR code), configurer un compte Gmail avec mot de passe d'application dans `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre_adresse@gmail.com
MAIL_PASSWORD=votre_mot_de_passe_application
MAIL_ENCRYPTION=tls
```

Lancer les migrations pour créer les tables :

```bash
php artisan migrate
```

## Jeu de données fictif

Le projet contient des seeders Laravel permettant de générer automatiquement des événements et participants fictifs, utilisés uniquement à des fins de démonstration et de test.

```bash
php artisan migrate --seed
```

Pour réinitialiser complètement la base avec de nouvelles données :

```bash
php artisan migrate:fresh --seed
```

Toutes les données générées sont fictives. Aucune donnée réelle de paiement, d'utilisateur ou d'événement externe n'est utilisée dans ce projet.

## Utilisation

1. Accéder au tableau de bord (/dashboard) pour visualiser les statistiques globales
2. Créer un nouvel événement via /events/create
3. Consulter la liste des événements via /events
4. Inscrire un participant à un événement via /participants/create
5. Gérer le statut de présence depuis la liste des participants d'un événement
6. Exporter la liste des participants au format CSV (optionnel)

## Comptes de démonstration

Après `php artisan db:seed`, deux comptes sont disponibles (mot de passe : `password`) :

| Rôle | Email | Usage |
|---|---|---|
| Admin | admin@eventmanager.tn | Accès au back-office (/admin/dashboard) |
| Participant | participant@eventmanager.tn | Accès à l'espace participant (/mon-espace) |

## Captures d'écran

Les captures ci-dessous illustrent les pages principales de l'application. Pour les régénérer :

1. Lancer le serveur : `php artisan serve`
2. Se connecter avec le compte admin ci-dessus
3. Prendre une capture (Cmd+Shift+4 sur Mac, Win+Maj+S sur Windows, ou l'extension navigateur "Full Page Screen Capture") pour chacune des pages suivantes, puis enregistrer les fichiers dans un dossier `docs/screenshots/` à la racine du projet

| Page | URL | Fichier attendu |
|---|---|---|
| Page d'accueil publique | `/` | `docs/screenshots/accueil.png` |
| Connexion | `/login` | `docs/screenshots/login.png` |
| Tableau de bord admin | `/admin/dashboard` | `docs/screenshots/dashboard.png` |
| Liste des événements | `/admin/events` | `docs/screenshots/events-index.png` |
| Création d'un événement | `/admin/events/create` | `docs/screenshots/event-create.png` |
| Liste des participants | `/admin/participants` | `docs/screenshots/participants-index.png` |
| Inscription d'un participant | `/admin/participants/create` | `docs/screenshots/participant-create.png` |
| Scanner QR code (check-in) | `/admin/scanner` | `docs/screenshots/scanner.png` |
| Espace participant | `/mon-espace` | `docs/screenshots/participant-dashboard.png` |

Une fois les fichiers ajoutés dans `docs/screenshots/`, les intégrer ici avec :
```markdown
![Tableau de bord](docs/screenshots/dashboard.png)
```

## Planning du projet

Le projet a été développé selon une méthodologie Agile, organisée en six sprints d'une semaine.

| Sprint | Période | Objectif |
|---|---|---|
| Sprint 1 | 08-14 juin | Setup du projet et base de données |
| Sprint 2 | 15-21 juin | CRUD Événements |
| Sprint 3 | 22-28 juin | CRUD Participants |
| Sprint 4 | 29 juin - 05 juillet | Gestion de la présence |
| Sprint 5 | 06-13 juillet | Dashboard et export CSV |
| Sprint 6 | 14-23 juillet | Tests, corrections et livraison finale |

## Livrables

- Prototype fonctionnel
- Code source (ce repository)
- Documentation d'installation (ce README)
- Jeu de données fictif (seeders)
- Documentation de la structure de la base de données
- Captures d'écran des pages principales

## Informations sur le stage

| | |
|---|---|
| Sujet | Event Registration and Participant Management Platform |
| Durée | 1,5 mois (08/06/2026 - 23/07/2026) |
| Nombre de stagiaires | 1 |
| Stagiaire | Kmar Srarfi |
| Encadrant professionnel | Mohamed Amine Yaakoubi (Tech Lead) |
| École | ESPRIT - École Supérieure Privée d'Ingénierie et de Technologies |