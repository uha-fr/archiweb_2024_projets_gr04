<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="/css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="#page-top">MANGER</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="">Aliment</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Recette</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Planing</a></li>
                    <li class="nav-item sign-in-up"><a class="nav-link" href="">Inscription</a></li>
                    <li class="nav-item sign-in-up"><a class="nav-link" href="">Connexion</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <nav class="mt-5 pt-4">
        Menu Recettes
        <?php
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if(isset($_SESSION['utilisateur'])) : ?>
            <span>Bienvenue, <?= $_SESSION['utilisateur']['nom_utilisateur'] ?></span>
            <a href="/utilisateur/logout">Déconnexion</a>
        <?php else : ?>
            <a href="/utilisateur/login">Connexion</a>
        <?php endif; ?>
    </nav>

    <div class="conteneur mt-5"> 
        <?= $contenu ?>
    </div>

    <script type="text/javascript">console.log("default template");</script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmRxJ+EN6gDNtYKb/E/fWd0LbRc5zNU6cP4U9d8jJHONaU7eQc7Jm6yR03b1z7b" crossorigin="anonymous"></script>
</body>
</html>
