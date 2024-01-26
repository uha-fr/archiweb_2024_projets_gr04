<p>Voici les recettes disponibles</p>
<?php foreach($recettes as $recette): ?>
    <section><a href="recette/lire/<?= $recette->id ?>"><?= $recette->nom ?></a></section>
<?php endforeach ?>