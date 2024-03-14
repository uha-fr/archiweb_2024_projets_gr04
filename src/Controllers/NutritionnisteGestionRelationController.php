<?php

namespace App\Controllers;

use App\Models\RelationNutritionnisteModel;

class NutritionnisteGestionRelationController extends Controller {
    public function index() {
        $this->verifUtilisateurConnecte();
        $this->isNutritionniste();

        $repo = new RelationNutritionnisteModel();

        $itemsParPage = 12;
        $nbItems = $repo->countAll(['idNutritionniste' => $this->getUserIdCo()]);
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
        $items = $repo->findByLimitesUtilisateursRelationNutritionnisteDetails($premierItem, $itemsParPage, $this->getUserIdCo());

        return $this->render('nutritionnisteGestionRelation/index.php', [
            'relations' => $items,
            'pageActuelle' => $pageActuelle,
            'nbPage' => $nbPage,
        ]);
    }

    private function isNutritionniste() {
        if($_SESSION['utilisateur']['role'] != "nutritionniste") {
            header('Location: /accueil');
            exit;
        }
    }
}