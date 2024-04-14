<head>
    <title>Nutritionnistes disponibles</title>
</head>

<main class="px-4">
    <section class="col-12">
        <h3>Nutritionnistes disponibles</h3>
        <?php if(!empty($relation)): ?>
            <p>Vous êtes déjà en relation avec un nutritionniste</p>
        <?php endif ?>
        <table class="table">
            <thead>
                <th>Nom</th>
                <th>Relation(s)</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($nutritionnistes as $index => $nutritionniste) : ?>
                    <tr>
                        <td><?= $nutritionniste->nom_utilisateur ?></td>
                        <td><?= $nutritionniste->nbRelations ?></td>
                        <?php if(empty($relation)): ?>
                            <td><button id="<?= $nutritionniste->id ?>" class="btn btn-primary" onclick="demandeSuivi(this)" <?= $nutritionniste->notif ? "disabled" : "" ?>>Demander</button></td>
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-center flex-wrap">
                <li class="page-item <?= ($pageActuelle == 1) ? "disabled" : "" ?>">
                    <a href="?page=<?= $pageActuelle -1 ?>" class="page-link">Page précédente</a>
                </li>
                <?php for($page = 1; $page <= $nbPage; $page++): ?>
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
</main>

<script type="text/javascript">
    function demandeSuivi(node) {
        let idNutritionniste = $(node).attr('id');

        var myJson = {
            idNutritionniste: idNutritionniste,
        };

        $.ajax({
            type: 'POST',
            url: '/rechercheNutritionniste/demandeSuivi',
            data: JSON.stringify(myJson),
            contentType: 'application/json',
            success: function(response) {
                if(response == 200) {
                    $(node).prop('disabled', true);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });
    }
</script>