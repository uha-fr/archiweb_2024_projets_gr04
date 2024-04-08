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


<script type="text/javascript">
    <?php if(isset($frigoType)): ?>
        var frigoType = <?php echo json_encode($frigoType) ?>
    <?php endif ?>
</script>

<script src="/public/js/rechercheAliment.js" type="text/javascript"></script>