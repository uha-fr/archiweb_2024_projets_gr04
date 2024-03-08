<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UtilisateursModel;

class UtilisateurController extends Controller
{

    public function index()
    {
        $controller = new UtilisateurController;
        $controller->login();
    }

    /**
     * Formulaire de connexion
     */
    public function login()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        if (isset($_SESSION['utilisateur'])) {
            // Utilisateur déjà connecté, redirection vers la page d'accueil
            header('Location: ../accueil');
            exit;
        }

        // Vérification si erreurs
        $errorMessage = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);

        // Vérification si succès d'inscription (La page d'inscription redirige vers la page de connexion si l'inscription s'est bien passé)
        $successMessage = $_SESSION['sign_in_success'] ?? '';
        unset($_SESSION['sign_in_success']);

        // Génération du formulaire
        $form = new Form;
        $form->debutForm('post',  'checkLogin', ['class' => 'border shadow p-3 rounded', 'style' => 'width: 450px'])
            ->ajoutTitre('Connexion', ['class' => 'text-center p3'])
            ->ajoutErr($errorMessage)
            ->ajoutSuccess($successMessage)
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $defaultValue = $_SESSION['last_username_attempt'] ?? '';
                $form->ajoutLabelFor('username', 'Nom d\'utilisateur', ['class' => 'form-label'])
                    ->ajoutInput('text', 'username', ['class' => 'form-control', 'id' => 'username', 'required', 'value' => $defaultValue]);
            })
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $form->ajoutLabelFor('password', 'Mot de passe', ['class' => 'form-label'])
                    ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'password', 'required']);
            })
            ->ajoutBouton('Confirmer', [
                'type' => 'submit',
                'class' => 'btn btn-primary'
            ])
            ->ajoutLien('S\'inscrire', [
                'href' => 'signIn',
                'class' => 'btn btn-link'
            ])
            ->finForm();


        unset($_SESSION['last_username_attempt']);

        // Affichage formulaire
        $this->render('utilisateur/login.php', [
            'form' => $form->create()
        ], 'empty.php');
    }

    /**
     * Après soumission du login
     */
    public function checkLogin()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        // Si les champs sont vides, rediriger l'utilisateur sur l'écran de login avec un message d'erreur
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $_SESSION['login_error'] = 'Veuillez remplir les champs !';
            header('Location: ../utilisateur/login');
            exit;
        } else { // Autrement traiter les données et autoriser ou non la connexion
            function test_input($data): string
            {
                $data = trim($data);
                $data = stripslashes($data);
                return htmlspecialchars($data);
            }

            $username = test_input($_POST['username']);
            $password = test_input($_POST['password']);
            $password = hash('sha256', $password);

            $utilisateursModel = new UtilisateursModel();
            $result = $utilisateursModel->findBy([
                'nom_utilisateur' => $username,
                'mdp' => $password
            ]);

            if (!empty($result)) {
                // var_dump($result);
                if ($result[0]->getMdp() == $password) {
                    $_SESSION['utilisateur'] = [
                        'id' => $result[0]->getId(),
                        'email' => $result[0]->getEmail(),
                        'role' => $result[0]->getRole(),
                        'nom_utilisateur' => $result[0]->getNomUtilisateur()
                    ];

                    //header('Location: /' . HOST . '/accueil');
                    header('Location: ../accueil');
                    exit;
                } else
                    $this->saveErrAndRedirect();
            } else
                $this->saveErrAndRedirect();
        }
    }

    /**
     * Fonction qui gère la déconnexion
     */
    public function logout()
    {
        $this->verifUtilisateurConnecte();

        session_unset();
        session_destroy();
        header('Location: ../accueil');
        exit;
    }

    /**
     * Formulaire d'inscription
     */
    public function signIn()
    {
        session_start();

        $errorMessage = $_SESSION['sign_in_error'] ?? '';
        unset($_SESSION['sign_in_error']);

        // Génération du formulaire
        $form = new Form;
        $form->debutForm('post',  'addUser', [
            'class' => 'border shadow p-3 rounded',
            'style' => 'width: 450px'
        ])
            ->ajoutTitre('Inscription', ['class' => 'text-center p3'])
            ->ajoutErr($errorMessage)
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $defaultValue = $_SESSION['last_username_attempt'] ?? '';
                $form->ajoutLabelFor('username', 'Nom d\'utilisateur', ['class' => 'form-label'])
                    ->ajoutInput('text', 'username', ['class' => 'form-control', 'id' => 'username', 'required', 'value' => $defaultValue]);
            })
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $form->ajoutLabelFor('password', 'Mot de passe', ['class' => 'form-label'])
                    ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'password', 'required']);
            })
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $form->ajoutLabelFor('confirm_password', 'Confirmer le mot de passe', ['class' => 'form-label'])
                    ->ajoutInput('password', 'confirm_password', ['class' => 'form-control', 'id' => 'confirm_password', 'required']);
            })
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $defaultValue = $_SESSION['last_email_attempt'] ?? '';
                $form->ajoutLabelFor('email', 'Email', ['class' => 'form-label'])
                    ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email', 'required', 'value' => $defaultValue]);
            })
            ->ajoutBouton('S\'inscrire', [
                'type' => 'submit',
                'class' => 'btn btn-primary'
            ])
            ->ajoutLien('Se connecter', [
                'href' => 'login',
                'class' => 'btn btn-link'
            ])
            ->finForm();

        unset($_SESSION['last_username_attempt']);
        unset($_SESSION['last_email_attempt']);

        // Affichage formulaire
        $this->render('utilisateur/signIn.php', [
            'form' => $form->create()
        ], 'empty.php');
    }

    /**
     * Après soumission du formulaire d'inscription
     */
    public function addUser()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['username']) &&
                !empty($_POST['password']) &&
                !empty($_POST['confirm_password']) &&
                !empty($_POST['email'])) {

                // Vérification du format de l'adresse email
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                    $this->saveErrAndRedirectToSignIn('Adresse email invalide !');

                // Récupérer les données du formulaire
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $email = $_POST['email'];

                // Vérifier si les mots de passe correspondent
                if ($password !== $confirm_password)
                    $this->saveErrAndRedirectToSignIn('Les mots de passe doivent correspondre !');

                // Hacher le mot de passe
                $hashed_password = hash('sha256', $password);

                // Check si doublons dans la base
                $utilisateursModel = new UtilisateursModel();
                $result = $utilisateursModel->findBy(['nom_utilisateur' => $username]);
                if (!empty($result))
                    $this->saveErrAndRedirectToSignIn('Nom d\'utilisateur déjà utilisé !');

                // Ajout de l'utilisateur à la base avec le role 'utilisateur' par défaut
                $success = $utilisateursModel->addUser($username, $hashed_password, $email, 'utilisateur');

                if ($success) {
                    echo 'Utilisateur ajouté avec succès.';
                } else {
                    echo 'Erreur lors de l\'ajout de l\'utilisateur.';
                }

                $this->saveSuccessAndRedirectToLogin('Inscription réussie, veuillez vous connecter !');

            } else
                $this->saveErrAndRedirectToSignIn('Veuillez remplir tous les champs !');

        } else {
            header("Location: ../inscription.php");
            exit;
        }
    }

    /**
     * Explicite
     * @return void → Redirection vers la page de Login
     */
    public function saveErrAndRedirect(): void
    {
        // Enregistrement du dernier nom d'utilisateur saisi
        $_SESSION['last_username_attempt'] = $_POST['username'];
        // Message d'erreur à afficher
        $_SESSION['login_error'] = 'Nom d\'utilisateur ou mot de passe incorrect !';
        // Redirection vers la page de login
        header('Location: ../utilisateur/login');
        exit();
    }

    /**
     * Explicite
     * @return void → Redirection vers la page d'Inscription
     */
    public function saveErrAndRedirectToSignIn($errMsg): void
    {
        // Enregistrement du dernier nom d'utilisateur saisi et de la dernière adresse email
        if ($errMsg != 'Nom d\'utilisateur déjà utilisé !')
            $_SESSION['last_username_attempt'] = $_POST['username'];
        $_SESSION['last_email_attempt'] = $_POST['email'];
        // Message d'erreur à afficher
        $_SESSION['sign_in_error'] = $errMsg;
        // Redirection vers la page de login
        header('Location: ../utilisateur/signIn');
        exit();
    }

    /**
     * Explicite
     * @return void → Redirection vers la page de Login
     */
    public function saveSuccessAndRedirectToLogin($successMsg): void
    {
        // Message de succès à afficher
        $_SESSION['sign_in_success'] = $successMsg;
        // Redirection vers la page de login
        header('Location: ../utilisateur/login');
        exit();
    }
}
