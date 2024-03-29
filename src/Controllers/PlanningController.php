<?php

namespace App\Controllers;

use App\Models\PlanningModel;
use App\Models\PlanningRecetteModel;
use App\Models\RecetteModel;

class PlanningController extends Controller
{
    public function index()
    {
        $repoRecette = new RecetteModel();
        $recettes = $repoRecette->findAll();

        $this->render('planning/index.php', [
            'recettes' => $recettes,
            'titre' => 'Mon planning',
            'controller' => 'Planning',
        ]);
    }

    /**
     * Ajoute une ou plusieurs recettes dans un planning
     *
     * @return void
     */
    public function addRecette()
    {
        $this->verifUtilisateurConnecte();
        $idUser = $this->getUserIdCo();

        $jsonData = file_get_contents('php://input');

        $data = json_decode($jsonData, true);
        
        if ($data !== null) {
            if(isset($data['idClient'])) {
                $idUser = $data['idClient'];
            }
            

            $repoPlanning = new PlanningModel();
            $planningUser = $repoPlanning->findBy(['id_user' => $idUser]);

            if ($planningUser == null) {
                $idPlanningUser = uniqid();
                $repoPlanning->setId($idPlanningUser)
                    ->setId_user($idUser);
                $repoPlanning->create();
            } else {
                $idPlanningUser = $planningUser[0]->getId();
            }

            $recettePlanning = new PlanningRecetteModel();
            $recettePlanning->setIdPlanning($idPlanningUser)
                ->setIdRecette($data['idRecette'])
                ->setDateDebut($data['start'])
                ->setDateFin($data['end']);
            $recettePlanning->create();

            echo 200;
        }
    }

    public function getRecettes()
    {
        $this->verifUtilisateurConnecte();
        $idUser = $this->getUserIdCo();

        $repoPlanning = new PlanningModel();

        $jsonData = file_get_contents('php://input');

        $data = json_decode($jsonData, true);
        if ($data !== null && $data != "mine") {
            $idUser = $data;
        }


        $planningUser = $repoPlanning->findBy(['id_user' => $idUser]);

        if (empty($planningUser)) {
            echo json_encode([]);
            return;
        }

        $idPlanningUser = $planningUser[0]->getId();

        $repoPlanningRecette = new PlanningRecetteModel();
        $recettes = $repoPlanningRecette->findPlanningRecetteNameByPlanningId($idPlanningUser);


        $recettesArray = array_map(function ($recette) {
            return [
                'nom' => $recette->nom,
                'dateDebut' => $recette->dateDebut,
                'dateFin' => $recette->dateFin,
            ];
        }, $recettes);

        header('Content-Type: application/json');
        echo json_encode($recettesArray);
    }
}
