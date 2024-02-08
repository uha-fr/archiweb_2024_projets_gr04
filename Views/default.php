<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <nav>
        Menu Recettes
        <?php
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if(isset($_SESSION['utilisateur'])) : ?>
            <span>Bienvenue, <?= $_SESSION['utilisateur']['nom_utilisateur'] ?></span>
            <a href="utilisateur/logout">Déconnexion</a>
        <?php else : ?>
            <a href="utilisateur/login">Connexion</a>
        <?php endif; ?>
    </nav>
    <div class="conteneur"><?= $contenu ?></div>

    <script type="text/javascript">console.log("default template");</script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    
</body>
</html>