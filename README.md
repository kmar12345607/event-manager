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
- Envoi d'emails réels de confirmation
- Authentification multi-rôles avancée
- Notifications (SMS, push)

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
| event_id | bigint (FK) | Référence vers l'événement (events.id) |
| full_name | string | Nom complet du participant |
| email | string | Adresse email |
| phone | string | Numéro de téléphone |
| registration_date | date | Date d'inscription |
| attendance_status | enum | inscrit / présent / absent |
| notes | text (nullable) | Notes complémentaires |
| created_at / updated_at | timestamp | Horodatage Laravel |

Relation : un événement peut avoir plusieurs participants (relation un-à-plusieurs).

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

## Captures d'écran

| Page | Aperçu |
|---|---|
| Tableau de bord | à ajouter |
| Liste des événements | à ajouter |
| Création d'un événement | à ajouter |
| Liste des participants | à ajouter |
| Inscription d'un participant | à ajouter |

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
