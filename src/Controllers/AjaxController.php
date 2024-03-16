<?php

namespace App\Controllers;

use App\Models\FavoriModel;

class AjaxController extends Controller {

    public function index() {}

    public function addFavori() {
        $this->verifUtilisateurConnecte();

        $jsonData = file_get_contents('php://input');

        $data = json_decode($jsonData, true);

        if ($data !== null) {
            $idUser = $this->getUserIdCo();
            $favori = new FavoriModel();
            $favori->setId(uniqid())
                    ->setType($data['type'])
                    ->setIdUtilisateur($idUser)
                    ->setIdFavori($data['idFavori']);
                                    
            $favori->create();
            echo 200;
        }
    }

}