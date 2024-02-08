<main class="px-4">
    <section class="col-12">
        <h3>Aliments et Produits</h3>
        <table class="table">
            <thead>
                <th>N°</th>
                <th>Nom</th>
            </thead>
            <tbody>
                <?php foreach ($aliments as $index => $aliment) : ?>
                    <tr>
                        <td><?= $index + $premierItem ?></td>
                        <td><?= $aliment->nom ?></td>
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