# Educia BDE - Plateforme de Gestion et d'Animation Etudiante

Plateforme web de gestion et d'animation de la vie etudiante developpee pour le Bureau des Eleves (BDE) de Skolae Toulon. L'application permet de centraliser les informations du campus, d'annoncer les evenements et sorties, et de fournir un espace dedie aux gestionnaires du BDE.

---

## Sommaire

- Presentation
- Fonctionnalites principales
- Architecture et Technologies
- Prerequis
- Installation et Configuration
- Execution de l'application
- Structure du projet
- Qualite de code et Tests
- Securite

---

## Presentation

Educia BDE est une solution concue pour dynamiser la vie associative et faciliter la gestion des projets du bde au sein de l'ecole. Elle offre une interface fluide, responsive et adaptee aux differents terminaux (ordinateurs, tablettes, smartphones), en bref un acces reserve aux membres authentifies.

---

## Fonctionnalites principales

### Authentification et Gestion des acces
- Inscription securisee des etudiants avec verification des donnees et confirmation du mot de passe.
- Connexion securisee avec hachage Bcrypt des identifiants.
- Gestion de session applicative stockee en base de donnees.
- Deconnexion securisee avec reinitialisation de la session.

### Navigation et Interface
- Disposition ergonomique avec menu lateral retractable (off-canvas) adapte au mobile et desktop.
- Tableau de bord centralisant les activites et le statut de connexion de l'utilisateur.
- Identite visuelle personnalisee aux couleurs de l'association.

### Modules de la vie etudiante
- Evenements : Presentation et suivi des rendez-vous culturels, sportifs et festifs du campus.
- Sorties : Coordination des activites et rencontres inter-etudiants.
- Communaute : Espace d'information et d'initiatives associatives.

---

## Architecture et Technologies

### Backend
- Langage : PHP 8.3+ / PHP 8.4
- Framework : Laravel 13
- ORM / Acces aux donnees : Eloquent ORM et Query Builder Laravel
- Gestion des sessions et du cache : Base de donnees (MySQL)

### Frontend
- Moteur de template : Laravel Blade
- Styles : CSS3 personnalise avec variables de themes et integration Tailwind CSS
- Bundler et outillage : Vite 6+ / Vite 8, Node.js

### Base de donnees
- SGBD : MySQL 8.x / MariaDB
- Support des migrations Laravel et script SQL initial (`bdd.sql`)

### Outils de developpement et qualite
- Laravel Pint : Formatage du code PHP respectant les standards PSR-12 / Laravel
- PHPUnit : Suite de tests unitaires et fonctionnels
- Laravel Boost / Pao / Pail : Environnement ameliore de developpement et de debogage

---

## Prerequis

Avant d'installer l'application, assurez-vous de disposer des outils suivants sur votre environnement de developpement :

- PHP >= 8.3 (avec extensions : `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`)
- Composer >= 2.x
- Node.js >= 18.x et gestionnaire de paquets `npm`
- Serveur MySQL >= 8.0 ou MariaDB >= 10.4 (WampServer, Laragon, Docker ou installation native)

---

## Installation et Configuration

### 1. Clonage du depot

Recuperez les sources du projet sur votre machine locale :

```bash
git clone https://github.com/FisherionPrime/bde.git
cd bde
```

### 2. Installation des dependances

Installez les dependances PHP via Composer :

```bash
composer install
```

Installez les dependances JavaScript / CSS via npm :

```bash
npm install
```

### 3. Configuration des variables d'environnement

Copiez le fichier d'exemple pour creer votre fichier `.env` :

Sous Windows (PowerShell / CMD) :
```cmd
copy .env.example .env
```

Sous Linux / macOS :
```bash
cp .env.example .env
```

Generez la cle de chiffrement de l'application :

```bash
php artisan key:generate
```

### 4. Configuration de la base de donnees

Modifiez les parametres de connexion dans le fichier `.env` pour cibler votre base MySQL :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bde
DB_USERNAME=root
DB_PASSWORD=
```

Importer le fichier bdd.sql dans votre bdd (comme phpmyadmin)

## Execution de l'application

### Mode Developpement

Pour executer simultanement le serveur applicatif PHP et le serveur de compilation d'actifs Vite, lancez la commande globale :

```bash
composer run dev
```

Ou separement dans deux terminaux :

Terminal 1 (Backend PHP) :
```bash
php artisan serve
```

Terminal 2 (Compilation a chaud Vite) :
```bash
npm run dev
```

L'application sera accessible a l'adresse : `http://localhost:8000` (ou `http://127.0.0.1:8000`).

### Mode Production (Compilation des actifs)

Pour construire les fichiers CSS et JavaScript optimises pour la production :

```bash
npm run build
```

---

## Structure du projet

Apercu des dossiers cles du projet :

```text
bde/
|-- app/
|   |-- Http/
|   |   `-- Controllers/       # Controleurs applicatifs
|   |-- Models/                # Modeles Eloquent (User, etc.)
|   `-- Providers/             # Fournisseurs de services Laravel
|-- config/                    # Fichiers de configuration de l'application
|-- database/
|   |-- factories/             # Fabriques pour les jeux d'essai
|   |-- migrations/            # Historique des migrations du schema de donnees
|   `-- seeders/               # Remplissage initial de la base de donnees
|-- public/
|   |-- images/                # Actifs statiques et logos
|   `-- index.php              # Point d'entree HTTP public
|-- resources/
|   |-- css/                   # Feuilles de style et Tailwind CSS
|   |-- js/                    # Scripts JavaScript client
|   `-- views/                 # Vues et templates Blade
|       |-- auth/              # Vues de connexion et inscription
|       |-- index.blade.php    # Tableau de bord principal
|       `-- template.blade.php # Layout structurel partage
|-- routes/
|   |-- console.php            # Commandes console Artisan
|   `-- web.php                # Routes web de l'application
|-- tests/                     # Tests automatises Unit et Feature
|-- bdd.sql                    # Dump SQL initial du schema
`-- composer.json              # Definitions des dependances PHP
```

---

## Qualite de code et Tests

### Execution des tests automatises

Le projet est equipe d'une suite de tests PHPUnit. Pour executer les tests :

```bash
php artisan test
```

### Standardisation du code (Pint)

Le style du code PHP est normalise avec Laravel Pint. Pour corriger automatiquement les ecarts de style :

```bash
vendor/bin/pint
```

---

## Securite

- Hachage des mots de passe : Utilisation native de l'algorithme Bcrypt avec un cout adapte (`BCRYPT_ROUNDS=12`).
- Gestion des sessions : Stockage securise des sessions en base de donnees avec identifiant unique et delai d'expiration.
- Validation des donnees : Verification stricte des champs lors de la creation de compte et de l'authentification.
