<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\PlanningModel;
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
        header('Location: ' . WEBROOT . '/utilisateur/login');
    }

    /**
     * Formulaire de connexion
     */
    public function login()
    {
        if (isset($_SESSION['utilisateur'])) {
            // Utilisateur déjà connecté, redirection vers la page d'accueil
            header('Location: ' . WEBROOT . '/accueil');
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
            header('Location: ' . WEBROOT . '/utilisateur/login');
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
                if ($result[0]->getMdp() == $password) {
                    $_SESSION['utilisateur'] = [
                        'id' => $result[0]->getId(),
                        'email' => $result[0]->getEmail(),
                        'role' => $result[0]->getRole(),
                        'nom_utilisateur' => $result[0]->getNomUtilisateur()
                    ];

                    header('Location: ' . WEBROOT . '/accueil');
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
        header('Location: ' . WEBROOT . '/accueil');
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
                $newIdUser = uniqid();
                $newUser = new UtilisateursModel();
                $newUser->setId($newIdUser)
                        ->setNomUtilisateur($username)
                        ->setMdp($hashed_password)
                        ->setEmail($email)
                        ->setRole('utilisateur');
                $newUser->create();

                //Création planning vide
                $repoPlanning = new PlanningModel();
                $idPlanningUser = uniqid();
                $repoPlanning->setId($idPlanningUser)
                    ->setId_user($newIdUser);
                $repoPlanning->create();

                if (true) {
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
            header('Location: ' . WEBROOT . '/utilisateur/forgotPasswordForm');
            exit;
        }

        $username = $_POST['username'];
        $utilisateursModel = new UtilisateursModel();
        $result = $utilisateursModel->findBy(['nom_utilisateur' => $username]);

        if (empty($result)) {
            $_SESSION['login_error'] = 'Aucun compte n\'est lié au nom d\'utilisateur '. $username .' !';
            header('Location: ' . WEBROOT . '/utilisateur/forgotPasswordForm');
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

        if(!$mail->Send()) {
            echo 'Erreur lors de l\'envoi de l\'e-mail.';
            echo 'Erreur : ' . $mail->ErrorInfo;
            exit;
        }

        $_SESSION['sign_in_success'] = 'Un email de récupération a été envoyé à votre adresse mail.';
        header('Location: ' . WEBROOT . '/utilisateur/login');
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
            header('Location: ' . WEBROOT . '/utilisateur/login');
            exit;
        }

        // Vérifier si le token existe dans la base de données
        $utilisateursModel = new UtilisateursModel();
        $user = $utilisateursModel->findBy(['token' => $token]);

        if (!$user) {
            $_SESSION['login_error'] = 'Token invalide !';
            header('Location: ' . WEBROOT . '/utilisateur/login');
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
                header('Location: ' . WEBROOT . '/utilisateur/resetPassword?token=' . $token);
                exit;
            }

            $hashed_password = hash('sha256', $password);
            $utilisateursModel->updatePassword($user[0]->id, $hashed_password);

            // Supprimer le token lié à la demande de réinitialisation du mot de passe
            $utilisateursModel->deleteToken($user[0]->id);

            $_SESSION['sign_in_success'] = 'Votre mot de passe a été réinitialisé avec succès. Veuillez vous connecter avec votre nouveau mot de passe.';
            header('Location: ' . WEBROOT . '/utilisateur/login');
            exit;
        }

        // Afficher le formulaire de réinitialisation du mot de passe
        $this->render('utilisateur/resetPassword.php', [
            'form' => $form->create()
        ]);
    }

    public function settings() {
        // Récupération des messages d'erreur et de succès
        $errorMessage = $_SESSION['settings_error'] ?? '';
        $successMessage = $_SESSION['settings_success'] ?? '';
        $errorPswMessage = $_SESSION['settings_psw_error'] ?? '';
        $successPswMessage = $_SESSION['settings_psw_success'] ?? '';

        unset($_SESSION['settings_error']);
        unset($_SESSION['settings_success']);
        unset($_SESSION['settings_psw_error']);
        unset($_SESSION['settings_psw_success']);

        // Génération du formulaire de modification de l'adresse e-mail
        $emailForm = new Form;
        $emailForm->debutForm('post', '../utilisateur/changeEmail', ['class' => 'border shadow p-3 rounded', 'style' => 'width: 450px'])
            ->ajoutTitre('Changer d\'adresse e-mail', ['class' => 'text-center p3'])
            ->ajoutErr($errorMessage)
            ->ajoutSuccess($successMessage)
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $form->ajoutLabelFor('email', 'Nouvelle adresse e-mail', ['class' => 'form-label'])
                    ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email', 'required']);
            })
            ->ajoutBouton('Changer d\'adresse e-mail', ['type' => 'submit', 'class' => 'btn btn-primary'])
            ->finForm();

        // Génération du formulaire de modification du mot de passe
        $passwordForm = new Form;
        $passwordForm->debutForm('post', '../utilisateur/changePassword', ['class' => 'border shadow p-3 rounded', 'style' => 'width: 450px'])
            ->ajoutTitre('Changer de mot de passe', ['class' => 'text-center p3'])
            ->ajoutErr($errorPswMessage)
            ->ajoutSuccess($successPswMessage)
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $form->ajoutLabelFor('password', 'Nouveau mot de passe', ['class' => 'form-label'])
                    ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'password', 'required']);
            })
            ->ajoutDiv(['class' => 'mb-3'], function ($form) {
                $form->ajoutLabelFor('confirm_password', 'Confirmer le nouveau mot de passe', ['class' => 'form-label'])
                    ->ajoutInput('password', 'confirm_password', ['class' => 'form-control', 'id' => 'confirm_password', 'required']);
            })
            ->ajoutBouton('Changer de mot de passe', ['type' => 'submit', 'class' => 'btn btn-primary'])
            ->finForm();

        // Affichez la page des paramètres de l'utilisateur
        $this->render('utilisateur/settings.php', [
            'emailForm' => $emailForm->create(),
            'passwordForm' => $passwordForm->create()
        ]);
    }

    public function changeEmail() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newEmail = $_POST['email'];

            // Validation de l'e-mail
            if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                header('Location: ' . WEBROOT . '/utilisateur/settings');
                $_SESSION['settings_error'] = 'Adresse mail invalide !';
                exit();
            }

            $user_id = $_SESSION['utilisateur']['id'];

            $userModel = new UtilisateursModel();
            $result = $userModel->updateEmail($user_id, $newEmail);

            if ($result) {
                $_SESSION['utilisateur']['email'] = $newEmail;
                $_SESSION['settings_success'] = 'Adresse e-mail mise à jour avec succès !';
            } else {
                $_SESSION['settings_error'] = 'Erreur lors de la mise à jour de l\'adresse e-mail !';
            }
        }

        header('Location: ' . WEBROOT . '/utilisateur/settings');
        exit();
    }

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                $_SESSION['settings_psw_error'] = 'Les mots de passe doivent correspondre !';
                header('Location: ' . WEBROOT . '/utilisateur/settings');
                exit();
            }

            $user_id = $_SESSION['utilisateur']['id'];
            $hashedPassword = hash('sha256', $newPassword);

            $userModel = new UtilisateursModel();
            $result = $userModel->updatePassword($user_id, $hashedPassword);

            if ($result) {
                $_SESSION['settings_psw_success'] = 'Mot de passe mis à jour avec succès !';
            } else {
                $_SESSION['settings_psw_error'] = 'Erreur lors de la mise à jour du mot de passe !';
            }
        }

        header('Location: ' . WEBROOT . '/utilisateur/settings');
        exit();
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
        header('Location: ' . WEBROOT . '/utilisateur/login');
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
        header('Location: ' . WEBROOT . '/utilisateur/signIn');
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
        header('Location: ' . WEBROOT . '/utilisateur/login');
        exit();
    }
}
