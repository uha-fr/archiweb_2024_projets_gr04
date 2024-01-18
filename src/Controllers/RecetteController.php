<?php

namespace App\Controllers;

use App\Models\RecetteModel;

class RecetteController extends Controller {

    public function index() {

        $recetteModel = new RecetteModel();
        $recettes = $recetteModel->findAll();

        $this->render('recette/index.php', [
            'recettes' => $recettes
        ]);
    }

    public function lire(int $id) {
        $recetteModel = new RecetteModel();
        $recette = $recetteModel->find($id);

        $this->render('recette/lire.php', [
            'recette' => $recette
        ]);
    }
}