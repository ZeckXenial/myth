<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js'></script>
    <title>Calendario Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div id='calendar'></div>

    <!-- Modal de Edición -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Editar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="editEventForm">
                        <div class="mb-3">
                            <label for="editEventTitle" class="form-label">Título</label>
                            <input type="text" class="form-control" id="editEventTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEventStart" class="form-label">Inicio</label>
                            <input type="datetime-local" class="form-control" id="editEventStart" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEventEnd" class="form-label">Fin</label>
                            <input type="datetime-local" class="form-control" id="editEventEnd" required>
                        </div>
                        <input type="hidden" id="editEventId">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                    <button id="deleteEventButton" class="btn btn-danger">Eliminar Evento</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '<?= site_url('calendar/getEvents') ?>', // URL del método que devuelve eventos
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                locale: 'es',
                editable: true,
                selectable: true,
                selectMirror: true,
                eventClick: function(info) {
                    // Llenar el modal de edición con los datos del evento
                    var editEventTitle = document.getElementById('editEventTitle');
                    if (editEventTitle) editEventTitle.value = info.event.title;

                    var editEventStart = document.getElementById('editEventStart');
                    if (editEventStart) editEventStart.value = info.event.start.toISOString().slice(0, 16);

                    var editEventEnd = document.getElementById('editEventEnd');
                    if (editEventEnd) editEventEnd.value = info.event.end.toISOString().slice(0, 16);

                    var editEventId = document.getElementById('editEventId');
                    if (editEventId) editEventId.value = info.event.id; // Almacenar el ID del evento

                    // Mostrar el modal de edición
                    $('#editEventModal').modal('show');

                    // Manejar la eliminación del evento
                    var deleteEventButton = document.getElementById('deleteEventButton');
                    if (deleteEventButton) {
                        deleteEventButton.onclick = function() {
                            if (confirm("¿Deseas eliminar este evento?")) {
                                fetch(`<?= site_url('calendar/deleteEvent') ?>/${info.event.id}`, {
                                    method: 'DELETE'
                                }).then(response => {
                                    if (response.ok) {
                                        info.event.remove(); // Eliminar evento del calendario
                                        $('#editEventModal').modal('hide'); // Cerrar el modal
                                    }
                                });
                            }
                        };
                    }

                    // Manejar la edición del evento
                    document.getElementById('editEventForm').onsubmit = function(e) {
                        e.preventDefault();
                        var title = document.getElementById('editEventTitle')?.value;
                        var start = document.getElementById('editEventStart')?.value;
                        var end = document.getElementById('editEventEnd')?.value;
                        var id = document.getElementById('editEventId')?.value; // Obtener el ID del evento

                        // Lógica para editar el evento
                        fetch(`<?= site_url('calendar/editEvent') ?>/${id}`, { // Usar el ID correcto aquí
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id: id, title: title, start: start, end: end })
                        }).then(response => response.json()).then(data => {
                            if (data.success) {
                                info.event.setProp('title', title);
                                info.event.setStart(start);
                                info.event.setEnd(end);
                                $('#editEventModal').modal('hide'); // Cerrar el modal
                                document.getElementById('editEventForm').reset(); // Reiniciar el formulario
                            }
                        });
                    };
                }
            });
            calendar.render();

            // Manejo del formulario para agregar eventos
            
        });
    </script>
</body>
</html>
