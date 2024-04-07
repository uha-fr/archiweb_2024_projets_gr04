<?php

namespace App\Controllers;

use App\Models\PlanningModel;
use App\Models\PlanningRecetteModel;
use App\Models\RecetteModel;
use App\Models\RelationNutritionnisteModel;
use App\Core\Form;
use App\Models\RecetteAlimentModel;

class PlanningController extends Controller
{
    public function index()
    {
        $this->verifUtilisateurConnecte();

        $repoRecette = new RecetteModel();
        $recettes = $repoRecette->findAll();

        $repoRelation = new RelationNutritionnisteModel();
        $accesAccorde = $repoRelation->findBy(['idClient' => $this->getUserIdCo()]); 
        if(!empty($accesAccorde)) {
            $accesAccorde = $accesAccorde[0]->getNutritionnisteAccesPlanning();
        }else{
            $accesAccorde = "pasDeNutritionniste";
        }

        $optionsMois = [
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre'
        ];

        $form = new Form;
        $form->debutForm()
                ->ajoutSelect('listeMois', $optionsMois)
                ->ajoutBouton('Créer', ['type' => 'submit'])
                ->finForm();

        $ingredientsDetails = [];
        $afficherListe = false;

        if(isset($_POST['listeMois']) && !empty($_POST['listeMois'])) {
            $afficherListe = true;
            $repoPlanning = new PlanningModel();
            $idPlanningUser = $repoPlanning->findBy(['id_user' => $this->getUserIdCo()]);
            $repoPlanningRecette = new PlanningRecetteModel();
            $idAliments = $repoPlanningRecette->findByMonth($idPlanningUser[0]->getId(), $this->secure($_POST['listeMois']));
            
            if(!empty($idAliments)) {
                $repoRecetteAliment = new RecetteAlimentModel();
                $ingredientsDetails = $repoRecetteAliment->findDetailsAlimentByRecetteIdArray($idAliments);
            }

            setcookie('liste', json_encode($ingredientsDetails), time() + 3600, '/');
        }
        
        if(isset($_POST['telechargerRecette'])) {
            $nomFichier = 'export.txt';
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . $nomFichier . '"');

            if(isset($_COOKIE['liste'])) {
                $ingredients = json_decode($_COOKIE['liste']);

                foreach($ingredients as $ingredient) {
                    echo $ingredient->nom . " " . $ingredient->quantite . $ingredient->unite;
                    echo "\n";
                }
            }else{
                echo "Liste vide";
            }
            exit();
        }

        $this->render('planning/index.php', [
            'recettes' => $recettes,
            'titre' => 'Mon planning',
            'accesAccorde' => $accesAccorde,
            'controller' => 'Planning',
            'form' => $form->create(),
            'ingredientsDetailsListe' => $ingredientsDetails,
            'afficherListe' => $afficherListe,
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

    public function changerAccesPlanning() {
        $this->verifUtilisateurConnecte();

        $jsonData = file_get_contents('php://input');

        $data = json_decode($jsonData, true);
        if ($data !== null) {
            $repoRelation = new RelationNutritionnisteModel();
            $relation = $repoRelation->findBy(['idClient' => $this->getUserIdCo()]);

            if(!empty($relation)) {
                $data['acces'] == "true" ? $relation[0]->setNutritionnisteAccesPlanning(0) : $relation[0]->setNutritionnisteAccesPlanning(1);
                $relation[0]->update();
            }
            echo 200;
        }
    }
}
