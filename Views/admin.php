<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="/public/css/admin.css" rel="stylesheet" type="text/css">
</head>

<body>
    <?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    ?>
    <div id="viewport">
        <!-- Sidebar -->
        <div id="sidebar">
            <header>
                <a href="#">Administration</a>
            </header>
            <ul class="nav">
                <li>
                    <a href="/">
                        <i class="zmdi zmdi-view-dashboard"></i> Sortir
                    </a>
                </li>
                <li>
                    <a href="../admin/gestionUtilisateurs">
                        <i class="zmdi zmdi-view-dashboard"></i> Gestion utilisateurs
                    </a>
                </li>
            </ul>
        </div>
        <!-- Content -->
        <div id="content">
            <?= $contenu ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</body>

</html>