<?php

require_once 'vendor/autoload.php';

use App\Core\Main;

define('ROOT', __DIR__);

if($_SERVER['HTTP_HOST'] == 'localhost') {
    define('HOST', '/archiweb_2024_projets_gr04');
}else{
    define('HOST', '');
}

//.env
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '.')->load();

// Démarrage la session
session_start();

//Création du Routeur (Main.php)
$app = new Main();

//Démarrage de l'application
$app->start();