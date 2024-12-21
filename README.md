# Projet Symfony : Gestion de Tutoriels

Ce projet est une application Symfony permettant de gérer des tutoriels, des sujets et des chapitres. Voici les étapes pour installer et utiliser le projet.

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Symfony CLI
- Serveur MySQL

## Installation

### Cloner le dépôt

Clonez le dépôt du projet avec la commande suivante :

```bash
git clone https://github.com/VictorJqn/tp_symfony_tutorials.git

cd <NOM_DU_DEPOT>

```

### Installer les dépendances

Exécutez la commande suivante pour installer les dépendances du projet :

``` bash
composer install
```
### Configurer la base de données

Modifiez le fichier .env pour inclure vos informations de connexion MySQL :

``` bash
DATABASE_URL="mysql://username:password@127.0.0.1:3306/nom_de_la_base"
```

Ensuite, créez la base de données et exécutez les migrations :

``` bash
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
```

### Charger les données du test 

``` bash
php bin/console hautelook:fixtures:load -n
```

### Lancer le serveur Symfony
``` bash
php -S 127.0.0.1:8000 -t public
```

Le projet sera accessible à l'adresse : http://localhost:8000

## Utilisateurs disponibles

### Administrateur 

Email : admin@example.com

Mot de passe : admin123

### Utilisateur Victor

Email : victor@example.com

Mot de passe : victor123

### Utilisateur John (Banni)

Email : john@example.com

Mot de passe : john123

## Fonctionnalités principales

### Gestion des sujets

Créer, modifier, supprimer des sujets

### Gestion des tutoriels

Créer, modifier, supprimer des tutoriels.

Les tutoriels sont associés à des sujets.

### Gestion des chapitres

Créer, modifier, supprimer des chapitres.

Les chapitres sont liés à des tutoriels.

### Rôles des utilisateurs

Administrateurs : peuvent gérer tous les aspects de l'application.

Utilisateurs standards : ont un accès limité.

Utilisateurs bannis : ne peuvent pas accéder aux fonctionnalités principales.

## Auteur

Ce projet a été développé comme un TP Symfony par Victor Jacquin pour démontrer les concepts fondamentaux du framework.




