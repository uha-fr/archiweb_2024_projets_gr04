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
            
			background-color: #ee0979;
			border-color: #ee0979;
		}

		.btn-primary:hover {
			background-color: #be0761;
			border-color:  #be0761;
		}

        .btn-primary2 {
            display: block; 
            width: 100%; 
            text-align: center;
			background-color: #ee0979;
			border-color: #ee0979;
		}

		.btn-primary2:hover {
			background-color: #be0761;
			border-color:  #be0761;
		}

		.form-control {
			border-radius: 5px;
		}


		.modal {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			display: none;
			justify-content: center;
			align-items: center;
		}

		.modal-contenu {
			background-color: white;
			padding: 20px;
			border-radius: 5px;
			text-align: center;
			position: relative;
		}

		#fermer-modal {
			position: absolute;
			top: 10px;
			right: 20px;
			cursor: pointer;
			padding: 5px;
		}
	</style>
</head>

<main>
	<div id="modal-parent" class="modal <?= $afficherListe ? 'd-flex' : 'd-none' ?>">
		<div class="modal-contenu">
			<p id="fermer-modal">x</p>
			<h4>Créez votre liste de course</h4>
			<p>Créez votre liste de courses avec votre planning de repas !</p>
			<?= $form ?>

			<?php if($afficherListe): ?>
				<?php if(empty($ingredientsDetailsListe)): ?>
					<p>Aucun ingrédients pour ce mois</p>
				<?php else: ?>
					<ul class="mt-2 text-start list-unstyled">
					<?php foreach($ingredientsDetailsListe as $ingredients): ?>
						<li><?= $ingredients->nom ?> <?= $ingredients->quantite ?><?= $ingredients->unite ?></li>
					<?php endforeach ?>
					</ul>
					<form action="" method="post">
						<input type="hidden" name="telechargerRecette"/>
						<button type="">Télécharger</button>
					</form>
				<?php endif ?>
			<?php endif ?>
		</div>
	</div>


	<?php if (isset($client)) : ?>
    <h3 class="text-center" style="color: #333333;"><?= $titre ?></h3>
    <?php endif ?>

    <?php if (isset($relation) && $relation->getNutritionnisteAccesPlanning() == 1) : ?>
        <p class="text-center" style="margin: 20px auto; max-width: 700px; background-color: #f8f9fa; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
            <?= $client->getNomUtilisateur() ?> vous a donné l'accès à l'édition de son planning
        </p>
    <?php endif ?>

    <?php if ($controller == "Planning") : ?>
        <div style="text-align: center; margin-top: 30px;">
            <?php if ($accesAccorde == "0" || $accesAccorde == "1") : ?>
                <?php if ($accesAccorde == "0") : ?>
                    <button id="acces=false" class="btn btn-primary mx-2 " onclick="accorderAcces(this)">Accorder l'accès à mon nutritionniste</button>
                <?php else : ?>
                    <button id="acces=true" class="btn btn-primary mx-2" onclick="accorderAcces(this)">Retirer l'accès à mon nutritionniste</button>
                <?php endif ?>
            <?php endif ?>
            <button id="ouvrir-modal" class="btn btn-primary mx-2">Générer ma liste de courses</button>
        </div>
    <?php endif ?>


			<div id="calendar"></div>

			<?php if ($controller == 'Planning' || isset($relation) && $relation->getNutritionnisteAccesPlanning() == 1) : ?>
				<h2>Ajouter une recette au planning</h2>
				<form id="eventForm" class="mt-3">
                <div class="row justify-content-center">
                <div class="col-md-4">
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
                    <button type="submit" class="btn btn-primary mt-4 w-100">Ajouter la recette</button>
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
		<?php if (isset($client) && $client) : ?>
			idClient = <?php echo json_encode($client->getId()) ?>;
		<?php else : ?>
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
		if (formAddRecette) {
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

				<?php if (isset($client) && $client) : ?>
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

		
		document.getElementById('ouvrir-modal').addEventListener('click', function() {
			document.getElementById('modal-parent').style.setProperty('display', 'flex', 'important');
		});

		document.getElementById('fermer-modal').addEventListener('click', function() {
			document.getElementById('modal-parent').style.setProperty('display', 'none', 'important');
		});
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
		if (node.id == "acces=true") {
			acces = "true";
		}

		$.ajax({
			type: 'POST',
			url: '/Planning/changerAccesPlanning',
			contentType: "application/json; charset=utf-8",
			data: JSON.stringify({
				acces: acces
			}),
			success: function(data) {
				if (node.id == "acces=true") {
					node.innerText = "Accorder l'accès à mon nutritionniste";
					node.id = "acces=false";
				} else {
					node.innerText = "Retirer l'accès à mon nutritionniste";
					node.id = "acces=true";
				}
			},
		});
	}
</script>