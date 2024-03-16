<head>
    <!-- <link href="/public/css/calendar.css" rel="stylesheet"> -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.js'></script>
    <!-- <link href="/mon_projet_mvc/archiweb_2024_projets_gr04/public/css/calendrier.css" rel="stylesheet"> 
    Pour enlever le style ici pour inclure le fichier css séparemment il faut mettre le chemin absolu qui peut etre différent suivant chaque personne-->
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
        <div class="row">
            <div class="col-md-4">
                <input type="text" id="recette" class="form-control" placeholder="Nom de la recette" required>
            </div>
            <div class="col-md-4">
                <input type="date" id="dateDebut" class="form-control" required>
            </div>
            <div class="col-md-4">
                <input type="date" id="dateFin" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ajouter la recette</button>
    </form>
</main>

<?php

if (!isset($events)) {
    $events = [];
}
?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            <?php foreach($events as $event): ?>
            {
                title: '<?= htmlspecialchars($event->getTitre(), ENT_QUOTES, 'UTF-8') ?>',
                start: '<?= htmlspecialchars($event->getDateDebut(), ENT_QUOTES, 'UTF-8') ?>',
                end: '<?= htmlspecialchars($event->getDateFin(), ENT_QUOTES, 'UTF-8') ?>',
                url: '/planning/<?= htmlspecialchars($event->getId(), ENT_QUOTES, 'UTF-8') ?>',
            },
            <?php endforeach; ?>
        ]
    });
    calendar.render();


    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();  
        var recette = document.getElementById('recette').value;
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

        document.getElementById('eventForm').reset();
    });
});
</script>



