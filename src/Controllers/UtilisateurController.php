<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UtilisateursModel;
use DateInterval;
use DateTime;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class UtilisateurController extends Controller
{

    public function index()
    {
        header('Location: ../utilisateur/login');
    }

    /**
     * Formulaire de connexion
     */
    public function login()
    {
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
            ->ajoutLien('Mot de passe oublié ?', [
                'href' => 'forgotPasswordForm',
                'class' => 'btn btn-link'
            ])
            ->finForm();


        unset($_SESSION['last_username_attempt']);

        // Affichage formulaire
        $this->render('utilisateur/login.php', [
            'form' => $form->create()
        ]);
    }

    /**
     * Après soumission du login
     */
    public function checkLogin()
    {
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

            $username = strtolower(test_input($_POST['username']));
            $password = test_input($_POST['password']);
            $password = hash('sha256', $password);

            $utilisateursModel = new UtilisateursModel();
            $result = $utilisateursModel->findBy([
                'nom_utilisateur' => $username,
                'mdp' => $password
            ]);

            if (!empty($result)) {
                // var_dump($result);
                if ($result[0]->mdp == $password) {
                    $_SESSION['utilisateur'] = [
                        'id' => $result[0]->id,
                        'email' => $result[0]->email,
                        'role' => $result[0]->role,
                        'nom_utilisateur' => $result[0]->nom_utilisateur
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
        ]);
    }

    /**
     * Après soumission du formulaire d'inscription
     */
    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['username']) &&
                !empty($_POST['password']) &&
                !empty($_POST['confirm_password']) &&
                !empty($_POST['email'])) {

                // Vérification du format de l'adresse email
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                    $this->saveErrAndRedirectToSignIn('Adresse email invalide !');

                // Récupérer les données du formulaire
                $username = strtolower($_POST['username']);
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
     * Formulaire de récupération de mot de passe
     */
    public function forgotPasswordForm()
    {
        $errorMessage = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);

        // Génération du formulaire
        $form = new Form;
        $form->debutForm('post',  'forgotPassword', ['class' => 'border shadow p-3 rounded', 'style' => 'width: 450px'])
            ->ajoutTitre('Récupération du mot de passe', ['class' => 'text-center p3'])
            ->ajoutErr($errorMessage)
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $form->ajoutLabelFor('username', 'Nom d\'utilisateur', ['class' => 'form-label'])
                    ->ajoutInput('text', 'username', ['class' => 'form-control', 'id' => 'username', 'required']);
            })
            ->ajoutBouton('Confirmer', [
                'type' => 'submit',
                'class' => 'btn btn-primary'
            ])
            ->finForm();

        // Affichage formulaire
        $this->render('utilisateur/forgotPassword.php', [
            'form' => $form->create()
        ]);
    }

    /**
     * Après soumission du formulaire de récupération de mot de passe
     */
    public function forgotPassword()
    {
        if (empty($_POST['username'])) {
            $_SESSION['login_error'] = 'Veuillez remplir le champ nom d\'utilisateur !';
            header('Location: ../utilisateur/forgotPasswordForm');
            exit;
        }

        $username = $_POST['username'];
        $utilisateursModel = new UtilisateursModel();
        $result = $utilisateursModel->findBy(['nom_utilisateur' => $username]);

        if (empty($result)) {
            $_SESSION['login_error'] = 'Aucun compte n\'est lié au nom d\'utilisateur '. $username .' !';
            header('Location: ../utilisateur/forgotPasswordForm');
            exit;
        }

        // Générer un token unique
        $token = bin2hex(random_bytes(50));
        $utilisateursModel->saveToken($result[0]->id, $token);

        // Construire le lien à envoyer par mail en fonction de l'environnement
        $env = getenv('ENV');
        $link = ($env === 'dev') ? 'http://' . $_SERVER['HTTP_HOST'] . '/utilisateur/resetPassword?token=' . $token : 'http://yourwebsite.com/resetPassword?token=' . $token; // TODO : Remplacer par le nom de domaine du site
        $imageLink = ($env === 'dev') ? 'http://' . $_SERVER['HTTP_HOST'] . '/public/images/logo.png' : 'http://yourwebsite.com/public/images/logo.png';

        // Envoyer l'e-mail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML();
        $mail->Username = $_ENV['MAIL'];
        $mail->Password = $_ENV['MAILPASS'];
        $mail->SetFrom($_ENV['MAIL']);
        $mail->Subject = 'Réinitialisation du mot de passe';
        $mail->Body = '
            <html>
            <head>
                <style>
                    body {
                        background-color: #f0f0f0;
                        font-family: Arial, sans-serif;
                    }
                    .container {
                        background-color: #ffffff;
                        margin: 0 auto;
                        padding: 20px;
                        max-width: 600px;
                    }
                    .button {
                        background-color: #f19f1e;
                        border: none;
                        color: white;
                        padding: 15px 32px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-size: 16px;
                        margin: 4px 2px;
                        cursor: pointer;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <img src="' . $imageLink . '" alt="Logo du site">
                    <h2>Bonjour ' . $username . ' !</h2>
                    <p>Vous avez récemment demandé une réinitialisation de votre mot de passe. Pour réinitialiser votre mot de passe, veuillez cliquer sur le bouton suivant :</p>
                    <a href="' . $link . '" class="button">Réinitialiser le mot de passe</a>
                </div>
            </body>
            </html>
        ';
        $mail->AddAddress($result[0]->email);
        // die($result[0]->email);

        if(!$mail->Send()) {
            echo 'Erreur lors de l\'envoi de l\'e-mail.';
            echo 'Erreur : ' . $mail->ErrorInfo;
            exit;
        }

        $_SESSION['sign_in_success'] = 'Un email de récupération a été envoyé à votre adresse mail.';
        header('Location: ../utilisateur/login');
        exit;
    }

    /**
     * Formulaire de réinitialisation du mot de passe
     */
    public function resetPassword()
    {
        // Récupérer le token à partir de l'URL
        $token = $_GET['token'] ?? null;

        if (!$token) {
            $_SESSION['login_error'] = 'Token invalide !';
            header('Location: ../utilisateur/login');
            exit;
        }

        // Vérifier si le token existe dans la base de données
        $utilisateursModel = new UtilisateursModel();
        $user = $utilisateursModel->findBy(['token' => $token]);

        if (!$user) {
            $_SESSION['login_error'] = 'Token invalide !';
            header('Location: ../utilisateur/login');
            exit;
        }

        $resetPasswordError = $_SESSION['reset_password_error'] ?? '';
        unset($_SESSION['reset_password_error']);

        // Génération du formulaire
        $form = new Form;
        $form->debutForm('post',  '', ['class' => 'border shadow p-3 rounded', 'style' => 'width: 450px'])
            ->ajoutTitre('Réinitialisation du mot de passe', ['class' => 'text-center p3'])
            ->ajoutErr($resetPasswordError)
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $form->ajoutLabelFor('password', 'Nouveau mot de passe', ['class' => 'form-label'])
                    ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'password', 'required']);
            })
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $form->ajoutLabelFor('confirm_password', 'Confirmer le nouveau mot de passe', ['class' => 'form-label'])
                    ->ajoutInput('password', 'confirm_password', ['class' => 'form-control', 'id' => 'confirm_password', 'required']);
            })
            ->ajoutBouton('Réinitialiser le mot de passe', [
                'type' => 'submit',
                'class' => 'btn btn-primary'
            ])
            ->finForm();


        // Si le formulaire de réinitialisation du mot de passe est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                $_SESSION['reset_password_error'] = 'Les mots de passe doivent correspondre !';
                header('Location: ../utilisateur/resetPassword?token=' . $token);
                exit;
            }

            $hashed_password = hash('sha256', $password);
            $utilisateursModel->updatePassword($user[0]->id, $hashed_password);

            // Supprimer le token lié à la demande de réinitialisation du mot de passe
            $utilisateursModel->deleteToken($user[0]->id);

            $_SESSION['sign_in_success'] = 'Votre mot de passe a été réinitialisé avec succès. Veuillez vous connecter avec votre nouveau mot de passe.';
            header('Location: ../utilisateur/login');
            exit;
        }

        // Afficher le formulaire de réinitialisation du mot de passe
        $this->render('utilisateur/resetPassword.php', [
            'form' => $form->create()
        ]);
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
