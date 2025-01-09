# Mon Projet - Système de Gestion de Contenu

## Contexte du Projet

Ce projet vise à créer une plateforme de gestion de contenu pour les développeurs, permettant le partage d'articles, l'exploration de contenu pertinent et la collaboration. Il comprend une interface utilisateur fluide pour les utilisateurs et un tableau de bord puissant pour les administrateurs.

## Technologies Utilisées

- **Langage**: PHP 8 (Programmation Orientée Objet)
- **Base de Données**: PDO pour l'interaction avec la base de données

## Fonctionnalités Principales

### Partie Back Office (Administrateurs)

- **Gestion des Catégories**: Création, modification, suppression et statistiques des catégories.
- **Gestion des Tags**: Création, modification, suppression et statistiques des tags.
- **Gestion des Utilisateurs**: Consultation, gestion des profils, attribution de permissions et suspension des utilisateurs.
- **Gestion des Articles**: Consultation, acceptation ou refus des articles soumis, archivage des articles inappropriés.
- **Statistiques et Tableau de Bord**: Visualisation des utilisateurs, articles, catégories, tags et articles populaires.

### Partie Front Office (Utilisateurs)

- **Inscription et Connexion**: Création de compte et connexion sécurisée.
- **Navigation et Recherche**: Barre de recherche interactive et navigation dynamique.
- **Affichage du Contenu**: Derniers articles et catégories mises à jour.
- **Espace Auteur**: Création, modification et gestion des articles.

## Structure du Projet

```
mon-projet
├── src
│   ├── Controllers
│   ├── Models
│   ├── Views
│   ├── config
│   ├── core
│   └── public
├── .env
├── composer.json
├── README.md
└── routes.php
```

## Installation

1. Clonez le dépôt.
2. Installez les dépendances avec Composer.
3. Configurez le fichier `.env` pour la connexion à la base de données.
4. Lancez le serveur web pour accéder à l'application.

## Contribution

Les contributions sont les bienvenues. Veuillez soumettre une demande de tirage pour toute amélioration ou correction.
