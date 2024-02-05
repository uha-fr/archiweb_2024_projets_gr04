<?php

require_once 'vendor/autoload.php';

use App\Core\Main;

define('ROOT', __DIR__);

//.env
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '.')->load();

//Création du Routeur (Main.php)
$app = new Main();

//Démarrage de l'application
$app->start();