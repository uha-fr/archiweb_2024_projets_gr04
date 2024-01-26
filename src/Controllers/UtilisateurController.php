<?php

namespace App\Controllers;

use App\Core\Form;

class UtilisateurController extends Controller {

    public function index() {
        var_dump("coucou");
    }

    public function login() {
        
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('name', 'Nom')
            ->ajoutInput('text', 'name', ['class' => 'input-form'])
            ->finForm();


        $this->render('utilisateur/login.php', [
            'form' => $form->create()
        ]);
    }

    /**
     * Formulaire d'inscription
     *
     * @return self
     */
    public function inscription() {
        // var_dump($_POST);
        // if(Form::validate($_POST)) {
                //valide
                //$email = strip_tags($_POST['email']);
                //lier avec la partie d'Alex
        // }

        $form = new Form;
    }
}