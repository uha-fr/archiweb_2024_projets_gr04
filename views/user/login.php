<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="/mon_projet_mvc/index.php" method="POST">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username"><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password"><br><br>

        <input type="submit" value="Connexion">
    </form>
</body>
</html>
