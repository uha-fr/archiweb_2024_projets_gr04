<head>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.js'></script>
    <title>Mon planning</title>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
        }

        #calendar {
            max-width: 900px;
            margin: 40px auto;
            padding: 10px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
    <div id="calendar"></div>
    <h2>Ajouter une recette au planning</h2>
    <form id="eventForm" class="mt-3">
        <div class="row justify-content-center">
            <div class="col-md-4 ">
                <select id="recette" class="form-control" onchange="showDescription()">
                    <option value="">Choisir une recette</option>
                    <?php foreach($recettes as $recette): ?>
                        <option value="<?= htmlspecialchars($recette->id) ?>" data-description="<?= htmlspecialchars($recette->description) ?>"><?= htmlspecialchars($recette->nom) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="date" id="dateDebut" class="form-control" required>
            </div>
            <div class="col-md-4">
                <input type="date" id="dateFin" class="form-control" required>
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


</main>

<?php

if (!isset($events)) {
    $events = [];
}
?>


<script>

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


</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            
        ]
    });
    calendar.render();


    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();  
        var recetteSelect = document.getElementById('recette');
        var recette = recetteSelect.options[recetteSelect.selectedIndex].text;
        var dateDebut = document.getElementById('dateDebut').value;
        var dateFin = document.getElementById('dateFin').value;

        if (!recette || !dateDebut || !dateFin) {
            alert("Tous les champs sont requis !");
            return;
        }

        calendar.addEvent({
            title: recette,
            start: dateDebut,
            end: dateFin
        });

        // Préparation de l'objet JSON pour envoyer au serveur les informations des recettes qu'on vient d'ajouter dans le calendrier 
        var myJson = {
            idRecette: recette, //TODO : Ici, recette est le nom de la recette, nous il nous faut son id.
            start: dateDebut,
            end: dateFin
        };

        // Requete AJAX qui envoie notre objet MYSON au serveur
        // Le serveur reçoit les informations via la fonction addRecette dans PlanningController.php
        $.ajax({
            type: 'POST',
            url: '/planning/addRecette',
            data: JSON.stringify(myJson),
            contentType: 'application/json',
            success: function(response) {
                if(response == 200) {
                    console.log("Succes add recette");
                    console.log(element);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });

        document.getElementById('eventForm').reset();
    });


    /**
     * TODO : au chargement de la page, il faut ajouter les recettes au calendrier. Il faut donc récupérer toutes les recettes
     * du planning de l'utilisateur courant depuis le serveur (dans PlanningController.php) et les envoyer à la vue (ici),
     * puis les afficher avec 
     * calendar.addEvent({
            title: recette,
            start: dateDebut,
            end: dateFin
        }); 
     */
});
</script>



