<?php

namespace App\Controllers;

use App\Models\AlimentModel;

class AlimentController extends Controller {

    public function index() {
        $this->verifUtilisateurConnecte();

        $alimentModel = new AlimentModel();

        $alimentsParPage = 14;
        $nbALiment = $alimentModel->countAllAliments();
        $nbPage = ceil($nbALiment->nbAliment / $alimentsParPage);

        if(isset($_GET['page']) && !empty($_GET['page'])) {
            $pageActuelle = (int) $this->secure($_GET['page']);
            if($pageActuelle > $nbPage) {
                $pageActuelle = $nbPage;
            }
            
        }else{
            $pageActuelle = 1;
        }

        $premierItem = $pageActuelle * $alimentsParPage - $alimentsParPage;
        $aliments = $alimentModel->findByLimitsGeneral($premierItem, $alimentsParPage, [], "nom");

        return $this->render('aliment/index.php', [
            'aliments' => $aliments,
            'premierItem' => $premierItem,
            'pageActuelle' => $pageActuelle,
            'nbPage' => $nbPage
        ]);
    }

    public function recupererAliments() {
        $this->verifUtilisateurConnecte();

        $alimentModel = new AlimentModel();
        $aliments = $alimentModel->findAll();

        $response = ['data' => $aliments];

        //Reponse
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}