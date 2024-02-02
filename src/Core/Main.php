<?php

namespace App\Core;

use App\Controllers\AccueilController;

/**
 * Routeur principal
 */
class Main {
    public function start() {
    
        // Nettoyage de l'URL et enlèvement de duplication d'URL
        //Récupération de l'URL
        $uri = $_SERVER['REQUEST_URI'];

        if(!empty($uri) && $uri != '/' && $uri[-1] === '/'){
            //On enlève le /
            $uri = substr($uri, 0, -1);

            //Envoi de code de redirection permanente
            http_response_code(301);

            //Redirection vers l'URL sans /
            header('Location' . $uri);
        }

        //Séparage des paramètres de l'URL dans un tableau
        $params = [];
        if(isset($_GET['p']))
            $params = explode('/', $_GET['p']);

        
        if(isset($params[0]) && $params[0] != '') {
            //Récupération du nom du controller
            $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';
        
            //Instanciation du controller
            $controller = new $controller();

            //Récupération du deuxième paramètre (sinon index)
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if(method_exists($controller, $action)) {
                //S'il reste des params on les passe à la méthode
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            }else{
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }

        }else{
            $controller = new AccueilController;
            $controller->index();
        }
    }
}