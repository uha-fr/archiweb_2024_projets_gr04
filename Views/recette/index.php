<h3>Voici les recettes disponibles</h3>
<?php foreach($recettes as $recette): ?>
    <section><a href="recette/lire/<?= $recette->id ?>"><?= $recette->nom ?></a></section>
<?php endforeach ?>

<h3>J'ai quoi dans mon frigo ?</h3>
<?= $formAliments ?>
<ul id="resultatsAliments"></ul>
<p><strong>Mon frigo</strong></p>
<ul id="monFrigo"></ul>
<?= $boutonTrouverRecettes ?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        var aliments = undefined;
        var frigo = [];

        // Récupération des aliments sur le premier focus
        $('#monAliment').on('focus', function() {
            if(aliments === undefined) {
                $.ajax({
                        type: 'POST',
                        url: '/archiweb_2024_projets_gr04/aliment/recupererAliments',
                        dataType: 'json',
                        success: function(data) {
                            aliments = data['data'];
                        },
                });
            }
        });

        //Recherche dynamique sur le oninput
        $('#monAliment').on('input', function() {
            let str = $(this).val().toLowerCase();
            if(str.length >= 2 && aliments !== undefined) {
                let res = aliments.filter(item => item.nom.toLowerCase().includes(str));
                $('#resultatsAliments').empty();
                let liElements = res.map(e => $('<li>').text(e.nom).attr({
                    onclick: 'reporter(this);'
                }));
                $('#resultatsAliments').append(liElements);
            }else{
                $('#resultatsAliments').empty();
            }
        });

        $('#boutonAddFrigo').on('click', function(e) {
            e.preventDefault();
            let alimentUser = $('#monAliment').val();
            let alimentTrouve = aliments.find(item => item.nom.toLowerCase() === alimentUser.toLowerCase());
            let alimentTrouveFrigo = frigo.find(item => item.nom.toLowerCase() === alimentUser.toLowerCase());

            if(alimentTrouve != undefined && alimentTrouveFrigo == undefined) {
                $('#monAliment').val('');
                let liElement = $('<li>').text(alimentUser).attr({
                    id: alimentTrouve.id,
                });
                $('#monFrigo').append(liElement);

                $('<input>').attr({
                    type: 'hidden',
                    name: 'donnees[]',
                    value: alimentTrouve.id,
                }).appendTo('#formFindRecette');

                frigo.push(alimentTrouve);
            }
        });
    });

    function reporter(node){
        $('#monAliment').val($(node).text());
        $('#resultatsAliments').empty();
    }
</script>