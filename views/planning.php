<!DOCTYPE html>
<html>
<head>
    <title>Mon Calendrier de Planification</title>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.10/index.global.min.js'></script>
    <script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                {
                    title: 'Recette de Lasagnes',
                    start: '2024-01-10', 
                    description: 'Préparation de lasagnes maison'
                },
                {
                    title: 'Recette de Quiche Lorraine',
                    start: '2024-01-15', 
                    description: 'Préparation d\'une quiche lorraine'
                },
                
            ]
        });
        calendar.render();
    });

    </script>
  </head>
  <body>
    <div id='calendar'></div>
  </body>
</html>
