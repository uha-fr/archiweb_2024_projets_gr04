<head>
    <link href="../public/css/recettes.css" rel="stylesheet">
    <title>Ajouter une recette</title>
</head>

<main>
    <div class="w-25 p-3 m-auto">
        <h3>Ajouter une nouvelle recette</h3>
        <?= $formDebut ?>
            <div class="spe"><?= $formAliments ?></div>
            <ul id="resultatsAliments"></ul>
            <ul id="monFrigo"></ul>
        <?= $formFin ?>
    </div>

</main>

<script src="../public/js/rechercheAliment.js" type="text/javascript"></script>
<script type="text/javascript">
    localStorage.removeItem('frigo');
</script>

