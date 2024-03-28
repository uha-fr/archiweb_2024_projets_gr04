<head>
    <title>Vos relations</title>
</head>

<main class="px-4 d-flex">
    <section class="col-9">
        <h3>Vos relations</h3>
        <table class="table">
            <thead>
                <th>Nom d'utilisateur</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($relations as $index => $relation) : ?>
                    <tr>
                        <td><?= $relation->nom_utilisateur ?></td>
                        <td><a href="/nutritionnisteGestionRelation/voirPlanning/<?= $relation->id ?>" class="btn border text-decoration-none">Voir le planning</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
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

    <section class="">
        <h3>Vos demandes de relation</h3>
        <ul class="list-unstyled">
            <?php foreach ($notificationsDemande as $index => $notificationDemande) : ?>

                <li class="mx-1 d-flex border mx-4 mb-2 p-2" id="<?= $notificationDemande->idNotification ?>">
                    <?= $notificationDemande->nom_utilisateur ?>
                    <div class="ms-auto d-flex align-items-center gap-3">
                        <a class="rounded-circle bg-success pe-auto" onclick="clickNotification('<?= $notificationDemande->idNotification ?>','<?= $notificationDemande->idUserOrigine ?>', true)" style="width: 20px;height: 20px;cursor: pointer;"></a>
                        <a class="rounded-circle bg-danger" onclick="clickNotification('<?= $notificationDemande->idNotification ?>','<?= $notificationDemande->idUserOrigine ?>', false)" style="width: 20px;height: 20px;cursor: pointer;"></a>
                    </div>
                </li>

            <?php endforeach ?>
        </ul>
    </section>
</main>

<script type="text/javascript">
    function clickNotification(idNotif, idClient, response) {

        let myJson = {
            idNotif: idNotif,
            idClient: idClient,
            response: response,
        };

        $.ajax({
            type: 'POST',
            url: '/NutritionnisteGestionRelation/reponseNotifDemandeRelation',
            data: JSON.stringify(myJson),
            contentType: "application/json; charset=utf-8",
            success: function(data) {
                let res = document.getElementById(idNotif);
                res.style.setProperty('display', 'none', 'important');
            },
        });
    }
</script>