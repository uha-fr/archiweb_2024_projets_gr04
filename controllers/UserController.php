<?php
require_once 'BaseController.php';
require_once 'Models/User.php';

// à modifier

class UserController extends BaseController {

    public function showLoginForm() {
        $this->view('user/login');

    }
    public function showLandpage() {
        $this->view('user/landing');
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (User::validate($username, $password)) {
            session_start();
            $_SESSION['user'] = $username;
            $this->redirect('/mon_projet_mvc/Views/user/profile.php');
        } else {
            $this->view('user/login', ['error' => 'Identifiants incorrects']);
        }
    }
    public function register() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (User::create($username, $password)) {
            session_start();
            $_SESSION['user'] = $username;
            $this->redirect('/mon_projet_mvc/Views/user/profile.php');
        } else {
            $this->view('user/register', ['error' => 'Impossible de créer le compte']);
        }
    }
    

    public function profile() {
        session_start();
        if (isset($_SESSION['user'])) {
            $this->view('user/profile', ['username' => $_SESSION['user']]);
        } else {
            $this->redirect('/mon_projet_mvc/Views/user/login.php');
            
        }
    }
}
