<?php

require_once 'vendor/autoload.php';

use App\Core\Main;

define('ROOT', __DIR__);

//Création du Routeur (Main.php)
$app = new Main();

//Démarrage de l'application
$app->start();