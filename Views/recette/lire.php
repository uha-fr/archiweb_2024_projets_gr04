<main class="p-4">
    <h2><?= $recette->nom ?></h2>
    <p><?= $recette->description ?></p>

    <h3>Ingrédients</h3>
    <ul>
        <?php foreach ($ingredients as $ingredient) : ?>
            <li><?= $ingredient->nom ?></li>
        <?php endforeach ?>
    </ul>
</main>