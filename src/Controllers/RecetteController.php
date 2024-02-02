<?php

namespace App\Controllers;

use App\Models\RecetteModel;
use App\Core\Form;
use App\Models\AlimentModel;

class RecetteController extends Controller {

    public function index() {

        if (isset($_POST['effacerFiltre'])) {
            setcookie('r', '', time() - 3600, '/');
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }

        $recetteModel = new RecetteModel();
        $recettesParPage = 10;

        if(isset($_GET['page']) && !empty($_GET['page'])) {
            $pageActuelle = (int) strip_tags($_GET['page']);
        }else{
            $pageActuelle = 1;
        }

        if (isset($_POST['aliments']) && is_array($_POST['aliments']) || isset($_COOKIE['r'])) {
            if(isset($_POST['aliments'])) {
                $alimentsFrigo = $_POST['aliments'];
                if($this->valide($alimentsFrigo)) {
                    $recettes = $recetteModel->findByIdsAliments($alimentsFrigo);
                    setcookie('r', json_encode($recettes), time() + 3600, '/');
                }
            }else{
                $recettes = json_decode($_COOKIE['r']);
            }

            $nbRecette = count($recettes);
            $nbPage = ceil($nbRecette / $recettesParPage);
            if($pageActuelle > $nbPage) {
                $pageActuelle = $nbPage;
            }
            $premierItem = $pageActuelle * $recettesParPage - $recettesParPage;
            $recettes = array_slice($recettes, $premierItem, $premierItem + $recettesParPage);
        }else{
            $nbRecette = $recetteModel->countAllRecettes();
            $nbPage = ceil($nbRecette->nbRecette / $recettesParPage);
            if($pageActuelle > $nbPage) {
                $pageActuelle = $nbPage;
            }
            $premierItem = $pageActuelle * $recettesParPage - $recettesParPage;
            $recettes = $recetteModel->findByLimits($premierItem, $recettesParPage);
        }

        $formAliments = new Form;
        $formAliments->debutForm()
            ->ajoutInput('search', 'aliment', ['id' => 'monAliment', 'autocomplete' => 'off'])
            ->ajoutBouton('Ajouter à mon frigo', ['id' => 'boutonAddFrigo', 'class' => 'button-26'])
            ->finForm();

        $boutonTrouverRecettes = new Form;
        $boutonTrouverRecettes->debutForm('post', '#', ['id' => 'formFindRecette'])
            ->ajoutBouton('Trouver une recette', ['id' => 'findRecette', 'type' => 'sumbit', 'class' => 'button-26'])
            ->finForm();

        $btnEffacerFiltres = new Form;
        $btnEffacerFiltres->debutForm()
            ->ajoutInput('hidden', 'effacerFiltre')
            ->ajoutBouton('Effacer les filtres', ['type' => 'submit', 'class' => 'button-26'])
            ->finForm();

        $this->render('recette/index.php', [
            'recettes' => $recettes,
            'formAliments' => $formAliments->create(),
            'boutonTrouverRecettes' => $boutonTrouverRecettes->create(),
            'premierItem' => $premierItem,
            'pageActuelle' => $pageActuelle,
            'nbPage' => $nbPage,
            'btnEffacerFiltres' => $btnEffacerFiltres->create()
        ]);
    }

    public function lire(int $id) {
        $recetteModel = new RecetteModel();
        $recette = $recetteModel->find($id);

        $alimentModel = new AlimentModel();
        $ingredients = $alimentModel->findAlimentsByRecetteId($id);
        $this->render('recette/lire.php', [
            'recette' => $recette,
            'ingredients' => $ingredients
        ]);
    }

    private function valide(array $datas):bool {
        foreach($datas as $data) {
            if(!is_numeric($data)) return false;
        }
        return true;
    }
}