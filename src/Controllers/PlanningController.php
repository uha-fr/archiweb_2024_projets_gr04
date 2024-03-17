<?php


namespace App\Controllers;
use App\Models\PlanningModel;
use App\Models\PlanningRecetteModel;
use DateInterval;
use DatePeriod;
use DateTime;


class PlanningController  extends Controller{
    public function index() {
        $planningModel = new PlanningModel();
        $recettes = $planningModel->findAll("recette"); 

        // error_log(print_r($recettes, true)); 

        $this->render('planning/index.php', ['recettes' => $recettes]);

    }


    /**
     * Ajoute une ou plusieurs recettes dans un planning
     *
     * @return void
     */
    public function addRecette() {
        $this->verifUtilisateurConnecte();

        $jsonData = file_get_contents('php://input');

        $data = json_decode($jsonData, true);

        if ($data !== null) {
            $idUser = $this->getUserIdCo(); // Id de l'utilisateur connecté

            //On récupère l'id du planning de l'utilisateur connecté pour ajouter des recettes à son planning
            $repoPlanning = new PlanningModel();
            $planningUser = $repoPlanning->findBy(['id_user' => $idUser]); //idPlanningUser est un tableau d'objet de PlanningModel. On aura forcement qu'on objet car on cherché par userId.
            $idPlanningUser = $planningUser[0]->getId(); //On récupère l'id du planning de l'user connecté
            
            $dateDebut = new DateTime($data['start']);
            $dateFin = new DateTime($data['end']);

            $période = new DateInterval('P1D');
            $dateRange = new DatePeriod($dateDebut, $période, $dateFin->modify('+1 day')); 

            foreach ($dateRange as $date) {
                $recettePlanning = new PlanningRecetteModel();
                $recettePlanning->setId($idPlanningUser)
                                ->setIdRecette($data['idRecette']) 
                                ->setDate($date->format('Y-m-d'));
                $recettePlanning->create();
            }


            
            /* TODO :
            // Attention : il peut y avoir plusieurs recette à ajouter car la date est dépendante de start et end (voir ligne 141/142 de Views/planning/index.php)
            // Il faut donc vérifier s'il y a plusieurs jours entre start et end. Si oui, il faut ajouter la même recette pour plusieurs dates, donc on va créer plusieurs objet PlanningRecetteModel
            
            //Exemple de création l'objet PlanningRecetteModel et de remplissage de ses valeurs
            $recettePlanning = new PlanningRecetteModel();
            $recettePlanning->setId($idPlanningUser)
                            ->setIdRecette(...)
                            ->setDate(...);
            $recettePlanning->create();
            */
            echo 200;
        }
    }

    public function getRecettes() {
        $this->verifUtilisateurConnecte();
        $idUser = $this->getUserIdCo(); 

        $repoPlanning = new PlanningModel();

        $planningUser = $repoPlanning->findBy(['id_user' => $idUser]); 
        
        if (empty($planningUser)) {
            echo json_encode([]);
            return;
        }
    
        $idPlanningUser = $planningUser[0]->getId(); 
        
        

        $repoRecette = new PlanningRecetteModel();

        $recettes = $repoRecette->findBy(['id' => $idPlanningUser]); 
    

        $recettesArray = array_map(function($recette) {
            return [
                'nom' => $recette->getNom(), 
                'dateDebut' => $recette->getDate(), 
                'dateFin' => $recette->getDate(), 
            ];
        }, $recettes);
    
        header('Content-Type: application/json');
        echo json_encode($recettesArray);
    }
    
    
    
    

}


