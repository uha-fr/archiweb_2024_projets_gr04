
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
document.addEventListener('DOMContentLoaded', function () {
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

    fetchAndDisplayRecettes();

    function fetchAndDisplayRecettes() {
        $.ajax({
            url: '/planning/getRecettes',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                data.forEach(function (recette) {
                    let endDate = new Date(recette.dateFin);
                    endDate.setDate(endDate.getDate() + 1);

                    calendar.addEvent({
                        title: recette.nom,
                        start: recette.dateDebut,
                        end: endDate.toISOString().split('T')[0]
                    });
                });
            },
            error: function () {
                console.error("Erreur lors de la récupération des recettes.");
            }
        });
    }

    document.getElementById('eventForm').addEventListener('submit', function (e) {
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

        $.ajax({
            type: 'POST',
            url: '/planning/addRecette',
            data: JSON.stringify(myJson),
            contentType: 'application/json',
            error: function (xhr, status, error) {
                console.error('Erreur lors de la requête :', error);
            }
        });

        document.getElementById('eventForm').reset();
    });
});