<head>
    <link href="public/css/recettes.css" rel="stylesheet">
</head>

<main>
    <div class="recettes-list">
        <section class="col-12">
            <h3>Recettes</h3>
            <?= $btnEffacerFiltres ?>
            <table class="table">
                <thead>
                    <th>Id</th>
                    <th>Nom</th>
                </thead>
                <tbody>
                    <?php foreach ($recettes as $index => $recette) : ?>
                        <tr class="ligne-recette" onclick="window.location='recette/lire/<?= $recette->id ?>'">
                            <td><?= $index + $premierItem ?></td>
                            <td><?= $recette->nom ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li class="page-item <?= ($pageActuelle == 1) ? "disabled" : "" ?>">
                        <a href="?page=<?= $pageActuelle - 1 ?>" class="page-link">Page précédente</a>
                    </li>
                    <?php for ($page = 1; $page <= $nbPage; $page++) : ?>
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
    </div>

    <div class="frigo">
        <h3>J'ai quoi dans mon frigo ?</h3>
        <div class="frigo-sub"><?= $formAliments ?></div>
        <ul id="resultatsAliments"></ul>
        <div class="frigo-sub">
            <?= $boutonTrouverRecettes ?>
            <button id="viderFrigo" type="" class="button-26">Vider mon frigo</button>
        </div>
        <ul id="monFrigo"></ul>
        
        
    </div>
</main>


<script type="text/javascript">
    var aliments = undefined;
    var frigo = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Récupération des aliments sur le premier focus
        $('#monAliment').on('focus', function() {
            if (aliments === undefined) {
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
            if (str.length >= 2 && aliments !== undefined) {
                let res = aliments.filter(item => item.nom.toLowerCase().includes(str));
                $('#resultatsAliments').empty();
                let liElements = res.map(e => $('<li>').text(e.nom).attr({
                    onclick: 'reporter(this);'
                }));
                $('#resultatsAliments').append(liElements);
            } else {
                $('#resultatsAliments').empty();
            }
        });

        $('#boutonAddFrigo').on('click', function(e) {
            e.preventDefault();
            let alimentUser = $('#monAliment').val();
            if(aliments != undefined) {
                var alimentTrouve = aliments.find(item => item.nom.toLowerCase() === alimentUser.toLowerCase());
                var alimentTrouveFrigo = frigo.find(item => item.nom.toLowerCase() === alimentUser.toLowerCase());
            }

            if (alimentTrouve != undefined && alimentTrouveFrigo == undefined) {
                $('#monAliment').val('');

                //Ajout li
                let liElement = $('<li>').attr({
                    id: alimentTrouve.id,
                }).text(alimentTrouve.nom);

                let aElement = $('<a>').attr({
                    href: '#', 
                    class: 'aliment-frigo-cross'
                }).text('x');

                liElement.append(aElement);
                $('#monFrigo').append(liElement);

                //Ajout input
                $('<input>').attr({
                    type: 'hidden',
                    name: 'aliments[]',
                    value: alimentTrouve.id,
                }).appendTo('#formFindRecette');

                frigo.push(alimentTrouve);

                //Ajout dans localStorage
                let frigoItems = localStorage.getItem('frigo');
                if(frigoItems != null) {
                    frigoItems = JSON.parse(frigoItems);
                }else{
                    frigoItems = [];
                }
                frigoItems.push(alimentTrouve);
                localStorage.setItem('frigo', JSON.stringify(frigoItems));

            }
        });

        $('#viderFrigo').on('click', function(e) {
            e.preventDefault();
            localStorage.removeItem('frigo');
            $('#monFrigo').html('');
            frigo = [];
        });

        

        //localStorage to frigo
        let localFrigo = localStorage.getItem('frigo');
        if(localFrigo != null) {
            localFrigo = JSON.parse(localFrigo);
            for(let item of localFrigo) {
                let liElement = $('<li>').attr({
                    id: item.id,
                }).text(item.nom);

                let aElement = $('<a>').attr({
                    href: '#', 
                    class: 'aliment-frigo-cross',
                    onclick: 'supprimerAlimentFrigo(this)'
                }).text('x');

                liElement.append(aElement);
                $('#monFrigo').append(liElement);

                frigo.push(item);
            }
        }
    });

    function reporter(node) {
        $('#monAliment').val($(node).text());
        $('#resultatsAliments').empty();
    }

    function supprimerAlimentFrigo(node) {
        let id = $(node).parent().attr('id');
        $('#'+id).remove();
        frigo = frigo.filter(item => item.id != id);
        localStorage.setItem('frigo', JSON.stringify(frigo));
    }
</script>