<?php

namespace App\Controllers;

use App\Models\RecetteModel;
use App\Core\Form;
use App\Models\AlimentModel;

class RecetteController extends Controller {

    public function index() {

        $recetteModel = new RecetteModel();

        if (isset($_POST['donnees']) && is_array($_POST['donnees'])) {
            $donneesTableau = $_POST['donnees'];

            if($this->valide($donneesTableau)) {
                $recettes = $recetteModel->findByIdsAliments($donneesTableau);
            }
        }else{
            $recettes = $recetteModel->findAll();
        }
        

        $formAliments = new Form;
        $formAliments->debutForm()
            ->ajoutLabelFor('aliment', 'Mon aliment')
            ->ajoutInput('search', 'aliment', ['id' => 'monAliment', 'autocomplete' => 'off'])
            ->ajoutBouton('Ajouter à mon frigo', ['id' => 'boutonAddFrigo'])
            ->finForm();

        $boutonTrouverRecettes = new Form;
        $boutonTrouverRecettes->debutForm('post', '#', ['id' => 'formFindRecette'])
            ->ajoutBouton('Trouver une recette', ['id' => 'findRecette', 'type' => 'sumbit'])
            ->finForm();


        $this->render('recette/index.php', [
            'recettes' => $recettes,
            'formAliments' => $formAliments->create(),
            'boutonTrouverRecettes' => $boutonTrouverRecettes->create()
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