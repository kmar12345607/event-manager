<div align="center">
📅 Event Registration & Participant Management Platform
Plateforme de gestion des inscriptions aux événements et du suivi des participants
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=flat&logo=bootstrap&logoColor=white)
[![Status](https://img.shields.io/badge/Statut-Prototype-orange)]()
[![License](https://img.shields.io/badge/Licence-Académique-lightgrey)]()
</div>
---
📑 Table des matières
À propos du projet
Contexte et périmètre
Fonctionnalités
Stack technique
Architecture du projet
Modèle de données
Installation
Configuration
Jeu de données fictif
Utilisation
Captures d'écran
Planning du projet
Livrables
Informations sur le stage
Contact
---
🎯 À propos du projet
Event Registration & Participant Management Platform est une application web développée dans le but de simplifier la gestion des événements et le suivi de leurs participants.
L'application permet à un administrateur de :
Créer et gérer des événements
Inscrire des participants à ces événements
Suivre leur présence en temps réel
Visualiser des statistiques globales depuis un tableau de bord
Le projet a été conçu comme une solution simple, claire et facilement maintenable, pensée pour des organisations souhaitant digitaliser la gestion de leurs événements sans dépendre d'outils complexes ou payants.
---
⚠️ Contexte et périmètre
Ce projet est développé dans un cadre académique et prototype. Il est important de préciser les limites volontaires du périmètre :
✅ Inclus dans le projet	❌ Hors périmètre
Gestion complète des événements (CRUD)	Connexion à un système de paiement réel
Gestion complète des participants (CRUD)	Intégration à des plateformes d'événements externes (Eventbrite, Meetup...)
Suivi de présence	Envoi d'emails réels de confirmation
Statistiques de base	Authentification multi-rôles avancée
Export CSV	Notifications push / SMS
Données fictives (seeders)	Données de production réelles
> Le projet reste volontairement **simple et orienté démonstration**, dans le but de livrer un prototype fonctionnel et propre dans les délais impartis du stage.
---
✨ Fonctionnalités
🗓️ Gestion des événements
Formulaire de création d'un événement
Page de listing de tous les événements
Modification et suppression d'un événement
Gestion du statut de l'événement (actif / annulé / terminé)
👥 Gestion des participants
Formulaire d'inscription d'un participant à un événement
Listing des participants avec recherche (par nom, email)
Modification et suppression d'un participant
Vérification du nombre maximum de places disponibles
✅ Suivi de présence
Gestion du statut de présence : `inscrit` → `présent` / `absent`
Mise à jour rapide du statut depuis la liste des participants
Vue filtrée par événement
📊 Tableau de bord (Dashboard)
Nombre total d'événements créés
Nombre total de participants inscrits
Taux de présence global (%)
Export de la liste des participants au format CSV (optionnel)
---
🛠️ Stack technique
Couche	Technologies
Frontend	HTML5, CSS3, JavaScript, Bootstrap (optionnel), Blade (moteur de templates Laravel)
Backend	Laravel (PHP), Eloquent ORM
Base de données	MySQL ou SQLite
Export	CSV
Outils	Git, GitHub, Composer, npm
---
🏗️ Architecture du projet
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
---
🗄️ Modèle de données
Table `events`
Champ	Type	Description
`id`	bigint (PK)	Identifiant unique
`name`	string	Nom de l'événement
`date`	date	Date de l'événement
`location`	string	Lieu de l'événement
`description`	text	Description détaillée
`max_participants`	integer	Nombre maximum de participants autorisés
`status`	enum	Statut : `actif` / `annulé` / `terminé`
`created_at` / `updated_at`	timestamp	Horodatage Laravel
Table `participants`
Champ	Type	Description
`id`	bigint (PK)	Identifiant unique
`event_id`	bigint (FK)	Référence vers l'événement (`events.id`)
`full_name`	string	Nom complet du participant
`email`	string	Adresse email
`phone`	string	Numéro de téléphone
`registration_date`	date	Date d'inscription
`attendance_status`	enum	`inscrit` / `présent` / `absent`
`notes`	text (nullable)	Notes complémentaires
`created_at` / `updated_at`	timestamp	Horodatage Laravel
Relation : un événement (`events`) peut avoir plusieurs participants (`participants`) → relation 1-N.
```php
// Event.php
public function participants() {
    return $this->hasMany(Participant::class);
}

// Participant.php
public function event() {
    return $this->belongsTo(Event::class);
}
```
---
⚙️ Installation
Prérequis
PHP >= 8.1
Composer
MySQL ou SQLite
Node.js & npm (si utilisation de Bootstrap/JS via npm)
Étapes
```bash
# 1. Cloner le repository
git clone <url-du-repo>
cd <nom-du-dossier>

# 2. Installer les dépendances PHP
composer install

# 3. Copier le fichier d'environnement
cp .env.example .env
php artisan key:generate

# 4. Installer les dépendances front-end (optionnel)
npm install
npm run dev

# 5. Lancer le serveur de développement
php artisan serve
```
L'application est ensuite accessible à l'adresse : http://localhost:8000
---
🔧 Configuration
Configurer la connexion à la base de données dans le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=root
DB_PASSWORD=
```
> Pour utiliser **SQLite** à la place : définir `DB_CONNECTION=sqlite` et créer le fichier `database/database.sqlite`.
Lancer les migrations pour créer les tables :
```bash
php artisan migrate
```
---
🌱 Jeu de données fictif
Le projet contient des seeders Laravel permettant de générer automatiquement des événements et participants fictifs, utilisés uniquement à des fins de démonstration et de test.
```bash
php artisan migrate --seed
```
Ou pour réinitialiser complètement la base avec de nouvelles données :
```bash
php artisan migrate:fresh --seed
```
> ℹ️ Toutes les données générées sont **fictives**. Aucune donnée réelle de paiement, d'utilisateur ou d'événement externe n'est utilisée dans ce projet.
---
🚀 Utilisation
Accéder au tableau de bord (`/dashboard`) pour visualiser les statistiques globales
Créer un nouvel événement via `/events/create`
Consulter la liste des événements via `/events`
Inscrire un participant à un événement via `/participants/create`
Gérer le statut de présence depuis la liste des participants d'un événement
Exporter la liste des participants au format CSV (optionnel)
---
📸 Captures d'écran
Page	Aperçu
Tableau de bord	(à ajouter)
Liste des événements	(à ajouter)
Création d'un événement	(à ajouter)
Liste des participants	(à ajouter)
Inscription d'un participant	(à ajouter)
---
🗓️ Planning du projet
Le projet a été développé selon une méthodologie Agile, organisée en 6 sprints d'une semaine :
Sprint	Période	Objectif
Sprint 1	08–14 Juin	Setup du projet & base de données
Sprint 2	15–21 Juin	CRUD Événements
Sprint 3	22–28 Juin	CRUD Participants
Sprint 4	29 Juin–05 Juil	Gestion de la présence
Sprint 5	06–13 Juillet	Dashboard & export CSV
Sprint 6	14–23 Juillet	Tests, corrections & livraison finale
---
📦 Livrables
✅ Prototype fonctionnel
✅ Code source (ce repository)
✅ Documentation d'installation (ce README)
✅ Jeu de données fictif (seeders)
✅ Documentation de la structure de la base de données
✅ Captures d'écran des pages principales
---
🎓 Informations sur le stage
	
Sujet	Event Registration and Participant Management Platform
Durée	1,5 mois (08/06/2026 – 23/07/2026)
Nombre de stagiaires	1
Stagiaire	Kmar Srarfi
Encadrant professionnel	Mohamed Amine Yaakoubi (Tech Lead)
École	ESPRIT — École Supérieure Privée d'Ingénierie et de Technologies
---
📬 Contact
Pour toute question concernant ce projet, n'hésitez pas à ouvrir une issue sur ce repository ou à contacter directement le stagiaire en charge du développement.
<div align="center">
Projet réalisé dans le cadre d'un stage d'été — ESPRIT 2026
</div>
