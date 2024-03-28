<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\RecetteModel;
use App\Models\RelationNutritionnisteModel;
use App\Models\UtilisateursModel;

class NutritionnisteGestionRelationController extends Controller {
    public function index() {
        $this->verifUtilisateurConnecte();
        $this->isNutritionniste();

        /* Relations */
        $repo = new RelationNutritionnisteModel();

        $itemsParPage = 12;
        $nbItems = $repo->countAll(['idNutritionniste' => $this->getUserIdCo()]);
        $nbPage = ceil((int)$nbItems->items / $itemsParPage);

        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $pageActuelle = (int) $this->secure($_GET['page']);
            if ($pageActuelle > $nbPage) {
                $pageActuelle = $nbPage;
            }
        } else {
            $pageActuelle = 1;
        }
        $premierItem = $pageActuelle * $itemsParPage - $itemsParPage;
        $items = $repo->findByLimitesUtilisateursRelationNutritionnisteDetails($premierItem, $itemsParPage, $this->getUserIdCo());

        /* Notifications demande de relations */
        $repoNotification = new NotificationModel();
        $notificationsDemande = $repoNotification->findUserOrigineNameByUserDest($this->getUserIdCo());

        return $this->render('nutritionnisteGestionRelation/index.php', [
            'relations' => $items,
            'pageActuelle' => $pageActuelle,
            'nbPage' => $nbPage,
            'notificationsDemande' => $notificationsDemande,
        ]);
    }

    public function voirPlanning(int $idClient) {
        $this->verifUtilisateurConnecte();
        $this->isNutritionniste();

        $idClient = $this->secure($idClient);

        $repoUtilisateur = new UtilisateursModel();
        $client = $repoUtilisateur->find($idClient);

        $repoRelation = new RelationNutritionnisteModel();
        $relation = $repoRelation->findBy(['idClient' => $idClient]);
        $relation = $relation ? $relation[0] : null;

        $titre = $client ? 'Planning de ' . $client->getNomUtilisateur() : 'Erreur';

        $repoRecette = new RecetteModel();
        $recettes = $repoRecette->findAll();

        $this->render('planning/index.php', [
            'client' => $client,
            'relation' => $relation,
            'titre' => $titre,
            'recettes' => $recettes,
            'controller' => 'NutritionnisteGestionRelation'
        ]);
    }

    public function reponseNotifDemandeRelation() {
        $this->verifUtilisateurConnecte();

        $jsonData = file_get_contents('php://input');

        $data = json_decode($jsonData, true);

        if ($data !== null) {
            if($data['response'] === true) {
                $relation = new RelationNutritionnisteModel();
                $relation->setIdNutritionniste($this->getUserIdCo())
                            ->setId(uniqid())
                            ->setIdClient($this->secure($data['idClient']));
                $relation->create();
            }
            $repo = new NotificationModel();
            $repo->delete($this->secure($data['idNotif']));
            
            echo 200;
        }
    }

    private function isNutritionniste() {
        if($_SESSION['utilisateur']['role'] != "nutritionniste") {
            header('Location: /accueil');
            exit;
        }
    }
}