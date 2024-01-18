<?php

namespace App\Controllers;

class AccueilController extends Controller {
    public function index() {
        $this->render('accueil/index.php');
    }
}