# Projet Biblios - Symfony 7
 
Ce projet a été réalisé dans le cadre du cours OpenClassrooms : [Construisez un site web à l'aide du framework Symfony 7](https://openclassrooms.com/fr/courses/8264046-construisez-un-site-web-a-laide-du-framework-symfony-7). L'objectif est de proposer une application qui recense les livres disponibles dans une bibliothèque en indiquant aux utilisateurs les informations les concernant et leur disponibilité. 


## Table des matières

- [Stack](#stack)

- [Installation](#installation)

- [Configuration](#configuration)

- [To Do List](#todo)

- [License](#license)

  
 ## Stack
 * \>= PHP 8.2 
 * \>= Symfony 7.1
 * Composer
 * Docker
 * PostegreSQL

## Installation

 1. Clonez le dépôt du projet :

```bash
git clone https://github.com/mroulland/biblios.git
cd biblios 
```
2. Installez les dépendances avec Composer :

```bash
composer install
```
3. Configurez les conteneurs docker qui contiendront la base de données PostegreSQL :

```bash
docker-composer up -d
```
4. Créez un fichier .env.local pour spécifier les variables d'environnements

  
## Configuration

1. L'environnement : le fichier .env.local doit contenir les informations pour se connecter à la base de données PostgreSQL. Attention à prendre en compte le port délivré par le container, qui est amené à changer à chaque redémarrage.
```
DATABASE_URL="postgresql://user:password@localhost:5432/dbname?serverVersion=15&charset=utf8"
```
2. Migration de la base de données.
```
php bin/console doctrine:migrations:migrate
```

3. Démarrage du serveur Symfony.
```
symfony server:start
```
4. Ouvrir le navigateur sur proposée par le serveur : http(s)://localhost:8000 (généralement).

## To Do List
* Ajout d'une pagination sur la liste de livres
* Ajout de filtre par statut sur les livres
* Affichage dynamique de l'état connecté pour un utilisateur

## Licence
Ce projet est sous licence MIT.


