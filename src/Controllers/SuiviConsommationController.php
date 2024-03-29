<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\PlanningModel;
use App\Models\PlanningRecetteModel;
use App\Models\RecetteAlimentModel;

class SuiviConsommationController extends Controller {
    public function index() {

        $formJour = new Form;
        $formJour->debutForm('post', '', ['class' => 'role-form'])
                ->ajoutInput('date', 'dayDate', ['onchange' => 'submitForm(this)'])
                ->finForm();

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
        $optionsAnnees = ['2024' => '2024'];
        $formMois = new Form;
        $formMois->debutForm()
                    ->ajoutSelect('moisDate', $optionsMois)
                    ->ajoutSelect('moisAnneeDate', $optionsAnnees)
                    ->ajoutBouton('Valider', ['type' => 'submit'])
                    ->finForm();

        $formAnnee = new Form;
        $formAnnee->debutForm()
                    ->ajoutSelect('anneeDate', $optionsAnnees)
                    ->ajoutBouton('Valider', ['type' => 'submit'])
                    ->finForm();



        
        $repoPlanning = new PlanningModel();
        $idPlanning = $repoPlanning->findBy(['id_user' => $this->getUserIdCo()]);
        $repoPlanningRecette = new PlanningRecetteModel();

        //Recherche par jour
        if(isset($_POST['dayDate']) && !empty($_POST['dayDate'])) {
            
            $date = $this->secure($_POST['dayDate']);
            $titre = date('d-M-Y', strtotime($this->secure($_POST['dayDate'])));
            $labels = [$titre];
            $tabRecettesIds = $repoPlanningRecette->findByDay($idPlanning[0]->getId(), $date);
            $repoRecetteAliment = new RecetteAlimentModel();
            if(!empty($tabRecettesIds)) {
                $ingredientsDetails = $repoRecetteAliment->findDetailsAlimentByRecetteIdArray($tabRecettesIds);
                $data[] = $this->calculCalorie($ingredientsDetails);
            }else{
                $data[] = 0;
            }
        }else{
            // Recherche par mois
            if(isset($_POST['moisDate'])) {
                $date = $this->secure($_POST['moisDate']);
                $titre = date('F', mktime(0, 0, 0, $this->secure($_POST['moisDate']), 1)) . '-' . $this->secure($_POST['moisAnneeDate']) ;
                $labels = [$titre];
                $tabRecettesIds = $repoPlanningRecette->findByMonth($idPlanning[0]->getId(), $date);
                $repoRecetteAliment = new RecetteAlimentModel();
                if(!empty($tabRecettesIds)) {
                    $ingredientsDetails = $repoRecetteAliment->findDetailsAlimentByRecetteIdArray($tabRecettesIds);
                    $data[] = $this->calculCalorie($ingredientsDetails);
                }else{
                    $data[] = 0;
                }
            }else{
                //Rechercher par année
                if(isset($_POST['anneeDate'])) {
                    $date = $this->secure($_POST['anneeDate']);
                    $titre = 'Année ' . $this->secure($_POST['anneeDate']);
                    $labels = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                    foreach($optionsMois as $index => $value) {
                        $tabRecettesIds = $repoPlanningRecette->findByMonth($idPlanning[0]->getId(), $index);
                        $repoRecetteAliment = new RecetteAlimentModel();
                        if(!empty($tabRecettesIds)) {
                            $ingredientsDetails = $repoRecetteAliment->findDetailsAlimentByRecetteIdArray($tabRecettesIds);
                            $data[] = $this->calculCalorie($ingredientsDetails);
                        }else{
                            $data[] = 0;
                        }
                    }

                // Aujourd'hui
                }else{
                    $date = date('Y-m-d');
                    $titre = 'Aujourd\'hui';
                    $labels = ['Aujourd\'hui'];
                    $tabRecettesIds = $repoPlanningRecette->findByDay($idPlanning[0]->getId(), $date);
                    $repoRecetteAliment = new RecetteAlimentModel();
                    if(!empty($tabRecettesIds)) {
                        $ingredientsDetails = $repoRecetteAliment->findDetailsAlimentByRecetteIdArray($tabRecettesIds);
                        $data[] = $this->calculCalorie($ingredientsDetails);
                    }else{
                        $data[] = 0;
                    }
                }
            }
        }
        
        return $this->render('suiviConsommation/index.php', [
            'data' => $data,
            'labels' => $labels,
            'titre' => $titre,
            'formJour' => $formJour->create(),
            'formMois' => $formMois->create(),
            'formAnnee' => $formAnnee->create(),
        ]);
    }

    private function calculCalorie($ingredients) {
        $totalCalorie = 0;
        foreach($ingredients as $ingredient) {
            if($ingredient->unite == 'kg' || $ingredient->unite == 'L') {
                $totalCalorie += $ingredient->quantite * 10 * $ingredient->kcal;
            }else {
                if($ingredient->unite == 'g') {
                    $totalCalorie += $ingredient->quantite / 100 * $ingredient->kcal; 
                }
            }
        }
        return $totalCalorie;
    }
}