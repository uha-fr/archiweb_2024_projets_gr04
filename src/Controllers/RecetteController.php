<?php

namespace App\Controllers;

use App\Models\RecetteModel;
use App\Core\Form;
use App\Models\AlimentModel;
use App\Models\RecetteAlimentModel;

class RecetteController extends Controller {

    public function index() {
        $this->verifUtilisateurConnecte();

        if (isset($_POST['effacerFiltre'])) {
            setcookie('r', '', time() - 3600, '/');
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        }

        $recetteModel = new RecetteModel();
        $recettesParPage = 10;

        if(isset($_GET['page']) && !empty($_GET['page'])) {
            $pageActuelle = (int) $this->secure($_GET['page']);
        }else{
            $pageActuelle = 1;
        }

        if (isset($_POST['aliments']) && is_array($_POST['aliments']) || isset($_COOKIE['r'])) {
            if(isset($_POST['aliments'])) {
                $alimentsFrigo = $_POST['aliments'];
                if($this->valideArrayNumeric($alimentsFrigo)) {
                    $recettes = $recetteModel->findByIdsAliments($alimentsFrigo);
                    setcookie('r', json_encode($recettes), time() + 3600, '/');
                }else{
                    header('Location: ' . WEBROOT . '/');
                    exit;
                }
            }else{
                $recettes = json_decode($_COOKIE['r']);
            }

            $nbRecette = count($recettes);
            $nbPage = ceil($nbRecette / $recettesParPage);
            if($pageActuelle > $nbPage) {
                $pageActuelle = $nbPage;
            }
            $premierItem = $pageActuelle * $recettesParPage - $recettesParPage;
            $recettes = array_slice($recettes, $premierItem, $premierItem + $recettesParPage);
        }else{
            $nbRecette = $recetteModel->countAllRecettes();
            $nbPage = ceil($nbRecette->nbRecette / $recettesParPage);
            if($pageActuelle > $nbPage) {
                $pageActuelle = $nbPage;
            }
            $premierItem = $pageActuelle * $recettesParPage - $recettesParPage;
            if($premierItem < 0) $premierItem = 0;
            $recettes = $recetteModel->findByLimits($premierItem, $recettesParPage);
        }

        $formAliments = new Form;
        $formAliments->ajoutInput('search', 'aliment', ['id' => 'monAliment', 'placeholder' => 'Pomme de terre ...' ,'autocomplete' => 'off', 'class' => 'ps-2', 'style' => 'width: 340px;'])
            ->ajoutBouton('+', ['id' => 'boutonAddFrigo', 'class' => 'btn btn-primary w-50']);

        $boutonTrouverRecettes = new Form;
        $boutonTrouverRecettes->debutForm('post', '#', ['id' => 'formFindRecette', 'class' => 'w-100'])
            ->ajoutBouton('Trouver une recette', ['id' => 'findRecette', 'type' => 'sumbit', 'class' => 'btn btn-primary w-100'])
            ->finForm();

        $btnEffacerFiltres = new Form;
        $btnEffacerFiltres->debutForm()
            ->ajoutInput('hidden', 'effacerFiltre')
            ->ajoutBouton('Effacer les filtres', ['type' => 'submit', 'class' => 'btn border'])
            ->finForm();


        $this->render('recette/index.php', [
            'recettes' => $recettes,
            'formAliments' => $formAliments->create(),
            'boutonTrouverRecettes' => $boutonTrouverRecettes->create(),
            'premierItem' => $premierItem,
            'pageActuelle' => $pageActuelle,
            'nbPage' => $nbPage,
            'btnEffacerFiltres' => $btnEffacerFiltres->create(),
            'frigoType' => 'index',
        ]);
    }

    public function lire(string $id) {
        $this->verifUtilisateurConnecte();

        $id = $this->secure($id);
        $recetteModel = new RecetteModel();
        $recette = $recetteModel->findByUser($id);
        if($recette == null) {
            exit('La page recherchée n\'existe pas');
        } 

        $retourBouton = new Form;
        $retourBouton->ajoutLien('Retour', ['href' => '../', 'class' => 'btn btn-primary mb-3']);

        $alimentModel = new AlimentModel();
        $ingredients = $alimentModel->findAlimentsByRecetteId($id);

        $totalCalorie = 0;
        foreach($ingredients as $ingredient) {
            if($ingredient->unite == 'kg' || $ingredient->unite == 'L') {
                $totalCalorie += $ingredient->quantite * 10 * $ingredient->getKcal();
            }else {
                if($ingredient->unite == 'g') {
                    $totalCalorie += $ingredient->quantite / 100 * $ingredient->getKcal(); 
                }
            }
        }
        
        $this->render('recette/lire.php', [
            'recette' => $recette,
            'ingredients' => $ingredients,
            'totalCalorie' => $totalCalorie,
            'retour' => $retourBouton->create(),
        ]);
    }

    public function ajoutermodifier($idRecette = null) {
        $this->verifUtilisateurConnecte();
        
        $recetteModel = new RecetteModel();
        $recetteAlimentModel = new RecetteAlimentModel();

        $isModification = false;
        if($idRecette != null) {
            $idRecette = $this->secure($idRecette);
            $isModification = true;
            $recetteEdit = $recetteModel->findByUser($idRecette);
            $alimModel = new AlimentModel();
            $ingredientsEdit = $alimModel->findAlimentsByRecetteId($idRecette);
            $this->setIngredientFrigo($ingredientsEdit);
        }

        $erreurs = [];
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['nom']) && !empty($_POST['nom'])) {
                $nomRecette = trim($this->secure($_POST['nom']));
                $descriptionRecette = trim($this->secure($_POST['desc']));
                if(isset($_POST['aliments'])) {

                    $ingredients = $_POST['aliments'];

                    if(! $this->valideArrayNumeric($ingredients)) {
                        header('Location: ' . WEBROOT . '/');
                        exit;
                    }
                }
                if($idRecette != null) {
                    $recetteModel->supprimerRecetteById($idRecette);
                }

                $idRecette = uniqid();
                $recetteModel->setId($idRecette)
                            ->setNom($nomRecette)
                            ->setDescription($descriptionRecette)
                            ->setIdUtilisateur($this->getUserIdCo());
                $recetteModel->create();

                foreach($ingredients as $idIngredient) {
                    $recetteAlimentModel = new RecetteAlimentModel();
                    $recetteAlimentModel->setIdRecette($idRecette)
                                        ->setIdAliment($idIngredient)
                                        ->setQuantite(1);
                    $recetteAlimentModel->create();
                }
                header('Location: ' . WEBROOT . '/recette');
                exit;
            }else{
                $erreurs['nomVide'] = "Veuillez mettre un nom à votre recette";
            }
        }

        $formDebut = new Form;
        $formDebut->debutForm('post', '#', ['id' => 'formFindRecette'])
            ->ajoutLabelFor('nom', 'Nom', [], true);
            if($idRecette != null) {
                $formDebut->ajoutInput('text', 'nom', ['class' => 'form-control mt-1 mb-2', 'required', 'value' => $recetteEdit->getNom()], true)
                ->ajoutLabelFor('desc', 'Description', [], true)
                ->ajoutTextArea('desc', $recetteEdit->getDescription(), ['class' => 'form-control mt-1 mb-2'], true);
            }else{
                $formDebut->ajoutInput('text', 'nom', ['class' => 'form-control mt-1 mb-2', 'required'], true)
                ->ajoutLabelFor('desc', 'Description', [], true)
                ->ajoutTextArea('desc', '', ['class' => 'form-control mt-1 mb-2'], true);
            }
        
        $formFin = new Form;
        $formFin->ajoutLien('Annuler', ['href' => '/recette', 'class' => 'btn w-25 border']);
            if($idRecette != null) {
                $formFin->ajoutBouton('Modifier la recette', ['type' => 'submit', 'class' => 'btn btn-primary w-75']);
            }else{
                $formFin->ajoutBouton('Ajouter la recette', ['type' => 'submit', 'class' => 'btn btn-primary w-75']);
            }
                $formFin->finForm();

        $formAliments = new Form;
        $formAliments->ajoutLabelFor('aliment', 'Ingrédient', [], true)
            ->ajoutInput('search', 'aliment', ['id' => 'monAliment', 'autocomplete' => 'off', 'class' => 'form-control mt-1 mb-2'], true)
            ->ajoutBouton('+', ['id' => 'boutonAddFrigo', 'class' => 'btn btn-primary', 'style' => 'height: 39px; margin-top: 27px;']);

        $this->render('recette/ajouterModifier.php', [
            'formDebut' => $formDebut->create(),
            'formFin' => $formFin->create(),
            'formAliments' => $formAliments->create(),
            'erreurs' => $erreurs,
            'isModification' => $isModification,
            'frigoType' => 'creationModification',
        ]);
    }

    public function supprimer(string $id) {
        $this->verifUtilisateurConnecte();

        $id = $this->secure($id);

        $recetteModel = new RecetteModel();
        $recetteModel->supprimerRecetteById($id);

        header('Location: ' . WEBROOT . '/recette');
        exit;
    }

    private function valideArrayNumeric(array $datas):bool {
        foreach($datas as $data) {
            if(!is_numeric($data)) return false;
        }
        return true;
    }

    private function setIngredientFrigo(array $ingredients) {
        echo '<script>let ingredientsEdit = ' . json_encode($ingredients) . '</script>';
    }
}