<head>
    <title>Vos relations</title>
</head>

<main class="px-4">
    <section class="col-12">
        <h3>Vos relations</h3>
        <table class="table">
            <thead>
                <th>Nom d'utilisateur</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($relations as $index => $relation) : ?>
                    <tr>
                        <td><?= $relation->nom_utilisateur ?></td>
                        <td><a href="" class="btn border text-decoration-none">Voir le planning</a></td>
                        <td><a href="" class="btn border text-decoration-none">Proposer un planning</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
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