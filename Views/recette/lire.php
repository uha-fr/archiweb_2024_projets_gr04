<h2>La recette en détail</h2>
<p><?= $recette->nom ?></p>
<p><?= $recette->description ?></p>

<h2>Ingrédients</h2>
<ul>
<?php foreach($ingredients as $ingredient): ?>
    <li><?= $ingredient->nom ?></li>
<?php endforeach ?>
</ul>

