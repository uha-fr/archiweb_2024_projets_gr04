<?php

namespace App\Core;

class Form {

    private $formCode = '';

    /**
     * Génère le formulaire HTML
     *
     * @return string
     */
    public function create():string {
        return $this->formCode;
    }

    /**
     * Valide si le formulaire est valide
     *
     * @param array $form Tableau issu du formulaire ($_POST, $_GET)
     * @param array $champs Tableau listant les champs obligatoires
     * @return boolean
     */
    public static function validate(array $form, array $champs):bool {
        foreach($champs as $champ) {
            if(!isset($form[$champ]) || empty($form[$champ])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute les attributs envoyés à la balise
     *
     * @param array $attributs Tableau associatif (Ex : ['class' => 'form-control', 'required' => true])
     * @return string Chaîne de caractères générée
     */
    private function ajoutAttributs(array $attributs):string {
        $str = '';

        //Listage des attributs "courts"
        $courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

        foreach($attributs as $attribut => $valeur) {
            if(in_array($attribut, $courts) && $valeur == true) {
                $str .= " $attribut";
            }else{
                $str .= " $attribut='$valeur'";
            }
        }

        return $str;
    }

    /**
     * Balise d'ouverture du formulaire
     *
     * @param string $methode Méthode du formulaire (post ou get)
     * @param string $action Action du formulaire
     * @param array $attributs Attributs
     * @return self
     */
    public function debutForm(string $methode = 'post', string $action = '#', array $attributs = []):self {
        //Création balise form
        $this->formCode .= "<form action='$action' method='$methode'";

        //Ajout des attributs eventuels
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) . '>' : '>';

        return $this;
    }

    /**
     * Balise de fermeture du formulaire
     *
     * @return self
     */
    public function finForm():self {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * AJoute un label
     *
     * @param string $for
     * @param string $texte
     * @param array $attributs
     * @return self
     */
    public function ajoutLabelFor(string $for, string $texte, array $attributs = []):self {
        
        $this->formCode .= "<label for='$for'";
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        $this->formCode .= ">$texte</label>";

        return $this;
    }

    public function ajoutInput(string $type, string $nom, array $attributs = []):self {
        $this->formCode .= "<input type='$type' name='$nom'";
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) . '>' : '>';

        return $this;
    }
    
    public function ajoutTextArea(string $nom, string $texte = '', array $attributs = []):self {
        $this->formCode .= "<textarea name='$nom'";
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        $this->formCode .= ">$texte</textarea>";

        return $this;
    }

    public function ajoutSelect(string $nom, array $options, array $attributs = []):self {
        $this->formCode .= "<select name='$nom'";
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) . '>' : '>';
        foreach($options as $valeur => $texte) {
            $this->formCode .= "<option value='$valeur'>$texte</option>";
        }
        $this->formCode .= "</select>";
        return $this;
    }

    public function ajoutBouton(string $texte, array $attributs = []):self {
        $this->formCode .= '<button ';
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        $this->formCode .= ">$texte</button>";
        return $this;
    }

    public function ajoutTitre(string $texte, array $attributs = []):self {
        $this->formCode .= '<h1 ';
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        $this->formCode .= ">$texte</h1>";
        return $this;
    }

    public function ajoutLien(string $texte, array $attributs = []):self {
        $this->formCode .= '<a ';
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        $this->formCode .= ">$texte</a>";
        return $this;
    }

    /**
     * Ajoute un div autour des éléments du formulaire
     *
     * @param array $attributs Attributs du div
     * @param callable $callback Fonction de rappel pour ajouter les éléments dans le div
     * @return self
     */
    public function ajoutDiv(array $attributs, callable $callback):self {
        $this->formCode .= "<div";
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        $this->formCode .= ">";

        $callback($this);

        $this->formCode .= "</div>";

        return $this;
    }

    /**
     * Ajoute le code php pour gérer l'affichage des erreurs
     *
     * @param string $errorMessage Le message d'erreur
     * @return self
     */
    public function ajoutErr(string $errorMessage):self {
        if (!empty($errorMessage)) {
            $this->formCode .= "<div class='alert alert-danger' role='alert'>$errorMessage</div>";
        }

        return $this;
    }

    public function ajoutSuccess(string $successMsg):self {
        if (!empty($successMsg)) {
            $this->formCode .= "<div class='alert alert-success' role='alert'>$successMsg</div>";
        }

        return $this;
    }

}