<?php


namespace App\Controllers;
use App\Models\PlanningModel;

class PlanningController  extends Controller{
    public function index() {
        $planningModel = new PlanningModel();
        $recettes = $planningModel->findAll(); 

        // error_log(print_r($recettes, true)); 

        $this->render('planning/index.php', ['recettes' => $recettes]);

    }
}


