<head>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.css' rel='stylesheet' />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.9.0/locales/fr.js"></script> -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.js'></script>
    <title>Mon planning</title>
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
    <div id="calendar"></div>
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


</main>

<?php

if (!isset($events)) {
    $events = [];
}
?>

<script type="text/javascript" src="/public/js/calendrier.js"></script>