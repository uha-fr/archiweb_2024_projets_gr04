<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user']); ?></h1>
    <form
        action="/mon_projet_mvc/index.php?logout"
        method="POST">   
        <input type="submit" value="Déconnexion">   
    </form>
</body>
</html>
