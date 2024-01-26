<?php
require_once 'Controllers/UserController.php';

session_start();
// var_dump($_SERVER['REQUEST_METHOD'], $_POST, $_GET); // verification des données de la requête

$controller = new UserController();
// $controller->showLandpage();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $controller->login();
} else {
    $action = $_GET['action'] ?? $_POST['action'] ?? null;  

    if ($action === 'logout') {
        session_destroy();
        $_SESSION = array(); 
        $controller->redirect('/mon_projet_mvc/index.php');
    } else {
        // $controller->showLoginForm();
        $controller->showLandpage();
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $controller->register();
} else {
    $action = $_GET['action'] ?? $_POST['action'] ?? null;  

    if ($action === 'logout') {
        session_destroy();
        $_SESSION = array(); 
        $controller->redirect('/mon_projet_mvc/index.php');
    } else {
        $controller->showLandPage();
    }
}

