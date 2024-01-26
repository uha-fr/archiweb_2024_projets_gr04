<?php

namespace App\Controllers;

abstract class Controller {
    
    function render (string $fichier, array $donnees = [], string $template = 'default.php') {

        extract($donnees);

        //Buffer de sortie
        ob_start(); //Toutes les sorties sont mise en mémoire

        require_once ROOT . '/Views/' . $fichier;

        $contenu = ob_get_clean(); //Stock dans $contenu toutes les sorties depuis ob_start

        require_once ROOT . '/Views/' . $template;
    }
}