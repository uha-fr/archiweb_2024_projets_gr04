# Archiweb Projet 'MANGER' - ELLOUZATI Mohamed / NICOD Théo / SCHLAGETER Alex
Cette application est un outil permettant de suivre son alimentation

## Prérequis
Intallez un environement WAMP, LAMP ou MAMP selon votre système d'exploitation

Versions requises :

PHP 7.3.13 

MySQL 8.0.X

Installez le gestionnaire de paquet PHP Composer : https://getcomposer.org/download/

Suivez la documentation

## Configuration du projet
Récupérez le projet à la racine du dossier www/ de votre environnement AMP (sinon avec un virtual host) :

    git clone https://github.com/uha-fr/archiweb_2024_projets_gr04.git
    
À la racine du projet, exécutez les commandes :

    composer install
    composer dump-autoload

À la racine du projet, créez un fichier .env en prenant exemple sur le contenu du fichier .env.example et renseignez vos informations de base de données.

## Mettre en place la base de données
Dans votre système de base de données, importez la base de données "manger.sql" disponible à la racine du projet.

## Lancer le projet
Si tout est mis en place correctement, vous pouvez accédez à l'application depuis http://localhost/archiweb_2024_projets_gr04/ (ou depuis votre virtual host)
