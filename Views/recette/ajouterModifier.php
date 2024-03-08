<head>
    <link href="/public/css/recettes.css" rel="stylesheet">
    <?php if($isModification): ?>
        <title>Modifier une recette</title>
    <?php else: ?>
        <title>Ajouter une recette</title>
    <?php endif ?>
</head>

<main>
    <div class="w-25 p-3 m-auto">
        <?php if($isModification): ?>
            <h3>Modifier la recette</h3>
        <?php else: ?>
            <h3>Ajouter une nouvelle recette</h3>
        <?php endif ?>
        
        <?= $formDebut ?>
            <div class="spe"><?= $formAliments ?></div>
            <ul id="resultatsAliments"></ul>
            <ul id="monFrigo"></ul>
        <?= $formFin ?>
    </div>

</main>

<script src="/public/js/rechercheAliment.js" type="text/javascript"></script>

<script type="text/javascript">
    localStorage.removeItem('frigo');
    try {
        localStorage.setItem('frigo', JSON.stringify(ingredientsEdit)); // ingredientsEdit provient du serveur
    } catch(e){}
</script>