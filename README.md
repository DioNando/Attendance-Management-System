# Système de Gestion de Présence par QR Code

Ce projet est un système de gestion de présence basé sur la technologie QR code pour les événements. Il permet aux organisateurs de gérer efficacement leurs invités, de générer des QR codes uniques pour chaque participant, d'envoyer des invitations par email et d'offrir une interface de scan pour vérifier les présences lors des événements.

## Fonctionnalités principales

- **Gestion d'événements**
  - Création et modification d'événements
  - Configuration des lieux, dates et informations
  - Tableau de bord avec statistiques de présence
  - Gestion des catégories d'événements et options de personnalisation
  - Planification de rappels automatiques

- **Gestion des invités**
  - Ajout manuel d'invités
  - Import en masse via fichier CSV
  - Génération automatique de QR codes uniques
  - Envoi d'invitations par email avec QR code intégré
  - Suivi des réponses et confirmations

- **Système de QR code**
  - Génération de QR codes uniques et sécurisés
  - Interface de scan adaptée aux mobiles
  - Vérification instantanée des invités
  - Horodatage des arrivées
  - Validation contextuelle (date, lieu, limitations)

- **Suivi des présences**
  - Tableau de présence en temps réel
  - Statistiques et rapports d'événement
  - Export des données de présence en formats multiples (PDF, Excel, CSV)
  - Visualisations graphiques des tendances
  - Notifications en temps réel des arrivées

## Architecture technique

Le système est développé selon une architecture MVC (Modèle-Vue-Contrôleur) avec Laravel comme framework principal. L'application utilise des composants Livewire pour une expérience dynamique sans rechargement de page, et s'appuie sur des jobs en file d'attente pour les tâches intensives comme l'envoi massif d'emails.

### Aperçu des technologies
- **PHP 8.2+** pour une programmation moderne avec les dernières fonctionnalités
- **Laravel 12** comme framework backend robuste
- **Livewire 3** pour les composants dynamiques côté serveur
- **AlpineJS** pour les interactions JavaScript légères
- **Tailwind CSS** pour un design responsive et personnalisable
- **Laravel Queue** pour le traitement asynchrone
- **MySQL/PostgreSQL** pour le stockage persistant des données

## Structure du projet

### Entités et relations

#### Utilisateurs (User)
- Différents rôles: Admin, Organisateur, Staff, Scanner, Invité
- Gestion des droits d'accès selon les rôles
- Authentification et sécurité

Relations:
- Un utilisateur peut organiser plusieurs événements (si Organisateur)
- Un utilisateur peut appartenir à plusieurs équipes d'organisation

#### Événements (Event)
- Informations détaillées sur l'événement (nom, description, lieu)
- Dates de début et de fin
- Paramètres de configuration
- Options d'accès et de visibilité
- Gestion des ressources et capacités

Relations:
- Un événement appartient à un organisateur (User)
- Un événement peut avoir plusieurs invités (Guests)
- Un événement contient plusieurs enregistrements de présence (Attendances)
- Un événement peut avoir plusieurs équipes de gestion

#### Invités (Guest)
- Informations personnelles (nom, prénom, email)
- QR code unique
- Statut d'invitation (envoyée, non envoyée, confirmée, refusée)
- Données personnalisées (allergies, préférences, etc.)
- Historique de participation aux événements précédents

Relations:
- Un invité est associé à un événement spécifique
- Un invité peut avoir un enregistrement de présence
- Un invité peut appartenir à des groupes ou catégories

#### Présences (Attendance)
- Enregistrement des entrées
- Horodatage de l'arrivée
- Utilisateur ayant effectué le scan
- Statut (enregistré, absent, en retard, etc.)
- Données additionnelles (notes, commentaires)

Relations:
- Une présence est liée à un invité
- Une présence est liée à un événement
- Une présence peut être enregistrée par un utilisateur
- Une présence peut générer des notifications

### Diagramme des relations

```
User (1) ---> (*) Event
Event (1) ---> (*) Guest
Event (1) ---> (*) Attendance
Guest (1) ---> (1) Attendance
User (1) ---> (*) Attendance (checked_in_by)
User (*) ---> (*) Team
Team (*) ---> (*) Event
```

## Technologies utilisées

- **Backend**
  - Laravel 12.x (Framework PHP)
  - MySQL/PostgreSQL (Base de données)
  - Queues Laravel (Traitement asynchrone des emails)
  - Redis pour le cache et les files d'attente
  - WebSockets pour les notifications en temps réel

- **Frontend**
  - Blade (Moteur de templates Laravel)
  - Livewire (Composants dynamiques)
  - Alpine.js (Interactivité JavaScript)
  - Tailwind CSS (Framework CSS)
  - Chart.js pour les visualisations graphiques
  - Tailwind UI pour les composants d'interface

- **Packages clés**
  - `simplesoftwareio/simple-qrcode` : Génération de QR codes
  - `maatwebsite/excel` : Import/export CSV des invités
  - `barryvdh/laravel-dompdf` : Génération de PDF
  - `intervention/image` : Manipulation d'images
  - `jsQR` ou `instascan` : Lecture des QR codes via webcam/caméra mobile
  - `laravel/jetstream` : Authentification et gestion d'équipe
  - `spatie/laravel-permission` : Gestion des rôles et permissions

## Installation et configuration

### Prérequis
- PHP 8.2 ou supérieur
- Composer 2.0+
- Node.js 16+ et NPM 8+
- Base de données MySQL 8.0+ ou PostgreSQL 12+
- Serveur web (Apache/Nginx)
- Extension PHP : GD, BCMath, Exif, OPcache, PDO

### Installation

1. Cloner le dépôt
   ```bash
   git clone https://github.com/votre-username/attendance-management-system.git
   cd attendance-management-system
   ```

2. Installer les dépendances
   ```bash
   composer install
   npm install
   ```

3. Configurer l'environnement
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configurer la base de données dans le fichier .env
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nom_de_votre_bd
   DB_USERNAME=votre_utilisateur
   DB_PASSWORD=votre_mot_de_passe
   ```

5. Configurer l'envoi d'emails
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=votre_serveur_smtp
   MAIL_PORT=587
   MAIL_USERNAME=votre_username
   MAIL_PASSWORD=votre_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=invitations@votredomaine.com
   MAIL_FROM_NAME="Système d'invitation"
   ```

6. Exécuter les migrations et les seeders
   ```bash
   php artisan migrate --seed
   ```

7. Compiler les assets
   ```bash
   npm run dev
   ```

8. Démarrer le serveur
   ```bash
   php artisan serve
   ```

9. Démarrer la queue worker pour les emails (dans un terminal séparé)
   ```bash
   php artisan queue:work
   ```

10. Créer un lien symbolique pour le stockage (pour les QR codes et fichiers d'invitation)
    ```bash
    php artisan storage:link
    ```

## Développement

### Commandes utiles

- Lancer les tests
  ```bash
  php artisan test
  ```

- Analyser le code avec Laravel Pint
  ```bash
  ./vendor/bin/pint
  ```

- Lancer le développement avec hot reload
  ```bash
  npm run dev
  ```

- Exécuter toutes les tâches de développement en parallèle (serveur, queue et assets)
  ```bash
  composer dev
  ```

## Workflows utilisateur

### Organisateur d'événement
1. Crée un nouvel événement avec tous les détails
2. Ajoute des invités manuellement ou via import CSV
3. Envoie des invitations par email
4. Suit les confirmations et les présences via le tableau de bord
5. Génère des rapports post-événement

### Invité
1. Reçoit un email avec un QR code unique
2. Peut confirmer sa présence via le lien inclus dans l'email
3. Présente le QR code à l'entrée de l'événement (version imprimée ou mobile)
4. Peut recevoir des rappels automatiques avant l'événement

### Personnel de scan
1. Se connecte à l'application via l'interface de scan
2. Utilise un appareil mobile ou un ordinateur avec webcam
3. Scanne les QR codes des invités
4. Visualise instantanément les informations de l'invité et enregistre sa présence
5. Peut ajouter des notes ou observations sur les participants

## Expérience utilisateur

- **Interface responsive** adaptée à tous les appareils (mobiles, tablettes, ordinateurs)
- **Mode hors ligne** pour le scan des QR codes en cas de connectivité limitée
- **Thème sombre/clair** pour une meilleure ergonomie
- **Accessibilité** conforme aux standards WCAG 2.1
- **Multilingue** avec support initial pour français et anglais

## Sécurité

- QR codes uniques avec UUID v4
- Authentification et autorisations basées sur les rôles
- Validation des données sur toutes les entrées
- Protection contre les attaques CSRF, XSS, et injections SQL
- Validation des QR codes spécifiques à l'événement
- Cryptage des données sensibles
- Expiration automatique des liens d'invitation
- Journalisation des activités pour audit

## Contribution au projet

Les contributions sont les bienvenues ! Pour contribuer :

1. Fork le projet
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/amazing-feature`)
3. Commit vos changements (`git commit -m 'Add some amazing feature'`)
4. Push vers la branche (`git push origin feature/amazing-feature`)
5. Ouvrez une Pull Request

### Guide de style de code
- Suivre les standards PSR-12
- Utiliser les typages stricts en PHP
- Commenter le code selon les standards PHPDoc
- Écrire des tests pour les nouvelles fonctionnalités

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus d'informations.

## Feuille de route
- Support de l'authentification à deux facteurs
- Application mobile dédiée pour le scan
- Intégration avec des plateformes de calendrier (Google, Outlook)
- API pour intégrations tierces
- Système de badges personnalisables

---

Développé avec ❤️ par Wave Inc.
