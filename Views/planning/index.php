<head>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.css' rel='stylesheet' />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.9.0/locales/fr.js"></script> -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.js'></script>
    <title><?= $titre ?></title>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Roboto', sans-serif;
        }

        #calendar {
            max-width: 900px;
            margin: 40px auto;
            padding: 10px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }

        #eventForm {
            max-width: 700px;
            margin: 20px auto;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-control {
            border-radius: 5px;
        }
    </style>
</head>

<main>
    <?php if(isset($client)): ?>
        <h3><?= $titre ?></h3>
    <?php endif ?>

    <?php if(isset($relation) && $relation->getNutritionnisteAccesPlanning() == 1): ?>
        <p><?= $client->getNomUtilisateur() ?> vous a donné l'accès à l'édition de son planning</p>
    <?php endif ?>

    <?php if($controller == "Planning" && $accesAccorde === true || $accesAccorde === false): ?>
        <?php if($accesAccorde == "0"): ?>
            <button id="acces=false" class="mx-2" onclick="accorderAcces(this)" ">Accorder l'accès à mon nutritionniste</button>
        <?php else: ?>
            <button id="acces=true" class="mx-2" onclick="accorderAcces(this)" ">Retirer l'accès à mon nutritionniste</button>
        <?php endif ?>
    <?php endif ?>

    <div id="calendar"></div>

    <?php if ($controller == 'Planning' || isset($relation) && $relation->getNutritionnisteAccesPlanning() == 1) : ?>
        <h2>Ajouter une recette au planning</h2>
        <form id="eventForm" class="mt-3">
            <div class="row justify-content-center">
                <div class="col-md-4 ">
                    <select id="recette" class="form-control" onchange="showDescription()">
                        <option value="">Choisir une recette</option>
                        <?php foreach ($recettes as $recette) : ?>
                            <option value="<?= htmlspecialchars($recette->id) ?>" data-description="<?= htmlspecialchars($recette->description) ?>"><?= htmlspecialchars($recette->nom) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="date" id="dateDebut" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <input type="date" id="dateFin" class="form-control">
                </div>
                <div class="col-md-4">

                    <button type="submit" class="btn btn-primary mt-4">Ajouter la recette</button>
                </div>
            </div>
            <div class="col-md-12 mt-3 mx-auto ">
                <div id="recetteDescription" class="card" style="display:none;">
                    <div class="card-body">
                        <h5 class="card-title">Description</h5>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            </div>
        </form>
    <?php endif ?>


</main>

<?php

if (!isset($events)) {
    $events = [];
}
?>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'fr',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
        });
        calendar.render();

        let idClient = undefined;
        <?php if(isset($client) && $client): ?>
            idClient = <?php echo json_encode($client->getId()) ?>;
        <?php else: ?>
            idClient = 'mine';
        <?php endif ?>


        $.ajax({
            url: '/planning/getRecettes',
            method: 'POST',
            data: JSON.stringify(idClient),
            dataType: 'json',
            success: function(data) {
                data.forEach(function(recette) {
                    let endDate = new Date(recette.dateFin);
                    endDate.setDate(endDate.getDate() + 1);

                    calendar.addEvent({
                        title: recette.nom,
                        start: recette.dateDebut,
                        end: endDate.toISOString().split('T')[0]
                    });
                });
            },
            error: function() {
                console.error("Erreur lors de la récupération des recettes.");
            }
        });

        let formAddRecette = document.getElementById('eventForm');
        if(formAddRecette) {
            formAddRecette.addEventListener('submit', function(e) {
                e.preventDefault();
                var recetteSelect = document.getElementById('recette');
                var recette = recetteSelect.options[recetteSelect.selectedIndex].text;
                var dateDebut = document.getElementById('dateDebut').value;
                var dateFin = document.getElementById('dateFin').value;

                if (!dateFin) {
                    dateFin = dateDebut;
                }

                if (!recette || !dateDebut) {
                    alert("Champs 'recette' et 'date de début' requis");
                    return;
                }

                let endDate = new Date(dateFin);
                endDate.setDate(endDate.getDate() + 1);

                calendar.addEvent({
                    title: recette,
                    start: dateDebut,
                    end: endDate.toISOString().split('T')[0]
                });

                var myJson = {
                    idRecette: recetteSelect.value,
                    start: dateDebut,
                    end: dateFin
                };

                <?php if(isset($client) && $client): ?>
                    myJson.idClient = <?php echo json_encode($client->getId()) ?>;
                <?php endif ?>

                $.ajax({
                    type: 'POST',
                    url: '/planning/addRecette',
                    data: JSON.stringify(myJson),
                    contentType: 'application/json',
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la requête :', error);
                    }
                });

                document.getElementById('eventForm').reset();
            });
        }
    });

    function showDescription() {
        var select = document.getElementById('recette');
        var description = select.options[select.selectedIndex].getAttribute('data-description');
        var descriptionDiv = document.getElementById('recetteDescription');
        var cardText = descriptionDiv.querySelector('.card-text');

        if (description) {
            cardText.textContent = description;
            descriptionDiv.style.display = 'block';
        } else {
            descriptionDiv.style.display = 'none';
        }
    }

    function accorderAcces(node) {
        let acces = "false";
        if(node.id == "acces=true") {
            acces = "true";
        }

        $.ajax({
            type: 'POST',
            url: '/Planning/changerAccesPlanning',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify({acces: acces}),
            success: function(data) {
                if(node.id == "acces=true") {
                    node.innerText = "Accorder l'accès à mon nutritionniste";
                    node.id = "acces=false";
                }else{
                    node.innerText = "Retirer l'accès à mon nutritionniste";
                    node.id = "acces=true";
                }
            },
        });
    }
</script>