<head>
	<title>Suivi de ma consommation</title>
</head>


<main class="container">
    <div class="row">
        <div class="col">
            <label>Au jour :</label>
            <?= $formJour ?>
        </div>
        <div class="col">
            <label>Au mois :</label>
            <?= $formMois ?>
        </div>
        <div class="col">
            <label>Mensuel sur l'année :</label>
            <?= $formAnnee ?>
        </div>
    </div>
    <h3><?= $titre ?></h3>
    <div class="w-100 h-100">
        <canvas id="myChart"></canvas>
    </div>
</main>

<script type="text/javascript" src="/public/js/lib.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	const ctx = document.getElementById('myChart');

	var labels = <?php echo json_encode($labels) ?>;
	var data = <?php echo json_encode($data) ?>;

	new Chart(ctx, {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [{
				label: 'Kcal',
				data: data,
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
</script>