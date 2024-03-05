<?php

namespace App\Controllers;

use App\Models\UtilisateursModel;

class AdminController extends Controller {

    public function index() {
        $this->isAdmin();

        // Affichage par défaut
        $this->gestionUtilisateurs();
    }

    public function gestionUtilisateurs() {
        $this->isAdmin();

        $repo = new UtilisateursModel();

        $roles = ['admin' => 'Administrateur', 'nutritionniste' => 'Nutritionniste', 'utilisateur' => 'Utilisateur'];

        if(isset($_POST['role']) && !empty($_POST['role'])) {
            $user = $repo->find($this->secure($_POST['userId']));
            $nouveauRole = $this->secure($_POST['role']);
            if(!array_key_exists($nouveauRole, $roles)) {
                header('Location: /');
                exit;
            }
            $user->setRole($nouveauRole);
            $user->update();
        }

        $itemsParPage = 12;
        $nbItems = $repo->countAll();
        $nbPage = ceil((int)$nbItems->items / $itemsParPage);

        if(isset($_GET['page']) && !empty($_GET['page'])) {
            $pageActuelle = (int) $this->secure($_GET['page']);
            if($pageActuelle > $nbPage) {
                $pageActuelle = $nbPage;
            }
            
        }else{
            $pageActuelle = 1;
        }

        $premierItem = $pageActuelle * $itemsParPage - $itemsParPage;
        $items = $repo->findByLimitsGeneral($premierItem, $itemsParPage);


        return $this->render('admin/gestionUtilisateur.php', [
            'utilisateurs' => $items,
            'nbPage' => $nbPage,
            'pageActuelle' => $pageActuelle,
            'roles' => $roles,
        ], 'admin.php');
    }

    public function isAdmin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(!$_SESSION['utilisateur']['role'] == "admin") {
            header('Location: .');
            exit;
        }
    }
}