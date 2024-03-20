<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="/public/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $project_root = '//' . $_SERVER['HTTP_HOST'] . '/accueil';
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="<?php echo $project_root; ?>"><img src="/public/images/smalllogo.png" alt="Logo" style="height:30px; width:30px;"> MANGER</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['utilisateur'])): ?>
                        <li class="nav-item"><a class="nav-link" href="/aliment">Aliment</a></li>
                        <li class="nav-item"><a class="nav-link" href="/recette">Recette</a></li>
                        <li class="nav-item"><a class="nav-link" href="/planning">Planning</a></li>
                        <li class="nav-item"><a class="nav-link" href="/rechercheNutritionniste">Nutritionnistes</a></li>
                        <?php if($_SESSION['utilisateur']['role'] == "nutritionniste"): ?>
                            <li class="nav-item"><a class="nav-link" href="/nutritionnisteGestionRelation">Gestion des relations</a></li>
                        <?php endif ?>
                        <li class="nav-item sign-in-up"><a class="nav-link" href="/utilisateur/logout">Deconnexion</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $_SESSION['utilisateur']['nom_utilisateur'] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <div class="d-flex align-items-center px-3">
                                        <img src="/public/images/<?= $_SESSION['utilisateur']['role'] ?>PP.png" class="rounded-circle" alt="Profile Picture" style="width: 50px; height: 50px;">
                                        <div class="ms-2">
                                            <strong><?= $_SESSION['utilisateur']['nom_utilisateur'] ?></strong>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <?php if($_SESSION['utilisateur']['role'] == "admin"): ?>
                                    <li><a class="dropdown-item" href="/admin">Administration</a></li>
                                <?php endif ?>
                                <li><a class="dropdown-item" href="/utilisateur/settings">Paramètres</a></li>
                                <li><a class="dropdown-item" href="/utilisateur/logout">Déconnexion</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item sign-in-up"><a class="nav-link" href="/utilisateur/login">Connexion</a></li>
                    <?php endif ?>

                </ul>
            </div>
        </div>
    </nav>

    

    <div class="conteneur" style="margin-top: 66px;"> 
        <?= $contenu ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
