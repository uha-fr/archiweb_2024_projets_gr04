<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\RelationNutritionnisteModel;
use App\Models\UtilisateursModel;

class RechercheNutritionnisteController extends Controller
{

    public function index()
    {
        $this->verifUtilisateurConnecte();
        
        $repo = new UtilisateursModel();

        $itemsParPage = 12;
        $nbItems = $repo->countAll(['role' => 'nutritionniste']);
        $nbPage = ceil((int)$nbItems->items / $itemsParPage);

        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $pageActuelle = (int) $this->secure($_GET['page']);
            if ($pageActuelle > $nbPage) {
                $pageActuelle = $nbPage;
            }
        } else {
            $pageActuelle = 1;
        }

        $premierItem = $pageActuelle * $itemsParPage - $itemsParPage;
        $items = $repo->findByLimitesNutritionnistesDetails($premierItem, $itemsParPage, $this->getUserIdCo());

        $repo = new RelationNutritionnisteModel();
        $relation = $repo->findBy(['idClient' => $this->getUserIdCo()]);
        

        return $this->render('rechercheNutritionniste/index.php', [
            'nutritionnistes' => $items,
            'nbPage' => $nbPage,
            'pageActuelle' => $pageActuelle,
            'relation' => $relation,
        ]);
        
    }

    public function demandeSuivi() {
        $this->verifUtilisateurConnecte();

        $jsonData = file_get_contents('php://input');

        $data = json_decode($jsonData, true);

        if ($data !== null) {
            $idUser = $this->getUserIdCo();
            $notif = new NotificationModel();
            $notif->setId(uniqid())
                    ->setType('demande-nutritionniste')
                    ->setIdUserDest($data['idNutritionniste'])
                    ->setIdUserOrigine($idUser)
                    ->setDate();
                
            $notif->create();
            echo 200;
        }
    }
}
