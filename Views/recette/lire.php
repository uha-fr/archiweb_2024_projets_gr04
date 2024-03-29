<main class="p-4">
    <?= $retour ?>
    <h2><?= $recette->getNom() ?></h2>
    <p><?= $recette->getDescription() ?></p>

    <h4>Ingrédients</h4>
    <ul>
        <?php foreach ($ingredients as $ingredient) : ?>
            <li><?= $ingredient->getNom() ?> - <?= $ingredient->quantite ?><?= $ingredient->unite ?></li>
        <?php endforeach ?>
    </ul>
    <p>Total calories : <?= $totalCalorie ?> Kcal</p>
</main>