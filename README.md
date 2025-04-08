# Système de Gestion de Présence par QR Code

Ce projet est un système de gestion de présence basé sur la technologie QR code pour les événements. Il permet aux organisateurs de gérer efficacement leurs invités, de générer des QR codes uniques pour chaque participant, d'envoyer des invitations par email et d'offrir une interface de scan pour vérifier les présences lors des événements.

## Fonctionnalités principales

- **Gestion d'événements**
  - Création et modification d'événements
  - Configuration des lieux, dates et informations
  - Tableau de bord avec statistiques de présence

- **Gestion des invités**
  - Ajout manuel d'invités
  - Import en masse via fichier CSV
  - Génération automatique de QR codes uniques
  - Envoi d'invitations par email avec QR code intégré

- **Système de QR code**
  - Génération de QR codes uniques et sécurisés
  - Interface de scan adaptée aux mobiles
  - Vérification instantanée des invités
  - Horodatage des arrivées

- **Suivi des présences**
  - Tableau de présence en temps réel
  - Statistiques et rapports d'événement
  - Export des données de présence

## Structure du projet

### Entités et relations

#### Utilisateurs (User)
- Différents rôles: Admin, Organisateur, Staff, Scanner, Invité
- Gestion des droits d'accès selon les rôles
- Authentification et sécurité

Relations:
- Un utilisateur peut organiser plusieurs événements (si Organisateur)

#### Événements (Event)
- Informations détaillées sur l'événement (nom, description, lieu)
- Dates de début et de fin
- Paramètres de configuration

Relations:
- Un événement appartient à un organisateur (User)
- Un événement peut avoir plusieurs invités (Guests)
- Un événement contient plusieurs enregistrements de présence (Attendances)

#### Invités (Guest)
- Informations personnelles (nom, prénom, email)
- QR code unique
- Statut d'invitation (envoyée, non envoyée)

Relations:
- Un invité est associé à un événement spécifique
- Un invité peut avoir un enregistrement de présence

#### Présences (Attendance)
- Enregistrement des entrées
- Horodatage de l'arrivée
- Utilisateur ayant effectué le scan
- Statut (enregistré, absent, etc.)

Relations:
- Une présence est liée à un invité
- Une présence est liée à un événement
- Une présence peut être enregistrée par un utilisateur

### Diagramme des relations

```
User (1) ---> (*) Event
Event (1) ---> (*) Guest
Event (1) ---> (*) Attendance
Guest (1) ---> (1) Attendance
User (1) ---> (*) Attendance (checked_in_by)
```

## Technologies utilisées

- **Backend**
  - Laravel 10.x (Framework PHP)
  - MySQL/PostgreSQL (Base de données)
  - Queues Laravel (Traitement asynchrone des emails)

- **Frontend**
  - Blade (Moteur de templates Laravel)
  - Livewire (Composants dynamiques)
  - Alpine.js (Interactivité JavaScript)
  - Tailwind CSS (Framework CSS)

- **Packages clés**
  - `simplesoftwareio/simple-qrcode` : Génération de QR codes
  - `maatwebsite/excel` : Import/export CSV des invités
  - `jsQR` ou `instascan` : Lecture des QR codes via webcam/caméra mobile

## Installation et configuration

### Prérequis
- PHP 8.1 ou supérieur
- Composer
- Node.js et NPM
- Base de données MySQL ou PostgreSQL

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

## Workflows utilisateur

### Organisateur d'événement
1. Crée un nouvel événement avec tous les détails
2. Ajoute des invités manuellement ou via import CSV
3. Envoie des invitations par email
4. Suit les confirmations et les présences via le tableau de bord
5. Génère des rapports post-événement

### Invité
1. Reçoit un email avec un QR code unique
2. Présente le QR code à l'entrée de l'événement (version imprimée ou mobile)

### Personnel de scan
1. Se connecte à l'application via l'interface de scan
2. Utilise un appareil mobile ou un ordinateur avec webcam
3. Scanne les QR codes des invités
4. Visualise instantanément les informations de l'invité et enregistre sa présence

## Sécurité

- QR codes uniques avec UUID v4
- Authentification et autorisations basées sur les rôles
- Validation des données
- Protection contre les CSRF
- Validation des QR codes spécifiques à l'événement

## Contribution au projet

Les contributions sont les bienvenues ! Pour contribuer :

1. Fork le projet
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/amazing-feature`)
3. Commit vos changements (`git commit -m 'Add some amazing feature'`)
4. Push vers la branche (`git push origin feature/amazing-feature`)
5. Ouvrez une Pull Request

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus d'informations.

---

Développé avec ❤️ par Wave Inc.
