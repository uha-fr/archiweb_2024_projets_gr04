<head>
    <link href="/public/css/recettes.css" rel="stylesheet">
    <title>Mes recettes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<main class="row">
    <div class="col-md-12 col-lg-6">
        <section>
            <h3>Recettes</h3>
            <div class="d-flex justify-content-between">
                <a href="recette/ajoutermodifier" class="btn btn-primary text-decoration-none">Ajouter une recette</a>
                <?= $btnEffacerFiltres ?>
            </div>
            <table class="table">
                <thead>
                    <th>Nom</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($recettes as $recette) : ?>
                        <tr class="ligne-recette" onclick="window.location='recette/lire/<?= $recette->id ?>'">
                            <td><?= $recette->nom ?></td>
                            <td>
                                <?php if($recette->id_utilisateur == $_SESSION['utilisateur']['id']): ?> 
                                    <a href="recette/ajoutermodifier/<?= $recette->id ?>" class="text-decoration-none ps-3 pe-3 pb-1 position-relative start-50 hover">Modifier</a>
                                <?php endif ?>
                            </td>
                            <td>
                                <?php if($recette->id_utilisateur == $_SESSION['utilisateur']['id']): ?> 
                                    <a href="recette/supprimer/<?= $recette->id ?>" class="text-decoration-none ps-3 pe-3 pb-1 position-relative start-50 hover">x</a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination justify-content-center flex-wrap">
                    <li class="page-item <?= ($pageActuelle == 1) ? "disabled" : "" ?>">
                        <a href="?page=<?= $pageActuelle - 1 ?>" class="page-link">Page précédente</a>
                    </li>
                    <?php for ($page = 1; $page <= $nbPage; $page++) : ?>
                        <li class="page-item <?= ($pageActuelle == $page) ? "active" : "" ?>">
                            <a href="?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endfor ?>

                    <li class="page-item">
                        <a href="?page=<?= $pageActuelle + 1 ?>" class="page-link <?= ($pageActuelle == $nbPage) ? "disabled" : "" ?>">Page Suivante</a>
                    </li>
                </ul>
            </nav>
        </section>
    </div>

    <div class="col-md-12 col-lg-6">
        <h3>J'ai quoi dans mon frigo ?</h3>
        <div class="d-flex gap-1"><?= $formAliments ?></div>
        <ul id="resultatsAliments"></ul>
        <div class="d-flex mt-3 mb-3 gap-3">
            <?= $boutonTrouverRecettes ?>
            <button id="viderFrigo" type="" class="btn border w-50">Vider mon frigo</button>
        </div>
        <ul id="monFrigo"></ul>
        
        
    </div>
</main>


<script src="public/js/rechercheAliment.js" type="text/javascript"></script>