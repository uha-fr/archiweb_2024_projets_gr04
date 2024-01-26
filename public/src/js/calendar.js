document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            {
                title: 'Recette de Lasagnes',
                start: '2024-01-28', 
                description: 'Préparation de lasagnes maison'
            },
            {
                title: 'Recette de Quiche Lorraine',
                start: '2024-01-29', 
                description: 'Préparation d\'une quiche lorraine'
            },
            
        ]
    });
    calendar.render();
});