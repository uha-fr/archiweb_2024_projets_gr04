<?php

namespace App\Controllers;

use App\Models\RecetteModel;
use App\Models\RelationNutritionnisteModel;
use App\Models\UtilisateursModel;

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

    public function voirPlanning(int $idClient) {
        $this->verifUtilisateurConnecte();
        $this->isNutritionniste();

        $idClient = $this->secure($idClient);

        $repoUtilisateur = new UtilisateursModel();
        $client = $repoUtilisateur->find($idClient);

        $repoRelation = new RelationNutritionnisteModel();
        $relation = $repoRelation->findBy(['idClient' => $idClient]);
        $relation = $relation ? $relation[0] : null;

        $titre = $client ? 'Planning de ' . $client->getNomUtilisateur() : 'Erreur';

        $repoRecette = new RecetteModel();
        $recettes = $repoRecette->findAll();

        $this->render('planning/index.php', [
            'client' => $client,
            'relation' => $relation,
            'titre' => $titre,
            'recettes' => $recettes,
            'controller' => 'NutritionnisteGestionRelation'
        ]);
    }

    private function isNutritionniste() {
        if($_SESSION['utilisateur']['role'] != "nutritionniste") {
            header('Location: /accueil');
            exit;
        }
    }
}