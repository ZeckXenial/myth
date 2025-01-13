document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: '<?= site_url("calendar/getEvents") ?>', // URL para cargar eventos
        editable: true,
        eventClick: function(info) {
            if (confirm("¿Deseas eliminar este evento?")) {
                // Lógica para eliminar el evento
                fetch(`<?= site_url("calendar/deleteEvent") ?>/${info.event.id}`, {
                    method: 'DELETE'
                }).then(response => {
                    if (response.ok) {
                        info.event.remove(); // Eliminar evento del calendario
                    }
                });
            }
        }
    });
    calendar.render();

    // Manejo del formulario para agregar eventos
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var title = document.getElementById('eventTitle').value;
        var start = document.getElementById('eventStart').value;
        var end = document.getElementById('eventEnd').value;

        // Lógica para agregar el evento
        fetch('<?= site_url("calendar/addEvent") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ title: title, start: start, end: end })
        }).then(response => response.json()).then(data => {
            calendar.addEvent({
                id: data.id, // Suponiendo que el servidor devuelve el ID del nuevo evento
                title: title,
                start: start,
                end: end
            });
            $('#eventModal').modal('hide'); // Cerrar el modal
            document.getElementById('eventForm').reset(); // Reiniciar el formulario
        });
    });
});
