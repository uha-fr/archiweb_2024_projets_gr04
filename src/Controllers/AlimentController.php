<?php

namespace App\Controllers;

use App\Models\AlimentModel;

class AlimentController extends Controller {

    public function index() {
        $alimentModel = new AlimentModel();
        $aliments = $alimentModel->findAll();

        return $this->render('aliment/index.php', [
            'aliments' => $aliments
        ]);
    }

    public function recupererAliments() {
        $alimentModel = new AlimentModel();
        $aliments = $alimentModel->findAll();

        $response = ['data' => $aliments];

        //Reponse
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}