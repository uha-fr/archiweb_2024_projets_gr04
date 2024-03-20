<?php

require_once 'vendor/autoload.php';

use App\Core\Main;

define('ROOT', __DIR__);

define('DS', DIRECTORY_SEPARATOR);
define('WEBROOT', 'http://'.$_SERVER['SERVER_NAME'].(($_SERVER['SERVER_PORT'] == '80')?'':':'.$_SERVER['SERVER_PORT']).((dirname($_SERVER['SCRIPT_NAME']) == DS)?'':dirname($_SERVER['SCRIPT_NAME'])) );

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//.env
// Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '.')->load();
Dotenv\Dotenv::createUnsafeImmutable(__DIR__)->load();

// Démarrage la session
session_start();

//Création du Routeur (Main.php)
$app = new Main();

//Démarrage de l'application
$app->start();